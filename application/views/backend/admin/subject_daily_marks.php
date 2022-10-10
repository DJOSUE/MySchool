<?php 
    $min                = $this->crud->getInfo('minium_mark');
    $running_year       = $this->crud->getInfo('running_year');
    $running_semester   = $this->crud->getInfo('running_semester');
    $roundPrecision     = $this->crud->getInfo('round_precision');
    $quantityGrades     = $this->crud->getInfo('quantity_grades');

	$encode_data = $data;
	$decode_data = base64_decode($encode_data);
	$explode_data = explode("-", $decode_data);

    
    $student_id = $explode_data[0];
    $class_id   = $explode_data[1];
    $section_id = $explode_data[2];
    $subject_id = $explode_data[3];
    $unit_id    = $explode_data[4];

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
                    <div class="back"><a href="<?php echo base_url();?>admin/student_marks/<?php echo $student_id;?>/"><i class="picons-thin-icon-thin-0131_arrow_back_undo"></i></a></div>
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
                                                $subjectLabel = $this->db->get_where('subject' , array('subject_id' => $subject_id))->row();

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
                                                                                    AND subject_id = '$subject_id'
                                                                                    AND unit_id = '$unit_id'
                                                                                    AND year = '$running_year'
                                                                                    AND semester_id = '$running_semester'
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

                                                // if(is_numeric($average->labuno)     && $average->labuno != '' ) { $count++; } 
                                                if(is_numeric($average->labdos)     && $average->labdos != '' ) { $count++; }  
                                                if(is_numeric($average->labtres)    && $average->labtres != '' ) { $count++; }  
                                                if(is_numeric($average->labcuatro)  && $average->labcuatro != '' ) { $count++; }  
                                                if(is_numeric($average->labcinco)   && $average->labcinco != '') { $count++; }
                                                if(is_numeric($average->labseis)    && $average->labseis != '' ) { $count++; } 
                                                if(is_numeric($average->labsiete)   && $average->labsiete != '' ) { $count++; }  
                                                if(is_numeric($average->labocho)    && $average->labocho != '' ) { $count++; }  
                                                if(is_numeric($average->labnueve)   && $average->labnueve != '' ) { $count++; }  
                                                if(is_numeric($average->labdiez)    && $average->labdiez != '' ) { $count++; }                                                            
                                                
                                                $labototal      = (float)$labodos + (float)$labotres + (float)$labocuatro + (float)$labocinco + (float)$laboseis + (float)$labosiete + (float)$laboocho + (float)$labonueve + (float)$labodiez;
                                
                                                $mark = $count > 0 ? round(($labototal/$count), (int)$roundPrecision) : '-';

                                                for ($i=0; $i < $quantityGrades; $i++):
                                                    
                                                    $grade = $grades[$i];
                                                    $lable = $grade[1];
                                                    $name  = $grade[2];
                                            ?>
                                                <tr>
                                                    <td><?= $grade[0];?></td>
                                                    <td><?php echo $subjectLabel->$name; ?></td>
                                                    <td><?php echo $average->$lable; ?></td>
                                                </tr>
                                            <?php endfor; ?>
                                            <tr style="border-top: solid #a5a5a5;">
                                                <td>-</td>
                                                <td><?php echo getPhrase('total');?></td>
					                            <td>
					                                <?php if($mark < $min || $mark == "-"):?>
					  	                            <a class="btn nc btn-rounded btn-sm btn-danger" style="color:white"><?php if($mark == "") echo '0'; else echo $mark;?></a>
					                                <?php endif;?>
    					                            <?php if($mark >= $min):?>
					  	                            <a class="btn nc btn-rounded btn-sm btn-success" style="color:white"><?php echo $mark;?></a>
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
			                            <a class="extra-info" href="javascript:void(0);"><img alt="" src="<?php echo base_url();?>public/uploads/<?php echo $this->crud->getInfo('logo');?>" width="10%" style="margin-right:5px"><span class="text-white"><?php echo $this->crud->getInfo('system_name');?></span></a>
		                            </div>
		                            <div class="pi-body">
			                            <div class="avatar">
			                                <img alt="" src="<?php echo $this->crud->get_image_url('student',$student_id);?>">
			                            </div>  
			                            <div class="pi-info">
			                                <div class="h6 pi-name">
				                                <?php echo $this->crud->get_name('student', $student_id);?><br>
				                                <small><?php echo getPhrase('roll');?>: <?php echo $this->db->get_where('enroll', array('student_id' => $student_id))->row()->roll;?></small>
			                                </div>
			                                
			                                <div class="pi-sub">
				                                <?php echo getPhrase('class');?>: <?php echo $this->crud->get_class_name($class_id); ?><br>
        		                                <?php echo getPhrase('section');?>: <?php echo $this->db->get_where('section' , array('section_id' => $section_id))->row()->name; ?>
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