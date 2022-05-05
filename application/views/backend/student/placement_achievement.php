<?php
    $running_year     =   $this->crud->getInfo('running_year');
    $running_semester =   $this->crud->getInfo('running_semester'); 
    $roundPrecision   =   $this->crud->getInfo('round_precision');

    $quantity_score         = intval($this->academic->getInfo('ap_quantity_score'));
    $achievement_weighting  = json_decode($this->academic->getInfo('achievement_weighting'), true);
    $placement_weighting    = json_decode($this->academic->getInfo('placement_weighting'), true);

?>
<div class="content-w">
    <div class="conty">
        <?php include 'fancy.php';?>
        <div class="header-spacer"></div>
        <div class="os-tabs-w menu-shad">
            <div class="os-tabs-controls">
                <ul class="navs navs-tabs">
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>student/my_marks/"><i
                                class="picons-thin-icon-thin-0658_cup_place_winner_award_prize_achievement"></i>
                            <span><?php echo getPhrase('current_marks');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links" href="<?php echo base_url();?>student/my_past_marks/"><i
                                class="picons-thin-icon-thin-0658_cup_place_winner_award_prize_achievement"></i>
                            <span><?php echo getPhrase('past_marks');?></span></a>
                    </li>
                    <li class="navs-item">
                        <a class="navs-links active" href="<?php echo base_url();?>student/placement_achievement/"><i
                                class="picons-thin-icon-thin-0658_cup_place_winner_award_prize_achievement"></i>
                            <span><?php echo getPhrase('placement_and_achievement');?></span></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="content-i">
            <div class="content-box">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="element-box lined-primary shadow">
                            <h5 class="form-header"><?php echo getPhrase('your_placement_and_achievement');?>                                
                            </h5>
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
                                                    href="<?php echo base_url();?>student/test_print/<?= $item['test_id'];?>"><?php echo getPhrase('print');?></a>
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
</div>