/**
 * Purchase JS - purchase js for Drug Store theme
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

 function updateTotal() {
 	var total = 0, discount = 0;
 	$('.item-price').each(function(i) {
 		price = $(this).val();
 		if (!isNaN(price)) { total += Number(price); }
 	});

 	var taxtotal = 0;
 	$('.item-tax-price').each(function(i) {
 		taxprice = $(this).val();
 		if (!isNaN(taxprice)) { taxtotal += Number(taxprice); }
 	});

 	$('.item-discountvalue').each(function(i) {
 		var value = $(this).val();
 		if (!isNaN(value)) { discount += Number(value); }
 	});

 	total = roundNumber(total, 2);
 	taxprice = roundNumber(taxtotal, 2);
 	discount = roundNumber(discount, 2);

	var amount = +total + +taxprice;

 	$('.total-price').val(total);
 	$('.total-tax').val(taxprice);
 	$('.total-amount').val(amount);
 	$('.total-discount').val(discount);
 }

 function updatePrice() {
 	$('.item-row').each(function(){
 		var row = $(this),
 		price = row.find('.item-purchaseprice').val() * row.find('.item-qty').val();
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

 		var tax = 0,
 		tax_price = 0;

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
 	$(".item-discounttype").on('blur', updatePrice);
 	$(".item-discount").on('blur', updatePrice);
 	$(".discount-total").on('blur', updatePrice);
 	$("body").on('change', '.item-tax', updatePrice);
 	$("body").on('change', '.discount-type', updatePrice);
 }

 function initDatepicker() {
 	$('.exp-date').datetimepicker({
 		viewMode: 'years',
 		format: $('.common_daterange_my_format').val(),
 		widgetPositioning: {
 			horizontal: 'auto',
 			vertical: 'auto'
 		},
 		collapse: true,
 		icons: {
 			time: "far fa-clock",
 			date: "far fa-calendar-alt",
 			up: "fas fa-angle-up",
 			down: "fas fa-angle-down",
 			previous: 'fas fa-angle-left',
 			next: 'fas fa-angle-right',

 		}
 	});
 }

 function initAutocomplete() {
 	$(".item-name").autocomplete({
 		minLength: 0,
 		source: $('.site_url').val().concat('getmedicine'),
 		focus: function( event, ui ) {
 			$(this).parents('tr').find('.item-name').val( ui.item.label );
 			return false;
 		},
 		select: function( event, ui ) {
 			$(this).parents('tr').find('.item-name').val( ui.item.label );
 			$(this).parents('tr').find('.item-id').val( ui.item.id );
 			return false;
 		}
 	});
 }

 function item_html(count) {
 	var item_html = '<tr class="item-row">'+
 	'<td>'+
 	'<textarea class="item-name" name="purchase[items]['+count+'][name]" required></textarea>'+
 	'<input type="hidden" class="item-id" name="purchase[items]['+count+'][medicine_id]" required>'+
 	'<input type="hidden" name="purchase[items]['+count+'][id]" required>'+
 	'</td>'+
 	'<td>'+
 	'<textarea class="item-batch" name="purchase[items]['+count+'][batch]" required></textarea>'+
 	'</td>'+
 	'<td>'+
 	'<input type="text" class="item-expiry exp-date p-2 datetimepicker-input bg-white" name="purchase[items]['+count+'][expiry]" required>'+
 	'</td>'+
 	'<td>'+
 	'<textarea class="item-pqty" name="purchase[items]['+count+'][pqty]"></textarea>'+
 	'</td>'+
 	'<td>'+
 	'<textarea class="item-qty" name="purchase[items]['+count+'][qty]" required></textarea>'+
 	'</td>'+
 	'<td>'+
 	'<textarea class="item-purchaseprice" name="purchase[items]['+count+'][purchaseprice]" required></textarea>'+
 	'</td>'+
 	'<td>'+
 	'<textarea class="item-saleprice" name="purchase[items]['+count+'][saleprice]" required></textarea>'+
 	'</td>'+
 	'<td class="">'+
 	'<div class="row no-gutters">'+
 	'<div class="col">'+
 	'<select name="purchase[items]['+count+'][discounttype]" class="custom-select border-light item-discounttype">'+
 	'<option value="1">%</option>'+
 	'<option value="2">Flat</option>'+
 	'</select>'+
 	'</div>'+
 	'<div class="col">'+
 	'<textarea type="text" name="purchase[items]['+count+'][discount]" class="item-discount">0.00</textarea>'+
 	'</div>'+
 	'</div>'+
 	'<input type="hidden" name="purchase[items]['+count+'][discountvalue]" class="item-discountvalue" value="0.00">'+
 	'</td>'+
 	'<td class="invoice-tax">'+
 	'<input type="hidden" class="item-tax-price" name="purchase[items]['+count+'][taxprice]" value="0" readonly>'+
 	'</td>'+
 	'<td>'+
 	'<textarea class="bg-white item-price" name="purchase[items]['+count+'][price]" required readonly></textarea>'+
 	'</td>'+
 	'<td>'+
 	'<a class="badge badge-warning badge-sm badge-pill add-taxes m-1">Add Taxes</a>'+
 	'<a class="badge badge-danger badge-sm badge-pill delete m-1">Delete</a>'+
 	'</td>'+
 	'</tr>';

 	if (count === 0) {
 		$(".purchase-items tbody").prepend(item_html);
 	} else {
 		$(".purchase-items .item-row:last").after(item_html);
 	}
 }

 $(document).ready(function () {
 	"use strict";
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
 		price = ele_target.find('.item-purchaseprice').val() * ele_target.find('.item-qty').val(),
 		count = ele_target.find('.item-name').attr('name').split('[')[2];
 		count = parseInt(count.split(']')[0]);

 		$("input:checkbox[name=modaltax]:checked").each(function(index, element){
 			var ele = $(this), name = ele.siblings("label").text(), id = ele.val(), rate = ele.data('rate'),
 			tax_amount = roundNumber(rate * price * 0.01, 2);

 			$('.tax-modal-open').prepend('<p class="badge badge-light badge-sm badge-pill">'+
 				name+
 				'<input type="text" class="single-tax-price" name="purchase[items]['+count+'][tax]['+index+'][tax_price]" value="'+tax_amount+'" readonly>'+
 				'<input type="hidden" class="invoice-tax-id" name="purchase[items]['+count+'][tax]['+index+'][id]" value="'+id+'">'+ 
 				'<input type="hidden" name="purchase[items]['+count+'][tax]['+index+'][name]" value="'+name+'">' +
 				'<input type="hidden" class="invoice-tax-rate" name="purchase[items]['+count+'][tax]['+index+'][rate]" value="' +rate+'">' +
 				'</p>');
 		});
 		updatePrice();
 		$('.tax-modal-open').removeClass('tax-modal-open');
 		$('#addTax').modal('hide')
 	});

 	$('.purchase-items').on('click', '.add-items', function () {
 		if($(".item-row").length === 0) {
 			item_html(0);
 		} else {
 			var count = $('.purchase-items table tr.item-row:last .item-name').attr('name').split('[')[2];
 			count = parseInt(count.split(']')[0]) + 1;
 			item_html(count);
 		}
 		initAutocomplete();
 		initDatepicker();
 		bind();
 	});

 	$('.purchase-items').on('click', '.delete', function () {
 		var ele = $(this);
 		ele.parents('.item-row').remove();
 		bind();
 		return false;
 	});

 	initAutocomplete();
 	initDatepicker();
 	bind();
 });