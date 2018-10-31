<?php
/* $image= array(
  array(base_url().'assets/images/banner/Born-Fly1ads.jpg', 'https://www.born-fly.com/collections/all','1'),
  array(base_url().'assets/images/banner/Born-Fly2ads.jpg','https://www.born-fly.com/collections/all','2'),
  array(base_url().'assets/images/banner/Born-Fly3ads.jpg','https://www.born-fly.com/collections/all','3'),
  array(base_url().'assets/images/banner/Born-Fly4ads.jpg','https://www.born-fly.com/collections/all','4'),
  array(base_url().'assets/images/banner/Born-Fly5ads.jpg','https://www.born-fly.com/collections/all','5'),
  array(base_url().'assets/images/banner/Samsung1ads.jpg','http://www.samsung.com/us/','6'),
  array(base_url().'assets/images/banner/Samsung2ads.jpg','http://www.samsung.com/us/','7'),
  array(base_url().'assets/images/banner/Vans1ads.jpg','http://www.vans.co.in/product/','8'),
  array(base_url().'assets/images/banner/Vans2ads.jpg','http://www.vans.co.in/product/','9'),
  array(base_url().'assets/images/banner/Vans3ads.jpg','http://www.vans.co.in/product/','10'),
  array(base_url().'assets/images/banner/Vans4ads.jpg','http://www.vans.co.in/product/','11'),
  array(base_url().'assets/images/banner/Wizpak1ads.jpg','https://wizpaks.com/','12'),
  array(base_url().'assets/images/banner/Wizpak2ads.jpg','https://wizpaks.com/','13')
  ); 
$image = array(
    array(base_url() . 'assets/images/banner/Born-Fly1ads.jpg', '', '1'),
    array(base_url() . 'assets/images/banner/Born-Fly2ads.jpg', '', '2'),
    array(base_url() . 'assets/images/banner/Born-Fly3ads.jpg', '', '3'),
    array(base_url() . 'assets/images/banner/Born-Fly4ads.jpg', '', '4'),
    array(base_url() . 'assets/images/banner/Born-Fly5ads.jpg', '', '5'),
    array(base_url() . 'assets/images/banner/Samsung1ads.jpg', 'http://www.samsung.com/us/', '6'),
    array(base_url() . 'assets/images/banner/Samsung2ads.jpg', 'http://www.samsung.com/us/', '7'),
    array(base_url() . 'assets/images/banner/Vans1ads.jpg', 'http://www.vans.co.in/product/', '8'),
    array(base_url() . 'assets/images/banner/Vans2ads.jpg', 'http://www.vans.co.in/product/', '9'),
    array(base_url() . 'assets/images/banner/Vans3ads.jpg', 'http://www.vans.co.in/product/', '10'),
    array(base_url() . 'assets/images/banner/Vans4ads.jpg', 'http://www.vans.co.in/product/', '11'),
    array(base_url() . 'assets/images/banner/Wizpak1ads.jpg', 'https://wizpaks.com/', '12'),
    array(base_url() . 'assets/images/banner/Wizpak2ads.jpg', 'https://wizpaks.com/', '13')
);*/

$uid = $this->session->userdata('getuser');

$Banner_details = $this->banners->get_banner($uid);
$banner = $Banner_details['bannerdetails'];
$img = array();
for ($a = 0; $a < sizeof($banner); $a++) {
    //$img[] = json_decode($banner[$a]['BackgroundImage']);
    $image_array['image'] = $banner[$a]['BackgroundImage'];
    $image_array['code'] = $banner[$a]['code'];
     if ($banner[$a]['redirecturl'] == '') {
        $image_array['url'] = '#';
    } else {
    $image_array['url'] = $banner[$a]['redirecturl'];
    }
    $img[] = json_decode(json_encode($image_array));
}
$image = array();
for ($s = 0; $s < sizeof($img); $s++) {
    $id = $s + 1;
    if ($img[$s]->image != '') {
        $image[] = array($img[$s]->image, $img[$s]->url, $id, $img[$s]->code);
    }
}
//echo '<pre>';print_r($image);exit;
?>

