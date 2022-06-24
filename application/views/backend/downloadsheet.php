<!doctype html>
<html>
    <header>
    </header>
    <body>
    <?php 
        $data = $this->db->get_where('student', array('student_id' => $student_id))->result_array();
        foreach($data as $row):
    ?>
        <div class="dl1">
    	    <table cellpadding="0" cellspacing="0" class="dl2">
                <tr>
                    <td colspan="2">
                        <table class="dl3">
                            <tr>
                                <td class="dl4">
                                    <img src="<?php echo base_url();?>public/uploads/<?php echo $this->crud->getInfo('logo');?>" alt="EduAppGT" class="dl5">
                                </td>
                                <td class="dl6"></td>
                                <td class="dl7">
                                    <p class="dl8"><b><?php echo $this->crud->getInfo('system_name');?></b></p>
                                    <p class="dl9"><?php echo $this->crud->getInfo('address');?></b></p>
                                    <p class="dl9"><?php echo $this->crud->getInfo('phone');?></p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr></tr>
		    </table>
            <table cellpadding="0" cellspacing="0" class="dl2">
                <tr>
                    <td class="dl10">
                        <b class="dl11"><?php echo getPhrase('enroll');?></b><br>
                        <?php echo $this->db->get_where('enroll', array('student_id' => $student_id))->row()->roll;?>
                    </td>
                    <td class="dl12">
                        <b class="dl11"><?php echo getPhrase('first_name');?></b><br>
                        <?php echo $row['first_name'];?>
                    </td>
                    <td class="dl12">
                        <b class="dl11"><?php echo getPhrase('last_name');?></b><br>
                        <?php echo $row['last_name'];?>
                    </td>
                    <td class="dl12">
                        <b class="dl11"><?php echo getPhrase('gender');?></b><br>
                        <?php $this->db->get_where('gender', array('code' => $row['sex']))->row()->name;?>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="dl12">
                        <b class="dl11"><?php echo getPhrase('address');?></b><br>
                        <?php echo $row['address'];?>
                    </td>
                    <td class="dl12">
                        <b class="dl11"><?php echo getPhrase('phone');?></b><br>
                        <?php echo $row['phone'];?>
                    </td>
                </tr>
                <tr>
                    <td class="dl12">
                        <b class="dl11"><?php echo getPhrase('date_of_birth');?></b><br>
                        <?php echo $row['birthday'];?>
                    </td>
                    <td class="dl12">
                        <b class="dl11"><?php echo getPhrase('email');?></b><br>
                        <?php echo $row['email'];?>
                    </td>
                    <td class="dl12">
                        <b class="dl11"><?php echo getPhrase('username');?></b><br>
                        <?php echo $row['username'];?>
                    </td>
                    <td class="dl12">
                        <b class="dl11"><?php echo getPhrase('password');?></b><br>
                        <?php echo base64_decode($pw);?>
                    </td>
                </tr>
                <?php $class_id   = $this->db->get_where('enroll', array('student_id' => $student_id))->row()->class_id;?>
                <?php $section_id = $this->db->get_where('enroll', array('student_id' => $student_id))->row()->section_id;?>
                <tr>
                    <td colspan="2" class="dl12">
                        <b class="dl11"><?php echo getPhrase('parent');?></b><br>
                        <?php echo $this->crud->get_name('parent', $row['parent_id']);?>
                    </td>
                    <td class="dl12">
                        <b class="dl11"><?php echo getPhrase('class');?></b><br>
                        <?php echo $this->db->get_where('class', array('class_id' => $class_id))->row()->name;?>
                    </td>
                    <td class="dl12">
                        <b class="dl11"><?php echo getPhrase('section');?></b><br>
                        <?php echo $this->db->get_where('section', array('section_id' => $section_id))->row()->name;?>
                    </td>
                </tr>
            </table>
            <table cellpadding="0" cellspacing="0" class="dl14">
                <tr>
                    <th class="dl13" colspan="3"><?php echo getPhrase('assigned_subjects');?></th>
                </tr>
                <tr>
                    <th class="dl13">#</th>
                    <th class="dl13"><?php echo getPhrase('subject');?></th>
                    <th class="dl13"><?php echo getPhrase('teacher');?></th>
                </tr>
                <?php 
                    $subjects = $this->db->get_where('subject', array('class_id' => $class_id, 'section_id' => $section_id))->result_array();
                    foreach($subjects as $sub):
                ?>
                <tr>
                    <td class="dl15">
                        <b class="dl11">1.</b>
                    </td>
                    <td class="dl15">
                        <?php echo $sub['name'];?>
                    </td>
                    <td class="dl15">
                        <?php echo $this->crud->get_name('teacher',$sub['teacher_id']);?>
                    </td>
                </tr>
            <?php endforeach;?>
            </table>
            <small class="dl16"><?php echo $this->db->get_where('academic_settings' , array('type' =>'terms'))->row()->description;?></small>
            <br>
            <table cellpadding="0" cellspacing="0" class="dl17">
                <tr>
                    <td class="dl18">
                        <center>____________________________________<br>
                        <?php echo getPhrase('parent');?>
                    </td>
                    <td colspan="1" class="dl19">
                    </td>
                    <td class="dl18">
                        ____________________________________<br><?php echo getPhrase('student');?>
                    </td>
                </tr>
            </table>
            <table cellpadding="0" cellspacing="0"  class="dl20">
                <tr>
                    <td colspan="2" class="dl21">
                        <table class="dl22">
                            <tr>
                                <td class="dl11">
                                    <b><?php echo getPhrase('address');?>:</b><br>
                                    <?php echo $this->crud->getInfo('address');?>
                                </td>
                                <td class="dl11">
                                    <b><?php echo getPhrase('phone');?>:</b><br>
                                    <?php echo $this->crud->getInfo('phone');?>
                                </td>
                                <td class="dl23">
    								<?php echo getPhrase('generated_by');?> <?php echo $this->crud->getInfo('system_name');?><br>
                                    <b><?php echo base_url();?></b>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
		    </table>
        </div> 
        <?php endforeach;?>
    </body>
</html>