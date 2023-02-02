                <ul class="navs navs-tabs upper">
                    <li class="navs-item">
                        <a class="navs-links <?= $page_name == 'upload_agreements' ? 'active': '' ;?>"
                            href="<?php echo base_url()?>UploadBulk/upload_agreements/">
                            <i class="os-icon picons-thin-icon-thin-0394_business_handshake_deal_contract_sign"></i>
                            <span><?php echo getPhrase('agreement');?></span>
                        </a>
                    </li>
                </ul>