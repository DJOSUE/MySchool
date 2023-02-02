    <?php
        $url_print = base_url().'PrintDocument/print_agreement/'.base64_encode($agreement_id);
        if($url == 'student_enrollments')
        {
            $url_return = base_url().'admin/'.$url.'/'.$student_id.'/';
        }
        else
        {
            $url_return = base_url().'admin/student_enrollments/'.$student_id;
        }
    ?>
    <div class="content-w">
        <?php include 'fancy.php';?>
        <div class="header-spacer"></div>
	    <div class="content-i">
		    <div class="content-box">
			    <div class="conty">
				    <div class="ui-block">
					    <div class="ui-block-content">
      					    <div class="steps-w">
        					    <div class="step-triggers">
              						<a class="step-trigger active" href="#stepContent1"><?= getPhrase('download_student_agreement');?></a>
        				        </div>
        					    <div class="step-contents">
          					        <div class="step-content active" id="stepContent1">
									    <div class="row">
									    	<div class="col-sm-12">									
        				 				    	<center><img src="<?= base_url();?>public/uploads/student.png" style="width:30%"></center>
        				 					</div>
									    </div>
                				        <div class="form-buttons-w text-center">
                  						    <a class="btn btn-rounded btn-primary btn-lg" href="<?= $url_print;?>"><?= getPhrase('download');?></a>
                  					        <a class="btn btn-rounded btn-success btn-lg" href="<?= $url_return?>"><?= getPhrase($url);?></a>
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