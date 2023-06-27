    <div class="content-w">
        <?php include 'fancy.php';?>
        <div class="header-spacer"></div>
        <div class="content-i">
            <div class="content-box">
                <div class="conty">
                    <div class="row">
                        <main class="col col-xl-6 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">
                            <?php if(has_permission('news_management')):?>
                            <div class="ui-block paddingtel">
                                <div class="news-feed-form">
                                    <div class="tab-content">
                                        <div class="edu-wall-content ng-scope" id="new_post">
                                            <div class="tab-pane active show">
                                                <?= form_open(base_url() . 'admin/news/create/', array('enctype' => 'multipart/form-data')); ?>
                                                <div class="author-thumb" style="padding-right:15px;">
                                                    <img src="<?= $this->crud->get_image_url('admin', get_login_user_id());?>"
                                                        class="imgwidth">
                                                </div>
                                                <div class="form-group with-icon label-floating is-empty"
                                                    style="padding-left:10px; padding-right:10px;">
                                                    <label for="ckeditor1"
                                                        style="margin-top: 35px;margin-left: 70px;margin-bottom: 20px;">
                                                        <?= getPhrase('hi');?>
                                                        <?= $this->db->get_where('admin', array('admin_id' => get_login_user_id()))->row()->first_name;?>
                                                        <?= getPhrase('what_publish');?>
                                                    </label>
                                                    <textarea id="ckeditor1" name="description" required=""></textarea>
                                                    <span class="material-input"></span>
                                                </div>
                                                <div class="form-group" style="margin-bottom:-15px;">
                                                    <input type="file" name="userfile" onchange="imagePreview()"
                                                        id="userfile" class="inputfile inputfile-3"
                                                        style="display:none">
                                                    <label style="font-size:15px;" for="userfile"><i
                                                            class="os-icon picons-thin-icon-thin-0042_attachment"></i>
                                                        <span><?= getPhrase('upload_image');?>...</span></label>
                                                </div>
                                                <center><img id="logoPreview" src="" width="40%"
                                                        style="display:none;border-radius:5%;border:2px solid #eee;padding:5px" />
                                                </center>
                                                <div class="add-options-message btm-post edupostfoot edu-wall-actions"
                                                    style="padding:10px 5px;">
                                                    <a href="javascript:void(0);" class="options-message"
                                                        onclick="post()" data-toggle="tooltip" data-placement="top"
                                                        data-original-title="<?= getPhrase('news');?>">
                                                        <i class="os-icon picons-thin-icon-thin-0032_flag"></i>
                                                    </a>
                                                    <a href="javascript:void(0);" class="options-message"
                                                        onclick="poll()" data-toggle="tooltip" data-placement="top"
                                                        data-original-title="<?= getPhrase('polls');?>">
                                                        <i
                                                            class="os-icon picons-thin-icon-thin-0385_graph_pie_chart_statistics"></i>
                                                    </a>
                                                    <a href="javascript:void(0);" class="options-message"
                                                        onclick="video()" data-toggle="tooltip" data-placement="top"
                                                        data-original-title="<?= getPhrase('youtube_video');?>">
                                                        <i
                                                            class="os-icon picons-thin-icon-thin-0593_video_play_youtube"></i>
                                                    </a>
                                                    <button class="btn btn-rounded btn-edu" style="float:right"><i
                                                            class="picons-thin-icon-thin-0317_send_post_paper_plane"
                                                            style="font-size:12px"></i>
                                                        <?= getPhrase('publish');?></button>
                                                </div>
                                                <?= form_close();?>
                                            </div>
                                        </div>
                                        <div class="edu-wall-content ng-scope" id="new_video" style="display: none;">
                                            <div class="tab-pane show">
                                                <?= form_open(base_url() . 'admin/news/create_video/', array('enctype' => 'multipart/form-data')); ?>
                                                <input type="hidden" name="embed" id="embed">
                                                <div class="author-thumb" style="padding-right:15px;">
                                                    <img src="<?= $this->crud->get_image_url('admin', get_login_user_id());?>"
                                                        class="imgwidth">
                                                </div>
                                                <div class="form-group with-icon label-floating is-empty"
                                                    style="padding-left:10px;">
                                                    <textarea onkeyup="textAreaAdjust(this)" style="overflow:hidden"
                                                        class="form-control"
                                                        placeholder="<?= getPhrase('hi');?> <?= $this->db->get_where('admin', array('admin_id' => get_login_user_id()))->row()->first_name;?> <?= getPhrase('what_publish');?>"
                                                        name="description" required=""></textarea>
                                                    <span class="material-input"></span>
                                                </div>
                                                <div class="form-group" style="margin-bottom:-15px;">
                                                    <input type="text" name="url" id="url" class="form-control"
                                                        placeholder="YouTube URL" onchange="set_video()">
                                                </div><br>
                                                <pre style="text-align:center;display:none;" id="myCode"></pre>
                                                <div class="add-options-message btm-post edupostfoot edu-wall-actions"
                                                    style="padding:10px 5px;">
                                                    <a href="javascript:void(0);" class="options-message"
                                                        onclick="post()" data-toggle="tooltip" data-placement="top"
                                                        data-original-title="<?= getPhrase('news');?>">
                                                        <i class="os-icon picons-thin-icon-thin-0032_flag"></i>
                                                    </a>
                                                    <a href="javascript:void(0);" class="options-message"
                                                        onclick="poll()" data-toggle="tooltip" data-placement="top"
                                                        data-original-title="<?= getPhrase('polls');?>">
                                                        <i
                                                            class="os-icon picons-thin-icon-thin-0385_graph_pie_chart_statistics"></i>
                                                    </a>
                                                    <a href="javascript:void(0);" class="options-message"
                                                        onclick="video()" data-toggle="tooltip" data-placement="top"
                                                        data-original-title="<?= getPhrase('youtube_video');?>">
                                                        <i
                                                            class="os-icon picons-thin-icon-thin-0593_video_play_youtube"></i>
                                                    </a>
                                                    <button class="btn btn-rounded btn-edu" style="float:right"><i
                                                            class="picons-thin-icon-thin-0317_send_post_paper_plane"
                                                            style="font-size:12px"></i>
                                                        <?= getPhrase('publish');?></button>
                                                </div>
                                                <?= form_close();?>
                                            </div>
                                        </div>
                                        <div class="edu-wall-content ng-scope" id="new_poll" style="display: none;">
                                            <?= form_open(base_url() . 'admin/polls/create/' , array('enctype' => 'multipart/form-data'));?>
                                            <div class="tab-pane active show"><br>
                                                <div class="col-sm-12">
                                                    <h5 class="form-header"><?= getPhrase('create_poll');?></h5>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <div class="form-group label-floating">
                                                            <label
                                                                class="control-label"><?= getPhrase('question');?></label>
                                                            <input class="form-control" type="text" name="question">
                                                            <span class="material-input"></span>
                                                            <span class="material-input"></span>
                                                        </div>
                                                    </div>
                                                </div><br>
                                                <div id="bulk_add_form">
                                                    <div id="student_entry">
                                                        <div class="form-group">
                                                            <div class="col-sm-12">
                                                                <label class="col-form-label"
                                                                    for=""><?= getPhrase('options');?></label>
                                                                <div class="input-group">
                                                                    <input class="form-control" name="options[]"
                                                                        placeholder="<?= getPhrase('options');?>"
                                                                        type="text">
                                                                    <button
                                                                        class="btn btn-sm btn-danger bulk text-center"
                                                                        href="javascript:void(0);"
                                                                        onclick="deleteParentElement(this)"><i
                                                                            class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="student_entry_append"></div>
                                                </div> <br>
                                                <center><a href="javascript:void(0);"
                                                        class="btn btn-rounded btn-primary btn-sm"
                                                        onclick="append_student_entry()">+
                                                        <?= getPhrase('more_options');?></a></center><br>
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <div class="form-group label-floating is-select">
                                                            <label
                                                                class="control-label"><?= getPhrase('users');?></label>
                                                            <div class="select">
                                                                <select name="user" id="slct">
                                                                    <option value=""><?= getPhrase('select');?>
                                                                    </option>
                                                                    <option value="all"><?= getPhrase('all');?>
                                                                    </option>
                                                                    <option value="admin">
                                                                        <?= getPhrase('admins');?></option>
                                                                    <option value="student">
                                                                        <?= getPhrase('students');?></option>
                                                                    <option value="parent">
                                                                        <?= getPhrase('parents');?></option>
                                                                    <option value="teacher">
                                                                        <?= getPhrase('teachers');?></option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><br>
                                                <div class="add-options-message btm-post edupostfoot edu-wall-actions"
                                                    style="padding:10px 5px;">
                                                    <a href="javascript:void(0);" class="options-message"
                                                        onclick="post()" data-toggle="tooltip" data-placement="top"
                                                        data-original-title="<?= getPhrase('news');?>">
                                                        <i class="os-icon picons-thin-icon-thin-0032_flag"></i>
                                                    </a>
                                                    <a href="javascript:void(0);" class="options-message"
                                                        onclick="poll()" data-toggle="tooltip" data-placement="top"
                                                        data-original-title="<?= getPhrase('poll');?>">
                                                        <i
                                                            class="os-icon picons-thin-icon-thin-0385_graph_pie_chart_statistics"></i>
                                                    </a>
                                                    <a href="javascript:void(0);" class="options-message"
                                                        onclick="video()" data-toggle="tooltip" data-placement="top"
                                                        data-original-title="<?= getPhrase('youtube_video');?>">
                                                        <i
                                                            class="os-icon picons-thin-icon-thin-0593_video_play_youtube"></i>
                                                    </a>
                                                    <button class="btn btn-rounded btn-edu" style="float:right"><i
                                                            class="picons-thin-icon-thin-0317_send_post_paper_plane"
                                                            style="font-size:12px"></i>
                                                        <?= getPhrase('publish');?></button>
                                                </div>
                                            </div>
                                            <?= form_close();?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif;?>
                            <div id="panel">
                                <?php 
                                    $db = $this->db->query('SELECT description, publish_date, type,news_id FROM news UNION SELECT question,publish_date,type,id FROM polls ORDER BY publish_date DESC LIMIT 5')->result_array();
                                    // echo '<pre>';
                                    // print_r($db );
                                    // echo '</pre>';
                                    foreach($db as $wall):
                                    $this->crud->setRead($wall['news_id']);
                                ?>
                                <?php if($wall['type'] == 'news'):?>
                                <div class="ui-block paddingtel">
                                    <?php 
                                    $news_code = $this->db->get_where('news', array('news_id' => $wall['news_id']))->row()->news_code;
                                    $admin_id = $this->db->get_where('news', array('news_id' => $wall['news_id']))->row()->admin_id;?>
                                    <article class="hentry post has-post-thumbnail thumb-full-width">
                                        <div class="post__author author vcard inline-items">
                                            <img src="<?= $this->crud->get_image_url('admin', $admin_id);?>">
                                            <div class="author-date">
                                                <a class="h6 post__author-name fn"
                                                    href="javascript:void(0);"><?= $this->crud->get_name('admin', $admin_id);?></a>
                                                <div class="post__date">
                                                    <time class="published"
                                                        style="color: #0084ff;"><?= $this->db->get_where('news', array('news_id' => $wall['news_id']))->row()->date." ".$this->db->get_where('news', array('news_id' => $wall['news_id']))->row()->date2;?></time>
                                                </div>
                                            </div>
                                            <?php if(has_permission('news_management')):?>
                                            <div class="more">
                                                <i class="icon-options"></i>
                                                <ul class="more-dropdown">
                                                    <li><a href="javascript:void(0);"
                                                            onclick="showAjaxModal('<?= base_url();?>modal/popup/modal_wall/<?= $news_code;?>');"><?= getPhrase('edit');?></a>
                                                    </li>
                                                    <li><a onClick="return confirm('<?= getPhrase('confirm_delete');?>')"
                                                            href="<?= base_url();?>admin/news/delete/<?= $news_code;?>"><?= getPhrase('delete');?></a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <?php endif;?>
                                        </div>
                                        <?php if (file_exists('public/uploads/news_images/'.$news_code.'.jpg')):?>
                                        <hr>
                                        <div class="post-thumb">
                                            <img
                                                src="<?= base_url();?>public/uploads/news_images/<?= $news_code;?>.jpg">
                                        </div>
                                        <p><?= $this->crud->check_text($wall['description']);?></p>
                                        <?php else:?>
                                        <div class="wall-content">
                                            <p><?= $this->crud->check_text($wall['description']);?></p>
                                        </div>
                                        <?php endif;?>
                                        <div class="control-block-button post-control-button">
                                            <a href="javascript:void(0);" class="btn btn-control"
                                                style="background-color:#001b3d; color:#fff;" data-toggle="tooltip"
                                                data-placement="top" data-original-title="<?= getPhrase('news');?>">
                                                <i class="picons-thin-icon-thin-0032_flag"></i>
                                            </a>
                                        </div>
                                        <?php
                                            $checkData = $this->crud->getRead($wall['news_id']);
                                            if(count($checkData) > 0):
                                        ?>
                                        <div class="post-additional-info inline-items">
                                            <ul class="friends-harmonic">
                                                <?php foreach($checkData as $readed):?>
                                                <li>
                                                    <a href="javascript:void(0);">
                                                        <img loading="lazy"
                                                            onclick="showAjaxModal('<?= base_url();?>modal/popup/modal_users/<?= $wall['news_id'];?>');"
                                                            title="<?= $this->crud->get_name($readed['user_type'], $readed['user_id']);?>"
                                                            src="<?= $this->crud->get_image_url($readed['user_type'], $readed['user_id']);?>"
                                                            alt="<?= $this->crud->get_name($readed['user_type'], $readed['user_id']);?>"
                                                            width="28" height="28">
                                                    </a>
                                                </li>
                                                <?php endforeach;?>
                                            </ul>
                                            <div class="names-people-likes">
                                                <?php if(count($checkData) > 5):?>
                                                <?= getPhrase('and');?> <?= count($checkData)-5;?>
                                                <?= getPhrase('other_people_viewed_this_post');?>.
                                                <?php else:?>
                                                <?= getPhrase('have_seen_this_post');?>
                                                <?php endif;?>
                                            </div>
                                            <div class="comments-shared">
                                                <a href="javascript:void(0);" class="post-add-icon inline-items"></a>
                                                <a href="javascript:void(0);" class="post-add-icon inline-items"></a>
                                            </div>
                                        </div>
                                        <?php endif;?>
                                    </article>
                                </div>
                                <?php endif;?>
                                <?php if($wall['type'] == 'video'):?>
                                <div class="ui-block paddingtel">
                                    <?php 
                                    $news_code = $this->db->get_where('news', array('news_id' => $wall['news_id']))->row()->news_code;
                                    $news_embed = $this->db->get_where('news', array('news_id' => $wall['news_id']))->row()->embed;
                                    $admin_id = $this->db->get_where('news', array('news_id' => $wall['news_id']))->row()->admin_id;?>
                                    <article class="hentry post has-post-thumbnail thumb-full-width">
                                        <div class="post__author author vcard inline-items">
                                            <img src="<?= $this->crud->get_image_url('admin', $admin_id);?>">
                                            <div class="author-date">
                                                <a class="h6 post__author-name fn"
                                                    href="javascript:void(0);"><?= $this->crud->get_name('admin', $admin_id);?></a>
                                                <div class="post__date">
                                                    <time class="published"
                                                        style="color: #0084ff;"><?= $this->db->get_where('news', array('news_id' => $wall['news_id']))->row()->date." ".$this->db->get_where('news', array('news_id' => $wall['news_id']))->row()->date2;?></time>
                                                </div>
                                            </div>
                                            <div class="more">
                                                <i class="icon-options"></i>
                                                <ul class="more-dropdown">
                                                    <li><a href="javascript:void(0);"
                                                            onclick="showAjaxModal('<?= base_url();?>modal/popup/modal_wall/<?= $news_code;?>');"><?= getPhrase('edit');?></a>
                                                    </li>
                                                    <li><a onClick="return confirm('<?= getPhrase('confirm_delete');?>')"
                                                            href="<?= base_url();?>admin/news/delete/<?= $news_code;?>"><?= getPhrase('delete');?></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <hr>
                                        <p><?= $this->crud->check_text($wall['description']);?></p>
                                        <div class="post-thumb">
                                            <iframe src="<?= $news_embed;?>" height="360" width="100%" frameborder="0"
                                                allowfullscreen=""></iframe>
                                        </div>
                                        <div class="control-block-button post-control-button">
                                            <a href="javascript:void(0);" class="btn btn-control"
                                                style="background-color:#001b3d; color:#fff;" data-toggle="tooltip"
                                                data-placement="top" data-original-title="<?= getPhrase('news');?>">
                                                <i class="picons-thin-icon-thin-0032_flag"></i>
                                            </a>
                                        </div>
                                        <?php
                                            $checkData = $this->crud->getRead($wall['news_id']);
                                            if(count($checkData) > 0):
                                        ?>
                                        <div class="post-additional-info inline-items">
                                            <ul class="friends-harmonic">
                                                <?php foreach($checkData as $readed):?>
                                                <li>
                                                    <a href="javascript:void(0);">
                                                        <img loading="lazy"
                                                            onclick="showAjaxModal('<?= base_url();?>modal/popup/modal_users/<?= $wall['news_id'];?>');"
                                                            title="<?= $this->crud->get_name($readed['user_type'], $readed['user_id']);?>"
                                                            src="<?= $this->crud->get_image_url($readed['user_type'], $readed['user_id']);?>"
                                                            alt="<?= $this->crud->get_name($readed['user_type'], $readed['user_id']);?>"
                                                            width="28" height="28">
                                                    </a>
                                                </li>
                                                <?php endforeach;?>
                                            </ul>
                                            <div class="names-people-likes">
                                                <?php if(count($checkData) > 5):?>
                                                <?= getPhrase('and');?> <?= count($checkData)-5;?>
                                                <?= getPhrase('other_people_viewed_this_post');?>.
                                                <?php else:?>
                                                <?= getPhrase('have_seen_this_post');?>.
                                                <?php endif;?>
                                            </div>
                                            <div class="comments-shared">
                                                <a href="javascript:void(0);" class="post-add-icon inline-items"></a>
                                                <a href="javascript:void(0);" class="post-add-icon inline-items"></a>
                                            </div>
                                        </div>
                                        <?php endif;?>
                                    </article>
                                </div>
                                <?php endif;?>
                                <?php if($wall['type'] == 'polls'):?>
                                <?= form_open(base_url() . 'admin/polls/response/' , array('enctype' => 'multipart/form-data'));?>
                                <?php 
                                        $usrdb = $this->db->get_where('polls', array('id' => $wall['news_id']))->row()->user;
                                        $poll_code = $this->db->get_where('polls', array('id' => $wall['news_id']))->row()->poll_code;
                                        $admin_id = $this->db->get_where('polls', array('id' => $wall['news_id']))->row()->admin_id;
                                        $options = $this->db->get_where('polls', array('id' => $wall['news_id']))->row()->options;
                                    ?>
                                <?php if($usrdb == 'admin' || $usrdb == 'all'):?>
                                <?php 
                                        $type = 'admin';
                                        $id = get_login_user_id();
                                        $user = $type. "-".$id;
                                        $query = $this->db->get_where('poll_response', array('poll_code' => $poll_code, 'user' => $user));
                                    ?>
                                <?php if($query->num_rows() <= 0):?>
                                <div class="ui-block paddingtel">
                                    <input type="hidden" name="poll_code" id="poll_code" value="<?= $poll_code;?>">
                                    <article class="hentry post">
                                        <div class="post__author author vcard inline-items">
                                            <img src="<?= $this->crud->get_image_url('admin', $admin_id);?>"
                                                alt="author">
                                            <div class="author-date">
                                                <a class="h6 post__author-name fn"
                                                    href="javascript:void(0);"><?= $this->crud->get_name('admin', $admin_id);?></a>
                                                <div class="post__date">
                                                    <time class="published"
                                                        style="color: #0084ff;"><?= $this->db->get_where('polls', array('id' => $wall['news_id']))->row()->date." ".$this->db->get_where('polls', array('id' => $wall['news_id']))->row()->date2;?></time>
                                                </div>
                                            </div>
                                            <div class="more">
                                                <i class="icon-options"></i>
                                                <ul class="more-dropdown">
                                                    <li><a
                                                            href="<?= base_url();?>admin/view_poll/<?= $poll_code;?>/"><?= getPhrase('go_to_details');?></a>
                                                    </li>
                                                    <li><a onClick="return confirm('<?= getPhrase('confirm_delete');?>')"
                                                            href="<?= base_url();?>admin/polls/delete/<?= $poll_code;?>"><?= getPhrase('delete');?></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="control-block-button post-control-button">
                                            <a href="javascript:void(0);" class="btn btn-control"
                                                style="background-color:#99bf2d; color:#fff;" data-toggle="tooltip"
                                                data-placement="top" data-original-title="<?= getPhrase('polls');?>">
                                                <i class="picons-thin-icon-thin-0385_graph_pie_chart_statistics"></i>
                                            </a>
                                        </div>
                                        <div class="wall-content">
                                            <ul class="widget w-pool">
                                                <li>
                                                    <h4><?= $wall['description'];?></h4>
                                                </li><br>
                                                <?php 
                                                        $array = ( explode(',' , $options));
                                                        for($i = 0 ; $i<count($array)-1; $i++):
                                                    ?>
                                                <li>
                                                    <div class="skills-item">
                                                        <div class="skills-item-info">
                                                            <span class="skills-item-title">
                                                                <span class="radio">
                                                                    <h6>
                                                                        <label>
                                                                            <input type="radio" id="answer"
                                                                                name="answer<?= $poll_code;?>"
                                                                                value="<?= $array[$i];?>"><span
                                                                                class="circle"
                                                                                style="border: 3px solid #ffffff;"></span><span
                                                                                class="check"></span>
                                                                            <?= $array[$i];?>
                                                                        </label>
                                                                    </h6>
                                                                </span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <?php endfor;?>
                                            </ul>
                                            <a href="javascript:void(0);"
                                                class="btn btn-md-2 btn-vote text-white btn-border-think custom-color c-grey"
                                                onClick="vote('<?= $poll_code;?>')"><?= getPhrase('vote');?>
                                                <div class="ripple-container"></div>
                                            </a>
                                        </div>
                                        <?php
                                                $checkData = $this->crud->getRead($wall['news_id']);
                                                if(count($checkData) > 0):
                                            ?>
                                        <div class="post-additional-info inline-items">
                                            <ul class="friends-harmonic">
                                                <?php foreach($checkData as $readed):?>
                                                <li>
                                                    <a href="javascript:void(0);">
                                                        <img loading="lazy"
                                                            onclick="showAjaxModal('<?= base_url();?>modal/popup/modal_users/<?= $wall['news_id'];?>');"
                                                            title="<?= $this->crud->get_name($readed['user_type'], $readed['user_id']);?>"
                                                            src="<?= $this->crud->get_image_url($readed['user_type'], $readed['user_id']);?>"
                                                            alt="<?= $this->crud->get_name($readed['user_type'], $readed['user_id']);?>"
                                                            width="28" height="28">
                                                    </a>
                                                </li>
                                                <?php endforeach;?>
                                            </ul>
                                            <div class="names-people-likes">
                                                <?php if(count($checkData) > 5):?>
                                                <?= getPhrase('and');?> <?= count($checkData)-5;?>
                                                <?= getPhrase('other_people_viewed_this_post');?> .
                                                <?php else:?>
                                                <?= getPhrase('have_seen_this_post');?>
                                                <?php endif;?>
                                            </div>
                                            <div class="comments-shared">
                                                <a href="javascript:void(0);" class="post-add-icon inline-items"></a>
                                                <a href="javascript:void(0);" class="post-add-icon inline-items"></a>
                                            </div>
                                        </div>
                                        <?php endif;?>
                                    </article>
                                </div>
                                <?php endif;?>
                                <?php if($query->num_rows() > 0):?>
                                <div class="ui-block paddingtel">
                                    <article class="hentry post">
                                        <div class="post__author author vcard inline-items">
                                            <img src="<?= $this->crud->get_image_url('admin', $admin_id);?>">
                                            <div class="author-date">
                                                <a class="h6 post__author-name fn"
                                                    href="javascript:void(0);"><?= $this->crud->get_name('admin', $admin_id);?></a>
                                                <div class="post__date">
                                                    <time class="published"
                                                        style="color: #0084ff;"><?= $this->db->get_where('polls', array('id' => $wall['news_id']))->row()->date." ".$this->db->get_where('polls', array('id' => $wall['news_id']))->row()->date2;?></time>
                                                </div>
                                            </div>
                                            <div class="more">
                                                <i class="icon-options"></i>
                                                <ul class="more-dropdown">
                                                    <li><a
                                                            href="<?= base_url();?>admin/view_poll/<?= $poll_code;?>/"><?= getPhrase('go_to_details');?></a>
                                                    </li>
                                                    <li><a onClick="return confirm('<?= getPhrase('confirm_delete');?>')"
                                                            href="<?= base_url();?>admin/polls/delete/<?= $poll_code;?>"><?= getPhrase('delete');?></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="control-block-button post-control-button">
                                            <a href="javascript:void(0);" class="btn btn-control"
                                                style="background-color:#99bf2d; color:#fff;" data-toggle="tooltip"
                                                data-placement="top" data-original-title="<?= getPhrase('polls');?>">
                                                <i class="picons-thin-icon-thin-0385_graph_pie_chart_statistics"></i>
                                            </a>
                                        </div>
                                        <div>
                                            <div class="wall-content">
                                                <ul class="widget w-pool">
                                                    <li>
                                                        <h4><?= $wall['description'];?></h4>
                                                    </li><br>
                                                    <?php 
                                                            $this->db->where('poll_code', $poll_code);
                                                            $polls = $this->db->count_all_results('poll_response');
                                                            $array = ( explode(',' , $options));
                                                            $questions = count($array)-1;
                                                            $op = 0;
                                                            for($i = 0 ; $i<count($array)-1; $i++):
                                                        ?>
                                                    <?php 
                                                            $this->db->group_by('poll_code');
                                                            $po = $this->db->get_where('poll_response', array('poll_code' => $poll_code))->result_array();
                                                            foreach($po as $p):
                                                        ?>
                                                    <li>
                                                        <div class="skills-item">
                                                            <div class="skills-item-info">
                                                                <span class="skills-item-title">
                                                                    <?php 
                                                                        $this->db->where('answer', $array[$i]);
                                                                        $this->db->where('poll_code', $poll_code);
                                                                        $res = $this->db->count_all_results('poll_response');
                                                                    ?>
                                                                    <h6><label><?= $array[$i];?></label></h6>
                                                                </span>
                                                                <?php 
                                                                    $response = $res/$polls;
                                                                    $response2 = $response*100;
                                                                ?>
                                                                <span class="skills-item-count">
                                                                    <span class="count-animate" data-speed="1000"
                                                                        data-refresh-interval="50" data-to="62"
                                                                        data-from="0"></span>
                                                                    <span
                                                                        class="units"><?= round($response2);?>/100%</span>
                                                                </span>
                                                            </div>
                                                            <div class="skills-item-meter">
                                                                <span
                                                                    class="skills-item-meter-active bg-primary skills-animate"
                                                                    style="width: <?= $response2;?>%; opacity: 1;"></span>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <?php endforeach;?>
                                                    <?php endfor;?>
                                                </ul>
                                            </div>
                                        </div>
                                        <?php
                                            $checkData = $this->crud->getRead($wall['news_id']);
                                            if(count($checkData) > 0):?>
                                        <div class="post-additional-info inline-items">
                                            <ul class="friends-harmonic">
                                                <?php foreach($checkData as $readed):?>
                                                <li>
                                                    <a href="javascript:void(0);">
                                                        <img loading="lazy"
                                                            onclick="showAjaxModal('<?= base_url();?>modal/popup/modal_users/<?= $wall['news_id'];?>');"
                                                            title="<?= $this->crud->get_name($readed['user_type'], $readed['user_id']);?>"
                                                            src="<?= $this->crud->get_image_url($readed['user_type'], $readed['user_id']);?>"
                                                            alt="<?= $this->crud->get_name($readed['user_type'], $readed['user_id']);?>"
                                                            width="28" height="28">
                                                    </a>
                                                </li>
                                                <?php endforeach;?>
                                            </ul>
                                            <div class="names-people-likes">
                                                <?php if(count($checkData) > 5):?>
                                                <?= getPhrase('and');?> <?= count($checkData)-5;?>
                                                <?= getPhrase('other_people_viewed_this_post');?>.
                                                <?php else:?>
                                                <?= getPhrase('have_seen_this_post');?>
                                                <?php endif;?>
                                            </div>
                                            <div class="comments-shared">
                                                <a href="javascript:void(0);" class="post-add-icon inline-items"></a>
                                                <a href="javascript:void(0);" class="post-add-icon inline-items"></a>
                                            </div>
                                        </div>
                                        <?php endif;?>
                                    </article>
                                </div>
                                <?php endif;?>
                                <?php endif;?>
                                <?= form_close();?>
                                <?php endif;?>
                                <?php endforeach;?>
                            </div>
                        </main>
                        <div class="col col-xl-3 order-xl-1 col-lg-6 order-lg-2 col-md-6 col-sm-12 col-12">
                            <div class="eduappgt-sticky-sidebar">
                                <div class="sidebar__inner">
                                    <div class="ui-block paddingtel">
                                        <div class="ui-block-content">
                                            <div class="widget w-about">
                                                <br>
                                                <a href="javascript:void(0);" class="logo"><img
                                                        src="<?= base_url();?>public/uploads/<?= $this->crud->getInfo('logo');?>"
                                                        title="<?= $this->crud->getInfo('system_name');?>"></a>
                                                <ul class="socials">
                                                    <li><a class="socialDash fb"
                                                            href="<?= $this->crud->getInfo('facebook');?>"><i
                                                                class="fab fa-facebook-square"
                                                                aria-hidden="true"></i></a></li>
                                                    <li><a class="socialDash tw"
                                                            href="<?= $this->crud->getInfo('twitter');?>"><i
                                                                class="fab fa-twitter" aria-hidden="true"></i></a></li>
                                                    <li><a class="socialDash yt"
                                                            href="<?= $this->crud->getInfo('youtube');?>"><i
                                                                class="fab fa-youtube" aria-hidden="true"></i></a></li>
                                                    <li><a class="socialDash ig"
                                                            href="<?= $this->crud->getInfo('instagram');?>"><i
                                                                class="fab fa-instagram" aria-hidden="true"></i></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ui-block paddingtel">
                                        <div class="pipeline white lined-success">
                                            <div class="element-wrapper">
                                                <h6 class="element-header"><?= getPhrase('OUR_MISSION');?></h6>
                                            </div>
                                            <div class="content">
                                                <?= getPhrase('school_mission');?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ui-block paddingtel">
                                        <div class="pipeline white lined-success">
                                            <div class="element-wrapper">
                                                <h6 class="element-header"><?= getPhrase('OUR_VISION');?></h6>
                                            </div>
                                            <div class="content">
                                                <?= getPhrase('school_vision');?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ui-block paddingtel">
                                        <div class="pipeline white lined-success">
                                            <div class="element-wrapper">
                                                <h6 class="element-header"><?= getPhrase('OUR_VALUES');?></h6>
                                            </div>
                                            <div class="content">
                                                <?= getPhrase('school_values');?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ui-block paddingtel">
                                        <div class="pipeline white lined-success">
                                            <div class="element-wrapper">
                                                <h6 class="element-header"><?= getPhrase('policies');?></h6>
                                            </div>
                                            <div class="content">
                                                <center>
                                                    <a href="https://americanone-esl.com/document_pdf/catalogue.pdf"
                                                        class="panel-btn" target="_blank">
                                                        <?= getPhrase('catalogue');?>
                                                    </a>
                                                </center>
                                                <br/>
                                                <center>
                                                    <a href="https://americanone-esl.com/document_pdf/admin_handbook.pdf"
                                                        class="panel-btn" target="_blank">
                                                        <?= getPhrase('admin_handbook');?>
                                                    </a>
                                                </center>
                                                <br/>
                                                <center>
                                                    <a href="https://americanone-esl.com/document_pdf/office_handbook.pdf"
                                                        class="panel-btn" target="_blank">
                                                        <?= getPhrase('office_handbook');?>
                                                    </a>
                                                </center>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ui-block paddingtel">
                                        <div class="pipeline white lined-success">
                                            <div class="element-wrapper">
                                                <h6 class="element-header">CEA</h6>
                                            </div>
                                            <div class="content">
                                                <center>
                                                    <a href="https://cea-accredit.org/images/2022_docs_and_handbooks/Section_15_Complaints.pdf"
                                                        class="panel-btn" target="_blank">
                                                        Complaints
                                                    </a>
                                                </center>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ui-block paddingtel">
                                        <div class="ui-block-title">
                                            <h6 class="title"><?= getPhrase('chat groups');?></h6>
                                        </div>
                                        <ul class="widget w-friend-pages-added notification-list friend-requests">
                                            <?php  
                                                $this->db->limit(5);
                                                $group_messages = $this->db->get('group_message_thread')->result_array();
                                                if (sizeof($group_messages) > 0):
                                                foreach ($group_messages as $row):
                                            ?>
                                            <li class="inline-items">
                                                <div class="author-thumb">
                                                    <div class="avatar with-status status-green">
                                                        <div class="circle purple">
                                                            <?= strtoupper($row['group_name'][0]);?></div>
                                                    </div>
                                                </div>
                                                <div class="notification-event">
                                                    <a href="<?= base_url();?>admin/group/group_message_read/<?= $row['group_message_thread_code'];?>/"
                                                        class="h6 notification-friend"><?= $row['group_name'];?></a>
                                                    <span
                                                        class="chat-message-item"><?= count(json_decode($row['members']));?>
                                                        <?= getPhrase('members_on_this_group');?>.</span>
                                                </div>
                                            </li>
                                            <?php endforeach;?>
                                            <?php else:?>
                                            <br>
                                            <center>
                                                <h5><?= getPhrase('create_your_first_group');?></h5>
                                            </center><br>
                                            <center><img src="<?= base_url();?>public/uploads/mensajeseducaby.svg"
                                                    width="250px"></center>
                                            <br>
                                            <?php endif;?>
                                        </ul>
                                    </div>
                                    <div class="ui-block paddingtel">
                                        <div class="pipeline white lined-success">
                                            <div class="element-wrapper">
                                                <h6 class="element-header"><?= getPhrase('online_users');?></h6>
                                                <?php $this->crud->saveUser();?>
                                                <div class="full-ch at-w">
                                                    <div class="chat-content-w min">
                                                        <div class="chat-content min">
                                                            <div class="users-list-w">
                                                                <?php  
                                                                $this->db->group_by('gp');
                                                                $usuarios = $this->db->get('online_users')->result_array();
                                                                foreach($usuarios as $row): ?>
                                                                <div class="user-w with-status min status-green">
                                                                    <div class="user-avatar-w min">
                                                                        <div class="user-avatar">
                                                                            <img alt=""
                                                                                src="<?= $this->crud->get_image_url($row['type'], $row['id_usuario']);?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="user-name">
                                                                        <h6 class="user-title min">
                                                                            <?= $this->crud->get_name($row['type'], $row['id_usuario']);?>
                                                                        </h6>
                                                                        <div class="user-role min">
                                                                            <?php if($row['type'] == 'student'):?>
                                                                            <span
                                                                                class="badge badge-warning"><?= getPhrase('student');?></span>
                                                                            <?php endif;?>
                                                                            <?php if($row['type'] == 'accountant'):?>
                                                                            <span
                                                                                class="badge badge-info"><?= getPhrase('accountant');?></span>
                                                                            <?php endif;?>
                                                                            <?php if($row['type'] == 'librarian'):?>
                                                                            <span
                                                                                class="badge badge-info"><?= getPhrase('librarian');?></span>
                                                                            <?php endif;?>
                                                                            <?php if($row['type'] == 'parent'):?>
                                                                            <span
                                                                                class="badge badge-purple"><?= getPhrase('parent');?></span>
                                                                            <?php endif;?>
                                                                            <?php if($row['type'] == 'admin'):?>
                                                                            <span
                                                                                class="badge badge-primary"><?= getPhrase('admin');?></span>
                                                                            <?php endif;?>
                                                                            <?php if($row['type'] == 'teacher'):?>
                                                                            <span
                                                                                class="badge badge-success"><?= getPhrase('teacher');?></span>
                                                                            <?php endif;?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php endforeach;?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ui-block paddingtel">
                                        <div class="ui-block-title">
                                            <h6 class="title"><?= getPhrase('accounting');?></h6>
                                        </div>
                                        <div class="ui-block-content">
                                            <canvas id="myChart" width="400" height="400"></canvas>
                                        </div>
                                    </div>
                                    <div class="header-spacer"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col col-xl-3 order-xl-3 col-lg-6 order-lg-3 col-md-6 col-sm-12 col-12">
                            <div class="eduappgt-sticky-sidebar">
                                <div class="sidebar__inner">
                                    <div class="ui-block paddingtel">
                                        <div class="today-events calendar ">
                                            <div class="today-events-thumb">
                                                <div class="date">
                                                    <div class="day-number"><?= date('d');?></div>
                                                    <div class="day-week"><?= getPhrase(date('l'));?></div>
                                                    <div class="month-year" style="color:#FFF">
                                                        <?= getPhrase(date('F'));?>, <?= date('Y');?>.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="list">
                                                <?php if(has_permission('calendar_add')):?>
                                                <div class="control-block-button">
                                                    <a href="<?= base_url();?>admin/calendar/"
                                                        class="btn btn-control bg-breez"
                                                        style="background-color: #22b9ff;">
                                                        <i class="fa fa-plus text-white"></i>
                                                    </a>
                                                </div>
                                                <?php endif;?>
                                                <?php $date = date('Y-m-d');
                                                $events = $this->db->get_where('events', array('start >=' => $date.' '.'00:00:00', 'start <=' => $date.' '.'23:59:59')); ?>
                                                <div id="accordion-1" role="tablist" aria-multiselectable="true"
                                                    class="day-event" data-month="12" data-day="2">
                                                    <?php  if($events->num_rows() > 0):?>
                                                    <?php foreach($events->result_array() as $event): ?>
                                                    <div class="card">
                                                        <div class="card-header" role="tab" id="headingOne-1">
                                                            <div class="event-time">
                                                                <h5 class="mb-0 title"><a
                                                                        href="<?= base_url();?>admin/calendar/"><?= $event['title'];?></a>
                                                                </h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php endforeach;?>
                                                    <?php else:?>
                                                    <center>
                                                        <div style="padding-bottom : 75px;padding-top :75px;">
                                                            <p><?= getPhrase('no_today_events');?></p><img
                                                                src="<?= base_url();?>public/uploads/calendar.png"
                                                                width="20%" />
                                                        </div>
                                                    </center>
                                                    <?php endif;?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ui-block paddingtel">
                                        <div class="ui-block-title">
                                            <h6 class="title"><?= getPhrase('birthdays');?></h6>
                                        </div>
                                        <br><br>
                                        <center>
                                            <img src="<?= base_url();?>public/uploads/icons/cake.svg"
                                                width="85px"><br><br>
                                            <h4>
                                                <?= getPhrase('birthdays');?>
                                            </h4>
                                            <p>
                                                <?= $this->crud->get_birthdays();?>
                                                <?= getPhrase('users_have_a_birthday_this_month');?>.
                                            </p>
                                            <a href="<?= base_url();?>admin/birthdays/"
                                                class="panel-btn"><?= getPhrase('view_all_birthdays');?></a>
                                        </center>
                                        <div class="header-spacer"></div>
                                    </div><br>
                                    <div class="ui-block paddingtel">
                                        <div class="ui-block-title">
                                            <h6 class="title"><?= getPhrase('absent_students');?></h6>
                                        </div>
                                        <?php
                                            $check  = array('timestamp' => strtotime(date('Y-m-d')) , 'status' => '2');
                                            $query = $this->db->get_where('attendance' , $check);
                                            $absent_today   = $query->result_array();
                                        ?>
                                        <?php if($query->num_rows() > 0):?>
                                        <ul class="widget w-friend-pages-added notification-list friend-requests">
                                            <?php foreach($absent_today as $attendance):?>
                                            <li class="inline-items">
                                                <div class="author-thumb">
                                                    <img src="<?= $this->crud->get_image_url('student', $attendance['student_id']);?>"
                                                        alt="author" width="35px">
                                                </div>
                                                <div class="notification-event">
                                                    <a href="<?= base_url();?>admin/student_portal/<?= $attendance['student_id'];?>/"
                                                        class="h6 notification-friend"><?= $this->crud->get_name('student', $attendance['student_id']);?></a>
                                                    <span
                                                        class="chat-message-item"><?= $this->db->get_where('class', array('class_id' => $attendance['class_id']))->row()->name;?></span>
                                                </div>
                                            </li>
                                            <?php endforeach;?>
                                        </ul>
                                        <?php else:?>
                                        <center>
                                            <div style="padding-bottom : 75px;padding-top :75px;">
                                                <p><?= getPhrase('no_absent_students');?></p><img
                                                    src="<?= base_url();?>public/uploads/plan.png" width="20%">
                                            </div>
                                        </center>
                                        <?php endif;?>
                                        <div class="header-spacer"></div>
                                    </div><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="back-to-top" href="javascript:void(0);">
                    <img src="<?= base_url();?>public/style/olapp/svg-icons/back-to-top.svg" alt="arrow"
                        class="back-icon">
                </a>
            </div>
        </div>
    </div>
    <script>
