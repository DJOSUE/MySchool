<div class="modal-body">
    <div class="ui-block-title" style="background-color:#00579c">
        <h6 class="title" style="color:white"><?php echo getPhrase('payment_schedule');?></h6>
        <?php
        
        // echo '<pre>';
        // var_dump($param2);
        // echo '</pre>';
        
        ?>
    </div>
    <div class="ui-block-content">
        <div class="row">
            <div class="table-responsive">
                <table class="table table-padded" id="tblPayments">
                    <thead>
                        <tr>
                            <th class="orderby"><?= getPhrase('nro');?></th>
                            <th class="orderby"><?= getPhrase('amount');?></th>
                            <th class="orderby"><?= getPhrase('due_date');?></th>
                            <th class="orderby"><?= getPhrase('status_id');?></th>                            
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $this->db->reset_query();                                                
                        $this->db->order_by('due_date' , 'ASC');
                        $this->db->where('agreement_id', $param2);
                        $agreement = $this->db->get('agreement_amortization')->result_array();

                        foreach($agreement as $row2):
                            $allow_payment      = true;
                            $overdue            = false;
                            $color_due          = 'primary';
                            $status_id          = $row2['status_id'];
                            $amount             = $row2['amount'];
                            $materials          = $row2['materials'];
                            $fees               = $row2['fees'];
                            $amortization_id    = $row2['amortization_id'];    
                            $status_info        = $this->payment->get_payment_schedule_status_info($row2['status_id']);

                            $amount  = floatval($amount) + floatval($materials) + floatval($fees);

                            // Partial Payment
                            if($status_id == 2)
                            {                                                      
                                $this->db->reset_query();
                                $this->db->select_sum('amount');
                                $this->db->where('amortization_id =', $amortization_id);
                                $this->db->where('concept_type =', '1');
                                $paid = $this->db->get('payment_details')->row()->amount; 

                                $amount = $amount - $paid;
                            }
                            
                            //Due date
                            if($row2['due_date'] < date("Y-m-d") && $status_id != 0)
                            {
                                $color_due = "danger";

                                $earlier = new DateTime($row2['due_date']);
                                $later = new DateTime(date("Y-m-d"));

                                $diff = $later->diff($earlier)->format("%a");

                                if($diff >= LATE_FEE_DAYS )
                                {
                                    $overdue = true;
                                }
                            }
                        ?>
                        <tr>
                            <td>
                                <?= $row2['amortization_no'];?>
                            </td>
                            <td>
                                $ <?= number_format($amount, 2); ?>
                            </td>
                            <td>
                                <span class="badge badge-<?=$color_due;?>">
                                    <?= $row2['due_date'];?>
                                </span>
                            </td>
                            <td>
                                <div class="value badge badge-pill badge-primary"
                                    style="background-color: <?=$status_info['color']?>;">
                                    <?= $status_info['name'];?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>