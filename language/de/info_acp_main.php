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
	'ACP_EXTLINKNEWWIN_SETTINGS'		=> 'Einstellungen',
	'ACP_EXTLINKNEWWIN_SETTINGS_SAVED'	=> 'Die Einstellungen wurden erfolgreich gespeichert!',
	'ACP_EXTLINKNEWWIN_UCP'				=> 'Einstellung im Persönlichen Bereich anzeigen',
	'ACP_EXTLINKNEWWIN_UCP_EXPLAIN'		=> 'Aktiviert die Einstellung ’Öffne externe Links in neuem Fenster’ im Persönlichen Bereich (unter Einstellungen, Persönlichen Einstellungen), mit der Benutzer das Verhalten bei externen Links festlegen können.',
	'ACP_EXTLINKNEWWIN_USER'			=> 'Öffne externe Links in neuem Fenster für Benutzer',
	'ACP_EXTLINKNEWWIN_USER_EXPLAIN'	=> 'Wenn ’Einstellung im Persönlichen Bereich anzeigen’ auf <strong>Nein</strong> gesetzt ist, definiert dieser Schalter, ob externe Links für registrierte Benutzer in neuen Fenstern geöffnet werden.<br />Wenn ’Einstellung im Persönlichen Bereich anzeigen’ auf <strong>Ja</strong> gesetzt ist, gibt dieser Schalter das Standardverhalten an, das genutzt wird, wenn der Benutzer die Einstellung in seinem Persönlichen Bereich nicht geändert hat.',
	'ACP_EXTLINKNEWWIN_GUESTS'			=> 'Öffne externe Links in neuem Fenster für Gäste',
	'ACP_EXTLINKNEWWIN_GUESTS_EXPLAIN'	=> 'Gibt an, ob externe Links für Gäste in neuen Fenstern geöffnet werden.',
	'ACP_EXTLINKNEWWIN_BOTS'			=> 'Öffne externe Links in neuem Fenster für Bots',
	'ACP_EXTLINKNEWWIN_BOTS_EXPLAIN'	=> 'Gibt an, ob externe Links für Bots in neuen Fenstern geöffnet werden.',
	'ACP_EXTLINKNEWWIN_ADDREF'			=> 'Füge Attribut <i>rel="nofollow"</i> hinzu',
	'ACP_EXTLINKNEWWIN_ADDREF_EXPLAIN'	=> 'Wenn aktiviert, wird das Attribut ’rel="nofollow"’ zu allen externen Links hinzugefügt, die von dieser Erweiterung modifiziert wurden.',
));
