'use strict';

function is_display_type(display_type) {
    return $('.display-type').css('content') == display_type || $('.display-type').css('content') == '"' + display_type + '"';
}

function not_display_type(display_type) {
    return $('.display-type').css('content') != display_type && $('.display-type').css('content') != '"' + display_type + '"';
}

function os_init_sub_menus() {
    var menu_timer;
    $('.menu-activated-on-hover').on('mouseenter', 'ul.main-menu > li.has-sub-menu', function() {
        var $elem = $(this);
        clearTimeout(menu_timer);
        $elem.closest('ul').addClass('has-active').find('> li').removeClass('active');
        $elem.addClass('active');
    });

    $('.menu-activated-on-hover').on('mouseleave', 'ul.main-menu > li.has-sub-menu', function() {
        var $elem = $(this);
        menu_timer = setTimeout(function() {
            $elem.removeClass('active').closest('ul').removeClass('has-active');
        }, 30);
    });

    $('.menu-activated-on-click').on('click', 'li.has-sub-menu > a', function(event) {
        var $elem = $(this).closest('li');
        if ($elem.hasClass('active')) {
            $elem.removeClass('active');
        } else {
            $elem.closest('ul').find('li.active').removeClass('active');
            $elem.addClass('active');
        }
        return false;
    });
}

$(function() {

    if ($('#formValidate').length) {
        $('#formValidate').validator();
    }

    if ($('#formValidate').length) {
        $('#formValidate').validator();
    }
    if ($('#dataTable1').length) {
        $('#dataTable1').DataTable({ buttons: ['copy', 'excel', 'pdf'] });
    }

    $('.step-trigger-btn').on('click', function() {
        var btn_href = $(this).attr('href');
        $('.step-trigger[href="' + btn_href + '"]').click();
        return false;
    });

    $('.step-trigger').on('click', function() {
        var prev_trigger = $(this).prev('.step-trigger');
        if (prev_trigger.length && !prev_trigger.hasClass('active') && !prev_trigger.hasClass('complete')) return false;
        var content_id = $(this).attr('href');
        $(this).closest('.step-triggers').find('.step-trigger').removeClass('active');
        $(this).prev('.step-trigger').addClass('complete');
        $(this).addClass('active');
        $('.step-content').removeClass('active');
        $('.step-content' + content_id).addClass('active');
        return false;
    });

    $('.book-trigger-btn').on('click', function() {
        var btn_href = $(this).attr('href');
        $('.book-trigger[href="' + btn_href + '"]').click();
        return false;
    });

    $('.book-trigger').on('click', function() {
        var prev_trigger = $(this).prev('.book-trigger');
        if (prev_trigger.length && !prev_trigger.hasClass('active') && !prev_trigger.hasClass('complete')) return false;
        var content_id = $(this).attr('href');
        $(this).closest('.book-triggers').find('.book-trigger').removeClass('active');
        $(this).prev('.book-trigger').addClass('complete');
        $('.book-trigger').removeClass('active');
        $(this).addClass('active');
        $('.book-content').removeClass('active');
        $('.book-content' + content_id).addClass('active');
        return false;
    });

    if ($('.select2').length) {
        $('.select2').select2();
    }

    if ($('#ckeditor1').length) {
        CKEDITOR.replace('ckeditor1');
    }

    $('.mobile-menu-trigger').on('click', function() {
        $('.menu-mobile .menu-and-user').slideToggle(200, 'swing');
        return false;
    });
    os_init_sub_menus();
    $('.content-panel-toggler, .content-panel-close, .content-panel-open').on('click', function() {
        $('.all-wrapper').toggleClass('content-panel-active');
    });

    $('.ae-list').perfectScrollbar({ wheelPropagation: true });

    $('.ae-list .ae-item').on('click', function() {
        $('.ae-item.active').removeClass('active');
        $(this).addClass('active');
        return false;
    });

    $('.ae-side-menu-toggler').on('click', function() {
        $('.app-email-w').toggleClass('compact-side-menu');
    });

    $('.ae-item').on('click', function() {
        $('.app-email-w').addClass('forse-show-content');
    });

    if ($('.app-email-w').length) {
        if (is_display_type('phone') || is_display_type('tablet')) {
            $('.app-email-w').addClass('compact-side-menu');
        }
    }

    $('.os-dropdown-trigger').on('mouseenter', function() {
        $(this).addClass('over');
    });
    $('.os-dropdown-trigger').on('mouseleave', function() {
        $(this).removeClass('over');
    });

    $('[data-toggle="tooltip"]').tooltip();

    $('[data-toggle="popover"]').popover();

    $('.fs-selector-trigger').on('click', function() {
        $(this).closest('.fancy-selector-w').toggleClass('opened');
    });

    $('.close-ticket-info').on('click', function() {
        $('.support-ticket-content-w').addClass('folded-info').removeClass('force-show-folded-info');
        return false;
    });

    $('.show-ticket-info').on('click', function() {
        $('.support-ticket-content-w').removeClass('folded-info').addClass('force-show-folded-info');
        return false;
    });

    $('.support-index .support-tickets .support-ticket').on('click', function() {
        $('.support-index').addClass('show-ticket-content');
        return false;
    });

    $('.support-index .back-to-index').on('click', function() {
        $('.support-index').removeClass('show-ticket-content');
        return false;
    });

    $('.chat-content-w').perfectScrollbar({ wheelPropagation: true });

    $('.element-action-fold').on('click', function() {
        var $wrapper = $(this).closest('.element-wrapper');
        $wrapper.find('.element-box-tp, .element-box').toggle(0);
        var $icon = $(this).find('i');

        if ($wrapper.hasClass('folded')) {
            $icon.removeClass('os-icon-plus-circle').addClass('os-icon-minus-circle');
            $wrapper.removeClass('folded');
        } else {
            $icon.removeClass('os-icon-minus-circle').addClass('os-icon-plus-circle');
            $wrapper.addClass('folded');
        }
        return false;
    });
});