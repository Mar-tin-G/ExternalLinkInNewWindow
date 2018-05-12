<?php
/**
*
* @package phpBB Extension - martin externallinkinnewwindow
* @copyright (c) 2018 Martin ( https://github.com/Mar-tin-G )
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace martin\externallinkinnewwindow\event;

/**
* @ignore
*/
use \phpbb\config\config;
use \phpbb\user;
use \phpbb\request\request;
use \phpbb\template\template;
use \phpbb\language\language;
use martin\externallinkinnewwindow\constants;
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

	/* @var config */
	protected $config;

	/* @var user */
	protected $user;

	/* @var request */
	protected $request;

	/* @var template */
	protected $template;

	/* @var language */
	protected $lang;

	/**
	* Constructor
	*
	* @param config		$config
	* @param user		$user
	* @param request	$request
	* @param template	$template
	* @param language	$lang
	*/
	public function __construct(config $config, user $user, request $request, template $template, language $lang)
	{
		$this->config = $config;
		$this->user = $user;
		$this->request = $request;
		$this->template = $template;
		$this->lang = $lang;
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
				$this->lang->add_lang('ucp', 'martin/externallinkinnewwindow');

				$this->template->assign_vars(array(
					'S_UCP_EXTLINKNEWWIN' => true,
				));
				foreach (array(constants::USE_BOARD_DEFAULT, constants::ALWAYS_NEW_WIN, constants::NEVER_NEW_WIN) as $value)
				{
					$this->template->assign_block_vars('martin_extlinknewwin_options', array(
						'L_TITLE'	=> $this->lang->lang('UCP_EXTLINKNEWWIN_OPTION_' . $value),
						'OPTION'	=> $value,
						'SELECTED'	=> $event['data']['martin_extlinknewwin_ucp'] == $value,
					));
				}
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