function textAreaAdjust(o) {
    o.style.height = "1px";
    o.style.height = (25 + o.scrollHeight) + "px";
}
    </script>
    <script src="<?= base_url();?>public/style/js/Chart.bundle.js"></script>
    <script type="text/javascript">
var blank_student_entry = '';
$(document).ready(function() {
    blank_student_entry = $('#student_entry').html();
    for ($i = 1; $i < 1; $i++) {
        $("#student_entry").append(blank_student_entry);
    }
});

function append_student_entry() {
    $("#student_entry_append").append(blank_student_entry);
}

function deleteParentElement(n) {
    n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
}

function post() {
    $("#new_post").show(500);
    $("#new_poll").hide(500);
    $("#new_video").hide(500);
}

function poll() {
    $("#new_post").hide(500);
    $("#new_video").hide(500);
    $("#new_poll").show(500);
}

function video() {
    $("#new_post").hide(500);
    $("#new_poll").hide(500);
    $("#new_video").show(500);
}

var ctx = document.getElementById('myChart');
var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ['<?= getPhrase('expense');?>', '<?= getPhrase('income');?>'],
        datasets: [{
            label: '#<?= getPhrase('accounting');?>',
            data: [<?= $this->crud->get_expense(date('M'));?>,
                <?= $this->crud->get_payments(date('M'));?>
            ],
            backgroundColor: [
                'rgba(255, 99, 132, 0.7)',
                'rgba(153, 191, 45, 0.7)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(153, 191, 45, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: !0,
                    userCallback: function(value, index, values) {
                        value = value.toString();
                        value = value.split(/(?=(?:...)*$)/);
                        value = value.join('.');
                        return '$' + value;
                    }
                }
            }]
        },
        tooltips: {
            mode: 'label',
            label: 'mylabel',
            callbacks: {
                label: function(tooltipItem, data) {
                    var value = Number(data.datasets[0].data[tooltipItem.index]).toFixed(2);
                    return '$' + number_format(value);
                },
            },
        }
    }
});

