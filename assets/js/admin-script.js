/**
 * 
 * @file admin-script.js
 * @description All the script here will be included in admin panel
 * 
 * */

/**
 * 
 * @var GB_WPB_BACKEND
 * @description Global variable to hold every element on the backend script
 * 
 * */
GB_WPB_BACKEND = {};

(function($){
$(document).ready(function(){

/**
 * 
 * @function demo
 * @description Demo function
 * @param param :: Random vairalbe
 * @return void
 * 
 * */
GB_WPB_BACKEND.demo = function(param){
	// function code here
}

// Backend ajax request example
$('#wpb-click').on('click', function(){
	//auto::  alert(_GB_SECURITY[0]);
	var data = {
		action: 'ajax_backend_example',
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
