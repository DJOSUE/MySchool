<?php
    // Get the Data
    $this->db->reset_query();        
    $this->db->where('agreement_id', $agreement_id);
    $agreement = $this->db->get('agreement')->row_array();



    $this->db->reset_query();        
    $this->db->where('agreement_id', $agreement_id);
    $agreement_amortization = $this->db->get('agreement_amortization')->result_array();    

    $this->db->reset_query();        
    $this->db->where('agreement_id', $agreement_id);
    $agreement_card = $this->db->get('agreement_card')->row_array();  

    $this->db->reset_query();        
    $this->db->where('semester_enroll_id', $agreement['semester_enroll_id']);
    $semester_enroll = $this->db->get('semester_enroll')->row_array();

    $this->db->reset_query();        
    $this->db->where('year', $agreement['year']);
    $this->db->where('semester_id', $agreement['semester_id']);
    $this->db->where('student_id', $agreement['student_id']);
    $student_enroll = $this->db->get('v_enrollment')->result_array();   

    $agreement_date = $agreement['agreement_date'];

    $student_info = $this->crud->get_student_info_by_id($agreement['student_id']);

    $student_image = $this->crud->get_image_url('student', $agreement['student_id']);

    if(strpos($student_image, 'svg'))
    {
        $student_image = "";
    }

    $student_name    = $student_info['first_name'] . ' ' . $student_info['last_name'];
    $student_address = $student_info['address'];

    $amount_agreed  = '';
    $number_payments = intval($agreement['number_payments']);

    foreach ($agreement_amortization as $key => $value) 
    {
        $amortization_no = intval($value['amortization_no']);
        $total_quota = intval($value['amount']) + intval($value['materials']) + intval($value['fees']);

        if($amortization_no == 1)
        {
            if(floatval($agreement['down_payment']) == 0)
            {
                $amount_agreed .= '$ '.$total_quota.', ';
            }
            else
            {
                $number_payments--;
            }
        }
        if($amortization_no > 1)
        {
            $amount_agreed .= '$ '.$total_quota.', ';
        }
    }

    $program_name = $this->crud->get_program_name($student_info['program_id']);

    // echo '<pre>';
    // var_dump($agreement_card );
    // echo '</pre>';

?>
<html>

<header>
    <link href="/public/style/print/agreement.css" media="all" rel="stylesheet">
</header>

