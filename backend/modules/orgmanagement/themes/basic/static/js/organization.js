$(document).ready(function() {
	$("body").on("click","#departmentList .open",function() {
		$(this).addClass("close").removeClass("open");
		$(this).next("ul").css("display","none");
	});

	$("body").on("click","#departmentList .close",function() {
		$(this).addClass("open").removeClass("close");
		$(this).next("ul").css("display","block");
	});

	$("body").on("click","#departmentList input",function(e) {
		if ($(this).parent().next()[0] && $(this).parent().next()[0].tagName === "UL") {
			if ($(this).prop("checked")) {
				//$(this).parent().next().find("li input").prop("checked",true);
			} else {
				//$(this).parent().next().find("li input").prop("checked",false);
				if ($(this).parents("ul").prev()[0] && $(this).parents("ul").prev()[0].tagName === "LI" && $(this).parents("ul").prev().children("input").prop("checked")) {
					//$(this).parents("ul").prev().children("input").prop("checked",false);
				}
			}
		}

		if ($(this).parents("ul").prev()[0] && $(this).parents("ul").prev()[0].tagName === "LI" && $(this).parents("ul").prev().children("input").prop("checked")) {
			//$(this).parents("ul").prev().children("input").prop("checked",false);
		}

		e.stopPropagation();
	});
})