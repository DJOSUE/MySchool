<?php 
    $info = $this->db->get_where('v_student_month' , array('student_month_id' => $student_month_id))->row_array(); 
?>

<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="/public/style/print/smc.css" media="all" rel="stylesheet">
</head>

<body class="" style="width: 11in; height: 8.5in;">
    <div class="<?= $info['is_best'] == 1 ? 'image-best' : 'image'?>" style="width: 1047; height: 804;">
        <p class="s1" style="padding-left: 100pt;text-indent: 0pt;line-height: 56pt;text-align: center;">&nbsp;</p>
        <p class="s1" style="padding-left: 100pt;text-indent: 0pt;line-height: 56pt;text-align: center;">&nbsp;</p>
        <p class="s1" style="padding-left: 100pt;text-indent: 0pt;line-height: 56pt;text-align: center;">&nbsp;</p>
        <p class="s1" style="padding-left: 100pt;text-indent: 0pt;line-height: 56pt;text-align: center;">&nbsp;</p>
        <p class="s1"
            style="padding-left: 50pt; padding-top: 60pt; text-indent: 0pt;line-height: 50pt;text-align: center;">
            <span class="s2">
                <?= $info['first_name']?>
            </span>
        </p>
        <p class="s1" style="padding-left: 50pt; line-height: 50pt; text-align: center;">
            <span class="s2">
                <?= $info['last_name']?>
            </span>
        </p>
        <p style="padding-left: 50PT; padding-top: 55pt;line-height: 16pt;text-align: center;">            
            <?= ''//'Date: '.get_month_name($info['month'])?>
        </p>
        <p style="text-indent: 0pt;text-align: left;"><span></span></p>
        <h1 style="padding-top: 00pt;padding-left: 50pt;text-indent: 0pt;line-height: 19pt;text-align: center;">
            <?= get_month_name($info['month'])?>
        </h1>
        <p style="text-indent: 0pt;text-align: left;"></p>
    </div>
</body>
