/**
    * modal_validation.js by @guateapps.
    * Copyright 2022 Guate Apps.
*/
'use strict';
    
$("#email").keyup(function(e){
    var query = $("#email").val();
    $("#result_email").queue(function(n) {                     
    $.ajax({
            type: "POST",
            url: rootAppURI+'register/search_email',
            data: "c="+query,
            dataType: "html",
            error: function(){
                alert("¡Error!");
            },
            success: function(data)
            { 
                if (data == "success") 
                {            
                    var texto = "<b class='red'>"+exist+"</b>"; 
                    $("#result_email").html(texto);
                    $('#sub_form').attr('disabled','disabled');
                }
                else { 
                    var texto = ""; 
                    $("#result_email").html(texto);
                    $('#sub_form').removeAttr('disabled');
                }
                n();
            }
        });                           
     });                       
});            
    
$('.clockpicker').clockpicker({
    placement: 'top',
    align: 'left',
    donetext: 'Done'
});

jscolor.installByClassName("jscolor");