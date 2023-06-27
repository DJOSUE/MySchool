<?php 
    
    $user_id     = get_login_user_id();
    $account_type   =   get_table_user(get_role_id());

    $show = 'flex';
    $option = "";
    $checked = "";

    if(!has_permission('request_permission_all'))
    {
       // $show = 'flex';
        $option = 'onclick="return false;"';
    }

    $count = 1;
    $this->db->order_by('request_id', 'desc');

    if($year_id != "")
    {
        $this->db->where('year', $year_id);
    }
    if($semester_id != "")
    {
        $this->db->where('semester_id', $semester_id);
    }

    if($status_id != "")
    {
        $this->db->where('status', $status_id);
    }

    if($assigned_me == 1)
    {
        $checked = 'checked';
        $this->db->where('assigned_to', $user_id);
        $this->db->where('assigned_to_type', $account_type);
    }

    $this->db->where('request_type', '2');
    $requests = $this->db->get('student_request')->result_array();
?>
<?php include $view_path.'_data_table_dependency.php';?>
<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="os-tabs-w menu-shad">
            <div class="os-tabs-controls">
                <?php include 'request__nav.php';?>
            </div>
        </div>
        <div class="content-box">
            <div class="tab-content ">
                <div class="tab-pane active" id="students">
                    <div class="element-wrapper">
                        <h6 class="element-header"><?= getPhrase('student_permissions');?></h6>
                        <div class="row">
                            <div class="content-i">
                                <div class="content-box">
                                    <?= form_open(base_url() . 'admin/request_student/', array('class' => 'form m-b'));?>
                                    <div class="row" style="margin-top: -30px; border-radius: 5px;">
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?= getPhrase('status');?></label>
                                                <div class="select">
                                                    <select name="year_id">
                                                        <?php $class = $this->db->get_where('years', array('status' => '1'))->result_array();
                                                        foreach ($class as $row): ?>
                                                        <option value="<?php echo $row['year']; ?>"
                                                            <?php if($year_id == $row['year']) echo "selected";?>>
                                                            <?php echo $row['year']; ?>
                                                        </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?= getPhrase('status');?></label>
                                                <div class="select">
                                                    <select name="semester_id">
                                                        <?php  $class = $this->db->get('semesters')->result_array();
                                                        foreach ($class as $row): ?>
                                                        <option value="<?php echo $row['semester_id']; ?>"
                                                            <?php if($semester_id == $row['semester_id']) echo "selected";?>>
                                                            <?php echo $row['name']; ?>
                                                        </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group label-floating is-select">
                                                <label class="control-label"><?= getPhrase('status');?></label>
                                                <div class="select">
                                                    <select name="status_id" onchange="get_class_sections(this.value)">
                                                        <?php
                                                        $statuses = $this->studentModel->get_request_statuses();
                                                        foreach($statuses as $row):
                                                    ?>
                                                        <option value="<?= $row['status_id'];?>"
                                                            <?php if($status_id == $row['status_id']) echo "selected";?>>
                                                            <?= $row['name'];?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-2" style="display: <?=$show;?>;">
                                            <div class="description-toggle">
                                                <div class="description-toggle-content">
                                                    <div class="h6"><?= getPhrase('assigned_to_me');?></div>
                                                </div>
                                                <div class="togglebutton">
                                                    <label>
                                                        <input name="assigned_me" value="1" type="checkbox"
                                                            <?=$checked;?> <?=$option;?>>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <button class="btn btn-success btn-upper" style="margin-top:20px"
                                                    type="submit"><span><?= getPhrase('search');?></span></button>
                                            </div>
                                        </div>
                                    </div>
                                    <?= form_close();?>

                                </div>
                            </div>
                        </div>
                        <div class="element-box-tp">
                            <div class="table-responsive">
                                <table class="table table-padded" id="dvData" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th><?= getPhrase('title');?></th>
                                            <th><?= getPhrase('description');?></th>
                                            <th><?= getPhrase('student');?></th>
                                            <th><?= getPhrase('email');?></th>
                                            <th><?= getPhrase('from');?></th>
                                            <th><?= getPhrase('until');?></th>
                                            <th><?= getPhrase('status');?></th>
                                            <th><?= getPhrase('options');?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($requests as $row): ?>
                                        <tr>
                                            <td>
                                                <?= $row['title']; ?>
                                            </td>
                                            <td>
                                                <?php 
                                                if(strlen($row['description']) > 50)
                                                    echo substr($row['description'], 0, 50).'...';
                                                else
                                                    echo $row['description'];?>
                                            </td>
                                            <td class="cell-with-media">
                                                <a href="/admin/student_portal/<?=$row['student_id']?>" target="_blank">
                                                    <img alt=""
                                                        src="<?= $this->crud->get_image_url('student', $row['student_id']);?>"
                                                        style="height: 25px;">
                                                </a>
                                                <span><?= $this->crud->get_name('student', $row['student_id']);?></span>
                                            </td>
                                            <td>
                                                <?= $this->crud->get_email('student', $row['student_id']);?>
                                            </td>
                                            <td>
                                                <a class="badge badge-success"
                                                    style="color:white"><?= $row['start_date']; ?></a>
                                            </td>
                                            <td>
                                                <a class="badge badge-primary"
                                                    style="color:white"><?= $row['end_date']; ?></a>
                                            </td>
                                            <td>
                                                <?php $status_info =  $this->studentModel->get_request_status($row['status']);?>
                                                <a class="btn nc btn-rounded btn-sm btn-primary"
                                                    style="color:white; background-color: <?= $status_info['color'];?>;">
                                                    <?= $status_info['name'];?>
                                                </a>
                                            </td>
                                            <td class="bolder navs-links ">
                                                <a href="javascript:void(0);" class="grey" data-toggle="tooltip"
                                                    data-placement="top" data-original-title="<?= getPhrase('view');?>"
                                                    onclick="showAjaxModal('<?= base_url();?>modal/popup/modal_request_view/<?=$row['request_id'];?>');">
                                                    <i
                                                        class="os-icon picons-thin-icon-thin-0043_eye_visibility_show_visible"></i>
                                                </a>
                                                <?php if($row['status'] == 1) { ?>
                                                <a data-toggle="tooltip" data-placement="top"
                                                    data-original-title="<?= getPhrase('approve');?>"
                                                    onClick="return confirm('<?= getPhrase('confirm_approval');?>')"
                                                    href="<?= base_url();?>admin/request/accept/<?= $row['request_id'];?>/student/">
                                                    <i style="color:gray"
                                                        class="picons-thin-icon-thin-0154_ok_successful_check"></i>
                                                </a>
                                                <a class="grey" data-toggle="tooltip" data-placement="top"
                                                    data-original-title="<?= getPhrase('reject');?>" class="danger"
                                                    onClick="confirm_delete(<?= $row['request_id']; ?>)">
                                                    <i class="picons-thin-icon-thin-0153_delete_exit_remove_close"></i>
                                                </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
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
<script>
function confirm_delete(request_id) {

    // var student_id = document.getElementById("student_id").value;

    Swal.fire({
        input: 'textarea',
        inputLabel: 'reason',
        inputPlaceholder: 'Type your message here...',
        inputAttributes: {
            'aria-label': 'Type your message here'
        },
        title: "<?= getPhrase('confirm_reject');?>",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "<?= getPhrase('reject');?>",
        inputValidator: (value) => {
            return new Promise((resolve) => {
                if (value != '') {
                    resolve()
                } else {
                    resolve('You need to enter a reason')
                }
            })
        }
    }).then((result) => {
        msg = btoa(result.value);
        if (result.value) {
            location.href = '<?= base_url();?>admin/request/reject/' + request_id + '/student/' + msg;
        }
    });

}
</script>

<script>
    var table = $('#dvData').DataTable({
        dom: 'Blifrtp',
        scrollX: true,
        lengthMenu: [
            [10, 20, 50, -1],
            [10, 20, 50, "All"]
        ],
        pageLength: 50,
        buttons: [{
            extend: 'excelHtml5',
            text: '<i class="picons-thin-icon-thin-0123_download_cloud_file_sync" style="font-size: 20px;"></i>',
            titleAttr: 'Export to Excel'
        }]
    });
    $("select[name='dvData_length']" ).addClass('select-page');
</script>