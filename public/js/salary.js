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
	
	function updateSalarytemplateTotal() {
		var allownces = 0, deductions = 0,
		basic_salary = 0, gross_salary = 0, net_salary = 0;
		if ($('.basic-salary').val() != "") {
			basic_salary = parseFloat($('.basic-salary').val());
		}
		$('.allowance-container .allowance').each(function() {
			ele = $(this);
			if (ele.val() != "") {
				allownces = allownces + parseFloat(ele.val());
			}
		});
		$('.deduction-container .deduction').each(function() {
			ele = $(this);
			if (ele.val() != "") {
				deductions = deductions + parseFloat(ele.val());
			}
		});

		gross_salary = basic_salary + allownces;
		net_salary = gross_salary - deductions;

		$('.gross-salary').val(roundNumber(gross_salary, 2));
		$('.net-salary').val(roundNumber(net_salary, 2));
		$('.total-deduction').val(roundNumber(deductions, 2));
		$('.total-allowance').val(roundNumber(allownces, 2));
	}

	$(document).ready(function() {
		"use strict";
		$('body').on('blur', '.basic-salary', function () {
			var ele = $(this), value = ele.val();
			if (checkInputValue(value, ele, 'Basic Salary')) {
				updateSalarytemplateTotal();
			}
		});

		$('.deduction-container').on('blur', '.deduction', function () {
			var ele = $(this), value = ele.val();
			if (checkInputValue(value, ele, 'Deduction')) {
				updateSalarytemplateTotal();
			}
		});

		$('.allowance-container').on('blur', '.allowance', function () {
			var ele = $(this), value = ele.val();
			if (checkInputValue(value, ele, 'Allowance')) {
				updateSalarytemplateTotal();
			}
		});

		$('.allowance-container, .deduction-container').on('click', '.add-row', function () {
			var ele = $(this), ele_parent = ele.parents('table.table'), name = ele.data('name'),
			count = 0;
			if(ele_parent.find(".item-row").length !== 0) {
				count = ele_parent.find('tr.item-row:last input').attr('name').split('[')[2];
				count = parseInt(count.split(']')[0]) + 1;   
			}
			ele_parent.find('.remove-row').show();
			var item_html = '<tr class="item-row">'+
			'<td><input type="text" name="salary['+name+']['+count+'][label]" class="form-control mb-0" placeholder="Enter Label"></td>'+
			'<td><input type="text" name="salary['+name+']['+count+'][value]" class="form-control mb-0 '+name+'" placeholder="Enter Value"><span class="invalid-feedback"></span></td>'+
			'<td><a class="text-danger text-center remove-row" data-name="'+name+'"><i class="las la-trash-alt"></i></a></td>'+
			'</tr>';
			ele_parent.find(".item-row:last").after(item_html);
		});

		$('.allowance-container, .deduction-container').on('click', '.remove-row', function () {
			var ele = $(this), ele_parent = ele.parents('table.table'), name = ele.data('name'),
			count = ele_parent.find('tr.item-row').length;

			if (ele_parent.find('tr.item-row').length > 1) {
				ele.parents('tr.item-row').remove();
			}

			if (count <= 2) {
				ele_parent.find('.remove-row').hide();
			}
			updateSalarytemplateTotal();
		});

		$('.panel .panel-footer').on('click', '.salarytemplate-submit', function () {
			updateSalarytemplateTotal();
		});
	});