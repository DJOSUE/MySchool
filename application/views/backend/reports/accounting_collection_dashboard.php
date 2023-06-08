<?php include $view_path.'_data_table_dependency.php';?>

<div class="content-w">
    <?php include  $fancy_path.'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty">
        <div class="os-tabs-w menu-shad">
            <div class="os-tabs-controls">
                <?php include "accounting__nav.php";?>
            </div>
        </div><br>
        <div class="content-i">
            <div class="content-box">
                <div class="element-wrapper">
                    <div class="tab-content">
                        <?= form_open(base_url() . 'reports/accounting_collection_management/');?>
                        <div class="row">
                            <div class="col col-xl-2 col-lg-4 col-md-4 col-sm-8 col-8">
                                <div class="form-group label-floating is-select"  style="background-color: #fff;">
                                    <label class="control-label"><?php echo getPhrase('end_date');?></label>
                                    <div class="form-group date-time-picker">
                                        <input type="date" autocomplete="off" name="end_date"
                                            id="end_date" value="<?=$end_date;?>">

                                    </div>
                                </div>
                            </div>
                            <div class="col col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group label-floating is-select">
                                    <label class="control-label">
                                        <?= getPhrase('student_type');?>
                                    </label>
                                    <div class="select">
                                        <select name="program_id">
                                            <option value=""><?= getPhrase('select');?></option>
                                            <?php foreach($programs as $row): ?>
                                            <option value="<?= $row['program_id'];?>"
                                                <?php if($program_id == $row['program_id']) echo "selected";?>>
                                                <?= $row['name'];?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sx-2">
                                <div class="description-toggle">
                                    <div class="description-toggle-content">
                                        <div class="h6"><?= getPhrase('auto_payment');?></div>
                                    </div>
                                    <div class="togglebutton">
                                        <label><input name="auto_payment" value="1" type="checkbox"
                                                <?php if($auto_payment == 1) echo "checked";?>></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <button class="btn btn-success btn-upper" style="margin-top:20px"
                                        type="submit"><span><?= getPhrase('search');?></span></button>
                                </div>
                            </div>
                        </div>
                        <?= form_close()?>
                        <br />
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>