<?php
$login_userdata = $this->session->userdata('login_userdata');
$UserID = $login_userdata['UserID'];
?>
<div class="content-wrapper">    
    <section class="content-header">
        <h1>
            Video Sync
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Video Sync</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-sm-12">
                <?php if ($this->session->flashdata("success")) { ?>
                    <div class="alert alert-success alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <span class="text-center"><?php echo $this->session->flashdata('success'); ?></span>
                    </div>
                <?php }if ($this->session->flashdata("danger")) { ?>
                    <div class="alert alert-danger alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <span class="text-center"><?php echo $this->session->flashdata('danger'); ?></span>
                    </div>
                <?php } ?>
            </div>
            <div class="col-md-6">
                <div class="nav-tabs-custom">

                    <ul class="nav nav-tabs">
                        <li <?php if (isset($delete_detail)) { ?> class="deactive" <?php } else { ?> class="active" <?php } ?>><a onclick="return tab_pannel();" href="#up_video" data-toggle="tab">Upload Video</a></li>

                        <li <?php if (isset($delete_detail)) { ?>class="active"<?php } ?>><a onclick="return tab_pannel();" href="#video_detail" data-toggle="tab">Video Details</a></li>

                        <li><a onclick="return tab_pannel();" href="#activity" data-toggle="tab">Activity Updates</a></li>
                        <li><a href="#ning" data-toggle="tab">NING Platform</a></li>

                    </ul>

                    <div class="tab-content" id="video">    

                        <div class="tab-pane" id="ning" style="padding-bottom:  15%;">  
                            <div class="" style="text-align:  right;">
                                <a href="<?php echo base_url('admin/Video_Sync/paywall_network_admin_url'); ?>" style="font-size: 1.4em;color: rgb(57,194,215) !important;text-decoration: underline;" target="_blank">
                                    Click here to login in your NING admin platform
                                </a><br/>
                            </div>
                            <?php
                            $user = $this->session->userdata('login_userdata');
                            $UserID = $user['UserID'];

                            // if(isset($user['NetworkKey']) && $UserID != '' && $user['NetworkKey'] != ''){
                            $network_key = @$user['NetworkKey'];
                            $product_key = @$user['ProductKey'];
                            $paywall_id = @$user['PaywallId'];
                            ?>
                            <form action="<?php echo base_url('admin/Video_Sync/donate_paywall'); ?>" method="post">
                                <div class="row">
                                    <div class="col-xs-12 col-md-12">
                                        <div class="form-group">
                                            <input type="hidden" name="user_id" value="<?php echo $UserID; ?>" />
                                            <input type="hidden" name="network_key" value="<?php echo $network_key; ?>" />
                                            <label style="background:#dedede;width:100%;padding:2%;color: #000 !important;">Video Donate Paywall</label>
                                            <select class="form-control" id="donate_paywall" required="" name="donate_paywall" >
                                                <!--PAYWALL LIST WILL SHOWN HERE BY AJAX-->                                       
                                                <option value="">Select Paywall</option>
                                            </select>
                                            <b style="position:  relative;top: 7px;">Note: This paywall payment is for users to add donations</b>
                                            <a style="float: right;text-decoration: underline;color: rgb(57,194,215) !important;padding-top: 5px;" href="javascript:void(0);" onclick="return get_paywall_list(2);">Refresh paywall</a>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" name="submit_donate" id="submit_donate" value="Update Paywall" class="btn btn-primary"/>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <?php
                            //}
                            ?>  

                            <?php if ($UserID == 1) {
                                ?>
                                <form action="<?php echo base_url('admin/Video_Sync/update_network'); ?>" method="post">
                                    <div class="row">
                                        <div class="col-xs-12 col-md-12">
                                            <div class="form-group">
                                                <input type="hidden" name="user_id" value="<?php echo $UserID; ?>" />                                        
                                                <label style="background:#dedede;width:100%;padding:2%;color: #000 !important;">Update Your Network</label>

                                            </div>
                                            <div class="row">
                                                <div class="col-xs-12 col-md-6">
                                                    <div class="form-group">
                                                        <label>Network Key</label>
                                                        <input type="text" name="network_key" value="<?php echo $network_key != '' ? $network_key : 'demostream_test'; ?>" required="" class="form-control" />
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-md-6">
                                                    <div class="form-group">

                                                        <label>Product Key</label>
                                                        <input type="text" name="product_key" value="<?php echo $product_key != '' ? $product_key : 'Product_Donate_1_8717180'; ?>" required="" class="form-control" />
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="form-group">

                                                <label>Paywall ID</label>
                                                <input type="text" name="paywall_id" value="<?php echo $paywall_id != '' ? $paywall_id : '11E88EA2FFCD3D92995314187767603C'; ?>" required="" class="form-control" />
                                                <div class="help-block with-errors"></div>
                                            </div>

                                            <div class="form-group">
                                                <input type="submit" name="submit_network" id="submit_network" value="Update Network" class="btn btn-primary"/>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            <?php } ?>




                        </div>
                        <div class="<?php if (isset($delete_detail)) { ?>deactive<?php } else { ?>active<?php } ?> tab-pane" id="up_video">
                            <form method="post" id="add_new_videos"  style="padding: 0 15px;" class="form-horizontal" action="<?php echo base_url('admin/Video_Sync/add_new_video'); ?>" enctype="multipart/form-data" >

                                <div class="form-group">   
                                    <input type="text" name="Title" class="form-control" placeholder="Enter Video Title" required="" />
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <input type="text" id="Description" name="Description" class="form-control" placeholder="Enter Video Description" required="" />
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <input type="text" id="VideoHashTagID" name="VideoHashTagID"  class="form-control" placeholder="Enter Video Search Tag" required="" />
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <select class="form-control" id="paywall" required="" name="paywall" >
                                        <!-- PAYWALL LIST WILL SHOWN HERE BY AJAX -->
                                        <option value="">Select Paywall</option>
                                    </select>
                                    <b style="position:  relative;top: 7px;">Note: This paywall payment is for users to download video</b>
                                    <a style="float: right;text-decoration: underline;color: rgb(57,194,215) !important;padding-top: 5px;" href="javascript:void(0);" onclick="return get_paywall_list(1);">Refresh paywall</a>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <label style="background:#dedede;width:100%;padding:2%;color: #000 !important;">Upload Your File</label>
                                    <input type="file" class="form-control" id="userfile" name="userfile"/>
                                    <div id="progress-div"><div id="progress-bar"></div></div>
                                    <div id="targetLayer"></div>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <label style="background:#dedede;width:100%;padding:2%;">Upload From Online</label>
                                    <input type="text" name="url" id="url" class="form-control" onchange="return check_validate(this.value);" placeholder="Enter Video URL" />
                                    <input type="hidden" name="valid_url" value="" id="valid_url"/>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group">
                                    <input type="submit" name="submit" id="submit_video" value="SUBMIT YOUR VIDEO" class="btn btn-primary col-sm-12"/>
                                </div>
                            </form>
                        </div>

                        <div class="<?php if (isset($delete_detail)) { ?>active<?php } ?> tab-pane" id="video_detail">
                            <?php for ($r = 0; $r < sizeof($video_detail); $r++) { ?>

                                <form id="fund_form" method="post" class="form-horizontal" action="<?php echo base_url('admin/Video_Sync/update_checkbox'); ?>" style="background:#fff;border-bottom:2px solid rgb(57,194,215);">

                                    <table class="table active-table table-striped">

                                        <tr style="background:none;border-bottom:1px solid #999;">
                                            <th style="width:25%;padding:2%;">
                                                <div class="videoimg" style="width:100%;height:100px;background:url(<?php
                                                if ($video_detail[$r]['WrapperPath'] != '') {
                                                    echo $video_detail[$r]['WrapperPath'];
                                                } else {
                                                    $vid = getVideoID($video_detail[$r]['VideoPath']);
                                                    $WrapperPath = 'https://img.youtube.com/vi/' . $vid . '/0.jpg';
                                                    if ($WrapperPath == '') {
                                                        $WrapperPath = base_url() . 'assets/images/audio.gif';
                                                    }
                                                    echo $WrapperPath;
                                                }
                                                ?>);background-size:100% 100%;">

                                                    <a href="<?php echo $video_detail[$r]['VideoPath']; ?>" target="new">
                                                        <img src="<?php echo base_url(); ?>assets/images/play_icon.png" style="width:35%;height:35%;margin:33% 0 0 35%;float:left;"></a>

                                                </div>


                                            </th>
                                            <td>   
                                                <label style="margin-left:5%;"><?php echo $video_detail[$r]['Title']; ?></label>
                                                <b>
                                                    <a href="<?php echo base_url('admin/Video_Sync/edit/' . $video_detail[$r]['VideoID']); ?>">
                                                        <i class="fa fa-edit" style="float:right;margin-right:4%;color:blue;"></i>
                                                    </a>
                                                    <a onclick="return confirm('<?php echo base_url('admin/Video_Sync/delete/' . $video_detail[$r]['VideoID']); ?>', 'video');" href="#">
                                                        <i class="fa fa-trash" style="float:right;margin-right:2%;color:red;"></i>
                                                    </a>
                                                </b>
                                                <br />
                                                <h5 style="margin-left:5%;"><?php echo $video_detail[$r]['Description']; ?></h5>




                                            </td>
                                        </tr>

                                    </table><br />

                                    <table>  
                                        <tr>
                                        <input onclick="return Update1(this.value,<?php echo $video_detail[$r]['VideoID']; ?>, 'IsPublic');" type="checkbox"  id="IsPublic" value="<?php echo $video_detail[$r]['IsPublic']; ?>" style="width:5%;" <?php if ($video_detail[$r]['IsPublic'] == 1) { ?> checked="checked" <?php } ?> />&nbsp;Public

                                        <input onclick="return Update1(this.value,<?php echo $video_detail[$r]['VideoID']; ?>, 'CanDonate');" style="margin-left:6%;width:5%;" type="checkbox" id="CanDonate" value="<?php echo $video_detail[$r]['CanDonate']; ?>"  <?php if ($video_detail[$r]['CanDonate'] == 1) { ?> checked="checked" <?php } ?> />&nbsp;Donate


                                        <input onclick="return Update1(this.value,<?php echo $video_detail[$r]['VideoID']; ?>, 'CanShare');" type="checkbox" id="CanShare" style="width:5%;margin-left:9%;" value="<?php echo $video_detail[$r]['CanDonate']; ?>"  <?php if ($video_detail[$r]['CanShare'] == 1) { ?> checked="checked" <?php } ?> />&nbsp;Share
                                        </tr>
                                        <br />
                                        <tr>
                                        <input onclick="return Update1(this.value,<?php echo $video_detail[$r]['VideoID']; ?>, 'CanBuy');" style="width:5%;" type="checkbox"  id="CanBuy" value="<?php echo $video_detail[$r]['CanBuy']; ?>"  <?php if ($video_detail[$r]['CanBuy'] == 1) { ?> checked="checked" <?php } ?> />&nbsp;Buy

                                        <input onclick="return Update1(this.value,<?php echo $video_detail[$r]['VideoID']; ?>, 'CanCollaborate');" style="margin-left:9.1%;width:5%;" type="checkbox" id="CanCollaborate" value="<?php echo $video_detail[$r]['CanCollaborate']; ?>"  <?php if ($video_detail[$r]['CanCollaborate'] == 1) { ?> checked="checked" <?php } ?> />&nbsp;Download


                                        <?php
                                        $username = $this->session->userdata('admin_username');
                                        $password = $this->session->userdata('admin_password');

                                        $url = USER_AUTHEDICATE . "?Un=" . $username . "&Pwd=" . $password;
                                        $data = curl_init();
                                        curl_setopt($data, CURLOPT_URL, $url);
                                        curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
                                        curl_setopt($data, CURLOPT_PROXYPORT, 3128);
                                        curl_setopt($data, CURLOPT_SSL_VERIFYHOST, 0);
                                        curl_setopt($data, CURLOPT_SSL_VERIFYPEER, 0);
                                        $response_data = json_decode(curl_exec($data), true);
                                        $return = curl_errno($data); //returns 0 if no errors occured
                                        curl_close($data);
                                        //echo "<pre>"; print_r($response_data); exit;
                                        if ($response_data['userprofiledetails'][0]['IsAdmin'] == 1) {
                                            ?>

                                            <input onclick="return Update1(this.value,<?php echo $video_detail[$r]['VideoID']; ?>, 'IsFrontPage');" type="checkbox" id="IsFrontPage" style="width:5%;margin-left:8%;" value="<?php echo $video_detail[$r]['IsFrontPage']; ?>" <?php if ($video_detail[$r]['IsFrontPage'] == 1) { ?> checked="checked" <?php } ?> />&nbsp;Front Page

                                        <?php } ?>
                                        </tr>
                                    </table><br />

                                </form>

                            <?php } ?>
                        </div>

                        <div class="tab-pane" id="activity">

                            <form id="update_activities" method="post" class="form-horizontal" action="<?php echo base_url('admin/Video_Sync/activity_update'); ?>" enctype="multipart/form-data" >

                                <table>  
                                    <tr>
                                    <select onchange="return one_video(this.value);" name="video_id" class="form-control">
                                        <option value="">Select Video</option>
                                        <?php for ($r = 0; $r < sizeof($video_detail); $r++) { ?>
                                            <option value="<?php echo $video_detail[$r]['VideoID']; ?>"><?php echo $video_detail[$r]['Title']; ?></option>
                                        <?php } ?>
                                    </select>
                                    </tr>
                                    <br />
                                    <tr>
                                    <textarea class="form-control" placeholder="Update Message Here" name="message"></textarea>
                                    </tr>
                                    <br />
                                    <tr>
                                    <label style="background:#dedede;width:100%;padding:2%;">Upload Your File</label>
                                    <div class="panel panel-default">
                                        <!--<div class="panel-body img-file-tab">
                                            <div>
                                                <span class="btn btn-default btn-file img-select-btn">
                                                    <span>Browse</span>
                                                    <input type="file" name="userfile" id="image">
                                                </span>
                                                <span class="btn btn-default img-remove-btn">Remove</span>
                                            </div>
                                        </div>-->
                                        <input type="file" class="form-control" name="userfile"/>
                                    </div>
                                    </tr>
                                    <br />
                                    <tr>
                                    <button style="width:100%;" type="submit" name="submit" value="submit" class="btn btn-primary">Post</button>
                                    </tr><br />
                                </table>

                            </form>
                        </div>

                    </div>
                </div>
            </div>



            <div class="col-md-6" id="right_block" style="display:none;">
                <div class="nav-tabs-custom" id="ajax_return">

                </div>
                <!-- /.nav-tabs-custom -->
            </div>

            <?php $URL = @$this->session->flashdata('success_upload_video'); ?>
            <?php if (isset($URL)) { ?>
                <div class="col-md-6" id="youtube_video">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs" style="background:#ccc;">
                            <center><label style="margin:2%;font-size:120%;">Your Youtube-Video URL</label>
                                <br />
                                <a target="new" style="font-size:120%;padding:2%;" href="<?php echo $URL; ?>"><?Php echo $URL; ?></a>
                            </center><br />
                        </ul>
                        <center>
                        <!--<label>Please reset session <a href="<?php echo base_url('admin/Video_Sync/logout_youtube') ?>">Logout</a></label>==> </center>
                      </div>
                            <!-- /.nav-tabs-custom -->
                    </div>
                <?php } ?> 

            </div>

    </section>
