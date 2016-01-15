<?php
/**
*
* @package phpBB Extension - martin externallinkinnewwindow
* @copyright (c) 2015 Martin ( https://github.com/Mar-tin-G )
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
		global $user, $request;

		parent::setUp();

		// needed for generate_board_url() call.
		$request = new \phpbb_mock_request();
		$user = new \phpbb_mock_user();

		$this->config = new \phpbb\config\config(array(
			'martin_extlinknewwin_add_ref'			=> 1,
		));

		$this->user = $this->getMockBuilder('\phpbb\user')
			->disableOriginalConstructor()
			->getMock();
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
			'core.user_setup',
			'core.modify_text_for_display_after',
		), array_keys(\martin\externallinkinnewwindow\event\listener::getSubscribedEvents()));
	}

	/**
	* Test the core.user_setup event
	*/
	public function test_define_constants()
	{
		$this->set_listener();

		$dispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();
		$dispatcher->addListener('core.user_setup', array($this->listener, 'define_constants'));

		$dispatcher->dispatch('core.user_setup');

		$this->assertEquals(0, EXTLINKNEWWIN_USE_BOARD_DEFAULT);
		$this->assertEquals(1, EXTLINKNEWWIN_ALWAYS_NEW_WIN);
		$this->assertEquals(2, EXTLINKNEWWIN_NEVER_NEW_WIN);
	}

	/**
	* Data set for test_modify_external_links_logic
	*
	* @return array Array of test data
	*/
	public function modify_external_links_logic_data()
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
	}	/**
	* Test the logic in modify_external_links
	*
	* @dataProvider modify_external_links_logic_data
	*/
	public function test_modify_external_links_logic($vars, $modified)
	{
		$this->set_listener();

		$text 			= '<a what="ever" class="foo postlink bar" foo="bar" href="http://example.com/" bar="foo">text</a>';
		$modified_text	= '<a what="ever" class="foo postlink bar" foo="bar" href="http://example.com/" bar="foo" target="_blank" rel="nofollow">text</a>';

		$this->user->data['is_registered']		= $vars['registered'];
		$this->user->data['is_bot']				= $vars['bot'];
		$this->user->data['user_extlinknewwin']	= $vars['ucp_setting'];
		$this->config['martin_extlinknewwin_enable_guests']	= $vars['conf_guests'];
		$this->config['martin_extlinknewwin_enable_bots']	= $vars['conf_bots'];
		$this->config['martin_extlinknewwin_enable_ucp']	= $vars['conf_ucp'];
		$this->config['martin_extlinknewwin_enable_user']	= $vars['conf_user'];

		$dispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();
		$dispatcher->addListener('core.modify_text_for_display_after', array($this->listener, 'modify_external_links'));

		$event_data = array('text');
		$event = new \phpbb\event\data(compact($event_data));
		$dispatcher->dispatch('core.modify_text_for_display_after', $event);

		$event_data_after = $event->get_data_filtered($event_data);
		$this->assertArrayHasKey('text', $event_data_after);
		$this->assertEquals(($modified ? $modified_text : $text), $event_data_after['text']);
	}

	/**
	* Data set for test_modify_external_links
	*
	* @return array Array of test data
	*/
	public function modify_external_links_data()
	{
		global $user, $request;

		parent::setUp();

		// needed for generate_board_url() call.
		$request = new \phpbb_mock_request();
		$user = new \phpbb_mock_user();

		$board_url = generate_board_url();

		return array(
			'local link' => array(
				'<a what="ever" class="foo postlink-local bar" foo="bar" href="'. $board_url .'" bar="foo">text</a>',
				'<a what="ever" class="foo postlink-local bar" foo="bar" href="'. $board_url .'" bar="foo">text</a>',
			),
			'local link too' => array(
				'<a what="ever" class="foo postlink bar" foo="bar" href="'. $board_url .'" bar="foo">text</a>',
				'<a what="ever" class="foo postlink bar" foo="bar" href="'. $board_url .'" bar="foo">text</a>',
			),
			'no postlink class' => array(
				'<a what="ever" class="foo bar" foo="bar" href="http://example.com/" bar="foo">text</a>',
				'<a what="ever" class="foo bar" foo="bar" href="http://example.com/" bar="foo">text</a>',
			),
			'no href' => array(
				'<a what="ever" class="foo postlink bar" foo="bar" bar="foo">text</a>',
				'<a what="ever" class="foo postlink bar" foo="bar" bar="foo">text</a>',
			),
			'no link text' => array(
				'<a what="ever" class="foo postlink bar" foo="bar" href="http://example.com/" bar="foo"></a>',
				'<a what="ever" class="foo postlink bar" foo="bar" href="http://example.com/" bar="foo"></a>',
			),
			'external link, contains target attribute ' => array(
				'<a what="ever" class="foo postlink bar" foo="bar" href="http://example.com/" target="foobar" bar="foo">text</a>',
				'<a what="ever" class="foo postlink bar" foo="bar" href="http://example.com/" target="_blank" bar="foo" rel="nofollow">text</a>',
			),
			'external link, without target attribute ' => array(
				'<a what="ever" class="foo postlink bar" foo="bar" href="http://example.com/" bar="foo">text</a>',
				'<a what="ever" class="foo postlink bar" foo="bar" href="http://example.com/" bar="foo" target="_blank" rel="nofollow">text</a>',
			),
			'external link, contains rel attribute ' => array(
				'<a what="ever" class="foo postlink bar" foo="bar" href="http://example.com/" rel="foobar" bar="foo">text</a>',
				'<a what="ever" class="foo postlink bar" foo="bar" href="http://example.com/" rel="nofollow" bar="foo" target="_blank">text</a>',
			),
			'external link, without rel attribute ' => array(
				'<a what="ever" class="foo postlink bar" foo="bar" href="http://example.com/" bar="foo">text</a>',
				'<a what="ever" class="foo postlink bar" foo="bar" href="http://example.com/" bar="foo" target="_blank" rel="nofollow">text</a>',
			),
		);
	}

	/**
	* Test the core.modify_text_for_display_after event
	*
	* @dataProvider modify_external_links_data
	*/
	public function test_modify_external_links($text, $expected)
	{
		$this->set_listener();

		$this->user->data['is_registered'] = false;
		$this->config['martin_extlinknewwin_enable_guests'] = true;

		$dispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();
		$dispatcher->addListener('core.modify_text_for_display_after', array($this->listener, 'modify_external_links'));

		$event_data = array('text');
		$event = new \phpbb\event\data(compact($event_data));
		$dispatcher->dispatch('core.modify_text_for_display_after', $event);

		$event_data_after = $event->get_data_filtered($event_data);
		$this->assertArrayHasKey('text', $event_data_after);
		$this->assertEquals($expected, $event_data_after['text']);
	}
}
