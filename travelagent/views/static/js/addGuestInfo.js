$(document).ready(function() {
	$("#add").on("click",function() {
		new PopUps($("#addPopups"));
	});
	$("#paymentpassword").on("click",function() {
		new PopUps($("#alertpaymentpassword"));
	});
	$("#del").on("click",function() {
		new PopUps($(".prompt"));
	})
});