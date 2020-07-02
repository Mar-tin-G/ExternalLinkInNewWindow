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
	'ACP_EXTLINKNEWWIN_TITLE'			=> 'Liens externes dans une nouvelle fenêtre',
	'ACP_EXTLINKNEWWIN_SETTINGS'		=> 'Paramètres',
	'ACP_EXTLINKNEWWIN_SETTINGS_SAVED'	=> 'Les paramètres ont été sauvegards avec succès !',
	'ACP_EXTLINKNEWWIN_UCP'				=> 'Afficher les préférences dans l\'UCP',
	'ACP_EXTLINKNEWWIN_UCP_EXPLAIN'		=> 'Activer les préférences ’Ouvrir les liens externes dans une nouvelle fenêtre’ dans le Panneau de Contrôle de l\'Utilisateur (sous Préférences du Forum, Edition des paramètres globaux), pour permettre aux utilisateurs de contrôler le comportement des liens externes.',
	'ACP_EXTLINKNEWWIN_USER'			=> 'Ouvrir les liens externes dans une nouvelle fenêtre pour les utilisateurs',
	'ACP_EXTLINKNEWWIN_USER_EXPLAIN'	=> 'Si ’Afficher les préférences dans l\'UCP’ est réglé à <strong>Non</strong>, ce commutateur définit que les liens externes s\'ouvrent dans une nouvelle fenêtre pour les utilisateurs enregistrés.<br />’Afficher les préférences dans l\'UCP’ est réglé à <strong>Oui</strong>, ce commutateur définit que le comportement par défaut est appliqué si l\'utilisateur n\'a pas modifié les préférences dans l\'UCP.',
	'ACP_EXTLINKNEWWIN_GUESTS'			=> 'Ouvrir les liens externes dans une nouvelle fenêtre pour les invités',
	'ACP_EXTLINKNEWWIN_GUESTS_EXPLAIN'	=> 'Définit si les liens externes s\'ouvrent dans une nouvelle fenêtre pour les invités.',
	'ACP_EXTLINKNEWWIN_BOTS'			=> 'Ouvrir les liens externes dans une nouvelle fenêtre pour les robots',
	'ACP_EXTLINKNEWWIN_BOTS_EXPLAIN'	=> 'Définit si les liens externes s\'ouvrent dans une nouvelle fenêtre pour les robots.',
	'ACP_EXTLINKNEWWIN_ADDREF'			=> 'Add <i>rel="nofollow"</i> attribute',
	'ACP_EXTLINKNEWWIN_ADDREF_EXPLAIN'	=> 'Si activé, l\'attribut ’rel="nofollow"’ est ajouté à tous les liens externes qui ont été modifiés par cette extension afin de s\'ouvrir dans une nouvelle fenêtre.',
));
