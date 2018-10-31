<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Add Ning Network
<!--            <small>Preview</small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Add Ning Network</li>
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
                    <form role="form" class="form-reset" method="post" id="add_network" action="<?php echo base_url('admin/Network/AddNewNetwork'); ?>">
                        <input type="hidden" name="network_key" value="" id="network_key" />
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label>Choose User</label><span class="required">*</span>
                        <select class="form-control" required="" name="user_id" onchange="return get_user_data(this.value);">
                            <option value="">Select User</option>
                            <?php
                            for ($a = 0; $a < sizeof($Userdetail); $a++) {
                                ?>
                                <?php if ($Userdetail[$a]['FirstName'] != '' && $Userdetail[$a]['IsSubscribed'] == '1' && $Userdetail[$a]['EmailID'] != '') { 
                                    $network_key='';
                                    if($Userdetail[$a]['NetworkKey'] != '' && $Userdetail[$a]['NetworkKey'] != 'null'){
                                        $network_key = "[Network Key:".$Userdetail[$a]['NetworkKey'] .']';
                                    }
                                    ?>
                                    <option value="<?php echo $Userdetail[$a]['UserID']; ?>" <?php if ($Userdetail[$a]['UserID'] == $subscription_detail['UserId']) { ?> selected="selected" <?php } ?> ><?php echo $Userdetail[$a]['FirstName'] . ' ' . $Userdetail[$a]['LastName'] .' '. $network_key; ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                        <div class="help-block with-errors"></div>
                         <a href="#" target="_blank" id="admin_payment_url" class="pull-right btn btn-primary btn-xs">Click to login into Network</a></center>
                        </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Ning Profile Name</label><span class="required"> *</span>
                                <input type="text" class="form-control" name="profile_name" id="profile_name" placeholder="Enter profile name" required />
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Email</label><span class="required"> *</span>
                                <input type="text" placeholder="Enter email address" class="form-control" name="email" id="email" required />
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group" id="donate_paywall">
                                <label for="exampleInputPassword1">Select Donate Paywall</label>
                                    <select class="form-control" id="paywall" name="paywall" >
                                        <!--PAYWALL LIST WILL SHOWN HERE BY AJAX-->                                       
                                        <option value="">Select Paywall</option>
                                    </select>
                                    <b style="position:  relative;top: 7px;">Note: This paywall payment is for users to add donations</b>
                                    <a style="float: right;text-decoration: underline;color: rgb(57,194,215) !important;padding-top: 5px;" href="javascript:void(0);" onclick="return get_paywall_list();">Refresh paywall</a>
                                    <div class="help-block with-errors"></div>

                                </div>

                                </div>
                               
                            </div>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <div class="row">
                                <div class="col-sm-1">
                                    <button type="submit" name="submit" value="submit" class="btn btn-primary">Create Network</button>
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

    function get_user_data(user_id) {
        $('#network_key').val('');
        $.ajax({
            type: "POST",
            url: '<?php echo base_url() ?>admin/Network/GetUserData',
            data: {UserID: user_id},
            success: function (result) {
                if (result != 0) {
                    var obj = JSON.parse(result);
                    $('#profile_name').val(obj.account_name);
                    $('#email').val(obj.email);

                    if(obj.admin_url != ''){
                        $('#admin_payment_url').attr('href',obj.admin_url);
                        $('#admin_payment_url').show();
                        $('#paywall').show();
                        $('#donate_paywall').show();
                        $('#network_key').val(obj.network_key);
                        get_paywall_list();
                    }
                } else {
                    $('#network_key').val();
                    $('#profile_name').val();
                    $('#email').val();
                    $('#admin_payment_url').attr('href','#');
                    $("#admin_payment_url").hide();
                    $('#paywall').hide();
                    $('#donate_paywall').hide();
                }
            }
        });
    }
     function get_paywall_list() {
        var network_key= $('#network_key').val();
        $.ajax({
            type: "POST",
            url: '<?php echo base_url() ?>admin/Network/GetPaywallList',
            data: {network_key: network_key},
            success: function (result) {
                if (result != 0) {
                    $('#donate_paywall').show();
                    $('#paywall').html(result);
                }
            }
        });
    }
    $('#paywall').hide();
    $('#donate_paywall').hide();
    $("#admin_payment_url").hide();
    $('#add_network').validator();
    $.validate();
</script>