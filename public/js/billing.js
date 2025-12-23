/**
 * Billing JS - billing js for Drug Store theme
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
 			ele_value = parseFloat(ele_value);
 			if(ele_value >= 0) {
 				return true;
 			} else {
 				ele_class.val('');
 				toastr.error('Please enter numeric value in input box. field is not negative number', 'Error');
 			}
 		} else {
 			ele_class.val('');
 			toastr.error('Please enter numeric value in input box. field is only number', 'Error');
 		}
 	} else {
 		ele_class.val('');
		//toastr.error('Please enter numeric value in input box', 'Error');
	}
}

function updateTotal() {
	var total = 0,
	taxtotal = 0,
    discount = 0;

	$('.item-price').each(function(i) {
		price = $(this).val();
		if (!isNaN(price)) { total += Number(price); }
	});

	
	$('.item-discountvalue').each(function(i) {
        discountvalue = Number($(this).val());
        if (!isNaN(discountvalue)) { discount += discountvalue; }
    });
	
	$('.item-tax-price').each(function(i) {
		taxprice = $(this).val();
		if (!isNaN(taxprice)) { taxtotal += Number(taxprice); }
	});

	taxprice = roundNumber(taxtotal, 2);
	discount = roundNumber(discount, 2);
	taxprice = roundNumber(taxprice, 2);
	var amount = roundNumber((+price + +taxprice), 2);

	$('.total-discount').val(discount);
	$('.total-price').val(total);
	$('.total-tax').val(taxprice);
	$('.total-amount').val(amount);
}

function updatePrice() {
	$('.item-row').each(function(){
		var row = $(this),
		price = row.find('.item-sale').val() * row.find('.item-qty').val(),
		discounttype = row.find('.item-discounttype').val(),
        discount = Number(row.find('.item-discount').val());
        discount = roundNumber(discount, 2);
        if (discounttype === "2") {
            price = price - discount;
            row.find('.item-discountvalue').val(discount);
        } else {
            discount = price * discount * 0.01;
            row.find('.item-discountvalue').val(discount);
            price = price - discount;
        }

		var tax_price = roundNumber(row.find('.item-tax').find(':selected').data( "rate" ) * price * 0.01, 2);
		var tax = 0;
		row.find('.invoice-tax p').each(function() {
			var ele = $(this);
			tax_amount = roundNumber(ele.find('.invoice-tax-rate').val() * price * 0.01, 2);
			ele.find('.single-tax-price').val(tax_amount);
			tax += Number($(this).find('input.invoice-tax-rate').val()) * price * 0.01;
		});
		tax_price = roundNumber(tax, 2);
		price = Number(roundNumber(price, 2));

		var unit_price = (+price) + (+tax_price);
		isNaN(price) ? row.find('.item-price').val("N/A") : row.find('.item-price').val(price);
		isNaN(tax_price) ? row.find('.item-tax-price').html("N/A") : row.find('.item-tax-price').val(tax_price);
	});
	updateTotal();
}

function bind() {
	$(".item-purchaseprice").on('blur', updatePrice);
	$(".item-qty").on('blur', updatePrice);
	$(".item-sale").on('blur', updatePrice);
	$(".item-discount").on('blur', updatePrice);
	$(".item-discounttype").on('blur', updatePrice);
	$("body").on('change', '.item-tax', updatePrice);
	$("body").on('change', '.discount-type', updatePrice);
}

function initAutocomplete() {
	$(".billing-items .item-name").autocomplete({
		minLength: 0,
		source: $('.site_url').val().concat('getmedicine'),
		focus: function( event, ui ) {
			$(this).parents('tr').find('.item-name').val( ui.item.label );
			return false;
		},
		select: function( event, ui ) {
			var ele = $(this), ele_parent = ele.parents('tr.item-row'),
			path = $('.site_url').val().concat('getbatch');
			ele_parent.find('.item-name').val( ui.item.label );
			ele_parent.find('.item-medicine-id').val( ui.item.id );
			ele_parent.find('.item-batch option').remove();
			$.ajax({
				type: 'POST',
				url: path,
				data: { id: ui.item.id, _token: $('.s_token').val() },
				error: function() {
					toastr.error('No data Found', 'Server Error');
				},
				success: function(response) {
					response = JSON.parse(response);
					if (response.error == false) {
						ele_parent.find('.item-batch').append(response.result);	
					} else {
						toastr.error(ui.item.label+' '+response.message, 'Warning');
					}
				}
			});

			return false;
		}
	});
}

function itemHtml(count) {
	var item_html = '<tr class="item-row">'+
	'<td>'+
	'<input type="text" name="billing[items]['+count+'][name]" class="form-control item-name" required>'+
	'<input type="hidden" name="billing[items]['+count+'][medicine_id]" class="form-control item-medicine-id" required>'+
	'<input type="hidden" name="billing[items]['+count+'][new]" value="1">'+
	'</td>'+
	'<td>'+
	'<select name="billing[items]['+count+'][batch]" class="custom-select item-batch" required></select>'+
	'<input type="hidden" name="billing[items]['+count+'][batch_name]" class="item-batch-name">'+
	'</td>'+
	'<td>'+
	'<input type="text" name="billing[items]['+count+'][expiry]" class="form-control item-expiry bg-white" required readonly>'+
	'</td>'+
	'<td>'+
	'<div class="input-group">'+
	'<input type="text" name="billing[items]['+count+'][qty]" class="form-control item-qty" required>'+
	'<div class="input-group-prepend"><span class="item-available-qty input-group-text">0</span></div>'+
	'</div>'+
	'</td>'+
	'<td>'+
	'<input type="text" name="billing[items]['+count+'][saleprice]" class="form-control item-sale" required>'+
	'</td>'+
	'<td class="">'+
    '<div class="row no-gutters">'+
    '<div class="col">'+
    '<select name="billing[items]['+count+'][discounttype]" class="custom-select border-light item-discounttype">'+
    '<option value="1">%</option>'+
    '<option value="2">Flat</option>'+
    '</select>'+
    '</div>'+
    '<div class="col">'+
    '<textarea type="text" name="billing[items]['+count+'][discount]" class="item-discount">0.00</textarea>'+
    '</div>'+
    '</div>'+
    '<input type="hidden" name="billing[items]['+count+'][discountvalue]" class="item-discountvalue" value="0.00">'+
    '</td>'+
	'<td class="invoice-tax">'+
	'<input type="hidden" class="item-tax-price" name="billing[items]['+count+'][taxprice]" readonly>'+
	'</td>'+
	'<td>'+
	'<input type="text" name="billing[items]['+count+'][price]" class="form-control bg-white item-price" required readonly>'+
	'</td>'+
	'<td>'+
	'<a class="badge badge-warning badge-sm badge-pill add-taxes m-1">Add Taxes</a>'+
	'<a class="badge badge-danger badge-sm badge-pill delete m-1">Delete</a>'+
	'</td>'+
	'</tr>';

	if (count === 0) {
		$(".billing-items tbody").prepend(item_html);
	} else {
		$(".billing-items .item-row:last").after(item_html);
	}
}

$(document).ready(function () {
	"use strict";

	$('.billing-items').on('keyup', '.item-qty', function () {
		var ele = $(this), value = ele.val(),
		ele_parent = ele.parents('.item-row');
		if (checkInputValue(value, ele)) {
			var available = ele_parent.find('.item-available-qty').text();
			var entered = ele_parent.find('.item-qty').val();
			if (Number(entered) > Number(available) ) {
				ele.val('');
				toastr.error('Quantity must be less than Available Quantity', 'Error');
			}
		}
	});

	$(".patient-doctor").autocomplete({
		source: $('.site_url').val().concat('doctor/search'),
		minLength: 2,
		focus: function() {return false;},
		select: function( event, ui ) {
			$('.patient-doctor').val(ui.item.label);
			$('.patient-doctor-id').val(ui.item.id);
			return false;
		}
	});

	$('body').on('click', `.add-taxes, .invoice-tax p`, function () {
		var ele = $(this).parents('.item-row').find('.invoice-tax');
		ele.addClass('tax-modal-open');
		ele.find('p').each(function() {
			var id = $(this).find('.invoice-tax-id').val();
			$('#addTax').find('#inv-taxes-'+id).prop('checked', true)
		});
		$('#addTax').modal('show');
	});

	$('#addTax').on('hidden.bs.modal', function (e) {
		$('.tax-modal-open').removeClass('tax-modal-open');
		$("#addTax input").prop("checked", false);
	});

	$('body').on('click', '.add-modal-taxes', function () {
		$('.tax-modal-open p').remove();

		var ele_target  = $('.tax-modal-open').parents('.item-row'),
		price = ele_target.find('.item-price').val(),
		count = ele_target.find('.item-name').attr('name').split('[')[2];
		count = parseInt(count.split(']')[0]);

		$("input:checkbox[name=modaltax]:checked").each(function(index, element){
			var ele = $(this), name = ele.siblings("label").text(), id = ele.data('id'), rate = ele.data('rate'),
			tax_amount = roundNumber(rate * price * 0.01, 2);

			$('.tax-modal-open').prepend('<p class="badge badge-light badge-sm badge-pill">'+
				name+ 
				'<input type="text" class="single-tax-price" name="billing[items]['+count+'][tax]['+index+'][tax_price]" value="'+tax_amount+'" readonly>'+
				'<input type="hidden" class="invoice-tax-id" name="billing[items]['+count+'][tax]['+index+'][id]" value="'+id+'">'+ 
				'<input type="hidden" name="billing[items]['+count+'][tax]['+index+'][name]" value="'+name+'">' +
				'<input type="hidden" class="invoice-tax-rate" name="billing[items]['+count+'][tax]['+index+'][rate]" value="' +rate+'">' +
				'</p>');
		});
		updatePrice();
		$('.tax-modal-open').removeClass('tax-modal-open');
		$('#addTax').modal('hide')
	});

	$('.billing-items').on('change', '.item-batch', function () {
		var ele = $(this), ele_parent = ele.parents('tr.item-row'),
		path = $('.site_url').val().concat('getbatchdata');
		if (ele.val() === "") {
			ele_parent.find('.item-expiry').val('');
			ele_parent.find('.item-qty').val('');
			ele_parent.find('.item-available-qty').html('0');
			ele_parent.find('.item-sale').val('');
			return false;
		} else {
			ele_parent.find('.item-batch-name').val(ele.find('option:selected').text());
			$.ajax({
				type: 'POST',
				url: path,
				data: { medicine: ele_parent.find('.item-medicine-id').val(), batch: ele.val(), _token: $('.s_token').val() },
				error: function() {
					toastr.error('No data Found', 'Server Error');
				},
				success: function(response) {
					response = JSON.parse(response);
					if (response.error == false) {
						ele_parent.find('.item-expiry').val(response.result.expiry);
						ele_parent.find('.item-qty').val('');
						ele_parent.find('.item-available-qty').html(response.result.available_quantity);
						ele_parent.find('.item-sale').val(response.result.saleprice);
					} else {

						toastr.error(response.message, 'Warning');
					}
				}
			});
		}
	});

	$('.billing-items').on('click', '.add-items', function () {
		if($(".item-row").length === 0) {
			itemHtml(0);
		} else {
			var count = $('.billing-items table tr.item-row:last .item-name').attr('name').split('[')[2];
			count = parseInt(count.split(']')[0]) + 1;
			itemHtml(count);
		}
		initAutocomplete();
		bind();
	});

	$('.billing-items').on('click', '.delete', function () {
		var ele = $(this);
		ele.parents('.item-row').remove();
		bind();
		return false;
	});

	initAutocomplete();
	bind();
});