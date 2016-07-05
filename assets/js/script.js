/* script.js */

$(document).ready(function() {
	practice_area();
	services();
	
	// Saving
	submit_gen_info();
	submit_password();
	save_contents();
	save_area();
});

function practice_area() {
	$("#area-add").on("click", function() {
		add_area();
	});
	
	$("#area-add-input").keypress(function(e) {
		if (e.which === 13) {
			add_area();
		}
	});
	
	$("#area-remove").on("click", function() {
		remove_area();
	});
	
	move_area();
}

function move_area() {
	$("#up").on("click", function() {
		var curr_value = $("#area-select option:selected").attr("data") - 1;
		
		if (curr_value > 0) {
			var options = $("#area-select option");
			$(options[curr_value - 1]).insertAfter($(options[curr_value]));
			
			$(options[curr_value]).attr("data", curr_value);
			$(options[curr_value-1]).attr("data", curr_value + 1);
			
			var row_1_values = $(options[Number(curr_value)]).attr("value").split(',');
			var row_2_values = $(options[Number(curr_value) - 1]).attr("value").split(',');
			
			var row_1_p1 = curr_value;
			var row_2_p1 = curr_value + 1;
			
			var row_1_p2 = row_1_values[1];
			var row_2_p2 = row_2_values[1];
			
			var row_1_p3 = row_1_values[2]
			var row_2_p3 = row_2_values[2]
			
			var row_1_all = row_1_p1 + "," + row_1_p2 + "," + row_1_p3;
			var row_2_all = row_2_p1 + "," + row_2_p2 + "," + row_2_p3;
			
			$(options[Number(curr_value)]).attr("value", row_1_all);
			$(options[Number(curr_value) - 1]).attr("value", row_2_all);
		}
	});
	
	$("#down").on("click", function() {
		var curr_value = $("select option:selected").attr("data") - 1;
		
		if (curr_value < $("select option").length - 1) {
			var options = $("select option");
			$(options[curr_value]).insertAfter($(options[Number(curr_value) + 1]));
			
			$(options[curr_value]).attr("data", Number(curr_value) + 2);
			$(options[Number(curr_value) + 1]).attr("data", curr_value + 1);
			
			var row_1_values = $(options[Number(curr_value)]).attr("value").split(',');
			var row_2_values = $(options[Number(curr_value) + 1]).attr("value").split(',');
			
			var row_1_p1 = curr_value + 2;
			var row_2_p1 = curr_value + 1;
			
			var row_1_p2 = row_1_values[1];
			var row_2_p2 = row_2_values[1];
			
			var row_1_p3 = row_1_values[2]
			var row_2_p3 = row_2_values[2]
			
			var row_1_all = row_1_p1 + "," + row_1_p2 + "," + row_1_p3;
			var row_2_all = row_2_p1 + "," + row_2_p2 + "," + row_2_p3;
			
			$(options[Number(curr_value)]).attr("value", row_1_all);
			$(options[Number(curr_value) + 1]).attr("value", row_2_all);
		}
	});
}

function add_area() {
	if ($("#area-add-input").val().trim() !== "") {
		var list_length = $("select option").length + 1;
		$("select").append("<option data='" + list_length 
				+ "' value='" + list_length 
				+ ", 0, " + $("#area-add-input").val().trim() + "'>" 
				+ $("#area-add-input").val().trim() + "</option>");
		$("#area-add-input").val("");
	}
}

function remove_area() {
	var whoami = $("select option:selected").attr("data");
	var options = $("select option");
	
	for (var i = whoami; i < $("select option").length; i++) {
		var row_values = $(options[i]).attr("value").split(',');
		$(options[i]).attr("data", i);
		$(options[i]).attr("value", i + "," + row_values[1] + "," + row_values[2]);
	}
	var id = $("select option:selected").attr("value").split(',')[1]; 
	$("select option:selected").attr("hidden", true);
	$("select option:selected").attr("value", "0, " + id + ", deleted");
}


// SAVE
function submit_gen_info() {
	$("#submit-general").on("click", function() {
		if (check_phone() && check_fax() && check_state() && check_zipcode()) {
			return true;
		}
		return false;
	});
}

