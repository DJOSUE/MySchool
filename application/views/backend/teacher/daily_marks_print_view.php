<?php
    $roundPrecision     =   $this->crud->getInfo('round_precision');
    $running_year       =   $this->crud->getInfo('running_year');
    $running_semester   =   $this->crud->getInfo('running_semester'); 

	$class_name		 	= 	$this->db->get_where('class' , array('class_id' => $class_id))->row()->name;
    $section_id         =   $this->db->get_where('enroll' , array('student_id' => $student_id, 'class_id' => $class_id, 'year' => $running_year, 'semester_id' => $running_semester))->row()->section_id;
	$exam_name  		= 	$this->db->get_where('units' , array('unit_id' => $unit_id))->row()->name;
	$system_name        =	$this->crud->getInfo('system_name');
    $system_email       =   $this->crud->getInfo('system_email');
    $phone              =   $this->crud->getInfo('phone');

    $count_all  = 0;
    $total_all  = 0;

?>
 <title><?php echo $page_title;?> | <?php echo $system_name;?></title>
<link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500" rel="stylesheet" type="text/css">
<link
    href="<?php echo base_url();?>public/style/cms/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css"
    rel="stylesheet">
<link href="<?php echo base_url();?>public/style/cms/css/main.css?version=3.3" rel="stylesheet">
<link href="<?php echo base_url();?>public/style/cms/icon_fonts_assets/simple-line-icons/css/simple-line-icons.css"
    rel="stylesheet">
