$(document).ready(function() {
	$("#uploadBox input:file").on("change",function() {
		var name = this.files[0].name;
		$(this).siblings("input:text").val(name);
	})
});