function check_phone() {
	var area = $("#phone-area").val().trim();
	var num_1 = $("#phone-area").next().val().trim();
	var num_2 = $("#phone-area").next().next().val().trim();
	
	if (area !== "" && num_1 !== "" && num_2 !== "") {
		return true;
	}
	
	else if (area[0] !== "0") {
		if (area.length === 3 && num_1.length === 3 && num_2.length === 4) {
			if (IsNumeric(area) && IsNumeric(num_1) && IsNumeric(num_2)) {
				return true;
			}
		}
	}
	
	$("#err-phone").text("invalid phone number");
	$("#phone-area").css("border","3px solid #e28366");
	$("#phone-area ~ input").css("border","3px solid #e28366");
	return false;
}

function check_fax() {
	var area = $("#fax-area").val().trim();
	var num_1 = $("#fax-area").next().val().trim();
	var num_2 = $("#fax-area").next().next().val().trim();
	
	if (area === "" && num_1 === "" && num_2 === "") {
		return true;
	}
	
	else if (area[0] !== "0") {
		if (area.length === 3 && num_1.length === 3 && num_2.length === 4) {
			if (IsNumeric(area) && IsNumeric(num_1) && IsNumeric(num_2)) {
				return true;
			}
		}
	}
	
	$("#err-fax").text("invalid fax number");
	$("#fax-area").css("border","3px solid #e28366");
	$("#fax-area ~ input").css("border","3px solid #e28366");
	return false;
}

function IsNumeric(input) {
	return (input - 0) == input && (''+input).trim().length > 0;
}

function check_state() {
	var selected_state = $("#state").val();
	
	for (var i in state) {
		if (i === selected_state.toUpperCase()) {
			$("#err-state").text("");
			return true;
		}
	}
	$("#err-state").text("invalid state");
	$("#state").css("border","3px solid #e28366");
	return false;
}

function check_zipcode() {
	if (valid_zipcode($("#zipcode").val())) {
		$("#err-zipcode").text("");
		return true;
	}
	$("#err-zipcode").text("invalid zipcode");
	$("#zipcode").css("border","3px solid #e28366");
	return false;
}

function valid_zipcode(zipcode) {
	return /^\d{5}(-\d{4})?$/.test(zipcode);
}

function submit_password() {
	$("#submit-password").on("click", function() {
		
		if ($("#password").val() !== $("#password-confirm").val()) {
			$("#err-password").text("not matched");
			$("#password-confirm").css("border","3px solid #e28366");
			return false;
		}
		
		if ($("#password").val().trim() === $("#username").val() || $("#password").val().trim() === "password") {
			$("#err-password").text("Please choose different password.");
			$("#password").css("border","3px solid #e28366");
			return false;
		}
		
		if ($("#password").val().trim().length < 8) {
			$("#err-password").text("Password should contain at least 8 characters.");
			$("#password").css("border","3px solid #e28366");
			return false;
		} 
		
		return true;
	});
}

function save_contents() {
	$("#save-contents").on("click", function() {
		save_msg();
		return true;
	});
}

function save_area() {
	$("#save-area").on("click", function() {
		$("#area-select").attr("multiple", true);
		$("#area-select option").attr("selected", true);
	});
}

function save_msg() {
	$(".status-msg").css("opacity", 1);
	$(".status-msg").text("Saved");
	
	setTimeout(function() {
		$(".status-msg").animate({
			"opacity" : "0"
		}, 1000);
	}, 3000);
}

function services() {
	$("#add-service").on("click", function() {
		/*if ($("#add-services-tool").attr("class") === "collapsed") {
			$("#add-services-tool").attr("class", "opened");
			$("#add-services-tool").slideDown(300);
		}
		else {
			
		}*/
		
		$("#services-form").append("<div class='form-selection'><label>Service</label>" 
				+ "<input type='text' value='<?php echo $services['title']; ?>' name='services-title-1' /><br />" 
				+ "<textarea name='services-content-1'></textarea><button class='btn btn-danger service-delete'>"
				+ "DELETE</button></div>");
		
	});
}