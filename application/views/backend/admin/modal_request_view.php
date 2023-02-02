<?php 
    $this->db->reset_query();
    $this->db->where('request_id' , $param2);
    $task_query = $this->db->get('student_request');
    $edit_data = $task_query->result_array();

    foreach ($edit_data as $row):
        $student_info = $this->crud->get_student_info_by_id($row['student_id']);
?>
<div class="modal-body">
    <div class="modal-header" style="background-color:#00579c">
        <h6 class="title" style="color:white"><?php echo getPhrase('request_info');?></h6>
    </div>
    <div class="modal-body">
        <div class="content-i">
            <div class="content-box">
                <div class="row">
                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                        <ul class="widget w-personal-info item-block">
                            <li>
                                <span class="title">
                                    <?= getPhrase('Name');?>:
                                </span>
                                <span class="text">
                                    <?= $student_info['first_name'] .' '. $student_info['last_name'];?>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                        <ul class="widget w-personal-info item-block">
                            <li>
                                <span class="title">
                                    <?= getPhrase('reason');?>:
                                </span>
                                <span class="text">
                                    <?= $this->studentModel->get_request_type_name($row['request_type']);?>
                                </span>
                            </li>
                        </ul>
                    </div>
                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                        <ul class="widget w-personal-info item-block">
                            <li>
                                <span class="title">
                                    <?= getPhrase('status');?>:
                                </span>
                                <span class="text">
                                    <?php $status_info =  $this->studentModel->get_request_status($row['status']);?>
                                    <a class="btn nc btn-rounded btn-sm btn-primary"
                                        style="color:white; background-color: <?= $status_info['color'];?>;">
                                        <?= $status_info['name'];?>
                                    </a>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php if($row['start_date']):?>
                <div class="row">
                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                        <ul class="widget w-personal-info item-block">
                            <li>
                                <span class="title">
                                    <?= getPhrase('from');?>:
                                </span>
                                <span class="text">
                                    <?= $row['start_date'];?>
                                </span>
                            </li>
                        </ul>
                    </div>
                    <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                        <ul class="widget w-personal-info item-block">
                            <li>
                                <span class="title">
                                    <?= getPhrase('until');?>:
                                </span>
                                <span class="text">
                                    <?= $row['end_date'];?>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
                <? endif;?>
                <div class="row">
                    <div class="col">
                        <ul class="widget w-personal-info item-block">
                            <li>
                                <span class="title">
                                    <?= getPhrase('description');?>:
                                </span>
                                <span class="text">
                                    <?= $row['description'];?>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php if($row['comment']):?>
                <div class="row">
                    <div class="col">
                        <ul class="widget w-personal-info item-block">
                            <li>
                                <span class="title">
                                    <?= getPhrase('response');?>:
                                </span>
                                <span class="text">
                                    <?= $row['comment'];?>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
                <? endif;?>
                <?php if($row['file_name']):?>
                <div class="row">
                    <div class="col">
                        <ul class="widget w-personal-info item-block">
                            <li>
                                <span class="title">
                                    <?= getPhrase('file');?>:
                                </span>
                                <span class="text">
                                    <a href="<?= base_url().PATH_REQUEST_FILES;?><?= $row['file_name'];?>" class="grey"
                                        data-toggle="tooltip" data-placement="top" target="_blank"
                                        data-original-title="<?= getPhrase('view_file');?>">
                                        <i
                                            class="os-icon picons-thin-icon-thin-0075_document_file_paper_text_article_blog_template"></i>
                                        <?= getPhrase('view_file');?>
                                    </a>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
                <? endif;?>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-rounded btn-success" style="float: right;" type="close" data-dismiss="modal"
            aria-label="Close">
            <?= getPhrase('close');?>
        </button>
    </div>
</div>
<?php echo form_close();?>
<?php endforeach; ?>