function number_format(number, decimals, dec_point, thousands_point) {
    if (number == null || !isFinite(number)) {
        throw new TypeError("number is not valid");
    }
    if (!decimals) {
        var len = number.toString().split('.').length;
        decimals = len > 1 ? len : 0;
    }
    if (!dec_point) {
        dec_point = '.';
    }
    if (!thousands_point) {
        thousands_point = ',';
    }
    number = parseFloat(number).toFixed(decimals);
    number = number.replace(".", dec_point);
    var splitNum = number.split(dec_point);
    splitNum[0] = splitNum[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_point);
    number = splitNum.join(dec_point);
    return number;
}

var post_message = '<?= getPhrase('thank_you_polls');?>';

function vote(poll_code) {
    answer = $('input[name=answer' + poll_code + ']:checked').val();
    if (answer != "" && poll_code != "") {
        $.ajax({
            url: "<?= base_url();?>admin/polls/response/",
            type: 'POST',
            data: {
                answer: answer,
                poll_code: poll_code
            },
            success: function(result) {
                $('#panel').load(document.URL + ' #panel');
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 8000
                });
                Toast.fire({
                    icon: 'success',
                    title: post_message
                })
            }
        });
    } else {
        alert('<?= getPhrase('select_an_option');?>');
    }
}

