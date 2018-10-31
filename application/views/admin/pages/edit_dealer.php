<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Dealer
<!--            <small>Preview</small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Edit Dealer</li>
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
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" class="form-reset" method="post" id="edit_dealer" action="<?php echo base_url('admin/Dealer/update_dealer'); ?>" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-6">

                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Account Name</label><span class="required"> *</span>
                                        <input type="text" class="form-control" id="account_name" value="<?php echo $edit_dealer['AccountName']; ?>" name="account_name" placeholder="Enter Account Name" required="">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="UserID" value="<?php echo $edit_dealer['UserID']; ?>"/>
                                        <input type="hidden" name="DealerID" value="<?php echo $edit_dealer['DealerID']; ?>"/>
                                        <input type="hidden" name="DealerDetID" value="<?php echo $edit_dealer['DealerDetID']; ?>"/>

                                        <label for="exampleInputEmail1">First Name</label><span class="required"> *</span>                                        
                                        <input type="text" class="form-control " value="<?php echo $edit_dealer['FirstName']; ?>" name="firstname" id="firstname" maxlength="30" placeholder="Enter First name" required />
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Last Name</label><span class="required"> *</span>                                        
                                        <input type="text" class="form-control " value="<?php echo $edit_dealer['LastName']; ?>" name="lastname" id="lastname" maxlength="30" placeholder="Enter Last name" required />
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email Id</label><span class="required"> *</span>

                                        <input type="email" class="form-control" value="<?php echo $edit_dealer['EmailID']; ?>" name="emailid" id="emailid" placeholder="Enter Your Email-ID" required />
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <!--<div class="form-group">-->
                                        <!--<label for="exampleInputEmail1">Password</label><span class="required"> *</span>-->

                                    <input type="hidden" class="form-control" value="<?php echo $edit_dealer['Password']; ?>" id="password" name="password"/> 
                                    <!--<div class="help-block with-errors"></div>-->
                                    <!--</div>-->

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">City</label>

                                        <input type="text" class="form-control" value="<?php echo $edit_dealer['City']; ?>" id="city" name="city" placeholder="Enter City"> 
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputPassword1">State</label>
                                        <input type="text" class="form-control" value="<?php echo $edit_dealer['State']; ?>" id="state" name="state" placeholder="Enter branch State"  />
                                        <div class="help-block with-errors"></div>
                                    </div> 

                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Country</label>
                                        <input type="text" class="form-control" value="<?php echo $edit_dealer['Country']; ?>" id="country"  name="country" placeholder="Enter Country"  />
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group">
                                        <label>Profile Pic</label>
                                        <input type="file" class="form-control" id="userfile" name="userfile" />
                                        <div class="help-block with-errors"></div>

                                        <?php
                                        $filename = base_url() . 'uploads/' . $edit_dealer['ProfilePICPath'];

                                        if ($edit_dealer['ProfilePICPath'] != '') {
                                            ?>
                                            <img src="<?php echo $filename; ?>"  alt="Image preview" class="col-xs-12 col-sm-3 img-responsive thumbnail" />                                            
                                            <?php
                                        }
                                        ?>
                                    </div>



                                </div>



                                <div class=" col-xs-6">
                                    <div class="form-group">
                                        <label class="col-sm-12">Logo</label>
                                        <input type="file" class="form-control" id="logo"  name="logo" />

                                        <div class="help-block with-errors"></div>
                                        <?php
                                        $logo = base_url() . 'uploads/logo/' . $edit_dealer['Logo'];

                                        if ($edit_dealer['Logo'] != '') {
                                            ?>
                                            <img src="<?php echo $logo; ?>"  alt="Image preview" class="col-xs-12 col-sm-3 img-responsive thumbnail" />                                            
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-12">Domain</label>   <span class="required"> *</span>                                     
                                        <input type="text" class="form-control " value="<?php echo $edit_dealer['Domain']; ?>" name="domain" id="domain" maxlength="30" placeholder="Enter Domain name" required />
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Web Service URL</label><span class="required"> *</span>
                                        <input type="text" class="form-control" value="<?php echo $edit_dealer['WebServiceURL']; ?>" id="WebServiceURL" required=""  name="WebServiceURL" placeholder="Enter Web Service URL">
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Database Server Name</label><span class="required"> *</span>                                        
                                        <input type="text" class="form-control " value="<?php echo $edit_dealer['DBServerName']; ?>" name="DBServerName" id="DBServerName" maxlength="30" placeholder="Enter Database Server Name" required />
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Database Name</label><span class="required"> *</span>                                        
                                        <input type="text" class="form-control" value="<?php echo $edit_dealer['DBName']; ?>" name="DBName" id="DBName" maxlength="30" placeholder="Enter Database Name" required />
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Database User Name</label><span class="required"> *</span>                                        
                                        <input type="text" class="form-control " value="<?php echo $edit_dealer['DBUserName']; ?>" name="DBUserName" id="DBUserName" maxlength="30" placeholder="Enter Database User Name" required />
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Database Password</label><span class="required"> *</span>                                        
                                        <input type="text" class="form-control " value="<?php echo $edit_dealer['DBPassword']; ?>" name="DBPassword" id="DBPassword" maxlength="30" placeholder="Enter Database Password" required />
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Subscription From Date</label>
                                        <input type="text" class="datepicker form-control" value="<?php echo $edit_dealer['SubFromDate']; ?>"  onchange="return date(this.value);" name="SubFromDate" id="SubFromDate" maxlength="30" placeholder="  Enter Subscription From Date" />
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Subscription End Date</label>
                                        <input type="text" class="datepicker form-control" value="<?php echo $edit_dealer['SubEndDate']; ?>"   name="SubEndDate" id="SubEndDate" maxlength="30" placeholder="  Enter Subscription End Date" />
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group" style="display:none;">
                                        <label for="exampleInputPassword1">Subscription Charges</label><span class="required"> *</span>
                                        <input type="number" step="0.1" class="form-control" value="<?php echo $edit_dealer['SubscriptionCharges']; ?>" id="sub_charge"  name="sub_charge" placeholder="Enter Subscription Charges">
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group" style="display:none;">
                                        <label for="exampleInputPassword1">Transaction Share</label><span class="required"> *</span>
                                        <input type="number" step="0.1" class="form-control" value="<?php echo $edit_dealer['TransactionShare']; ?>" id="transaction_share"  name="transaction_share" placeholder="Enter Transaction Share">
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group" style="display:none;">
                                        <label for="exampleInputPassword1">Video Purchase Share</label><span class="required"> *</span>
                                        <input type="number" step="0.1" class="form-control"  value="<?php echo $edit_dealer['VideoPurchaseShare']; ?>" id="VideoPurchaseShare"  name="VideoPurchaseShare" placeholder="Enter Video Purchase Share">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <div class="row">
                                <div class="col-sm-1">
                                    <input type="submit" name="submit" value="submit" class="btn btn-primary"/>
                                </div>
                                <div class="col-sm-1">
                                    <a href="<?php echo base_url() . 'admin/Dealer/view_dealers'; ?>"><button type="button" name="cancel" id="" value="cancel" class="btn btn-danger">Cancel</button></a>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div> 
    </section>
</div>


<script>

    $('#SubFromDate').datepicker({
        format: 'mm/dd/yyyy',
        startDate: 'd',
        autoclose: true

    });

    $('.select2').select2();

    function date(d1) {
        $('#SubEndDate').val();
        $('#SubEndDate').datepicker({
            format: 'mm/dd/yyyy',
            startDate: d1,
            autoclose: true
        });
    }
    $('.select2').select2();


</script>
<script>
    $('#edit_dealer').validator();
    $.validate();
</script>