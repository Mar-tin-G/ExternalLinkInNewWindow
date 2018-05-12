<?php
/**
*
* @package phpBB Extension - martin externallinkinnewwindow
* @copyright (c) 2018 Martin ( https://github.com/Mar-tin-G )
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace martin\externallinkinnewwindow\tests\event;

require_once dirname(__FILE__) . '/../../../../../includes/functions.php';

class listener_test extends \phpbb_test_case
{
	/** @var \martin\externallinkinnewwindow\event\listener */
	protected $listener;

	protected $config, $user;

	/**
	* Define the extensions to be tested
	*
	* @return array vendor/name of extension(s) to test
	*/
	static protected function setup_extensions()
	{
		return array('martin/externallinkinnewwindow');
	}

	/**
	* Setup test environment
	*/
	public function setUp()
	{
		parent::setUp();
		$this->set_global_mocks();

		$this->config = new \phpbb\config\config(array(
			'martin_extlinknewwin_add_ref'	=> 1,
		));

		$this->user = $this->getMockBuilder('\phpbb\user')
			->disableOriginalConstructor()
			->getMock();
	}

	/**
	* Setup mocks needed for generate_board_url() call
	*/
	protected function set_global_mocks()
	{
		global $user, $request, $config;

		$request = new \phpbb_mock_request();
		$user = new \phpbb_mock_user();

		$config = new \phpbb\config\config(array(
			'force_server_vars' => true,
			'server_protocol' => 'http://',
			'server_name' => 'my-forum.com',
			'server_port' => 80,
			'script_path' => '/',
			'cookie_secure' => false,
		));
	}

	/**
	* Get an instance of the event listener to test
	*/
	protected function set_listener()
	{
		$this->listener = new \martin\externallinkinnewwindow\event\listener(
			$this->config,
			$this->user
		);
	}

	/**
	* Test the event listener is constructed correctly
	*/
	public function test_construct()
	{
		$this->set_listener();
		$this->assertInstanceOf('\Symfony\Component\EventDispatcher\EventSubscriberInterface', $this->listener);
	}

	/**
	* Test the event listener is subscribing events
	*/
	public function test_getSubscribedEvents()
	{
		$this->assertEquals(array(
			'core.text_formatter_s9e_configure_after',
			'core.text_formatter_s9e_renderer_setup',
		), array_keys(\martin\externallinkinnewwindow\event\listener::getSubscribedEvents()));
	}

	/**
	* Data set for test_set_textformatter_parameters
	*
	* @return array Array of test data
	*/
	public function set_textformatter_parameters_data()
	{
		return array(
			'guest with config enabled' => array(
				array(
					'registered'	=> false,
					'bot'			=> false,
					'conf_guests'	=> true,
					'conf_bots'		=> false,
					'conf_user'		=> false,
					'conf_ucp'		=> false,
					'ucp_setting'	=> 0,
				),
				true,
			),
			'guest with config disabled' => array(
				array(
					'registered'	=> false,
					'bot'			=> false,
					'conf_guests'	=> false,
					'conf_bots'		=> false,
					'conf_user'		=> false,
					'conf_ucp'		=> false,
					'ucp_setting'	=> 0,
				),
				false,
			),
			'bot with config enabled' => array(
				array(
					'registered'	=> false,
					'bot'			=> true,
					'conf_guests'	=> false,
					'conf_bots'		=> true,
					'conf_user'		=> false,
					'conf_ucp'		=> false,
					'ucp_setting'	=> 0,
				),
				true,
			),
			'bot with config disabled' => array(
				array(
					'registered'	=> false,
					'bot'			=> true,
					'conf_guests'	=> false,
					'conf_bots'		=> false,
					'conf_user'		=> false,
					'conf_ucp'		=> false,
					'ucp_setting'	=> 0,
				),
				false,
			),
			'user without ucp config enabled and user config enabled' => array(
				array(
					'registered'	=> true,
					'bot'			=> false,
					'conf_guests'	=> false,
					'conf_bots'		=> false,
					'conf_user'		=> true,
					'conf_ucp'		=> false,
					'ucp_setting'	=> 0,
				),
				true,
			),
			'user without ucp config enabled and user config disabled' => array(
				array(
					'registered'	=> true,
					'bot'			=> false,
					'conf_guests'	=> false,
					'conf_bots'		=> false,
					'conf_user'		=> false,
					'conf_ucp'		=> false,
					'ucp_setting'	=> 0,
				),
				false,
			),
			'user with ucp config enabled and user chose enabled' => array(
				array(
					'registered'	=> true,
					'bot'			=> false,
					'conf_guests'	=> false,
					'conf_bots'		=> false,
					'conf_user'		=> false,
					'conf_ucp'		=> true,
					'ucp_setting'	=> 1,
				),
				true,
			),
			'user with ucp config enabled and user chose disabled' => array(
				array(
					'registered'	=> true,
					'bot'			=> false,
					'conf_guests'	=> false,
					'conf_bots'		=> false,
					'conf_user'		=> false,
					'conf_ucp'		=> true,
					'ucp_setting'	=> 2,
				),
				false,
			),
			'user with ucp config enabled and user chose default which is enabled' => array(
				array(
					'registered'	=> true,
					'bot'			=> false,
					'conf_guests'	=> false,
					'conf_bots'		=> false,
					'conf_user'		=> true,
					'conf_ucp'		=> true,
					'ucp_setting'	=> 0,
				),
				true,
			),
			'user with ucp config enabled and user chose default which is disabled' => array(
				array(
					'registered'	=> true,
					'bot'			=> false,
					'conf_guests'	=> false,
					'conf_bots'		=> false,
					'conf_user'		=> false,
					'conf_ucp'		=> true,
					'ucp_setting'	=> 0,
				),
				false,
			),
		);
	}

	/**
	* Test the user status/UCP logic in set_textformatter_parameters
	*
	* @dataProvider set_textformatter_parameters_data
	*/
	public function test_set_textformatter_parameters($vars, $expected)
	{
		$this->set_listener();

		$renderer = $this->getMockBuilder('stdClass')
			->disableOriginalConstructor()
			->setMethods(array('get_renderer'))
			->getMock();

		$renderer
			->method('get_renderer')
			->willReturn(new MockRenderer());

		$this->user->data['is_registered']		= $vars['registered'];
		$this->user->data['is_bot']				= $vars['bot'];
		$this->user->data['user_extlinknewwin']	= $vars['ucp_setting'];
		$this->config['martin_extlinknewwin_enable_guests']	= $vars['conf_guests'];
		$this->config['martin_extlinknewwin_enable_bots']	= $vars['conf_bots'];
		$this->config['martin_extlinknewwin_enable_ucp']	= $vars['conf_ucp'];
		$this->config['martin_extlinknewwin_enable_user']	= $vars['conf_user'];

		$dispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();
		$dispatcher->addListener('core.text_formatter_s9e_renderer_setup', array($this->listener, 'set_textformatter_parameters'));

		$event_data = array('renderer');
		$event = new \phpbb\event\data(compact($event_data));
		$dispatcher->dispatch('core.text_formatter_s9e_renderer_setup', $event);

		$this->assertEquals($renderer->get_renderer()->getParameter('S_OPEN_IN_NEW_WINDOW'), $expected);
	}

	/**
	* Data set for test_set_textformatter_parameters_acp
	*
	* @return array Array of test data
	*/
	public function set_textformatter_parameters_data_acp()
	{
		return array(
			'acp config rel="nofollow" enabled' => array(
				true,
				true,
			),
			'acp config rel="nofollow" disabled' => array(
				false,
				false,
			),
		);
	}

	/**
	* Test the ACP logic in set_textformatter_parameters
	*
	* @dataProvider set_textformatter_parameters_data_acp
	*/
	public function test_set_textformatter_parameters_acp($acp_config, $expected)
	{
		$this->set_listener();

		$renderer = $this->getMockBuilder('stdClass')
			->disableOriginalConstructor()
			->setMethods(array('get_renderer'))
			->getMock();

		$renderer
			->method('get_renderer')
			->willReturn(new MockRenderer());

		$this->config['martin_extlinknewwin_add_ref'] = $acp_config;

		$dispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();
		$dispatcher->addListener('core.text_formatter_s9e_renderer_setup', array($this->listener, 'set_textformatter_parameters'));

		$event_data = array('renderer');
		$event = new \phpbb\event\data(compact($event_data));
		$dispatcher->dispatch('core.text_formatter_s9e_renderer_setup', $event);

		$this->assertEquals($renderer->get_renderer()->getParameter('S_NOFOLLOW'), $expected);
	}

	/**
	* Data set for test_text_rendering
	*
	* @return array Array of test data
	*/
	public function text_rendering_data()
	{
		$this->set_global_mocks();

		$board_url = generate_board_url();

		return array(
			'local link' => array(
				'<r><URL url="'. $board_url .'">text</URL></r>',
				array(
					'S_OPEN_IN_NEW_WINDOW'	=> true,
					'S_NOFOLLOW'			=> true,
				),
				'<a href="'. $board_url .'" class="postlink">text</a>',
			),
			'local link with link text' => array(
				'<r><URL url="'. $board_url .'/viewforum.php?f=1"><LINK_TEXT text="viewforum.php?f=1">'. $board_url .'/viewforum.php?f=1</LINK_TEXT></URL></r>',
				array(
					'S_OPEN_IN_NEW_WINDOW'	=> true,
					'S_NOFOLLOW'			=> true,
				),
				'<a href="'. $board_url .'/viewforum.php?f=1" class="postlink">viewforum.php?f=1</a>',
			),
			'local link with url bbcode' => array(
				'<r><URL url="'. $board_url .'/viewforum.php?f=1"><s>[url='. $board_url .'/viewforum.php?f=1]</s>text<e>[/url]</e></URL></r>',
				array(
					'S_OPEN_IN_NEW_WINDOW'	=> true,
					'S_NOFOLLOW'			=> true,
				),
				'<a href="'. $board_url .'/viewforum.php?f=1" class="postlink">text</a>',
			),
			'external link, but shall not be replaced' => array(
				'<r><URL url="http://example.com/"></URL></r>',
				array(
					'S_OPEN_IN_NEW_WINDOW'	=> false,
					'S_NOFOLLOW'			=> true,
				),
				'<a href="http://example.com/" class="postlink"></a>',
			),
			'external link, without target attribute' => array(
				'<r><URL url="http://example.com/"></URL></r>',
				array(
					'S_OPEN_IN_NEW_WINDOW'	=> true,
					'S_NOFOLLOW'			=> true,
				),
				'<a href="http://example.com/" class="postlink" target="_blank" rel="nofollow"></a>',
			),
			'external link, but nofollow setting is false' => array(
				'<r><URL url="http://example.com/"></URL></r>',
				array(
					'S_OPEN_IN_NEW_WINDOW'	=> true,
					'S_NOFOLLOW'			=> false,
				),
				'<a href="http://example.com/" class="postlink" target="_blank"></a>',
			),
			'external link, contains target attribute' => array(
				'<r><URL url="http://example.com/" target="foobar"></URL></r>',
				array(
					'S_OPEN_IN_NEW_WINDOW'	=> true,
					'S_NOFOLLOW'			=> true,
				),
				'<a href="http://example.com/" class="postlink" target="_blank" rel="nofollow"></a>',
			),
			'external link, contains rel attribute' => array(
				'<r><URL url="http://example.com/" rel="foobar"></URL></r>',
				array(
					'S_OPEN_IN_NEW_WINDOW'	=> true,
					'S_NOFOLLOW'			=> true,
				),
				'<a href="http://example.com/" class="postlink" target="_blank" rel="nofollow"></a>',
			),
		);
	}

	/**
	* Test the s9e text rendering
	*
	* We do not test the configure_textformatter() method, as that method only
	* modifies the template for the URL tag. Instead we use a test helper to
	* actually render some URL tags with a template which comes from the
	* fixtures, and check that external links are rendered correctly.
	*
	* @dataProvider text_rendering_data
	*/
	public function test_text_rendering($xml, $vars, $expected)
	{
		$fixture = __DIR__ . '/fixtures/styles/';
		$container = $this->get_test_case_helpers()->set_s9e_services(null, null, $fixture);

		$renderer = $container->get('text_formatter.renderer');

		$r = $renderer->get_renderer();
		$r->setParameter('S_OPEN_IN_NEW_WINDOW', $vars['S_OPEN_IN_NEW_WINDOW']);
		$r->setParameter('S_NOFOLLOW', $vars['S_NOFOLLOW']);

		$this->assertEquals($expected, $renderer->render($xml));
	}
}

class MockRenderer {
	protected $parameters;

	public function __construct()
	{
		$this->parameters = array();
	}

	public function setParameter($name, $value)
	{
		$this->parameters[$name] = $value;
	}

	public function getParameter($name)
	{
		return $this->parameters[$name];
	}
}
