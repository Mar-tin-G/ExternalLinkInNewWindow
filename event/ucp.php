<?php
/**
*
* @package phpBB Extension - martin externallinkinnewwindow
* @copyright (c) 2014 Martin ( https://github.com/Martin-G- )
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace martin\externallinkinnewwindow\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class ucp implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.ucp_prefs_personal_data'			=> 'ucp_get_pref',
			'core.ucp_prefs_personal_update_data'	=> 'ucp_set_pref', 
		);
	}

	/* @var \phpbb\config\config */
	protected $config;

	/* @var \phpbb\user */
	protected $user;

	/* @var \phpbb\request\request */
	protected $request;

	/* @var \phpbb\template\template */
	protected $template;

	/**
	* Constructor
	*
	* @param \phpbb\config\config		$config
	* @param \phpbb\user				$user
	* @param \phpbb\request\request		$request
	* @param \phpbb\template\template	$template
	*/
	public function __construct(\phpbb\config\config $config, \phpbb\user $user, \phpbb\request\request $request, \phpbb\template\template $template)
	{
		$this->config = $config;
		$this->user = $user;
		$this->request = $request;
		$this->template = $template;
	}

	/**
	* Adds the "Open external links in new window" preference to the UCP.
	*
	* @param	object		$event	The event object
	* @return	null
	* @access	public
	*/ 
	public function ucp_get_pref($event)
	{
		// only show UCP option when this is enabled in ACP
		if (!$this->config['martin_extlinknewwin_enable_ucp'])
		{
			$this->template->assign_vars(array(
				'S_UCP_EXTLINKNEWWIN' => false,
			));
		}
		else
		{
			// Get selected UCP option from request or database and merge it with the event data
			$event['data'] = array_merge($event['data'], array(
				'martin_extlinknewwin_ucp' => $this->request->variable('martin_extlinknewwin_ucp', (int) $this->user->data['user_extlinknewwin']),
			));

			// Output possible UCP options to the template
			if (!$event['submit'])
			{
				$this->user->add_lang_ext('martin/externallinkinnewwindow', 'ucp');

				$this->template->assign_vars(array(
					'S_UCP_EXTLINKNEWWIN' => true,
				));
				$this->template->assign_block_vars('martin_extlinknewwin_options', array(
					'L_TITLE'	=> $this->user->lang('UCP_EXTLINKNEWWIN_OPTION_' . EXTLINKNEWWIN_USE_BOARD_DEFAULT),
					'OPTION'	=> EXTLINKNEWWIN_USE_BOARD_DEFAULT,
					'SELECTED'	=> $event['data']['martin_extlinknewwin_ucp'] == EXTLINKNEWWIN_USE_BOARD_DEFAULT,
				));
				$this->template->assign_block_vars('martin_extlinknewwin_options', array(
					'L_TITLE'	=> $this->user->lang('UCP_EXTLINKNEWWIN_OPTION_' . EXTLINKNEWWIN_ALWAYS_NEW_WIN),
					'OPTION'	=> EXTLINKNEWWIN_ALWAYS_NEW_WIN,
					'SELECTED'	=> $event['data']['martin_extlinknewwin_ucp'] == EXTLINKNEWWIN_ALWAYS_NEW_WIN,
				));
				$this->template->assign_block_vars('martin_extlinknewwin_options', array(
					'L_TITLE'	=> $this->user->lang('UCP_EXTLINKNEWWIN_OPTION_' . EXTLINKNEWWIN_NEVER_NEW_WIN),
					'OPTION'	=> EXTLINKNEWWIN_NEVER_NEW_WIN,
					'SELECTED'	=> $event['data']['martin_extlinknewwin_ucp'] == EXTLINKNEWWIN_NEVER_NEW_WIN,
				));
			}
		}
	}

	/**
	* Saves the "Open external links in new window" preference for this user
	* to the database.
	*
	* @param	object		$event	The event object
	* @return	null
	* @access	public
	*/ 
	public function ucp_set_pref($event)
	{
		// only save UCP option when this is enabled in ACP
		if ($this->config['martin_extlinknewwin_enable_ucp'])
		{
			// save UCP option from submitted form to database
			$event['sql_ary'] = array_merge($event['sql_ary'], array(
				'user_extlinknewwin' => $event['data']['martin_extlinknewwin_ucp'],
			));
		}
	}
}
