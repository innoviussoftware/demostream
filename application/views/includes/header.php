<?php 
//echo '<pre>';
//print_r($meta);
?>
<!DOCTYPE html>
<html lang="en">

    <head>
	<?php error_reporting(0); ?>
        <title>Demo Stream</title>
        <!-- for-mobile-apps -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="Demo Stream" />
		<meta property="og:type" content="http://demostream.tv" />		
		<meta property="og:title" content="<?php echo $meta['title'];?>" />
		<meta property="og:description" content="<?php echo $meta['des'];?>" />
		<meta property="og:image" content="<?php echo $meta['image'];?>"/>		
		
		<meta name="twitter:title" content="<?php echo $meta['title'];?>" />
		<meta name="twitter:description" content="<?php echo $meta['des'];?>">
		<meta name="twitter:image" content="<?php echo $meta['image'];?>"/>

		<link rel="canonical" href="/web/tweet-button">
		
		<link rel="icon" href="<?php echo base_url().'assets/images/dslogo.png';?>">
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
            function hideURLbar(){ window.scrollTo(0,1); } </script>
        <!-- //for-mobile-apps -->
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
        <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" type="text/css" media="all" />
        <link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet" type="text/css" media="all">
        <!--web-fonts-->
        <link href="//fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
        <link href="//fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		
        <!--//web-fonts-->
        <!--//fonts-->
    </head>
	<body>
        <div class="banner-w3layouts" id="home" data-value='0'>
		<div class="on" id="on"></div>
		<div class="discount" style="display: none;">Discount Code: VIP</div>
    