<?php
/**
*
* @package phpBB Extension - martin externallinkinnewwindow
* @copyright (c) 2014 Martin ( https://github.com/Martin-G- )
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace martin\externallinkinnewwindow\acp;

class main_info
{
	function module()
	{
		return array(
			'filename'	=> '\martin\externallinkinnewwindow\acp\main_module',
			'title'		=> 'ACP_EXTLINKNEWWIN_TITLE',
			'version'	=> '1.0.0',
			'modes'		=> array(
				'settings'	=> array(
					'title'	=> 'ACP_EXTLINKNEWWIN_SETTINGS',
					'auth'	=> 'ext_martin/externallinkinnewwindow && acl_a_board',
					'cat'	=> array('ACP_EXTLINKNEWWIN_TITLE'),
				),
			),
		);
	}
}
