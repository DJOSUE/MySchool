<?php 
    $running_year = $this->crud->getInfo('running_year');
    $posts = $this->db->get_where('forum' , array('post_code' => $post_code))->result_array();
    foreach ($posts as $row):
        // echo '<pre>';
        // var_dump($row);
        // echo '</pre>';
?>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="content-i">
            <div class="content-box">
                <div class="back">
                    <a
                        href="<?= base_url();?>teacher/forum/<?= base64_encode($row['class_id']."-".$row['section_id']."-".$row['subject_id']);?>/"><i
                            class="picons-thin-icon-thin-0131_arrow_back_undo"></i></a>
                </div>
                <div class="row">
                    <div class="col-sm-8">
                        <div class="ui-block responsive-flex">
                            <table class="open-topic-table" id="panel">
                                <thead>
                                    <tr>
                                        <th class="author"><?= getPhrase('author');?></th>
                                        <th class="posts"><?= getPhrase('topic');?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="topic-date" colspan="2"><?= $row['timestamp'];?></td>
                                    </tr>
                                    <tr>
                                        <td class="author" width="50px" style="border-right: 1px solid #e6ecf5;">
                                            <div class="author-thumb">
                                                <img src="<?= $this->crud->get_image_url($row['type'], $row['teacher_id']); ?>"
                                                    alt="author">
                                            </div>
                                            <div class="author-content">
                                                <a href="javascript:void(0);"
                                                    class="h6 author-name"><?= $this->crud->get_name($row['type'], $row['teacher_id']);?></a>
                                                <div class="country"><span
                                                        class="badge badge-success"><?= ucwords($row['type']);?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="posts">
                                            <h3><?= $row['title'];?></h3>
                                            <div>
                                                <?= html_entity_decode($row['description']);?>
                                            </div>
                                            <?php if($row['file_name'] != ""):?>
                                            <?= getPhrase('file');?>: <a
                                                class="btn btn-rounded btn-sm btn-primary"
                                                href="<?= base_url();?>public/uploads/forum/<?= $row['file_name'];?>"
                                                style="color:white"><i
                                                    class="os-icon       picons-thin-icon-thin-0042_attachment"></i>
                                                <?= $row['file_name'];?></a>
                                            <?php endif;?>
                                        </td>
                                    </tr>
                                    <?php
                                            $this->db->order_by('message_id' , 'asc'); 
                                            $messages = $this->db->get_where('forum_message' , array('post_id' => $row['post_id']))->result_array();
                                            foreach ($messages as $row2):
                                        ?>
                                    <tr>
                                        <td class="topic-date" colspan="2"><?= $row2['date'];?></td>
                                    </tr>
                                    <tr>
                                        <td class="author" width="50px" style="border-right: 1px solid #e6ecf5;">
                                            <div class="author-thumb">
                                                <?php  if ($row2['user_type'] == "teacher"): ?>
                                                <img alt=""
                                                    src="<?= $this->crud->get_image_url('teacher', $row2['user_id']); ?>">
                                                <?php endif;?>
                                                <?php  if ($row2['user_type'] == "student"): ?>
                                                <img alt=""
                                                    src="<?= $this->crud->get_image_url('student', $row2['user_id']); ?>">
                                                <?php endif;?>
                                                <?php  if ($row2['user_type'] == "admin"): ?>
                                                <img alt=""
                                                    src="<?= $this->crud->get_image_url('admin', $row2['user_id']); ?>">
                                                <?php endif;?>
                                            </div>
                                            <div class="author-content">
                                                <a href="javascript:void(0);"
                                                    class="h6 author-name"><?= $this->crud->get_name($row2['user_type'], $row2['user_id']);?></a>
                                                <?php if($row2['user_type'] == "student"):?>
                                                <div class="country"><span
                                                        class="badge badge-info"><?= ucwords($row2['user_type']);?></span>
                                                </div>
                                                <?php else:?>
                                                <div class="country"><span
                                                        class="badge badge-success"><?= ucwords($row2['user_type']);?></span>
                                                </div>
                                                <?php endif;?>
                                            </div>
                                        </td>
                                        <td class="posts">
                                            <p><?= $row2['message'];?></p>
                                        </td>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>

                        <div class="element-box shadow lined-success">
                            <div class="row" style="margin:2px;margin-bottom:15px">
                                <div class="col-sm-12">
                                    <input type="hidden" value="<?= $post_code;?>" id="post_code"
                                        name="post_code">
                                    <div class="form-group is-empty"><textarea class="form-control"
                                            placeholder="<?= getPhrase('write_message');?>..." id="message"
                                            name="message" required="" rows="5" style="width:100%"></textarea><span
                                            class="material-input"></span></div>
                                    <a id="add" class="btn btn-primary pull-right text-white"
                                        href="javascript:void(0);"><?= getPhrase('reply');?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 ">
                        <div class="eduappgt-sticky-sidebar">
                            <div class="ui-block paddingtel">
                                <div class="ui-block-title">
                                    <h6 class="title"><?= getPhrase('students');?></h6>
                                </div>
                                <ul class="widget w-friend-pages-added notification-list friend-requests">
                                    <?php $students   =   $this->db->get_where('enroll' , array('class_id' => $row['class_id'], 'section_id' => $row['section_id'] , 'year' => $running_year, 'subject_id' => $row['subject_id']))->result_array();
                                        foreach($students as $row2):?>
                                    <li class="inline-items">
                                        <div class="author-thumb">
                                            <img src="<?= $this->crud->get_image_url('student', $row2['student_id']); ?>"
                                                width="35px">
                                        </div>
                                        <div class="notification-event">
                                            <a href="javascript:void(0);"
                                                class="h6 notification-friend"><?= $this->crud->get_name('student', $row2['student_id']);?></a>
                                            <span class="chat-message-item"><?= getPhrase('roll');?>:
                                                <?= $this->db->get_where('enroll' , array('student_id' => $row2['student_id']))->row()->roll; ?></span>
                                        </div>
                                    </li>
                                    <?php endforeach;?>
                                </ul>
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
var post_message = '<?= getPhrase('comment_success');?>';
$(document).ready(function() {
    $("#add").click(function() {
        message = $("#message").val();
        post_code = $("#post_code").val();
        if (message != "" && post_code != "") {
            $.ajax({
                url: "<?= base_url();?>teacher/forum_message/add",
                type: 'POST',
                data: {
                    message: message,
                    post_code: post_code
                },
                success: function(result) {
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
                    });
                }
            });
        }
    });
});
</script>