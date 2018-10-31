<?php
//echo '<pre>';print_r($video['videodetails']);exit;

$useragent = $_SERVER['HTTP_USER_AGENT'];

$is_mobile = "";

if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4))) {

    $is_mobile = true;
} else {

    $is_mobile = false;
}



//$IsSubscribed = 0;
//if (!empty($this->session->userdata('subscription'))) {
//    $subscription = $this->session->userdata('subscription');
//    //echo '<pre>';print_r($subscription);exit;
//    if (sizeof($subscription) > 0) {
//        $IsSubscribed = $subscription[0]['IsSubscribed'];
//    }
//} else if (!empty($this->session->userdata('login_data'))) {
//    $IsSubscribed = 2;
//} else {
//    $IsSubscribed = 0;
//}
//echo '<pre>';
//print_r($video);
//exit;

if ($video['campaigndetails'] != '') {



    $IsCampaign = 1;

    $video_path = $video['campaigndetails'][0]['VideoPath'];

    $youtube = strpos($video_path, 'youtu');

    $vimeo = strpos($video_path, 'vimeo');

    if ($youtube != '') {

        $video_path = convertYoutube($video_path);
    }if ($vimeo != '') {

        $video_path = convertVimeo($video_path);
    }



    $ext = pathinfo($video_path, PATHINFO_EXTENSION);

    $ext = strtolower($ext);

    $IsPayment = $video['campaigndetails'][0]['IsPayment'];

    $IsPurchase = $video['campaigndetails'][0]['IsPurchase'];

    $VideoAmount = $video['campaigndetails'][0]['Amount'];



    $wrapper_path = $video['campaigndetails'][0]['WrapperPath'];

    $Desc = $video['campaigndetails'][0]['CampaignDesc'];

    $video_count = $video['campaigndetails'][0]['ViewsCount'];

    $CampaignDetID = $video['campaigndetails'][0]['CampaignDetID'];



    $CanBuy = $video['campaigndetails'][0]['CanBuy'];

    $CanShare = $video['campaigndetails'][0]['CanShare'];

    $CanCollaborate = $video['campaigndetails'][0]['CanCollaborate'];

    $CanDonate = $video['campaigndetails'][0]['CanDonate'];



    $campaign_details = $this->session->set_userdata('campaign_details', $video['campaigndetails'][0]);

    $Video_ID = $this->session->userdata['Video_ID'];
    $User_ID = $this->session->userdata['UserID'];

    $iscampaign = $this->session->set_userdata('iscampaign', 1);

    $this->session->set_userdata('title', $video['campaigndetails'][0]['CampaignTitle']);



    $CommentsCount = $video['campaigndetails'][0]['CommentsCount'];

    $DonorCount = $video['campaigndetails'][0]['DonorsCount'];

    $shareurl = base_url() . 'Video_curl/campaign/' . $Video_ID;
}if ($video['videodetails'] != '') {

    $IsCampaign = 0;

    $CampaignDetID = $video['videodetails'][0]['CampaignDetID'];

    if ($CampaignDetID == '') {

        $CampaignDetID = $this->session->userdata['Video_ID'];
    }



    $Video_ID = $this->session->userdata['Video_ID'];
    $User_ID = $this->session->userdata['UserID'];

    $iscampaign = $this->session->set_userdata('iscampaign', 0);

    $IsPayment = $video['videodetails'][0]['IsPayment'];

    $IsPurchase = $video['videodetails'][0]['IsPurchase'];

    $VideoAmount = $video['videodetails'][0]['Amount'];



    $this->session->set_userdata('video_amount', $video['videodetails'][0]['Amount']);

    $this->session->set_userdata('title', $video['videodetails'][0]['Title']);

    $campaign_details = $this->session->set_userdata('campaign_details', $video['videodetails'][0]);

    $video_path = $video['videodetails'][0]['VideoPath'];

    $youtube = strpos($video_path, 'youtu');

    $vimeo = strpos($video_path, 'vimeo');

    if ($youtube != '') {

        $video_path = convertYoutube($video_path);
    }if ($vimeo != '') {

        $video_path = convertVimeo($video_path);
    }



    $ext = pathinfo($video_path, PATHINFO_EXTENSION);

    $ext = strtolower($ext);



    $Desc = $video['videodetails'][0]['Description'];

    $CanBuy = $video['videodetails'][0]['CanBuy'];

    $CanShare = $video['videodetails'][0]['CanShare'];

    $CanCollaborate = $video['videodetails'][0]['CanCollaborate'];

    $CanDonate = $video['videodetails'][0]['CanDonate'];

    $video_count = $video['videodetails'][0]['ViewsCount'];



    $CommentsCount = $video['videodetails'][0]['NoOfComments'];

    $DonorCount = $video['videodetails'][0]['NoOfDonors'];

    $shareurl = base_url() . 'Video_curl/video/' . $Video_ID;
} else {
    
}



if ($this->session->flashdata('data_msg')) {
    ?>

    <script>

        alert('<?php echo $this->session->flashdata('data_msg'); ?>');</script>

<?php } ?>

