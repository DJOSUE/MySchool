<?php 
    $role_id = '"'.$this->session->userdata('role_id').'"';

    $videos = $this->db->query("SELECT * FROM training_video WHERE status = 1 AND role_ids like '%$role_id%' ")->result_array();

?>

<link rel="stylesheet" type="text/css" href="/public/style/training_videos.css">

<div class="content-w">
    <?php include 'fancy.php';?>
    <div class="header-spacer"></div>
    <div class="conty"><br>
        <div class="container-fluid">
            <div class="layout-w">
                <div class="content-w">
                    <div class="container-fluid">
                        <div class="element-box">
                            <h3 class="form-header"><?php echo getPhrase('training_videos');?></h3><br>
                            <div class="row">
                                <section class="tabs">
                                    <div class="tabs">
                                        <div class="tabs-block">
                                            <div id="tabs-section" class="tabs">
                                                <ul class="tab-head">
                                                    <?php foreach ($videos as $key => $value) : 
                                                        $item = $key + 1;
                                                    ?>
                                                    <li>
                                                        <a href="#tab-<?=$item;?>" class="tab-link <?= $item == 1 ? 'active' : '';?>">
                                                            <span class="material-icons tab-icon">ondemand_video</span> 
                                                            <span class="tab-label"><?=$value['name'];?></span>
                                                        </a>
                                                    </li>
                                                    <?php endforeach;?>
                                                </ul>
                                                <?php foreach ($videos as $key => $value) : 
                                                    $item = $key + 1;
                                                ?>
                                                <section id="tab-<?=$item;?>"
                                                    class="tab-body entry-content <?= $item == 1 ? 'active active-content' : '';?>">
                                                    <h2><?=$value['name'];?></h2>
                                                    <br/>
                                                    <div class="row">
                                                        <div class="col">
                                                            <video width="100%" controls>
                                                                <source src="<?=$value['path'];?>" type="<?=$value['type'];?>">
                                                                Your browser does not support the video tag.
                                                            </video>
                                                        </div>
                                                        <div class="col">
                                                            <?=$value['description'];?>
                                                        </div>
                                                    </div>
                                                </section>
                                                <?php endforeach;?>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="display-type"></div>
        </div>
    </div>
</div>

<script>
//
// Tabs Toggler
//
(function($) {
    // Variables
    const $tabLink = $('#tabs-section .tab-link');
    const $tabBody = $('#tabs-section .tab-body');
    let timerOpacity;

    // Toggle Class
    const init = () => {
        // Menu Click
        $tabLink.off('click').on('click', function(e) {
            // Prevent Default
            e.preventDefault();
            e.stopPropagation();

            // Clear Timers
            window.clearTimeout(timerOpacity);

            // Toggle Class Logic
            // Remove Active Classes
            $tabLink.removeClass('active ');
            $tabBody.removeClass('active ');
            $tabBody.removeClass('active-content');

            // Add Active Classes
            $(this).addClass('active');
            $($(this).attr('href')).addClass('active');

            // Opacity Transition Class
            timerOpacity = setTimeout(() => {
                $($(this).attr('href')).addClass('active-content');
            }, 50);
        });
    };

    // Document Ready
    $(function() {
        init();
    });
}(jQuery));
</script>