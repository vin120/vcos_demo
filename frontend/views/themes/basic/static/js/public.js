$(document).ready(function() {
	$(".checkbox input").each(function() {
		toggleChecked($(this));
	})
	$(".checkbox input").on("click",function() {
		toggleChecked($(this));
	});
});

function toggleChecked(obj) {
	if (obj.prop("checked")) {
		obj.siblings("span").css("display","inline-block");
	} else {
		obj.siblings("span").css("display","none");
	}
}