<?php 
    $worker_id = $param2;
    $period_id = $param3;
    $payment_period = $this->db->get_where('payment_period', array('period_id' => $period_id))->row();   
?>
<div class="modal-body">
    <div class="modal-header" style="background-color:#00579c">
        <h6 class="title" style="color:white"><?php echo getPhrase('time_sheet');?></h6>
    </div>
    <div class="ui-block-content">
        <div class="row">
            <div class="table-responsive">
                <table id="dataTable1" width="100%" class="table table-striped table-lightfont">
                    <thead>
                        <tr>
                            <th scope="col"><?= getPhrase('date')?></th>
                            <th scope="col"><?= getPhrase('clock-in')?></th>
                            <th scope="col"><?= getPhrase('clock-out')?></th>
                            <th scope="col"><?= getPhrase('overtime')?></th>
                            <th scope="col"><?= getPhrase('total_hours')?></th>
                            <th scope="col"><?= getPhrase('note')?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $timesheet = $this->db->query("SELECT * FROM v_time_sheet WHERE worker_id = $worker_id and date BETWEEN '$payment_period->start_date' AND '$payment_period->end_date'")->result_array();
                            foreach ($timesheet as $key => $value):?>                                            
                                <tr>
                                    <td>
                                        <?= $value['date']; ?>
                                    </td>
                                    <td>
                                        <?= $value['start_time']; ?>
                                    </td>
                                    <td>
                                        <?= $value['end_time']; ?>
                                    </td>
                                    <td>
                                        <?= $value['overtime']; ?>
                                    </td>
                                    <td>
                                        <?= $value['hours_worked']; ?>
                                    </td>
                                    <td>
                                        <?= $value['note']; ?>
                                    </td>
                                </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>