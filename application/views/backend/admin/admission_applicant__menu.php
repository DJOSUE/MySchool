                                                <ul class="help-support-list">
                                                    <li>
                                                        <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                                            style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                                        <a
                                                            href="<?= base_url();?>admin/admission_applicant/<?= $applicant_id;?>/">
                                                            <?= getPhrase('personal_information');?>
                                                        </a>
                                                    </li>
                                                    <?php if(!$allow_actions):?>
                                                    <li>
                                                        <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                                            style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                                        <a
                                                            href="<?= base_url();?>admin/admission_applicant_payment/<?= $applicant_id;?>/">
                                                            <?= getPhrase('payment_history');?>
                                                        </a>
                                                    </li>    
                                                    <li>
                                                        <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                                            style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                                        <a
                                                            href="<?= base_url();?>admin/admission_applicant_update/<?= $applicant_id;?>/">
                                                            <?= getPhrase('update_information');?>
                                                        </a>
                                                    </li>                                                    
                                                    <li>
                                                        <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                                            style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                                        <a
                                                            href="<?= base_url();?>admin/admission_applicant_convert/<?= $applicant_id;?>/">
                                                            <?= getPhrase('convert_to_student');?>
                                                        </a>
                                                    </li>
                                                    <?php endif;?>
                                                </ul>