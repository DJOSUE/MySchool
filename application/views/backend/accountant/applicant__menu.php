                                                <ul class="help-support-list">
                                                    <li>
                                                        <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                                            style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                                        <a
                                                            href="<?= base_url();?>accountant/applicant_profile/<?= $applicant_id;?>/">
                                                            <?= getPhrase('personal_information');?>
                                                        </a>
                                                    </li>
                                                    <?php if(!$allow_actions):?>
                                                    <li>
                                                        <i class="picons-thin-icon-thin-0133_arrow_right_next"
                                                            style="font-size:20px"></i> &nbsp;&nbsp;&nbsp;
                                                        <a
                                                            href="<?= base_url();?>accountant/applicant_payment/<?= $applicant_id;?>/">
                                                            <?= getPhrase('payment_applicant');?>
                                                        </a>
                                                    </li>
                                                    <?php endif;?>
                                                </ul>