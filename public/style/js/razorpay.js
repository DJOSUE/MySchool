    /**
        * razorpay.js by @guateapps.
        * Copyright 2022 Guate Apps.
    */
     'use strict';
     var options = {
         key:            razorKey,
         amount:         razorTotal,
         name:           razorName,
         description:    razorDesc,
         netbanking:     true,
         currency:       razorCurrency,
         prefill: {
             name:       razorName,
             email:      razorEmail,
             contact:    razorContact
         },
         notes: {
             soolegal_order_id: razorOid,
         },
         handler: function (transaction) {
             document.getElementById('razorpay_payment_id').value = transaction.razorpay_payment_id;
             document.getElementById('razorpay-form').submit();
         },
         "modal": {
             "ondismiss": function(){
                 location.reload()
             }
         }
     };
     var razorpay_pay_btn, instance;
     function razorpaySubmit(el) {
         if(typeof Razorpay == 'undefined') {
             setTimeout(razorpaySubmit, 200);
             if(!razorpay_pay_btn && el) {
                 razorpay_pay_btn    = el;
                 el.disabled         = true;
                 el.value            = razorWait;  
             }
         } else {
             if(!instance) {
                 instance = new Razorpay(options);
                 if(razorpay_pay_btn) {
                 razorpay_pay_btn.disabled   = false;
                 razorpay_pay_btn.value      = razorNow;
                 }
             }
             instance.open();
         }
     }  