<?php 
    $running_year = $this->crud->getInfo('running_year');
    $student_info = $this->db->get_where('student' , array('student_id' => $student_id))->result_array(); 
    foreach($student_info as $row): ?>
    <div class="content-w"> 
        <?php include 'fancy.php';?>
        <div class="header-spacer"></div>
        <div class="content-i">
            <div class="content-box">
                <div class="conty">
                    <div class="back" style="margin-top:-20px;margin-bottom:10px">		
	                    <a title="<?php echo getPhrase('return');?>" href="<?php echo base_url();?>admin/students/"><i class="picons-thin-icon-thin-0131_arrow_back_undo"></i></a>	
	                </div>
                    <div class="row">
                        <main class="col col-xl-9 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">                
                            <div id="newsfeed-items-grid">
                                <div class="ui-block paddingtel">
                                    <div class="user-profile">
                                        <?php include 'student_area_header.php';?>
                                        <div class="ui-block">
                                            <div class="ui-block-title">    
                                                <h6 class="title"><?php echo getPhrase('behavior');?></h6>
                                            </div>
                                            <div class="ui-block-content">
                                                <div class="table-responsive">
                                                    <table class="table table-padded">
                                                        <thead>
                                                            <tr>
                                                                <th><?php echo getPhrase('priority');?></th>
                                                                <th><?php echo getPhrase('date');?></th>
                                                                <th><?php echo getPhrase('created_by');?></th>
                                                                <th><?php echo getPhrase('title');?></th>
                                                                <th><?php echo getPhrase('options');?></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $reports = $this->db->get_where('reports', array('student_id' => $row['student_id']))->result_array();
                                    					        foreach($reports as $row):
                                    				        ?>
                                    				        <?php $user = $row['user_id']; $re = explode('-', $user); ?>
                                                            <tr>
                                                                <td>
                                                                  <?php if($row['priority'] == 'alta'):?>
                                                                    <span class="status-pill red"></span><span><?php echo getPhrase('high');?></span>
                                                                  <?php endif;?>
                                                                  <?php if($row['priority'] == 'media'):?>
                                                                    <span class="status-pill yellow"></span><span><?php echo getPhrase('medium');?></span>
                                                                  <?php endif;?>
                                                                  <?php if($row['priority'] == 'baja'):?>
                                                                    <span class="status-pill green"></span><span><?php echo getPhrase('low');?></span>
                                                                  <?php endif;?>
                                                                </td>
                                                                <td><span><?php echo $row['date'];?></span></td>
                                                                <td class="cell-with-media">
                                                                    <img alt="" src="<?php echo $this->crud->get_image_url($re[0], $re[1]);?>" style="height: 25px;"><span><?php echo $this->crud->get_name($re[0], $re[1]);?></span>
                                                                </td>
                                                                <td><?php echo $row['title'];?></td>
                                                                <td class="bolder">
                                                                    <a href="<?php echo base_url();?>admin/looking_report/<?php echo $row['code'];?>/" class="grey"><i class="px20" class="picons-thin-icon-thin-0012_notebook_paper_certificate" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo getPhrase('view_details');?>"></i></a>
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
                        </main>
                        <?php include 'student_area_menu.php';?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach;?>