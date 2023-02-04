<?php 
    $student_request = $this->db->get_where('student_request', array('request_id' => $request_id))->row_array();
    $student_info = $this->db->get_where('v_students', array('student_id' => $student_request['student_id']))->row_array();

?>
<html>

</html>

<head>
    <meta content="text/html; charset=UTF-8" http-equiv="content-type">
    <link href="/public/uploads/print/vacation_request.css" media="all" rel="stylesheet">
</head>

<body class="c10 doc-content">
    <div>
        <p class="c5">
            <span
                style="overflow: hidden; display: inline-block; margin: 0.00px 0.00px; border: 0.00px solid #000000; transform: rotate(0.00rad) translateZ(0px); -webkit-transform: rotate(0.00rad) translateZ(0px); width: 735.00px; height: 97.28px;">
                <img alt="" src="/public/style/print/images/image1.png"
                    style="width: 735.00px; height: 120.57px; margin-left: -0.00px; margin-top: -23.28px; transform: rotate(0.00rad) translateZ(0px); -webkit-transform: rotate(0.00rad) translateZ(0px);"
                    title="">
            </span>
        </p>
    </div>
    <p class="c2"><span class="c8"></span></p>
    <p class="c2"><span class="c8"></span></p>
    <p class="c2"><span class="c8"></span></p>
    <p class="c6"><span class="c13">VACATION REQUEST</span></p>
    <p class="c2"><span class="c1"></span></p>
    <p class="c4"><span class="c0">Student&rsquo;s name:</span> <b><?=$student_info['full_name']?></b></p>
    <p class="c4"><span class="c0">Semester:</span>
        <b><?=$student_request['year'].' - '.$this->academic->get_semester_name($student_request['semester_id']) ?></b>
    </p>
    <p class="c3"><span class="c0">Students who comply with immigration policies by maintaining a minimum attendance of
            80% and minimum academic grade of 80% for the last two consecutive semesters will be eligible for vacation
            request.</span></p>
    <p class="c3"><span class="c0">Students who request permission under emergency or health problems must give a brief
            description of the situation. For the approval to be valid, it must be signed by the (P)DSO.</span></p>
    <p class="c3"><span class="c0">The student will receive a copy of the vacation approval and the original will be
            kept in the student&rsquo;s files for immigration supervision.</span></p>
    <p class="c3"><span class="c0">The vacation request grants an academic leave for up to four months. Transfer
            students will be required to bring proof of previous programs attended.</span></p>
    <p class="c3"><span class="c12">&nbsp;</span></p>
    <p class="c6"><span class="c9">&nbsp;</span></p>
    <br /><br /><br /><br />
    <p class="c6"><span class="c7">DSO/PDSO signature</span></p>
    <p class="c5 c11"><span class="c9"></span></p>
    <br /><br />
    <div>
        <p class="c5">
            <span
                style="overflow: hidden; display: inline-block; margin: 0.00px 0.00px; border: 0.00px solid #000000; transform: rotate(0.00rad) translateZ(0px); -webkit-transform: rotate(0.00rad) translateZ(0px); width: 749.50px; height: 25.94px;"><img
                    alt="" src="/public/style/print/images/image2.png"
                    style="width: 749.50px; height: 25.94px; margin-left: 0.00px; margin-top: 0.00px; transform: rotate(0.00rad) translateZ(0px); -webkit-transform: rotate(0.00rad) translateZ(0px);"
                    title=""></span>
        </p>
    </div>
</body>

</html>