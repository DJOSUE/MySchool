    /**
     * accountant_panel.js by @guateapps.
     * Copyright 2022 Guate Apps.
     */
    'use strict';

    graph(0, 0);
    reqExpense();

    function reqExpense() {
        $.ajax({
            url: rootAppURI + 'accountant/get_expense/',
            type: 'POST',
            success: function(res) {
                reqPayments(res);
            }
        });
    }

    function reqPayments(res) {
        $.ajax({
            url: rootAppURI + 'accountant/get_payments/',
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
                url: rootAppURI + "accountant/polls/response/",
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