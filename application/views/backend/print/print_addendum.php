<?php 
    $agreement_info     = $this->agreement->get_agreement_info($agreement_id);
    $agreement_archive  = $this->agreement->get_agreement_archive($agreement_id);
    $accountant_name    = $this->crud->get_name(get_account_type(),get_login_user_id());
    
    $student_name       =  $agreement_info['first_name'].' '.$agreement_info['last_name'];
    $amount_contract    = (floatval($agreement_info['tuition']) + floatval($agreement_info['materials']) + floatval($agreement_info['fees'])) - (floatval($agreement_info['scholarship']) + floatval($agreement_info['discounts'])) ;
    $amount_payment     = floatval($agreement_archive->paid);
    $amount_debt        = floatval($amount_contract) - floatval($amount_payment);

    $this->db->reset_query();
    $this->db->select('amortization_no');
    $this->db->where('archive_id', $agreement_archive->archive_id);
    $this->db->where('status_id <>', '1');
    $amortizations_archive = $this->db->get('archive_agreement_amortization')->result_array();

    $array = [];
    foreach($amortizations_archive as  $value){
        array_push($array, $value['amortization_no']);
    }

    $this->db->reset_query();
    $this->db->where('agreement_id', $agreement_id);
    $this->db->where_not_in('amortization_no', $array);
    $amortizations = $this->db->get('agreement_amortization')->result_array();

    $date = date_create($agreement_info['updated_at']);
    $update_date = date_format($date,"Y-m-d");

?>
<style>
    h1 {
        color: navy;
        text-align: center;
    }

    p {
        font-size: small;
    }
    .td-line {
        border-bottom: 0.5px solid black;
    }

    .text-small {
        font-size: small;
    }

    .sign:before {
        content : "";
        position: absolute;
        left    : 0;
        bottom  : 0;
        height  : 1px;
        width   : 50%;  /* or 100px */
        border-bottom:1px solid magenta;
    }

    .line {
        display: block;
        height: 1px;
        border: 0;
        border-top: 1px solid #ccc;
        margin: 1em 0;
        padding: 0;
    }
    .center {
        margin-left: auto;
        margin-right: auto;
    }
</style>

<div>
    <br /><br /><br /><br />
    <br />
    <h1>PAYMENT COMMITMENT</h1>
    
    <br />
    <p>I <b><?=$student_name?></b> understand and agree to cancel my fees previous agreed in my contract even if I stop studying
        at this institution, for the following reasons:</p>
    <table>
        <tr>
            <td class="td-line"></td>
        </tr>
        <tr>
            <td class="td-line"></td>
        </tr>
        <tr>
            <td class="td-line"></td>
        </tr>
        <tr>
            <td class="td-line"></td>
        </tr>
    </table>
    <br/> <br/> <br/>
    <table class="text-small">
        <tr>
            <td>Total Contract:</td>
            <td>$ <?=number_format($amount_contract,2)?></td>
        </tr>
        <tr>
            <td>Total Payment:</td>
            <td>$<?=number_format($amount_payment, 2)?></td>
        </tr>
        <tr>
            <td>Debt:</td>
            <td>$<?=number_format($amount_debt, 2)?></td>
        </tr>
        <tr>
            <td>Commitment Date:</td>
            <td><?=$update_date?></td>
        </tr>
    </table>

    <p>Student agrees to make monthly payments described below for classes request by the student.</p>
    <table class="text-small">
        <?php 
        $i=0;
        foreach($amortizations as $item):
            $i++;
        ?>
        <tr>
            <td>
                <?=$i?> Payment:
            </td>
            <td>
                $ <?=number_format($item['amount'], 2)?>
            </td>
            <td>
                Date:
            </td>
            <td>
                <?=$item['due_date']?>
            </td>
        </tr>
        <?php endforeach;?>
    </table>
    <br/> <br/>
    <br/> <br/>
    <table class="text-small center">
        <tr>
            <td><span style='font-size:10.0pt'>_________________________</span></td>
            <td><span style='font-size:10.0pt'>_________________________</span></td>
        </tr>
        <tr>
            <td><?=$student_name?></td>
            <td><?=$accountant_name?></td>
        </tr>
    </table>
    <?php 
        // echo '<pre>';
        // var_dump($amortizations_archive);
        // echo '</pre>';
    ?>
</div>