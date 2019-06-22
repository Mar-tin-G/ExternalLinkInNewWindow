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
	'ACP_EXTLINKNEWWIN_TITLE'			=> 'الروابط الخارجية في نافذة جديدة',
	'ACP_EXTLINKNEWWIN_SETTINGS'		=> 'الإعدادات',
	'ACP_EXTLINKNEWWIN_SETTINGS_SAVED'	=> 'تم حفظ الإعدادات بنجاح !',
	'ACP_EXTLINKNEWWIN_UCP'				=> 'تفعيل في لوحة التحكم الشخصية',
	'ACP_EXTLINKNEWWIN_UCP_EXPLAIN'		=> 'إظهار هذه الخاصية في لوحة التحكم الشخصية (أسفل إعدادات المنتدى, تعديل الإعدادات العامة), والسماح للأعضاء التحكم في الخيارات المتوفرة للروابط الخارجية.',
	'ACP_EXTLINKNEWWIN_USER'			=> 'تفعيل للأعضاء',
	'ACP_EXTLINKNEWWIN_USER_EXPLAIN'	=> 'إذا تم تحديد <strong>لا</strong> للخيار “تفعيل في لوحة التحكم الشخصية”, سيتم تطبيق الخيار الذي تحدده هنا على جميع الأعضاء المسجلين.<br />أما إذا تم تحديد <strong>نعم</strong>, سيتم تطبيق الخيار الذي تحدده هنا فقط على الأعضاء الذين لم يعدلوا في الخيارات المتاحة لهم في لوحة التحكم الشخصية.',
	'ACP_EXTLINKNEWWIN_GUESTS'			=> 'تفعيل للزائرين',
	'ACP_EXTLINKNEWWIN_GUESTS_EXPLAIN'	=> 'يستطيع الزائرين فتح الروابط الخارجية في نافذة جديدة عند تحديد “نعم”.',
	'ACP_EXTLINKNEWWIN_BOTS'			=> 'تفعيل لمحركات البحث',
	'ACP_EXTLINKNEWWIN_BOTS_EXPLAIN'	=> 'محركات البحث تستطيع فتح الروابط الخارجية في نافذة جديدة عند تحديد “نعم”.',
	'ACP_EXTLINKNEWWIN_ADDREF'			=> 'إضافة الوسم <i>rel="nofollow"</i>',
	'ACP_EXTLINKNEWWIN_ADDREF_EXPLAIN'	=> 'عند تفعيل هذا الخيار, سيتم إضافة الوسم ’rel="nofollow"’ إلى جميع الروابط الخارجية التي تم تعديلها بواسطة هذه الأضافة لفتحها في نافذة جديدة. هذا الوسم يعمل على عدم متابعة الروابط الخارجية.',
));