<div class="container middle paper-craft-middle">

    <div class="row">
        <?php if ($this->session->flashdata('success')) { ?>
            <div class="alert alert-success alert-dismissable" role="alert">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <span><?php echo $this->session->flashdata('success'); ?></span>
            </div>
        <?php }if ($this->session->flashdata('danger')) { ?>
            <div class="alert alert-danger alert-dismissable" role="alert">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <span><?php echo $this->session->flashdata('danger'); ?></span>
            </div>
        <?php } ?>	

        <div class="col-md-offset-0 col-md-4 col-xs-12" style="border-top-left-radius: 1em;border-top-right-radius: 1em; margin-top: 4%;">		

    
            <div class="row text-center" style="display: none;margin: 0px !important;background-color: #fff;border-top-left-radius: 1em;border-top-right-radius: 1em;margin: 0px !important;">

                <div class="col-sm-6 col-xs-6" style="background-color: gold;color: #fff;padding: 10px;border-top-left-radius: 1em;border-top-right-radius: 1em;">

                    <h4>Video</h4>

                </div>

                <div class="col-sm-6 col-xs-6" style="color: #85298c;background-color: #fff;padding: 10px;border-top-left-radius: 1em;border-top-right-radius: 1em;">

                    <h4>Live</h4>

                </div>

            </div>

     
        </div>

    </div>

    <div class="row">

        <div class="col-md-offset-0 col-md-4">

            <div class="row top-title" style="font-size: 14px;background-color: #8B008B;color: white;">		

                <div class="col-xs-12" style="text-align: left;">

                    <a href="#" onclick="history.back();" style="color:white;"><span class=""></span></a>&nbsp; <b><?php echo $this->session->userdata['title']; ?></b>

                </div>

                <div class="col-xs-0" style="font-size: 18px;text-align: right;">

                    <a href="<?php
                    if ($IsCampaign == 1) {

                        echo base_url('Video_curl/campaign/' . $Video_ID);
                    } else {

                        echo base_url('Video_curl/video/' . $Video_ID);
                    }
                    ?>" style="color:white;"><span></span></a>

                </div>

            </div>

        </div>

    </div>

    <div class="row" style="">



        <div class="col-md-offset-0 col-md-4 col-xs-12 col-sm-12 bg-video about-pad" id="mob" style="max-height: 500px;">		

            <div class="iframe">

                <div class="embed-responsive embed-responsive-16by9" style="">

                    <?php if ($video_path != 'null' && $video_path != '' && $ext == '') { ?>

                        <iframe class="embed-responsive-item" src="<?php echo $video_path; ?>" frameborder="0" allowfullscreen></iframe>



                    <?php } else if ($ext == 'wav' || $ext == 'mp3' || $ext == 'm4a') {
                        ?>				

                        <p>

                            <img src="<?php echo base_url() . 'assets/images/audio.gif'; ?>" style="width: 100%;" class="img-responsive"/>

                        </p>

                        <audio controls style="position: absolute;bottom: 5%;margin-left: 5%;width: 80%;">

                            <source src="<?php echo $video_path; ?>" type="audio/mpeg">

                            <source src="<?php echo $video_path; ?>" type="audio/wav">

                            <source src="<?php echo $video_path; ?>" type="audio/ogg">

                        </audio>

                        <?php
                    } else {

                        echo '<iframe width="560" height="315" src="" frameborder="0" allowfullscreen></iframe>';
                    }
                    ?>

                </div>				

            </div>	



            <div class="row paper-craft buttons" style="background-color: #67216D;">



                <a href="<?php
                if ($CanBuy == 1) {

                    echo base_url('Shopify');
                }
                ?>" id="hover-buy" onclick="return msg(<?php echo $CanBuy; ?>, 'buy');">	



                    <div class="col-xs-2 col-md-2" style="padding-top: 5px;width: 25%;">



                        <svg version="1.1" id="buy_1" style="display: none;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"

                             width="25px" height="25px" viewBox="0 0 18 18" style="enable-background:new 0 0 18 18;" xml:space="preserve">

                        <style type="text/css">

                            #buy_1 .st0{fill:#FFFFFF;}

                            #buy_1 .st1{fill-rule:evenodd;clip-rule:evenodd;fill:#D8BADA;}

                        </style>

                        <g>

                        <path class="st1" d="M5.5,10.4h10.6L18,3.5h-2.8l-1-3.2l-4.1,1.4l0.6,1.8h-0.2l-1-3.2L5.3,1.7l0.6,1.8H3.7L3.2,1.6

                              C3,0.7,2.2,0,1.3,0H0v0.8h1.3c0.6,0,1.1,0.4,1.2,1l2,8.2c-0.4,0.3-0.7,0.8-0.7,1.4c0,0.9,0.8,1.7,1.7,1.7h10.3v-0.8H5.5

                              c-0.5,0-0.9-0.4-0.9-0.9C4.6,10.9,5,10.4,5.5,10.4z M3.9,4.3H17l-1.5,5.4H5.2L3.9,4.3z"/>

                        <path class="st1" d="M12.7,14.6c-0.9,0-1.7,0.8-1.7,1.7c0,0.9,0.8,1.7,1.7,1.7c1,0,1.7-0.8,1.7-1.7C14.4,15.3,13.6,14.6,12.7,14.6z

                              M12.7,17.2c-0.5,0-0.9-0.5-0.9-0.9c0-0.5,0.4-0.9,0.9-0.9c0.5,0,0.9,0.4,0.9,0.9C13.6,16.8,13.2,17.2,12.7,17.2z"/>

                        <path class="st1" d="M6.5,14.6c-0.9,0-1.7,0.8-1.7,1.7c0,0.9,0.8,1.7,1.7,1.7c0.9,0,1.7-0.8,1.7-1.7C8.2,15.3,7.4,14.6,6.5,14.6z

                              M6.5,17.2c-0.5,0-0.9-0.5-0.9-0.9c0-0.5,0.4-0.9,0.9-0.9c0.5,0,0.9,0.4,0.9,0.9C7.4,16.8,6.9,17.2,6.5,17.2z"/>

                        </g>

                        </svg>



                        <svg version="1.1" id="buy_2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"

                             width="25px" height="25px" viewBox="0 0 18 18" style="enable-background:new 0 0 18 18;" xml:space="preserve">

                        <style type="text/css">

                            #buy_2 .st0{fill:#662D91;}					

                            #buy_2 .st2{fill:#009245;}

                            #buy_2 .st3{fill:#FFFFFF;}

                            #buy_2 .st4{fill:#CCCCCC;}

                            #buy_2 .st5{fill:#428BCA;}

                            #buy_2 .st6{clip-path:url(#SVGID_2_);}

                            #buy_2 .st7{fill:#5CB85C;}

                            #buy_2 .st8{fill:#5BC0DE;}

                            #buy_2 .st9{fill:#F0AD4E;}

                            #buy_2 .st10{fill:#D9534F;}

                            #buy_2 .st11{fill:#32788E;}

                            #buy_2 .st12{fill:none;stroke:#CCCCCC;stroke-miterlimit:10;}

                            #buy_2 .st13{clip-path:url(#SVGID_13_);}

                            #buy_2 .st14{clip-path:url(#SVGID_14_);fill:#83258A;}

                            #buy_2 .st15{clip-path:url(#SVGID_17_);}

                            #buy_2 .st16{clip-path:url(#SVGID_18_);fill:#651B6B;}

                            #buy_2 .st17{clip-path:url(#SVGID_21_);}

                            #buy_2 .st18{clip-path:url(#SVGID_22_);fill:#D8BADA;}

                            #buy_2 .st19{clip-path:url(#SVGID_25_);}

                            #buy_2 .st20{clip-path:url(#SVGID_26_);fill:#FFFFFF;}

                            #buy_2 .st21{fill:#E1C8E2;}

                            #buy_2 .st22{fill-rule:evenodd;clip-rule:evenodd;fill:#FFFFFF;}

                            #buy_2 .st23{fill-rule:evenodd;clip-rule:evenodd;fill:#D8BADA;}

                            #buy_2 .st24{fill-rule:evenodd;clip-rule:evenodd;fill:#525252;}

                        </style>

                        <g>

                        <defs>

                        <rect id="SVGID_9_" x="145.2" y="-338.6" width="1920" height="975"/>

                        </defs>

                        <clipPath id="SVGID_2_">

                            <use xlink:href="#SVGID_9_"  style="overflow:visible;"/>

                        </clipPath>

                        <g class="st6">



<!--							<image style="overflow:visible;" width="3840" height="1080" xlink:href="6A1A6B12.jpg"  transform="matrix(1 0 0 1 -1774.7902 -403.6242)">

