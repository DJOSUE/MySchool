/**
    * payments.js by @guateapps.
    * Copyright 2022 Guate Apps.
*/
'use strict';
    
function get_class_sections(class_id) 
{ 
    $.ajax({
        url: rootAppURI+'admin/get_class_section/' + class_id ,
        success: function(response)
        {
            jQuery('#section_holder').html(response);
        }
    });
}

function select() 
{
    var chk = $('.check');
    for (i = 0; i < chk.length; i++) 
    {
        chk[i].checked = true ;
    }
}

function unselect() 
{
    var chk = $('.check');
    for (i = 0; i < chk.length; i++) {
        chk[i].checked = false ;
    }
}

var class_id = '';

function get_class_students_mass(class_id) {
    if (class_id !== '') {
    $.ajax({
        url: rootAppURI+'admin/get_class_students_mass/' + class_id ,
        success: function(response)
        {
            jQuery('#student_selection_holder_mass').html(response);
        }
    });
  }
}

function check_validation(){
    if (class_id !== '') {
        $('.submit').removeAttr('disabled');
    }
    else{
        $('.submit').attr('disabled', 'disabled');
    }
}

$('.class_id').on('change',function(){
    class_id = $('.class_id').val();
    check_validation();
});

function get_class_students_p(class_id) {
    $.ajax({
        url: rootAppURI+'admin/get_class_studentss/' + class_id ,
        success: function(response)
        {
            jQuery('#student_selection_holder').html(response);
        }
    });
}