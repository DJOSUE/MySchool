<?php 
    $details = $this->db->get_where('reports', array('code' => $code))->result_array();
	foreach($details as $row):
?>
    <div class="content-w">
        <?php include 'fancy.php';?>
        <div class="header-spacer"></div>
        <div class="conty">
            <div class="content-box">
	            <div class="row">
	                <div class="col-sm-8">
		                <div class="pipeline white lined-primary">
		                    <div class="pipeline-header">
			                    <h5 class="pipeline-name"><?php echo $row['title'];?></h5>
			                    <div class="pipeline-header-numbers">
			                        <div class="pipeline-count">
				                        <i class="os-icon picons-thin-icon-thin-0024_calendar_month_day_planner_events"></i> <?php echo $row['date'];?> <br>
			                        </div>
			                        <div class="col-3 text-right">
			  	                    <?php if($row['priority'] == 'alta'):?>
					                    <a class="btn nc btn-rounded btn-sm btn-danger text-left text-white"><?php echo getPhrase('high');?></a></td>
				                    <?php endif;?>
				                    <?php if($row['priority'] == 'media'):?>
					                    <a class="btn nc btn-rounded btn-sm btn-warning text-left text-white"><?php echo getPhrase('medium');?></a></td>
				                    <?php endif;?>
				                    <?php if($row['priority'] == 'baja'):?>
					                    <a class="btn nc btn-rounded btn-sm btn-info text-left text-white"><?php echo getPhrase('low');?></a></td>
				                    <?php endif;?>
			                        </div>
			                    </div>
		                    </div>
			                <p><?php echo $row['description'];?></p>
			                <?php if( $row['file'] != ""):?>
			                <div class="b-t padded-v-big">
				                <?php echo getPhrase('file');?>: <a class="btn btn-rounded btn-sm btn-primary text-white" href="<?php echo base_url();?>public/uploads/report_files/<?php echo $row['file'];?>"><i class="os-icon picons-thin-icon-thin-0042_attachment"></i> <?php echo getPhrase('download');?></a>
			                </div>
			                <?php endif;?>
			                <?php if($row['status'] == 0):?><br><br>
			                <div class="b-t padded-v-big"><a class="btn btn-rounded btn-sm btn-success text-white" onClick="return confirm('<?php echo getPhrase('confirm_solved');?>')" href="<?php echo base_url();?>admin/create_report/update/<?php echo $row['code'];?>"><i class="os-icon picons-thin-icon-thin-0154_ok_successful_check"></i> <?php echo getPhrase('mark_solved');?></a></div>
			                <?php endif;?>
		                </div>
		                <div class="element-box shadow lined-success">
                        <?php if($row['status'] == 0): ?>
		  		            <div class="row">
				                <input type="hidden" name="report_code" id="report_code" value="<?php echo $row['code'];?>">
			                    <div class="col-sm-12">
                                    <textarea class="form-control full-width" placeholder="<?php echo getPhrase('write_message');?>" id="message" name="message" required="" rows="5"></textarea>
                                    <a id="add" class="btn btn-primary pull-right text-white" href="javascript:void(0);"><?php echo getPhrase('reply');?></a>
				                </div>
				            </div>
    	                <?php endif;?>
    	                <?php if($row['status'] == 1):?>
	    	                <center><div class="alert alert-success" role="alert"><strong><?php echo getPhrase('success');?>!</strong> <?php echo getPhrase('solved');?></div></center>
    	                <?php endif;?><br>
    	                    <div id="panel">
	                	    <?php
                                $this->db->order_by('message_id' , 'desc'); 
                                $news_messages = $this->db->get_where('report_response' , array('report_code' => $row['code']))->result_array();
                                foreach ($news_messages as $row2):
                            ?>
    		                    <div class="element-box-w b-t">
                                    <div class="row m-t m-b">
			                            <div class="col-sm-10">
				                            <a href="javascript:void(0);"><img alt="" src="<?php echo $this->crud->get_image_url($row2['sender_type'], $row2['sender_id']);?>" width="30px" class="tbl-st"> <span class="h6"><?php echo $this->crud->get_name($row2['sender_type'], $row2['sender_id']);?></span></a>
				                            <div class="com tp-rem"><?php echo $row2['message'];?></div>
			                            </div>
			                            <div class="col-sm-2">
				                            <div class="gi text-right"><?php echo $row2['date'];?></div>
			                            </div>
			                        </div>
		                        </div>
		                        <?php endforeach;?>
	                        </div>
	                    </div>
	                </div>
	                <div class="col-sm-4">
    	                <div class="ui-block paddingtel lined-danger">
    	                    <div class="ui-block-title">
    			                <h6 class="title"><?php echo getPhrase('student');?></h6>
    			            </div>
                            <div class="ui-block-content">
                                <div class="widget w-about text-center">
                                    <a href="javascript:void(0);" class="logo"><img src="<?php echo $this->crud->get_image_url('student', $row['student_id']);?>" class="w90"></a>
                                    <h4><?php echo $this->crud->get_name('student', $row['student_id']);?><br> <small><?php echo getPhrase('roll');?>: <?php echo $this->db->get_where('enroll', array('student_id' => $row['student_id']))->row()->roll;?>.</small></h4>
                                    <?php 
                                        $cl_id = $this->db->get_where('enroll', array('student_id' => $row['student_id']))->row()->class_id;
                                        $sec_id = $this->db->get_where('enroll', array('student_id' => $row['student_id']))->row()->section_id;?>
                                        <h5><a class="badge badge-success" href="javascript:void(0);"><?php echo $this->db->get_where('class', array('class_id' => $cl_id))->row()->name;?></a></h5>
                                        <h5><a class="badge badge-info" href="javascript:void(0);"><?php echo getPhrase('section');?>: <?php echo $this->db->get_where('section', array('section_id' => $sec_id))->row()->name;?></a></h5>
                                       <br>
                                </div>
                            </div>
                        </div>
                        <div class="ui-block paddingtel lined-danger">
	                        <div class="ui-block-title">
			                    <h6 class="title"><?php echo getPhrase('teacher');?></h6>
			                </div>
	        	            <?php $user1 = $row['user_id']; $user = explode("-", $user1);?>
                            <div class="ui-block-content">
                                <div class="widget w-about text-center">
                                    <a href="javascript:void(0);" class="logo"><img src="<?php echo $this->crud->get_image_url($user[0], $user[1]);?>" class="w90"></a>
                                    <h4><?php echo $this->crud->get_name($user[0], $user[1]);?><br> <small><?php echo getPhrase('phone');?>:  <?php echo $this->db->get_where($user[0], array($user[0].'_id' => $user[1]))->row()->phone;?>.</small></h4>
                                    <h5><a class="badge badge-primary" href="javascript:void(0);"><?php echo getPhrase($user[0]);?></a></h5>
                                   <br>
                                </div>
                            </div>
                        </div>
	                </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach;?>