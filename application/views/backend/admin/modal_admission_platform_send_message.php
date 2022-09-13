<?php 

    // Get message

    $email = base64_decode($param2);
    $applicant_id = base64_decode($param3);
    $token = generate_token();
    $url_app = ADMISSION_PLATFORM_URL.'message_thread?auth_token='.$token.'&email='.$email;

    $ch_app = curl_init($url_app);
    curl_setopt($ch_app, CURLOPT_HTTPGET, true);
    curl_setopt($ch_app, CURLOPT_RETURNTRANSFER, true);
    $response_json_app = curl_exec($ch_app);
    curl_close($ch_app);
    $response_app = json_decode($response_json_app, true);

    $message_thread = $response_app['message_thread'];

    if(is_array($message_thread))
    {
        $message_thread_code = $message_thread[0]["message_thread_code"];
    }

    $current_user_email = 'f1@americanone-esl.com';  
    
    $allow_actions = !is_student($applicant_id);

    // echo '<pre>';
    // var_dump($message_thread_code);
    // echo '</pre>';

?>
<link href="<?php echo base_url();?>public/style/messaging/main_messaging.css" rel="stylesheet" type="text/css">

<div class="modal-header" style="background-color:#00579c">
    <div class="user-info" style="color:#fff">
        <?php echo $this->crud->get_name('applicant', $applicant_id); ?>
    </div>
</div>
<div class="modal-body">
    <div class="row">
        <section class="chat" id="chat_body">
            <div class="messages-chat">
                <?php foreach ($message_thread as $row):?>
                <?php if($row['sender_email'] != $current_user_email):?>
                <div class="message text-only">
                    <p class="text"><?=nl2br($row['message']);?></p>
                </div>
                <?php endif;?>
                <?php if($row['sender_email'] == $current_user_email):?>
                <div class="message text-only">
                    <div class="response">
                        <p class="text">
                            <?php
                                $message = str_replace(array("\r\n\r\n","\\r\\n\\r\\n"), '<br/>', $row['message']);
                                echo str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"), '<br/>', $message);
                            ?>
                        </p>
                    </div>
                </div>
                <?php endif;?>
                <?php endforeach;?>
            </div>
        </section>
    </div>
    <div class="footer-chat">
        <?php if($allow_actions): ?>
        <input type="text" id="message" class="write-message" placeholder="Type your message here"></input>
        <a href="javascript:void(0);" class="navs-links" data-toggle="tooltip" data-placement="top"
            data-original-title="<?= getPhrase('send_message');?>" onclick="sendMessage();">
            <i class="os-icon picons-thin-icon-thin-0317_send_post_paper_plane"></i>
        </a>
        <?php endif;?>
    </div>
</div>
<script type="text/javascript">
    function sendMessage() 
    {
        var message = document.getElementById("message").value;

        $.ajax({
                url: '<?php echo base_url();?>admin/admission_applicant_send_message_api/<?=$param2?>/<?= $message_thread_code?>',
                type: 'POST',
                data: {
                    message: message
                },
                success: function(result) {
                    console.log(result);
                    $('#exampleModal').modal('hide');
                }
            });
    }
</script>