    /**
        * parent_panel.js by @guateapps.
        * Copyright 2022 Guate Apps.
    */
     'use strict';
    
     function vote(poll_code)
     {
         var answer = $('input[name=answer'+poll_code+']:checked').val();
         if(answer)
         {
             $.ajax({url: rootAppURI+"parents/polls/response/",type:'POST',data:{answer:answer,poll_code:poll_code},success:function(result)
             {
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
             }});
         }else{
             alert(option);
         }
     }
     
     
     $("html").on("mouseup", function (e) {
         var l = $(e.target);
         if (l[0].className.indexOf("popover") == -1) {
             $(".popover").each(function () {
                 $(this).popover("hide");
             });
         }
     });
     
     $("#add").on('click',function()
     {
           var message = $("#message").val();
           var report_code = $("#report_code").val();
           if(message)
           {
               $.ajax({url:rootAppURI+"parents/student_report/response/",type:'POST',data:{message:message,report_code:report_code},success:function(result)
               {
                 $('#panel').load(document.URL + ' #panel');
                 $("#message").val('');
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
             }});
           }
     });