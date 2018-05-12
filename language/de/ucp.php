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
	'UCP_EXTLINKNEWWIN_SELECT'			=> 'Öffne externe Links in neuem Fenster',
	'UCP_EXTLINKNEWWIN_SELECT_EXPLAIN'	=> '<strong>Board-Standard nutzen</strong>: Standard-Verhalten nutzen, das der Administrator vorgibt.<br /><strong>Immer in neuem Fenster öffnen</strong>: Externe Links werden immer in einem neuen Fenster geöffnet.<br /><strong>Nie in neuem Fenster öffnen</strong>: Externe Links werden immer im selben Fenster geöffnet.',
	'UCP_EXTLINKNEWWIN_OPTION_0'		=> 'Board-Standard nutzen' ,
	'UCP_EXTLINKNEWWIN_OPTION_1'		=> 'Immer in neuem Fenster öffnen',
	'UCP_EXTLINKNEWWIN_OPTION_2'		=> 'Nie in neuem Fenster öffnen',
));
