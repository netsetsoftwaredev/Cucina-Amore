jQuery(document).ready(function ($) {
    $(".sidebar .block-categories li").each(function () {
        if ($(this).find('.sub-menu').length > 0) {
            $(this).addClass('parent-menu');
        }
    });
	$(".sidebar .block-categories li.parent-menu  > a").click(function(event) {		
		$(this).parent().find('.sub-menu').toggle();
		$(this).parent().toggleClass('open');
		event.preventDefault();
	});
});
function goBlogListSearch(e){
    var value = document.getElementById('blog_list_search').value;
    if (value) {
        window.location = e.form.action + value + '/';
    }
    return false;
}