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

class ucp_test extends \phpbb_test_case
{
	/** @var \martin\externallinkinnewwindow\event\ucp */
	protected $listener;

	protected $config, $user, $request, $template;

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

		$this->config = new \phpbb\config\config(array(
			'martin_extlinknewwin_enable_ucp'		=> 1,
		));

		$this->user = $this->getMockBuilder('\phpbb\user')
			->disableOriginalConstructor()
			->getMock();

		$this->request = $this->getMockBuilder('\phpbb\request\request')
			->disableOriginalConstructor()
			->getMock();

		$this->template = $this->getMockBuilder('\phpbb\template\template')
			->disableOriginalConstructor()
			->getMock();
	}

	/**
	* Get an instance of the event listener to test
	*/
	protected function set_listener()
	{
		$this->listener = new \martin\externallinkinnewwindow\event\ucp(
			$this->config,
			$this->user,
			$this->request,
			$this->template
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
			'core.ucp_prefs_personal_data',
			'core.ucp_prefs_personal_update_data',
		), array_keys(\martin\externallinkinnewwindow\event\ucp::getSubscribedEvents()));
	}

	/**
	* Test the core.ucp_prefs_personal_data event when UCP option is disabled
	*/
	public function test_ucp_get_pref_disabled()
	{
		$this->set_listener();

		$dispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();
		$dispatcher->addListener('core.ucp_prefs_personal_data', array($this->listener, 'ucp_get_pref'));

		$this->config['martin_extlinknewwin_enable_ucp'] = 0;

		$this->template->expects($this->once())
			->method('assign_vars')
			->with($this->equalTo(array('S_UCP_EXTLINKNEWWIN' => false)));

		$dispatcher->dispatch('core.ucp_prefs_personal_data');
	}

	/**
	* Data set for test_ucp_get_pref_enabled
	*
	* @return array Array of test data
	*/
	public function ucp_get_pref_data()
	{
		return array(
			'request variable is set' => array(
				0,
				1,
				0,
			),
			'request variable is NOT set' => array(
				null,
				1,
				1,
			),
		);
	}

	/**
	* Test the core.ucp_prefs_personal_data event when UCP option is enabled
	*
	* @dataProvider ucp_get_pref_data
	*/
	public function test_ucp_get_pref_enabled($request, $database, $expected)
	{
		$this->set_listener();

		$dispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();
		$dispatcher->addListener('core.ucp_prefs_personal_data', array($this->listener, 'ucp_get_pref'));

		$event_data = array('data', 'submit');
		$data = array();
		$submit = false;
		$event = new \phpbb\event\data(compact($event_data));

		$this->user->data['user_extlinknewwin'] = $database;

		$this->request->expects($this->once())
			->method('variable')
			->with($this->equalTo('martin_extlinknewwin_ucp'), $this->equalTo($database))
			->willReturn($request !== null ? $request : $database);

		$this->user->expects($this->once())
			->method('add_lang_ext')
			->with($this->equalTo('martin/externallinkinnewwindow'), $this->equalTo('ucp'));

		$this->template->expects($this->once())
			->method('assign_vars')
			->with($this->equalTo(array('S_UCP_EXTLINKNEWWIN' => true)));

		$this->template->expects($this->exactly(3))
			->method('assign_block_vars');

		$dispatcher->dispatch('core.ucp_prefs_personal_data', $event);

		$event_data_after = $event->get_data_filtered($event_data);
		$this->assertArrayHasKey('data', $event_data_after);
		$this->assertArrayHasKey('martin_extlinknewwin_ucp', $event_data_after['data']);
		$this->assertEquals($expected, $event_data_after['data']['martin_extlinknewwin_ucp']);
	}

	/**
	* Test the core.ucp_prefs_personal_update_data event
	*/
	public function test_ucp_set_pref()
	{
		$this->set_listener();

		$dispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();
		$dispatcher->addListener('core.ucp_prefs_personal_update_data', array($this->listener, 'ucp_set_pref'));

		$event_data = array('data', 'sql_ary');
		$data = array('martin_extlinknewwin_ucp' => 123);
		$sql_ary = array('whatever');
		$event = new \phpbb\event\data(compact($event_data));

		$dispatcher->dispatch('core.ucp_prefs_personal_update_data', $event);

		$event_data_after = $event->get_data_filtered($event_data);
		$this->assertArrayHasKey('sql_ary', $event_data_after);
		$this->assertArrayHasKey('user_extlinknewwin', $event_data_after['sql_ary']);
		$this->assertEquals(123, $event_data_after['sql_ary']['user_extlinknewwin']);
	}
}
