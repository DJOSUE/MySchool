/**
 * admin_calendar.js by @guateapps.
 * Copyright 2022 Guate Apps.
 */
'use strict';

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('admin_calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        initialDate: new Date(),
        editable: true,
        navLinks: true,
        initialView: window.mobilecheck() ? "list" : "dayGridMonth",
        displayEventTime: true,
        eventTimeFormat: {
            hour: 'numeric',
            minute: '2-digit',
            meridiem: 'short'
        },
        displayEventEnd: true,
        selectable: true,
        buttonText: {
            today: today,
            month: month,
            week: week,
            day: day,
            list: list
        },
        dayMaxEvents: true,
        locale: locale,
        events: {
            url: rootAppURI + 'calendar/getEvents',
            failure: function() {}
        },
        eventClick: function(info, element) {
            var event = info.event;
            $('#ModalEdit #id').val(event.id);
            $('#ModalEdit #title').val(event.title);
            $('#ModalEdit #colore').val(event.classNames);
            $('#ModalEdit').modal('show');
        },
        eventDrop: function(info) {
            edit(info.event);
        },
        eventResize: function(info) {
            edit(info.event);
        },
        loading: function(bool) {},
        select: function(start, end) {
            $('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
            $('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
            $('#ModalAdd').modal('show');
        },
    });
    calendar.render();

    function edit(event) {
        var start = moment(event.start).format('YYYY-MM-DD HH:mm:ss');
        if (event.end) {
            var end = moment(event.end).format('YYYY-MM-DD HH:mm:ss');
        } else {
            var end = start;
        }
        var id = event.id;
        Event = [];
        Event[0] = id;
        Event[1] = start;
        Event[2] = end;
        $.ajax({
            url: rootAppURI + 'admin/calendar/update_date/',
            type: "POST",
            data: { Event: Event },
            success: function(rep) {
                if (rep == 'OK') {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 8000
                    });
                    Toast.fire({
                        icon: 'success',
                        title: updated
                    })
                } else {
                    alert('Error update');
                }
            }
        });
    }
});