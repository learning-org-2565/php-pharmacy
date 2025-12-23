/**
* Make Payment JS - admin js for Drug Store theme
* @version v1.0
* @copyright 2020 Pepdev.
*/
function roundNumber(number, decimals) {
	var newString;
	decimals = Number(decimals);
	if (decimals < 1) {
		newString = (Math.round(number)).toString();
	} else {
		var numString = number.toString();
		if (numString.lastIndexOf(".") == -1) {
			numString += ".";
		}
		var cutoff = numString.lastIndexOf(".") + decimals;
		var d1 = Number(numString.substring(cutoff, cutoff + 1)); 
		var d2 = Number(numString.substring(cutoff + 1, cutoff + 2)); 
		if (d2 >= 5) {
			if (d1 == 9 && cutoff > 0) {
				while (cutoff > 0 && (d1 == 9 || isNaN(d1))) {
					if (d1 != ".") {
						cutoff -= 1;
						d1 = Number(numString.substring(cutoff, cutoff + 1));
					} else {
						cutoff -= 1;
					}
				}
			}
			d1 += 1;
		}
		if (d1 == 10) {
			numString = numString.substring(0, numString.lastIndexOf("."));
			var roundedNum = Number(numString) + 1;
			newString = roundedNum.toString() + '.';
		} else {
			newString = numString.substring(0, cutoff) + d1.toString();
		}
	}
	if (newString.lastIndexOf(".") == -1) {
		newString += ".";
	}
	var decs = (newString.substring(newString.lastIndexOf(".") + 1)).length;
	for (var i = 0; i < decimals - decs; i++) newString += "0";
		return newString;
}

function checkInputValue(ele_value, ele_class, error_field = 'Input') {
	if(ele_value != '') {
		if($.isNumeric(ele_value)) {
			$(ele_class).parent().find('.invalid-feedback').html('');
			$(ele_class).parent().find('.invalid-feedback').hide();
			ele_value = parseFloat(ele_value);
			if(ele_value >= 0) {
				return true;
			} else {
				ele_class.parent().find('.invalid-feedback').html('The '+error_field+' field is not negative number.');
				ele_class.parent().find('.invalid-feedback').show();
			}
		} else {
			ele_class.parent().find('.invalid-feedback').html('The '+error_field+' field is only number.');
			ele_class.parent().find('.invalid-feedback').show();
		}
	} else {
		ele_class.parent().find('.invalid-feedback').html('');
		ele_class.parent().find('.invalid-feedback').hide();
	}
}

function updateTotal(value, ele) {
	var advance = 0, deduction = 0,
	total = 0, month_salary = 0;
	if ($('.t-amount').val() != "") {
		month_salary = parseFloat($('.t-amount').val());
	} else {
		month_salary = 0;
	}

	if ($('.t-advance').val() != "") {
		advance = parseFloat($('.t-advance').val());
	} else {
		advance = 0;
	}

	if ($('.t-deduction').val() != "") {
		deduction = parseFloat($('.t-deduction').val());
	} else {
		deduction = 0;
	}

	total = parseFloat(month_salary) + parseFloat(advance) - parseFloat(deduction);
	$('.t-total').val(roundNumber(total, 2));
}

$(document).ready(function () {
	"use strict";

	$("#month").datepicker( {
		dateFormat: $('.common_date_my_format').val(),
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		onClose: function(dateText, inst) { 
			$(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
			var month = (inst.selectedMonth+1);
			month = (month < 10 ? "0"+month : month);
			var date = inst.selectedYear + '-' + month;

			$.ajax({
				type: 'post',
				url: 'index.php?route=checkstaffsalary',
				data: { date: date, id: $('.staff_id').val(), _token: $('.s_token').val() },
				error: function () {

				},
				success: function (response) {
					response = JSON.parse(response);
					if (response.error == false) {
						$('.makepayment-submit').attr('disabled', false);
					} else {
						toastr.error(response.msg, 'Error');
						$('.makepayment-submit').attr('disabled', true);
						$('#month').val('');
					}
				}
			});
		}
	});

	$('#makepayment-container').on('blur', '.t-advance, .t-deduction', function () {
		var ele = $(this), value = ele.val();
		if (checkInputValue(value, ele)) {
			updateTotal();
		} else {
			updateTotal();
		}
	});

	$('.makepayment-submit').on('click', function () {
		updateTotal();
	});
});