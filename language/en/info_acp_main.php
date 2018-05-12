<?php
/**
*
* @package phpBB Extension - martin externallinkinnewwindow
* @copyright (c) 2018 Martin ( https://github.com/Mar-tin-G )
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'ACP_EXTLINKNEWWIN_TITLE'			=> 'External Link In New Window',
	'ACP_EXTLINKNEWWIN_SETTINGS'		=> 'Settings',
	'ACP_EXTLINKNEWWIN_SETTINGS_SAVED'	=> 'Settings have been saved successfully!',
	'ACP_EXTLINKNEWWIN_UCP'				=> 'Show preference in UCP',
	'ACP_EXTLINKNEWWIN_UCP_EXPLAIN'		=> 'Enable the preference ’Open external links in new window’ in User Control Panel (under Board preferences, Edit global settings), allowing users to control the behavior on external links.',
	'ACP_EXTLINKNEWWIN_USER'			=> 'Open external links in new window for users',
	'ACP_EXTLINKNEWWIN_USER_EXPLAIN'	=> 'If ’Show preference in UCP’ is set to <strong>No</strong>, this switch defines if external links open in new windows for registered users.<br />If ’Show preference in UCP’ is set to <strong>Yes</strong>, this switch defines the default behavior that is used if the user does not change the preference in the UCP.',
	'ACP_EXTLINKNEWWIN_GUESTS'			=> 'Open external links in new window for guests',
	'ACP_EXTLINKNEWWIN_GUESTS_EXPLAIN'	=> 'Defines if external links open in new windows for guests.',
	'ACP_EXTLINKNEWWIN_BOTS'			=> 'Open external links in new window for bots',
	'ACP_EXTLINKNEWWIN_BOTS_EXPLAIN'	=> 'Defines if external links open in new windows for bots.',
	'ACP_EXTLINKNEWWIN_ADDREF'			=> 'Add <i>rel="nofollow"</i> attribute',
	'ACP_EXTLINKNEWWIN_ADDREF_EXPLAIN'	=> 'If enabled, the attribute ’rel="nofollow"’ is added to all external links that were modified by this extension to open in a new window.',
));
