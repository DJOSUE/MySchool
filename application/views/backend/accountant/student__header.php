<?php
    $status_info = $this->studentModel->get_status_info($row['student_session']);
    $program_info = $this->studentModel->get_program_info($row['program_id']);
?>
<div class="up-head-w"
    style="background-image:url(<?= base_url();?>public/uploads/bglogin.jpg)">
    <div class="up-main-info">
        <div class="user-avatar-w">
            <div class="user-avatar">
                <img alt=""
                    src="<?= $this->crud->get_image_url('student', $row['student_id']);?>"
                    style="background-color:#fff;">
            </div>
        </div>
        <h3 class="text-white"><?= $row['first_name'];?>
            <?= $row['last_name'];?></h3>
        <h5 class="up-sub-header">@<?= $row['username'];?></h5>
    </div>
    <svg class="decor" width="842px" height="219px" viewBox="0 0 842 219"
        preserveAspectRatio="xMaxYMax meet" version="1.1"
        xmlns="http://www.w3.org/2000/svg"
        xmlns:xlink="http://www.w3.org/1999/xlink">
        <g transform="translate(-381.000000, -362.000000)" fill="#FFFFFF">
            <path class="decor-path"
                d="M1223,362 L1223,581 L381,581 C868.912802,575.666667 1149.57947,502.666667 1223,362 Z">
            </path>
        </g>
    </svg>
</div>
<div class="up-controls">
    <div class="row">
        <div class="col-lg-6">
            <div class="value-pair">
                <div><?= getPhrase('status');?>:</div>
                <div class="value badge-status badge-pill badge-primary" style="background-color: <?=$status_info['color']?>;">
                    <?= $status_info['name'];?>
                </div>
            </div>
            <div class="value-pair">
                <div><?= getPhrase('program');?>:</div>
                <div class="value badge-status badge-pill badge-primary">
                    <?= $program_info['name'];?>
                </div>
            </div>
            <div class="value-pair">
                <div><?= getPhrase('member_since');?>:</div>
                <div class="value"><?= $row['since'];?>.</div>
            </div>
            <div class="value-pair">
                <div><?= getPhrase('roll');?>:</div>
                <div class="value">
                    <?= $row['student_code']?>.
                </div>
            </div>
        </div>
    </div>
</div>