# phpBB External Link In New Window extension

This is the repository for the development of the [phpBB](https://www.phpbb.com/) "External Link In New Window" Extension.

[![Build Status](https://travis-ci.org/Mar-tin-G/ExternalLinkInNewWindow.svg?branch=master)](https://travis-ci.org/Mar-tin-G/ExternalLinkInNewWindow)

## Description

Modifies external links (i.e. links to a resource outside of your board) to open in a new browser window by default.

Works without JavaScript, the needed attributes are injected into the HTML output. Also adds the ability to add the *rel=nofollow* attribute to external links.

The attribute *rel=noopener noreferrer* is always added to external links to prevent a possible security issue, see [this article](https://medium.com/sedeo/how-to-fix-target-blank-a-security-and-performance-issue-in-web-pages-2118eba1ce2f) for more information.

The extension can be configured in the Admin Control Panel:
* Allow users to choose for themselves if they would like to open external links in a new window.
* Or force external links to be opened in a new window for registered users.
* Open external links in new window for guests.
* Open external links in new window for bots.

If enabled in the Admin Control Panel, the board users can configure in their User Control Panel if they would like to open external links in a new window. You can configure a default behavior in the Admin Control Panel that is used if a user does not choose a setting on his own.

The extension only modifies these links when displaying a message (post, private message, etc.). It does not alter the messages that are stored into the database.

## Installation

* Download the latest validated release.
* Extract the downloaded release and copy it to the `ext` directory of your phpBB board
  * this should result in a `ext/martin/externallinkinnewwindow/` directory
* Log into your forum and enter the *Administration Control Panel*.
* Go to *Customise* > *Extension Management* > *Manage Extensions*.
* Find *External Link In New Window* in the list on the right side and click on *Enable*.
* Go to *Extensions* > *External Link In New Window* > *Settings* to set up the extension.

## Removal

* Log into your forum and enter the *Administration Control Panel*.
* Go to *Customise* > *Extension Management* > *Manage Extensions*.
* Find *External Link In New Window* in the list on the right side and click on *Disable*.
* To permanently uninstall, click on *Delete data* and delete the `ext/martin/externallinkinnewwindow/` directory afterwards.

## Feedback

Please feel free to post any feedback to the [External Link In New Window topic](https://www.phpbb.com/community/viewtopic.php?t=2284971) in phpBB's extension community forum.

For bug reports, please open an issue on [the extension's GitHub page](https://github.com/Mar-tin-G/ExternalLinkInNewWindow).

## License

[GPLv2](license.txt)
