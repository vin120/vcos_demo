$(document).ready(function() {
	$(".accordionBtn a").on("click",function() {
		var index = $(this).index();

		if ($(this).hasClass("active")) {
			$(this).removeClass("active");
			$(this).parents(".accordion").find(".body div").eq(index).slideUp();
		} else {
			$(this).addClass("active").siblings().removeClass("active");
			$(this).parents(".accordion").find(".body div").eq(index).slideDown().siblings().slideUp();
		}

		return false;
	});
});