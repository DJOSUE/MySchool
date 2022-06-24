    /**
     * exam_script.js by @guateapps.
     * Copyright 2022 Guate Apps.
     */
    'use strict';

    var totalP = $("#totalP").val();

    $('#pagination-demo').twbsPagination({
        totalPages: totalP,
        startPage: 1,
        visiblePages: 5,
        initiateStartPageClick: true,
        href: false,
        hrefVariable: '{{number}}',
        first: 'First',
        prev: 'Previous',
        next: 'Next',
        last: 'Last',
        loop: false,
        onPageClick: function(event, page) {
            $('.page-active').removeClass('page-active');
            $('#page' + page).addClass('page-active');
        },
        paginationClass: 'pagination',
        nextClass: 'next',
        prevClass: 'prev',
        lastClass: 'last',
        firstClass: 'first',
        pageClass: 'pages',
        activeClass: 'active sactive',
        disabledClass: 'disabled'
    });

    var timer_starting_hour = $("#totalH").val();
    document.getElementById("hour_timer").innerHTML = timer_starting_hour;
    var timer_starting_minute = $("#totalM").val();
    document.getElementById("minute_timer").innerHTML = timer_starting_minute;
    var timer_starting_second = $("#totalS").val();
    document.getElementById("second_timer").innerHTML = timer_starting_second;
    var timer = timer_starting_second;
    var mytimer = setInterval(function() { run_timer() }, 1000);

    function run_timer() {
        if (timer == 0 && timer_starting_minute == 0 && timer_starting_hour == 0) {
            $("#answer_script").submit();
        } else {
            timer--;
            if (timer < 0) {
                timer = 59;
                timer_starting_minute--;
                if (timer_starting_minute >= 0) {
                    document.getElementById("minute_timer").innerHTML = timer_starting_minute;
                }
            }
            if (timer_starting_minute < 0) {
                timer_starting_minute = 59;
                document.getElementById("minute_timer").innerHTML = timer_starting_minute;
                timer_starting_hour--;
                document.getElementById("hour_timer").innerHTML = timer_starting_hour;
            }
            document.getElementById("second_timer").innerHTML = timer;
        }
    }