[![Build Status](https://travis-ci.org/Mar-tin-G/ExternalLinkInNewWindow.svg?branch=master)](https://travis-ci.org/Mar-tin-G/ExternalLinkInNewWindow)

# External Link In New Window

[phpBB 3.2](https://www.phpbb.com/) Extension External Link In New Window

## Beta

This extension is still in beta status. Please do not use this extension on production boards without testing.

## Description

Modifies external links (i.e. links to a resource outside of your board) to open in a new browser window by default.

Works without JavaScript, the needed attributes are injected into the HTML output. Also adds the ability to add the *rel=nofollow* attribute to external links.

The extension can be configured in the Admin Control Panel:
* Allow users to choose for themselves if they would like to open external links in a new window.
* Or force external links to be opened in a new window for registered users.
* Open external links in new window for guests.
* Open external links in new window for bots.

If enabled in the Admin Control Panel, the board users can configure in their User Control Panel if they would like to open external links in a new window. You can configure a default behavior in the Admin Control Panel that is used if a user does not choose a setting on his own.

The extension only modifies these links when displaying a message (post, private message, etc.). It does not alter the messages that are stored into the database.

## Installation Instructions

* Download ZIP file from master branch
* Extract the ZIP file locally
* Create the following folders in you phpBB root path (if they do not exist already): `ext/martin/externallinkinnewwindow/`
* Upload all files from the extracted ZIP file to this folder `ext/martin/externallinkinnewwindow/` (overwrite any existing files)
* Log into your forum and enter the *Administration Control Panel*
* Go to *Customise* > *Extension Management* > *Manage Extensions*
* Find *External Link In New Window* in the list on the right side and click on *Enable*
* Go to *Extensions* > *External Link In New Window* > *Settings* to set up the extension

## Feedback

Please feel free to post any feedback to the [External Link In New Window topic](https://www.phpbb.com/community/viewtopic.php?f=501&t=2284971) in phpBB's extension community forum.

## License

[GPLv2](license.txt)
