    /**
        * student_panel.js by @guateapps.
        * Copyright 2022 Guate Apps.
    */
     'use strict';
    
     $(document).ready(function()
     {
         $("#add").on('click',function()
         {
             var message = $("#message").val();
             var post_code = $("#post_code").val();
             if(message)
             {
                 $.ajax({url:rootAppURI+"student/forum_message/add",type:'POST',data:{message:message,post_code:post_code},success:function(result)
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
                     });
                 }});
             }
         });
       });
       
     if(uriseg == 'homeworkroom' || uriseg == 'homework_edit')
     {
          $(document).ready(function() {
             $('input[name="files"]').fileuploader({
                 limit: 20,
                 maxSize: 50,
                 addMore: true,
                 thumbnails: {
                     onItemShow: function(item) {
                         item.html.find('.fileuploader-action-remove').before('<button type="button" class="fileuploader-action fileuploader-action-sort" title="Sort"><i class="fileuploader-icon-sort"></i></button>');
                     }
                 },
                 sorter: {
                     selectorExclude: null,
                     placeholder: null,
                     scrollContainer: window,
                     onSort: function(list, listEl, parentEl, newInputEl, inputEl) {
                     }
                 }
             });
         });
     }
     
     function vote(poll_code)
     {
         var answer = $('input[name=answer'+poll_code+']:checked').val();
         if(answer)
         {
             $.ajax({url: rootAppURI+"student/polls/response/",type:'POST',data:{answer:answer,poll_code:poll_code},success:function(result)
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