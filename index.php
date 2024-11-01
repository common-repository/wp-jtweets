<?php
/*
Plugin Name: WP-jTweets
Plugin URI: http://aaronreimann.com/plugins/wp-jtweets
Description: A widget that uses jQuery/Twitter to fade in/out a user's tweets one at a time.  Works with the new Twitter feed URL
Version: 1.1.5
Author: Aaron Reimann
Author URI: http://aaronreimann.com
License: GPL3

Copyright 2013-2021 Aaron Reimann aaron.reimann@gmail.com

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 3, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define('WPJTWEETS', __FILE__);

require_once( plugin_dir_path(WPJTWEETS).'class_widget.php' );
require_once( plugin_dir_path(WPJTWEETS).'twitteroauth/twitteroauth.php' );

function jtweets_enqueue_scripts() {
    wp_enqueue_style( 's8_jtweets_stylesheets', plugins_url( '/style.css', __FILE__ ) );
    wp_enqueue_script( 'jtweets', plugins_url( '/js/jtweets.js', __FILE__ ), array( 'jquery' ) );
}
add_action( 'wp_enqueue_scripts', 'jtweets_enqueue_scripts' );

function jtweets_widget_init() {
	register_widget( 'jTweetsWidget' );
}
add_action( 'widgets_init', 'jtweets_widget_init' );

// Twitter date/time formatter
function jtweets_twitter_formatter( $twitter_timestamp ) {
	//Format from JSON: Sat Mar 16 18:27:08 +0000 2013
	$epoch_timestamp = strtotime( $twitter_timestamp );
	$twitter_time = human_time_diff( $epoch_timestamp, current_time('timestamp') ) . ' ago' ;
	return $twitter_time;
}

// actual functions that spits out the code
function jtweets_echo(
		$twitter_username,
		$consumer_key,
		$consumer_secret,
		$access_token,
		$access_token_secret,
		$theme,
		$twitter_number,
		$show_avatar,
		$show_retweets,
		$show_replies,
		$new_window,
		$time_pause,
		$pixel_height,
		$no_fade,
        $grow_method )
{

	// getting / setting transient for caching
	if ( false === ( $tweets = get_transient( 'jtweets-'.$twitter_username ) ) ) {
		$connection = jtweets_GetConnectionWithAccessToken( $consumer_key, $consumer_secret, $access_token, $access_token_secret );
		$tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$twitter_username."&count=".$twitter_number);

		set_transient( 'jtweets-'.$twitter_username, $tweets, 300 );
		$tweets = get_transient( 'jtweets-'.$twitter_username );
	}

	if ( $tweets ) {

		if ( $no_fade ) {
			$nofade = "-no-fade";
            $nofade_class = ' no-fade';
		} else {
			$nofade = $nofade_class = '';
		}

		echo '<div id="jtweets-feed'.$nofade.'" class="jtweets-feed' . $nofade_class . ' ' . $grow_method . '"';
        if ( ! empty( $pixel_height ) ) {
            echo ' style="height: '.$pixel_height.'px;"';
        }
        if ( ! $no_fade ) {
            if ( empty( $time_pause ) ) {
                $time_pause = 10000;
            }
            echo ' data-rotatetime="'.$time_pause.'"';
        }
        echo ' class="'.$theme.'"';
		echo '>';

		if ( $show_avatar ) {
			// just getting the header stuff
			$count = 0;
			foreach ( $tweets  as $tweet ) {
				if ( $count == 0 ) {
					echo '<div class="jtweets-avatar-block">';
						echo '<div class="jtweets-avatar-block-1">';
							echo '<a href="https://twitter.com/'.$tweet->user->screen_name.'">';
								echo '<img src="'.$tweet->user->profile_image_url_https.'" alt="@'.$tweet->user->screen_name.'\'s avatar" />';
							echo '</a>';
						echo '</div>';
						echo '<div class="jtweets-avatar-block-2">';
							echo '<a href="https://twitter.com/'.$tweet->user->screen_name.'">';
								echo '@'.$tweet->user->screen_name.'';
							echo '</a>';
							echo '<br/>';
							echo $tweet->user->name.'<br/>';
						echo '</div>';
					echo '</div>';
					$count = $count + 1;
				}
			}
		}

		echo '<ul>';

		foreach ( $tweets as $tweet ) {
			$twitter_timestamp = $tweet->created_at;
			$tweet_date = jtweets_twitter_formatter( $twitter_timestamp );
			echo '<li>';
				echo jtweets_make_links( $tweet->text );
				echo ' <span>'.$tweet_date.'</span>';
			echo '</li>';
		}

		echo '</ul>';

		echo '</div>';

	} else {
		echo '<div id="jtweets-feed" class="jtweets-feed" data-rotatetime="2000">';
        echo '<ul><li>No Twitter Feed to Display</li>';
        echo '<li>Check Your Settings</li></ul>';
        echo '</div>';
	}
}

function jtweets_GetConnectionWithAccessToken( $cons_key, $cons_secret, $oauth_token, $oauth_token_secret ) {
	$connection = new TwitterOAuth( $cons_key, $cons_secret, $oauth_token, $oauth_token_secret );
	return $connection;
}

function jtweets_make_links( $tweet ) {
	$tweet = preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>', $tweet);
	$tweet = preg_replace('/(?<=^|\s)@([A-Za-z0-9\_]*)/', '<a href="http://www.twitter.com/$1\" target="_blank">@$1</a>', $tweet);
	$tweet = preg_replace('/#([A-Za-z0-9\_]*)/', '<a href="https://twitter.com/search?q=%23$1&src=hash" target="_blank">#$1</a>', $tweet); 
	return $tweet;
}
