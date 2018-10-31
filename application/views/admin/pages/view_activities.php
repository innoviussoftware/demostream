<div class="content-wrapper">

    <section class="content-header">
        <h1>
            My Activities
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">My Activities</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-xs-12">
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
                        <li class="active"><a href="#donors" onclick="return tab_pannel();" data-toggle="tab">Donors</a></li>
                        <li><a href="#fund" onclick="return tab_pannel();" data-toggle="tab">Fund Management</a></li>
                        <li><a href="#product" onclick="return tab_pannel();" data-toggle="tab">Product Management</a></li>
                    </ul>

                    <div class="tab-content">

                        <div class="active tab-pane" id="donors">
                            <table class="table table-striped">
                                <tr>

                                <select id="video_id" onchange="return get(this.value);" style="border:1px solid #999;" class="form-control select">
                                    <option>Select Video</option>
                                    <?php
                                    for ($r = 0; $r < sizeof($video_detail); $r++) {
                                        ?>
                                        <option value="<?php echo $video_detail[$r]['VideoID']; ?>" key="<?php echo $video_detail[$r]['Title']; ?>"><?php echo $video_detail[$r]['Title']; ?></option>                  
                                    <?php } ?>
                                </select>
                                </tr> 
                            </table>
                        </div>

                        <div class="tab-pane" id="fund">
                            <form id="fund_form" method="post" class="form-horizontal" action="<?php echo base_url('admin/Activities/fund'); ?>">

                                <?php $input = explode('demostream', $fundmanager['PayPalClientID']); //print_r($input);?>

                                <input type="hidden" name="FundManagerID" value="<?php echo $fundmanager['FundManagerID']; ?>"  />
                                <input type="hidden" name="CampaignDetID" value="<?php echo $fundmanager['CampaignDetID']; ?>"  />
                                <input type="hidden" name="PaypalFirstName" value="<?php echo $fundmanager['PaypalFirstName']; ?>"  />
                                <input type="hidden" name="PaypalSecondName" value="<?php echo $fundmanager['PaypalSecondName']; ?>"  />
                                <input type="hidden" name="IsVerified" value="<?php echo $fundmanager['IsVerified']; ?>"  />
                                <input type="hidden" name="CreatedLat" value="<?php echo $fundmanager['CreatedLat']; ?>"  />
                                <input type="hidden" name="UpdatedLat" value="<?php echo $fundmanager['UpdatedLat']; ?>"  />
                                <input type="hidden" name="UpdatedLang" value="<?php echo $fundmanager['UpdatedLang']; ?>"  />
                                <input type="hidden" name="UserID" value="<?php echo $fundmanager['UserID']; ?>"  />
                                <input type="hidden" name="Subscriptioncharge" value="<?php echo $fundmanager['Subscriptioncharge']; ?>"  />
                                <input type="hidden" name="ShopifyAPIKey" value="<?php echo $fundmanager['ShopifyAPIKey']; ?>"  />
                                <input type="hidden" name="ShopifyChannelID" value="<?php echo $fundmanager['ShopifyChannelID']; ?>"  />
                                <input type="hidden" name="ShopifyStoreName" value="<?php echo $fundmanager['ShopifyStoreName']; ?>"  />
                                <input type="hidden" name="APIKeyToken" value="<?php echo $fundmanager['APIKeyToken']; ?>"  />
                                <input type="hidden" name="APIKeyPassword" value="<?php echo $fundmanager['APIKeyPassword']; ?>"  />
                                <input type="hidden" name="DropBoxApiKey" value="<?php echo $fundmanager['DropBoxApiKey']; ?>"  />
                                <input type="hidden" name="DropBoxApiSecret" value="<?php echo $fundmanager['DropBoxApiSecret']; ?>"  />

                                <table class="table table-striped">
                                    <tr>
                                    <input type="text" id="pk" placeholder="Enter Your Publisher Key" name="pk" value="<?php echo $input[0]; ?>" class="form-control"  />
                                    </tr>
                                    <br />
                                    <tr>
                                    <input type="text" id="sk" name="sk" placeholder="Enter Your Secret Key" value="<?php echo $input[1]; ?>" class="form-control"  />
                                    </tr>
                                    <br />
                                    <tr>
                                    <input type="text" id="PaypalEmail" name="PaypalEmail" placeholder="Enter Your Email" value="<?php echo $fundmanager['PaypalEmail']; ?>" class="form-control"  />
                                    </tr> 
                                    <br />
                                    <tr>

                                    <input style="margin-left:70%;margin-right:2%;" type="submit" name="submit" value="submit" class="btn btn-primary"  />

                                    <input id="fund_reset" type="button" name="Clear" value="clear" class="btn btn-primary"  /> 


                                    </tr>
                                    <br />
                                </table>

                            </form>
                        </div>

                        <div class="tab-pane" id="product">
                            <form id="product_form" method="post" class="form-horizontal" action="<?php echo base_url('admin/Activities/product'); ?>">


                                <input type="hidden" name="FundManagerID" value="<?php echo $fundmanager['FundManagerID']; ?>"  />
                                <input type="hidden" name="CampaignDetID" value="<?php echo $fundmanager['CampaignDetID']; ?>"  />
                                <input type="hidden" name="CreatedLang" value="<?php echo $fundmanager['CreatedLang']; ?>"  />
                                <input type="hidden" name="CreatedLat" value="<?php echo $fundmanager['CreatedLat']; ?>"  />

                                <input type="hidden" name="PaypalFirstName" value="<?php echo $fundmanager['PaypalFirstName']; ?>"  />
                                <input type="hidden" name="IsSync" value="false"  />

                                <input type="hidden" name="IsVerified" value="true"  />
                                <input type="hidden" name="PaypalEmail" value="<?php echo $fundmanager['PaypalEmail']; ?>"  />
                                <input type="hidden" name="CreatedLat" value="<?php echo $fundmanager['CreatedLat']; ?>"  />
                                <input type="hidden" name="UpdatedLat" value="<?php echo $fundmanager['UpdatedLat']; ?>"  />
                                <input type="hidden" name="UpdatedLang" value="<?php echo $fundmanager['UpdatedLang']; ?>"  />
                                <input type="hidden" name="UserID" value="<?php echo $fundmanager['UserID']; ?>"  />
                                <input type="hidden" name="Subscriptioncharge" value="<?php echo $fundmanager['Subscriptioncharge']; ?>"  />
                                <input type="hidden" name="ShopifyChannelID" value="<?php echo $fundmanager['ShopifyChannelID']; ?>"  />

                                <input type="hidden" name="DropBoxApiKey" value="<?php echo $fundmanager['DropBoxApiKey']; ?>"  />
                                <input type="hidden" name="DropBoxApiSecret" value="<?php echo $fundmanager['DropBoxApiSecret']; ?>"  />

                                <input type="hidden" name="PayPalClientID" value="<?php echo $fundmanager['PayPalClientID']; ?>"  />


                                <table class="table table-striped">
                                    <tr>
                                    <input type="text" id="ShopifyAPIKey" name="ShopifyAPIKey" class="form-control" placeholder="Shopify API Key" value="<?php echo $fundmanager['ShopifyAPIKey']; ?>"  />
                                    </tr>
                                    <br />
                                    <tr>
                                    <input type="text" id="ShopifyStoreName" name="ShopifyStoreName" class="form-control" placeholder="Enter Shopify Store Name" value="<?php echo $fundmanager['ShopifyStoreName']; ?>" />
                                    </tr>
                                    <br />
                                    <tr>
                                    <input type="text" id="APIKeyToken" name="APIKeyToken" class="form-control" placeholder="Shopify Web API Key" value="<?php echo $fundmanager['APIKeyToken']; ?>" />
                                    </tr> 
                                    <br />
                                    <tr>
                                    <input type="text" id="APIKeyPassword" name="APIKeyPassword" class="form-control" placeholder="Shopify Web Password" value="<?php echo $fundmanager['APIKeyPassword']; ?>" />
                                    </tr> 
                                    <br />
                                    <tr>

                                    <input  style="margin-left:70%;margin-right:2%;"  type="submit" name="submit" value="submit" class="btn btn-primary"  />
                                    <input id="product_reset" type="button" name="Clear" value="clear" class="btn btn-primary"  /> 

                                    </tr>
                                    <br />
                                </table>

                            </form>
                        </div>       
                    </div>
                </div>
            </div>


            <div class="col-md-6" id="right_block" style="display:none;">
                <div class="nav-tabs-custom">


                    <ul class="nav nav-tabs" style="background:#ccc;">
                        <label style="font-size:120%;padding:2%;" id="video_title"></label>
                    </ul>

                    <div class="tab-content" id="video">

                        <div class="active tab-pane" >
                            <ul class="list-group" id="ajax_return">

                            </ul>
                        </div>
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>



        </div>
    </section>
</div>


<script type="text/javascript">
    function tab_pannel()
    {
        $('#right_block').hide();
    }

    $('#product_reset').click(function () {

        $('#product_form')[0].reset();
        $('#ShopifyAPIKey').val('');
        $('#ShopifyStoreName').val('');
        $('#APIKeyToken').val('');
        $('#APIKeyPassword').val('');
    });


    function get(video_id) {

        var name = $('#video_id option[value="' + video_id + '"]').attr('key');
        $('#video_title').html(name);

        $.ajax({
            type: "POST",
            url: '<?php echo base_url() ?>admin/Activities/select_one_video',

            data: {video_id: video_id},
            success: function (result) {
                $('#right_block').show();
                $("#ajax_return").html(result);
            }
        });
    }
</script>


