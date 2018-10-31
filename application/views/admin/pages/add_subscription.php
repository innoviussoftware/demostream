
<div class="content-wrapper">
    <section class="content-header">
        <?php if (isset($subscription_detail) != '') { ?>
            <h1>Edit Subscription</h1>
        <?php } else { ?>
            <h1>Add Subscription</h1>
        <?php } ?>

        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>

            <?php if (isset($subscription_detail) != '') { ?>

                <li class="active">Edit Subscription</li>

            <?php } else { ?>
                <li class="active">Add Subscription</li>
            <?php } ?>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="box box-primary">
                    <?php if ($this->session->flashdata("success")) { ?>
                        <div class="alert alert-success alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <span class="text-center"><?php echo $this->session->flashdata('success'); ?></span>
                        </div>
                    <?php } else if ($this->session->flashdata("danger")) { ?>
                        <div class="alert alert-danger alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <span class="text-center"><?php echo $this->session->flashdata('danger'); ?></span>
                        </div>
                    <?php } ?>

                    <?php if (isset($subscription_detail)) { ?>
                        <form role="form" class="form-reset" method="post" id="edit_subscription" action="<?php echo base_url('admin/Clients/edit_subscription'); ?>" enctype="multipart/form-data">

                            <input type="hidden" name="SubscriptionId" value="<?php echo $subscription_detail['SubscriptionId']; ?>"/>
                            <input type="hidden" name="CreatedOnMobile" value="<?php echo $subscription_detail['CreatedOnMobile']; ?>"/>

                        <?php } else { ?>
                            <form role="form" class="form-reset" method="post" id="add_subscription" action="<?php echo base_url('admin/Clients/add_new_subscription'); ?>" enctype="multipart/form-data">
                            <?php } ?>

                            <div class="box-body">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group">
                                            <label>Choose User</label><span class="required">*</span>
                                            <select class="form-control" required="" name="user_id">
                                                <option value="">Select User</option>
                                                <?php
                                                for ($a = 0; $a < sizeof($Userdetail); $a++) {
                                                    ?>
                                                    <?php if ($Userdetail[$a]['FirstName'] != '') { ?>
                                                        <option value="<?php echo $Userdetail[$a]['UserID']; ?>" <?php if ($Userdetail[$a]['UserID'] == $subscription_detail['UserId']) { ?> selected="selected" <?php } ?> ><?php echo $Userdetail[$a]['FirstName']; ?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        <div class="form-group">
                                            <label>Choose Package</label><span class="required">*</span>
                                            <select class="form-control" id="PackageID" required="" name="PackageID" >
                                                <option value="">Select Package</option>
                                                <?php
                                                if (sizeof($package) > 0) {
                                                    for ($i = 0; $i < sizeof($package); $i++) {
                                                        ?>
                                                        <option value="<?php echo $package[$i]['PackageID']; ?>" <?php if ($package[$i]['PackageID'] == $subscription_detail['PackageID']) { ?> selected="selected" <?php } ?> data-key="<?php echo $package[$i]['PackAmount']; ?>"><?php echo $package[$i]['PackageName'] . ' @ [$' . $package[$i]['PackAmount'] . '] for [' . $package[$i]['NoOfDays'] . ' months]'; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                            </select>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        <div class="form-group">
                                            <label>Subscription Start Date</label><span class="required">*</span>
                                            <input type="text" class="datepicker form-control" value="<?php
                                            if ($subscription_detail['SubscriptionDate'] != '' && $subscription_detail['SubscriptionDate'] != '1970-01-01') {
                                                echo date('m/d/Y', strtotime($subscription_detail['SubscriptionDate']));
                                            }
                                            ?>" name="subscription_date" id="subscription_date" maxlength="30"  placeholder=" Enter Subscription Date" required="" />
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        <!--
                                        <div class="form-group" style="display: none;">
                                            <label>Subscription Amount</label><span class="required"> *</span>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-dollar"></i>
                                                </div>
                                                <input type="text" class="form-control" readonly="" id="SubscriptionAmount" value="<?php // echo $subscription_detail['SubscriptionAmount'];                ?>"  name="SubscriptionAmount"/>

                                            </div>
                                            <div class="help-block with-errors"></div>
                                        </div>-->


                                        <div class="form-group">
                                            <label>Transaction Id</label>
                                            <input type="text" class="form-control" value="<?php echo $subscription_detail['TransactionId']; ?>" id="TransactionId"  name="TransactionId" placeholder="Enter Transaction Id" />
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        <div class="form-group">
                                            <label>Invoice Id</label>
                                            <input type="text" class="form-control" value="<?php echo $subscription_detail['InvoiceId']; ?>" id="InvoiceId"  name="InvoiceId" placeholder="Enter Invoice Id" />
                                            <div class="help-block with-errors"></div>
                                        </div>

                                        <!--                                        <div class="form-group" style="display: none;">
                                                                                    <label>Subscription From Date</label><span class="required">*</span>
                                                                                    <input type="text" class="datepicker form-control" onchange="return date(this.value);" value="<?php
                                        if ($subscription_detail['SubFromDate'] != '' && $subscription_detail['SubFromDate'] != '1970-01-01') {
//                                                echo date('m/d/Y', strtotime($subscription_detail['SubFromDate']));
                                        }
                                        ?>" name="SubFromDate" id="SubFromDate" maxlength="30" placeholder="  Enter Subscription From Date" required>
                                                                                    <div class="help-block with-errors"></div>
                                                                                </div>
                                        
                                        
                                        
                                                                                <div class="form-group" style="display: none;">
                                                                                    <label>Subscription End Date</label><span class="required">*</span>
                                                                                    <input type="text" class="datepicker form-control" value="<?php
                                        if ($subscription_detail['SubEndDate'] != '' && $subscription_detail['SubEndDate'] != '1970-01-01') {
//                                                echo date('m/d/Y', strtotime($subscription_detail['SubEndDate']));
                                        }
                                        ?>" name="SubEndDate" id="SubEndDate" maxlength="30" placeholder="  Enter Subscription End Date" required>
                                                                                <div class="help-block with-errors"></div>
                                                                            </div>-->



                                    </div>
                                </div>

                                <div class="box-footer">
                                    <div class="row">

                                        <div class="col-sm-1">
                                            <button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                        <div class="col-sm-1">
                                            <a href="<?php echo base_url('admin/Clients/view_subscription'); ?>">
                                                <button type="button" name="cancel" id="cancel" value="cancel" class="btn btn-danger">Cancel</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                        </form>
                </div>
            </div>
        </div> 
</div>
</section>
</div>

<script>
    $('#add_subscription').validator();
    $.validate();
</script>
<script>

//    $('#SubFromDate').datepicker({
//        format: 'mm/dd/yyyy',
//        startDate: 'd',
//        autoclose: true,
//        orientation: 'bottom'
//
//    });
    $('#subscription_date').datepicker({
        format: 'mm/dd/yyyy',
        startDate: 'd',
        autoclose: true,
        orientation: 'bottom'

    });

    $('.select2').select2();

//    function date(d1) {
//        $('#SubEndDate').val('');
//        $('#SubEndDate').datepicker({
//            format: 'mm/dd/yyyy',
//            startDate: d1,
//            autoclose: true,
//            orientation: 'bottom'
//        });
//    }
    $('.select2').select2();

</script>
