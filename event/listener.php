<?php
/**
*
* @package phpBB Extension - martin externallinkinnewwindow
* @copyright (c) 2018 Martin ( https://github.com/Mar-tin-G )
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace martin\externallinkinnewwindow\event;

/**
* @ignore
*/
use \phpbb\config\config;
use \phpbb\user;
use martin\externallinkinnewwindow\constants;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.text_formatter_s9e_configure_after'	=> 'configure_textformatter',
			'core.text_formatter_s9e_renderer_setup'	=> 'set_textformatter_parameters',
		);
	}

	/* @var config */
	protected $config;

	/* @var user */
	protected $user;

	/**
	* Constructor
	*
	* @param config	$config
	* @param user	$user
	*/
	public function __construct(config $config, user $user)
	{
		$this->config = $config;
		$this->user = $user;
	}

	/**
	* Extends the s9e TextFormatter template for the URL tag to include two more
	* templates: open the URL in a new window, and open it in a new window with
	* setting the rel="nofollow" attribute.
	*
	* @param	object		$event	The event object
	* @return	null
	* @access	public
	*/
	public function configure_textformatter($event)
	{
		/** @var \s9e\TextFormatter\Configurator $configurator */
		$configurator = $event['configurator'];

		// the default URL tag template is this:
		// <a href="{@url}" class="postlink"><xsl:apply-templates/></a>
		$default_url_template = $configurator->tags['URL']->template;

		$url_template_new_window = str_replace(
			'href="{@url}"',
			'href="{@url}" target="_blank" rel="noopener noreferrer"',
			$default_url_template
		);
		$url_template_new_window_nofollow = str_replace(
			'href="{@url}"',
			'href="{@url}" target="_blank" rel="noopener noreferrer nofollow"',
			$default_url_template
		);

		// select the appropriate template based on the parameters and the URL
		$configurator->tags['URL']->template =
			'<xsl:choose>' .
				'<xsl:when test="$S_OPEN_IN_NEW_WINDOW and not(starts-with(@url, \'' . generate_board_url() . '\'))">' .
					'<xsl:choose>' .
						'<xsl:when test="$S_NOFOLLOW">' . $url_template_new_window_nofollow . '</xsl:when>' .
						'<xsl:otherwise>' . $url_template_new_window . '</xsl:otherwise>' .
					'</xsl:choose>' .
				'</xsl:when>' .
				'<xsl:otherwise>' . $default_url_template . '</xsl:otherwise>' .
			'</xsl:choose>';
	}

	/**
	* Sets parameters for the s9e TextFormatter, which will be used to select
	* the appropriate template for the URL tag.
	*
	* @param	object		$event	The event object
	* @return	null
	* @access	public
	*/
	public function set_textformatter_parameters($event)
	{
		/** @var \s9e\TextFormatter\Renderer $renderer */
		$renderer = $event['renderer']->get_renderer();

		// only modify external links to open in a new window if...
		$renderer->setParameter('S_OPEN_IN_NEW_WINDOW',
			// ... the visitor is a guest and the ACP option "Open external links in new window for guests" is set...
			(!$this->user->data['is_registered'] && $this->config['martin_extlinknewwin_enable_guests'])
			// ... or the visitor is a bot and the ACP option "Open external links in new window for bots" is set...
			|| ($this->user->data['is_bot'] && $this->config['martin_extlinknewwin_enable_bots'])
			// ... or the visitor is a registered user and...
			|| ($this->user->data['is_registered'] && (
				// ... the ACP option to let the user enable/disable this feature via UCP is NOT set,
				// and the ACP option "Open external links in new window for users" is set...
				(!$this->config['martin_extlinknewwin_enable_ucp'] && $this->config['martin_extlinknewwin_enable_user'])
				// ... or the ACP option to let the user enable/disable this feature via UCP IS set, ...
				|| ($this->config['martin_extlinknewwin_enable_ucp'] && (
					// ... and the user chose to enable this feature...
					($this->user->data['user_extlinknewwin'] == constants::ALWAYS_NEW_WIN)
					// ... or he chose to use the board default, which is to enable this feature.
					|| ($this->user->data['user_extlinknewwin'] == constants::USE_BOARD_DEFAULT && $this->config['martin_extlinknewwin_enable_user'])
				))
			))
		);

		// add rel="nofollow" attribute if enabled in the ACP
		$renderer->setParameter('S_NOFOLLOW', !!$this->config['martin_extlinknewwin_add_ref']);
	}
}
