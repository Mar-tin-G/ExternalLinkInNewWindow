<?php
/**
*
* @package phpBB Extension - martin externallinkinnewwindow
* @copyright (c) 2015 Martin ( https://github.com/Martin-G- )
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace martin\externallinkinnewwindow\migrations;

class release_1_0_0 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['martin_extlinknewwin_version']) && version_compare($this->config['martin_extlinknewwin_version'], '1.0.0', '>=');
	}

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\alpha2');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('martin_extlinknewwin_version', '1.0.0')),
			array('config.add', array('martin_extlinknewwin_enable_user', 0)),
			array('config.add', array('martin_extlinknewwin_enable_ucp', 0)),
			array('config.add', array('martin_extlinknewwin_enable_guests', 0)),
			array('config.add', array('martin_extlinknewwin_enable_bots', 0)),
			array('config.add', array('martin_extlinknewwin_add_ref', 0)),

			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_EXTLINKNEWWIN_TITLE'
			)),
			array('module.add', array(
				'acp',
				'ACP_EXTLINKNEWWIN_TITLE',
				array(
					'module_basename'	=> '\martin\externallinkinnewwindow\acp\main_module',
					'modes'				=> array('settings'),
				),
			)),
		);
	}

	public function update_schema()
	{
		return array(
			'add_columns'	=> array(
				$this->table_prefix . 'users'	=> array(
					'user_extlinknewwin'	=> array('UINT', 0),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_columns'	=> array(
				$this->table_prefix . 'users'	=> array(
					'user_extlinknewwin',
				),
			),
		);
	}
}