</div>
<?php

function getVideoID($url) {
    $url_string = parse_url($url, PHP_URL_QUERY);
    parse_str($url_string, $args);
    return isset($args['v']) ? $args['v'] : false;
}
?>
<script>

    function tab_pannel()
    {
        $('#edit').hide();
        $('#right_block').hide();
    }

    function check_validate(url) {
        if (url == '') {
            $('#submit_video').prop('disabled', false);
            return false;
        } else {
            $('#submit_video').prop('disabled', true);
        }
        $.ajax({

            type: "POST",
            url: '<?php echo base_url() ?>admin/Video_Sync/check_validate',

            data: {url: url},
            success: function (result) {

                if (result == 1) {
                    $('#submit_video').prop('disabled', true);
                    alert('Please enter valid URL');
                    $('#url').val('');
                } else {
                    $('#submit_video').prop('disabled', false);
                    $('#valid_url').val(result);

                }
            }
        });
    }
    function Update1(Value, VideoID, Name) {

        $.ajax({
            type: "POST",
            url: '<?php echo base_url() ?>admin/Video_Sync/update_checkbox',

            data: {Value: Value, VideoID: VideoID, Name: Name},
            success: function (result) {
                //alert(result);
                $('#right_block').hide();
                $("#update").html(result);
            }
        });
    }

    function get_paywall_list(product_type) {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url() ?>admin/Video_Sync/get_paywall_list',

            data: {product_type: product_type},
            success: function (result) {
                if (result != 0) {
                    if (product_type == 1)
                    {
                        $('#paywall').html(result);
                    }
                    if (product_type == 2)
                    {
                        $('#donate_paywall').html(result);
                    }
                }
                if (result == 1) {
                    if (product_type == 1) {
                        alert('Oops! Your network is not created, Please contact admin');
                        return false;
                    }
                }
            }
        });
    }


    function one_video(video_id) {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url() ?>admin/Video_Sync/select_one_video',

            data: {video_id: video_id},
            success: function (result) {
                $('#right_block').show();
                $('#edit').hide();
                $('#youtube_video').hide();
                $("#ajax_return").html(result);
            }
        });
    }
</script>
<script type="text/javascript">
    $(document).ready(function () {
        get_paywall_list(1);
        get_paywall_list(2);
    });
</script>
<script src="<?php echo base_url() . 'assets/admin/js/jquery.form.min.js'; ?>"></script>
<script type="text/javascript">
    $(document).ready(function () {

        $('#progress-div').hide();
        $('#add_new_videos').submit(function (e) {
            if ($('#userfile').val()) {
                e.preventDefault();


                $('#add_new_videos').ajaxSubmit({
                    target: '#targetLayer',
                    beforeSubmit: function () {
                        $("#progress-bar").width('0%');
                    },
                    uploadProgress: function (event, position, total, percentComplete) {
                        $('#progress-div').show();
                        $("#progress-bar").width(percentComplete + '%');
                        $("#progress-bar").html('<div id="progress-status">' + percentComplete + ' %</div>')
                    },
                    success: function () {
                        $('#progress-div').hide();
                    },
                    resetForm: true
                });
//                return false;
            }
        });
    });
</script>

<script>
    $('#add_new_videos').validator();
</script>


<script>
    $('#update_activities').validator();
</script>
