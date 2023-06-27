    <div class="content-w">
        <?php include 'fancy.php';?>
        <div class="header-spacer"></div>
        <div class="conty">
            <div class="content-i">
                <div class="content-box">
	                <div class="element-wrapper">
	                    <div class="tab-content">
		                    <div class="tab-pane active" id="reports">
		                        <div class="element-wrapper">
                                    <h6 class="element-header">
                                        <?php echo getPhrase('teacher_reports');?>
                                        <div style="margin-top:auto;text-align:right;"><a href="javascript:void(0);" data-target="#addroutine" data-toggle="modal" class="btn btn-control btn-grey-lighter btn-purple"><i class="picons-thin-icon-thin-0001_compose_write_pencil_new"></i><div class="ripple-container"></div></a></div>
                                    </h6>
                                    <div class="element-box-tp">
                                        <div class="table-responsive">
                                            <table class="table table-padded">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo getPhrase('teacher');?></th>
                                    					<th><?php echo getPhrase('reason');?></th>
                                    					<th><?php echo getPhrase('code');?></th>
                                    					<th><?php echo getPhrase('date');?></th>
                                    					<th><?php echo getPhrase('priority');?></th>
                                    					<th><?php echo getPhrase('status');?></th>
                                    					<th class="text-center"><?php echo getPhrase('options');?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php $reports = $this->db->get_where('student_report', array('student_id' => get_login_user_id()))->result_array();
			                                        foreach($reports as $row):
			                                    ?>
                                                    <tr>
                                                        <td><img alt="" src="<?php echo $this->crud->get_image_url('teacher', $row['teacher_id']);?>" width="25px" style="border-radius: 10px;margin-right:5px;"> <?php echo $this->crud->get_name('teacher', $row['teacher_id']);?></td>
					                                    <td><a href="<?php echo base_url();?>student/view_report/<?php echo $row['report_code'];?>" style="color:#000;"><?php echo $row['title'];?></a></td>
					                                    <td><a class="btn nc btn-rounded btn-sm btn-primary" style="color:white"><?php echo $row['report_code'];?></a></td>
					                                    <td><a class="btn nc btn-rounded btn-sm btn-success" style="color:white"><?php echo $row['timestamp'];?></a></td>
					                                    <td>
                                    					<?php if($row['priority'] == 'alta'):?>
                                    						<a class="btn nc btn-rounded btn-sm btn-danger" style="color:white"><?php echo getPhrase('high');?></a>
                                    					<?php endif;?>
                                    					<?php if($row['priority'] == 'media'):?>
                                    						<a class="btn nc btn-rounded btn-sm btn-warning" style="color:white"><?php echo getPhrase('middle');?></a>
                                    					<?php endif;?>
                                    					<?php if($row['priority'] == 'baja'):?>
                                    						<a class="btn nc btn-rounded btn-sm btn-secondary" style="color:white"><?php echo getPhrase('low');?></a>
                                    						<?php endif;?>
					                                    </td>
					                                    <td>
                                    					<?php if($row['status'] == 0):?>
                                    						<a class="btn nc btn-rounded btn-sm btn-danger" style="color:white" href="#"><?php echo getPhrase('pending');?></a>
                                    					<?php endif;?>
                                    					<?php if($row['status'] == 1):?>
                                    						<a class="btn nc btn-rounded btn-sm btn-success" style="color:white" href="#"><?php echo getPhrase('solved');?></a>
                                    					<?php endif;?>
					                                    </td>
					                                    <td class="row-actions">
						                                    <a class="btn btn-rounded btn-sm btn-primary" style="color:white" href="<?php echo base_url();?>student/view_report/<?php echo $row['report_code'];?>"><i class="picons-thin-icon-thin-0043_eye_visibility_show_visible"></i> <?php echo getPhrase('view');?></</a>
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
        </div>
    </div>
	 
	 
	 <div class="modal fade" id="addroutine" tabindex="-1" role="dialog" aria-labelledby="addroutine" aria-hidden="true">
        <div class="modal-dialog window-popup edit-my-poll-popup" role="document">
            <div class="modal-content">
                <a href="javascript:void(0);" class="close icon-close" data-dismiss="modal" aria-label="Close"></a>
                <div class="modal-body">
                    <div class="ui-block-title" style="background-color:#00579c">
                        <h6 class="title" style="color:white"><?php echo getPhrase('create_report');?></h6>
                    </div>
                    <div class="ui-block-content">
                        <?php echo form_open(base_url() . 'student/listado_de_reportes/create/', array('enctype' => 'multipart/form-data')); ?>
                            <div class="row">
                                <div class="col col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group label-floating is-empty">
                  	                    <label class="control-label"><?php echo getPhrase('title');?></label>
                  		                <input class="form-control" placeholder="" type="text" name="title">
                		                <span class="material-input"></span>
                	                </div>
                                </div>
                                <div class="col col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group label-floating is-select">
                                        <label class="control-label"><?php echo getPhrase('teacher');?></label>
                                        <div class="select">
                                            <select name="teacher_id" required="">
                                    	        <option value=""><?php echo getPhrase('select');?></option>
					                            <?php 
                                                    $teachers = $this->db->get('teacher')->result_array();
                                                    foreach($teachers as $row): ?>
                                                <option value="<?php echo $row['teacher_id'];?>"><?php echo $this->crud->get_name('teacher', $row['teacher_id']);?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group label-floating is-select">
                                        <label class="control-label"><?php echo getPhrase('priority');?></label>
                                        <div class="select">
                                            <select name="priority" id="slct" required="">
                                                <option value=""><?php echo getPhrase('select');?></option>
						                        <option value="baja"><?php echo getPhrase('low');?></option>
						                        <option value="media"><?php echo getPhrase('medium');?></option>
						                        <option value="alta"><?php echo getPhrase('high');?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                  	                    <label class="control-label"><?php echo getPhrase('file');?></label>
                  		                <input class="form-control" placeholder="" type="file" name="file">
                		                <span class="material-input"></span>
                	                </div>
                                </div>
                                <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group">
                                        <textarea class="form-control" rows="6" placeholder="<?php echo getPhrase('description');?>..." name="description" required=""></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-buttons-w text-right">
                                <center><button class="btn btn-rounded btn-success" type="submit"><?php echo getPhrase('save');?></button></center>
                            </div>
                        <?php echo form_close();?>        
                    </div>
                </div>
            </div>
        </div>
    </div>