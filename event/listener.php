<?php
/**
*
* @package phpBB Extension - martin externallinkinnewwindow
* @copyright (c) 2015 Martin ( https://github.com/Martin-G- )
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace martin\externallinkinnewwindow\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'						=> 'define_constants',
			'core.modify_text_for_display_after'	=> 'modify_external_links',
		);
	}

	/* @var \phpbb\config\config */
	protected $config;

	/* @var \phpbb\user */
	protected $user;

	/**
	* Constructor
	*
	* @param \phpbb\config\config		$config
	* @param \phpbb\user				$user
	*/
	public function __construct(\phpbb\config\config $config, \phpbb\user $user)
	{
		$this->config = $config;
		$this->user = $user;
	}

	/**
	* Define some constants that are needed for this extension. This function is called
	* early on every page by using the event 'core.user_setup'.
	*
	* @param	object		$event	The event object
	* @return	null
	* @access	public
	*/
	public function define_constants($event)
	{
		define('EXTLINKNEWWIN_USE_BOARD_DEFAULT', 0);
		define('EXTLINKNEWWIN_ALWAYS_NEW_WIN', 1);
		define('EXTLINKNEWWIN_NEVER_NEW_WIN', 2);
	}

	/**
	* Function to add the 'target="_blank"' attribute to HTML anchors (<a href="...">)
	* that link an external resource, so user agents open this link in a new window.
	* If enabled in ACP, this function does also add the 'rel="nofollow"' attribute.
	* NB: only the output to the visitors user agent is altered, the data in the
	* database is unchanged.
	*
	* @param	object		$event	The event object
	* @return	null
	* @access	public
	*/
	public function modify_external_links($event)
	{
		$text = $event['text'];
		$board_url = generate_board_url();
		$matches = array();

		// only modify external links to open in a new window if...
		if (
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
					($this->user->data['user_extlinknewwin'] == EXTLINKNEWWIN_ALWAYS_NEW_WIN)
					// ... or he chose to use the board default, which is to enable this feature.
					|| ($this->user->data['user_extlinknewwin'] == EXTLINKNEWWIN_USE_BOARD_DEFAULT && $this->config['martin_extlinknewwin_enable_user'])
				))
			))
		)
		{
			// this rather long regular expression filters all links from the text that have
			// the attribute 'class="postlink"' set, and saves the link (attribute 'href') for
			// later parsing.
			// The regular expression matches both attributes regardless of their order.
			if (preg_match_all('#(<a[^>]*?(?>class="postlink"|href="([^"]+?)")[^>]*?(?>class="postlink"|href="([^"]+?)")[^>]*?)>([^<]+?)</a>#si', $text, $matches, PREG_SET_ORDER))
			{
				foreach ($matches as $match)
				{
					$link_href = ($match[2] == '' ? $match[3] : $match[2]);
					$link_text = $match[4];

					// if you put an internal link in [url] tags, phpBB will mark them as "postlink",
					// i.e. as an external link. So we have to filter out these internal links.
					if (strpos($link_href, $board_url) === false)
					{
						// if the link already contains the 'target' attribute, replace it
						if (preg_match('#target="[^"]+?"#si', $match[1]) === 1)
						{
							$link_anchor = preg_replace('#target="[^"]+?"#si', 'target="_blank"', $match[1]);
						}
						else
						{
							$link_anchor = $match[1] . ' target="_blank"';
						}

						// add the rel="nofollow" attribute, if enabled in ACP
						if ($this->config['martin_extlinknewwin_add_ref'])
						{
							// replace existing 'rel' attribute
							if (preg_match('#rel="[^"]+?"#si', $match[1]) === 1)
							{
								$link_anchor = preg_replace('#rel="[^"]+?"#si', 'rel="nofollow"', $link_anchor);
							}
							else
							{
								$link_anchor .= ' rel="nofollow"';
							}
						}

						// finally replace the external link
						$text = str_replace($match[0], $link_anchor . '>' . $link_text . '</a>', $text);
					}
				}

				$event['text'] = $text;
			}
		}
	}
}