</image>-->

                        </g>

                        </g>

                        <g>

                        <path class="st22" d="M5.5,10.4h10.6L18,3.5h-2.8l-1-3.2l-4.1,1.4l0.6,1.8h-0.2l-1-3.2L5.3,1.7l0.6,1.8H3.7L3.2,1.6

                              C3,0.7,2.2,0,1.3,0H0v0.8h1.3c0.6,0,1.1,0.4,1.2,1l2,8.2c-0.4,0.3-0.7,0.8-0.7,1.4c0,0.9,0.8,1.7,1.7,1.7h10.3v-0.8H5.5

                              c-0.5,0-0.9-0.4-0.9-0.9C4.6,10.9,5,10.4,5.5,10.4z M13.7,1.3l0.7,2.1h-3L11,2.3L13.7,1.3z M9,1.3l0.7,2.1h-3L6.2,2.3L9,1.3z

                              M3.9,4.3H17l-1.5,5.4H5.2L3.9,4.3z"/>

                        <path class="st22" d="M12.7,14.6c-0.9,0-1.7,0.8-1.7,1.7c0,0.9,0.8,1.7,1.7,1.7c1,0,1.7-0.8,1.7-1.7C14.4,15.3,13.6,14.6,12.7,14.6

                              z M12.7,17.2c-0.5,0-0.9-0.5-0.9-0.9c0-0.5,0.4-0.9,0.9-0.9c0.5,0,0.9,0.4,0.9,0.9C13.6,16.8,13.2,17.2,12.7,17.2z"/>

                        <path class="st22" d="M6.5,14.6c-0.9,0-1.7,0.8-1.7,1.7c0,0.9,0.8,1.7,1.7,1.7c0.9,0,1.7-0.8,1.7-1.7C8.2,15.3,7.4,14.6,6.5,14.6z

                              M6.5,17.2c-0.5,0-0.9-0.5-0.9-0.9c0-0.5,0.4-0.9,0.9-0.9c0.5,0,0.9,0.4,0.9,0.9C7.4,16.8,6.9,17.2,6.5,17.2z"/>

                        </g>

                        </svg>



                        <p style="color: #fff">Buy</p>



                        <script>

                            $('#hover-buy').mouseover(function () {

                                $('#buy_2').hide();

                                $('#buy_1').show();

                            });

                            $('#hover-buy').mouseout(function () {

                                $('#buy_1').hide();

                                $('#buy_2').show();

                            });

                        </script>

                    </div></a>

                <a href="#" data-toggle="modal" data-target="#share-popup" id="hover-share">

                    <div class="col-xs-2 col-md-2" style="padding-top: 5px;width: 25%;">



                        <svg version="1.1" id="share_2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"

                             width="25px" height="25px" viewBox="0 0 18 18" style="enable-background:new 0 0 18 18;" xml:space="preserve">

                        <style type="text/css">

                            #share_2 .st0{fill:#FFFFFF;}

                        </style>

                        <path class="st0" d="M14.6,1C15.9,1,17,2,17,3.2s-1.1,2.2-2.4,2.2c-0.8,0-1.5-0.3-1.9-0.9l-0.2-0.3l-0.1-0.3

                              c-0.1-0.2-0.1-0.5-0.1-0.7C12.2,2,13.2,1,14.6,1 M3.4,6.8c0.8,0,1.5,0.3,1.9,0.9L5.5,8l0.1,0.3C5.8,8.5,5.8,8.7,5.8,9

                              c0,0.2,0,0.5-0.1,0.7L5.6,10l-0.2,0.3c-0.5,0.6-1.2,0.9-1.9,0.9C2.1,11.2,1,10.2,1,9S2.1,6.8,3.4,6.8 M14.6,12.6

                              c1.3,0,2.4,1,2.4,2.2S15.9,17,14.6,17s-2.4-1-2.4-2.2c0-0.2,0-0.5,0.1-0.7l0.1-0.3l0.2-0.3C13.1,12.9,13.8,12.6,14.6,12.6 M14.6,0

                              c-1.9,0-3.4,1.4-3.4,3.2c0,0.4,0.1,0.7,0.2,1.1L6.1,7C5.5,6.3,4.5,5.8,3.4,5.8C1.5,5.8,0,7.2,0,9s1.5,3.2,3.4,3.2

                              c1.1,0,2.1-0.5,2.7-1.3l5.2,2.8c-0.1,0.3-0.2,0.7-0.2,1.1c0,1.8,1.5,3.2,3.4,3.2s3.4-1.4,3.4-3.2s-1.5-3.2-3.4-3.2

                              c-1.1,0-2.1,0.5-2.7,1.3l-5.2-2.8C6.8,9.7,6.8,9.4,6.8,9S6.7,8.3,6.6,7.9l5.2-2.8c0.6,0.8,1.6,1.3,2.7,1.3c2,0,3.5-1.4,3.5-3.2

                              S16.5,0,14.6,0L14.6,0z"/>

                        </svg>



                        <svg version="1.1" id="share_1" style="display: none;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"

                             width="25px" height="25px" viewBox="0 0 18 18" style="enable-background:new 0 0 18 18;" xml:space="preserve">

                        <style type="text/css">

                            #share_1 .st0{fill:#D8BADA;}

                        </style>

                        <path class="st0" d="M14.6,11.6c1.9,0,3.4,1.4,3.4,3.2S16.5,18,14.6,18s-3.4-1.4-3.4-3.2c0-0.4,0.1-0.7,0.2-1.1l-5.2-2.8

                              c-0.6,0.8-1.6,1.3-2.7,1.3C1.5,12.2,0,10.8,0,9s1.5-3.2,3.4-3.2c1.1,0,2.1,0.5,2.7,1.3l5.2-2.8c-0.1-0.3-0.2-0.7-0.2-1.1

                              c0-1.8,1.5-3.2,3.4-3.2c2,0,3.5,1.4,3.5,3.2s-1.5,3.2-3.4,3.2c-1.1,0-2.1-0.5-2.7-1.3L6.6,7.9C6.8,8.3,6.8,8.6,6.8,9

                              s-0.1,0.7-0.2,1.1l5.2,2.8C12.5,12.1,13.5,11.6,14.6,11.6L14.6,11.6z"/>

                        </svg>







                        <p style="color: #fff">Share</p>

                        <!--<img  class="img-responsive" id="share2" style="display:none;transform: scale(1);"  src="<?php echo base_url(); ?>assets/images/icons/new/share1.png">-->



                        <script>

                            $('#hover-share').mouseover(function () {

                                $('#share_2').hide();

                                $('#share_1').show();

                            });

                            $('#hover-share').mouseout(function () {

                                $('#share_1').hide();

                                $('#share_2').show();

                            });

                        </script>

                    </div>

                </a>

                <a id="hover-donate" href="<?php
                if ($CanDonate == 1) {

                    echo base_url('Video_curl/activity_updates/' . $Video_ID);
                }
                ?>" onclick="return msg(<?php echo $CanDonate; ?>, 'donate');">

                    <div class="col-xs-2 col-md-2" style="padding: 5px;width: 25%;">



                        <svg version="1.1" id="donate_2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"

                             width="25px" height="25px" viewBox="0 0 18 18" style="enable-background:new 0 0 18 18;" xml:space="preserve">

                        <style type="text/css">

                            #donate_2 .st0{fill:#FFFFFF;}

                        </style>

                        <g>

                        <path class="st0" d="M8.2,9.6h1.6c0.6,0,1.2,0.5,1.2,1.2c0,0.6-0.5,1.2-1.2,1.2H7c-0.3,0-0.6,0.3-0.6,0.6C6.4,12.7,6.7,13,7,13h1.5

                              v1.1c0,0.3,0.3,0.6,0.6,0.6c0.3,0,0.6-0.3,0.6-0.6V13h0.2c1.3,0,2.3-1,2.3-2.3c0-1.3-1-2.3-2.3-2.3H8.2c-0.6,0-1.2-0.5-1.2-1.2

                              c0-0.6,0.5-1.2,1.2-1.2H11c0.3,0,0.6-0.3,0.6-0.6C11.5,5.3,11.3,5,11,5H9.6V3.9c0-0.3-0.3-0.6-0.6-0.6c-0.3,0-0.6,0.3-0.6,0.6V5

                              H8.2C7,5,5.9,6,5.9,7.3C5.9,8.5,7,9.6,8.2,9.6L8.2,9.6z M8.2,9.6"/>

                        <path class="st0" d="M9,18c5,0,9-4,9-9c0-5-4-9-9-9C4,0,0,4,0,9C0,14,4,18,9,18L9,18z M9,1.1c4.3,0,7.9,3.5,7.9,7.9

                              c0,4.3-3.5,7.9-7.9,7.9c-4.3,0-7.9-3.5-7.9-7.9C1.1,4.7,4.7,1.1,9,1.1L9,1.1z M9,1.1"/>

                        </g>

                        </svg>



                        <svg version="1.1" id="donate_1" style="display: none;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"

                             width="25px" height="25px" viewBox="0 0 18 18" style="enable-background:new 0 0 18 18;" xml:space="preserve">

                        <style type="text/css">

                            #donate_1 .st0{fill:#D8BADA;}

                            #donate_1 .st1{fill:#FFFFFF;}

                        </style>

                        <path class="st0" d="M9,18c5,0,9-4,9-9s-4-9-9-9S0,4,0,9S4,18,9,18L9,18z"/>

                        <path class="st1" d="M8.2,9.6h1.6c0.6,0,1.2,0.5,1.2,1.2c0,0.6-0.5,1.2-1.2,1.2H7c-0.3,0-0.6,0.3-0.6,0.6C6.4,12.7,6.7,13,7,13h1.5

                              v1.1c0,0.3,0.3,0.6,0.6,0.6s0.6-0.3,0.6-0.6V13h0.2c1.3,0,2.3-1,2.3-2.3s-1-2.3-2.3-2.3H8.2C7.6,8.4,7,7.9,7,7.2C7,6.6,7.5,6,8.2,6

                              H11c0.3,0,0.6-0.3,0.6-0.6C11.5,5.3,11.3,5,11,5H9.6V3.9c0-0.3-0.3-0.6-0.6-0.6S8.4,3.6,8.4,3.9V5H8.2C7,5,5.9,6,5.9,7.3

                              C5.9,8.5,7,9.6,8.2,9.6L8.2,9.6z"/>

                        </svg>

                        <p style="color: #fff;">Donate</p>



