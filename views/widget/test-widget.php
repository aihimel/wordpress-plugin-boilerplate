<?php 
/**
 * 
 * @file test-widget
 * @description A test widget for wordpress templates
 * 
 * */

// Security Check
if(!defined('ABSPATH')) die();

class GBTestWidget extends WP_Widget{

	public function __construct(){
		parent::__construct(
			'gb_test_widget',
			'GB Test Widget',
			array(
				'description' => 'GB Test Widget',
			)
		);
	}

	public function widget($args, $instance){
		$title = apply_filters('widget_title', $instance['title']);
		echo $args['before_widget'];
		if(!empty($title)) echo $args['before_title'] . $title . $args['after_title'];

		// Write all you need want to see here.
		echo $instance['posts'];

		echo $args['after_widget'];
		//auto::  pr($args);
		//auto::  pr($instance);
	}

	public function form($instance){
		if(isset($instance['title'])) $title = $instance['title']; else $title = "Demo Title";
		if(isset($instance['posts'])) $posts = $instance['posts']; else $posts = "5";

		?>

		<label for='<?php echo $this->get_field_id('title'); ?>'><?php echo "Title: ";?></label>
		<input class='widefat' id='<?php echo $this->get_field_id('title'); ?>' name='<?php echo $this->get_field_name('title'); ?>' type='text' value='<?php echo $title; ?>'>

		<label for='<?php echo $this->get_field_id('posts'); ?>'><?php echo "Posts: ";?></label>
		<input class='widefat' id='<?php echo $this->get_field_id('posts'); ?>' name='<?php echo $this->get_field_name('posts'); ?>' type='text' value='<?php echo $posts; ?>'>

		
		<?php
	}
}