<!-- contact -->
<div class="modal fade" id="contacts" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn btn-cmt text-center popup" style="" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="color: #85298c;font-weight: normal !important;">Contacts</h4>
            </div>
            <div class="modal-body text-center">

                <center><p>Are you a Brand or Company Looking to work creatively with Jack Knight? <br>
                        Please Contact at <a href="mailto:Jack@demostream.tv">Jack@demostream.tv</a></p>
                </center>
            </div>
            <div class="modal-footer">

            </div>
        </div>

    </div>
</div>
<!--about us-->
<div class="modal fade" id="about" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn btn-cmt text-center popup" style="" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="color: #85298c;font-weight: normal !important;">About</h4>
            </div>
            <div class="modal-body text-justify">
                <div class="row">
                    <div class="col-md-3 col-sm-3 img-responsive img-circle" style="margin: 2% 0 0 3%;border-radius: 7em;padding: 25px;">
                        <center><img src="<?php echo base_url(); ?>assets/images/unknown.jpg" style="height: auto;"/></center>
                    </div>
                    <div class="col-md-8">
                        <p><br>Jack Knight is a proven leader and innovator in the entertainment and social media field. He has contributed to selling over 100 million records worldwide and has helped Sean "Diddy&#63; Combs turn the Bad Boy Music Label into a Billion dollar mega brand. <a href="#" style="display: inline;color: #85298c;font-weight: 600;text-decoration: underline;" id="learn_more" onclick="return show();"> Learn more</a></p>

                        <div id="data" style="display: none;">
                            <p>Jack has remained true to his craft of songwriting, producing and mentoring new talent for the past 15 years. His chart topping success had spanned over 2 decades, and has enabled him to work side by side with such talents and luminaries as Diddy, Matisyahu, Kanye West, Lyor Cohen, Jennifer Lopez, Lil Kim, Adele Tawil, Snoop Dog, Jay-z, and many more. </p><br>
                            <p>"The DNA of a great song has always been at the core of my experience and training in the music business" says Knight "and that combined with powerful distribution methods and outlets can create unlimited resources.
                                <a href="#" id="hide" style="display: inline;color: #85298c;font-weight: 700;text-decoration: underline;" onclick="return hide();"> Hide</a>
                            </p>
                        </div>		
                        <div class="col-md-9" style="padding: 0;">
                            <h5 style="color: #85298c;text-align: unset !important;font-weight: normal;font-size: 15px;text-transform: none;"><br><br>Find me on social media</h6>
                                <div class="col-md-3" style="padding: 0;">
                                    <a href="https://www.facebook.com/jackknightfamily/" target="_blank"><i class="fa fa-facebook about-icon"></i></a>
                                </div>
                                <div class="col-md-3" style="padding: 0;">
                                    <a href="https://www.instagram.com/jackknightthelegend/" target="_blank"><i style="padding: 8px 10px 9px 10px;" class="fa fa-instagram about-icon"></i></a>
                                </div>

                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">

            </div>
        </div>

    </div>
