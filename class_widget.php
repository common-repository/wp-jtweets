<?php
class jTweetsWidget extends WP_Widget
{
	
	public function jTweetsWidget()
	{
		$widget_options = array(
			'classname'		=>	'jtweets-widget',
			'description'	=>	'A widget to show a fade-in/fade-out effect on Tweets using jQuery'
		);

		parent::WP_Widget(false, 'WP jTweets', $widget_options);
	}
	
	public function widget( $args, $instance )
	{
		extract($args, EXTR_SKIP );
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$twitter_username = isset( $instance['twitter_username'] ) ? esc_attr( $instance['twitter_username'] ) : '';
		$consumer_key = isset( $instance['consumer_key'] ) ? esc_attr( $instance['consumer_key'] ) : '';
		$consumer_secret = isset( $instance['consumer_secret'] ) ? esc_attr( $instance['consumer_secret'] ) : '';
		$access_token_secret = isset( $instance['access_token_secret'] ) ? esc_attr( $instance['access_token_secret'] ) : '';
		$access_token = isset( $instance['access_token'] ) ? esc_attr( $instance['access_token'] ) : '';
		$selected_theme = isset( $instance['theme'] ) ? esc_attr( $instance['theme'] ) : '0';
		$twitter_number = isset( $instance['twitter_number'] ) ? esc_attr( $instance['twitter_number'] ) : '3';
		$theme = isset( $instance['theme'] ) ? esc_attr( $instance['theme'] ) : '';
		$show_avatar = isset( $instance['show_avatar'] ) ? esc_attr( $instance['show_avatar'] ) : '';
		$show_retweets = isset( $instance['show_retweets'] ) ? esc_attr( $instance['show_retweets'] ) : '0';
		$show_replies = isset( $instance['show_replies'] ) ? esc_attr( $instance['show_replies'] ) : '0';
		$new_window = isset( $instance['new_window'] ) ? esc_attr( $instance['new_window'] ) : '0';
		$no_fade = isset( $instance['no_fade'] ) ? esc_attr( $instance['no_fade'] ) : '0';
		$time_pause = isset( $instance['time_pause'] ) ? esc_attr( $instance['time_pause'] ) : '';
		$pixel_height = isset( $instance['pixel_height'] ) ? esc_attr( $instance['pixel_height'] ) : '';
        $grow_method = ( isset( $instance['grow_method'] ) && in_array( $instance['grow_method'], array( 'grow-only', 'resize', 'no-resize' ) ) ) ? $instance['grow_method'] : 'grow-only';

		echo $before_widget;
		echo $before_title . $title . $after_title;

		if ( $twitter_username )
		{
			jtweets_echo(
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
                $grow_method );
		}

		echo $after_widget;
	}

