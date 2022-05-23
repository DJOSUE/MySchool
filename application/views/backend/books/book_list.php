<?php 

    $running_year     =   $this->crud->getInfo('running_year');
    $running_semester =   $this->crud->getInfo('running_semester');
    $teacher_id       =   $this->session->userdata('login_user_id');

?>    
    <div class="content-w">
        <?php include $path_fancy;?>
        <div class="header-spacer"></div>
        <div class="content-i">
            <div class="content-box">
                <div class="conty">
                    <div class="row">
                        <?php 
                        $this->db->group_by('class_id');
                        $classes = $this->db->get_where('subject', array('teacher_id' => $teacher_id))->result_array();
                        foreach($classes as $cl):
                    ?>
                        <div class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="ui-block" data-mh="friend-groups-item">
                                <div class="friend-item friend-groups">
                                    <div class="friend-item-content">
                                        <div class="friend-avatar">
                                            <div class="author-thumb">
                                                <img src="<?php echo base_url();?>public/uploads/<?php echo $this->db->get_where('settings', array('type' => 'logo'))->row()->description;?>"
                                                    width="120px"
                                                    style="background-color:#fff;padding:15px; border-radius:0px">
                                            </div>
                                            <div class="author-content">
                                                <?php echo $this->db->get_where('class', array('class_id' => $cl['class_id']))->row()->name;?>
                                                <div class="country">
                                                    <b><?php echo getPhrase('sections');?>:</b><br/>
                                                    <?php 
                                                        $sections = $this->db->get_where('section', array('class_id' => $cl['class_id'], 'year' => $running_year, 'semester_id' => $running_semester))->result_array(); 
                                                        foreach($sections as $sec):
                                                            $is_saturday = false;
                                                            if(strpos(strtolower($sec['name']),'saturday')!== false)
                                                            {
                                                                $is_saturday = true;
                                                            }
                                                    ?>
                                                    <a href="<?php echo base_url();?>books/<?php echo base64_encode($cl['class_id']."|".$is_saturday);?>/"
                                                        class="h5 author-name">
                                                    <?php echo $sec['name']." "."|";?>
                                                    </a><br/>
                                                    <?php endforeach;?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>
        </div>
    </div>