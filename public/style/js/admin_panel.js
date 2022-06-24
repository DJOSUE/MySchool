/**
 * admin_panel.js by @guateapps.
 * Copyright 2022 Guate Apps.
 */
'use strict';

graph(0, 0);
reqExpense();

function textAreaAdjust(o) {
    o.style.height = "1px";
    o.style.height = (25 + o.scrollHeight) + "px";
}

var blank_student_entry = '';
$(document).ready(function() {
    blank_student_entry = $('#student_entry').html();
    for (var i = 1; i < 1; i++) {
        $("#student_entry").append(blank_student_entry);
    }
});

function append_student_entry() {
    $("#student_entry_append").append(blank_student_entry);
}

function deleteParentElement(n) {
    n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
}

if (window.FileReader) {
    var reader = new FileReader(),
        rFilter = /^(image\/bmp|image\/cis-cod|image\/gif|image\/ief|image\/jpeg|image\/jpeg|image\/jpeg|image\/pipeg|image\/png|image\/svg\+xml|image\/tiff|image\/x-cmu-raster|image\/x-cmx|image\/x-icon|image\/x-portable-anymap|image\/x-portable-bitmap|image\/x-portable-graymap|image\/x-portable-pixmap|image\/x-rgb|image\/x-xbitmap|image\/x-xpixmap|image\/x-xwindowdump)$/i;
    reader.onload = function(oFREvent) {
        $("#logoPreview").show();
        var lgpreview = document.getElementById("logoPreview");
        lgpreview.src = oFREvent.target.result;
    };
} else {
    alert("Try using Chrome, Firefox or WebKit");
}

function imagePreview() {
    if (document.getElementById("userfile").files.length === 0) { return; }
    var file = document.getElementById("userfile").files[0];
    if (!rFilter.test(file.type)) { alert("You must select a valid image file!"); return; }
    reader.readAsDataURL(file);
}

function post() {
    $("#new_post").removeClass("hidde");
    $("#new_post").show(500);
    $("#new_poll").hide(500);
    $("#new_video").hide(500);
}

function poll() {
    $("#new_poll").removeClass("hidde");
    $("#new_post").hide(500);
    $("#new_video").hide(500);
    $("#new_poll").show(500);
}

function video() {
    $("#new_video").removeClass("hidde");
    $("#new_post").hide(500);
    $("#new_poll").hide(500);
    $("#new_video").show(500);
}

function reqExpense() {
    $.ajax({
        url: rootAppURI + 'admin/get_expense/',
        type: 'POST',
        success: function(res) {
            reqPayments(res);
        }
    });
}

function reqPayments(res) {
    $.ajax({
        url: rootAppURI + 'admin/get_payments/',
        type: 'POST',
        success: function(response) {
            graph(res, response);
        }
    });
}

function graph(res, pay) {
    var ctx = document.getElementById('myChart');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: [expense, income],
            datasets: [{
                label: '',
                data: [res, pay],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(153, 191, 45, 0.7)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(153, 191, 45, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: !0,
                        userCallback: function(value, index, values) {
                            value = value.toString();
                            value = value.split(/(?=(?:...)*$)/);
                            value = value.join('.');
                            return '$' + value;
                        }
                    }
                }]
            },
            tooltips: {
                mode: 'label',
                label: 'mylabel',
                callbacks: {
                    label: function(tooltipItem, data) {
                        var value = Number(data.datasets[0].data[tooltipItem.index]).toFixed(2);
                        return '$' + number_format(value);
                    },
                },
            }
        }
    });
}

function number_format(number, decimals, dec_point, thousands_point) {
    if (number == null || !isFinite(number)) {
        throw new TypeError("number is not valid");
    }
    if (!decimals) {
        var len = number.toString().split('.').length;
        decimals = len > 1 ? len : 0;
    }
    if (!dec_point) {
        dec_point = '.';
    }
    if (!thousands_point) {
        thousands_point = ',';
    }
    number = parseFloat(number).toFixed(decimals);
    number = number.replace(".", dec_point);
    var splitNum = number.split(dec_point);
    splitNum[0] = splitNum[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_point);
    number = splitNum.join(dec_point);
    return number;
}

function vote(poll_code) {
    var answer = $('input[name=answer' + poll_code + ']:checked').val();
    if (answer) {
        $.ajax({
            url: rootAppURI + "admin/polls/response/",
            type: 'POST',
            data: { answer: answer, poll_code: poll_code },
            success: function(result) {
                $('#panel').load(document.URL + ' #panel');
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 8000
                });
                Toast.fire({
                    icon: 'success',
                    title: thanks
                })
            }
        });
    } else {
        alert(option);
    }
}

function getId(url) {
    var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
    var match = url.match(regExp);
    if (match && match[2].length == 11) {
        return match[2];
    } else {
        return 'error';
    }
}

function set_video() {
    var Id = getId($("#url").val());
    $('#myCode').html('<br><iframe width="560" height="315" src="//www.youtube.com/embed/' + Id + '" frameborder="0" allowfullscreen></iframe>');
    $("#embed").val('//www.youtube.com/embed/' + Id);
    $("#myCode").removeClass("hidde");
    $("#myCode").show(500);
}