<link href="<?php echo base_url();?>public/style/cms/icon_fonts_assets/picons-thin/style.css" rel="stylesheet">
<link href="<?php echo base_url();?>public/style/cms/icon_fonts_assets/picons-social/style.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<style>
* {
    -webkit-print-color-adjust: exact !important;
    /* Chrome, Safari */
    color-adjust: exact !important;
    /*Firefox*/
    ;
}
</style>
<div class="content-w">
    <div class="content-i">
        <div class="content-box">
            <div class="element-wrapper">
                <div class="rcard-wy" id="print_area">
                    <div class="rcard-w">
                        <div class="infos">
                            <div class="info-1">
                                <div class="rcard-logo-w">
                                    <img alt=""
                                        src="<?php echo base_url();?>public/uploads/<?php echo $this->crud->getInfo('logo');?>">
                                </div>
                                <div class="company-name"><?php echo $system_name;?></div>
                                <div class="company-address"><?php echo getPhrase('marks');?></div>
                            </div>
                            <div class="info-2">
                                <div class="rcard-profile">
                                    <img alt="" src="<?php echo $this->crud->get_image_url('student', $student_id);?>">
                                </div>
                                <div class="company-name"><?php echo $this->crud->get_name('student', $student_id);?>
                                </div>
                                <div class="company-address">
                                    <?php echo getPhrase('roll');?>:
                                    <?php echo $this->db->get_where('enroll', array('student_id' => $student_id))->row()->roll;?><br />
                                    <?php echo $class_name;?><br />
                                    <?php echo $this->db->get_where('section' , array('class_id' => $section_id))->row()->name;?>
                                </div>
                            </div>
                        </div>
                        <div class="rcard-heading">
                            <h5><?php echo $exam_name;?></h5>
                            <div class="rcard-date"><?php echo $class_name;?></div>
                        </div>
                        <div class="rcard-table table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center"><?php echo getPhrase('subject');?></th>
                                        <th class="text-center"><?php echo getPhrase('teacher');?></th>
                                        <th class="text-center"><?php echo getPhrase('mark');?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $exams = $this->crud->get_exams();
                                        $subjects = $this->db->get_where('v_enroll' , array('class_id' => $class_id, 'section_id' => $section_id, 'student_id' => $student_id,'year' => $running_year, 'semester_id' => $running_semester))->result_array();
                                        
                                        foreach ($subjects as $row3):
                                            $subject_id = $row3['subject_id'];
                                            $average = $this->db->query("SELECT ROUND((SUM(labuno)/COUNT(IF(labuno = '-' or labuno IS NULL,null,'1'))), $roundPrecision) AS 'labuno',
                                                                                ROUND((SUM(labdos)/COUNT(IF(labdos = '-' or labdos IS NULL,null,'1'))), $roundPrecision) AS 'labdos',
                                                                                ROUND((SUM(labtres)/COUNT(IF(labtres = '-' or labtres IS NULL,null,'1'))), $roundPrecision) AS 'labtres',
                                                                                ROUND((SUM(labcuatro)/COUNT(IF(labcuatro = '-' or labcuatro IS NULL,null,'1'))), $roundPrecision) AS 'labcuatro',
                                                                                ROUND((SUM(labcinco)/COUNT(IF(labcinco = '-' or labcinco IS NULL,null,'1'))), $roundPrecision) AS 'labcinco',
                                                                                ROUND((SUM(labseis)/COUNT(IF(labseis = '-' or labseis IS NULL,null,'1'))), $roundPrecision) AS 'labseis',
                                                                                ROUND((SUM(labsiete)/COUNT(IF(labsiete = '-' or labsiete IS NULL,null,'1'))), $roundPrecision) AS 'labsiete',
                                                                                ROUND((SUM(labocho)/COUNT(IF(labocho = '-' or labocho IS NULL,null,'1'))), $roundPrecision) AS 'labocho',
                                                                                ROUND((SUM(labnueve)/COUNT(IF(labnueve = '-' or labnueve IS NULL,null,'1'))), $roundPrecision) AS 'labnueve',
                                                                                ROUND((SUM(labdiez)/COUNT(IF(labdiez = '-' or labdiez IS NULL,null,'1'))), $roundPrecision) AS 'labdiez'
                                                                        FROM mark_daily 
                                                                        WHERE student_id = '$student_id'
                                                                            AND class_id = '$class_id'
                                                                            AND section_id = '$section_id'
                                                                            AND subject_id = '$subject_id'
                                                                            AND unit_id = '$unit_id'
                                                                            AND year = '$running_year'
                                                                            AND semester_id = '$running_semester' 
                                                                            ")->result_array();
                                            // Math to get Average
                                            $Total_Sum = array_sum($average[0]);
                                            $count = 0;
                                            
                                            $labouno        = $average[0][labuno];
                                            $labodos        = $average[0][labdos];
                                            $labotres       = $average[0][labtres];
                                            $labocuatro     = $average[0][labcuatro];
                                            $labocinco      = $average[0][labcinco];
                                            $laboseis       = $average[0][labseis];
                                            $labosiete      = $average[0][labsiete];
                                            $laboocho       = $average[0][labocho];
                                            $labonueve      = $average[0][labnueve];
                                            $labodiez       = $average[0][labdiez];
                                
                                            // Calculate the average 
                                            if(is_numeric($labouno)     && $labouno != '-' ) { $count++; } 
                                            if(is_numeric($labodos)     && $labodos != '-' ) { $count++; }  
                                            if(is_numeric($labotres)    && $labotres != '-' ) { $count++; }  
                                            if(is_numeric($labocuatro)  && $labocuatro != '-' ) { $count++; }  
                                            if(is_numeric($labocinco)   && $labocinco != '-') { $count++; }
                                            if(is_numeric($laboseis)    && $laboseis != '-' ) { $count++; } 
                                            if(is_numeric($labosiete)   && $labosiete != '-' ) { $count++; }  
                                            if(is_numeric($laboocho)    && $laboocho != '-' ) { $count++; }  
                                            if(is_numeric($labonueve)   && $labonueve != '-' ) { $count++; }  
                                            if(is_numeric($labodiez)    && $labodiez != '-') { $count++; }

                                            $count_all++;

                                            if($Total_Sum > 0){       
                                                $mark =  round(($Total_Sum/$count),$roundPrecision);
                                                $total_all += $mark;
                                            } 
                                            else{
                                                $mark = "-";
                                            }
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $row3['subject_name'];?>
                                        </td>
                                        <td>
                                            <?php 
                                                $teacher = $this->db->get_where('v_subject', array('subject_id' => $row3['subject_id']))->row();
                                                echo $teacher->teacher_name;
                                            ?>
                                        </td>
                                        <td class="text-center">
                                            <?php echo $mark; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; 

                                        if($total_all > 0)
                                            $mark_all =  round(($total_all/$count_all),$roundPrecision);
                                        else
                                            $mark_all = "-";

                                    ?>
                                    <tr>
                                        <td></td>
                                        <td style="text-align: right;"><?= getPhrase('average');?></td>
                                        <td class="text-center"><?= $mark_all;?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="rcard-footer">
                            <div class="rcard-logo">
                                <img alt=""
                                    src="<?php echo base_url();?>public/uploads/<?php echo $this->crud->getInfo('logo');?>"><span><?php echo $system_name;?></span>
                            </div>
                            <div class="rcard-info">
                                <span><?php echo $system_email;?></span><span><?php echo $phone;?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn btn-info btn-rounded"
                onclick="printDiv('print_area')"><?php echo getPhrase('print');?></button>
        </div>
    </div>
</div>

<script>
function printDiv(nombreDiv) {
    var contenido = document.getElementById(nombreDiv).innerHTML;
    var contenidoOriginal = document.body.innerHTML;
    document.body.innerHTML = contenido;
    window.print();
    document.body.innerHTML = contenidoOriginal;
}
</script>