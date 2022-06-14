<?php 
    $running_year       = $this->crud->getInfo('running_year');    
    $running_semester   = $this->crud->getInfo('running_semester');

    $syllabus       = "";
    $application    = "";
    $content        = "";
    $workbook       = "";

    $class_book = $this->db->get_where('class_books' , array('class_id' => $class_id, 'is_saturday' => $is_saturday, 'status' => '1'))->result_array();

    foreach ($class_book as $row => $item) {
        if(strpos(strtolower($item['code']), "syllabus")!== false)
        {
            $syllabus = $item['url'];
        }
        if(strpos(strtolower($item['code']), 'application')!== false)
        {
            $application = $item['url'];
        }
        if(strpos(strtolower($item['code']), 'content')!== false)
        {
            $content = $item['url'];
        }
        if(strpos(strtolower($item['code']), 'workbook')!== false)
        {
            $workbook = $item['url'];
        }
    }
?>
    <div class="content-w">
        <div class="conty">
            <?php include $path_fancy;?>
            <div class="header-spacer"></div>
            <div class="os-tabs-w menu-shad">
                <div class="os-tabs-controls">
                    <ul class="navs navs-tabs upper">
                        <?php
                        // echo '<pre>';
                        // var_dump($program_id);
                        // echo '</pre>';
                        ?>
                        <?php if($syllabus != ""):?>
                        <li class="navs-item">
                            <a class="navs-links book-trigger active" id="bookLink01" href="#stepContent01"><i
                                    class="os-icon picons-thin-icon-thin-0008_book_reading_read_manual"></i><span><?= getPhrase('syllabus');?></span></a>
                        </li>
                        <?php endif; ?>
                        <?php if($application != "" && ($program_id == 1 || $program_id == 0)):?>
                        <li class="navs-item">
                            <a class="navs-links book-trigger" id="bookLink02" href="#stepContent02"><i
                                    class="os-icon os-icon picons-thin-icon-thin-0006_book_writing_reading_read_manual"></i><span><?= getPhrase('application');?></span></a>
                        </li>
                        <?php endif; ?>
                        <?php if($content != ""):?>
                        <li class="navs-item">
                            <a class="navs-links book-trigger" id="bookLink03" href="#stepContent03"><i
                                    class="os-icon os-icon picons-thin-icon-thin-0016_bookmarks_reading_book"></i><span><?= getPhrase('content');?></span></a>
                        </li>
                        <?php endif; ?>
                        <?php if($workbook != ""):?>
                        <li class="navs-item">
                            <a class="navs-links book-trigger" id="bookLink04" href="#stepContent04"><i
                                    class="os-icon os-icon picons-thin-icon-thin-0007_book_reading_read_bookmark"></i><span><?= getPhrase('workbook');?></span></a>
                        </li>
                        <?php endif; ?>
                    </ul>
                    <h4>
                        <?= $class_name;?>
                    </h4>
                </div>
            </div>
            <div class="content">
                <div class="book-contents">
                    <?php if($syllabus != ""):?>
                    <div class="book-content active" id="stepContent01">
                        <div class="row">
                            <iframe class="iframe" src="<?= $syllabus;?>" frameborder="0">></iframe>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if($application != ""):?>
                    <div class="book-content" id="stepContent02">
                        <div class="row">
                            <iframe class="iframe" referrerpolicy="unsafe-url" src="<?= $application;?>" frameborder="0">></iframe>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if($content != ""):?>
                    <div class="book-content" id="stepContent03">
                        <div class="row">
                            <iframe class="iframe" src="<?= $content;?>" frameborder="0">></iframe>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if($workbook != ""):?>
                    <div class="book-content" id="stepContent04">
                        <div class="row">
                            <iframe class="iframe" src="<?= $workbook;?>" frameborder="0">></iframe>
                        </div>
                    </div>
                    <?php endif; ?>                    
                </div>            
            </div>
        </div>
    </div>