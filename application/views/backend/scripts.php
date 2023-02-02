<?php if($page_name == 'calendar'):?>
        <script src='<?php echo base_url();?>public/style/fullcalendar/lib/main.js'></script>
    <?php endif;?>
    <script src="<?php echo base_url();?>public/style/js/picker.js"></script>
    <script src="<?php echo base_url();?>public/style/js/picker.en.js"></script>
    <script src="<?php echo base_url();?>public/style/cms/bower_components/bootstrap-clockpicker/bootstrap-clockpicker.min.js"></script>
    <?php if ($this->session->flashdata('flash_message') != ""):?>
        <script>
            "use strict";
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 3000
            }); 
            Toast.fire({
                icon: 'success',
                title: '<?php echo $this->session->flashdata("flash_message");?>'
            })
        </script>
    <?php endif;?>

    <?php if ($this->session->flashdata('flash_error_message') != ""):?>
        <script>
            "use strict";
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 3000
            }); 
            Toast.fire({
                icon: 'error',
                title: '<?php echo $this->session->flashdata("flash_error_message");?>'
            })
        </script>
    <?php endif;?>

    <script src="<?php echo base_url();?>public/style/cms/bower_components/popper.js/dist/umd/popper.min.js"></script>
    <script src="<?php echo base_url();?>public/style/cms/bower_components/moment/moment.js"></script>
    <script src="<?php echo base_url();?>public/style/cms/bower_components/tether/dist/js/tether.min.js"></script>
    <script src="<?php echo base_url();?>public/style/cms/bower_components/ckeditor/ckeditor.js"></script>
    <script src="<?php echo base_url();?>public/style/cms/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url();?>public/style/cms/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>public/style/cms/bower_components/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js"></script>
    <script src="<?php echo base_url();?>public/style/cms/bower_components/bootstrap/js/dist/util.js"></script>
    <script src="<?php echo base_url();?>public/style/cms/bower_components/bootstrap/js/dist/tab.js"></script>
    <script src="<?php echo base_url();?>public/style/cms/js/main.js"></script>
    <script src="<?php echo base_url();?>public/style/cms/bower_components/bootstrap/js/dist/modal.js"></script>
    <script src="<?php echo base_url();?>public/style/cms/bower_components/bootstrap/js/dist/tooltip.js"></script>
    <script src="<?php echo base_url();?>public/style/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>public/style/cms/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url();?>public/style/tinymce/tinymce.min.js"></script>
    <script src="<?php echo base_url();?>public/style/cms/bower_components/bootstrap/js/dist/button.js"></script>
    <script src="<?php echo base_url();?>public/style/cms/bower_components/bootstrap/js/dist/collapse.js"></script>
    <script src="<?php echo base_url();?>public/style/cms/bower_components/bootstrap/js/dist/dropdown.js"></script>
    <script src="<?php echo base_url();?>public/style/olapp/js/jquery.appear.js"></script>
    <script src="<?php echo base_url();?>public/style/olapp/js/jquery.matchHeight.js"></script>
    <script src="<?php echo base_url();?>public/style/olapp/js/svgxuse.js"></script>
    <script src="<?php echo base_url();?>public/style/olapp/js/Headroom.js"></script>
    <script src="<?php echo base_url();?>public/style/olapp/js/velocity.js"></script>
    <script src="<?php echo base_url();?>public/style/olapp/js/ScrollMagic.js"></script>
    <script src="<?php echo base_url();?>public/style/olapp/js/jquery.waypoints.js"></script>
    <script src="<?php echo base_url();?>public/style/olapp/js/material.min.js"></script>
    <script src="<?php echo base_url();?>public/style/olapp/js/bootstrap-select.js"></script>
    <script src="<?php echo base_url();?>public/style/olapp/js/smooth-scroll.js"></script>
    <script src="<?php echo base_url();?>public/style/olapp/js/moment.js"></script>
    <script src="<?php echo base_url();?>public/style/olapp/js/loader.js"></script>
    <script src="<?php echo base_url();?>public/style/olapp/js/jquery.magnific-popup.js"></script>
    <script src="<?php echo base_url();?>public/style/olapp/js/sticky-sidebar.js"></script>
    <script src="<?php echo base_url();?>public/style/olapp/js/base-init.js"></script>
    <script defer src="<?php echo base_url();?>public/style/olapp/fonts/fontawesome-all.js"></script>
    <script src="<?php echo base_url();?>public/style/olapp/Bootstrap/dist/js/bootstrap.bundle.js"></script>
    <script src="<?php echo base_url();?>public/style/js/scripts_dhcoder.js"></script>