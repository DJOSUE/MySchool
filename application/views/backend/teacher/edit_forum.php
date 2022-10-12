 <?php 
    $details = $this->db->get_where('forum', array('post_code' => $code))->result_array();
    foreach($details as $row2):
 ?>
    <div class="content-w">
        <?php include 'fancy.php';?>
        <div class="header-spacer"></div>
        <div class="conty">
	       <div class="os-tabs-w menu-shad">
                <div class="os-tabs-controls">
                    <?php include 'subject__nav.php';?>
                </div>
            </div>
	        <div class="content-i">
	            <div class="content-box">
	                <div class="col-lg-12">		
	                    <div class="back hidden-sm-down" style="margin-top:-20px;margin-bottom:10px">		
	                        <a href="<?php echo base_url();?>teacher/forum/<?php echo base64_encode($row2['class_id']."-".$row2['section_id']."-".$row2['subject_id']);?>/"><i class="picons-thin-icon-thin-0131_arrow_back_undo"></i></a>	
	                    </div>	
                        <div class="element-wrapper">	
	                        <div class="element-box lined-primary shadow">
      	                        <div class="modal-header">
                                    <h5 class="modal-title"><?php echo getPhrase('update_forum');?></h5>
      	                        </div><br>
                                <?php echo form_open(base_url() . 'teacher/forum/update/'.$code, array('enctype' => 'multipart/form-data')); ?>
		                            <div class="form-group">
			                            <label for=""> <?php echo getPhrase('title');?></label><input class="form-control" name="title" required="" value="<?php echo $row2['title'];?>" type="text">
		                            </div>
		                            <input type="hidden" value="<?php echo $row['class_id'];?>" name="class_id">
		                            <input type="hidden" value="<?php echo $row['subject_id'];?>" name="subject_id">
		                            <input type="hidden" value="<?php echo $row['subject_id'];?>" name="subject_id">
		                            <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
        		                        <div class="description-toggle">
                                            <div class="description-toggle-content">
                                                <div class="h6"><?php echo getPhrase('show_students');?></div>
                                                <p><?php echo getPhrase('show_message');?></p>
                                            </div>          
                                            <div class="togglebutton">
                                                <label><input name="post_status" value="1" <?php if($row2['post_status'] == 1) echo "checked";?> type="checkbox"></label>
                                            </div>
                                        </div>
                                    </div>
		                            <div class="form-group">
			                            <label> <?php echo getPhrase('description');?></label><textarea cols="80" id="ckeditor1" name="description" required="" rows="2"><?php echo $row2['description'];?></textarea>
			                        </div>          
          		                    <div class="modal-footer">
                	                    <button class="btn btn-rounded btn-success" type="submit"> <?php echo getPhrase('update');?></button>
          		                    </div>
          	                    <?php echo form_close();?>
		                    </div>
	                    </div>
	                </div>
                </div>  
            </div>
        </div>
    </div>
<?php endforeach;?>