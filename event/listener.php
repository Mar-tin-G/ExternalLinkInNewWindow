<?php
/**
*
* @package phpBB Extension - martin externallinkinnewwindow
* @copyright (c) 2015 Martin ( https://github.com/Mar-tin-G )
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace martin\externallinkinnewwindow\event;

/**
* @ignore
*/
use \phpbb\config\config;
use \phpbb\user;
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
	* Add the 'target="_blank"' attribute to HTML anchors
	*
	* Only links to external resources are modified.
	* If enabled in ACP, this function also adds the 'rel="nofollow"' attribute.
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
			/*
			 * search for all links with one expensive preg_match_all() call.
			 * the regular expression matches:
			 * <a ... class="... postlink ..." ... href="{HREF}" ...>{TEXT}</a>
			 *
			 * the $matches array then contains for each single match:
			 * [0]        the full match
			 * ['anchor'] the full opening anchor tag '<a ... ' (without the closing >) of the matched link
			 * ['href']   the external link HREF
			 * ['text']   the TEXT content of the <a> element
			 */

			// construct the regular expression:
			// all characters that are not separators (i.e. that do not end attribute or element)
			$not_sep = '[^"<>]*?';
			// the class attribute must contain 'postlink', but there may be other classes appended or prepended
			$class = $not_sep . 'postlink'. $not_sep;

			if (preg_match_all('#'.
				// we need the full opening anchor tag <a ... >
				'(?P<anchor><a'.
					// the attributes are in arbitrary order, separated by whitespace
					'(?:\s+'.
						// the attribute may be one of:
						'(?:'.
							// class: we need to match this
							'class="(?P<class>'. $class .')"'.
							'|'.
							// href: we need to match this too
							'href="(?P<href>[^"]+?)"'.
							'|'.
							// other attributes are not of interest to us
							'\w+="'. $not_sep . '"'.
						')'.
					')+'.
				')>'.
				// we also need the link text <a ...>text</a>
				// NB: do not use $not_sep here as the text may contain the " character
				'(?P<text>[^<]+?)'.
				'</a>#si',
				$text, $matches, PREG_SET_ORDER)
			)
			{
				foreach ($matches as $match)
				{
					// do nothing if the postlink class or the href was not set
					if ($match['class'] == '' || $match['href'] == '')
					{
						continue;
					}

					// if you put an internal link in [url] tags, phpBB will mark them as "postlink",
					// i.e. as an external link. So we have to filter out these internal links.
					if (strpos($match['href'], $board_url) === false)
					{
						// if the link already contains the 'target' attribute, replace it; otherwise append it
						if (preg_match('#target="[^"]+?"#si', $match['anchor']) === 1)
						{
							$link_anchor = preg_replace('#target="[^"]+?"#si', 'target="_blank"', $match['anchor']);
						}
						else
						{
							$link_anchor = $match['anchor'] . ' target="_blank"';
						}

						// add the rel="nofollow" attribute, if enabled in ACP
						if ($this->config['martin_extlinknewwin_add_ref'])
						{
							// replace existing 'rel' attribute or append it
							if (preg_match('#rel="[^"]+?"#si', $link_anchor) === 1)
							{
								$link_anchor = preg_replace('#rel="[^"]+?"#si', 'rel="nofollow"', $link_anchor);
							}
							else
							{
								$link_anchor .= ' rel="nofollow"';
							}
						}

						// finally replace the external link
						$text = str_replace($match[0], $link_anchor . '>' . $match['text'] . '</a>', $text);
					}
				}

				$event['text'] = $text;
			}
		}
	}
}
