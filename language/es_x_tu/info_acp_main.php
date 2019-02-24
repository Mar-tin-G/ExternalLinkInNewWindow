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
	'ACP_EXTLINKNEWWIN_TITLE'			=> 'Enlaces externos en nueva ventana',
	'ACP_EXTLINKNEWWIN_SETTINGS'		=> 'Ajustes',
	'ACP_EXTLINKNEWWIN_SETTINGS_SAVED'	=> '¡Los ajustes han sido guardados correctamente!',
	'ACP_EXTLINKNEWWIN_UCP'				=> 'Mostrar preferencias en el PCU',
	'ACP_EXTLINKNEWWIN_UCP_EXPLAIN'		=> 'Habilitar la preferencia ’Abrir enlaces externos en nueva ventana’ en el Panel de Control del Usuario (debajo de Preferencias del Foro, Editar ajustes globales), permitiendo así a los usuarios controlar el comportamiento en enlaces externos.',
	'ACP_EXTLINKNEWWIN_USER'			=> 'Abrir enlaces externos en nueva ventana para los usuarios',
	'ACP_EXTLINKNEWWIN_USER_EXPLAIN'	=> 'Si ’Mostrar preferencias en el PCU’ se establece en <strong>No</strong>, este interruptor define si los enlaces externos se abren en ventanas nuevas para los usuarios registrados.<br />Si ’Mostrar preferencias en el PCU’ se establece en <strong>Si</strong>, este modificador define el comportamiento predeterminado que se utiliza si el usuario no cambia la preferencia en el PCU.',
	'ACP_EXTLINKNEWWIN_GUESTS'			=> 'Abrir enlaces externos en nueva ventana para los invitados',
	'ACP_EXTLINKNEWWIN_GUESTS_EXPLAIN'	=> 'Define si los enlaces externos se abren en ventanas nuevas para los invitados.',
	'ACP_EXTLINKNEWWIN_BOTS'			=> 'Abrir enlaces externos en nueva ventana para los robots',
	'ACP_EXTLINKNEWWIN_BOTS_EXPLAIN'	=> 'Define si los enlaces externos se abren en ventanas nuevas para los robots.',
	'ACP_EXTLINKNEWWIN_ADDREF'			=> 'Añadir atributo <i>rel="nofollow"</i>',
	'ACP_EXTLINKNEWWIN_ADDREF_EXPLAIN'	=> 'Si se habilita, el atributo ’rel="nofollow"’ se añade a todos los enlaces externos que fueron modificados por esta extensión para abrir en una nueva ventana.',
));
