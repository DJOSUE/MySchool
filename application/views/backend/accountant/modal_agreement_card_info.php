<?php
    $this->db->reset_query();        
    $this->db->where('agreement_id', $param2);
    $card_info = $this->db->get('agreement_card')->row_array();
?>
<div class="modal-body">
    <div class="ui-block-title" style="background-color:#00579c">
        <h6 class="title" style="color:white"><?php echo getPhrase('card_info');?></h6>
    </div>
    <div class="ui-block-content">
        <div class="row">
            <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                <ul class="widget w-personal-info item-block">                                                        
                    <li>
                        <span class="title">
                            <?= getPhrase('name');?>:
                        </span>
                        <span class="text">
                            <?= $card_info['card_holder'];?>
                        </span>
                    </li>
                    <li>
                        <span class="title">
                            <?= getPhrase('type_card');?>:
                        </span>
                        <span class="text">
                            <?= $this->payment->get_credit_card_name($card_info['type_card_id']);?>
                        </span>
                    </li>
                    <li>
                        <span class="title">
                            <?= getPhrase('postal_code');?>:
                        </span>
                        <span class="text">
                            <?= $card_info['zip_code'];?>
                        </span>
                    </li>
                </ul>
            </div>
            <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                <ul class="widget w-personal-info item-block">                                                        
                    <li>
                        <span class="title">
                            <?= getPhrase('card_number');?>:
                        </span>
                        <span class="text">
                            <?= get_decrypt($card_info['card_number']);?>
                        </span>
                    </li>
                    <li>
                        <span class="title">
                            <?= getPhrase('expiration_date');?>:
                        </span>
                        <span class="text">
                            <?= get_decrypt($card_info['expiration_date']);?>
                        </span>
                    </li>
                    <li>
                        <span class="title">
                            <?= getPhrase('security_code');?>:
                        </span>
                        <span class="text">
                            <?= get_decrypt($card_info['security_code']);?>
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>