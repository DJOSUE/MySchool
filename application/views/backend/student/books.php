<?php 
    $running_year = $this->crud->getInfo('running_year'); 
    $running_semester = $this->crud->getInfo('running_semester'); 
    $student_id = get_login_user_id();
    $class_id = $this->db->get_where('enroll', array('student_id' => $student_id, 'year' => $running_year, 'semester_id' => $running_semester))->row()->class_id;
?>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="ae-content-w grbg">
            <div class="top-header top-header-favorit">
                <div class="top-header-thumb">
                    <img src="<?php echo base_url();?>public/uploads/bglogin.jpg" alt="nature"
                        class="bgcover">
                    <div class="top-header-author">
                        <div class="author-thumb">
                            <img src="<?php echo base_url();?>public/uploads/<?php echo $this->crud->getInfo('logo');?>"
                                alt="author" style="background-color: #fff; padding:10px">
                        </div>
                        <div class="author-content">
                            <a href="javascript:void(0);" class="h3 author-name"><?php echo getPhrase('library');?></a>
                            <div class="country"><?php echo $this->crud->getInfo('system_name');?> |
                                <?php echo $this->crud->getInfo('system_title');?></div>
                        </div>
                    </div>
                </div>
                <div class="profile-section" style="background-color: #fff;">
                    <div class="control-block-button"></div>
                </div>
            </div>
        </div>
        <div class="content-box">
            <br>
            <div class="tab-content">
                <div class="tab-pane active" id="all">
                    <div class="element-wrapper">
                        <div class="element-box-tp">
                            <div class="table-responsive">
                                <table class="table table-padded">
                                    <thead>
                                        <tr>
                                            <th><?php echo getPhrase('name');?></th>
                                            <th><?php echo getPhrase('description');?></th>
                                            <th><?php echo getPhrase('url');?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $count = 1; 
                                            $book = $this->db->get_where('school_books', array('class_id' => $class_id))->result_array();
                                            foreach($book as $row):?>
                                        <tr>
                                            <td><?php echo $row['name'];?></td>
                                            <td><?php echo $row['description'];?></td>
                                            <td style="color:grey">
                                                <?php if($row['type'] == 'virtual' && $row['file_name'] != ""):?>
                                                <a class="btn btn-rounded btn-sm btn-primary" style="color:white"
                                                    href="<?php echo base_url();?>public/uploads/library/<?php echo $row['file_name'];?>"><i
                                                        class="picons-thin-icon-thin-0042_attachment"></i>
                                                    <?php echo getPhrase('download');?></a>
                                                <?php else:?>
                                                <?php echo getPhrase('no_downloaded');?>
                                                <?php endif;?>
                                            </td>
                                        </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="request">
                    <div class="element-wrapper">
                        <div style="margin-top:auto;float:right;"><a href="javascript:void(0);"
                                data-target="#new_request" data-toggle="modal"
                                class="text-white btn btn-control btn-grey-lighter btn-success"><i
                                    class="picons-thin-icon-thin-0001_compose_write_pencil_new"></i>
                                <div class="ripple-container"></div>
                            </a></div>
                        <div class="element-box-tp">
                            <div class="table-responsive">
                                <table class="table table-padded">
                                    <thead>
                                        <tr>
                                            <th style="width: 60px;">#</th>
                                            <th><?php echo getPhrase('book');?></th>
                                            <th><?php echo getPhrase('requested_by');?></th>
                                            <th><?php echo getPhrase('starting_date');?></th>
                                            <th><?php echo getPhrase('ending_date');?></th>
                                            <th><?php echo getPhrase('status');?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $count = 1;
                                            $this->db->order_by('book_request_id', 'desc');
                                            $book_requests = $this->db->get_where('book_request', array('student_id' => get_login_user_id()))->result_array();
                                            foreach ($book_requests as $row) { ?>
                                        <tr>
                                            <td><?php echo $count++; ?></td>
                                            <td><?php echo $this->db->get_where('book', array('book_id' => $row['book_id']))->row()->name; ?>
                                            </td>
                                            <td><?php echo $this->crud->get_name('student', $row['student_id']);?></td>
                                            <td><?php echo date('d/m/Y', $row['issue_start_date']); ?></td>
                                            <td><?php echo date('d/m/Y', $row['issue_end_date']); ?></td>
                                            <td>
                                                <?php
                                                        if($row['status'] == 0)
                                                            $status = '<div class="status-pill yellow" data-title="'. getPhrase('pending').'" data-toggle="tooltip"></div>';
                                                        else if($row['status'] == 1)
                                                            $status = '<div class="status-pill green" data-title="'. getPhrase('approved').'" data-toggle="tooltip"></div>';
                                                        else
                                                            $status = '<div class="status-pill red" data-title="'. getPhrase('rejected').'" data-toggle="tooltip"></div>';
                                                        echo $status;
                                                    ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="display-type"></div>
</div>