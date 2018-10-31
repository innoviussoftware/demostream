
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Video
            <small><?php echo $edit_detail[0]['Title']; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url('admin/Video_Sync/view_video'); ?>"></i> Video Sync</a></li>
            <li class="active">Edit Video</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12 col-xs-12">
                <!-- general form elements -->
                <div class="box box-primary">
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
                    <?php if ($this->session->flashdata("warning")) { ?>
                        <div class="alert alert-warning alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <span class="text-center"><?php echo $this->session->flashdata('warning'); ?></span>
                        </div>
                    <?php } ?>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" class="form-reset" method="post" action="<?php echo base_url('admin/Video_Sync/edit_video_detail'); ?>">

                        <input type="hidden" name="VideoID" value="<?php echo $edit_detail[0]['VideoID']; ?>"  />
                            <input type="hidden" name="IsFrontPage" value="<?php echo $edit_detail[0]['IsFrontPage']; ?>"  /> 
                            <input type="hidden" name="VideoPath" value="<?php echo $edit_detail[0]['VideoPath']; ?>"  />
                            <input type="hidden" name="VideoSize" value="<?php echo $edit_detail[0]['VideoSize']; ?>"  />
                            <input type="hidden" name="IsPublic" value="<?php echo $edit_detail[0]['IsPublic']; ?>"  />
                            <input type="hidden" name="WrapperPath" value="<?php echo $edit_detail[0]['WrapperPath']; ?>"  />
                            <input type="hidden" name="DeviceID" value="<?php echo $edit_detail[0]['DeviceID']; ?>"  />
                            <input type="hidden" name="VideoFileName" value="<?php echo $edit_detail[0]['VideoFileName']; ?>"  />
                            <input type="hidden" name="UserID" value="<?php echo $edit_detail[0]['UserID']; ?>"  />
                            <input type="hidden" name="IsPayment" value="<?php echo $edit_detail[0]['IsPayment']; ?>"  />
                            <input type="hidden" name="IsBtnConfig" value="<?php echo $edit_detail[0]['IsBtnConfig']; ?>"  />
                            <input type="hidden" name="FirstName" value="<?php echo $edit_detail[0]['FirstName']; ?>"  />
                            <input type="hidden" name="LastName" value="<?php echo $edit_detail[0]['LastName']; ?>"  />
                            <input type="hidden" name="City" value="<?php echo $edit_detail[0]['City']; ?>"  />
                            <input type="hidden" name="State" value="<?php echo $edit_detail[0]['State']; ?>"  />
                            <input type="hidden" name="Country" value="<?php echo $edit_detail[0]['Country']; ?>"  />
                            <input type="hidden" name="DonationAmount" value="<?php echo $edit_detail[0]['DonationAmount']; ?>"  />
                            <input type="hidden" name="NoOfDonors" value="<?php echo $edit_detail[0]['NoOfDonors']; ?>"  />
                            <input type="hidden" name="IsDeleted" value="<?php echo $edit_detail[0]['IsDeleted']; ?>"  />
                            <input type="hidden" name="IsPurchase" value="<?php echo $edit_detail[0]['IsPurchase']; ?>"  />
                            <input type="hidden" name="NoOfComments" value="<?php echo $edit_detail[0]['NoOfComments']; ?>"  />
                            <input type="hidden" name="CampaignDetID" value="<?php echo $edit_detail[0]['CampaignDetID']; ?>"  />
                            <input type="hidden" name="isFollowing" value="<?php echo $edit_detail[0]['isFollowing']; ?>"  />
                            <input type="hidden" name="CampaignStartDate" value="<?php echo $edit_detail[0]['CampaignStartDate']; ?>" />
                            <input type="hidden" name="CampaignEndDate" value="<?php echo $edit_detail[0]['CampaignEndDate']; ?>"  />
                            <input type="hidden" name="ViewsCount" value="<?php echo $edit_detail[0]['ViewsCount']; ?>"  />
                            <input type="hidden" name="TotalVideoCount" value="<?php echo $edit_detail[0]['TotalVideoCount']; ?>" /> 
                            <input type="hidden" name="UpdatesCount" value="<?php echo $edit_detail[0]['UpdatesCount']; ?>" />    
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12 col-md-6">
                                    <input type="hidden" name="PaywallId" id="PaywallId" value="<?php echo $edit_detail[0]['PaywallName'];?>" />
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Title</label><span class="required"> *</span>
                                        <input type="text" class="form-control" name="Title" value="<?php echo $edit_detail[0]['Title']; ?>" placeholder="Enter video name" required />
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Description</label><span class="required"> *</span>
                                        <input type="text" placeholder="Enter description" class="form-control" name="Description" value="<?php echo $edit_detail[0]['Description']; ?>" required />
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Download Paywall</label><span class="required"> *</span>
                                        <select class="form-control" id="paywall" required="" name="paywall" >
                                            <!--PAYWALL LIST WILL SHOWN HERE BY AJAX-->                                       
                                            <option value="">Select Paywall</option>
                                        </select>
                                        <b style="position:  relative;top: 7px;">Note: This paywall payment is for users to download video</b>
                                        <a style="float: right;text-decoration: underline;color: rgb(57,194,215) !important;padding-top: 5px;" href="javascript:void(0);" onclick="return get_paywall_list(1);">Refresh paywall</a>
                                        <div class="help-block with-errors"></div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <button type="submit" name="Submit" value="Submit" class="btn btn-primary">Submit</button>                                    
                                
                                        <a href="<?php echo base_url('admin/Video_Sync/view_video'); ?>">
                                            <button type="button" name="cancel" id="cancel" value="cancel" class="btn btn-danger">Cancel</button>
                                        </a>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div> 


    </section>


</div>

<script type="text/javascript">
    $(document).ready(function () {
        get_paywall_list(1);
    });
</script>
<script>
    function get_paywall_list(product_type) {
        var PaywallId = $('#PaywallId').val();        
        $.ajax({
            type: "POST",
            url: '<?php echo base_url() ?>admin/Video_Sync/get_paywall_list',
            data: {product_type: product_type,download_paywall: PaywallId},
            success: function (result) {
                if (result != 0) {
                    if(product_type == 1)
                    {
                        $('#paywall').html(result);
                    }
                    if(product_type == 2)
                    {
                        $('#donate_paywall').html(result);
                    }
                }if(result == 1){
                    if(product_type == 1){
                        alert('Oops! Your network is not created, Please contact admin');
                        return false;
                    }
                }
            }
        });
    }
    </script>