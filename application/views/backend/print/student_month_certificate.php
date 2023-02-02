<?php 

    $class_name		 	= 	$this->db->get_where('class' , array('class_id' => $class_id))->row()->name;
    $section_name       =   $this->db->get_where('section' , array('section_id' => $section_id))->row()->name;
    $semester_name      =   $this->db->get_where('semesters' , array('semester_id' => $semester_id))->row()->name;
?>

<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>SOTM CERTIFICATE</title>
    <style type="text/css">
    * {
        margin: 0;
        padding: 0;
        text-indent: 0;
    }

    .s1 {
        color: #213366;
        font-family: "Palatino Linotype", serif;
        font-style: italic;
        font-weight: normal;
        text-decoration: none;
        font-size: 46pt;
    }

    .s2 {
        color: #213366;
        font-family: "Palatino Linotype", serif;
        font-style: italic;
        font-weight: normal;
        text-decoration: none;
        font-size: 35pt;
    }

    h1 {
        color: #C00;
        font-family: "Montserrat Black";
        font-style: normal;
        font-weight: bold;
        text-decoration: none;
        font-size: 14pt;
    }

    p {
        color: #999;
        font-family: "Montserrat SemiBold";
        font-style: normal;
        font-weight: bold;
        text-decoration: none;
        font-size: 12pt;
        margin: 0pt;
    }
    </style>
    <link href="/public/style/print/smc.css" media="all" rel="stylesheet">
</head>

<body background="/public/style/print/images/smc.png" bgcolor="FFCECB" background-repeat: no-repeat; style="width: 11in; height: 8.5;">
    <p class="s1" style="padding-left: 100pt;text-indent: 0pt;line-height: 56pt;text-align: center;">&nbsp;</p>
    <p class="s1" style="padding-left: 100pt;text-indent: 0pt;line-height: 56pt;text-align: center;">&nbsp;</p>
    <p class="s1" style="padding-left: 100pt;text-indent: 0pt;line-height: 56pt;text-align: center;">&nbsp;</p>
    <p class="s1" style="padding-left: 100pt;text-indent: 0pt;line-height: 56pt;text-align: center;">&nbsp;</p>
    <p class="s1"
        style="padding-left: 100pt; padding-top: 45pt; text-indent: 0pt;line-height: 50pt;text-align: center;">
        &lt;&lt;<span class="s2">Name</span>&gt;&gt;</p>
    <p class="s1" style="padding-left: 100pt; line-height: 50pt; text-align: center;">&lt;&lt;<span class="s2">Last
            Name</span>&gt;&gt;</p>
    <p style="padding-left: 100pt; padding-top: 50pt; 0pt;line-height: 16pt;text-align: center;">Date:
        &lt;&lt;Date&gt;&gt;</p>
    <p style="text-indent: 0pt;text-align: left;"><span></span></p>
    <h1 style="padding-top: 00pt;padding-left: 100pt;text-indent: 0pt;line-height: 19pt;text-align: center;">
        &lt;&lt;Month&gt;&gt;&nbsp;</h1>
    <p style="text-indent: 0pt;text-align: left;"></p>
</body>

</html>