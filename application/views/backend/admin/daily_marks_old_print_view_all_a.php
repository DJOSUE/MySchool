<?php
    $system_name        =	$this->crud->getInfo('system_name');
    $system_email       =   $this->crud->getInfo('system_email');
    
    $roundPrecision     =   $this->crud->getInfo('round_precision');
    $phone              =   $this->crud->getInfo('phone');

    $info = base64_decode($data);
    $ex = explode("-",$info);

    $section_id     =   $ex[2];
    $year           =   $ex[3];
    $semester_id    =   $ex[4];

	$class_name		= 	$this->db->get_where('class' , array('class_id' => $class_id))->row()->name;    
	

	
?>
<link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500" rel="stylesheet" type="text/css">
<link
    href="<?php echo base_url();?>public/style/cms/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css"
    rel="stylesheet">
<link href="<?php echo base_url();?>public/style/cms/css/main.css?version=3.3" rel="stylesheet">
<style>
* {
    -webkit-print-color-adjust: exact !important;
    /* Chrome, Safari */
    color-adjust: exact !important;
    /*Firefox*/
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
                                <div class="company-name"><?php echo $exam_name;?></div>
                                <div class="company-address"><?php echo getPhrase('marks');?></div>
                            </div>
                            <div class="info-2">
                                <div class="rcard-profile">
                                    <img alt="" src="<?php echo $this->crud->get_image_url('student', $student_id);?>">
                                </div>
                                <div class="company-name"><?php echo $this->crud->get_name('student' , $student_id);?>
                                </div>
                                <div class="company-address">
                                    <?php echo getPhrase('roll');?>:
                                    <?php echo $this->db->get_where('enroll', array('student_id' => $student_id))->row()->roll;?>
                                    <br />
                                    <?= $class_name;?>
                                    <br />
                                    <?php echo $this->db->get_where('section' , array('section_id' => $section_id))->row()->name;?>
                                </div>
                            </div>
                        </div>
                        <div class="rcard-heading">
                            <h5><?php echo $year.' - '.$this->db->get_where('semesters', array('semester_id' => $semester_id))->row()->name;?></h5>
                        </div>
                        <br/>
                        <br/>
                        <div class="rcard-table table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center"><?php echo getPhrase('year')?></th>
                                        <th class="text-center"><?php echo getPhrase('semester')?></th>
                                        <th class="text-center"><?php echo getPhrase('class')?></th>
                                        <th class="text-center"><?php echo getPhrase('attendance')?></th>
                                        <th class="text-center"><?php echo getPhrase('mark')?></th>
                                        <th class="text-center"><?php echo getPhrase('grade')?></th>
                                        <th class="text-center"><?php echo getPhrase('gpa')?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $enrollments = $this->db->query("SELECT class_id, class_name, section_id, section_name, year, semester_id, semester_name FROM v_enroll 
                                                                          WHERE student_id = '$student_id'
                                                                       GROUP BY class_id, section_id 
                                                                      ")->result_array();

                                        foreach ($enrollments as $enroll):
                                            $class_id    = $enroll['class_id'];
                                            $section_id  = $enroll['section_id'];
                                            $year        = $enroll['year'];
                                            $semester_id = $enroll['semester_id'];

                                            $average = $this->db->query("SELECT ROUND((SUM(labuno)/COUNT(IF(labuno = '-' or labuno is null,null,'1'))), $roundPrecision) AS 'labuno',
                                                                                ROUND((SUM(labdos)/COUNT(IF(labdos = '-' or labdos is null,null,'1'))), $roundPrecision) AS 'labdos',
                                                                                ROUND((SUM(labtres)/COUNT(IF(labtres = '-' or labtres is null,null,'1'))), $roundPrecision) AS 'labtres',
                                                                                ROUND((SUM(labcuatro)/COUNT(IF(labcuatro = '-' or labcuatro is null,null,'1'))), $roundPrecision) AS 'labcuatro',
                                                                                ROUND((SUM(labcinco)/COUNT(IF(labcinco = '-' or labcinco is null,null,'1'))), $roundPrecision) AS 'labcinco',
                                                                                ROUND((SUM(labseis)/COUNT(IF(labseis = '-' or labseis is null,null,'1'))), $roundPrecision) AS 'labseis',
                                                                                ROUND((SUM(labsiete)/COUNT(IF(labsiete = '-' or labsiete is null,null,'1'))), $roundPrecision) AS 'labsiete',
                                                                                ROUND((SUM(labocho)/COUNT(IF(labocho = '-' or labocho is null,null,'1'))), $roundPrecision) AS 'labocho',
                                                                                ROUND((SUM(labnueve)/COUNT(IF(labnueve = '-' or labnueve is null,null,'1'))), $roundPrecision) AS 'labnueve',
                                                                                ROUND((SUM(labdiez)/COUNT(IF(labdiez = '-' or labdiez is null,null,'1'))), $roundPrecision) AS 'labdiez'
                                                                            FROM mark_daily 
                                                                            WHERE student_id = '$student_id'
                                                                                AND class_id = '$class_id'
                                                                                AND section_id = '$section_id'
                                                                                AND year = '$year'
                                                                                AND semester_id = '$semester_id'
                                                                            ")->first_row();

                                            // Calculate the average 
                                            $count = 0;
                                            
                                            $labouno        = $average->labuno;
                                            $labodos        = $average->labdos;
                                            $labotres       = $average->labtres;
                                            $labocuatro     = $average->labcuatro;
                                            $labocinco      = $average->labcinco;
                                            $laboseis       = $average->labseis;
                                            $labosiete      = $average->labsiete;
                                            $laboocho       = $average->labocho;
                                            $labonueve      = $average->labnueve;
                                            $labodiez       = $average->labdiez;

                                            // Validate values
                                            if($labouno     == '' ) { $labouno      = '-'; } 
                                            if($labodos     == '' ) { $labodos      = '-'; }  
                                            if($labotres    == '' ) { $labotres     = '-'; }  
                                            if($labocuatro  == '' ) { $labocuatro   = '-'; }  
                                            if($labocinco   == '' ) { $labocinco    = '-'; }
                                            if($laboseis    == '' ) { $laboseis     = '-'; } 
                                            if($labosiete   == '' ) { $labosiete    = '-'; }  
                                            if($laboocho    == '' ) { $laboocho     = '-'; }  
                                            if($labonueve   == '' ) { $labonueve    = '-'; }  
                                            if($labodiez    == '' ) { $labodiez     = '-'; }

                                            if(is_numeric($average->labuno)     && $average->labuno != '' ) { $count++; } 
                                            if(is_numeric($average->labdos)     && $average->labdos != '' ) { $count++; }  
                                            if(is_numeric($average->labtres)    && $average->labtres != '' ) { $count++; }  
                                            if(is_numeric($average->labcuatro)  && $average->labcuatro != '' ) { $count++; }  
                                            if(is_numeric($average->labcinco)   && $average->labcinco != '') { $count++; }
                                            if(is_numeric($average->labseis)    && $average->labseis != '' ) { $count++; } 
                                            if(is_numeric($average->labsiete)   && $average->labsiete != '' ) { $count++; }  
                                            if(is_numeric($average->labocho)    && $average->labocho != '' ) { $count++; }  
                                            if(is_numeric($average->labnueve)   && $average->labnueve != '' ) { $count++; }  
                                            if(is_numeric($average->labdiez)    && $average->labdiez != '' ) { $count++; }                                                            
                                            
                                            $labototal      = (float)$labouno + (float)$labodos + (float)$labotres + (float)$labocuatro + (float)$labocinco + (float)$laboseis + (float)$labosiete + (float)$laboocho + (float)$labonueve + (float)$labodiez;
                                            $attendance     = $labouno;
                                            $mark = $count > 0 ? round(($labototal/$count), (int)$roundPrecision) : '-';
                                            
                                    ?>
                                    <tr>
                                        <td><?php echo $enroll['year'];?></td>
                                        <td><?php echo $enroll['semester_name'];?></td>
                                        <td><?php echo $enroll['class_name'];?></td>
                                        <td class="text-center"><?php echo $attendance;?></td>
                                        <td class="text-center"><?php echo $mark;?></td>
                                        <td><?= $grade = $this->crud->get_grade($mark);?></td>
                                        <td><?= $gpa = $this->crud->get_gpa($mark);?></td>
                                    </tr>
                                    <?php endforeach; ?>                                    
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