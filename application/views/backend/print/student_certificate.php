<?php 

    $class_name		 	= 	$this->db->get_where('class' , array('class_id' => $class_id))->row()->name;
    $section_name       =   $this->db->get_where('section' , array('section_id' => $section_id))->row()->name;
    $semester_name      =   $this->db->get_where('semesters' , array('semester_id' => $semester_id))->row()->name;
?>

<html>

<header>
    <link href="/public/uploads/print/agreement.css" media="all" rel="stylesheet">
</header>

<body>
    <h1>Student Certificate</h1>
    <br/>
    <h2><?=$section_name;?></h2>
    <br/>
    <h3><?=$semester_name;?></h3>
    <br/>
    
</body>