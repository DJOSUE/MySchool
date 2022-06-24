<div class="os-tabs-controls">
    <ul class="navs navs-tabs upper">
        <?php if(has_permission('academic_settings')):?>
        <li class="navs-item">
            <a class="navs-links <?= $page_name == 'academic_settings' ? 'active': '' ;?>"
                href="<?php echo base_url();?>admin/academic_settings/"><i
                    class="os-icon picons-thin-icon-thin-0006_book_writing_reading_read_manual"></i><span><?php echo getPhrase('academic_settings'); ?></span></a>
        </li>
        <?php endif;?>
        <?php if(has_permission('academic_settings_grades')):?>
        <li class="navs-item">
            <a class="navs-links <?= $page_name == 'grade' ? 'active': '' ;?>"
                href="<?php echo base_url();?>admin/grade/"><i
                    class="os-icon picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i><span><?php echo getPhrase('grades'); ?></span></a>
        </li>
        <?php endif;?>
        <?php if(has_permission('academic_settings_gpa')):?>
        <li class="navs-item">
            <a class="navs-links <?= $page_name == 'gpa' ? 'active': '' ;?>"
                href="<?php echo base_url();?>admin/gpa/"><i
                    class="os-icon picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i><span><?php echo getPhrase('gpa_level'); ?></span></a>
        </li>
        <?php endif;?>
        <?php if(has_permission('academic_settings_semesters')):?>
        <li class="navs-item">
            <a class="navs-links <?= $page_name == 'semesters' ? 'active': '' ;?>"
                href="<?php echo base_url();?>admin/semesters/"><i
                    class="os-icon picons-thin-icon-thin-0007_book_reading_read_bookmark"></i><span><?php echo getPhrase('semesters'); ?></span></a>
        </li>
        <?php endif;?>
        <?php if(has_permission('academic_settings_units')):?>
        <li class="navs-item">
            <a class="navs-links <?= $page_name == 'units' ? 'active': '' ;?>"
                href="<?php echo base_url();?>admin/units/"><i
                    class="os-icon picons-thin-icon-thin-0007_book_reading_read_bookmark"></i><span><?php echo getPhrase('units'); ?></span></a>
        </li>
        <?php endif;?>
        <?php if(has_permission('academic_settings_sections')):?>
        <li class="navs-item">
            <a class="navs-links <?= $page_name == 'sections' ? 'active': '' ;?>"
                href="<?php echo base_url();?>admin/sections/"><i
                    class="os-icon picons-thin-icon-thin-0002_write_pencil_new_edit"></i><span><?php echo getPhrase('sections'); ?></span></a>
        </li>
        <?php endif;?>
        <?php if(has_permission('academic_settings_subject')):?>
        <li class="navs-item <?= $page_name == 'subjects' ? 'active': '' ;?>">
            <a class="navs-links" href="<?php echo base_url();?>admin/subjects/"><i
                    class="os-icon picons-thin-icon-thin-0002_write_pencil_new_edit"></i><span><?php echo getPhrase('subject'); ?></span></a>
        </li>
        <?php endif;?>
        <!-- <li class="navs-item">
                            <a class="navs-links" href="<?php echo base_url();?>admin/student_promotion/"><i
                                    class="os-icon picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i><span><?php echo getPhrase('student_promotion'); ?></span></a>
                        </li> -->
    </ul>
</div>