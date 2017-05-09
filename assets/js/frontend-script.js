/**
 * 
 * @file frontend-script.js
 * @description All the script here will be included in frontend.
 * 
 * */
(function($){
$(document).ready(function(){

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
