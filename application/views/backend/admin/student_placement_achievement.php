<?php 
    $student_info = $this->db->get_where('student' , array('student_id' => $student_id))->result_array(); 
    $quantity_score         = intval($this->academic->getInfo('ap_quantity_score'));
    $achievement_weighting  = json_decode($this->academic->getInfo('achievement_weighting'), true);
    $placement_weighting    = json_decode($this->academic->getInfo('placement_weighting'), true);
    
    foreach($student_info as $row): 
?>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="content-i">
        <div class="content-box">
            <div class="conty">
                <div class="back" style="margin-top:-20px;margin-bottom:10px">
                    <a title="<?php echo getPhrase('return');?>" href="<?php echo base_url();?>admin/students/"><i
                            class="picons-thin-icon-thin-0131_arrow_back_undo"></i></a>
                </div>
                <div class="row">
                    <main class="col col-xl-9 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">
                        <div id="newsfeed-items-grid">
                            <div class="ui-block paddingtel">
                                <div class="user-profile">
                                    <?php include 'student_area_header.php';?>
                                    <div class="ui-block p-2">
                                        <div class="ui-block-title">
                                            <h6 class="title"><?php echo getPhrase('placement_and_achievement_tests');?></h6>
                                        </div>
                                        <div class="ui-block-content">
                                            <div class="row p-2">
                                                <div class="table-responsive">
                                                    <table class="table table-lightborder">
                                                        <thead>
                                                            <tr>
                                                                <th><?php echo getPhrase('type');?></th>
                                                                <th><?php echo getPhrase('year');?></th>
                                                                <th><?php echo getPhrase('semester');?></th>
                                                                <th><?php echo getPhrase('class');?></th>
                                                                <th><?php echo getPhrase('section');?></th>
                                                                <th><?php echo getPhrase('grade');?></th>
                                                                <th><?php echo getPhrase('comment');?></th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php 
                                                            $tests = $this->db->get_where('v_pa_test' , array('student_id' => $student_id))->result_array();                                        
                                                            foreach ($tests as $key => $item):                                            
                                                                
                                                                $type = $item['type_test'];

                                                                $average = 0;
                                                                $score_array = [];                                            
                                                                if($type == '2') // Placement test
                                                                {
                                                                    for ($i=1; $i <= $quantity_score; $i++) { 
                                                                        $name = 'score'.$i;
                                                                        $score_array[$i] = round((($item[$name]/$achievement_weighting[$name])*100), $roundPrecision);
                                                                    }

                                                                    $average = round((array_sum($score_array)/count($score_array)), $roundPrecision);
                                                                }
                                                                else
                                                                {
                                                                    for ($i=1; $i <= $quantity_score; $i++) { 
                                                                        $name = 'score'.$i;
                                                                        $score_array[$i] = round((($item[$name]/$placement_weighting[$name])*100), $roundPrecision);
                                                                    }

                                                                    $average = round((array_sum($score_array)/count($score_array)), $roundPrecision);
                                                                }
                                                            ?>
                                                            <tr>
                                                                <td>
                                                                    <?=  $type == '1' ?  getPhrase("placement") :  getPhrase("achievement");?>
                                                                </td>
                                                                <td>
                                                                    <?= $item['year']; ?>
                                                                </td>
                                                                <td>
                                                                    <?= $item['semester_name']; ?>
                                                                </td>
                                                                <td>
                                                                    <?= $item['class_name']; ?>
                                                                </td>
                                                                <td>
                                                                    <?= $item['section_name']; ?>
                                                                </td>
                                                                <td>
                                                                    <?= $average ?>
                                                                </td>
                                                                <td>
                                                                    <?= $item['comment']; ?>
                                                                </td>
                                                                <td>
                                                                    <a class="btn btn-rounded btn-sm btn-primary" style="color:white" target="_blank"
                                                                        href="<?php echo base_url();?>admin/test_print/<?= $item['test_id'].'/'.$student_id;?>"><?php echo getPhrase('print');?></a>
                                                                </td>
                                                            </tr>
                                                            <?php endforeach;?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                    <?php include 'student_area_menu.php';?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach;?>