                    <ul class="navs navs-tabs upper">
                        <?php if(has_permission('academic_dashboard_report')):?>
                        <li class="navs-item">
                            <a class="navs-links <?= $page_name == 'advisor_dashboard' ? 'active' : ''?>"
                                href="<?php echo base_url();?>reports/advisor_dashboard/">
                                <i class="os-icon picons-thin-icon-thin-0482_gauge_dashboard_empty"></i>
                                <span><?php echo getPhrase('home');?></span>
                            </a>
                        </li>
                        <?php endif;?>
                    </ul>