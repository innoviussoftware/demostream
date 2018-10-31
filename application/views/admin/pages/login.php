<?php
if (!empty($this->session->userdata['login_userdata'])) {
    redirect(base_url() . "admin");
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
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/bower_components/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/bower_components/Ionicons/css/ionicons.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/skins/_all-skins.min.css">
        <link href="<?php echo base_url(); ?>assets/admin/css/admin_style.css" rel="stylesheet" type="text/css" media="all" />
        <link href="<?php echo base_url(); ?>assets/admin/css/AdminLTE.css" rel="stylesheet" type="text/css" media="all" />
        <link href="<?php echo base_url(); ?>assets/admin/css/AdminLTE.min.css" rel="stylesheet" type="text/css" media="all" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/img-upload.css">
        <link href="//fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
        <link href="//fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/bower_components/bootstrap-daterangepicker/daterangepicker.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/img-upload.js"></script>

        <script src="<?php echo base_url(); ?>assets/admin/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- datepicker -->
    <script src="<?php echo base_url(); ?>assets/admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/admin/js/validator.min.js"></script>

</head>
        <body class="hold-transition skin-blue sidebar-mini">

            <div class="wrapper">


<body class="hold-transition login-page">

    <div class="login-box">
        <div class="login-logo">
          
            
            <ul class="nav navbar-nav navbar-left" style="width:100%;height:100px;">
                <li style="background: transparent;">
                    <h1>
                        <a href="#">
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                 width="800px" height="200px" viewBox="2000 250 200 1200" style="enable-background:new 0 0 1500 900;" xml:space="preserve">
                                <style type="text/css">
                                    #Layer_1 .st0{fill:#FFFFFF;}
                                    #Layer_1 .st1{fill:#39C2D7;}
                                    #Layer_1 .st2{fill:#258D9D;}
                                </style>
                                <g>
                                    <path id="demostream-copy-8" class="st0" d="M703.9,494.4H679c-0.6,43.6,81.5,42.9,81.5,1.3c0-24.8-19.6-27.7-39.6-29.9
                                          c-9.1-1-16.6-2.5-16-10c0.9-11.7,27.9-12.9,27.9,0.3h24.5c0.6-42.7-77.7-42.7-76.9,0c0.3,21.5,14.7,28.9,36.6,30.4
                                          c10.1,0.6,18.4,2.1,18.4,9.1C735.4,507.2,703.9,507,703.9,494.4z M794.2,448.3v76.4h25.5v-76.4h24.6v-22.6h-74.9v22.6L794.2,448.3
                                          L794.2,448.3z M925.6,489.6l19.7,31.4v3.7h-28.8l-17.3-29.2h-13.4v29.2H860v-99.1h44.2C943.9,425.8,951.1,472.6,925.6,489.6z
                                          M904.3,473.1c14,0,14.7-24.6,0-24.8c-6-0.1-12.4,0-18.4,0v24.8H904.3z M1023.8,425.7h-62.9v99.1h64.2v-22.5h-38.6v-17.4h34.3
                                          v-22.5h-34.3v-14h37.3V425.7z M1111.4,524.7l-5.9-12.5h-39.7l-5.9,12.5h-25.2V521l45.4-96.7h11.1l45.5,96.7v3.7H1111.4z
                                          M1097.1,490.6l-11.7-26l-11.4,26H1097.1z M1198.6,468.4l-39.4-43h-9.5v99.4h26.3v-44.2l21.3,22.1h2.9l21.5-22.1v44.2h26.3v-99.4
                                          h-9.2L1198.6,468.4z"/>
                                    <path class="st1" d="M289.9,425.7H252v100h37.9C355.4,525.4,355.4,425.9,289.9,425.7z M290.1,502H278v-53h12.1
                                          C322,449,322,502,290.1,502z"/>
                                    <g>
                                        <polygon class="st1" points="384.5,485.4 418.7,485.4 418.7,462.7 384.5,462.7 384.5,448.5 421.7,448.5 421.7,425.7 359,425.7 
                                                 359,525.7 423,525.7 423,502.9 384.5,502.9 		"/>
                                        <polygon class="st1" points="493.8,469 454.5,425.7 445,425.7 445,525.7 471.3,525.7 471.3,481.2 492.5,503.4 495.4,503.4 
                                                 516.7,481.2 516.7,525.7 543,525.7 543,425.7 533.8,425.7 		"/>
                                        <path class="st1" d="M564,475.6c0,68.7,104,68.7,104,0C668,407,564,407,564,475.6z"/>
                                    </g>
                                    <path id="Path-Copy-41" class="st0" d="M603.8,501c-1,0-2-0.3-2.9-0.8c-1.8-1-2.9-2.9-2.9-5v-39.4c0-2.1,1.1-4,2.9-5
                                          c1.8-1,4-1,5.8,0l34.4,19.7c1.8,1,2.9,2.9,2.9,5s-1.1,4-2.9,5l-34.4,19.7C605.8,500.8,604.8,501,603.8,501L603.8,501z"/>
                                    <path class="st2" d="M644.1,474.5l-0.2-0.1c0.1,0.4,0.1,0.7,0.1,1.1c0,2.1-1.1,4-2.9,5l-34.4,19.7c-0.9,0.5-1.9,0.8-2.9,0.8
                                          c-0.9,0-1.8-0.2-2.7-0.7c0.3,1.6,1.3,3,2.8,3.9c0.9,0.5,1.9,0.8,2.9,0.8s2-0.3,2.9-0.8l34.4-19.7c1.8-1,2.9-2.9,2.9-5
                                          C647,477.4,645.9,475.6,644.1,474.5z"/>
                                    <path id="Powered-By-Copy-7" class="st0" d="M252,374.4h7.6c1.1,0,2.1,0.1,3.2,0.3c1,0.2,1.9,0.6,2.7,1.1s1.4,1.2,1.8,2
                                          c0.5,0.8,0.7,1.9,0.7,3.2c0,1.4-0.2,2.6-0.7,3.5s-1.2,1.6-2,2s-1.8,0.8-2.9,1s-2.2,0.3-3.4,0.3h-3v9.4h-4V374.4z M258.5,384.2
                                          c0.6,0,1.2,0,1.8-0.1c0.6,0,1.2-0.2,1.7-0.4c0.5-0.2,0.9-0.5,1.3-1s0.5-1,0.5-1.8c0-0.7-0.1-1.3-0.4-1.7c-0.3-0.4-0.7-0.7-1.2-1
                                          s-1-0.4-1.6-0.4c-0.6-0.1-1.1-0.1-1.7-0.1H256v6.4h2.5V384.2z M270.4,389.4c0-1.2,0.2-2.3,0.7-3.3s1-1.8,1.8-2.5
                                          c0.7-0.7,1.6-1.2,2.7-1.6c1-0.4,2.1-0.6,3.3-0.6s2.2,0.2,3.3,0.6c1,0.4,1.9,0.9,2.7,1.6c0.7,0.7,1.3,1.6,1.8,2.5
                                          c0.4,1,0.7,2.1,0.7,3.3s-0.2,2.3-0.7,3.3c-0.4,1-1,1.8-1.8,2.5s-1.6,1.2-2.7,1.6c-1,0.4-2.1,0.6-3.3,0.6s-2.2-0.2-3.3-0.6
                                          c-1-0.4-1.9-0.9-2.7-1.6s-1.3-1.6-1.8-2.5S270.4,390.6,270.4,389.4z M274.3,389.4c0,0.6,0.1,1.2,0.3,1.7c0.2,0.6,0.5,1,0.9,1.5
                                          s0.9,0.8,1.4,1c0.6,0.3,1.2,0.4,1.9,0.4c0.7,0,1.3-0.1,1.9-0.4s1-0.6,1.4-1s0.7-0.9,0.9-1.5c0.2-0.6,0.3-1.1,0.3-1.7
                                          s-0.1-1.2-0.3-1.7c-0.2-0.6-0.5-1-0.9-1.5c-0.4-0.4-0.9-0.8-1.4-1c-0.6-0.3-1.2-0.4-1.9-0.4c-0.7,0-1.3,0.1-1.9,0.4s-1,0.6-1.4,1
                                          s-0.7,0.9-0.9,1.5C274.4,388.2,274.3,388.8,274.3,389.4z M288.6,381.7h4.2l3.3,10.8h0.1l3.1-10.8h4.2l3.3,10.8h0.1l3.2-10.8h3.9
                                          l-5.2,15.4H305l-3.6-10.5h-0.1L298,397h-4L288.6,381.7z M319.3,390.7c0.1,1.2,0.6,2,1.3,2.7c0.8,0.6,1.7,1,2.8,1
                                          c1,0,1.8-0.2,2.4-0.6c0.7-0.4,1.2-0.9,1.7-1.5l2.8,2.1c-0.9,1.1-1.9,1.9-3,2.4s-2.3,0.7-3.5,0.7s-2.2-0.2-3.3-0.6
                                          c-1-0.4-1.9-0.9-2.7-1.6s-1.3-1.6-1.8-2.5s-0.7-2.1-0.7-3.3s0.2-2.3,0.7-3.3s1-1.8,1.8-2.5c0.7-0.7,1.6-1.2,2.7-1.6
                                          c1-0.4,2.1-0.6,3.3-0.6c1.1,0,2,0.2,2.9,0.6s1.6,0.9,2.3,1.6s1.1,1.6,1.5,2.6s0.5,2.2,0.5,3.6v1.1h-11.7V390.7z M327.1,387.8
                                          c0-1.1-0.4-2-1.1-2.7s-1.6-1-2.8-1c-1.2,0-2.1,0.3-2.7,1c-0.7,0.7-1.1,1.5-1.2,2.7H327.1z M334.6,381.7h3.8v2.4h0.1
                                          c0.4-0.9,1-1.6,1.8-2.1s1.7-0.7,2.7-0.7c0.2,0,0.5,0,0.7,0.1s0.5,0.1,0.7,0.2v3.7c-0.3-0.1-0.6-0.2-0.9-0.2
                                          c-0.3-0.1-0.6-0.1-0.9-0.1c-0.9,0-1.6,0.2-2.2,0.5c-0.5,0.3-1,0.7-1.2,1.1c-0.3,0.4-0.5,0.9-0.6,1.3s-0.1,0.7-0.1,1v8.2h-3.8v-15.4
                                          H334.6z M349.5,390.7c0.1,1.2,0.6,2,1.3,2.7c0.8,0.6,1.7,1,2.8,1c1,0,1.8-0.2,2.4-0.6c0.7-0.4,1.2-0.9,1.7-1.5l2.8,2.1
                                          c-0.9,1.1-1.9,1.9-3,2.4s-2.3,0.7-3.5,0.7s-2.2-0.2-3.3-0.6s-1.9-0.9-2.7-1.6s-1.3-1.6-1.8-2.5c-0.4-1-0.7-2.1-0.7-3.3
                                          s0.2-2.3,0.7-3.3c0.4-1,1-1.8,1.8-2.5c0.7-0.7,1.6-1.2,2.7-1.6s2.1-0.6,3.3-0.6c1.1,0,2,0.2,2.9,0.6s1.6,0.9,2.3,1.6
                                          s1.1,1.6,1.5,2.6s0.5,2.2,0.5,3.6v1.1h-11.7V390.7z M357.4,387.8c0-1.1-0.4-2-1.1-2.7s-1.6-1-2.8-1c-1.2,0-2.1,0.3-2.7,1
                                          c-0.7,0.7-1.1,1.5-1.2,2.7H357.4z M377,394.7L377,394.7c-0.6,0.9-1.4,1.6-2.3,2s-2,0.6-3,0.6c-1.2,0-2.3-0.2-3.2-0.6
                                          c-0.9-0.4-1.7-1-2.4-1.7c-0.7-0.7-1.2-1.6-1.5-2.6s-0.5-2-0.5-3.2s0.2-2.2,0.5-3.2c0.4-1,0.9-1.8,1.5-2.6c0.7-0.7,1.4-1.3,2.4-1.7
                                          c0.9-0.4,1.9-0.6,3-0.6c0.7,0,1.4,0.1,1.9,0.2c0.6,0.1,1,0.3,1.5,0.6s0.8,0.5,1.1,0.8c0.3,0.3,0.5,0.5,0.7,0.8h0.1v-10.8h3.8V397
                                          H377V394.7z M367.9,389.4c0,0.6,0.1,1.2,0.3,1.7c0.2,0.6,0.5,1,0.9,1.5c0.4,0.4,0.9,0.8,1.4,1c0.6,0.3,1.2,0.4,1.9,0.4
                                          c0.7,0,1.3-0.1,1.9-0.4s1-0.6,1.4-1s0.7-0.9,0.9-1.5c0.2-0.6,0.3-1.1,0.3-1.7s-0.1-1.2-0.3-1.7c-0.2-0.6-0.5-1-0.9-1.5
                                          c-0.4-0.4-0.9-0.8-1.4-1c-0.6-0.3-1.2-0.4-1.9-0.4c-0.7,0-1.3,0.1-1.9,0.4s-1,0.6-1.4,1s-0.7,0.9-0.9,1.5
                                          C368,388.2,367.9,388.8,367.9,389.4z M394.8,374.4h8.8c0.9,0,1.7,0.1,2.5,0.3s1.6,0.5,2.2,1c0.7,0.5,1.2,1.1,1.6,1.8
                                          c0.4,0.7,0.6,1.6,0.6,2.6c0,1.3-0.4,2.3-1.1,3.2s-1.7,1.4-2.8,1.8v0.1c0.7,0.1,1.4,0.3,2,0.6s1.1,0.7,1.6,1.2s0.8,1,1,1.7
                                          s0.4,1.3,0.4,2c0,1.2-0.2,2.3-0.7,3.1c-0.5,0.8-1.1,1.5-1.9,2s-1.7,0.9-2.8,1.1c-1,0.2-2.1,0.3-3.2,0.3h-8.2V374.4z M398.8,383.6
                                          h3.7c1.3,0,2.4-0.3,3-0.8s1-1.2,1-2.1c0-1-0.3-1.7-1-2.2s-1.8-0.7-3.3-0.7h-3.3v5.8H398.8z M398.8,393.6h3.7c0.5,0,1.1,0,1.6-0.1
                                          s1.1-0.2,1.6-0.4s0.9-0.6,1.2-1c0.3-0.4,0.5-1,0.5-1.8c0-1.2-0.4-2-1.2-2.5c-0.8-0.5-2-0.7-3.6-0.7h-3.9L398.8,393.6L398.8,393.6z
                                          M413.1,381.7h4.2l4.3,10.7h0.1l3.8-10.7h4l-7.3,18.7c-0.3,0.7-0.6,1.4-0.9,1.9s-0.7,1-1.2,1.4c-0.4,0.4-1,0.7-1.6,0.8
                                          s-1.3,0.3-2.2,0.3c-1,0-2-0.1-2.9-0.4l0.5-3.5c0.3,0.1,0.6,0.2,0.9,0.3s0.7,0.1,1,0.1c0.5,0,0.9,0,1.2-0.1c0.3-0.1,0.6-0.2,0.8-0.4
                                          c0.2-0.2,0.4-0.4,0.6-0.7c0.1-0.3,0.3-0.6,0.5-1l0.7-1.8L413.1,381.7z"/>
                                </g>
                            </svg>

                            <!--<img class="img-responsive" style="width: 15%;float: left;" src="<?php echo base_url() . 'assets/images/dslogo.png'; ?>"/>-->
                        </a>
                    </h1>
                </li>
            </ul>
            
            <br />
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Sign in to start your session</p>
            <?php if ($this->session->flashdata("success")) { ?>
                <div class="alert alert-success alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <span class="text-center"><?php echo $this->session->flashdata('Success'); ?></span>
                </div>
            <?php }if ($this->session->flashdata("Duplicate")) { ?>
                <div class="alert alert-danger alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <span class="text-center"><?php echo $this->session->flashdata('Duplicate'); ?></span>
                </div>
            <?php } ?>

            <form action="<?php echo base_url('admin/Users/login'); ?>" method="post">

                <div class="form-group has-feedback">
                   <input type="text" class="form-control" name="username" placeholder="Please Enter Email id" required=""/>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Submit Password" required=""/>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
               
                <div class="row">

                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-primary btn-block btn-flat" id="btnchange">Sign In</button>
                    </div>
                    <!-- /.col -->

                </div>
            </form>

             <a href="<?php echo base_url(); ?>">Back to main site</a>  
        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->


