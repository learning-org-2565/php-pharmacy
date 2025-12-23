/**
 * Admin JS - admin js for Drug Store theme
 * @version v1.0
 * @copyright 2020 Pepdev.
 */
 Dropzone.autoDiscover = false;
 $(document).ready(function () {
    "use strict";
    var path = $('.site_url').val();

    //Theme Customizer
    $('body').prepend('<div class="setting-wrapper">' +
        '<div class="setting-handle"><i class="las la-cog text-white font-24"></i></div>' +
        '<div class="setting-container">' +
        '<div class="setting-layout">' +
        '<h5 class="text-left font-20 font-500">Layout</h5>' +
        '<div class="layout text-left ml-2">' +
        '<div class="custom-control custom-checkbox custom-checkbox-1 mb-3">' +
        '<input type="checkbox" class="custom-control-input" name="setting_layout" id="setting-layout-wide" value="wide">' +
        '<label class="custom-control-label font-12" for="setting-layout-wide">Wide Layout</label>' +
        '</div>' +
        '<div class="custom-control custom-checkbox custom-checkbox-1 mb-3">' +
        '<input type="checkbox" class="custom-control-input" name="setting_layout" id="setting-layout-boxed" value="boxed">' +
        '<label class="custom-control-label font-12" for="setting-layout-boxed">Boxed Layout</label>' +
        '</div>' +
        '<div class="custom-control custom-checkbox custom-checkbox-1 mb-3">' +
        '<input type="checkbox" class="custom-control-input" name="setting_layout" id="setting-layout-static" value="static">' +
        '<label class="custom-control-label font-12" for="setting-layout-static">Static Layout</label>' +
        '</div>' +
        '<div class="custom-control custom-checkbox custom-checkbox-1 mb-3">' +
        '<input type="checkbox" class="custom-control-input" name="setting_layout" id="setting-layout-fixed" value="fixed">' +
        '<label class="custom-control-label font-12" for="setting-layout-fixed">Fixed Layout</label>' +
        '</div>' +
        '<div class="custom-control custom-checkbox custom-checkbox-1 mb-3">' +
        '<input type="checkbox" class="custom-control-input" name="setting_layout" id="setting-layout-collapsed" value="collapsed" checked>' +
        '<label class="custom-control-label font-12" for="setting-layout-collapsed">Collapsed Menu</label>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '<div class="setting-menu-color">' +
        '<h5 class="text-left font-20 font-500">Menu Color</h5>' +
        '<div class="layout">' +
        '<a href="#" data-color="white">Light Menu</a>' +
        '<a href="#" data-color="Dark">Dark Menu</a>' +
        '</div>' +
        '</div>' +
        '<div class="setting-color text-left">' +
        '<h5 class="text-left font-20 font-500">Header Color</h5>' +
        '<h6 class="text-left font-16 font-500">With Light sidebar</h6>' +
        '<a data-menu="white" data-color="primary" style="background-color: #3483FF"></a>' +
        '<a data-menu="white" data-color="success" style="background-color: #0bc36e"></a>' +
        '<a data-menu="white" data-color="secondary" style="background-color: #282a3c"></a>' +
        '<a data-menu="white" data-color="warning" style="background-color: #fec107"></a>' +
        '<a data-menu="white" data-color="danger" style="background-color: #fb9678"></a>' +
        '<a data-menu="white" data-color="info" style="background-color: #03a9f3"></a>' +
        '<a data-menu="white" data-color="dark" style="background-color: #555"></a>' +
        '<h6 class="text-left font-16 font-500">With Dark sidebar</h6>' +
        '<a data-menu="dark" data-color="primary" style="background-color: #3483FF"></a>' +
        '<a data-menu="dark" data-color="success" style="background-color: #0bc36e"></a>' +
        '<a data-menu="dark" data-color="secondary" style="background-color: #282a3c"></a>' +
        '<a data-menu="dark" data-color="warning" style="background-color: #fec107"></a>' +
        '<a data-menu="dark" data-color="danger" style="background-color: #fb9678"></a>' +
        '<a data-menu="dark" data-color="info" style="background-color: #03a9f3"></a>' +
        '<a data-menu="dark" data-color="dark" style="background-color: #555"></a>' +
        '<h6 class="text-left font-16 font-500">With Gradient</h6>' +
        '<a data-menu="gradient" data-color="primary" class="gradient" style="background-color: #3483FF"></a>' +
        '<a data-menu="gradient" data-color="success" class="gradient" style="background-color: #0bc36e"></a>' +
        '<a data-menu="gradient" data-color="secondary" class="gradient" style="background-color: #282a3c"></a>' +
        '<a data-menu="gradient" data-color="warning" class="gradient" style="background-color: #fec107"></a>' +
        '<a data-menu="gradient" data-color="danger" class="gradient" style="background-color: #fb9678"></a>' +
        '<a data-menu="gradient" data-color="info" class="gradient" style="background-color: #03a9f3"></a>' +
        '<a data-menu="gradient" data-color="dark" class="gradient" style="background-color: #555"></a>' +
        '</div>' +
        '</div>' +
        '</div>');
    //
    $('.setting-handle').click(function () {
        var ele = $('.setting-wrapper');
        if (ele.css('right') === '0px') {
            ele.css('right', '-255px');
        } else {
            ele.css('right', '0');
        }
    });

    $('.setting-layout a').click(function (e) {
        e.preventDefault();
        var ele = $(this);
        $('.setting-layout a').removeClass('active');
        if (ele.data('layout') === 'boxed') {
            $('.wrapper').addClass('boxed');
            ele.addClass('active');
        } else {
            $('.wrapper').removeClass('boxed');
            ele.addClass('active');
        }   
    });

    $('body').on('click', '.setting-menu-color a', function (e) {
        e.preventDefault();
        var ele = $(this);
        $('.setting-menu-color a').removeClass('active');
        if (ele.data('color') === 'white') {
            $('#main-wrapper').addClass('menu-light');
            ele.addClass('active');
        } else {
            $('#main-wrapper').removeClass('menu-light');
            ele.addClass('active');
        }   
    });

    $('body').on('click', '.setting-color a', function (e) {
        e.preventDefault();
        var ele = $(this), 
        hdr = $('.page-hdr');
        hdr.removeClass('bg-primary');
        hdr.removeClass('bg-success');
        hdr.removeClass('bg-secondary');
        hdr.removeClass('bg-warning');
        hdr.removeClass('bg-danger');
        hdr.removeClass('bg-info');
        hdr.removeClass('bg-dark');
        hdr.removeClass('page-hdr-gradient');
        if (ele.data('menu') === 'white') {
            $('#main-wrapper').addClass('menu-light');
            hdr.addClass('page-hdr-colored');
            hdr.addClass('bg-' + ele.data('color'));
        }
        if (ele.data('menu') === 'gradient') {
            $('#main-wrapper').removeClass('menu-light');
            hdr.addClass('page-hdr-colored page-hdr-gradient');
            hdr.addClass('bg-' + ele.data('color'));
        }
        if (ele.data('menu') === 'dark') {
            $('#main-wrapper').removeClass('menu-light');
            hdr.addClass('page-hdr-colored');
            hdr.addClass('bg-' + ele.data('color'));
        }
    });

    if ($('.setting-wrapper').length > 0) {
        new PerfectScrollbar('.setting-container', {
            wheelSpeed: 2,
            minScrollbarLength: 20
        });
    }
    $("input[name='setting_layout']").change(function () {
        var ele = $(this), val = ele.val();

        if (val === "boxed") {
            $("#setting-layout-wide").prop("checked", false);
            $('.wrapper').addClass('boxed');
        }
        if (val === "wide") {
            $("#setting-layout-boxed").prop("checked", false);
            $('.wrapper').removeClass('boxed');
        } 
        if (val === "static") {
            $("#setting-layout-fixed").prop("checked", false);
            $('#main-wrapper').removeClass('menu-fixed');
            $('#main-wrapper').removeClass('page-hdr-fixed');
        }
        if (val === "collapsed") {
            $('#main-wrapper').addClass('page-menu-small');
        }
        if (val === "fixed") {
            $("#setting-layout-static").prop("checked", false);
            $('#main-wrapper').addClass('menu-fixed');
            $('#main-wrapper').addClass('page-hdr-fixed');
        }

        if (ele.attr('id') === "setting-layout-boxed" && ele.prop('checked') === false) {
            $("#setting-layout-wide").prop("checked", true);
            $('.wrapper').removeClass('boxed');
        }

        if (ele.attr('id') === "setting-layout-collapsed" && ele.prop('checked') === false) {
            $('#main-wrapper').removeClass('page-menu-small');
        }

        if (ele.attr('id') === "setting-layout-static" && ele.prop('checked') === false) {
            $('#main-wrapper').addClass('menu-fixed');
            $('#main-wrapper').addClass('page-hdr-fixed');
        }
    });

});