<!--<img  class="img-responsive" id="donate1" style="transform: scale(1);" src="<?php echo base_url(); ?>assets/images/icons/new/donate2.png">-->





                        <script>

                            $('#hover-donate').mouseover(function () {

                                $('#donate_2').hide();

                                $('#donate_1').show();

                            });

                            $('#hover-donate').mouseout(function () {

                                $('#donate_1').hide();

                                $('#donate_2').show();

                            });

                        </script>

                    </div>

                </a>

                <!--<a href="#" id="hover-down" onclick="<?php if ($video_path != 'null' && $video_path != '' && $vimeo == '' && $ext == '') { ?>return video('<?php echo $video_path; ?>') <?php } ?>;">-->

                <?php
                if ($IsPayment == 0) {
                    ?>
                    <a download id="hover-down" style="cursor: pointer;" onclick="">
                        <?php
                    } if ($IsPayment == 1) {
                        if ($this->session->userdata('login_userdata')) {
                            if ($IsPurchase == 1) {
                                ?>
                                <a download id="hover-down" style="cursor: pointer;" onclick="">
                                    <?php
                                } if ($IsPurchase == 0) {
                                    ?>
                                    <a id="hover-down" style="cursor: pointer;" onclick="location.replace('<?php echo base_url(); ?>Purchase/index');">
                                        <?php
                                    }
                                } if ($this->session->userdata('login_userdata') == '') {
                                    ?>
                                    <a id="hover-down" style="cursor: pointer;" onclick="location.replace('<?php echo base_url(); ?>Hauth/users');">
                                        <?php
                                    }
                                }
                                ?>

                                <div class="col-xs-2 col-md-2" style="padding-right: inherit;padding-top: 5px;width: 20%;">



                                    <svg version="1.1" id="down_1" style="display: none;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"

                                         width="25px" height="25px" viewBox="0 0 18 18" style="enable-background:new 0 0 18 18;" xml:space="preserve">

                                    <style type="text/css">

                                        .st0{fill-rule:evenodd;clip-rule:evenodd;fill:none;}

                                        .st1{fill:#FFFFFF;}

                                        .st2{fill-rule:evenodd;clip-rule:evenodd;fill:#FFFFFF;}

                                    </style>

                                    <g>

                                    <g>

                                    <path class="st1" d="M9.3,14.1l-0.2,0l0,0c0,0,0,0-0.1,0c-0.1,0-0.1,0-0.1,0l-0.4-0.2c-0.1,0-0.1-0.1-0.1-0.1

                                          c-0.1-0.1-0.1-0.1-0.2-0.1L3.6,8.8C3,8.2,3,7.2,3.6,6.6c0.3-0.3,0.7-0.5,1.1-0.5c0,0,0,0,0,0c0.4,0,0.8,0.2,1.1,0.5l2.1,2.1V1.5

                                          C7.8,0.7,8.5,0,9.3,0c0.8,0,1.5,0.7,1.5,1.5v7.2l2.1-2.1C13.4,6,14.4,6,15,6.6c0.6,0.6,0.6,1.6,0,2.2c-3,3.2-4.6,4.8-4.6,4.8

                                          L10,13.9l-0.4,0.2c0,0,0,0-0.1,0C9.4,14.1,9.3,14.1,9.3,14.1z M9,12.9C9,12.9,9,12.9,9,12.9C9,13,9,13,9,12.9C9,13,9.1,13,9.1,13

                                          c0,0,0.2,0.1,0.2,0.1c0.1,0,0.2-0.1,0.3-0.1c0.2-0.2,1-1,4.7-4.9c0.2-0.2,0.2-0.5,0-0.8c-0.2-0.2-0.5-0.2-0.7,0l-3.8,4V1.5

                                          C9.8,1.3,9.6,1,9.3,1S8.8,1.3,8.8,1.5v9.8L5,7.3C4.9,7.2,4.8,7.2,4.7,7.2h0c-0.1,0-0.2,0.1-0.3,0.1c-0.2,0.2-0.2,0.5,0,0.8

                                          C4.3,8.1,7.8,11.7,9,12.9z"/>

                                    </g>

                                    <g>

                                    <path class="st2" d="M17,13.1c-0.5,0-1,0.4-1,1V16H2v-1.9c0-0.5-0.4-1-1-1c-0.5,0-1,0.4-1,1V17c0,0.5,0.4,1,1,1h16

                                          c0.5,0,1-0.4,1-1v-2.9C18,13.5,17.6,13.1,17,13.1L17,13.1z"/>

                                    </g>

                                    </g>

                                    </svg>



                                    <svg version="1.1" id="down_2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"

                                         width="25px" height="25px" viewBox="0 0 18 18" style="enable-background:new 0 0 18 18;" xml:space="preserve">

                                    <style type="text/css">

                                        .st0{fill-rule:evenodd;clip-rule:evenodd;fill:none;}

                                        .st1{fill:#FFFFFF;}

                                        .st2{fill-rule:evenodd;clip-rule:evenodd;fill:#FFFFFF;}

                                    </style>

                                    <path class="st2" d="M8.2,13.8C8.2,13.8,8.3,13.9,8.2,13.8c0.1,0.1,0.1,0.1,0.1,0.1c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0

                                          c0,0,0,0,0.1,0c0,0,0,0,0,0c0,0,0,0,0.1,0c0,0,0,0,0.1,0c0,0,0,0,0.1,0c0,0,0,0,0.1,0c0,0,0,0,0.1,0c0,0,0,0,0,0c0,0,0.1,0,0.1,0

                                          c0,0,0.1,0,0.1,0c0,0,0,0,0.1,0c0,0,0,0,0.1,0c0,0,0,0,0.1,0c0,0,0,0,0.1,0c0,0,0,0,0.1,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0.1,0

                                          c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0.1,0,0.1-0.1c0,0,1.8-1.7,5.3-5.2c0.4-0.4,0.4-1.1,0-1.6

                                          c-0.4-0.4-1.2-0.4-1.6,0l-3.3,3.3V1.2C10.1,0.5,9.6,0,9,0C8.4,0,7.9,0.5,7.9,1.2v9.2L4.5,7C4.1,6.6,3.4,6.6,3,7

                                          C2.5,7.5,2.5,8.2,3,8.6L8.2,13.8L8.2,13.8z"/>

                                    <path class="st2" d="M17,13.2c-0.5,0-1,0.4-1,1V16H2v-1.9c0-0.5-0.4-1-1-1c-0.5,0-1,0.4-1,1V17c0,0.5,0.4,1,1,1h16c0.5,0,1-0.4,1-1

                                          v-2.9C18,13.6,17.6,13.2,17,13.2L17,13.2z"/>



                                    </svg>

                                    <p style="color: #fff;">Download</p>						

                            <!--<img  class="img-responsive" id="down1" style="transform: scale(1);" src="<?php echo base_url(); ?>assets/images/icons/new/download2.png">-->





                                    <script>

                                        $('#hover-down').mouseover(function () {

                                            $('#down_2').hide();

                                            $('#down_1').show();

                                        });

                                        $('#hover-down').mouseout(function () {

                                            $('#down_1').hide();

                                            $('#down_2').show();

                                        });

                                    </script>

                                </div>

                            </a>

                            </div>







                            <div class="row des">

                                <div class="col-xs-6">

                                    <h5>About</h5>

                                </div>

                                <div class="col-xs-6">

                                    <h5 style="color:#8B008B;float:right;font-weight:normal;">Views <b><?php echo $video_count; ?></b></h5>

                                </div>

                                <div class="col-xs-12" id="mobile-des">

                                    <?php
                                    $len = strlen($Desc);

                                    if ($Desc != '' && $len > 40) {
                                        ?>

                                        <p style="font-size:12px;" id="short"><br><?php echo substr($Desc, 0, 40); ?>...<a href="#" id="show_more">show more</a></p>

                                        <p id="about_desc" style="font-size:12px;display: none;"><br><?php echo $Desc; ?>...<a href="#" id="less">less</a></p>

                                    <?php } else { ?>

                                        <p style="font-size:12px;"><br><?php echo $Desc; ?></p>

                                    <?php } ?>

                                    <script>

                                        $('#show_more').click(function () {

                                            $('#mob').css('max-height', 'unset');

                                            $('#about_desc').slideDown('slow');

                                            $('#short').hide();

                                        });

                                        $('#less').click(function () {

                                            $('#mob').css('max-height', '500px');

                                            $('#about_desc').slideUp('slow');

                                            $('#short').show();

                                        });

                                    </script>

                                </div>

                                <div class="col-xs-12" id="web-des">

                                    <?php
                                    $len1 = strlen($Desc);

                                    if ($Desc != '' && $len1 > 140) {
                                        ?>



                                        <p style="font-size:12px;" id="short1"><br><?php echo substr($Desc, 0, 140); ?>...<a href="#" id="show_more1">show more</a></p>

                                        <p id="about_desc1" style="font-size:12px;display: none;"><br><?php echo $Desc; ?>...<a href="#" id="less1">less</a></p>			

                                    <?php } else { ?>

                                        <p style="font-size:12px;"><br><?php echo $Desc; ?></p>

                                    <?php } ?>

                                </div>			

                                <script>

                                    $('#show_more1').click(function () {

                                        $('#mob').css('max-height', 'unset');

                                        $('#about_desc1').slideDown('slow');

                                        $('#short1').hide();

                                    });

                                    $('#less1').click(function () {

                                        $('#mob').css('max-height', '500px');

                                        $('#about_desc1').slideUp('slow');

                                        $('#short1').show();

                                    });

                                </script>		



                            </div>

                            <div class="row categories">

                                <div class="col-xs-6">

                                    <a href="<?php echo base_url('Video_curl/comments_donors/' . $Video_ID . '/' . $Video_ID . "/comments"); ?>" style="display: inline-block;" class="btn-cmt text-center">

                                        <div class="col-xs-3">

                                            <svg version="1.1" id="cmt" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"

                                                 width="25px" height="25px" viewBox="0 0 18 18" style="enable-background:new 0 0 18 18;" xml:space="preserve">

                                            <style type="text/css">

                                                #cmt .st0{fill:#FFFFFF;}

                                            </style>

                                            <path class="st0" d="M10.8,10.7H6.9c-0.2,0-0.3,0.1-0.3,0.3s0.1,0.3,0.3,0.3h3.9c0.2,0,0.3-0.1,0.3-0.3C11.1,10.9,11,10.7,10.8,10.7

                                                  L10.8,10.7z"/>

                                            <path class="st0" d="M3,9.4h7.8c0.2,0,0.3-0.1,0.3-0.3S11,8.8,10.8,8.8H3C2.8,8.8,2.7,9,2.7,9.1C2.7,9.3,2.8,9.4,3,9.4L3,9.4z"/>

                                            <path class="st0" d="M3,7.6h7.8c0.2,0,0.3-0.1,0.3-0.3c0-0.1-0.1-0.3-0.3-0.3H3c-0.2,0-0.3,0.2-0.3,0.3C2.7,7.5,2.8,7.6,3,7.6L3,7.6

                                                  z"/>

                                            <path class="st0" d="M16.2,0.6L6,0.5c-1,0-1.8,0.8-1.8,1.9v1.5H1.8C0.8,4,0,4.8,0,5.7v6.5c0,1,0.8,1.9,1.8,1.9h1.8v3.1

                                                  c0,0.1,0.1,0.2,0.2,0.3h0.1c0.1,0,0.2,0,0.2-0.1L7,14.2h5c1,0,1.8-0.8,1.8-1.9l0,0l1.6,1.8c0.1,0.1,0.1,0.1,0.2,0.1h0.1

                                                  c0.1,0,0.2-0.2,0.2-0.3v-3.1h0.3c1,0,1.8-0.8,1.8-1.9V2.3C18,1.4,17.2,0.6,16.2,0.6L16.2,0.6z M13.2,12.3c0,0.7-0.5,1.2-1.2,1.2H6.9

                                                  c-0.1,0-0.2,0-0.2,0.1l-2.5,2.8v-2.6c0-0.2-0.1-0.3-0.3-0.3H1.8c-0.6,0-1.2-0.5-1.2-1.2V5.7c0-0.7,0.5-1.2,1.2-1.2h2.7H12

                                                  c0.7,0,1.2,0.5,1.2,1.2V12.3z M17.4,8.9c0,0.7-0.5,1.2-1.2,1.2h-0.6c-0.2,0-0.3,0.1-0.3,0.3V13l-1.5-1.6V5.7c0-1-0.8-1.9-1.8-1.9

                                                  H4.8V2.3c0-0.7,0.5-1.2,1.2-1.2h10.2l0,0c0.7,0,1.2,0.5,1.2,1.2L17.4,8.9L17.4,8.9z"/>

                                            </svg>

                                        </div>

                                        <div class="col-xs-8"><p style="padding-top: 5px;">Comments</p></div>







        <!--<img src="<?php echo base_url(); ?>assets/images/comments.png"><span>&nbsp;&nbsp;Comments</span>-->

                                    </a>

                                </div>

                                <div class="col-xs-6">

                                    <a href="<?php echo base_url('Video_curl/comments_donors/' . $Video_ID . '/' . $Video_ID . "/donors"); ?>" style="display: inline-block;" class="btn-cmt text-center">

                                        <div class="col-xs-3">

                                            <svg version="1.1" id="donor-list" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"

                                                 width="25px" height="25px" viewBox="0 0 18 18" style="enable-background:new 0 0 18 18;" xml:space="preserve">

                                            <style type="text/css">

                                                #donor-list .st0{fill:#FFFFFF;}

                                            </style>

                                            <g>

                                            <path class="st0" d="M5.8,8.7c0.2,0,0.4-0.2,0.4-0.4V7.4c0-0.1,0-0.2,0.1-0.2C7.1,6.5,7.9,6.1,8.1,6C8.2,6,8.3,5.8,8.3,5.6V4.4

                                                  c0-0.1-0.1-0.2-0.2-0.3C8.1,4,8,4,8,3.9V2.6c0-0.5,0.4-0.8,0.8-0.8h0.3c0.5,0,0.8,0.4,0.8,0.8v1.3C10,4,9.9,4,9.9,4.1

                                                  C9.8,4.1,9.7,4.2,9.7,4.4v1.3C9.7,5.8,9.8,6,9.9,6c0.2,0.1,1,0.5,1.8,1.2c0.1,0.1,0.1,0.1,0.1,0.2v0.9c0,0.2,0.2,0.4,0.4,0.4

                                                  c0.2,0,0.4-0.2,0.4-0.4V7.4c0-0.3-0.1-0.6-0.4-0.8c-0.7-0.6-1.4-1-1.8-1.2V4.5c0.2-0.2,0.3-0.4,0.3-0.7V2.6C10.7,1.7,10,1,9.1,1

                                                  H8.9C8,1,7.3,1.7,7.3,2.6v1.3c0,0.3,0.1,0.5,0.3,0.7v0.9C7.2,5.6,6.5,6.1,5.8,6.6C5.6,6.8,5.4,7.1,5.4,7.4v0.9

                                                  C5.4,8.5,5.6,8.7,5.8,8.7z"/>

                                            <path class="st0" d="M17.6,15c-0.7-0.6-1.4-1-1.8-1.2v-0.9c0.2-0.2,0.3-0.4,0.3-0.7v-1.3c0-0.9-0.7-1.6-1.5-1.6h-0.3

                                                  c-0.9,0-1.5,0.7-1.5,1.6v1.3c0,0.3,0.1,0.5,0.3,0.7v0.9c-0.3,0.2-1.1,0.6-1.8,1.2c-0.2,0.2-0.4,0.5-0.4,0.8v0.9

                                                  c0,0.2,0.2,0.4,0.4,0.4c0.2,0,0.4-0.2,0.4-0.4v-0.9c0-0.1,0-0.2,0.1-0.2c0.8-0.6,1.6-1.1,1.8-1.2c0.1-0.1,0.2-0.2,0.2-0.4v-1.3

                                                  c0-0.1-0.1-0.2-0.2-0.3c-0.1,0-0.1-0.1-0.1-0.2v-1.3c0-0.5,0.4-0.8,0.8-0.8h0.3c0.5,0,0.8,0.4,0.8,0.8v1.3c0,0.1,0,0.1-0.1,0.2

                                                  c-0.1,0.1-0.2,0.2-0.2,0.3V14c0,0.2,0.1,0.3,0.2,0.4c0.2,0.1,1,0.5,1.8,1.2c0.1,0.1,0.1,0.1,0.1,0.2v0.9c0,0.2,0.2,0.4,0.4,0.4

                                                  c0.2,0,0.4-0.2,0.4-0.4v-0.9C18,15.4,17.9,15.1,17.6,15z"/>

                                            <path class="st0" d="M6.7,15c-0.7-0.6-1.4-1-1.8-1.2v-0.9c0.2-0.2,0.3-0.4,0.3-0.7v-1.3c0-0.9-0.7-1.6-1.5-1.6H3.4

                                                  c-0.9,0-1.5,0.7-1.5,1.6v1.3c0,0.3,0.1,0.5,0.3,0.7v0.9C1.8,14,1.1,14.4,0.4,15C0.1,15.1,0,15.4,0,15.7v0.9C0,16.8,0.2,17,0.4,17

                                                  c0.2,0,0.4-0.2,0.4-0.4v-0.9c0-0.1,0-0.2,0.1-0.2c0.8-0.6,1.6-1.1,1.8-1.2c0.1-0.1,0.2-0.2,0.2-0.4v-1.3c0-0.1-0.1-0.2-0.2-0.3

                                                  c-0.1,0-0.1-0.1-0.1-0.2v-1.3c0-0.5,0.4-0.8,0.8-0.8h0.3c0.5,0,0.8,0.4,0.8,0.8v1.3c0,0.1,0,0.1-0.1,0.2c-0.1,0.1-0.2,0.2-0.2,0.3

                                                  V14c0,0.2,0.1,0.3,0.2,0.4c0.2,0.1,1,0.5,1.8,1.2c0.1,0.1,0.1,0.1,0.1,0.2v0.9c0,0.2,0.2,0.4,0.4,0.4c0.2,0,0.4-0.2,0.4-0.4v-0.9

                                                  C7.1,15.4,7,15.1,6.7,15z"/>

                                            <path class="st0" d="M9.4,10.6H8.6c-0.3,0-0.5-0.2-0.5-0.5c0-0.3,0.2-0.5,0.5-0.5H10c0.2,0,0.4-0.2,0.4-0.4c0-0.2-0.2-0.4-0.4-0.4

                                                  H9.4V8.3c0-0.2-0.2-0.4-0.4-0.4S8.6,8.1,8.6,8.3v0.5h0c-0.7,0-1.2,0.6-1.2,1.3c0,0.7,0.6,1.3,1.2,1.3h0.8c0.3,0,0.5,0.2,0.5,0.5

                                                  c0,0.3-0.2,0.5-0.5,0.5H8c-0.2,0-0.4,0.2-0.4,0.4c0,0.2,0.2,0.4,0.4,0.4h0.7v0.5c0,0.2,0.2,0.4,0.4,0.4c0.2,0,0.4-0.2,0.4-0.4v-0.5

                                                  h0c0.7,0,1.2-0.6,1.2-1.3C10.7,11.1,10.1,10.6,9.4,10.6z"/>

                                            </g>

                                            </svg>

                                        </div>

                                        <div class="col-xs-8"><p style="padding-top: 5px;">Donor List</p></div>





        <!--<img src="<?php echo base_url(); ?>assets/images/donors.png"><span>&nbsp;&nbsp;&nbsp;Donor List</span>-->

                                    </a>

                                </div>	

                            </div>	

                            <div class="row categories" style="">

                                <?php
                                if ($IsCampaign == 1) {
                                    ?>

                                    <div class="col-xs-6" style="margin-top: 1%;">

                                        <a href="<?php echo base_url('Video_curl/comments_donors/' . $CampaignDetID . '/' . $Video_ID . "/videolist"); ?>"  style="display: inline-block;" class="btn-cmt text-center">

                                                <!--                            <img src="<?php echo base_url(); ?>assets/images/vediolist.png"><span>&nbsp;&nbsp;Video List</span>-->

                                            <div class="col-xs-3" style="padding-left: 15px;">

                                                <svg version="1.1" id="vediolist_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"

                                                     width="25px" height="25px" viewBox="0 0 18 18" style="enable-background:new 0 0 18 18;" xml:space="preserve">

                                                <style type="text/css">

                                                    #vediolist_1 .st0{clip-path:url(#SVGID_2_);fill:#0B050C;}

                                                    #vediolist_1 .st1{fill:#0B050C;}

                                                    #vediolist_1 .st2{fill:#FFFFFF;}

                                                </style>

                                                <g>

                                                <path class="st2" d="M8.7,4.1h1.7c0.2,0,0.4-0.2,0.4-0.4s-0.2-0.4-0.4-0.4H8.7c-0.2,0-0.4,0.2-0.4,0.4S8.5,4.1,8.7,4.1z"/>

                                                <path class="st2" d="M7.6,4.1L7.6,4.1C7.9,4.1,8,3.9,8,3.7S7.9,3.4,7.7,3.4H7.6c-0.2,0-0.4,0.2-0.4,0.4S7.4,4.1,7.6,4.1z"/>

                                                <path class="st2" d="M17.6,0h-2.7c-0.2,0-0.4,0.2-0.4,0.4v0.2H3.4V0.4C3.4,0.2,3.3,0,3.1,0H0.4C0.2,0,0,0.2,0,0.4v17.3

                                                      C0,17.8,0.2,18,0.4,18h2.7c0.2,0,0.4-0.2,0.4-0.4v-0.3h11.2v0.3c0,0.2,0.2,0.4,0.4,0.4h2.7c0.2,0,0.4-0.2,0.4-0.4V0.4

                                                      C18,0.2,17.8,0,17.6,0z M2.7,17.3h-2v-2.1h2V17.3z M2.7,14.4h-2v-2.1h2V14.4z M2.7,11.5h-2V9.4h2V11.5z M2.7,8.6h-2V6.5h2V8.6z

                                                      M2.7,5.8h-2V3.6h2V5.8z M2.7,2.9h-2V0.7h2V2.9z M14.6,3.2v2.9V9v2.9v2.9v1.8H3.4v-1.8v-2.9V9V6.1V3.2v-2h11.2V3.2z M17.3,17.3h-2

                                                      v-2.1h2V17.3z M17.3,14.4h-2v-2.1h2V14.4z M17.3,11.5h-2V9.4h2V11.5z M17.3,8.6h-2V6.5h2V8.6z M17.3,5.8h-2V3.6h2V5.8z M17.3,2.9

                                                      h-2V0.7h2V2.9z"/>

                                                <path class="st2" d="M7.6,12.4c0.2,0,0.4-0.1,0.6-0.2l3.4-2.1c0,0,0,0,0,0c0.2-0.1,0.3-0.3,0.4-0.5c0.2-0.3,0.2-0.7,0.1-1

                                                      C12.2,8.3,12,8,11.7,7.8L10,6.7c0,0,0,0,0,0l-1.7-1C8.1,5.6,7.8,5.5,7.6,5.5c-0.7,0-1.2,0.6-1.2,1.3c0,0,0,4.1,0,4.1

                                                      c0,0.3,0,0.5,0.2,0.7C6.8,12.1,7.2,12.4,7.6,12.4z"/>

                                                <path class="st2" d="M9.3,14.2H7.6c-0.2,0-0.4,0.2-0.4,0.4c0,0.2,0.2,0.4,0.4,0.4h1.7c0.2,0,0.4-0.2,0.4-0.4

                                                      C9.7,14.3,9.5,14.2,9.3,14.2z"/>

                                                <path class="st2" d="M10.4,14.2L10.4,14.2c-0.3,0-0.4,0.2-0.4,0.4c0,0.2,0.2,0.4,0.4,0.4h0.1c0.2,0,0.4-0.2,0.4-0.4

                                                      C10.7,14.3,10.6,14.2,10.4,14.2z"/>

                                                </g>

                                                </svg>



                                            </div>

                                            <div class="col-xs-8"><p style="padding-top: 5px;">Video List</p></div>

                                        </a>

                                    </div>

                                    <div class="col-xs-6" style="margin-top: 1%;">

                                                <!--                        <a href="<?php echo base_url('Video_curl/comments_donors/' . $CampaignDetID . '/' . $Video_ID . "/activity"); ?>"  style="display: inline-block;" class="btn-cmt text-center">

                                                                        <img src="<?php echo base_url(); ?>assets/images/activityupdates.png"><span>&nbsp;Activity Updates</span>

                                                                    </a>-->

                                        <?php
                                        //echo base_url('Video_curl/comments_donors/'.$CampaignDetID.'/'.$Video_ID."/activity"); 

                                        if ($is_mobile == true) {
                                            ?>

                                            <a href="#" style="display: inline-block;height:44px;" data-toggle="modal" data-target="#getdemostream" class="btn-cmt text-center">

                                                <center><p style="margin-top: 5px;">&nbsp; Join Demostream</p></center>

                                            </a>

                                        <?php } ?>

                                    </div>	

                                    <?php
                                } else {
                                    ?>

                                    <div class="col-xs-6" style="margin-top: 1%;">

                                        <a href="<?php echo base_url('Video_curl/comments_donors/' . $CampaignDetID . '/' . $Video_ID . "/videolist"); ?>" style="display: inline-block;" class="btn-cmt text-center">



                                            <div class="col-xs-3" style="padding-left: 15px;">

                                                <svg version="1.1" id="vediolist_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"

                                                     width="25px" height="25px" viewBox="0 0 18 18" style="enable-background:new 0 0 18 18;" xml:space="preserve">

                                                <style type="text/css">

                                                    #vediolist_1 .st0{clip-path:url(#SVGID_2_);fill:#0B050C;}

                                                    #vediolist_1 .st1{fill:#0B050C;}

                                                    #vediolist_1 .st2{fill:#FFFFFF;}

                                                </style>

                                                <g>

                                                <path class="st2" d="M8.7,4.1h1.7c0.2,0,0.4-0.2,0.4-0.4s-0.2-0.4-0.4-0.4H8.7c-0.2,0-0.4,0.2-0.4,0.4S8.5,4.1,8.7,4.1z"/>

                                                <path class="st2" d="M7.6,4.1L7.6,4.1C7.9,4.1,8,3.9,8,3.7S7.9,3.4,7.7,3.4H7.6c-0.2,0-0.4,0.2-0.4,0.4S7.4,4.1,7.6,4.1z"/>

                                                <path class="st2" d="M17.6,0h-2.7c-0.2,0-0.4,0.2-0.4,0.4v0.2H3.4V0.4C3.4,0.2,3.3,0,3.1,0H0.4C0.2,0,0,0.2,0,0.4v17.3

                                                      C0,17.8,0.2,18,0.4,18h2.7c0.2,0,0.4-0.2,0.4-0.4v-0.3h11.2v0.3c0,0.2,0.2,0.4,0.4,0.4h2.7c0.2,0,0.4-0.2,0.4-0.4V0.4

                                                      C18,0.2,17.8,0,17.6,0z M2.7,17.3h-2v-2.1h2V17.3z M2.7,14.4h-2v-2.1h2V14.4z M2.7,11.5h-2V9.4h2V11.5z M2.7,8.6h-2V6.5h2V8.6z

                                                      M2.7,5.8h-2V3.6h2V5.8z M2.7,2.9h-2V0.7h2V2.9z M14.6,3.2v2.9V9v2.9v2.9v1.8H3.4v-1.8v-2.9V9V6.1V3.2v-2h11.2V3.2z M17.3,17.3h-2

                                                      v-2.1h2V17.3z M17.3,14.4h-2v-2.1h2V14.4z M17.3,11.5h-2V9.4h2V11.5z M17.3,8.6h-2V6.5h2V8.6z M17.3,5.8h-2V3.6h2V5.8z M17.3,2.9

                                                      h-2V0.7h2V2.9z"/>

                                                <path class="st2" d="M7.6,12.4c0.2,0,0.4-0.1,0.6-0.2l3.4-2.1c0,0,0,0,0,0c0.2-0.1,0.3-0.3,0.4-0.5c0.2-0.3,0.2-0.7,0.1-1

                                                      C12.2,8.3,12,8,11.7,7.8L10,6.7c0,0,0,0,0,0l-1.7-1C8.1,5.6,7.8,5.5,7.6,5.5c-0.7,0-1.2,0.6-1.2,1.3c0,0,0,4.1,0,4.1

                                                      c0,0.3,0,0.5,0.2,0.7C6.8,12.1,7.2,12.4,7.6,12.4z"/>

                                                <path class="st2" d="M9.3,14.2H7.6c-0.2,0-0.4,0.2-0.4,0.4c0,0.2,0.2,0.4,0.4,0.4h1.7c0.2,0,0.4-0.2,0.4-0.4

                                                      C9.7,14.3,9.5,14.2,9.3,14.2z"/>

                                                <path class="st2" d="M10.4,14.2L10.4,14.2c-0.3,0-0.4,0.2-0.4,0.4c0,0.2,0.2,0.4,0.4,0.4h0.1c0.2,0,0.4-0.2,0.4-0.4

                                                      C10.7,14.3,10.6,14.2,10.4,14.2z"/>

                                                </g>

                                                </svg>



                                            </div>

                                            <div class="col-xs-8"><p style="padding-top: 5px;">Video List</p></div>

                                                                        <!--<img src="<?php echo base_url(); ?>assets/images/vediolist.png">-->



                                        </a>

                                    </div>

                                    <div class="col-xs-6" style="margin-top: 1%;">

                                        <?php
                                        //echo base_url('Video_curl/comments_donors/'.$CampaignDetID.'/'.$Video_ID."/activity"); 

                                        if ($is_mobile == true) {
                                            ?>

                                            <a href="#" style="display: inline-block;height:44px;" data-toggle="modal" data-target="#getdemostream" class="btn-cmt text-center">

                                                <center><p style="margin-top: 5px;">&nbsp; Join Demostream</p></center>

                                            </a>

                                        <?php } ?>

                                    </div>		

                                    <?php
                                }
                                ?>



                            </div>



                            </div> 



                            </div>



                            <div class="row" style="padding:0px 6% 5% 5%;background-color: #fff;display: none;" id="mobile-banner-div">	

                                <div class="col-md-offset-0 col-md-4 col-xs-12" style="padding: 0px 0px;">		

                                    <div id="myCarousel" class="carousel slide" data-ride="carousel">

                                        <?php
                                        $image = array(
                                            array(base_url() . 'assets/images/banner/Samsung1ads.jpg', 'http://www.samsung.com/us/'),
                                            array(base_url() . 'assets/images/banner/Samsung2ads.jpg', 'http://www.samsung.com/us/'),
                                            array(base_url() . 'assets/images/banner/Vans1ads.jpg', 'http://www.vans.co.in/product/'),
                                            array(base_url() . 'assets/images/banner/Vans2ads.jpg', 'http://www.vans.co.in/product/'),
                                            array(base_url() . 'assets/images/banner/Vans3ads.jpg', 'http://www.vans.co.in/product/'),
                                            array(base_url() . 'assets/images/banner/Vans4ads.jpg', 'http://www.vans.co.in/product/'),
                                            array(base_url() . 'assets/images/banner/Wizpak1ads.jpg', 'https://wizpaks.com/'),
                                            array(base_url() . 'assets/images/banner/Wizpak2ads.jpg', 'https://wizpaks.com/')
                                        );
                                        ?>	

                                        <!-- Indicators -->

                                        <ol class="carousel-indicators">

                                            <?php
                                            for ($i = 1; $i < sizeof($image); $i++) {
                                                ?>        

                                                <li data-target="#myCarousel" data-slide-to="" class="active" style="display: none;"></li>	

                                                <li data-target="#myCarousel" data-slide-to="<?php echo $i; ?>" style="display: none;"></li>

                                            <?php } ?>			

                                        </ol>



                                        <!-- Wrapper for slides -->

                                        <div class="carousel-inner" style="height: 170px;">	

                                            <div class="item active">

                                                <a href="http://www.samsung.com/us/" target="_blank"><img src="<?php echo base_url(); ?>assets/images/banner/Samsung1ads.jpg"/></a>

                                            </div>

                                            <?php
                                            for ($i = 1; $i < sizeof($image); $i++) {
                                                ?>   

                                                <div class="item">

                                                    <a href="<?php echo $image[$i][1]; ?>" target="_blank"><img src="<?php echo $image[$i][0]; ?>"/></a>

                                                </div>

                                            <?php } ?>	

                                            <!-- Left and right controls-->

                                            <a class="left carousel-control" href="#myCarousel" data-slide="prev">

                                                <span class="glyphicon glyphicon-chevron-left"></span>

                                                <span class="sr-only">Previous</span>

                                            </a>

                                            <a class="right carousel-control" href="#myCarousel" data-slide="next">

                                                <span class="glyphicon glyphicon-chevron-right"></span>

                                                <span class="sr-only">Next</span>

                                            </a>



                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div id="loading" style="display: none;background-color: whitesmoke;padding: 5px 70px;position: absolute;top: 50%;left: 50%;border-radius: 1em;border-color: currentColor;opacity: 3;z-index: 1111;">

                                <i class="fa fa-spinner fa-spin" style="font-size: 30px;"></i><br>

                                <p>Loading...</p>

                            </div>

                            <div class="modal fade" id="share-popup" role="dialog">

                                <div class="modal-dialog">



                                    <!-- Modal content-->

                                    <div class="modal-content">

                                        <div class="modal-header"></div>

                                        <div class="row modal-body text-center">

                                            <a style="color: white;" href="<?php
                                            if ($CanShare == 1) {

                                                echo share_url('facebook', array('url' => $shareurl, 'text' => $CampaignDesc));
                                            }
                                            ?>"

                                               onclick="<?php if ($CanShare == 1) { ?>

                                            window.open('<?php echo share_url('facebook', array('url' => $shareurl, 'text' => $CampaignDesc)); ?>', 'newwindow', 'width=300,height=250');

                                            return false;<?php } else { ?> return msg(<?php echo $CanShare; ?>, 'share');<?php } ?>">

                                                <img src="<?php echo base_url() . 'assets/images/Share-on-Facebook.png'; ?>" class="col-md-4 img-class"/>

                                            </a>



                                            <?php
                                            $title = $this->session->userdata['title'];

                                            $title = str_replace('"', ' ', $title);

                                            $twiturl = "https://twitter.com/intent/tweet?text=" . $title . "&image=" . $wrapper_path . "&url=" . $shareurl;
                                            ?>

                                            <a style="color: white;" href="<?php
                                            if ($CanShare == 1) {

                                                echo $twiturl;
                                            }
                                            ?>"

                                               onclick="<?php if ($CanShare == 1) { ?>

                                            window.open('<?php echo $twiturl; ?>', 'newwindow', 'width=300,height=250');

                                            return false;<?php } else { ?> return msg(<?php echo $CanShare; ?>, 'share');<?php } ?>">

                                                <img src="<?php echo base_url() . 'assets/images/share-twitter.png'; ?>" class="col-md-4 img-class"/>

                                            </a>



                                        </div>

                                        <div class="modal-footer">

                                            <button type="button" class="btn btn-cmt text-center popup" style="" data-dismiss="modal">cancel</button>

                                        </div>

                                    </div>



                                </div>

                            </div>



                            <!--Powered By Demostream-->

                            <div class="modal fade" id="poweredBy" role="dialog">

                                <div class="modal-dialog">



                                    <!-- Modal content-->

                                    <div class="modal-content">

                                        <div class="modal-header"></div>

                                        <div class="modal-body text-center">

                                            <?php
                                            $powered = '<div style="width: 40%"><h4>' . $this->session->userdata['title'] . '</h4><img src="' . $wrapper_path . '" height="100" width="200"/><p style="text-align: justify;">' . $Desc . '</p></div>';
                                            ?>

                                            <div class="form-group">

                                                <textarea class="form-control" rows="10" style="color: black;"><?php echo $powered; ?></textarea>

                                            </div>

                                        </div>

                                        <div class="modal-footer">

                                            <button type="button" class="btn btn-cmt text-center popup" style="" data-dismiss="modal">close</button>

                                        </div>

                                    </div>



                                </div>

                            </div>

                            </div>



                            <script>



                                    function msg(can, data) {



                                        if (can == 0) {

                                            alert('Owner has not given permission to ' + data);

                                        } else {

                                            IS_IPAD = navigator.userAgent.match(/iPad/i) != null;

                                            IS_IPHONE = (navigator.userAgent.match(/iPhone/i) != null) || (navigator.userAgent.match(/iPod/i) != null);

                                            //alert(navigator.userAgent);

                                            if (IS_IPAD || IS_IPHONE) {



                                                $('#hover-buy').on('click touchend', function () {

                                                    var link = $(this).attr('href');

                                                    location.replace(link); // opens in new window as requested

                                                    return false; // prevent anchor click    

                                                });

                                                $('#hover-donate').on('click touchend', function () {

                                                    var link = $(this).attr('href');

                                                    location.replace(link); // opens in new window as requested

                                                    return false; // prevent anchor click    

                                                });

                                            }

                                        }

                                    }



                                    $(document).ready(function () {



                                        var video_url = '<?php echo base_url(); ?>video/getvideo.php?videoid=<?php echo $video_path; ?>&type=Download';

<?php if ($video_path != 'null' && $video_path != '' && $vimeo == '' && $ext == '' && $IsPayment == 0) { ?>

                                            $.ajax({

                                                type: "GET",
                                                url: video_url,
                                                datatype: 'JSON',
                                                success: function (result) {
                                                    console.log(result);

                                                    //window.open(result,'_blank');



                                                    $('#hover-down').attr('href', result);

                                                }

                                            });

<?php }if ($ext != '' && $IsPayment == 0) { ?>

                                            $('#hover-down').attr('href', '<?php echo $video_path; ?>');

<?php } ?>

                                    });



                            </script>

                            <?php

                            function convertVimeo($string) {

                                return preg_replace('#https?://(www\.)?vimeo\.com/(\d+)#', '//player.vimeo.com/video/$2', $string);
                            }

                            function convertYoutube($string) {



                                return preg_replace(
                                        "/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i", "https://www.youtube.com/embed/$2", $string
                                );
                            }
                            ?>

