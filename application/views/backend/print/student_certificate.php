<?php 
    $student_info   = $this->db->get_where('student' , array('student_id' => $student_id))->row_array();
    $semester_info  = $this->db->get_where('semester_enroll' , array('semester_id' => $semester_id, 'year' => $year))->row_array();
?>

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="/public/style/print/student_certificate.css" media="all" rel="stylesheet">
</head>

<body class="" style="width: 11in; height: 8.5in;">
    <div class="image">
        <br/><br/><br/><br/><br/><br/>
        <br/><br/><br/><br/><br/>
        <p class="s1">
            <?=$student_info['first_name'];?>
        </p>
        <p class="s1">
            <?=$student_info['last_name']?>
        </p>
        <p style="padding-top: 10pt; text-align: center;">
            has successfully completed the required 16 credit hours
            <br/>
            of study for Intermediateand is therefore awarded this.
        </p>
        <br/>
        <p style="padding-left: 0pt; padding-top: 50pt; text-align: center;">
            Given this <?=$semester_info['end_date']?>
        </p>
        
    </div>   
</body>
</html>