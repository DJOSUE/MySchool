<?php

    $info = $this->db->get_where('admin', array('admin_id' => $admin_id_selected))->result_array();	


    foreach($info as $row):
?>
    <div class="content-w"> 
    	<?php include 'fancy.php';?>
    	<div class="header-spacer"></div>
    	<div class="content-i">
	    	<div class="content-box">
			    <div class="conty">
    			    <div class="back" style="margin-top:-20px;margin-bottom:10px">		
	                    <a title="<?php echo getPhrase('return');?>" href="<?php echo base_url();?>admin/admins/"><i class="picons-thin-icon-thin-0131_arrow_back_undo"></i></a>	
	                </div>
    			    <div class="row">
            			<main class="col col-xl-9 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">                
            			    <div id="newsfeed-items-grid">
        						<div class="ui-block paddingtel">
          						    <div class="user-profile">
              							<div class="up-head-w" style="background-image:url(<?php echo base_url();?>public/uploads/bglogin.jpg)">
          								    <div class="up-main-info">
              								   	<div class="user-avatar-w">
          								            <div class="user-avatar">
          								                <img alt="" src="<?php echo $this->crud->get_image_url('admin', $row['admin_id']);?>" style="background-color:#fff;">
          								            </div>
          								        </div>
          								        <h3 class="text-white"><?php echo $this->crud->get_name('admin', $row['admin_id']);?></h3>
          								        <h5 class="up-sub-header">@<?php echo $row['username'];?></h5>
          								    </div>
          								    <svg class="decor" width="842px" height="219px" viewBox="0 0 842 219" preserveAspectRatio="xMaxYMax meet" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g transform="translate(-381.000000, -362.000000)" fill="#FFFFFF"><path class="decor-path" d="M1223,362 L1223,581 L381,581 C868.912802,575.666667 1149.57947,502.666667 1223,362 Z"></path></g></svg>
          							    </div>
              							<div class="up-controls">
              								<div class="row">
              								    <div class="col-lg-6">
              								        <div class="value-pair">
              								            <div><?php echo getPhrase('account_type');?>:</div>
														
              								            <?php if($row['owner_status'] == 1):?>
              								                <div class="value badge badge-pill badge-success"><?php echo getPhrase('super_admin');?></div>
														<?php elseif($row['owner_status'] == 1):?>
              								                <div class="value badge badge-pill badge-info"><?php echo getPhrase('admin');?></div>
              								            <?php else:?>
              								                <div class="value badge badge-pill badge-primary"><?php echo getPhrase('advisor');?></div>
              								            <?php endif;?>
              								        </div>
              								        <div class="value-pair">
              								            <div><?php echo getPhrase('member_since');?>:</div>
              								            <div class="value"><?php echo $row['since'];?>.</div>
              								        </div>
              								    </div>
              								</div>
              							</div>
          							    <div class="ui-block">
										    <div class="ui-block-title">		
    											<h6 class="title"><?php echo getPhrase('personal_information');?></h6>
										    </div>
										    <div class="ui-block-content">
    											<div class="row">
    												<div class="col col-lg-6 col-md-6 col-sm-12 col-12">
    													<ul class="widget w-personal-info item-block">
    														<li>
    															<span class="title"><?php echo getPhrase('name');?>:</span>
    															<span class="text"><?php echo $row['first_name'];?> <?php echo $row['last_name'];?></span>
    														</li>
    														<li>
    															<span class="title"><?php echo getPhrase('email');?>:</span>
    															<span class="text"><?php echo $row['email'];?></span>
    														</li>
    														<li>
    															<span class="title"><?php echo getPhrase('username');?>:</span>
    															<span class="text"><?php echo $row['username'];?></span>
    														</li>
    														<li>
    															<span class="title"><?php echo getPhrase('identification');?>:</span>
    															<span class="text"><?php echo $row['idcard'];?></span>
    														</li>
    													</ul>
    												</div>
    												<div class="col col-lg-6 col-md-6 col-sm-12 col-12">
    													<ul class="widget w-personal-info item-block">
    														<li>
    															<span class="title"><?php echo getPhrase('profession');?>:</span>
    															<span class="text"><?php echo $row['profession'];?></span>
    														</li>
    														<li>
    															<span class="title"><?php echo getPhrase('phone');?>:</span>
    															<span class="text"><?php echo $row['phone'];?></span>
    														</li>
    														<li>
    															<span class="title"><?php echo getPhrase('birthday');?>:</span>
    															<span class="text"><?php echo $row['birthday'];?></span>
    														</li>
    														<li>
    															<span class="title"><?php echo getPhrase('address');?>:</span>
    															<span class="text"><?php echo $row['address'];?></span>
    														</li>
    													</ul>
    												</div>
    											</div>
										    </div>
									    </div>
          						    </div>
                			    </div>
            			    </div>
        			    </main>
        			    <div class="col col-xl-3 order-xl-1 col-lg-6 order-lg-2 col-md-6 col-sm-12 col-12">
            			    <div class="eduappgt-sticky-sidebar">
                    			<div class="sidebar__inner">
                				    <div class="ui-block paddingtel">
                    					<div class="ui-block-content">
                    					    <div class="widget w-about">
                            					<a href="javascript:void(0);" class="logo"><img src="<?php echo base_url();?>public/uploads/<?php echo $this->crud->getInfo('logo');?>"></a>
                        					    <ul class="socials">
                                					<li><a class="socialDash fb" href="<?php echo $this->crud->getInfo('facebook');?>"><i class="fab fa-facebook-square" aria-hidden="true"></i></a></li>
                                                    <li><a class="socialDash tw" href="<?php echo $this->crud->getInfo('twitter');?>"><i class="fab fa-twitter" aria-hidden="true"></i></a></li>
                                                    <li><a class="socialDash yt" href="<?php echo $this->crud->getInfo('youtube');?>"><i class="fab fa-youtube" aria-hidden="true"></i></a></li>
                                                    <li><a class="socialDash ig" href="<?php echo $this->crud->getInfo('instagram');?>"><i class="fab fa-instagram" aria-hidden="true"></i></a></li>
                        					    </ul>
                    					    </div>
                					    </div>
            					    </div>
                				    <div class="ui-block paddingtel">
                    					<div class="ui-block-content">
                						    <div class="help-support-block">
    											<h3 class="title"><?php echo getPhrase('quick_links');?></h3>
											    <ul class="help-support-list">													
    												<li>
													    <i class="picons-thin-icon-thin-0133_arrow_right_next" style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
													    <a href="<?php echo base_url();?>admin/admin_profile/<?php echo $admin_id_selected;?>/"><?php echo getPhrase('personal_information');?></a>
												    </li>
													<?php if(has_permission('can_edit_admin')): ?>
												    <li>
    													<i class="picons-thin-icon-thin-0133_arrow_right_next" style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
													    <a href="<?php echo base_url();?>admin/admin_update/<?php echo $admin_id_selected;?>/"><?php echo getPhrase('update_information');?></a>
												    </li>
													<?php endif;?>
													<?php if(has_permission('login_as_admin')):?>
													<li>
														<i class="picons-thin-icon-thin-0329_computer_laptop_user_login" style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
														<a href="<?php echo base_url();?>admin/login_as/admin/<?php echo $admin_id_selected;?>/"><?php echo getPhrase('login_as');?></a>
													</li>
                                                	<?php endif;?>
											    </ul>
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
    </div>
<?php endforeach;?>