<body>
    <!-- student_registration -->
    <div class="m_WordSection1">
        <div id="logo">
            <p class="MsoNormal" align="center" style='text-align:center;line-height:normal; border:none;padding:0in'>
                <span style='font-family:Rubik'>
                    <img height=40 src="/public/uploads/logo_print.png">
                </span>
            </p>
        </div>
        <br />
        <div id="checklist_new_student_title">
            <p class="MsoNormal" align="center" style='text-align:center;line-height:normal;border:none;padding:0in'>
                <span style='font-size:36.0pt;font-family:"Montserrat ExtraBold";color:#223367'>
                    STUDENT REGISTRATION
                </span>
            </p>
        </div>
        <br />
        <table border="0" cellspacing="0" cellpadding="0" align="left" width="682">
            <tr style="background:#e7e6e6;">
                <td width="172">
                    <b>Name of student:</b>

                </td>
                <td width="510" colspan="3">
                    <?=$student_name;?>
                </td>
            </tr>
            <tr></tr>
            <tr>
                <td width="172">
                    <b>Type of student:</b>
                </td>
                <td width="149">
                    <?= $program_name?>
                </td>
                <td width="173">
                    <b>Country:</b>
                </td>
                <td width="188">
                    <?= $this->crud->get_country_name($student_info['country_id'])?>
                </td>
            </tr>
            <tr style="background:#e7e6e6;">
                <td width="172">
                    <b>Program:</b>
                </td>
                <td width="149">
                    <?= $this->academic->get_program_type_name($agreement['program_type_id'])?>
                </td>
                <td width="173">
                    <b>Email:
                        </p>
                </td>
                <td width="188">
                    <?=$student_info['email']?>
                </td>
            </tr>
            <tr>
                <td width="172">
                    <b>Birthday:</b></p>
                </td>
                <td width="149">
                    <?=$student_info['birthday']?>
                </td>
                <td width="173">
                    <b>Phone Number:</b>
                </td>
                <td width="188">
                    <?=$student_info['phone']?>
                </td>
            </tr>
        </table>
        <br />
        <br />
        <h2 style='margin:0in;text-align:center;line-height:100%'>
            <b>
                <?= strtoupper($program_name)?> SIDE
            </b>
        </h2>
        <br />
        <br />
        <div class="row">
            <div class="column">
                <?php if($program_name == 'international'):?>
                <table class="checklist center">
                    <tr>
                        <td width="37">
                        </td>
                        <td>
                            Application for admission
                        </td>
                    </tr>
                    <tr>
                        <td width="37">
                        </td>
                        <td>
                            Passport and/or visa
                        </td>
                    </tr>
                    <tr>
                        <td width="37">
                        </td>
                        <td>
                            I-94 on-line current form available
                        </td>
                    </tr>
                    <tr>
                        <td width="37">
                        </td>
                        <td>
                            Transfer form
                        </td>
                    </tr>
                    <tr>
                        <td width="37">
                        </td>
                        <td>
                            Affidavit of Financial Support
                        </td>
                    </tr>
                    <tr>
                        <td width="37">
                        </td>
                        <td>
                            Bank Statements
                        </td>
                    </tr>
                    <tr>
                        <td width="37">
                        </td>
                        <td>
                            Registration signed by student
                        </td>
                    </tr>
                    <tr>
                        <td width="37">
                        </td>
                        <td>
                            Placement test
                        </td>
                    </tr>
                    <tr>
                        <td width="37">
                        </td>
                        <td>
                            Contract signed
                        </td>
                    </tr>
                    <tr>
                        <td width="37">
                        </td>
                        <td>
                            Copy of enrollment given to student
                        </td>
                    </tr>
                    <tr>
                        <td width="37">
                        </td>
                        <td>
                            Enrolled in MySchool
                        </td>
                    </tr>
                </table>
                <?php else:?>
                <table class="checklist center">
                    <tr>
                        <td width="37">
                        </td>
                        <td>
                            Personal information form
                        </td>
                    </tr>
                    <tr>
                        <td width="37">
                        </td>
                        <td>
                            Schedule
                        </td>
                    </tr>
                    <tr>
                        <td width="37">
                        </td>
                        <td>
                            Policies
                        </td>
                    </tr>
                    <tr>
                        <td width="37">
                        </td>
                        <td>
                            Copy of ID
                        </td>
                    </tr>
                    <tr>
                        <td width="37">
                        </td>
                        <td>
                            Contract signed
                        </td>
                    </tr>
                    <tr>
                        <td width="37">
                        </td>
                        <td>
                            Credit card application
                        </td>
                    </tr>
                    <tr>
                        <td width="37">
                        </td>
                        <td>
                            Books
                        </td>
                    </tr>
                    <tr>
                        <td width="37">
                        </td>
                        <td>
                            Automatic payments
                        </td>
                    </tr>
                </table>
                <?php endif;?>
            </div>
            <div class="column">
                <table class="checklist center" width="235">
                    <tr>
                        <td style="height: 250px;">
                            <img class="center" height="250px" src="<?=$student_image?>">
                        </td>
                    </tr>
                    <tr class="center" style="background-color: #e7e6e6;">
                        <td>
                            <span>
                                IDENTIFICATION NUMBER
                            </span>
                        </td>
                    </tr>
                    <tr class="center">
                        <td>
                            <span>
                                <?=$student_info['student_code'];?>
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- student_registration -->
    <div id="student_registration">
        <div id="student_checklist" class="WordSection3">
            <div id="logo">
                <p class="MsoNormal" align="center"
                    style='text-align:center;line-height:normal; border:none;padding:0in'>
                    <span style='font-family:Rubik'>
                        <img height=40 src="/public/uploads/logo_print.png">
                    </span>
                </p>
            </div>
            <br />
            <div id="checklist_new_student_title">
                <p class="MsoNormal" align="center"
                    style='text-align:center;line-height:normal;border:none;padding:0in'>
                    <span style='font-size:36.0pt;font-family:"Montserrat ExtraBold";color:#223367'>
                        STUDENT REGISTRATION
                    </span>
                </p>
            </div>
            <div id="student_info">
                <table class="13" border="1" cellspacing=0 cellpadding=0 width=704
                    style='border-collapse:collapse;border:none'>
                    <tr style='height:0.75pt'>
                        <td width="66"
                            style='width:49.5pt;border:dotted #EFEFEF 1.0pt; background:#F3F3F3;padding:5.0pt 5.0pt 5.0pt 5.0pt;height:0.75pt'>
                            <p class="MsoNormal" align="center"
                                style='text-align:center;line-height:normal; border:none'>
                                <b>
                                    <span style='font-family:Montserrat'>Name:</span>
                                </b>
                            </p>
                        </td>
                        <td width=638 valign=top
                            style='width:478.5pt;border:dotted #EFEFEF 1.0pt;border-left:none;background:#F3F3F3;padding:5.0pt 5.0pt 5.0pt 5.0pt;height:0.75pt'>
                            <p class="MsoNormal" align="center"
                                style='text-align:center;line-height:normal; font-family:Rubik;color:black'>
                                <b>
                                    <?=$student_name;?>
                                </b>
                            </p>
                        </td>
                    </tr>
                </table>
            </div>
            <br />
            <div id="checklist" class="row">
                <h1 align="center"
                    style='margin-top:2.0pt;margin-right:0in;margin-bottom:0in;margin-left:0in;text-align:center;line-height:normal'>
                    <b>
                        <span style='font-size:14.0pt;font-family:Montserrat;color:#365F91'>
                            CHECKLIST FOR NEW STUDENTS
                        </span>
                    </b>
                </h1>
                <br />
                <div class="column">
                    <div id="attendance_policy">
                        <h2 align="center" style='margin:0in;text-align:center;line-height:100%'>
                            <b>
                                <span style='font-size:12.5pt;font-family:Montserrat'>
                                    Attendance Policy
                                </span>
                            </b>
                        </h2>
                        <p class="MsoNormal" style='margin-left:.5in;text-indent:-.25in;line-height:normal'>
                            <span style='font-size:8.0pt;font-family:"Noto Sans Symbols"'>
                                ❑ &nbsp;&nbsp;
                            </span>
                            <span style='font-family:Rubik'>
                                Absent = 30 minutes after classes started.
                            </span>
                        </p>
                        <p class="MsoNormal" style='margin-left:.5in;text-indent:-.25in;line-height:normal'>
                            <span style='font-size:8.0pt;font-family:"Noto Sans Symbols"'>
                                ❑ &nbsp;&nbsp;
                            </span>
                            <span style='font-family:Rubik'>
                                Tardy = 1 – 30 minutes late to class
                            </span>
                        </p>
                        <p class="MsoNormal" style='margin-left:.5in;text-indent:-.25in;line-height:normal'>
                            <span style='font-size:8.0pt;font-family:"Noto Sans Symbols"'>
                                ❑ &nbsp;&nbsp;
                            </span>
                            <span style='font-family:Rubik'>
                                1% deduction for every minute late
                            </span>
                        </p>
                        <p class="MsoNormal" style='margin-left:.5in;text-indent:-.25in;line-height:normal'>
                            <span style='font-size:8.0pt;font-family:"Noto Sans Symbols"'>
                                ❑ &nbsp;&nbsp;
                            </span>
                            <span style='font-family:Rubik'>
                                Must have doctor’s note to excuse absences for being sick
                            </span>
                        </p>
                    </div>
                    <br />
                    <div id="classroom_policy">
                        <h2 align="center" style='margin:0in;text-align:center;line-height:100%'>
                            <b>
                                <span style='font-size:12.5pt;font-family:Montserrat'>
                                    Classroom Policy
                                </span>
                            </b>
                        </h2>
                        <p class="MsoNormal" style='margin-left:.5in;text-indent:-.25in;line-height:normal'>
                            <span style='font-size:8.0pt;font-family:"Noto Sans Symbols"'>
                                ❑ &nbsp;&nbsp;
                            </span>
                            <span style='font-family:Rubik'>
                                No cell phones
                            </span>
                        </p>
                        <p class="MsoNormal" style='margin-left:.5in;text-indent:-.25in;line-height:normal'>
                            <span style='font-size:8.0pt;font-family:"Noto Sans Symbols"'>
                                ❑ &nbsp;&nbsp;
                            </span>
                            <span style='font-family:Rubik'>
                                No food or drinks (water bottles are allowed)
                            </span>
                        </p>
                        <p class="MsoNormal" style='margin-left:.5in;text-indent:-.25in;line-height:normal'>
                            <span style='font-size:8.0pt;font-family:"Noto Sans Symbols"'>
                                ❑ &nbsp;&nbsp;
                            </span>
                            <span style='font-family:Rubik'>
                                No talking in native language: English Only!
                            </span>
                        </p>
                    </div>
                    <br />
                    <div id="academic_issues">
                        <h2 align="center" style='margin:0in;text-align:center;line-height:100%'>
                            <b>
                                <span style='font-size:12.5pt;font-family:Montserrat'>
                                    Academic Issues
                                </span>
                            </b>
                        </h2>
                        <p class="MsoNormal" style='margin-left:.5in;text-indent:-.25in;line-height:normal'>
                            <span style='font-size:8.0pt;font-family:"Noto Sans Symbols"'>
                                ❑ &nbsp;&nbsp;
                            </span>
                            <span style='font-family:Rubik'>
                                Students are graded daily on these aspects: attendance, writing, participation,
                                listening, reading, quizzes, and homework.
                            </span>
                        </p>
                        <p class="MsoNormal" style='margin-left:.5in;text-indent:-.25in;line-height:normal'>
                            <span style='font-size:8.0pt;font-family:"Noto Sans Symbols"'>
                                ❑ &nbsp;&nbsp;
                            </span>
                            <span style='font-family:Rubik'>
                                Students are also graded on each unit exam, midterm exams, and final exams. (Units 1&2,
                                Units 3&4, Units 5&6, Units 9&10, Units 11&12, Units 13&14)
                            </span>
                        </p>
                        <p class="MsoNormal" style='margin-left:.5in;text-indent:-.25in;line-height:normal'>
                            <span style='font-size:8.0pt;font-family:"Noto Sans Symbols"'>
                                ❑ &nbsp;&nbsp;
                            </span>
                            <span style='font-family:Rubik'>
                                Semester = 16 weeks
                            </span>
                        </p>
                        <p class="MsoNormal" style='margin-left:.5in;text-indent:-.25in;line-height:normal'>
                            <span style='font-size:8.0pt;font-family:"Noto Sans Symbols"'>
                                ❑ &nbsp;&nbsp;
                            </span>
                            <span style='font-family:Rubik'>
                                80-100% overall grade is required to pass (attendance is graded separately but must also
                                be 80-100% in order to pass)
                            </span>
                        </p>
                        <p class="MsoNormal" style='margin-left:.5in;text-indent:-.25in;line-height:normal'>
                            <span style='font-size:8.0pt;font-family:"Noto Sans Symbols"'>
                                ❑ &nbsp;&nbsp;
                            </span>
                            <span style='font-family:Rubik'>
                                Level Change must be requested after each semester.
                            </span>
                        </p>
                        <p class="MsoNormal" style='margin-left:.5in;text-indent:-.25in;line-height:normal'>
                            <span style='font-size:8.0pt;font-family:"Noto Sans Symbols"'>
                                ❑ &nbsp;&nbsp;
                            </span>
                            <span style='font-family:Rubik'>
                                Books are required in class
                            </span>
                        </p>
                        <p class="MsoNormal" style='margin-left:.5in;text-indent:-.25in;line-height:normal'>
                            <span style='font-size:8.0pt;font-family:"Noto Sans Symbols"'>
                                ❑ &nbsp;&nbsp;
                            </span>
                            <span style='font-family:Rubik'>
                                Grades are posted on myschool daily.
                            </span>
                        </p>
                        <p class="MsoNormal" style='margin-left:.5in;text-indent:-.25in;line-height:normal'>
                            <span style='font-size:8.0pt;font-family:"Noto Sans Symbols"'>
                                ❑ &nbsp;&nbsp;
                            </span>
                            <span style='font-family:Rubik'>
                                Class completion certificates will be issued at the end of each semester.
                            </span>
                        </p>
                    </div>
                </div>
                <div class="column">
                    <div>
                        <h2 align="center" style='margin:0in;text-align:center;line-height:100%'>
                            <b>
                                <span style='font-size:12.5pt;font-family:Montserrat'>
                                    School Activities / Calendar
                                </span>
                            </b>
                        </h2>
                        <p class="MsoNormal" style='margin-left:.5in;text-indent:-.25in;line-height:normal'>
                            <span style='font-size:8.0pt;font-family:"Noto Sans Symbols"'>
                                ❑ &nbsp;&nbsp;
                            </span>
                            <span style='font-family:Rubik'>
                                Major Holidays are observed
                            </span>
                        </p>
                        <p class="MsoNormal" style='margin-left:.5in;text-indent:-.25in;line-height:normal'>
                            <span style='font-size:8.0pt;font-family:"Noto Sans Symbols"'>
                                ❑ &nbsp;&nbsp;
                            </span>
                            <span style='font-family:Rubik'>
                                Activities will be announced
                            </span>
                        </p>
                        <p class="MsoNormal" style='margin-left:.5in;text-indent:-.25in;line-height:normal'>
                            <span style='font-size:8.0pt;font-family:"Noto Sans Symbols"'>
                                ❑ &nbsp;&nbsp;
                            </span>
                            <span style='font-family:Rubik'>
                                Student Teachers/ Tutors available upon request, students must sign-up.
                            </span>
                        </p>
                    </div>
                    <br />
                    <div>
                        <h2 align="center" style='margin:0in;text-align:center;line-height:100%'>
                            <b>
                                <span style='font-size:12.5pt;font-family:Montserrat'>
                                    Grievances
                                </span>
                            </b>
                        </h2>
                        <p class="MsoNormal"
                            style='margin-left:.5in;text-align:justify;text-indent:-.25in;line-height:normal'>
                            <span style='font-size:8.0pt;font-family:"Noto Sans Symbols"'>
                                ❑ &nbsp;&nbsp;
                            </span>
                            <span style='font-family:Rubik'>
                                If students have any problems, concerns, or questions, they should talk to their
                                teacher(s) first. If further assistance is needed or if the problem is unresolved, the
                                students can go to their advisor or academic director for more help.
                            </span>
                        </p>
                    </div>
                    <br />
                    <div>
                        <h2 align="center" style='margin:0in;text-align:center;line-height:100%'>
                            <b>
                                <span style='font-size:12.5pt;font-family:Montserrat'>
                                    Citizenship Issues
                                </span>
                            </b>
                        </h2>
                        <p class="MsoNormal"
                            style='margin-left:.5in;text-align:justify;text-indent:-.25in;line-height:normal'>
                            <span style='font-size:8.0pt;font-family:"Noto Sans Symbols"'>
                                ❑ &nbsp;&nbsp;
                            </span>
                            <span style='font-family:Rubik'>
                                No Smoking within 25 feet of entrance.
                            </span>
                        </p>
                        <p class="MsoNormal"
                            style='margin-left:.5in;text-align:justify;text-indent:-.25in;line-height:normal'>
                            <span style='font-size:8.0pt;font-family:"Noto Sans Symbols"'>
                                ❑ &nbsp;&nbsp;
                            </span>
                            <span style='font-family:Rubik'>
                                Students must maintain respectful relationships with others.
                            </span>
                        </p>
                        <p class="MsoNormal"
                            style='margin-left:.5in;text-align:justify;text-indent:-.25in;line-height:normal'>
                            <span style='font-size:8.0pt;font-family:"Noto Sans Symbols"'>
                                ❑ &nbsp;&nbsp;
                            </span>
                            <span style='font-family:Rubik'>
                                No purses or valuables should be kept in the car in the parking lot.
                            </span>
                        </p>
                        <p class="MsoNormal"
                            style='margin-left:.5in;text-align:justify;text-indent:-.25in;line-height:normal'>
                            <span style='font-size:8.0pt;font-family:"Noto Sans Symbols"'>
                                ❑ &nbsp;&nbsp;
                            </span>
                            <span style='font-family:Rubik'>
                                Plagiarism is illegal &amp; grounds for dismissal from the school.
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            <br />
            <p class="MsoNormal" style='line-height:normal'>
                <b>
                    <span style='font-size:8.0pt;font-family:Rubik'>
                        I understand these policies and procedures as they were explained to me.
                    </span>
                </b>
            </p>
            <br />
            <div id="signature" align="center">
                <hr />
                <p class="MsoNormal" align="center" style='margin-bottom:10.0pt;text-align:center;line-height:normal'>
                    <span style='font-family:Rubik'>
                        Signature of student
                    </span>
                </p>
                <p class="MsoNormal" align="center" style='margin-bottom:10.0pt;line-height:normal'>
                    <span style='font-size:7.0pt;font-family:Rubik'>
                        <i>
                            (<b>Copy to student</b>; <b>Original</b> to student file)
                        </i>
                    </span>
                </p>
            </div>
        </div>
        <br />
        <div id="policies_agreements" class=WordSection3>
            <div id="logo">
                <p class="MsoNormal" align="center"
                    style='text-align:center;line-height:normal; border:none;padding:0in'>
                    <span style='font-family:Rubik'>
                        <img height=40 src="/public/uploads/logo_print.png">
                    </span>
                </p>
            </div>
            <br />
            <div id="policies_agreements_title">
                <p class="MsoNormal" align="center"
                    style='text-align:center;line-height:normal;border:none;padding:0in'>
                    <span style='font-size:25.0pt;font-family:"Montserrat ExtraBold";color:#223367'>
                        STUDENT REGISTRATION
                    </span>
                </p>

            </div>
            <br />
            <div id="student_info">
                <table class="13" border="1" cellspacing=0 cellpadding=0 width=704
                    style='border-collapse:collapse;border:none'>
                    <tr style='height:0.75pt'>
                        <td width="66"
                            style='width:49.5pt;border:dotted #EFEFEF 1.0pt; background:#F3F3F3;padding:5.0pt 5.0pt 5.0pt 5.0pt;height:0.75pt'>
                            <p class="MsoNormal" align="center"
                                style='text-align:center;line-height:normal; border:none'>
                                <b>
                                    <span style='font-family:Montserrat'>Name:</span>
                                </b>
                            </p>
                        </td>
                        <td width=638 valign=top
                            style='width:478.5pt;border:dotted #EFEFEF 1.0pt;border-left:none;background:#F3F3F3;padding:5.0pt 5.0pt 5.0pt 5.0pt;height:0.75pt'>
                            <p class="MsoNormal" align="center" style='text-align:center;line-height:normal'>
                                <b>
                                    <span style='font-family:Rubik;color:black'>
                                        <?=$student_name;?>
                                    </span>
                                </b>
                            </p>
                        </td>
                    </tr>
                </table>
            </div>
            <br />
            <div id="policies_agreements_content">
                <h1 align="center"
                    style='margin-top:2.0pt;margin-right:0in;margin-bottom:0in;margin-left:0in;text-align:center;line-height:normal'>
                    <b>
                        <span style='font-size:14.0pt;font-family:Montserrat;color:#365F91'>
                            POLICIES AND AGREEMENTS
                        </span>
                    </b>
                </h1>
                <div>
                    <p class="MsoNormal" style='line-height:normal;page-break-after:avoid;margin-bottom:10px;'>
                        <b>
                            <span style='font-size:10.0pt;font-family:Rubik'>
                                Change of Schedules
                            </span>
                        </b>
                    </p>
                    <div class="row">
                        <div class="column-left-20">
                            <span style='font-size:8.0pt;font-family:Rubik'>
                                ___________ Initial
                            </span>
                        </div>
                        <div class="column-right-80 ">
                            <span style='font-size:8.0pt;font-family:Rubik'>
                                A change of schedule is only allowed in emergency case such as health problems and work
                                problems (only for local students).
                            </span>
                        </div>
                    </div>
                    </p>
                </div>
                <br />
                <div>
                    <p class="MsoNormal" style='line-height:normal;page-break-after:avoid;margin-bottom:10px;'>
                        <b>
                            <span style='font-size:10.0pt;font-family:Rubik'>
                                Use of Photographs
                            </span>
                        </b>
                    </p>
                    <div class="row">
                        <div class="column-left-20">
                            <span style='font-size:8.0pt;font-family:Rubik'>
                                ___________ Initial
                            </span>
                        </div>
                        <div class="column-right-80 ">
                            <span style='font-size:8.0pt;font-family:Rubik'>
                                We take photos of our students for student ID cards and student files. We also take
                                pictures of students while they are involved in various activities with the school.
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="column-left-20">
                            <span style='font-size:8.0pt;font-family:Rubik'>
                                ___________ Initial
                            </span>
                        </div>
                        <div class="column-right-80 ">
                            <span style='font-size:8.0pt;font-family:Rubik'>
                                I agree to let American One English Schools, INC use any photo with my image in it as
                                they choose without compensation or notification.
                            </span>
                        </div>
                    </div>
                </div>
                <br />
                <div>
                    <p class="MsoNormal" style='line-height:normal;page-break-after:avoid;margin-bottom:10px;'>
                        <b>
                            <span style='font-size:10.0pt;font-family:Rubik'>
                                Assumption of Risk
                            </span>
                        </b>
                    </p>
                    <div class="row">
                        <div class="column-left-20">
                            <span style='font-size:8.0pt;font-family:Rubik'>
                                ___________ Initial
                            </span>
                        </div>
                        <div class="column-right-80 ">
                            <span style='font-size:8.0pt;font-family:Rubik'>
                                In consideration of American One English Schools, a division of INC, Inc. allowing me to
                                participate in any and all school related activities, recreation, or events. I hereby
                                assume all risk and accept responsibility for any harm, injury, or damage to myself or
                                to any person or property by participation therein or traveling to or from such
                                activities. I specifically waive any claim for damage or loss to my person or property
                                that I may suffer in connection with said activities by any act, or failure to act, of
                                American One English Schools. INC its officers, agents, employees, and representatives,
                                accepting myself the full responsibility for any and all such damage or injury which may
                                result whether or not such injuries or damages are caused by the American One English
                                Schools INC or its employees.
                            </span>
                        </div>
                    </div>
                </div>
                <br />
                <div>
                    <p class="MsoNormal" style='line-height:normal;page-break-after:avoid;margin-bottom:10px;'>
                        <b>
                            <span style='font-size:10.0pt;font-family:Rubik'>
                                Semester Agreement
                            </span>
                        </b>
                    </p>
                    <p class="MsoNormal" style='text-align:justify;line-height:normal;page-break-after:avoid'>
                    <div class="row">
                        <div class="column-left-20">
                            <span style='font-size:8.0pt;font-family:Rubik'>
                                ___________ Initial
                            </span>
                        </div>
                        <div class="column-right-80 ">
                            <span style='font-size:8.0pt;font-family:Rubik'>
                                I understand that I am signing up for half of the regular program or one (1) semester
                                and that I received accurate information. I also understand that I must fulfill my
                                financial obligations, which are due the date of registration. I understand that I may
                                continue beyond this one semester.
                            </span>
                        </div>
                    </div>
                    </p>
                </div>
                <br />
                <div>
                    <p class="MsoNormal" style='line-height:normal;page-break-after:avoid;margin-bottom:10px;'>
                        <b>
                            <span style='font-size:10.0pt;font-family:Rubik'>
                                I-20 sign up F-1 Status
                            </span>
                        </b>
                    </p>
                    <p class="MsoNormal" style='text-align:justify;line-height:normal;page-break-after:avoid'>
                    <div class="row">
                        <div class="column-left-20">
                            <span style='font-size:8.0pt;font-family:Rubik'>
                                ___________ Initial
                            </span>
                        </div>
                        <div class="column-right-80 ">
                            <span style='font-size:8.0pt;font-family:Rubik'>
                                I understand that I am responsible for keeping my F-1 status active and that before my
                                I-20 expires I will speak with the DSO of the school and extend my I-20 for 1 more year.
                                I also understand that it is my responsibility to make sure I am in a legal status in
                                the US as an F-1 student. I am signing up for my I-20 for one year of a full time
                                intensive English program. I received accurate information. And I also understand that I
                                must fulfill my financial obligations, which are due the date of registration.
                            </span>
                        </div>
                    </div>
                    </p>
                </div>
                <br />
                <div>
                    <p class="MsoNormal" style='line-height:normal;page-break-after:avoid;margin-bottom:10px;'>
                        <b>
                            <span style='font-size:10.0pt;font-family:Rubik;'>
                                Yearly Agreement
                            </span>
                        </b>
                    </p>
                    <div class="row">
                        <div class="column-left-20">
                            <span style='font-size:8.0pt;font-family:Rubik'>
                                ___________ Initial
                            </span>
                        </div>
                        <div class="column-right-80" style="text-align:justify;">
                            <span style='font-size:8.0pt;font-family:Rubik;'>
                                I understand that I am signing up for a year of the regular program or three (3)
                                semesters and that I received a discount for this yearly agreement. I also understand
                                that I must fulfill my financial obligations, which are due the date of registration. I
                                understand that If I’m absent for 1 week without notification. This agreement will be
                                invalid and disrupted. And also I have the right to have 2 weeks vacation after my
                                semester is completed.
                            </span>
                        </div>
                    </div>
                    </p>
                </div>
            </div>
            <br />
            <p class="MsoNormal" style='margin-bottom:8.0pt;text-align:justify;line-height:normal'>
                <span style='font-size:9.0pt;font-family:"Rubik ExtraBold"'>
                    <b>
                        I have carefully read this agreement and release of liability and fully understand its contents.
                        I am aware that this is a release of liability and signs it of my own free will.
                    </b>
                </span>
            </p>
            <br />
            <br />
            <div class="row" align="center">
                <div class="column" align="center">
                    <b>
                        <span style='font-size:10.0pt'>__________________________________________</span><br />
                        <span style='font-size:10.0pt'>Student Signature</span>
                    </b>
                </div>
                <div class="column" align="center">
                    <b>
                        <span style='font-size:10.0pt'>__________________________________________</span><br />
                        <span style='font-size:10.0pt'>American One English Schools, INC</span>
                    </b>
                </div>
            </div>
            <br /><br /><br />
        </div>
    </div>

    <!-- service_agreement -->
    <div id="service_agreement" class=WordSection3>
        <div id="logo">
            <p class="MsoNormal" align="center" style='text-align:center;line-height:normal; border:none;padding:0in'>
                <span style='font-family:Rubik'>
                    <img height=40 src="/public/uploads/logo_print.png">
                </span>
            </p>
        </div>
        <br />
        <div id="service_agreement_title">
            <p class="MsoNormal" align="center" style='text-align:center;line-height:normal;border:none;padding:0in'>
                <span style='font-size:25.0pt;font-family:"Montserrat ExtraBold";color:#223367'>
                    ENGLISH CLASSES SERVICE AGREEMENT
                </span>
            </p>
        </div>
        <br />
        <div>
            <div class="MsoNormal"
                style='line-height:normal;page-break-after:avoid;margin-bottom:10px; font-size:8.0pt;font-family:Rubik;text-align: justify;text-justify: inter-word;'>
                <p>
                    American One English Schools INC which will be known as the “School” and
                    <b>(<?=$student_name;?>)</b> who will be known as the “Student” on <b><?=$agreement_date;?></b>
                </p>
                <p>
                    <b>1. This English classes service agreement</b>, dated on <?=$agreement_date;?>, is made between
                    American One English Schools INC incorporated in the state of Utah, and headquartered at 1918 West
                    4100 South suite 200, West Valley City, Utah – 84119 and <?=$student_name;?> who lives on
                    <?=$student_address;?>
                </p>
                <p>
                    <b>2. WHEREAS,</b> American One English Schools operates and maintains its principal business in
                    West
                    Valley City, Utah, with an address described above, through which it offers “personalized” English
                    classes in its location.

                </p>
                <p>
                    <b>3. The Parties’ Obligations</b><br />
                    American One English Schools, INC, by its acceptance of this Agreement, agrees to provide
                    personalized English classes in its location with the presence of an instructor <?=$student_name;?>
                    services described below for the following trimester <b><?=$semester_name;?></b>.
                </p>
                <p>
                    Start date: <?=$semester_start;?>
                    End date: <?=$semester_end;?>
                </p>
                <ol type="a">
                    <li>provide instructional material for the trimester described above;</li>
                    <li>provide the presence of an instructor in a classroom setting;</li>
                    <li>provide English classes given by an instructor according to the student’s level; and</li>
                    <li>provide a comfortable classroom setting.</li>
                </ol>
                <p>
                    <b><?=$student_name;?></b> agrees to pay for said Services as described in the
                    trimester of <b><?=$semester_name;?></b>.. to the terms and conditions set for this Agreement.
                </p>
                <ol type="a">
                    <li>pay the total cost of the trimester agreement.</li>
                    <li>pay for instructional materials.</li>
                    <li>pay for any damages to the classroom setting or any part of the school building caused by the
                        student in this agreement.</li>
                </ol>
                <p>
                    American One English Schools will perform their services in a competent and professional manner and
                    will comply with all applicable laws, regulations and accreditation standards in the performance of
                    its obligations.
                </p>
                <p>
                    The student will not reproduce, copy, or sell any school materials without the authorization of the
                    school, this also applies to the materials of third-party school providers which own intellectual
                    property rights (copyrights). American One is not liable for any wrongdoings caused by the student
                    as stated in this paragraph.
                </p>
                <p>
                    <b>4. Fees and Payments</b>
                    English Classes Service Fees: The student has two options of payment, either to pay full tuition
                    before the beginning of the academic trimester or monthly payments per trimester as follows. Student
                    agrees to pay full-tuition payment rates as described below for classes requested by the Student.
                    <b>Student agrees to make monthly payment rates described below for classes requested by the
                        Student.</b>
                </p>
                <div class="center">

                    <table class="payment center">
                        <tbody>
                            <tr>
                                <td>
                                    Total cost of Tuition
                                </td>
                                <td>
                                    <?= $agreement['tuition'];?>
                                </td>
                                <td>
                                    Date
                                </td>
                                <td>
                                    <?= $agreement['agreement_date'];?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Scholarship
                                </td>
                                <td>
                                    <?= $agreement['scholarship'];?>
                                </td>
                                <td>
                                    Number of payments
                                </td>
                                <td>
                                    <?= $agreement['number_payments'];?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Other Discount
                                </td>
                                <td>
                                    <?= $agreement['discounts'];?>
                                </td>
                                <td>
                                    Enroll fee
                                </td>
                                <td>
                                    <?= $agreement['fees'];?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <b>Total Payment:</b>
                                </td>
                                <td>
                                    <?= (($agreement['tuition'] + $agreement['fees'] + $agreement['materials']) - ($agreement['scholarship'] +  $agreement['discounts']));?>
                                </td>
                                <td>
                                    Materials fee:
                                </td>
                                <td>
                                    <?= $agreement['materials'];?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Full payment
                                </td>
                                <td>

                                </td>
                                <td>
                                    Date
                                </td>
                                <td>

                                </td>
                            </tr>
                            <?php 

                            foreach ($agreement_amortization as $key):
                                $total_quota = intval($key['amount']) + intval($key['materials']) + intval($key['fees']);
                            ?>
                            <tr>
                                <td>
                                    <?= ordinal($key['amortization_no'])?> payment:
                                </td>
                                <td>
                                    <?= $total_quota;?>
                                </td>
                                <td>
                                    Date
                                </td>
                                <td>
                                    <?= $key['due_date'];?>
                                </td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>

                </div>
                <div>
                    <p>
                        Student agrees to pay for all English class services provided as described in clause 3 to this
                        Agreement. All invoices for fees charged by American One in connection with the Service will be
                        due and payable within 2 days of the due date. A late fee of $25 will be charged after the third
                        day of the due date with a grace period up to 7 days. After the grace period expires students
                        will be subject to pay $10 per day for each day payment is not made as agreed in this Agreement.
                        The Student agrees to pay all fees and costs of collection, including all court and attorney
                        fees.
                    </p>
                </div>
                <br />
                <p>
                    <b>5. Terms and Terminations </b><br />
                <ol type="a">
                    <li>
                        The initial term of this Agreement will begin on the Effective Date and end one (1) year
                        thereafter, unless extended prior to termination by mutual written agreements of the parties.
                    </li>
                    <li>
                        In addition to termination set forth elsewhere in this Agreement, this Agreement may be
                        terminated as follows.
                    </li>
                    <li>
                        The student may terminate this Agreement at any time during the term upon fifteen (15) days
                        prior to the end of the current trimester. Written notice to an advisor at the enrollment office
                        of the school must be made.
                    </li>
                    <li>
                        If a student does not notify an advisor at the office of the school and give a written notice
                        this Agreement will be automatically extended for the 2nd and possibly the 3rd academic
                        trimester.
                    </li>
                    <li>
                        Grace period termination and refund. The student has 5 (five) calendar days to terminate this
                        Agreement after the Effective Date of signing to this Agreement, and a refund will be given as
                        follows:
                        <p style="padding-left: 40px;">
                            Termination of Agreement day 1 (one) : 75% of the total cost of tuition<br />
                            Termination of Agreement day 2 (two) : 55% of the total cost of tuition<br />
                            Termination of Agreement day 3 (three) :35% of the total cost of tuition<br />
                            Termination of Agreement day 4 (fours) :15% of the total cost of tuition<br />
                            Termination of Agreement day 5 (five) : 5% of the total cost of tuition<br />
                            After the 5th day, student does not receive any refunds.<br />
                        </p>
                    </li>
                </ol>
                </p>
                <p>
                    <b>6. Effects of Termination </b><br />
                    This Agreement cannot be terminated for other circumstances except death, complete incapacity where
                    the student cannot reason or move, any other exceptions will not be acceptable, such as economic
                    hardship. Student is responsible to fulfill this Agreement with the understanding that our
                    instructors have a commitment of employment with the school for at least 16 weeks and must get paid
                    even if the student leaves with or without notification, the school must fulfill other expenses such
                    as rent and utilities. Student is bound to this Agreement as explained on term and termination 5
                    (a).
                </p>
                <p>
                    <b>7. Severability </b><br />
                    In the event that any part of this Agreement is found to be unenforceable, the remainder will
                    continue in effect and such part will be amended, modified or narrowed, that provision will be
                    deemed amended to achieve as nearly as possible the same economic effect as the original provision
                    so as to best accomplished the objectives of such part to the extent permissible by law and
                    consistent with the intent of the parties as of the Effective Date.
                </p>
                <p>
                    <b>8. Authority </b><br />
                    Each of the parties represents to the other that the execution and delivery of this Agreement and
                    the performance of the obligations under this Agreement have been duly authorized by all requisite
                    action of the governing body of the party, if any, and that the person executing this Agreement is
                    fully authorized to bind that party. In this Agreement the authorities to bind that party are the
                    school president and the student advisors.
                </p>
                <p>
                    <b>Definitions </b><br />
                    <i>“Accreditation Standards”</i> means the Commission on English Language Accreditation (CEA) that
                    promotes
                    excellence in the field of English language administration and teaching.<br />
                    <i>“Authority”</i> means a person provided to enter into contracts or incur other obligations in
                    advance
                    of, or in excess of, funds available for that purpose.<br />
                    <i>“Classroom Setting”</i> means school’s desks, boards, computers, tables, walls, and floors.<br />
                    <i>“Instructional Materials”</i> means school’s text-book and workbooks.<br />
                    <i>“Instructor”</i>, a person who teaches something, in this case English classes.<br />
                    <i>“Personalize(d)”</i>, whether capitalized or not, means, design or produce (something) to meet
                    someone's
                    individual requirements.<br />
                    <i>“Trimester”</i> each of the three terms in an academic year. At American One this signifies 16
                    consecutive weeks of classes from the time the student enrolls in the program.<br />
                    <i>“Tuition”</i> means payment for services of classes.<br />
                    <br />
                    I have read, understood and drafted this agreement of payments and the length of the program with
                    American One English Schools INC and I know that I am subjected to this Agreement according to the
                    laws of the state of Utah in the U.S.A.
                </p>
                <br /><br />
                <div class="row" align="center">
                    <div class="column" align="center">
                        <b>
                            <span style='font-size:10.0pt'>__________________________________________</span><br />
                            <span style='font-size:10.0pt'>Student Signature</span>
                        </b>
                    </div>
                    <div class="column" align="center">
                        <b>
                            <span style='font-size:10.0pt'>__________________________________________</span><br />
                            <span style='font-size:10.0pt'>Student Full Name</span>
                        </b>
                    </div>
                </div>
                <br /><br /><br />
                <div class="row" align="center">
                    <div class="column" align="center">
                        <b>
                            <span style='font-size:10.0pt'>__________________________________________</span><br />
                            <span style='font-size:10.0pt'>Advisor Signature</span>
                        </b>
                    </div>
                    <div class="column" align="center">
                        <b>
                            <span style='font-size:10.0pt'>__________________________________________</span><br />
                            <span style='font-size:10.0pt'>Advisor Full name</span>
                        </b>
                    </div>
                </div>
            </div>
        </div>
        <?php
            $nro = 4 - intval($agreement['number_payments']);
            for ($i=0; $i < $nro; $i++) { 
                echo '<br/>';
            }
        ?>
    </div>
    <br /><br />

    <!-- agreement_ClassSchedule -->
    <div id="agreement_ClassSchedule" class=WordSection3>
        <div id="logo">
            <p class="MsoNormal" align="center" style='text-align:center;line-height:normal; border:none;padding:0in'>
                <span style='font-family:Rubik'>
                    <img height=40 src="/public/uploads/logo_print.png">
                </span>
            </p>
        </div>
        <br /><br />
        <div>
            <p class="MsoNormal" align="center" style='text-align:center;line-height:normal;border:none;padding:0in'>
                <span style='font-size:36.0pt;font-family:"Montserrat ExtraBold";color:#223367'>
                    STUDENT REGISTRATION
                </span>
            </p>
        </div>
        <br /><br />
        <h3>
            PERSONAL INFORMATION
        </h3>
        <div align="center">
            <table class="info">
                <thead>
                    <tr>
                        <th>
                            Full Name:
                        </th>
                        <th>
                            Phone Number:
                        </th>
                        <th>
                            Country:
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <?= $student_name?>
                        </td>
                        <td>
                            <?= $student_info['phone']?>
                        </td>
                        <td>
                            <?= $this->crud->get_country_name($student_info['country_id'])?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <h3>
            CURRENT SEMESTER
        </h3>
        <h6>
            <?= $student_enroll[0]['year'].' - '.$student_enroll[0]['semester_name']?>
        </h6>
        <div align="center">
            <table class="info">
                <thead>
                    <tr>
                        <th>
                            START DATE
                        </th>
                        <th>
                            END DATE
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <?= $semester_enroll['start_date']?>
                        </td>
                        <td>
                            <?= $semester_enroll['end_date']?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <h3>
            CLASS TYPE INFORMATION
        </h3>
        <div align="center">
            <table class="info">
                <thead>
                    <tr>
                        <th>
                            Type of student
                        </th>
                        <th>
                            Program
                        </th>
                        <th>
                            Level
                        </th>
                        <th>
                            Class Modality
                        </th>
                        <th>
                            Books
                        </th>
                        <th>
                            Class Time
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <?= $program_name?>
                        </td>
                        <td>
                            <?= $this->academic->get_program_type_name($agreement['program_type_id'])?>
                        </td>
                        <td>
                            <?= $student_enroll[0]['class_name']?>
                        </td>
                        <td>
                            <?= $this->academic->get_modality_name($agreement['modality_id'])?>
                        </td>
                        <td>
                            <?= $agreement['book_type']?>
                        </td>
                        <td>
                            <?= $student_enroll[0]['section_name']?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <h3>
            CLASS SCHEDULE
        </h3>
        <div align="center">
            <table class="info">
                <thead>
                    <tr>
                        <th>
                            TEACHER
                        </th>
                        <th>
                            COURSE
                        </th>
                        <th>
                            LEVEL
                        </th>
                        <th>
                            CLASSROOM
                        </th>
                        <th>
                            MONDAY - THURSDAY
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($student_enroll as $enroll):?>
                    <tr>
                        <td>
                            <?= $enroll['teacher_name']?>
                        </td>
                        <td>
                            <?= $enroll['subject_name']?>
                        </td>
                        <td>
                            <?= $enroll['class_name']?>
                        </td>
                        <td>
                            <?= $enroll['modality_id']?>
                        </td>
                        <td>
                            <?= $enroll['book_type']?>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
        <p>
            I, <?= $student_name?> understand and agree with the policies and procedures as they were explained to me on
            the date of my registration <?= $agreement_date?>. I also acknowledge that I received the policies
            orientation and rules for students.
        </p>
    </div>

    <!-- online_policies_agreements -->
    <?php if($agreement['modality_id'] == 2):?>
    <div id="online_policies_agreements" class=WordSection3>
        <div id="logo">
            <p class="MsoNormal" align="center" style='text-align:center;line-height:normal; border:none;padding:0in'>
                <span style='font-family:Rubik'>
                    <img height=40 src="/public/uploads/logo_print.png">
                </span>
            </p>
        </div>
        <br />
        <div id="policies_agreements_title">
            <p class="MsoNormal" align="center" style='text-align:center;line-height:normal;border:none;padding:0in'>
                <span style='font-size:25.0pt;font-family:"Montserrat ExtraBold";color:#223367'>
                    STUDENT REGISTRATION
                </span>
            </p>

        </div>
        <br />
        <div id="student_info">
            <table class="13" border="1" cellspacing=0 cellpadding=0 width=704
                style='border-collapse:collapse;border:none'>
                <tr style='height:0.75pt'>
                    <td width="66"
                        style='width:49.5pt;border:dotted #EFEFEF 1.0pt; background:#F3F3F3;padding:5.0pt 5.0pt 5.0pt 5.0pt;height:0.75pt'>
                        <p class="MsoNormal" align="center" style='text-align:center;line-height:normal; border:none'>
                            <b>
                                <span style='font-family:Montserrat'>Name:</span>
                            </b>
                        </p>
                    </td>
                    <td width=638 valign=top
                        style='width:478.5pt;border:dotted #EFEFEF 1.0pt;border-left:none;background:#F3F3F3;padding:5.0pt 5.0pt 5.0pt 5.0pt;height:0.75pt'>
                        <p class="MsoNormal" align="center" style='text-align:center;line-height:normal'>
                            <b>
                                <span style='font-family:Rubik;color:black'>
                                    <?=$student_name;?>
                                </span>
                            </b>
                        </p>
                    </td>
                </tr>
            </table>
        </div>
        <br />
        <div id="policies_agreements_content">
            <h1 align="center"
                style='margin-top:2.0pt;margin-right:0in;margin-bottom:0in;margin-left:0in;text-align:center;line-height:normal'>
                <b>
                    <span style='font-size:14.0pt;font-family:Montserrat;color:#365F91'>
                        ONLINE CLASSES: POLICIES AND AGREEMENTS
                    </span>
                </b>
            </h1>
            <div>
                <p class="MsoNormal" style='line-height:normal;page-break-after:avoid;margin-bottom:10px;'>
                    <b>
                        <span style='font-size:12.0pt;font-family:Rubik'>
                            Cameras
                        </span>
                    </b>
                </p>
                <div class="row">
                    <div class="column-left-20">
                        <span style='font-size:10.0pt;font-family:Rubik'>
                            ___________ Initial
                        </span>
                    </div>
                    <div class="column-right-80 ">
                        <span style='font-size:10.0pt;font-family:Rubik'>
                            I understand that I must have my camera on at all times during class. Having my camera off
                            means I’m not present in class.
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="column-left-20">
                        <span style='font-size:10.0pt;font-family:Rubik'>
                            ___________ Initial
                        </span>
                    </div>
                    <div class="column-right-80 ">
                        <span style='font-size:10.0pt;font-family:Rubik'>
                            I understand I must speak with the teachers if my camera is not available. I must give a
                            clear explanation to the DSO for an excuse not to use the camera.
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="column-left-20">
                        <span style='font-size:10.0pt;font-family:Rubik'>
                            ___________ Initial
                        </span>
                    </div>
                    <div class="column-right-80 ">
                        <span style='font-size:10.0pt;font-family:Rubik'>
                            I understand that my camera must capture my face. No ceilings, no chairs, no foreheads, no
                            pictures, and no virtual backgrounds.
                        </span>
                    </div>
                </div>
                </p>
            </div>
            <br />
            <div>
                <p class="MsoNormal" style='line-height:normal;page-break-after:avoid;margin-bottom:10px;'>
                    <b>
                        <span style='font-size:12.0pt;font-family:Rubik'>
                            Devices
                        </span>
                    </b>
                </p>
                <div class="row">
                    <div class="column-left-20">
                        <span style='font-size:10.0pt;font-family:Rubik'>
                            ___________ Initial
                        </span>
                    </div>
                    <div class="column-right-80 ">
                        <span style='font-size:10.0pt;font-family:Rubik'>
                            I understand that I must own a computer or a tablet and reliable internet. (No cellphones).
                            I also understand that students who are constantly in movement such as driving or walking
                            while connected to class will be considered absent.
                        </span>
                    </div>
                </div>
            </div>
            <br />
            <div>
                <p class="MsoNormal" style='line-height:normal;page-break-after:avoid;margin-bottom:10px;'>
                    <b>
                        <span style='font-size:12.0pt;font-family:Rubik'>
                            Participation
                        </span>
                    </b>
                </p>
                <div class="row">
                    <div class="column-left-20">
                        <span style='font-size:10.0pt;font-family:Rubik'>
                            ___________ Initial
                        </span>
                    </div>
                    <div class="column-right-80 ">
                        <span style='font-size:10.0pt;font-family:Rubik'>
                            I understand that if I do not respond to the instructor while connected I will be considered
                            absent.
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <br />
        <p class="MsoNormal" style='margin-bottom:10.0pt;text-align:justify;line-height:normal'>
            <span style='font-size:9.0pt;font-family:"Rubik ExtraBold"'>
                <b>
                    I have carefully read this agreement and fully understand its contents. I am signing it of my own
                    free will, and I understand that by signing this document, I acknowledge that not complying with the
                    above policies will negatively affect my grades.
                </b>
            </span>
        </p>
        <br /><br />
        <br /><br />
        <br /><br /><br /><br />
        <div class="row" align="center">
            <div class="column" align="center">
                <b>
                    <span style='font-size:10.0pt'>__________________________________________</span><br />
                    <span style='font-size:10.0pt'>Student Signature</span>
                </b>
            </div>
            <div class="column" align="center">
                <b>
                    <span style='font-size:10.0pt'>__________________________________________</span><br />
                    <span style='font-size:10.0pt'>American One English Schools, INC</span>
                </b>
            </div>
        </div>
    </div>
    <?php endif;?>

    <!-- automatic_payment -->
    <?php if($agreement['automatic_payment']):?>
    <div id="card_information" class=WordSection1>
        <div id="logo">
            <p class="MsoNormal" align="center" style='text-align:center;line-height:normal; border:none;padding:0in'>
                <span style='font-family:Rubik'>
                    <img height=40 src="/public/uploads/logo_print.png">
                </span>
            </p>
        </div>
        <br>
        <br>
        <div>
            <p class="MsoNormal" align="center" style='text-align:center;line-height:normal;border:none;padding:0in'>
                <span style='font-size:36.0pt;font-family:"Montserrat ExtraBold";color:#223367'>
                    CREDIT CARD INFORMATION
                </span>
            </p>
        </div>
        <br /> <br /> <br />
        <table>
            <tr style='height:22.5pt'>
                <td>
                    <p>Name of Student:</p>
                </td>
                <td width=584 valign=top
                    style='border-bottom:solid #222222 1.0pt;  padding:5.0pt 5.0pt 5.0pt 5.0pt;height:22.5pt'>
                    <p class="MsoNormal" align="center">
                        <span lang=EN style='font-family:Rubik'><?=$student_name?>
                        </span>
                    </p>
                </td>
            </tr>
        </table>
        <br /> <br /> <br />

        <span lang=EN style='font-size:10.0pt;font-family:Rubik'>
            I wish to pay a down payment of $ <?=$agreement['down_payment']?> on the contract AMERICAN ONE.
        </span>
        </p>


        <span lang=EN style='font-size:10.0pt;font-family:Rubik'>
            I authorize AMERICAN ONE to <b>charge automatic payments on my credit card account</b> on the
            <?=$agreement['payment_date']?> of each month for <?=$number_payments?> months in the
            amount of <?= $amount_agreed ?> to be applied to my financial contract for English classes. I
            further understand that at any time the payment amount is rejected by the credit card company; I will be
            billed for a $25.00 late fee.
        </span>
        </p>

        <br /><br />
        <br /><br />
        <div class=center>
            <table class="credit-card center">
                <tr>
                    <td class="line">
                        <?= $agreement_card['card_holder']?>
                    </td>
                    <td class="line">
                        <?= get_decrypt($agreement_card['zip_code'])?>
                    </td>
                    <td class="line">
                        <?= $this->payment->get_credit_card_name($agreement_card['type_card_id'])?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Name of Card Holder
                    </td>
                    <td>
                        Zip Code
                    </td>
                    <td>
                        Card Name
                    </td>
                </tr>
                <tr>
                    <td class="line">
                        <?= get_decrypt($agreement_card['card_number'])?>
                    </td>
                    <td class="line">
                        <?= get_decrypt($agreement_card['security_code'])?>
                    </td>
                    <td class="line">
                        <?= get_decrypt($agreement_card['expiration_date'])?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Credit Card Number
                    </td>
                    <td>
                        Sec Code
                    </td>
                    <td>
                        Expiration Date
                    </td>
                </tr>
                <tr>
                    <td class="line">
                    </td>
                    <td class="line" colspan="2">
                    </td>
                </tr>
                <tr>
                    <td>
                        Card Holder Signature
                    </td>
                    <td colspan="2">
                        American One Representative
                    </td>

                </tr>
            </table>
        </div>
        <br>
        <br>

        <p class="MsoNormal" style='margin-bottom:10.0pt;text-align:justify;line-height:normal'>
            <i style='font-size:10.0pt;font-family:Rubik'>
                If <?=$student_name?> doesn’t pay in cash every month for the next <?=$agreement['number_payments']?>
                payment(s). American
                One will charge the credit or debit card to receive the payment after 2 days of being overdue. *American
                Express, Discover or Mastercard payments will have an additional 5% charge.
            </i>
        </p>
        <br>
        <br><br>
        <br>
        <div class=center>
            <table class="credit-card center">
                <tr>
                    <td class="line">
                    </td>
                    <td class="line">
                    </td>
                </tr>
                <tr>
                    <td>
                        Card Holder Signature
                    </td>
                    <td>
                        American One Representative
                    </td>

                </tr>
            </table>
        </div>

    </div>
    <?php endif;?>
</body>

</html>