<?php
class DotmailerNewsletterWidget extends WP_Widget {
	public function __construct()
	{
		parent::WP_Widget(false, $name = __('dotmailer Newsletter Widget', 'DotmailerNewsletterWidget') );
	}

	public function form( $instance )
	{
		if ( $instance ) {
			$title = esc_attr($instance['title']);
		} else {
			$title = '';
		}
		echo '<p>Title:
		<input class="widefat" id="' . $this->get_field_id("title") . '" name="' . $this->get_field_name("title") . '" type="text" value="' . $title . '" />
		</p>';
	}

	public function update( $new_instance, $old_instance )
	{
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}

	public function widget( $args, $instance )
	{
		extract ( $args );
		$title = apply_filters('widget_title', $instance['title']);
		echo $before_widget;
		echo '<div class="widget-text wp_widget_plugin_box">';

		if ( $title ) {
			echo $before_title . $title . $after_title;
		}

		$options = get_option( 'dotmailer_option_name' );
		
		$username = $options['dotmailer_username'];
		$password = $options['dotmailer_password'];
		?>

		<form name="dotmailer-subscribe" id="dotmailer-subscribe" method="post" action="<?php echo get_site_url() ?>/wp-content/plugins/dotmailer-newsletter/DotmailerNewsletterSubscribe.php">
			<input class="dotmailer-email" type="email" name="dotmailer-email" id="dotmailer-email" />
			<button type="submit">Subscribe</button>
		</form>
		<p id="form-messages"></p>

		<?php

		echo '</div>';
		echo $after_widget;
	}
}
$script = get_site_url() . '/wp-content/plugins/dotmailer-newsletter/js/dotmailerAjax.js';
wp_enqueue_script('dotmailer AJAX', $script, array('jquery'));

add_action('widgets_init', create_function('', 'return register_widget("DotmailerNewsletterWidget");') );