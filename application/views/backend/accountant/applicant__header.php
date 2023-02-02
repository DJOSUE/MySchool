<div>
                                        <div class="up-head-w"
                                            style="background-image:url(<?= base_url();?>public/uploads/bglogin.jpg)">
                                            <div class="up-main-info">
                                                <div class="user-avatar-w">
                                                    <div class="user-avatar">
                                                        <img alt=""
                                                            src="<?= $this->crud->get_image_url('applicant', $row['applicant_id']);?>"
                                                            style="background-color:#fff;">
                                                    </div>
                                                </div>
                                                <h3 class="text-white"><?= $row['first_name'];?>
                                                    <?= $row['last_name'];?></h3>
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
                                                        <div><?= getPhrase('applicant_type');?>:</div>
                                                        <div class="value badge-status badge-pill badge-info"
                                                            style="background-color: <?= $type_info['color']?>;">
                                                            <?=$type_info['name'];?>

                                                        </div>
                                                    </div>
                                                    <div class="value-pair">
                                                        <div><?= getPhrase('status');?>:</div>
                                                        <div class="value badge-status badge-pill badge-primary"
                                                            style="background-color: <?= $status_info['color']?>;">
                                                            <?= $status_info['name'];?>
                                                        </div>
                                                    </div>
                                                    <?php if($row['is_imported'] == 1) :?>
                                                    <div class="value-pair">
                                                        <div> </div>
                                                        <div class="value badge-status badge-pill badge-primary">
                                                            <?= getPhrase('imported');?>
                                                        </div>
                                                    </div>
                                                    <?php endif;?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>