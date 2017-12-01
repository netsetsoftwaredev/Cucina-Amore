jQuery(document).ready(function($){
    $('.cnb-color-field').wpColorPicker();
	$("#settings").hide();
	$(".minus").hide();;
	$("h4.cnb_settings").click(function() {
		$("#settings").slideToggle();
		$(".plus").toggle();
		$(".minus").toggle();
	});
});