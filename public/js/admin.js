/**
 * Admin JS - admin js for Drug Store theme
 * @version v1.0
 * @copyright 2020 Pepdev.
 */
 Dropzone.autoDiscover = false;
 $(document).ready(function () {
    "use strict";
    var path = $('.site_url').val();

    //********************************************
    //Data-Title Tool tip bootstrap **************
    //********************************************
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover()

    //*************************************************
    //Left Side menu  *********************************
    //*************************************************
    $('body').on('click', '.menu-close', function () {
        var ele = $(this);
        $('#main-wrapper').addClass('page-menu-small');
        ele.find('i').removeClass('fa-hand-point-left');
        ele.find('i').addClass('fa-hand-point-right');
        ele.removeClass('menu-close');
        ele.addClass('menu-open');
    });

    $('body').on('click', '.menu-open', function () {
        var ele = $(this);
        $('#main-wrapper').removeClass('page-menu-small');
        ele.find('i').removeClass('fa-hand-point-right');
        ele.find('i').addClass('fa-hand-point-left');
        ele.removeClass('menu-open');
        ele.addClass('menu-close');
    });

    if ($('.page-search input').length) {
        $(".page-search input").autocomplete({
            source: path.concat('customer/search'),
            minLength: 2,
            focus: function() {
                return false;
            },
            select: function(event, ui) {
                window.location.href = $('.site_url').val().concat('customer/view&id='+ui.item.id);
                return false;
            }
        }).autocomplete( "instance" )._renderItem = function( ul, item ) {
            return $( "<li>" )
            .append('<div>' + item.label + '<div class="font-12"> ( ' + item.email + ' )</div><div class="font-12"> ( ' + item.mobile + ' )</div></div>')
            .appendTo( ul );
        };
    }

    if ($('.customer-name').length) {
        $(".customer-name").autocomplete({
            source: path.concat('customer/search'),
            minLength: 2,
            focus: function() {return false;},
            select: function( event, ui ) {
                $('.customer-id').val(ui.item.id);
                $('.customer-name').val(ui.item.label);
                $('.customer-mail').val(ui.item.email);
                $('.customer-mobile').val(ui.item.mobile);
                return false;
            }
        }).autocomplete( "instance" )._renderItem = function( ul, item ) {
            return $( "<li>" )
            .append('<div>' + item.label + '<div class="font-12"> ( ' + item.email + ' )</div><div class="font-12"> ( ' + item.mobile + ' )</div></div>')
            .appendTo( ul );
        };
    }

    //Left side Sub Menu
    $('body').on('click', 'li.has-sub > a', function () {
        var ele = $(this), target = ele.parent('li.has-sub').find('ul.sub-menu:first');
        ele.parent('li.has-sub').siblings('li').find('a .arrow').removeClass('rotate');
        if (target.css('display') === "none") {
            ele.parent('li.has-sub').siblings('li').find('.sub-menu').slideUp();
            ele.find('.arrow').addClass('rotate');
            target.slideDown();
        } else {
            ele.parent('li.has-sub').find('.arrow').removeClass('rotate');
            ele.parent('li.has-sub').find('ul.sub-menu').slideUp();
        }
        return false;
    });

    //Open Left Side Menu in mobile
    $('body').on('click', '.open-left-menu', function () {
        var ele = $('.menu-wrapper'), nav_ele = $('.navbar-container');
        $('body').append('<div class="menu-overlay"></div>');
        ele.addClass('menu-mobile-open');
        nav_ele.addClass('menu-mobile-open');
    });
    //Close Left Side Menu in mobile
    $('body').on('click', '.menu-overlay', function () {
        $('.menu-wrapper, .navbar-container').removeClass('menu-mobile-open');
        $('.menu-overlay').remove();
    });


    function openSideNav() {
        $('body').addClass('sidenav-active');
        $('.sidenav').css('right', '0');
    }

    function closeSideNav() {
        $('.sidenav').css('right', '-60%');
        $('body').removeClass('sidenav-active');
    }

    //Open Page hdr right menu in Mobile
    $('body').on('click', '.open-page-menu-desktop', function () {
        var ele = $('.page-hdr-desktop');
        $('.page-search').slideUp(300);
        if (ele.css('display') === "none") {
            ele.slideDown(300);
        } else {
            ele.slideUp(300);
        }
    });
    //Open Page search in mobile
    $('body').on('click', '.open-mobile-search', function () {
        var ele = $('.page-search');
        $('.page-hdr-desktop').slideUp(300);
        if (ele.css('display') === "none") {
            ele.slideDown(300);
        } else {
            ele.slideUp(300);
        }
    });

    //*************************************************
    //Perfect Scrollbar  ******************************
    //************************************************* 
    if ($('.menu-fixed').length > 0 && $('.menu-wrapper').length > 0) {
        new PerfectScrollbar('.menu-fixed .menu-wrapper .menu ul', {
            wheelSpeed: 2,
            minScrollbarLength: 20
        });
    }

    //********************************************
    //Delete Item From List **********************
    //********************************************
    $('.table-delete').click(function () {
        $('.delete-card-button input.delete-id').val($(this).find('input').val());
        $("#delete-card").modal({
            keyboard: true
        });
    });

    $('#delete-card').on('hidden.bs.modal', function (e) {
        $('.delete-card-button input.delete-id').val('');
    });

    //********************************************
    //Image  Uplaod ******************************
    //********************************************
    $('#media-upload').on('show.bs.modal', function (e) {
        var uploaded = $('#media-upload .uploaded');
        if (uploaded.val() === '0') {
            var path = $('.site_url').val().concat('get/media');
            $.ajax({
                type: 'get',
                url: path,
                data: { name: 'media', _token: $('.s_token').val() },
                error: function () {},
                success: function (response) {
                    $('#media-upload .media-all').append(response);
                    uploaded.val('1');
                }
            });
        }
        $('#media-upload .media-all').addClass('media-modal-open');
    });

    $('.image-upload').click(function () {
        $(this).parent().addClass('image-upload-progress');
        $("#media-upload").modal('show');
    });

    $("#media-upload").on('hidden.bs.modal', function () {
        $(this).parent().find('.image-upload-progress').removeClass('image-upload-progress');
        $('#media-upload .media-all').removeClass('media-modal-open');
    });

    //Dropzone.autoDiscover = false;
    $("#media-dropzone").dropzone({
        addRemoveLinks: false,
        acceptedFiles: "image/*",
        maxFilesize: 5,
        autoProcessQueue: true,
        dictDefaultMessage: 'Drop files here or click here to upload <br /><br /> Only Image',
        init: function() {
            var reportDropzone = this;
            reportDropzone.on("sending", function(file, xhr, formData) {
                formData.append("_token", $('.s_token').val());
            });

            reportDropzone.on("success", function(file, xhr) {
                var response = JSON.parse(xhr);
                if (response.error === false) {
                    $('.media-all').prepend(response.media);
                    toastr.success('Uploaded Succefully', 'Report uploaded Succefully.');
                } else {
                    toastr.error('Error', response.message);
                }
                reportDropzone.removeFile(file);
            });

            reportDropzone.on("error", function(file, message) { 
                toastr.error('Error', message);
                reportDropzone.removeFile(file); 
            });
        },
    });

    $('#media-upload').on('click', '.media-modal-open .picture', function () {
        var image = $(this).find('input').val();
        $('.image-upload-progress .saved-picture').append('<img src="public/uploads/' + image + '" alt="">');
        $('.image-upload-progress .saved-picture input[type=hidden]').val(image);
        $('.image-upload-progress .saved-picture').show();
        $('.image-upload-progress .image-upload').hide();
        $('.image-upload-progress .saved-picture-delete').show();
        $('.content-input').removeClass('image-upload-progress');
        $('#media-upload').modal('hide');
    });

    //Image Delete 
    $('.media-all').on('click', '.block .remove', function () {
        var ele = $(this), ele_par = ele.parent(),
        media = ele_par.find('.picture input').val(),
        id = ele_par.find('.block-id').val();
        $.ajax({
            method: "POST",
            url: path.concat('media/delete'),
            data: { page: 'media', name: media, id: id, _token: $('.s_token').val() },
            error: function () {
                alert('Sorry Try Again!');
            },
            success: function (response) {
                response = JSON.parse(response);
                if (response.error === false) {
                    ele.parents('.block').remove();
                    toastr.success('Deleted', 'File deleted Succefully.');
                } else {
                    toastr.success('Wanrning', 'File could not be deleted!.');
                }
            }
        });
    });

    $('.saved-picture-delete').click(function () {
        $(this).siblings('.saved-picture').find('img').remove();
        $(this).siblings('.saved-picture').find('input').val('');
        $(this).siblings('.saved-picture').hide();
        $(this).siblings('.image-upload').show();
        $(this).hide();
    });


    $("#attach-file-upload").dropzone({
        addRemoveLinks: true,
        acceptedFiles: "image/*,application/pdf",
        maxFilesize: 2,
        dictDefaultMessage: 'Drop files here or click here to upload.<br /><br /> Only Image and PDF allowed.',
        init: function() {
            var attachmentDropzone = this;
            
            this.on("success", function(file, xhr){
                var response = JSON.parse(xhr);
                if (response.error === false) {
                    $('.attachment-container').append(response.media);
                    toastr.success('File uploaded successfully.', 'Success');
                    $('#attach-file').modal('hide');
                } else {
                    toastr.error(response.message, 'Error');
                }
                attachmentDropzone.removeFile(file);
            });
        }
    });

    $('.attachment-container').on('click', '.attachment-delete a', function () {
        var ele = $(this),
        name = ele.parents('.attachment-image').find('input').val(),
        id = $('#attach-file #attach-file-upload').find('input[name=id]').val(),
        type = $('#attach-file #attach-file-upload').find('input[name=type]').val();
        $.ajax({
            type: 'POST',
            url: 'index.php?route=attach/documents/delete',
            data: {name: name, type: type, id: id, _token: $('.s_token').val()},
            error: function() {
                toastr.error('File could not be deleted', 'Server Error');
            },
            success: function(response) {
                response = JSON.parse(response);
                if (response.error === false) {
                    ele.parents('.attachment-image').remove();
                    toastr.success(response.message, 'Success');
                } else {
                    toastr.error(response.message, 'Error');
                }
            }
        });
    });



    //********************************************
    //Admin Panel Left Side Menu *****************
    //********************************************
    //Left side Sub Menu 
    $('.menu-dropdown').click(function () {
        var ele = $(this);
        if (ele.siblings('.sub-menu').css('display') === 'none') {
            $('.sub-menu').slideUp();
            $('#menu-menu ul a').removeClass('menu-arrow-rotate');
            ele.addClass('menu-arrow-rotate');
            ele.siblings('.sub-menu').slideDown(200);
        } else {
            ele.removeClass('menu-arrow-rotate');
            $('.sub-menu').slideUp(200);
        }
    });


    //*************************************************
    //ThemeAccordion **********************************
    //*************************************************
    $('.theme-accordion:nth-child(1) .theme-accordion-bdy').slideDown();
    $('.theme-accordion:nth-child(1) .theme-accordion-control i').addClass('ti-minus');
    $('body').on('click', '.theme-accordion-hdr', function () {
        var ele = $(this);
        $('.theme-accordion-bdy').slideUp();
        $('.theme-accordion-control i').removeClass('ti-minus');
        if (ele.parents('.theme-accordion').find('.theme-accordion-bdy').css('display') === "none") {
            ele.find('.theme-accordion-control i').addClass('ti-minus');
            ele.parents('.theme-accordion').find('.theme-accordion-bdy').slideDown();
        } else {
            ele.find('.theme-accordion-control i').removeClass('ti-minus');
            ele.parents('.theme-accordion').find('.theme-accordion-bdy').slideUp();
        }
    });

    // Image Live Preview
    $('.adm-add-img p').click(function () {
        $('.adm-add-img img').remove();
        $('.adm-add-img').hide();
        $('#picture_container input[type=hidden]').val("");
        $('.picture').show();
    });


    //********************************************
    //Jaquery Ui Datepicker **********************
    //********************************************

    //User profile date picker
    $('#user-dob').datepicker({
        dateFormat: $('.common_date_format').val(),
        changeMonth: true,
        changeYear: true,
        yearRange: "-100:+0"
    });

    $('.dateofbirth').datepicker({
        dateFormat: $('.common_date_format').val(),
        changeMonth: true,
        changeYear: true,
        yearRange: "-100:+0"
    });


    //Filter date picker
    $('.filter-date').datepicker({
        dateFormat: $('.common_date_format').val()
    });

    //Filter date picker
    $('.date').datepicker({
        dateFormat: $('.common_date_format').val()
    });

    //********************************************
    //Date Range picker JS ***********************
    //********************************************
    if ($('.table-date-range').length) {
        var tabledate_data = $('.table-date-range').data();
        $('.table-date-range').daterangepicker({
            autoApply: false,
            alwaysShowCalendars: true,
            opens: 'left',
            applyButtonClasses: 'btn-danger',
            cancelClass: 'btn-white',
            locale: {
                format: $('.common_daterange_format').val(),
                separator: " => ",
            },
            startDate: tabledate_data.start,
            endDate: tabledate_data.end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'This Year': [moment().startOf('year'), moment().endOf('year')],
                'All Time': [moment('2015-01-01'), moment().add(1, 'days')],
            },
        });

        $('.table-date-range').on('apply.daterangepicker', function(ev, picker) {
            window.location.replace(path+tabledate_data.route+'&start='+picker.startDate.format('YYYY-MM-DD')+'&end='+picker.endDate.format('YYYY-MM-DD'));
        });
    }

    if ($('a.open-pdf').length) {
        $("a.open-pdf").fancybox({
            'frameWidth': 800,
            'frameHeight': 800,
            'overlayShow': true,
            'hideOnContentClick': false,
            'type': 'iframe'
        });
    }

    //New or Edit Epxense type Modal *************
    $('body').on('click', '.edit-expense-type', function () {
        var ele = $(this);
        $('#addExpenseModel input[name="name"]').val(ele.data("name"));
        $('#addExpenseModel textarea[name="description"]').val(ele.data("description"));
        $('#addExpenseModel input[name="id"]').val(ele.data("id"));
        $('#addExpenseModel select[name="status"]').val(ele.data("status"));
        $('#addExpenseModel .modal-title').text('Edit Expense Type');
        $('#addExpenseModel form').attr('action', $('.site_url').val().concat('expensetype/edit'));
        $('#addExpenseModel').modal('show');
    });
    $('#addExpenseModel').on('hidden.bs.modal', function (e) {
        $('#addExpenseModel .modal-title').text('New Expense Type');
        $('#addExpenseModel input').not( "[name='_token']" ).val('');
        $('#addExpenseModel textarea').val('');
        $('#addExpenseModel form').attr('action', $('.site_url').val().concat('expensetype/add'));
    });

    //New or Edit Payment type Modal *************
    $('body').on('click', '.edit-paymenttype', function () {
        var ele = $(this);
        $('#addPaymentType input[name="name"]').val(ele.data("name"));
        $('#addPaymentType input[name="id"]').val(ele.data("id"));
        $('#addPaymentType select[name="status"]').val(ele.data("status"));
        $('#addPaymentType .modal-title').text('Edit Payment Method');
        $('#addPaymentType form').attr('action', $('.site_url').val().concat('paymentmethod/edit'));
        $('#addPaymentType').modal('show');
    });
    $('#addPaymentType').on('hidden.bs.modal', function (e) {
        $('#addPaymentType .modal-title').text('New Payment Method');
        $('#addPaymentType input').not( "[name='_token']" ).val('');
        $('#addPaymentType textarea').val('');
        $('#addPaymentType form').attr('action', $('.site_url').val().concat('paymentmethod/add'));
    });

    //New or Edit Tax Modal *************
    $('body').on('click', '.edit-tax', function () {
        var ele = $(this);
        $('#addTax input[name="name"]').val(ele.data("name"));
        $('#addTax input[name="rate"]').val(ele.data("rate"));
        $('#addTax input[name="id"]').val(ele.data("id"));
        $('#addTax .modal-title').text('Edit Tax Rate');
        $('#addTax form').attr('action', $('.site_url').val().concat('tax/edit'));
        $('#addTax').modal('show');
    });
    $('#addTax').on('hidden.bs.modal', function (e) {
        $('#addTax .modal-title').text('New Tax Rate');
        $('#addTax input').not( "[name='_token']" ).val('');
        $('#addTax textarea').val('');
        $('#addTax form').attr('action', $('.site_url').val().concat('tax/add'));
    });

    //New or Edit Item Modal *************
    $('body').on('click', '.edit-item', function () {
        var ele = $(this);
        $('#addItem .name').val(ele.data("name"));
        $('#addItem .description').val(ele.data("description"));
        $('#addItem .price').val(ele.data("price"));
        $('#addItem .id').val(ele.data("id"));
        $('#addItem .modal-title').text('Edit Item');
        $('#addItem form').attr('action', $('.site_url').val().concat('item/edit'));
        $('#addItem').modal('show');
    });
    $('#addItem').on('hidden.bs.modal', function (e) {
        $('#addItem .modal-title').text('New Item');
        $('#addItem input').not( "[name='_token']" ).val('');
        $('#addItem form').attr('action', $('.site_url').val().concat('item/add'));
        $('#addItem textarea').val('');
    });

    //New or Edit Medicine Category Modal *************
    $('body').on('click', '.edit-mcategory', function () {
        var ele = $(this);
        var data = ele.data();
        $('#add-mcategory input[name="name"]').val(ele.data("name"));
        $('#add-mcategory input[name="id"]').val(ele.data("id"));
        $('#add-mcategory .modal-title').text('Edit Medicine Category');
        $('#add-mcategory form').attr('action', $('.site_url').val().concat('medicine/category/edit'));
        $('#add-mcategory').modal('show');
    });
    $('#add-mcategory').on('hidden.bs.modal', function (e) {
        $('#add-mcategory .modal-title').text('New Medicine Category');
        $('#add-mcategory input').not( "[name='_token']" ).val('');
        $('#add-mcategory textarea').val('');
        $('#add-mcategory form').attr('action', $('.site_url').val().concat('medicine/category/add'));
    });

    $("#uploadmedicine-modal").on('change', '#medicinefile', function(e) {
        if (e.target.files.length > 0) {
            $(this).siblings('label').text(e.target.files[0].name);
        }
    });

    //Stock table update modal
    $('.stock-table').on('click', '.edit-stock', function () {
        var ele = $(this), ele_parent = ele.parents('tr'),
        data = ele.data();
        $('#editstock-modal input[name="available"]').val(ele_parent.find('.available').text());
        $('#editstock-modal input[name="id"]').val(data.id);
        $('#editstock-modal input[name="medicine_id"]').val(data.medicineid);
        $('#editstock-modal .medicine').html(ele_parent.find('.medicine').text());
        $('#editstock-modal .batch').html(ele_parent.find('.batch').text());
        $('#editstock-modal .expiry').html(ele_parent.find('.expiry').text());
        $('#editstock-modal .qty').html(ele_parent.find('.qty').text());
        $('#editstock-modal .sold').html(ele_parent.find('.sold').text());
        $('#editstock-modal').modal('show');
    });

    $('#editstock-modal').on('hidden.bs.modal', function (e) {
        $('#editstock-modal input').not( "[name='_token']" ).val('');
    });

    //New or Edit supplier Modal *************
    $('body').on('click', '.edit-supplier', function () {
        var ele = $(this);
        var data = ele.data();
        $('#add-supplier input[name="name"]').val(ele.data("name"));
        $('#add-supplier input[name="email"]').val(ele.data("email"));
        $('#add-supplier input[name="phone"]').val(ele.data("phone"));
        $('#add-supplier textarea[name="address"]').val(ele.data("address"));
        $('#add-supplier input[name="id"]').val(ele.data("id"));
        $('#add-supplier .modal-title').text('Edit Supplier');
        $('#add-supplier form').attr('action', $('.site_url').val().concat('supplier/edit'));
        $('#add-supplier').modal('show');
    });

    $('#add-supplier').on('hidden.bs.modal', function (e) {
        $('#add-supplier .modal-title').text('New Supplier');
        $('#add-supplier input').not( "[name='_token']" ).val('');
        $('#add-supplier textarea').val('');
        $('#add-supplier form').attr('action', $('.site_url').val().concat('supplier/add'));
    });

    //Email User
    $('.send-user-type').on('change', function() {
        var ele = $(this), user = ele.find('option:selected').val(), receiver = $('select.send-receiver');
        $('.receiver-container .block').remove();
        $.ajax({
            method: "POST",
            url: "index.php?route=get/receiver",
            data: { user: user , _token: $('.s_token').val()},
            error: function () {
                alert('Sorry Try Again!');
            },
            success: function (response) {
                $.each(JSON.parse(response), function (key, value) {
                    if (value.id === 'all') {
                        $('.receiver-container').append('<div class="custom-control custom-checkbox block mb-3 receiver-all">'+
                            '<input type="checkbox" class="custom-control-input" id="receiver-'+value.id+'" value="'+value.id+'" checked>'+
                            '<label class="custom-control-label" for="receiver-'+value.id+'">'+value.name+'</label></div>');
                    } else {
                        $('.receiver-container').append('<div class="custom-control custom-checkbox block mb-3 receiver-single">'+
                            '<input type="checkbox" name="receiver[user][]" class="custom-control-input" id="receiver-'+value.id+'" value="'+value.id+'" checked>'+
                            '<label class="custom-control-label" for="receiver-'+value.id+'">'+value.name+'</label></div>');
                    }
                });
            }
        });
    });
    $('.receiver-container').on('change', '.receiver-all input', function () {
        var ele = $(this);
        if (ele.is(":checked")) {
            ele.parents('.receiver-container').find('input').prop("checked", true);
        } else {
            ele.parents('.receiver-container').find('input').prop("checked", false);
        }
    });
    $('.receiver-container').on('change', '.receiver-single input', function () {
        var ele = $(this);
        $('.receiver-container').find('.receiver-all input').prop("checked", false);
    });

    //Attendence 
    $('.attendence').datepicker({
        autoclose: true,
        dateFormat: $('.common_date_format').val(),
        startDate:'01-01-2019',
        endDate:'31-12-2019',
        onSelect: function (dateText, date) {
            if (dateText != '' && typeof dateText !== "undefined") {
                $('.attendence-container').removeClass('d-none');
                $('.date_pick input[name="day"]').val(date.currentDay);
                $('.date_pick input[name="month"]').val(date.currentMonth);
                $('.date_pick input[name="year"]').val(date.currentYear);
                $('.attendence-submit').removeClass('d-none');
            }
        }
    });

    $('.attendence-container').on('change', '.attendence-head', function() {
        var ele = $(this);
        if (ele.prop("checked") === true) {
            $('.attendence-container .attendence-'+ele.val()).prop("checked", true);
        }
        $('.attendence-container .attendence-head').not('#attendence-head-'+ele.val()).prop("checked", false);
    });

    if ($('.attendance-month').length) {
        $(".attendance-month").datepicker( {
            dateFormat: 'M yy',
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            beforeShow: function(input, inst) {
                inst.dpDiv.css({marginTop: '10px', marginLeft: -input.offsetWidth + 'px'});
            },
            onClose: function(dateText, inst) {
                var month = (inst.selectedMonth+1);
                month = (month < 10 ? "0"+month : month);
                var date = inst.selectedYear + '-' + month;
                if (date !== $('.range-month').val()) {
                    window.location.href = $('.site_url').val()+'staffattendance/view&id='+$('.staff-id').val()+'&monthyear='+date;
                }
            }
        });
    }

    //Email Log
    $('.table-action').on('click', '.log-message-view', function () {
        var ele = $(this), message = ele.data('message');
        $('#mailLogModal .log-message').append('<div class="message">'+message+'</div>');
        $('#mailLogModal').modal('show');
    });

    $('#mailLogModal').on('hidden.bs.modal', function (e) {
        $('#mailLogModal .log-message .message').remove();
    });

    //Mail Type
    $('body').on('change', 'select.mail-type', function () {
        if ($(this).val() == "2") { $('#smtp-mail').show(); }
        else { $('#smtp-mail').hide(); }
    });

    if ($('.report-credit-value').length && $('.report-debit-value').length) {
        $('.report-credit-value').text($('.report-statement-credit').val());
        $('.report-debit-value').text($('.report-statement-debit').val());
    }

    //********************************************
    //Listing Table ******************************
    //********************************************

    var dataTable = $('.datatable-table').DataTable({
        aLengthMenu: [[10, 25, 50, 75, -1], [10, 25, 50, 75, "All"]],
        iDisplayLength: 10,
        pagingType: 'full_numbers',
        order: [],
        dom: "<'row align-items-center pb-3'<'col-sm-6 text-left'l><'col-sm-6 text-right'f>><'row'<'col-sm-12'tr>><'row align-items-center pt-3'<'col-sm-12 col-md-4'i><'col-sm-12 col-md-8 text-right dataTables_pager'p>>",
        responsive: true,
        buttons: [
        {
            extend: 'print',
            autoPrint: true,
            customize: function (win) {
                $(win.document.body).find('h1').css('text-align','center');
                $(win.document.body).find('h1').css('font-size','20px');
            }
        },
        {
            extend: 'copyHtml5'
        },
        {
            extend: 'excelHtml5'
        },
        {
            extend: 'csvHtml5'
        }
        ],
        language: {
            "paginate": {
                "first":       '<i class="las la-angle-double-left"></i>',
                "previous":    '<i class="las la-angle-left"></i>',
                "next":        '<i class="las la-angle-right"></i>',
                "last":        '<i class="las la-angle-double-right"></i>'
            },
        }
    });

    var countdatatable = $('.datatable-count-table').DataTable({
        aLengthMenu: [[10, 25, 50, 75, -1], [10, 25, 50, 75, "All"]],
        iDisplayLength: 10,
        pagingType: 'full_numbers',
        order: [],
        dom: "<'row align-items-center pb-3'<'col-sm-6 text-left'l><'col-sm-6 text-right'f>><'row'<'col-sm-12'tr>><'row align-items-center pt-3'<'col-sm-12 col-md-4'i><'col-sm-12 col-md-8 text-right dataTables_pager'p>>",
        responsive: false,
        buttons: [
        {
            extend: 'print',
            autoPrint: true,
            exportOptions: {
                columns: ':visible'
            },
            customize: function (win) {
                $(win.document.body).find('h1').css('text-align','center');
                $(win.document.body).find('h1').css('font-size','20px');
            }
        },
        {
            extend: 'copyHtml5',
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'excelHtml5',
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'csvHtml5',
            exportOptions: {
                columns: ':visible'
            }
        }
        ],
        language: {
            "paginate": {
                "first":       '<i class="las la-angle-double-left"></i>',
                "previous":    '<i class="las la-angle-left"></i>',
                "next":        '<i class="las la-angle-right"></i>',
                "last":        '<i class="las la-angle-double-right"></i>'
            },
        },
        footerCallback: function ( row, data, start, end, display ) {

            var api = this.api(), data, column;
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                i.replace(/[\$,]/g, '')*1 :
                typeof i === 'number' ?
                i : 0;
            };

            for (var i = row.childElementCount - 1; i >= 0; i--) {
                if (i == 0 ) {
                    $( api.column(i).footer() ).html('Total');
                } else if (i > 0) {
                    column = api.column(i).data().reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    column = api.column( i, { page: 'current'} ).data().reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    if (column) {
                        $( api.column(i).footer() ).html($('.common_currency').val()+column.toFixed(2));
                    }
                }

            }
        }
    });

    $('.toggle-button a').on( 'click', function (e) {
        e.preventDefault();
        var ele = $(this);
        var column = countdatatable.column(ele.attr('data-column'));
        if (column.visible()) {
            ele.find('i').removeClass('la-toggle-on');
            ele.find('i').addClass('la-toggle-off');
        } else {
            ele.find('i').addClass('la-toggle-on');
            ele.find('i').removeClass('la-toggle-off');
        }
        column.visible(!column.visible());
    });

    $(".export-button .print").on("click", function(e) {
        e.preventDefault(); dataTable.button(0).trigger()
        countdatatable.button(0).trigger()
    });

    $(".export-button .copy").on("click", function(e) {
        e.preventDefault(); dataTable.button(1).trigger()
        countdatatable.button(1).trigger()
    });

    $(".export-button .excel").on("click", function(e) {
        e.preventDefault(); dataTable.button(2).trigger()
        countdatatable.button(2).trigger()
    });

    $(".export-button .csv").on("click", function(e) {
        e.preventDefault(); dataTable.button(3).trigger()
        countdatatable.button(3).trigger()
    });

    $(".export-button .pdf").on("click", function(e) {
        e.preventDefault(); dataTable.button(4).trigger()
        countdatatable.button(4).trigger()
    });

    $('body').on('change', 'input:radio[name=layout]', function () {
        var ele = $(this), ele_val = $(this).val();
        if (ele_val === "boxed") {
            $('.wrapper').addClass('boxed');
        } else {
            $('.wrapper').removeClass('boxed');
        }
    });

    $('body').on('change', 'input:radio[name=layout_fixed]', function () {
        var ele = $(this), ele_val = $(this).val();
        if (ele_val === "menu-fixed page-hdr-fixed") {
            $('#main-wrapper').addClass('menu-fixed page-hdr-fixed');
        } else {
            $('#main-wrapper').removeClass('menu-fixed page-hdr-fixed');
        }
    });

    $('body').on('change', 'input:checkbox[name=layout_menu]', function () {
        var ele = $(this), ele_val = $(this).val();
        if (ele.prop('checked') === true) {
            $('#main-wrapper').addClass('page-menu-small');
        } else {
            $('#main-wrapper').removeClass('page-menu-small');
        }
    });

    $('body').on('change', 'input:radio[name=side-menu]', function () {
        var ele = $(this), ele_val = $(this).val();
        if (ele_val === 'light') {
            $('#main-wrapper').addClass('menu-light');
        } else {
            $('#main-wrapper').removeClass('menu-light');
        }
    });

    $('body').on('change', 'input:radio[name=header-color]', function () {
        var ele = $(this), ele_val = $(this).val(), hdr = $('.page-hdr');
        hdr.removeClass('page-hdr-colored');
        hdr.removeClass('page-hdr-gradient');
        hdr.removeClass('bg-primary');
        hdr.removeClass('bg-success');
        hdr.removeClass('bg-secondary');
        hdr.removeClass('bg-warning');
        hdr.removeClass('bg-danger');
        hdr.removeClass('bg-info');
        hdr.removeClass('bg-dark');
        hdr.addClass(ele_val);
    });

    if ($('.alert-message').length) {
        var alert_message = JSON.parse($('.alert-message').val());
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "10000",
            "hideDuration": "10000",
            "timeOut": "2000",
            "extendedTimeOut": "800",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        toastr[alert_message.alert](alert_message.value, alert_message.alert);
    }
});



