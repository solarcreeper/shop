$(document).ready(function() {
	$("input[name='username']").keyup(function() {
		var postData = "func_type=find_user&username=" + $(this).val();
		$.ajax({
			type: "post",
			url: "../shop_server/fxs/add_fxs_user.php",
			data: postData,
			dataType: "json",
			async: true,
			success: function(result, status) {
				if (result.finded == true) {
					$("#error").html("&nbsp;&nbsp;该用户名已注册！");
				} else {
					$("#error").text("");
				}
			}
		});
	});

	$("#submit_args").submit(function(e) {
		e.preventDefault();
		var postData = "func_type=add&" + $(this).serialize();
		$.ajax({
			type: "post",
			url: "../shop_server/fxs/add_fxs_user.php",
			data: postData,
			dataType: "json",
			async: true,
			success: function(result) {
				alert(result.status);
				location.reload();
			},
			error: function(xhr, status, error) {
				alert(xhr.responseText);
			}
		});
	});
});

