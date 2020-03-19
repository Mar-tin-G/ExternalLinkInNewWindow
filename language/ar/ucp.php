<?php
/**
*
* @package phpBB Extension - martin externallinkinnewwindow
* @copyright (c) 2018 Martin ( https://github.com/Mar-tin-G )
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
* Translated By : Bassel Taha Alhitary <http://alhitary.net>
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
	'UCP_EXTLINKNEWWIN_SELECT'			=> 'فتح الروابط الخارجية في نافذة جديدة',
	'UCP_EXTLINKNEWWIN_SELECT_EXPLAIN'	=> '<strong>استخدم الإعدادات الإفتراضية</strong>: استخدام الإعدادات الإفتراضية التي حددها المدير للمنتدى.<br /><strong>نعم</strong> : سيتم دائماً فتح الروابط الخارجية في نافذة جديدة.<br /><strong>لا</strong> : سيتم دائماً فتح الروابط الخارجية في نفس النافذة / الصفحة.',
	'UCP_EXTLINKNEWWIN_OPTION_0' 		=> 'استخدم الإعدادات الإفتراضية' ,
	'UCP_EXTLINKNEWWIN_OPTION_1' 		=> 'نعم',
	'UCP_EXTLINKNEWWIN_OPTION_2' 		=> 'لا',
));
