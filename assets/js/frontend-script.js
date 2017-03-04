/**
 * 
 * @file frontend-script.js
 * @description All the script here will be included in frontend.
 * 
 * */

/**
 * 
 * @var GB_WPB_FRONTEND
 * @description Global variable to hold every element on the frontend script
 * 
 * */
GB_WPB_FRONTEND = {};

(function($){
$(document).ready(function(){

/**
 * 
 * @function demo
 * @description Demo function
 * @param param :: Random variable
 * @return void
 * @usage GB_WPB_FRONTEND.demo(param)
 * 
 * */
GB_WPB_FRONTEND.demo = function(param){
	// Function code here
}

// Frontend ajax request example
$('#wpb-click').on('click', function(){
	//auto::  alert(_GB_SECURITY[0]);
	var data = {
		action: 'ajax_frontend_example',
		value: 'example',
		_gb_security: _GB_SECURITY[0],
	};
	$.post(
		GB_AJAXURL, 
		data, 
		function(response){
			$('#wpb-display').html(response);
		}
	);
});
	
})
})(jQuery);
