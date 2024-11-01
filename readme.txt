=== WP-jTweets ===
Contributors: areimann
Donate link: http://aaronreimann.com
Tags: twitter, tweets, feed, json, rotate, cycle, status
Requires at least: 3.2
Tested up to: 5.7.0
Stable 1.1.5
Stable tag: trunk

A widget that uses jQuery and Twitter to display a user's tweets (or can just list the updates).  Works with the Twitter API 1.1

== Description ==

A Widget that uses jQuery (if you want) and Twitter to fade in and display a user's tweets one at a time, then fades into the next.  You can set the amount of tweets and how long they stay before they fade into the next tweet.  The tweets are in an infinite loop.  It only uses the jQuery library that comes with WP.  It is simple, but if you know CSS you can make it look very very nice.

== Installation ==

1. Unzip and upload the plugin into the plugins directory and then activate it. 
1. Go to the Widgets and drag the WP-jTweets bar into a sidebar.
1. Follow the instructions here under "Other Notes / Requirements"
1. Fill in your Twitter Username
1. Fill in your Twitter API fields (See Other Notes)

== Other Notes ==

= Twitter API 1.1 Keys and Tokens =

You now have to go to [Twitter's Dev Section](https://dev.twitter.com/apps/) and create an "app".  Please don't be terrified by this.  It takes 5 minutes.  The hardest part is copying and pasting the keys once they are created :)

1. Go here and login with your Twitter account: https://dev.twitter.com/apps/
1. Click 'Create New Application'
1. Give it a name like "WP-Jweets for YourDomainName"
1. Give it a description like "This is so I can show my tweets"
1. The "Website" field can be the domain name the tweets are going on
1. The "Callback URL" can be empty
1. Accept the agreement
1. Next, click on "Create My Access Token"
1. Create your token, you will need the following: Consumer key, Consumer secret, Access token and Access token

= Server =

Your server must have cURL enabled, it is required by the Twitter OAuth library (Thanks goes out to https://github.com/abraham/twitteroauth)

== Screenshots ==

1. The admin section showing the Widget
2. A screenshot in 2012 on the front end

== Changelog ==

= 1.1.5
* Changed some of the naming to match what Twitter now calls the fields.
* Testing to WordPress 5.7 RC1

= 1.1.4 =
* Standardizes the code to be more "The WP Way"

= 1.1.3 =
* Added classes (in addition to IDs for backwards compatibility) to display multiple Twitter ID’s on the same page
* Styling and JS now run off of classes
* Added option to allow resizing on fading tweets

= 1.1.2 =
* Adds option to display or not to retweets

= 1.1.1 =
* Adds an option to show "header" section to show the user's name and avatar
* Adds linking for @usernames, #hashtags and URLs
* Adds basic theming options
* Adds transient for "caching" of the feed

= 1.1.0 =
* Uses the Twitter API version 1.1
* Uses https://github.com/abraham/twitteroauth for Twitter Authentication

= 1.0.6 =
* Wraps the LI's into a UL for better HTML validation

= 1.0.5 =
* Adds the ability to disable the fade in/out and just display the feed without jQuery
* Calls in a style.css within the plugin so you don't have to drop in the CSS in a theme

= 1.0.4 =
* Uses jQuery 'data' method to pass time rotation instead of showing in the HTML
* Adds some error checking in case the Twitter user doesn't exist or the feed doesn't pull

= 1.0.3 =
* Changes to use the new Twitter API which caused an "array_slice" error

= 1.0.2 =
* Removed redundant Javascript in the front end

= 1.0.1 =
* Readme and notes changes

= 1.0 =
* Initial release

== Upgrade Notice ==

= Version 1.1.1 may affect your CSS.  If you have custom CSS, use the Original jTweets Theme.
