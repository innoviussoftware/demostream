<?php
//echo '<pre>';
//print_r($donor_deatils);	
//print_r($video_deatils);exit;
$iscampaign = $this->session->userdata['iscampaign'];

$size = sizeof($comments_deatils['campaigncomments']);
$size_donor = sizeof($donor_deatils['donationdetails']);
$size_video = sizeof($video_deatils['videodetails']);
$size_act = sizeof($activity_deatils['campaignactivityupdates']);
$Video_ID = $this->session->userdata['Video_ID'];
?>		
<div class="container middle paper-craft-middle">
    <div class="row video-img">
    </div>
    <div class="row">
        <div class="col-md-offset-0 col-md-4 col-xs-12">
            <div class="row back-row" style="background-color: #8B008B;color: white;">
                <div class="col-xs-10" style="font-size: 14px;text-align: left;">
                    <a href="#" onclick="history.back();" style="color:#fff;"><span class="fa fa-arrow-left"></span></a>&nbsp; <b><?php echo $this->session->userdata['title']; ?></b>
                </div>
                <div class="col-xs-2" style="font-size: 18px;text-align: right;">
                    <a href="<?php
                    if ($iscampaign == 1) {
                        echo base_url('Video_curl/campaign/' . $Video_ID);
                    } else {
                        echo base_url('Video_curl/video/' . $Video_ID);
                    }
                    ?>" style="color:#fff;"><span class="fa fa-home"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-offset-0 col-md-4 col-xs-12" style="overflow-y: scroll;min-height: 450px;max-height: 450px;background-color: whitesmoke;padding-right: 0px;padding-left: 0px;">
            <ul class="cmt nav comment-tabs" style="background-color: white;font-size: 12px;">
                <?php if ($this->session->userdata['iscampaign'] == 1) { ?>
                    <li <?php if ($this->session->userdata['active'] == 'activity') { ?> class="active" <?php } ?>>
                        <a data-toggle="tab" href="#activity_list">Activity Updates</a>
                    </li>
                <?php } ?>			
                <li <?php if ($this->session->userdata['active'] == 'donors') { ?> class="active" <?php } ?>>
                    <a data-toggle="tab" href="#donors">Donors</a>
                </li>
                <li <?php if ($this->session->userdata['active'] == 'comments') { ?> class="active" <?php } ?>>
                    <a data-toggle="tab" href="#comments">Comments</a>
                </li>	
                <?php //if($this->session->userdata['iscampaign'] == 1){   ?>
                <li <?php if ($this->session->userdata['active'] == 'videolist') { ?> class="active" <?php } ?>>
                    <a data-toggle="tab" href="#video_list">Video List</a>
                </li>	
                <?php //}  ?>
            </ul>	
            <div class="tab-content" style="color: black;min-height: 400px;">
                <div id="activity_list" class="tab-pane fade <?php if ($this->session->userdata['active'] == 'activity') { ?> in active <?php } ?>" style="margin-bottom:5px;">
                    <div class="col-md-12 col-xs-12">								
                        <ul class="list-group">  
                            <?php
                            if ($this->session->userdata['iscampaign'] == 1) {
                                $i = 0;
                                if ($size_act > 0) {
                                    for ($i == 0; $i < $size_act; $i++) {
                                        $act_data = $activity_deatils['campaignactivityupdates'];

                                        $img = $act_data[$i]['ActivityImgPath'];
                                        $updatemsg = $act_data[$i]['UpdateMessage'];
                                        $create_date = $act_data[$i]['CreatedOnMobile'];
                                        $create_date = date('Y-m-d', strtotime($create_date));
                                        $current_date = date('Y-m-d');

                                        $date1 = date_create($create_date);
                                        $date2 = date_create($current_date);
                                        $diff = date_diff($date1, $date2);
                                        $year = $diff->format("%y");
                                        $month = $diff->format("%m");
                                        if ($year > 0) {
                                            $d = $diff->format("%y year %m month %d days");
                                        } elseif ($month > 0) {
                                            $d = $diff->format("%m Month %d days");
                                        } else {
                                            $d = $diff->format("%d days");
                                        }
                                        if ($img == '') {
                                            $img = base_url() . 'assets/images/noimage.png';
                                        }
                                        ?>
                                        <li class="list-group-item justify-content-between" style="margin-top: 3px;margin-bottom: 0px;">
                                            <div class="row">
                                                <div class="col-xs-2">
                                                    <img class="comment-img" src="<?php echo $img; ?>"/>										
                                                </div>
                                                <div class="col-md-offset-1 col-xs-9">
                                                    <h5><?php echo $updatemsg; ?></h5><br><br>
                                                    <p style="float: right;font-size:14px;"><?php echo $d; ?></p>
                                                </div>
                                            </div>

                                        </li>
                                        <?php
                                    }
                                    ?>										
                                </ul>  
                                <?php
                            } else {
                                echo '<span class="text-center" style="font-size: 12px;">No Activity Updates as of Yet</span>';
                            }
                        }
                        ?>						
                    </div>
                </div>
                <div id="comments" class="tab-pane fade  <?php if ($this->session->userdata['active'] == 'comments') { ?> in active <?php } ?>" style="margin-bottom:5px;">

                    <div class="col-md-12 col-xs-12">	
                        <?php if ($this->session->userdata('login_userdata')) { ?>
                            <a class="btn btn-default" data-toggle="modal" data-target="#comments-form" style="z-index: 1;background-color: #8B008B;color: white;float: right;padding: 5px 8px;border-radius: 5em;">
                                <i class="fa fa-plus" style="font-size: larger;float: right;bottom: 5%;"></i>
                            </a>
                            <?php
                        } else {
                            ?>
                            <a class="btn btn-default" onclick="location.replace('<?php echo base_url(); ?>Hauth/users');" style="z-index: 1;background-color: #8B008B;color: white;float: right;padding: 5px 8px;border-radius: 5em;">
                                <i class="fa fa-plus" style="font-size: larger;float: right;bottom: 5%;"></i>
                            </a>
                            <?php
                        }
                        ?>
                        <ul class="list-group" style="margin-top: 10%;">  
                            <?php
                            $i = 0;
                            if ($size > 0) {
                                for ($i == 0; $i < $size; $i++) {
                                    $cmt_data = $comments_deatils['campaigncomments'];

                                    $profile_pic = $cmt_data[$i]['ProfilePICPath'];
                                    $name = $cmt_data[$i]['FirstName'] . " " . $cmt_data[$i]['LastName'];
                                    $comment_txt = $cmt_data[$i]['Comments'];
                                    $create_date = $cmt_data[$i]['CreatedOnMobile'];
                                    $create_date = date('Y-m-d', strtotime($create_date));
                                    $current_date = date('Y-m-d');

                                    $date1 = date_create($create_date);
                                    $date2 = date_create($current_date);
                                    $diff = date_diff($date1, $date2);
                                    $year = $diff->format("%y");
                                    $month = $diff->format("%m");
                                    if ($year > 0) {
                                        $d = $diff->format("%y year %m month %d days");
                                    } elseif ($month > 0) {
                                        $d = $diff->format("%m Month %d days");
                                    } else {
                                        $d = $diff->format("%d days");
                                    }

                                    $deleted = $cmt_data[$i]['IsDeleted'];

                                    if ($profile_pic == '') {
                                        $profile_pic = base_url() . 'assets/images/unknown.jpg';
                                    }if ($cmt_data[$i]['FirstName'] == '' && $cmt_data[$i]['LastName'] == '') {
                                        $name = 'Unknown User';
                                    }

                                    if ($deleted == 0) {
                                        ?>
                                        <li class="list-group-item justify-content-between" style="margin-top: 3px;margin-bottom: 0px;">
                                            <div class="row">
                                                <div class="col-xs-2">
                                                    <img class="comment-img" src="<?php echo $profile_pic; ?>"/>										
                                                </div>
                                                <div class="col-md-offset-1 col-xs-9">
                                                    <b style="font-size: 13px;color: #000 !important;"><?php echo $name; ?></b><br>
                                                    <p style="font-size: 12px;color: #000 !important;"><?php echo $comment_txt; ?></p>
                                                    <p style="float: right;font-size:10px;"><?php echo $d; ?></p>
                                                </div>
                                            </div>

                                        </li>
                                        <?php
                                    }
                                }
                                ?>                                  
                            </ul>   
                            <?php
                        } else {
                            echo '<span class="text-center" style="font-size: 12px;">No Comments as of Yet</span>';
                        }
                        ?>										
                    </div>
                </div>
                <div id="donors" class="tab-pane fade <?php if ($this->session->userdata['active'] == 'donors') { ?> in active <?php } ?>"  style="margin-bottom:5px;">
                    <div class="col-md-12 col-xs-12">
                        <ul class="list-group">
                            <?php
                            $i = 0;
                            if ($size_donor > 0) {
                                for ($i == 0; $i < $size_donor; $i++) {
                                    $donor_data = $donor_deatils['donationdetails'];

                                    $profile_pic = $donor_data[$i]['ProfilePICPath'];
                                    $name = $donor_data[$i]['PPUserName'];
                                    $amount = $donor_data[$i]['DonationAmount'];
                                    $donate_date = $donor_data[$i]['DonatedOn'];
                                    $donate_date = date('Y-m-d', strtotime($donate_date));
                                    $current_date = date('Y-m-d');

                                    $date1 = date_create($donate_date);
                                    $date2 = date_create($current_date);
                                    $diff = date_diff($date1, $date2);
                                    $year = $diff->format("%y");
                                    $month = $diff->format("%m");

                                    if ($year > 0) {
                                        $d = $diff->format("%y year %m month %d days");
                                    } elseif ($month > 0) {
                                        $d = $diff->format("%m Month %d days");
                                    } else {
                                        $d = $diff->format("%d days");
                                    }
                                    if ($profile_pic == '') {
                                        $profile_pic = base_url() . 'assets/images/unknown.jpg';
                                    }
                                    $deleted = $donor_data[$i]['IsDeleted'];
                                    if ($deleted == 0) {
                                        ?>
                                        <li class="list-group-item justify-content-between" style="margin-top: 3px;margin-bottom: 0px;">
                                            <div class="row">
                                                <div class="col-xs-2">
                                                    <img class="comment-img" src="<?php echo $profile_pic; ?>"/>										
                                                </div>
                                                <div class="col-md-offset-1 col-xs-9">
                                                    <h5><?php echo $name; ?></h5><br>
                                                    <p><?php echo "$" . $amount; ?></p>
                                                    <p style="float: right;font-size:14px;"><?php echo $d; ?></p>
                                                </div>
                                            </div>
                                        </li>
                                        <?php
                                    }
                                }
                                ?>
                            </ul>     
                            <?php
                        } else {
                            echo '<span class="text-center" style="font-size: 12px;">No Donors as of Yet</span>';
                        }
                        ?>	       
                    </div>
                </div>	
                <div id="video_list" class="tab-pane fade  <?php if ($this->session->userdata['active'] == 'videolist') { ?> in active <?php } ?>" style="margin-bottom:5px;">
                    <div class="col-md-12 col-xs-12">								
                        <ul class="list-group">  
                            <?php
                            //if($this->session->userdata['iscampaign'] == 1){ 
                            $i = 0;
                            if ($size_video > 0) {
                                for ($i == 0; $i < $size_video; $i++) {
                                    $list_data = $video_deatils['videodetails'];

                                    $profile_pic = $list_data[$i]['WrapperPath'];
                                    $title = $list_data[$i]['Title'];
                                    $name = $list_data[$i]['Description'];
                                    $des = substr($name, 0, 60);
                                    $video_id = $list_data[$i]['VideoID'];

                                    if ($deleted == 0) {
                                        ?>
                                        <a style="color: #000 !important;" href="<?php echo base_url('Video_curl/video/' . $video_id); ?>">
                                            <li class="list-group-item justify-content-between" style="margin-top: 3px;margin-bottom: 0px;">
                                                <div class="row">
                                                    <div class="col-xs-2">
                                                        <a style="color: #000 !important;" href="<?php echo base_url('Video_curl/video/' . $video_id); ?>">
                                                            <img class="comment-img" src="<?php echo $profile_pic; ?>"/>
                                                        </a>
                                                    </div>
                                                    <a style="font-size: 13px;color: #000 !important;" href="<?php echo base_url('Video_curl/video/' . $video_id); ?>">
                                                        <div class="col-md-offset-1 col-xs-9">
                                                            <b><?php echo $title; ?></b>
                                                            <p style="font-size: 11px;"><?php
                                                                if ($des != '') {
                                                                    echo $des . '...';
                                                                }
                                                                ?></p>
                                                        </div>
                                                    </a>
                                                </div>

                                            </li>
                                        </a>
                                        <?php
                                    }
                                }
                                ?>                                  
                            </ul>   
                            <?php
                        } else {
                            echo '<span class="text-center" style="font-size: 12px;">No Videos as of Yet</span>';
                        }
                        // }										
                        ?>	                          
                    </div>
                </div>
            </div>



            <div class="modal fade" id="comments-form" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <form action="<?php echo base_url() . 'Video_curl/comments'; ?>" method="post">
                            <div class="modal-header" style="background-color: #85298c;color: #fff;font-weight: normal !important;">
                                <h6 class="modal-title">Enter your comments</h6>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="video_id" value="<?php echo $Video_ID; ?>"/>
                                <textarea class="" rows="2" name="comments" style="width: -webkit-fill-available;"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-cmt text-center popup" style="float: left;" data-dismiss="modal">close</button>
                                <input type="submit" class="btn btn-cmt text-center popup" name="submit">
                            </div>
                        </form>
                    </div>

                </div>
            </div>


        </div>				   
    </div>

</div>