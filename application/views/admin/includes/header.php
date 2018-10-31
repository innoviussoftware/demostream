<?php
if (sizeof($this->session->userdata['login_userdata']) == 0) {
    redirect(base_url() . "Hauth/users");
}
?>

<html lang="en">

    <head>
        <?php error_reporting(0); ?>
        <title>Demo Stream</title>
        <!-- for-mobile-apps -->

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="Demo Stream" />


        <link rel="icon" href="<?php echo base_url() . 'assets/images/dslogo1.png'; ?>">
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
            function hideURLbar(){ window.scrollTo(0,1); } </script>
        <!-- //for-mobile-apps -->
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
        <!-- <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" type="text/css" media="all" /> -->
        <link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet" type="text/css" media="all">
        <!--web-fonts-->
        <link href="//fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
        <link href="//fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">



        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
            function hideURLbar(){ window.scrollTo(0,1); } </script>


        <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/bower_components/bootstrap/dist/css/bootstrap.min.css"> -->
        <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/bower_components/font-awesome/css/font-awesome.min.css"> -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/bower_components/Ionicons/css/ionicons.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/skins/_all-skins.min.css">
        <link href="<?php echo base_url(); ?>assets/admin/css/admin_style.css" rel="stylesheet" type="text/css" media="all" />
        <link href="<?php echo base_url(); ?>assets/admin/css/AdminLTE.css" rel="stylesheet" type="text/css" media="all" />
        <link href="<?php echo base_url(); ?>assets/admin/css/AdminLTE.min.css" rel="stylesheet" type="text/css" media="all" />
        <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/img-upload.css"> -->
        <link href="//fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
        <link href="//fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/bower_components/bootstrap-daterangepicker/daterangepicker.css">

        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> 


        <!--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>-->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js" ></script>

        <script src="https://cdn.datatables.net/buttons/1.5.0/js/dataTables.buttons.min.js"></script>
        <script src="http://cdn.datatables.net/buttons/1.5.0/js/buttons.colVis.min.js"></script>
        <script src="http://cdn.datatables.net/buttons/1.5.0/js/buttons.flash.min.js"></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
        <script src="http://cdn.datatables.net/buttons/1.5.0/js/buttons.html5.min.js"></script>
        <script src="http://cdn.datatables.net/buttons/1.5.0/js/buttons.print.min.js"></script>

        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.0/css/buttons.jqueryui.min.css">

        <script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.jqueryui.min.js"></script>

        <script src="<?php echo base_url(); ?>assets/admin/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
        <!-- datepicker -->
        <script src="<?php echo base_url(); ?>assets/admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

        <script src="<?php echo base_url(); ?>assets/admin/js/validator.min.js"></script>



        <!-- date-range-picker -->
        <script src="<?php echo base_url(); ?>assets/admin/bower_components/moment/min/moment.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
        <!-- Bootstrap 3.3.7 -->
                <!-- <script src="<?php echo base_url(); ?>assets/admin/bower_components/bootstrap/dist/js/bootstrap.min.js"></script> -->
                 <!-- <script src="<?php echo base_url(); ?>assets/admin/bower_components/datatables.net/js/jquery.dataTables.min.js"></script> -->
                <!-- <script src="<?php echo base_url(); ?>assets/admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script> -->

        <!-- bootbox code -->
        <script src="<?php echo base_url(); ?>assets/admin/js/bootbox.min.js"></script>

 <!-- <script src="<?php echo base_url(); ?>assets/js/img-upload.js"></script> -->



    </head>
    <body class="hold-transition skin-blue sidebar-mini">

        <div class="wrapper">
