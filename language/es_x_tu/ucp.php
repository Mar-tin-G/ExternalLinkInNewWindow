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
	'UCP_EXTLINKNEWWIN_SELECT'			=> 'Abrir enlaces externos en una nueva ventana',
	'UCP_EXTLINKNEWWIN_SELECT_EXPLAIN'	=> '<strong>Usar por defecto del foro</strong>: Usa el comportamiento predeterminado que definió el Administrador.<br /><strong>Siempre abrir nueva ventana</strong>: Los enlaces externos siempre se abrirán en una nueva ventana.<br /><strong>Nunca abrir nueva ventana</strong>: Los enlaces externos siempre se abrirán en la misma ventana.',
	'UCP_EXTLINKNEWWIN_OPTION_0' 		=> 'Usar por defecto del foro' ,
	'UCP_EXTLINKNEWWIN_OPTION_1' 		=> 'Siempre abrir nueva ventana',
	'UCP_EXTLINKNEWWIN_OPTION_2' 		=> 'Nunca abrir nueva ventana',
));
