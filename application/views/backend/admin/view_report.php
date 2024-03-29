<?php 
    $reports = $this->db->get_where('student_report', array('report_code' => $report_code))->result_array();
    foreach($reports as $row):
?>
    <div class="content-w">
        <?php include 'fancy.php';?>
        <div class="header-spacer"></div>
        <div class="conty">
            <div class="content-i">
                <div class="content-box">
	                <div class="row">
	                    <div class="col-sm-8">
		                    <div class="pipeline white lined-primary">
		                        <div class="pipeline-header">
			                        <h5 class="pipeline-name"><?php echo $row['title'];?></h5>
			                        <div class="pipeline-header-numbers">
			                            <div class="pipeline-count">
				                            <i class="os-icon picons-thin-icon-thin-0024_calendar_month_day_planner_events"></i> <?php echo $row['timestamp'];?>
			                            </div>
			                            <div class="col-3 text-right">
			  	                        <?php if($row['priority'] == 'alta'):?>
					                        <a class="btn nc btn-rounded btn-sm btn-danger text-left" style="color:white"><?php echo getPhrase('high');?></a></td>
				                        <?php endif;?>
				                        <?php if($row['priority'] == 'media'):?>
					                        <a class="btn nc btn-rounded btn-sm btn-warning text-left" style="color:white"><?php echo getPhrase('medium');?></a></td>
				                        <?php endif;?>
				                        <?php if($row['priority'] == 'baja'):?>
					                        <a class="btn nc btn-rounded btn-sm btn-info text-left" style="color:white"><?php echo getPhrase('low');?></a></td>
				                        <?php endif;?>
			                            </div>
			                        </div>
		                        </div>
			                    <p><?php echo $row['description'];?></p>
			                    <div class="b-t padded-v-big">
			                        <?php echo getPhrase('file');?>: <a class="btn btn-rounded btn-sm btn-primary" href="<?php echo base_url();?>public/uploads/reportes_alumnos/<?php echo $row['file'];?>" style="color:white"><i class="os-icon picons-thin-icon-thin-0042_attachment"></i> <?php echo getPhrase('download');?></a></td>
			                        <?php if($row['status'] == 0):?><br><br>
			                        <div class="b-t padded-v-big"><a class="btn btn-rounded btn-sm btn-success" onClick="return confirm('<?php echo getPhrase('confirm_solved');?>')" href="<?php echo base_url();?>admin/view_report/update/<?php echo $row['report_code'];?>" style="color:white"><i class="os-icon picons-thin-icon-thin-0154_ok_successful_check"></i> <?php echo getPhrase('mark_solved');?></a></div>
			                        <?php endif;?>
			                    </div>
		                    </div>
		                    <div class="element-box shadow lined-success">
		                    <?php if($row['status'] == 0):?>
		                        <div class="row">
				                    <input type="hidden" name="report_code" id="report_code" value="<?php echo $row['report_code'];?>">
			                        <div class="col-sm-12">
                                        <textarea class="form-control" placeholder="<?php echo getPhrase('write_message');?>" id="message" name="message" required="" rows="5" style="width:100%"></textarea>
                                        <a id="add" class="btn btn-success pull-right text-white" href="javascript:void(0);"><?php echo getPhrase('reply');?></a>
				                    </div>
				                </div><br>
                            <?php endif;?>
                            <?php if($row['status'] == 1):?>
        	                    <center><div class="alert alert-success" role="alert"><strong><?php echo getPhrase('success');?></strong> <?php echo getPhrase('report_success');?></div></center>
                            <?php endif;?>
                                <div id="panel">
                                <?php
                                    $this->db->order_by('report_message_id' , 'desc'); 
                                    $news_messages = $this->db->get_where('report_message' , array('report_code' => $row['report_code']))->result_array();
                                    foreach ($news_messages as $row2):
                                ?>
                    		        <div class="element-box-w b-t">
                                        <div class="row m-t m-b">
                    			            <div class="col-sm-10">
                        				        <a href="javascript:void(0);"><img alt="" src="<?php echo $this->crud->get_image_url($row2['sender_type'], $row2['sender_id']);?>" width="30px" style="border-radius:20px;margin-right:5px;"> <span class="infogi"><?php echo $this->crud->get_name($row2['sender_type'], $row2['sender_id']);?></span></a>
                        				        <div class="com" style="margin-top:1rem"><?php echo $row2['message'];?></div>
                    			            </div>
                    			            <div class="col-sm-2">
                    				            <div class="gi text-right"><?php echo $row2['timestamp'];?></div>
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
    			                    <h6 class="title"><?php echo getPhrase('teacher');?></h6>
			                    </div>
                                <div class="ui-block-content">
                                    <div class="widget w-about" style="text-align:center">
                                        <a href="javascript:void(0);" class="logo"><img src="<?php echo $this->crud->get_image_url('teacher', $row['teacher_id']);?>" alt="Educaby" style="width:90px;"></a>
                                        <h4><?php echo $this->crud->get_name('teacher', $row['teacher_id']);?><br> <small><?php echo getPhrase('phone');?>:  <?php echo $this->db->get_where('teacher', array('teacher_id' => $row['teacher_id']))->row()->phone;?>.</small></h4>
                                        <h5><a class="badge badge-primary" href="javascript:void(0);"><?php echo getPhrase('teacher');?></a></h5>
                                        <br>
                                    </div>
                                </div>
                            </div>
		                    <div class="ui-block paddingtel lined-danger">
	                            <div class="ui-block-title">
    			                    <h6 class="title"><?php echo getPhrase('student');?></h6>
			                    </div>
                                <div class="ui-block-content">
                                    <div class="widget w-about" style="text-align:center">
                                        <a href="javascript:void(0);" class="logo"><img src="<?php echo $this->crud->get_image_url('student', $row['student_id']);?>" alt="Educaby" style="width:90px;"></a>
                                        <h4><?php echo $this->crud->get_name('student', $row['student_id']);?><br> <small>Carnet: <?php echo $this->db->get_where('enroll', array('student_id' => $row['student_id']))->row()->roll;?>.</small></h4>
                                        <?php $cl_id = $this->db->get_where('enroll', array('student_id' => $row['student_id']))->row()->class_id;
                                        $sec_id = $this->db->get_where('enroll', array('student_id' => $row['student_id']))->row()->section_id;?>
                                        <h5><a class="badge badge-success" href="javascript:void(0)"><?php echo $this->db->get_where('class', array('class_id' => $cl_id))->row()->name;?></a></h5>
                                        <h5><a class="badge badge-info" href="javascript:void(0);"><?php echo getPhrase('section');?> <?php echo $this->db->get_where('section', array('section_id' => $cl_id))->row()->name;?></a></h5>
                                        <br>
                                    </div>
                                </div>
                            </div>
    	                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach;?>

    <script>
    	var post_message		=	'<?php echo getPhrase('comment_success');?>';
    	$(document).ready(function()
    	{
    	  $("#add").click(function()
    	  {
    	  	message=$("#message").val();
    	  	report_code=$("#report_code").val();
    	  	if(message!="" && report_code!="")
    	  	{
    		  	$.ajax({url:"<?php echo base_url();?>admin/create_report_message/",type:'POST',data:{message:message,report_code:report_code},success:function(result)
    		  	{
            		 $('#panel').load(document.URL + ' #panel');
            		 $("#message").val('');
            		   const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 8000
                    }); 
                    Toast.fire({
                        icon: 'success',
                        title: post_message
                    })
    		    }});
    	  	}
    	  });
    	});
    </script>