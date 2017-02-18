<?php
/**
 * 
 * @file example_shortcode.php
 * @description Example shortcode outpub
 * 
 * */

// Security Check
if(!defined('ABSPATH')) die();

// Assets loading
wp_enqueue_style('wpb-frontend-style');
wp_enqueue_script('wpb-frontend-script');

global $wordpress_plugin_boilerplage;
ob_start();
?>
<?php //pr($wordpress_plugin_boilerplage->shortcode_data);?>

<div id='wpb-display'>Display Here</div>
<button id='wpb-click'>Click</button>

<?php
$wordpress_plugin_boilerplage->shortcode_html = ob_get_contents();
ob_end_clean();
?>
