<?php
    $this->db->reset_query();        
    $this->db->where('agreement_id', $param2);
    $card_info = $this->db->get('agreement_card')->row_array();

    $this->db->reset_query();        
    $this->db->where('agreement_id', $param2);
    $agreement = $this->db->get('agreement')->row_array();

    $automatic = intval($agreement['automatic_payment']) == 0 ? false: true;

    $agreement_card_id = $card_info['agreement_card_id'] ?? 0;

?>
<?php echo form_open(base_url() . 'accountant/agreement/card/'.base64_encode($agreement_card_id).'/'.base64_encode($param3) , array('enctype' => 'multipart/form-data'));?>
<div class="modal-body">
    <div class="ui-block-title" style="background-color:#00579c">
        <h6 class="title" style="color:white"><?php echo getPhrase('card_info');?></h6>
    </div>
    <div class="ui-block-content">
        <div class="row" id="automatic_payment_div">
            <input name="agreement_card_id" id="agreement_card_id" type="hidden" value="<?= $agreement_card_id;?>">
            <input name="agreement_id" id="agreement_id" type="hidden" value="<?= $param2;?>">
            <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="form-group label-floating is-select">
                    <label class="control-label"><?= getPhrase('automatic_payment');?>
                    </label>
                    <div class="select">
                        <select name="automatic_payment" id="automatic_payment">
                            <option value="1" <?=$automatic ?  'selected': ''?>> Yes </option>
                            <option value="0" <?=$automatic ?  '': 'selected'?>> No </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="form-group label-floating is-select">
                    <label class="control-label"><?= getPhrase('type_card');?>
                    </label>
                    <div class="select">
                        <select name="type_card_id" id="type_card_id">
                            <?php 
                                $card_types = $this->payment->get_credit_cards();
                                foreach($card_types as $item):
                                    $selected = $card_info['type_card_id'] == $item['creditcard_id'] ? 'selected' : '';
                            ?>
                            <option value="<?= $item['creditcard_id']; ?>" <?=$selected?>>
                                <?= $item['name']; ?>
                            </option>
                            <?php endforeach?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="form-group label-floating">
                    <label class="control-label"><?= getPhrase('card_holder');?>
                    </label>
                    <input class="form-control" name="card_holder" id="card_holder" type="text"
                        value="<?= $card_info['card_holder'];?>">
                </div>
            </div>
            <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="form-group label-floating">
                    <label class="control-label"><?= getPhrase('card_number');?>
                    </label>
                    <input class="form-control" name="card_number" id="card_number" type="text" minlength="15"
                        maxlength="16" value="<?= get_decrypt($card_info['card_number']);?>">
                </div>
            </div>
            <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="form-group label-floating">
                    <label class="control-label"><?= getPhrase('expiration_date');?>
                    </label>
                    <input class="form-control" name="expiration_date" id="expiration_date" type="text" minlength="4"
                        maxlength="7" value="<?= get_decrypt($card_info['expiration_date']);?>">
                </div>
            </div>
            <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="form-group label-floating">
                    <label class="control-label"><?= getPhrase('security_code');?>
                    </label>
                    <input class="form-control" name="security_code" id="security_code" type="text" minlength="3"
                        maxlength="4" value="<?=  get_decrypt($card_info['security_code']);?>">
                </div>
            </div>
            <div class="col col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="form-group label-floating">
                    <label class="control-label"><?= getPhrase('zip_code');?>
                    </label>
                    <input class="form-control" name="zip_code" id="zip_code" type="text" minlength="5"
                        value="<?=  get_decrypt($card_info['zip_code']);?>">
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-rounded btn-success" type="submit"> <?php echo getPhrase('save');?></button>
    </div>
</div>
<?= form_close()?>