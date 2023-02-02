<?php 
    $min            = $this->crud->getInfo('minium_mark');
    $running_year   = $this->crud->getInfo('running_year');
    $running_semester   = $this->crud->getInfo('running_semester'); 
    $roundPrecision = $this->crud->getInfo('round_precision');
    $quantityGrades = $this->crud->getInfo('quantity_grades');
    $useDailyMarks  = $this->crud->getInfo('use_daily_marks');
    

	$encode_data = $data;
	$decode_data = base64_decode($encode_data);
	$explode_data = explode("-", $decode_data);

    $class_id   = $explode_data[0];
    $section_id = $explode_data[1];
    $subject_id = $explode_data[2];
    $unit_id    = $explode_data[3];
    $student_id = $explode_data[4];

    $grades[] = [1, 'labuno', 'la1'];
    $grades[] = [2, 'labdos', 'la2'];
    $grades[] = [3, 'labtres', 'la3'];
    $grades[] = [4, 'labcuatro', 'la4'];
    $grades[] = [5, 'labcinco', 'la5'];
    $grades[] = [6, 'labseis', 'la6'];
    $grades[] = [7, 'labsiete', 'la7'];
    $grades[] = [8, 'labocho', 'la8'];
    $grades[] = [9, 'labnueve', 'la9'];
    $grades[] = [10, 'labdiez', 'la10'];


?>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="content-i">
            <div class="content-box">
                <div class="back"> <a href="<?php echo base_url();?>teacher/students_area/"><i
                            class="picons-thin-icon-thin-0131_arrow_back_undo"></i></a> </div>
                <div class="row">
                    <div class="col-sm-8">
                        <div class="element-box lined-primary">
                            <h5 class="form-header">
                                <?php echo getPhrase('subject_marks');?><br>
                                <small><?php echo $this->db->get_where('subject', array('subject_id' => $subject_id))->row()->name;?></small>
                            </h5>
                            <div class="table-responsive">
                                <table class="table table-lightborder">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th><?php echo getPhrase('activity');?></th>
                                            <th><?php echo getPhrase('mark');?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                                
                                                $subject =  $this->db->get_where('subject' , array('subject_id' => $subject_id))->result_array();

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
                                                $Total_Sum = array_sum($average[0]) -  $average[0][labuno];
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
                                                // if(is_numeric($labouno)     && $labouno != '-' ) { $count++; } 
                                                if(is_numeric($labodos)     && $labodos != '-' ) { $count++; }  
                                                if(is_numeric($labotres)    && $labotres != '-' ) { $count++; }  
                                                if(is_numeric($labocuatro)  && $labocuatro != '-' ) { $count++; }  
                                                if(is_numeric($labocinco)   && $labocinco != '-') { $count++; }
                                                if(is_numeric($laboseis)    && $laboseis != '-' ) { $count++; } 
                                                if(is_numeric($labosiete)   && $labosiete != '-' ) { $count++; }  
                                                if(is_numeric($laboocho)    && $laboocho != '-' ) { $count++; }  
                                                if(is_numeric($labonueve)   && $labonueve != '-' ) { $count++; }  
                                                if(is_numeric($labodiez)    && $labodiez != '-') { $count++; }

                                                if($Total_Sum > 0)
                                                    $mark =  round(($Total_Sum/$count),$roundPrecision);
                                                else
                                                    $mark = "-";
                                                
                                                for ($i=0; $i < $quantityGrades; $i++):
                                                    $name = $grades[$i];
                                            ?>
                                        <tr>
                                            <td><?= $i+1;?></td>
                                            <td><?php echo $subject[0][$name[2]];?></td>
                                            <td>
                                                <a class="btn nc btn-rounded btn-sm btn-secondary" style="color:white">
                                                    <?php echo $average[0][$name[1]];?></label> 
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endfor;?>
                                        <tr style="border-top: solid #a5a5a5;">
                                            <td>-</td>
                                            <td><?php echo getPhrase('total');?></td>
                                            <td>
                                                <?php if(($mark < $min || $mark == 0) && $mark != '-'):?>
                                                <a class="btn btn-rounded btn-sm btn-danger"
                                                    style="color:white"><?php if($mark == '' ) echo '0'; else echo $mark;?></a>
                                                <?php endif;?>
                                                <?php if($mark >= $min):?>
                                                <a class="btn btn-rounded btn-sm btn-info"
                                                    style="color:white"><?php echo $mark;?></a>
                                                <?php endif;?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="pipeline white lined-secondary">
                            <div class="pipeline-header">
                                <h5 class="pipeline-name"><?php echo getPhrase('student');?></h5>
                            </div>
                            <div class="pipeline-item">
                                <div class="pi-foot">
                                    <a class="extra-info" href="javascript:void(0);"><img alt=""
                                            src="<?php echo base_url();?>public/uploads/<?php echo $this->crud->getInfo('logo');?>"
                                            width="10%" style="margin-right:5px"><span
                                            class="text-white"><?php echo $this->crud->getInfo('system_name');?></span></a>
                                </div>
                                <div class="pi-body">
                                    <div class="avatar">
                                        <img alt=""
                                            src="<?php echo $this->crud->get_image_url('student',$student_id);?>">
                                    </div>
                                    <div class="pi-info">
                                        <div class="h6 pi-name">
                                            <?php echo $this->crud->get_name('student', $student_id);?><br>
                                            <small><?php echo getPhrase('roll');?>:
                                                <?php echo $this->db->get_where('enroll', array('student_id' => $student_id))->row()->roll;?></small>
                                        </div>
                                        <?php $class_id = $this->db->get_where('subject', array('subject_id' => $explode_data[2]))->row()->class_id;?>
                                        <div class="pi-sub">
                                            <?php echo getPhrase('class');?>:
                                            <?php echo $this->crud->get_class_name($class_id); ?><br>
                                            <?php echo getPhrase('section');?>:
                                            <?php echo $this->db->get_where('section' , array('section_id' => $section_id))->row()->name; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>