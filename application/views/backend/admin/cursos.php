<?php 
    $running_year = $this->crud->getInfo('running_year'); 
    $running_semester = $this->crud->getInfo('running_semester'); 

    $add_subject = has_permission('add_subject');
    $edit_subject = has_permission('edit_subject');
    $delete_subject = has_permission('delete_subject');
?>

<div class="content-w">
    <?php $cl_id = base64_decode($class_id);?>
    <script src="<?= base_url();?>public/jscolor.js"></script>
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="all-wrapper no-padding-content solid-bg-all">
            <div class="layout-w">
                <div class="content-w">
                    <div class="content-i">
                        <div class="content-box">
                            <div class="app-email-w">
                                <div class="app-email-i">
                                    <div class="ae-content-w grbg">
                                        <div class="top-header top-header-favorit">
                                            <div class="top-header-thumb">
                                                <img src="<?= base_url();?>public/uploads/bglogin.jpg" class="bgcover">
                                                <div class="top-header-author">
                                                    <div class="author-thumb">
                                                        <img src="<?= base_url();?>public/uploads/<?= $this->crud->getInfo('logo');?>"
                                                            style="background-color: #fff; padding:10px">
                                                    </div>
                                                    <div class="author-content">
                                                        <a href="javascript:void(0);"
                                                            class="h3 author-name"><?= getPhrase('subjects');?>
                                                            <small>
                                                                (<?= $this->db->get_where('class', array('class_id' => $cl_id))->row()->name;?>)
                                                            </small>
                                                        </a>
                                                        <div class="country">
                                                            <?= $this->crud->getInfo('system_name');?> |
                                                            <?= $this->crud->getInfo('system_title');?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="profile-section">
                                                <div class="container-fluid">
                                                    <div class="row">
                                                        <div class="col col-xl-8 m-auto col-lg-8 col-md-12">
                                                            <div class="os-tabs-w">
                                                                <div class="os-tabs-controls">
                                                                    <ul class="navs navs-tabs upper">
                                                                        <?php 
                                                                        $active = 0;
                                                                        $query = $this->db->get_where('section' , array('class_id' => $cl_id, 'year' => $running_year, 'semester_id' => $running_semester )); 
                                                                        if ($query->num_rows() > 0):
                                                                        $sections = $query->result_array();
                                                                        foreach ($sections as $rows): 
                                                                            $active++;
                                                                        ?>
                                                                        <li class="navs-item">
                                                                            <a class="navs-links <?php if($active == 1) echo "active";?>"
                                                                                data-toggle="tab"
                                                                                href="#tab<?= $rows['section_id'];?>">
                                                                                <?= getPhrase('section');?>
                                                                                <?= $rows['name'];?>
                                                                            </a>
                                                                        </li>
                                                                        <?php endforeach;?>
                                                                        <?php endif;?>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="aec-full-message-w">
                                            <div class="aec-full-message">
                                                <div class="container-fluid grbg">
                                                    <div class="tab-content">
                                                        <?php 
                                                        $active2 = 0;
                                                        $query = $this->db->get_where('section' , array('class_id' => $cl_id, 'year' => $running_year, 'semester_id' => $running_semester));
                                                        if ($query->num_rows() > 0):
                                                        $sections = $query->result_array();
                                                        foreach ($sections as $row): $active2++;?>
                                                        <div class="tab-pane <?php if($active2 == 1) echo "active";?>"
                                                            id="tab<?= $row['section_id'];?>">
                                                            <div class="row">
                                                                <?php if($add_subject):?>
                                                                <div
                                                                    class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 margintelbot">
                                                                    <div class="friend-item friend-groups create-group"
                                                                        data-mh="friend-groups-item"
                                                                        style="min-height:200px;">
                                                                        <a href="javascript:void(0);" class="full-block"
                                                                            data-toggle="modal"
                                                                            data-target="#create-friend-group-1"></a>
                                                                        <div class="content">
                                                                            <a data-toggle="modal"
                                                                                data-target="#addsubject"
                                                                                href="javascript:void(0);"
                                                                                class="text-white  btn btn-control bg-blue">
                                                                                <i class="icon-feather-plus"></i>
                                                                            </a>
                                                                            <div class="author-content">
                                                                                <a data-toggle="modal"
                                                                                    data-target="#addsubject"
                                                                                    href="javascript:void(0);"
                                                                                    class="h5 author-name"><?= getPhrase('new_subject');?>
                                                                                </a>
                                                                                <div class="country">
                                                                                    <?= getPhrase('create_new_subject');?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php endif;?>
                                                                <?php 
                                                                    $this->db->order_by('subject_id', 'desc');
                                                                    $subjects = $this->db->get_where('subject', array('class_id' => $cl_id, 'year' => $running_year, 'semester_id' => $running_semester, 'section_id' => $row['section_id']))->result_array();
                                                                    foreach($subjects as $subject):
                                                                        $url = base_url() .'admin/subject_dashboard/'.base64_encode($subject['class_id']."-".$row['section_id']."-".$subject['subject_id'])
                                                                ?>
                                                                <div
                                                                    class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                                                    <div class="ui-block" data-mh="friend-groups-item">
                                                                        <div class="friend-item friend-groups">
                                                                            <div class="friend-item-content">
                                                                                <div class="more">
                                                                                    <i
                                                                                        class="icon-feather-more-horizontal"></i>
                                                                                    <ul class="more-dropdown">
                                                                                        <li>
                                                                                            <a href="<?= $url; ?>">
                                                                                                <?= getPhrase('dashboard');?>
                                                                                            </a>
                                                                                        </li>
                                                                                        <?php if($edit_subject):?>
                                                                                        <li><a href="javascript:void(0);"
                                                                                                onclick="showAjaxModal('<?= base_url();?>modal/popup/modal_subject/<?= $subject['subject_id'];?>');"><?= getPhrase('edit');?></a>
                                                                                        </li>
                                                                                        <?php endif;?>
                                                                                        <?php if($delete_subject):?>
                                                                                        <li><a onClick="return confirm('<?= getPhrase('confirm_delete');?>')"
                                                                                                href="<?= base_url();?>admin/courses/delete/<?= $subject['subject_id'];?>"><?= getPhrase('delete');?></a>
                                                                                        </li>
                                                                                        <?php endif;?>
                                                                                    </ul>
                                                                                </div>
                                                                                <div class="friend-avatar">
                                                                                    <div class="author-thumb">
                                                                                        <img src="<?= base_url();?>public/uploads/subject_icon/<?= $subject['icon'];?>"
                                                                                            width="120px"
                                                                                            style="background-color:#<?= $subject['color'];?>;padding:30px;border-radius:0px;">
                                                                                    </div>
                                                                                    <div class="author-content">
                                                                                        <a href="<?=  $url;?>"
                                                                                            class="h5 author-name">
                                                                                            <?= $subject['name'];?>
                                                                                            -
                                                                                            <?= $row['name'];?>
                                                                                        </a><br>
                                                                                        <span>
                                                                                            <?= $this->academic->get_modality_name($subject['modality_id']);?>
                                                                                        </span>
                                                                                        <br><br>
                                                                                        <img src="<?= $this->crud->get_image_url('teacher', $subject['teacher_id']);?>"
                                                                                            style="border-radius:50%;width:20px;">
                                                                                        <span>
                                                                                            <?= $this->crud->get_name('teacher', $subject['teacher_id']);?>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php endforeach;?>
                                                            </div>
                                                        </div>
                                                        <?php endforeach;?>
                                                        <?php endif;?>
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
            <div class="display-type"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="addsubject" tabindex="-1" role="dialog" aria-labelledby="fav-page-popup" aria-hidden="true">
    <div class="modal-dialog window-popup edit-my-poll-popup" role="document">
        <div class="modal-content">
            <a href="javascript:void(0);" class="close icon-close" data-dismiss="modal" aria-label="Close"></a>
            <div class="modal-header">
                <h6 class="title"><?= getPhrase('new_subject');?></h6>
            </div>
            <div class="modal-body" style="padding:15px">
                <?= form_open(base_url() . 'admin/courses/create/'.$cl_id, array('enctype' => 'multipart/form-data')); ?>
                <div class="row">
                    <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group label-floating">
                            <label class="control-label"><?= getPhrase('name');?></label>
                            <input class="form-control" placeholder="" name="name" type="text" required>
                        </div>
                    </div>
                    <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group">
                            <label class="control-label"><?= getPhrase('about_the_subject');?></label>
                            <textarea class="form-control" name="about"></textarea>
                        </div>
                    </div>
                    <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group label-floating">
                            <label class="control-label text-white"><?= getPhrase('color');?></label>
                            <input class="jscolor" name="color" required value="0084ff">
                        </div>
                    </div>
                    <div class="col col-sm-6">
                        <div class="form-group label-floating is-select">
                            <label class="control-label"><?= getPhrase('class');?></label>
                            <div class="select">
                                <select name="class_id" required="">
                                    <option value=""><?= getPhrase('select');?></option>
                                    <?php 
                                            $class_info = $this->db->get('class')->result_array();
                                            foreach ($class_info as $rowd) { ?>
                                    <option value="<?= $rowd['class_id']; ?>"
                                        <?php if($cl_id == $rowd['class_id']) echo "selected";?>>
                                        <?= $rowd['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col col-sm-6">
                        <div class="form-group label-floating is-select">
                            <label class="control-label"><?= getPhrase('section');?></label>
                            <div class="select">
                                <select name="section_id" required="">
                                    <option value=""><?= getPhrase('select');?></option>
                                    <?php 
                                        $class_info = $this->db->get_where('section', array('class_id' => $cl_id))->result_array();
                                        foreach ($class_info as $rowd) { ?>
                                    <option value="<?= $rowd['section_id']; ?>"><?= $rowd['name']; ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col col-sm-6">
                        <div class="form-group  label-floating is-select">
                            <label class="control-label"><?= getPhrase('icon');?></label>
                            <input class="form-control" name="userfile" type="file">
                        </div>
                    </div>
                    <div class="col col-sm-6">
                        <div class="form-group label-floating is-select">
                            <label class="control-label"><?= getPhrase('teacher');?></label>
                            <div class="select">
                                <select name="teacher_id" required="">
                                    <option value=""><?= getPhrase('select');?></option>
                                    <?php $teachers = $this->db->get('teacher')->result_array();
                                            foreach($teachers as $row):
                                        ?>
                                    <option value="<?= $row['teacher_id'];?>">
                                        <?= $row['first_name']." ".$row['last_name'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col col-lg-12 col-md-12 col-sm-12 col-12">
                        <button class="btn btn-success btn-lg full-width"
                            type="submit"><?= getPhrase('save');?></button>
                    </div>
                </div>
            </div>
            <?= form_close();?>
        </div>
    </div>
</div>