function getId(url) {
    var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
    var match = url.match(regExp);
    if (match && match[2].length == 11) {
        return match[2];
    } else {
        return 'error';
    }
}

function set_video() {
    var Id = getId($("#url").val());
    $('#myCode').html('<br><iframe width="560" height="315" src="//www.youtube.com/embed/' + Id +
        '" frameborder="0" allowfullscreen></iframe>');
    $("#embed").val('//www.youtube.com/embed/' + Id)
    $("#myCode").show(500);
}

//File Preview
if (window.FileReader) {
    var reader = new FileReader(),
        rFilter =
        /^(image\/bmp|image\/cis-cod|image\/gif|image\/ief|image\/jpeg|image\/jpeg|image\/jpeg|image\/pipeg|image\/png|image\/svg\+xml|image\/tiff|image\/x-cmu-raster|image\/x-cmx|image\/x-icon|image\/x-portable-anymap|image\/x-portable-bitmap|image\/x-portable-graymap|image\/x-portable-pixmap|image\/x-rgb|image\/x-xbitmap|image\/x-xpixmap|image\/x-xwindowdump)$/i;
    reader.onload = function(oFREvent) {
        $("#logoPreview").show();
        lgpreview = document.getElementById("logoPreview")
        lgpreview.src = oFREvent.target.result;
    };

    function imagePreview() {
        if (document.getElementById("userfile").files.length === 0) {
            return;
        }
        var file = document.getElementById("userfile").files[0];
        if (!rFilter.test(file.type)) {
            alert("You must select a valid image file!");
            return;
        }
        reader.readAsDataURL(file);
    }
} else {
    alert("Try using Chrome, Firefox or WebKit");
}
    </script>