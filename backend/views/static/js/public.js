$(document).ready(function() {
	// 调整主体部分高度
	setMainHeight();
	$(window).resize(setMainHeight);

	// 未开放模块提示
	$(".module.disabled").click(function() {
		CreatePrompt.init("This module is not open!",250);
		return false;
	})
});

function setMainHeight() {
	var height = $(window).height() - $("#header").height() - $("#footer").height();
	$("#main").css("height", height + "px");
}

var CreatePrompt = {
	init : function(text,width) {
		var html = "<div class='shadow'></div><div class='pop-ups'><h3>Msg<a href='#' class='close r'></a></h3><p>"+text+"</p></div>";

		$("body").append(html);
		$(".pop-ups").css({width : width + "px", marginLeft: - (width/2) + "px", marginTop : - ($(".pop-ups").height()/2) + "px"});

		this.click();
	},
	click : function() {
		$(".pop-ups .close").click(function() {
			$(".shadow").remove();
			$(".pop-ups").remove();
			return false;
		});
	}
}