	public function form($instance)
	{

		if ( !function_exists('curl_version') ) { echo "cURL most be installed on your server. This plugin will not work.<br/><br/>"; }

		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$twitter_username = isset( $instance['twitter_username'] ) ? esc_attr( $instance['twitter_username'] ) : '';
		$consumer_key = isset( $instance['consumer_key'] ) ? esc_attr( $instance['consumer_key'] ) : '';
		$consumer_secret = isset( $instance['consumer_secret'] ) ? esc_attr( $instance['consumer_secret'] ) : '';
		$access_token_secret = isset( $instance['access_token_secret'] ) ? esc_attr( $instance['access_token_secret'] ) : '';
		$access_token = isset( $instance['access_token'] ) ? esc_attr( $instance['access_token'] ) : '';
		$selected_theme = isset( $instance['theme'] ) ? esc_attr( $instance['theme'] ) : '0';
		$twitter_number = isset( $instance['twitter_number'] ) ? esc_attr( $instance['twitter_number'] ) : '3';
		$show_avatar = isset( $instance['show_avatar'] ) ? esc_attr( $instance['show_avatar'] ) : '';
		$show_retweets = isset( $instance['show_retweets'] ) ? esc_attr( $instance['show_retweets'] ) : '0';
		$show_replies = isset( $instance['show_replies'] ) ? esc_attr( $instance['show_replies'] ) : '0';
		$new_window = isset( $instance['new_window'] ) ? esc_attr( $instance['new_window'] ) : '0';
		$no_fade = isset( $instance['no_fade'] ) ? esc_attr( $instance['no_fade'] ) : '0';
		$time_pause = isset( $instance['time_pause'] ) ? esc_attr( $instance['time_pause'] ) : '';
		$pixel_height = isset( $instance['pixel_height'] ) ? esc_attr( $instance['pixel_height'] ) : '';
        $grow_method = ( isset( $instance['grow_method'] ) && in_array( $instance['grow_method'], array( 'grow-only', 'resize', 'no-resize' ) ) ) ? $instance['grow_method'] : 'grow-only';

		$themes = array (
			'Original jTweets Theme' => '',
			'No Theme (CSS is lame)' => 'theme-none',
			'TwentyTwelve Light' => 'theme-twentytwelve-light',
			'TwentyTwelve Dark' => 'theme-twentytwelve-dark',
			);			
		?>

		<label for="<?php echo $this->get_field_id('title');?>">
			Title:<br />
			<input
				id="<?php echo $this->get_field_id('title');?>"
				name="<?php echo $this->get_field_name('title');?>"
				value="<?php echo esc_attr($title) ?>"
			/><br />
		</label>
		
		<label for="<?php echo $this->get_field_id('twitter_username');?>">
			Twitter Username:<br />
			<input
				id="<?php echo $this->get_field_id('twitter_username');?>"
				name="<?php echo $this->get_field_name('twitter_username');?>"
				value="<?php echo $twitter_username; ?>"
			/><br />
		</label>

		<hr>

		<label for="<?php echo $this->get_field_id('consumer_key');?>">
			API Key: <a href="http://wordpress.org/plugins/wp-jtweets/other_notes/">(instruction here)</a><br />
			<input
				id="<?php echo $this->get_field_id('consumer_key');?>"
				name="<?php echo $this->get_field_name('consumer_key');?>"
				value="<?php echo $consumer_key; ?>"
				size="20"
			/><br />
		</label>

		<label for="<?php echo $this->get_field_id('consumer_secret');?>">
			API Secret Key:<br />
			<input
				id="<?php echo $this->get_field_id('consumer_secret');?>"
				name="<?php echo $this->get_field_name('consumer_secret');?>"
				value="<?php echo $consumer_secret; ?>"
				size="20"
			/><br />
		</label>

		<label for="<?php echo $this->get_field_id('access_token');?>">
			Access Token:<br />
			<input
				id="<?php echo $this->get_field_id('access_token');?>"
				name="<?php echo $this->get_field_name('access_token');?>"
				value="<?php echo $access_token; ?>"
				size="20"
			/><br />
		</label>

		<label for="<?php echo $this->get_field_id('access_token_secret');?>">
			Access Token Secret:<br />
			<input
				id="<?php echo $this->get_field_id('access_token_secret');?>"
				name="<?php echo $this->get_field_name('access_token_secret');?>"
				value="<?php echo $access_token_secret; ?>"
				size="20"
			/><br />
		</label>

		<hr>

		<label for="<?php echo $this->get_field_id('theme');?>">
			Theme<br>
        <select id="<?php echo $this->get_field_id('theme');?>"
                name="<?php echo $this->get_field_name('theme');?>">
            <?php
                foreach($themes as $name=>$theme) {
                    echo '<option value="'.$theme.'"';
                    echo ($selected_theme == $theme)?' selected="selected"':'';
                    echo '>'.$name.'</option>';
                }
            ?>
        </select>
        </label><br />

		<label for="<?php echo $this->get_field_id('twitter_number');?>">
			<input
				id="<?php echo $this->get_field_id('twitter_number');?>"
				name="<?php echo $this->get_field_name('twitter_number');?>"
				value="<?php echo  $twitter_number; ?>"
				size="2" maxlength="2"
			/>
			# of Tweets<br />
		</label>

		<label for="<?php echo $this->get_field_id('show_avatar');?>">
			<input
				type="checkbox"
				id="<?php echo $this->get_field_id('show_avatar');?>"
				name="<?php echo $this->get_field_name('show_avatar');?>"
				value="1"
				<?php //if ( $instance['show_retweets'] == TRUE) { print 'checked="yes" '; } ?>
				<?php if ( $show_avatar == TRUE ) { print 'checked="yes" '; } ?>
			/>
			Show Avatar/User<br />
		</label>	

		<label for="<?php echo $this->get_field_id('new_window');?>">
			<input
				type="checkbox"
				id="<?php echo $this->get_field_id('new_window');?>"
				name="<?php echo $this->get_field_name('new_window');?>"
				value="1"
				<?php if ( $new_window == TRUE ) { print 'checked="yes" '; } ?>
			/>
			Open Links in New Window<br />
		</label>	

		<label for="<?php echo $this->get_field_id('show_replies');?>">
			<input
				type="checkbox"
				id="<?php echo $this->get_field_id('show_replies');?>"
				name="<?php echo $this->get_field_name('show_replies');?>"
				value="1"
				<?php if ( $show_replies == TRUE ) { print 'checked="yes" '; } ?>
			/>
			Show Replies<br />
		</label>	

		<hr>

		<label for="<?php echo $this->get_field_id('no_fade');?>">
			<input
				type="checkbox"
				id="<?php echo $this->get_field_id('no_fade');?>"
				name="<?php echo $this->get_field_name('no_fade');?>"
				value="1"
				<?php if ( $no_fade == TRUE) { print 'checked="yes" '; } ?>
			/>
			Disable Fade In/Out<br />
		</label>

		<label for="<?php echo $this->get_field_id('time_pause');?>">
			<input
				id="<?php echo $this->get_field_id('time_pause');?>"
				name="<?php echo $this->get_field_name('time_pause');?>"
				value="<?php echo $time_pause; ?>"
				size="5" maxlength="5"
			/>
			Time to pause (1 second = 1000)<br />
		</label>

        <label for="<?php echo $this->get_field_id('grow_method');?>">
            <select id="<?php echo $this->get_field_id('grow_method');?>" style="max-width: 100%;"
                    name="<?php echo $this->get_field_name('grow_method');?>">
                <option value="grow-only" <?php if ( 'grow-only' == $grow_method ) echo 'selected="selected"'; ?>><?php _e( 'Auto-expand to contain tweets (does not shrink)' ); ?></option>
                <option value="resize" <?php if ( 'resize' == $grow_method ) echo 'selected="selected"'; ?>><?php _e( 'Auto-resize to contain tweets (will shrink with shorter tweets)' ); ?></option>
                <option value="no-resize" <?php if ( 'no-resize' == $grow_method ) echo 'selected="selected"'; ?>><?php _e( 'No resizing, div height should be set below' ); ?></option>
            </select>
            <?php _e( 'Above has no effect if "Disable Fade In/Out" is checked.' ); ?>
        </label><br/><br/>

		<label for="<?php echo $this->get_field_id('pixel_height');?>">
			Div Height in Pixels (clear if Disable Fade In/Out is checked):<br />
			<input
				id="<?php echo $this->get_field_id('pixel_height');?>"
				name="<?php echo $this->get_field_name('pixel_height');?>"
				value="<?php echo $pixel_height; ?>"
				size="3" maxlength="3"
			/><br />
		</label>
		
		<?php
	}
}
