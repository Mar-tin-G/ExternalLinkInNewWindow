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
	'UCP_EXTLINKNEWWIN_SELECT'										=> 'Open external links in new window',
	'UCP_EXTLINKNEWWIN_SELECT_EXPLAIN'								=> '<strong>Use board default</strong>: Use the default behavior that the administrator defined.<br /><strong>Always open new window</strong>: External links will always be opened in a new window.<br /><strong>Never open new window</strong>: External links will always be opened in the same window.',
	'UCP_EXTLINKNEWWIN_OPTION_' . EXTLINKNEWWIN_USE_BOARD_DEFAULT	=> 'Use board default' ,
	'UCP_EXTLINKNEWWIN_OPTION_' . EXTLINKNEWWIN_ALWAYS_NEW_WIN		=> 'Always open new window',
	'UCP_EXTLINKNEWWIN_OPTION_' . EXTLINKNEWWIN_NEVER_NEW_WIN		=> 'Never open new window',
));
