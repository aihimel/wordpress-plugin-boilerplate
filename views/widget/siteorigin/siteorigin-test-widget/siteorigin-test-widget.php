<?php
/**
 * Widget Name: Siteorigin Test Widget
 * Description: Test widget for site origin
 * Author: Aftabul Islam
 * Author URI: http://giribaz.com
 * Widget URI: http://giribaz.com
 * Video URI: http://giribaz.com
 * */

// Security check
if(!defined('ABSPATH')) die();

/**
 * 
 * @class SiteoriginTestWidget
 * @description Widget main class.
 * 
 * */
class SiteoriginTestWidget extends SiteOrigin_Widget{
	
	//auto::  public function __construct(){
		//auto::  parent::__construct(
			//auto::  'site-origin-test-widget', // Unique id for the widget
			//auto::  'Site Origin Test Widget Name'
		//auto::  );
	//auto::  }
	
	public function get_template_name($instance){
		return '';
	}
	
	public function get_style_name($instance){
		return '';
	}
	
}

siteorigin_widget_register('siteorigin-test-widget', __FILE__, 'SiteoriginTestWidget');

?>
