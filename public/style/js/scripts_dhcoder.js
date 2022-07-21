
/**
* scripts_dhcoder.js by @DHCoder.
* Copyright 2022 DHCoder.
*/
    'use strict';

    function showAjaxModal(url)
    {
        jQuery('#exampleModal .modal-body').html('<div class="text-center tp200"><img src="<?php echo base_url();?>public/assets/images/preloader.gif" /></div>');
        jQuery('#exampleModal').modal('show', {backdrop: 'true'});
        $.ajax({
            url: url,
            success: function(response)
            {
                jQuery('#exampleModal .modal-body').html(response);
            }
        });
    }

    window.mobilecheck = function() {
        var check = false;
        (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
        return check;
    };
    
    if(uriseg == 'calendar' && urig != 'admin')
    {
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                initialDate: new Date(),
                displayEventEnd: true,
                displayEventTime: true,
                eventTimeFormat: {
                  hour: 'numeric',
                  minute: '2-digit',
                  meridiem: 'short'
                },
                buttonText: {
                  today: today,
                  month: month,
                  week:  week,
                  day:   day,
                  list:  list
                },
                locale: locale,
                initialView: window.mobilecheck() ? "list" : "dayGridMonth",
                editable: false,
                navLinks: true,
                dayMaxEvents: true,
                events: {
                    url: rootAppURI+'calendar/getEvents',
                    failure: function() {}
                },
                loading: function(bool) {
                }
            });
            calendar.render();
        });
    }
    
    $(document).ready(function(){         
        var query;          
        $("#emailx").on('keyup', function(e){
            query = $("#emailx").val();
            $("#result_emailx").queue(function(n) {                     
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
                            $("#result_emailx").html(texto);
                            $('#sub_accountant').attr('disabled','disabled');
                        }
                        else { 
                            var texto = ""; 
                            $("#result_emailx").html(texto);
                            $('#sub_accountant').removeAttr('disabled');
                        }
                        n();
                    }
                });                           
            });                       
        });                       
    });
    
    window.onload=function()
    {      
        $("#filter").on('keyup', function() {
            var filter = $(this).val(),
            count = 0;
            $('#results div').each(function() {
                if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                    $(this).hide();
                } else {
                    $(this).show();
                    count++;
                }
            });
        });
    }
    
    $(document).ready(function(){         
        var query;          
        $("#user_accountant").on('keyup', function(e){
            query = $("#user_accountant").val();
            $("#result_accountant").queue(function(n) {                     
                $.ajax({
                    type: "POST",
                    url: rootAppURI+'register/search_user',
                    data: "c="+query,
                    dataType: "html",
                    error: function(){
                        alert("Error!");
                    },
                    success: function(data)
                    { 
                        if (data == "success") 
                        {            
                            var texto = "<b class='red'>"+exist+"</b>"; 
                            $("#result_accountant").html(texto);
                            $('#sub_accountant').attr('disabled','disabled');
                        }
                        else { 
                            var texto = ""; 
                            $("#result_accountant").html(texto);
                            $('#sub_accountant').removeAttr('disabled');
                        }
                        n();
                    }
                });                           
            });                       
        });                       
    });
    
    if(uriseg == 'accounting_report'){
        reqByMonth();
        chartAccounting('0,0,0,0,0,0,0,0,0,0,0,0','0,0,0,0,0,0,0,0,0,0,0,0');   
    }
    
    function reqByMonth(){
        $.ajax({
            url: rootAppURI+'admin/graphIncome/',
            type: 'POST',
            success: function(res) {
                reqExByMonth(res);
            }
        });
    }
    
    function reqExByMonth(res){
        $.ajax({
            url: rootAppURI+'admin/graphExpense/',
            type: 'POST',
            success: function(response) {
               chartAccounting(res,response);
            }
        });
    }
    
    function chartAccounting(inconmeData, expenseData){
        var incD = inconmeData.split(',');
        var incE = expenseData.split(',');
        new Chart(document.getElementById("accountingReportChart"), {
          type: 'line',
          data: {
            labels: [january,february,march,april,may,june,july,august,september,october,november,december],
            datasets: [{ 
                data: [incD[0],incD[1],incD[2],incD[3],incD[4],incD[5],incD[6],incD[7],incD[8],incD[9],incD[10],incD[11]],
                label: income,
                borderColor: "#3e95cd",
                backgroundColor: "#3e95cd",
                fill: false
              }, { 
                data: [incE[0],incE[1],incE[2],incE[3],incE[4],incE[5],incE[6],incE[7],incE[8],incE[9],incE[10],incE[11]],
                label: expense,
                borderColor: "#8e5ea2",
                backgroundColor: "#8e5ea2",
                fill: false
              }
            ]
          },
          options: {
            title: {
              display: true,
              text: accounting_report
            }
          }
        });   
    }
    
    function get_class_subjects(section_id) 
    {
        $.ajax({
            url: rootAppURI+'admin/get_class_subject/' + section_id ,
            success: function(response)
            {
                jQuery('#subject_holder').html(response);
            }
        });
    }
    
    function get_sections(class_id) 
    {
        $.ajax({
            url: rootAppURI+'admin/get_class_section/' + class_id ,
            success: function(response)
            {
                jQuery('#section_holder').html(response);
            }
        });
    }

    function get_class_sections2(class_id) 
    {
        $.ajax({
            url: rootAppURI+'admin/get_class_section/' + class_id ,
            success: function(response)
            {
                jQuery('#section_selector_holder2').html(response);
            }
        });
    }
        
    function get_student(section_id) 
    {
        $.ajax({
            url: rootAppURI+'admin/get_class_students_section/' + section_id ,
            success: function(response)
            {
                jQuery('#student_holder').html(response);
            }
        });
    }
    
    function get_class_students(class_id) {
        $.ajax({
            url: rootAppURI+'admin/get_class_stundets/' + class_id,
            success: function (response)
            {
                jQuery('#students_holder').html(response);
            }
        });
    }
        
    function Print(div) 
    { 
     	var printContents = document.getElementById(div).innerHTML;
     	var originalContents = document.body.innerHTML;
     	document.body.innerHTML = printContents;
     	window.print();
     	document.body.innerHTML = originalContents;
    }
    
    function checkAllBoxes(check){
        var checkboxes = document.getElementsByTagName('input');
        if (check.checked) {
            $('.'+check.id).prop("checked", true);
        } else {
            $('.'+check.id).prop("checked", false);
        }
    }
    
    if(uriseg == 'examroom'){
        $(document).ready(function() 
        {
            $('#question_type').on('change', function() {
                var question_type = $(this).val();
                if (question_type == '') {
                    $('#question_holder').html('<div class="alert alert-danger">'+select_qn+'</div>');
                    return;
                }
                $.ajax({
                    url: rootAppURI+ulogin+'/load_question_type/' + question_type + '/' + online_exam_id
                }).done(function(response) {
                    $('#question_holder').html(response);
                });
            });
        });
    }
    
    if(uriseg == 'forumroom' && (typeof ulogin != 'undefined'))
    {
        $(document).ready(function()
        {
            $("#add").on('click',function()
            {
                var message   = $("#message").val();
                var post_code = $("#post_code").val();
                if(message != "" && post_code != "")
                {
                    $.ajax({
                        url:rootAppURI+ulogin+"/forum_message/add",
                        type:'POST',
                        data:{
                            message:message,post_code:post_code
                        },
                        success:function(result)
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
                        }
                    });
                }
            });
        });
    }
    
    if(uriseg == 'reports_general')
    {
        var female    = $("#female").val();
        var male      = $("#male").val();
        var femaleval = $("#femaleval").val();
        var maleval   = $("#maleval").val();
        
        var ctx = document.getElementById("myChart");
            var myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: [female, male],
                    datasets: [{
                    label: '#',
                    data: [femaleval, maleval],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    }
    
    if(uriseg == 'live')
    {
        var liveDisplay = $("#liveDisplay").val();
        var liveEmail   = $("#liveEmail").val();
        var liveRoom    = $("#liveRoom").val();
        var liveTitle   = $("#liveTitle").val();
        
        var domain = "meet.jit.si";
        var options = {
            userInfo : { 
                email : liveEmail, 
                displayName : liveDisplay,
                moderator: true,
            },
            roomName: liveRoom,
            width: "100%",
            height: "100%",
            parentNode: document.querySelector('#liveContainer'),
            configOverwrite: {},
            interfaceConfigOverwrite: {
                DEFAULT_BACKGROUND: '#782c43',
            },
        }
        var api = new JitsiMeetExternalAPI(domain, options);
        api.executeCommand('subject', liveTitle);
    }

    if(uriseg == 'looking_report')
    {
    	$(document).ready(function()
    	{
    	    $("#add").on('click', function()
    	    {
    	  	    var message     = $("#message").val();
    	  	    var report_code = $("#report_code").val();
    	  	    if(message != "" && report_code != "")
    	  	    {
        		  	$.ajax({url: rootAppURI+"admin/create_report/response/",type:'POST',data:{message:message,report_code:report_code},success:function(result)
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
    	});
    }
    
    $('input[type=radio][name=livetype]').on('change',function() {
        if (this.value == 1){
            $('#siteUrl').hide(500);
        }
        else if (this.value == 2){
            $('#siteUrl').removeClass("hidde");
            $('#siteUrl').show(500);
        }
    });
    
    if(uriseg == 'new_poll')
    {
        var blank_student_entry = '';
        
       	$(document).ready(function() 
       	{
          	blank_student_entry = $('#student_entry').html();
       	});
       	
       	function append_student_entry()
       	{
        	$("#student_entry_append").append(blank_student_entry);
       	}
       	
       	function deleteParentElement(n)
       	{
          	n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
       	}
    }
    
    if(uriseg == 'admission_new_student')
    {
        $(document).ready(function(){         
            var query;          
            $("#user_student").on('keyup',function(e){
                query = $("#user_student").val();
                $("#result_student").queue(function(n) {                     
                    $.ajax({
                        type: "POST",
                        url: rootAppURI+'register/search_user',
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
                                $("#result_student").html(texto);
                                $('#sub_form').attr('disabled','disabled');
                            }
                            else { 
                                var texto = ""; 
                                $("#result_student").html(texto);
                                $('#sub_form').removeAttr('disabled');
                            }
                            n();
                        }
                    });                           
                });                       
            });                       
        });

        $(document).ready(function(){         
            var query;          
            $("#parent_username").keyup(function(e){
                query = $("#parent_username").val();
                $("#result").queue(function(n) {                     
                    $.ajax({
                        type: "POST",
                        url: rootAppURI+'register/search_user',
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
                                $("#result").html(texto);
                                $('#sub_form').attr('disabled','disabled');
                            }
                            else { 
                                var texto = ""; 
                                $("#result").html(texto);
                                $('#sub_form').removeAttr('disabled');
                            }
                            n();
                        }
                    });                           
                });                       
            });                       
        });

        $(document).ready(function(){         
            var query;          
            $("#parent_email").keyup(function(e){
                query = $("#parent_email").val();
                $("#email_result_parent").queue(function(n) {                     
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
                                $("#email_result_parent").html(texto);
                                $('#sub_form').attr('disabled','disabled');
                            }
                            else { 
                                var texto = ""; 
                                $("#email_result_parent").html(texto);
                                $('#sub_form').removeAttr('disabled');
                            }
                            n();
                        }
                    });                           
                });                       
            });                       
        });
    
        $(document).ready(function(){         
            var query;          
            $("#student_email").keyup(function(e){
                query = $("#student_email").val();
                $("#email_result_student").queue(function(n) {                     
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
                                $("#email_result_student").html(texto);
                                $('#sub_form').attr('disabled','disabled');
                            }
                            else { 
                                var texto = ""; 
                                $("#email_result_student").html(texto);
                                $('#sub_form').removeAttr('disabled');
                            }
                            n();
                        }
                    });                           
                });                       
            });                       
        });

	    $('#check').on('click',function () {
            if ($('#check').is(':checked') == true) {
                $("#new_parent").show(500);
                $("#initial").hide(500);
            }else{
                $("#new_parent").hide(500);
                $("#initial").show(500);
            }
        });
	    $("#new_parent").hide();
    }
    
    if(uriseg == 'notify')
    {
        $("#class").hide();
        $(function(){
            $("#type").on('change',function(){
                var status = this.value;
                if(status=="student")
                {
                    $("#class").show(500);
                }else{
                    $("#class").hide(500);
                }
            });
        });
    }
    
    function changeTheBlankColor() {
        var alpha = ["_"];
        var res = "", cls = "";
        var t = jQuery("#question_title").val();

        for (var i = 0; i < t.length; i++) {
            for (var j = 0; j < alpha.length; j++) {
                if (t[i] == alpha[j])
                {
                    cls = "red";
                }
            }
            if (t[i] === "_") {
                res += "<span class='"+cls+"'>"+'__'+"</span>";
            }
            else{
                res += "<span class='"+cls+"'>"+t[i]+"</span>";
            }
            cls="";
        }
        jQuery("#preview").html(res);
    }
    
    function showOptions(number_of_options){
        var usrl = $("#uslg").val();
        $.ajax({
            type: "POST",
            url: rootAppURI+usrl+"/manage_image_options",
            data: {number_of_options : number_of_options},
            success: function(response){
                jQuery('.options').remove();
                jQuery('#multiple_choice_question').after(response);
            }
        });
    }
    
    function showOptionsMultiple(number_of_options){
        var usrl = $("#uslg").val();
            $.ajax({
                type: "POST",
                url: rootAppURI+usrl+"/manage_multiple_choices_options",
                data: {number_of_options : number_of_options},
                success: function(response){
                    console.log(response);
                    jQuery('.options').remove();
                    jQuery('#multiple_choice_question').after(response);
                }
            });
        }
        
    function get_students_to_promote(running_year)
    {
        var from_class_id   = $("#from_class_id").val();
        var from_section_id   = $("#section_holder").val();
        var to_class_id     = $("#to_class_id").val();
        var promotion_year  = $("#promotion_year").val();
        if (from_class_id == "" || to_class_id == "" || from_section_id == "") {
            alert('Error.');
            return false;
        }
        $.ajax({
            url: rootAppURI+'admin/get_students_to_promote/' + from_class_id + '/' + to_class_id + '/' + running_year + '/' + promotion_year+'/'+from_section_id,
            success: function(response)
            {
                jQuery('#students_for_promotion_holder').html(response);
            }
        });
        return false;
    }
    
    if(uriseg == 'students_report')
    {
        var female = $("#female").val();
        var male = $("#male").val();
        
        var femaleval = $("#femaleval").val();
        var maleval = $("#maleval").val();
        
        var ctx = document.getElementById("myChart");
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: [female, male],
                datasets: [{
                    label: '#',
                    data: [femaleval, maleval],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 0
                }]
            },
        });
    }
    
    $("#btnExport").on('click',function (e) {
        var reportName = 'tab_report';
        var a = document.createElement('a');
        var data_type = 'data:application/vnd.ms-excel;charset=utf-8';
        var table_html = $('#dvData')[0].outerHTML;
        table_html = table_html.replace(/<tfoot[\s\S.]*tfoot>/gmi, '');
        var css_html = '<style>td {border: 0.5pt solid #c0c0c0} .tRight { text-align:right} .tLeft { text-align:left} </style>';
        a.href = data_type + ',' + encodeURIComponent('<html><head>' + css_html + '</' + 'head><body>' + table_html + '</body></html>');
        a.download = reportName + '.xls';
        a.click();
        e.preventDefault();
    });
    
    function updateLang(id) 
    {
        var language    = $('#current').val();
        var phrase_key  = id;
        var phrase      = $('#phrase-'+id).val();
        $.ajax({
            type:'post',
            url: rootAppURI+'admin/translate/update_language/'+language,
            data:{phrase_key:phrase_key,phrase:phrase},
            success:function(msg){
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 8000
                }); 
                Toast.fire({
                    icon: 'success',
                    title: 'Update'
                })
            }
        })
    }
     
    if(uriseg == 'view_report')
    {
    	$(document).ready(function()
    	{
    	    $("#add").on('click',function()
    	    { 
    	        var ulg = $("#ulg").val();
    	  	    var message = $("#message").val();
    	  	    var report_code = $("#report_code").val();
    	  	    if(message!="" && report_code!="")
    	  	    {
        		  	$.ajax({url: rootAppURI+ulg+"/create_report_message/",type:'POST',data:{message:message,report_code:report_code},success:function(result)
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
    	});
    }
    
    
    function submitComment()
    {
        var message     = $("#message").val();
        var report_code = $("#report_code").val();
        if(message != "" && report_code != "")
        {
            $.ajax({url: rootAppURI+"teacher/student_report/response/",type:'POST',data:{message:message,report_code:report_code},success:function(result)
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
	}
	
	$('.clockpicker').clockpicker({
        placement: 'top',
        align: 'left',
        donetext: 'Done'
    });
    
    $(document).ready(function() {
        if ($("#mymce").length > 0) {
            tinymce.init({
                selector: "textarea#mymce",
                theme: "modern",
                height: 300,
                plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                    "save table contextmenu directionality emoticons template paste textcolor"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",

            });
        }
    });
    
    
    if (typeof CKEDITOR !== 'undefined') 
    {
        CKEDITOR.disableAutoInline = true;
        if ($('#ckeditorEmail').length) 
        {
            CKEDITOR.config.uiColor = '#ffffff';
            CKEDITOR.config.toolbar = [['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', '-', 'About']];
            CKEDITOR.config.height = 250;
            CKEDITOR.replace('instruction');
        }
    }