</div>
<!--get demostream-->
<div class="modal fade" id="getdemostream" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn btn-cmt text-center popup" style="" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="color: #85298c;font-weight: normal !important;">Demostream</h4>
            </div>
            <div class="modal-body text-justify">
                <div class="row">
                    <div class="col-md-offset-2 col-md-10">
                        <p>Please submit this Contact form if you are interested in<br> Getting Your Project Marketed & Powered By Demostream </p>
                    </div>
                    <?php if ($this->session->flashdata("Success")) { ?>
                        <div class="alert" style="background-color: aliceblue;">
                            <span class="text-center"><?php echo $this->session->flashdata('Success'); ?></span>
                        </div>
                    <?php } ?>
                    <div class="col-md-offset-2 col-md-10">
                        <div class="agileits-login" style="padding-right: 3em !important;padding-left: 3em !important;font-size: 12px;">
                            <h6 class="modal-title" style="color: #85298c;font-size:17px;font-weight: normal !important;">Please fill the form</h6><br>
                            <form class="form-horizontal" id="get-demo" method="post" action="<?php echo base_url('Contact/submit'); ?>">
                                
                                <div class="form-group" style="margin-bottom: 0px !important;"> 
                                    <div class="col-sm-8" style="">
                                        <div class="inner-addon left-addon">
                                            <span class="form-control-feedback m" style="right: unset !important;"><img src="<?php echo base_url() . 'assets/images/1.png'; ?>" style="width: auto;height:auto;"></span>
                                            <input type="text" class="form-control" style="background-color: #fff !important" autocomplete="off" maxlength="40" required="" name="name" id="name" placeholder="Enter Name" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-bottom: 0px !important;"> 
                                    <div class="col-sm-8" style="">
                                        <div class="inner-addon left-addon">
                                            <span class="form-control-feedback m" style="right: unset !important;"><img src="<?php echo base_url() . 'assets/images/2.png'; ?>" style="width: auto;height:auto;"></span>
                                            <input type="email" class="form-control" autocomplete="off" maxlength="40" required="" name="email" id="email" placeholder="Enter Email" style="background-color: #fff !important" />
                                        </div></div>
                                </div>
                                <div class="form-group" style="margin-bottom: 0px !important;">
                                    <div class="col-sm-8" style="">
                                        <div class="inner-addon left-addon">
                                            <span class="form-control-feedback m" style="right: unset !important;"><img src="<?php echo base_url() . 'assets/images/3.png'; ?>" style="width: auto;height:auto;"></span>
                                            <input type="text" class="form-control" style="background-color: #fff !important" autocomplete="off" pattern="[0-9\/]*" required="" name="phone" maxlength="10" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="Enter Phone Number" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-8" style="">
                                        <div class="inner-addon left-addon">
                                            <span class="form-control-feedback m" style="right: unset !important;"><img src="<?php echo base_url() . 'assets/images/4.png'; ?>" style="width: auto;height:auto;"></span>
                                            <textarea class="form-control" required="" autocomplete="off" style="font-family: inherit !important;" name="message" row="3" placeholder="Your Message"></textarea><br>
                                        </div></div>
                                </div>				
                                <div class="form-group" style="">		
                                    <div class="col-sm-8" style="text-align: center;">				
                                        <input type="submit" name="submit" id="submit" style="border-radius: 7px;background-color: #85298c !important;color: white !important;" value="Submit" />  	
                                    </div>					
                                </div>	
                            </form>	
                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                </div>
            </div>

        </div>
    </div>


    <div class="copy" style="display: none">
        <p>� 2017 Freightage . All Rights Reserved | Design by <a href="http://w3layouts.com/">W3layouts</a> </p>
    </div>
    <!--light-box-files -->
    <!--<script src="<?php echo base_url(); ?>assets/js/modernizr.custom.js"></script>-->
    <script src="<?php echo base_url(); ?>assets/js/jquery.chocolat.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/chocolat.css" type="text/css" media="screen">

    <!--//footer-section-->
    <!--<a href="#" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>-->
    <!-- //smooth scrolling -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-3.1.1.min.js"></script>
    <script type="text/javascript">
                                    function show() {
                                        $('#learn_more').hide();
                                        $('#data').show();
                                    }
                                    function hide() {
                                        $('#data').hide();
                                        $('#learn_more').show();
                                    }
                                    $(function () {
                                        var windowHeight = $(window).height();
                                        var windowWidth = $(window).width();
                                        $('#mobile-des').hide();
                                        if (windowWidth < 768) {
                                            $('.m').css("top","-5px");
                                            $('#mobile-banner-div').css("margin-top", "0");
                                            $('#on').removeClass('on');
                                            $('#web-des').hide();
                                            $('#mobile-banner-div').show();
                                            $('#mobile-des').show();
                                        }
                                        var main = $(".middle");
                                        $(".middle").css({top: ((windowHeight / 2) - (main.height() / 2)) + "px",
                                            /* left:((windowWidth / 3) - (main.width() / 3)) + "px" */});
                                    });
                                   
    </script>
     <script type="text/javascript">
        var images = <?php echo json_encode($image); ?>;
       
            
        var i = 1;
         var imageHead = document.getElementById("home");
        imageHead.style.backgroundImage = "url(" + images[i][0] + ")";
            $('#home').attr('data-value', images[i][2]);
        i = i + 1;
        $("#on").click(function (event) {
            var data = parseInt($('#home').attr('data-value'));
            if (images[data - 1][1] != '#') {
            window.open(images[data - 1][1], '_blank');
            }
        });
        //$('#home').attr('data-value','1');
        setInterval(function () {
            imageHead.style.backgroundImage = "url(" + images[i][0] + ")";
            $('#home').attr('data-value', images[i][2]);
            i = i + 1;
            if (i == images.length) {
                i = 0;
            }
        }, 11000);
    </script>
</body>
</html>