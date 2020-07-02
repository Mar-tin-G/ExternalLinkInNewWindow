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
	'UCP_EXTLINKNEWWIN_SELECT'			=> 'Ouvrir le lien externe dans une nouvelle fenêtre',
	'UCP_EXTLINKNEWWIN_SELECT_EXPLAIN'	=> '<strong>Utiliser le paramètre par défaut du forum</strong> : Utilise le comportement par défaut défini par l\'administrateur.<br /><strong>Toujours ouvrir une nouvelle fenêtre</strong> : Les liens externes seront toujours ouverts dans une nouvelle fenêtre.<br /><strong>Ne jamais ouvrir une nouvelle fenêtre</strong> : Les liens externes seront toujours ouverts dans la même fenêtre.',
	'UCP_EXTLINKNEWWIN_OPTION_0' 		=> 'Utiliser le paramètre par défaut du forum' ,
	'UCP_EXTLINKNEWWIN_OPTION_1' 		=> 'Toujours ouvrir une nouvelle fenêtre',
	'UCP_EXTLINKNEWWIN_OPTION_2' 		=> 'Ne jamais ouvrir de nouvelle fenêtre',
));
