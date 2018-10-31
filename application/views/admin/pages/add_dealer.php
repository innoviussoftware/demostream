
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Add Dealer
<!--            <small>Preview</small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Add Dealer</li>
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
                    <form role="form" class="form-reset" method="post" id="add_client" action="<?php echo base_url('admin/Dealer/add_new_dealer'); ?>" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Account Name</label><span class="required"> *</span>
                                        <input type="text" class="form-control" id="account_name" required="" name="account_name" placeholder="Enter Account Name">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">First Name</label><span class="required"> *</span>                                        
                                        <input type="text" class="form-control " name="firstname" id="firstname" maxlength="30" placeholder="Enter First name" required>
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Last Name</label><span class="required"> *</span>                                        
                                        <input type="text" class="form-control " name="lastname" id="lastname" maxlength="30" placeholder="Enter Last name" required>
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email-ID</label><span class="required"> *</span>

                                        <input type="email" class="form-control" name="emailid" id="emailid" placeholder="Enter Your Email-ID" required>
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Password</label><span class="required"> *</span>

                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required> 
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">City</label>

                                        <input type="text" class="form-control" id="city" name="city" placeholder="Enter City"> 
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputPassword1">State</label>
                                        <input type="text" class="form-control" id="state" name="state" placeholder="Enter branch State" />
                                        <div class="help-block with-errors"></div>
                                    </div> 

                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Country</label>
                                        <input type="text" class="form-control" id="country"  name="country" placeholder="Enter Country" />
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Profile Pic</label>
                                        <input type="file" class="form-control" id="userfile"  name="userfile" placeholder="Enter Website">
                                        <div class="help-block with-errors"></div>
                                    </div>



                                </div>



                                <div class=" col-xs-6">

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Domain</label>   <span class="required"> *</span>                                                                             
                                        <input type="text" class="form-control " name="domain" id="domain" maxlength="30" placeholder="Enter Domain name" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Logo</label>
                                        <input type="file" class="form-control" id="logo"  name="logo" placeholder="Enter Website">
                                        <div class="help-block with-errors"></div>
                                    </div>


                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Web Service URL</label><span class="required"> *</span>
                                        <input type="text" class="form-control" id="WebServiceURL" required="" name="WebServiceURL" placeholder="Enter Web Service URL">
                                        <div class="help-block with-errors"></div>
                                    </div>


                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Database Server Name</label><span class="required"> *</span>                                        
                                        <input type="text" class="form-control " name="DBServerName" id="DBServerName" maxlength="30" placeholder="Enter Database Server Name" required>
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Database Name</label><span class="required"> *</span>                                        
                                        <input type="text" class="form-control" value="ktsdemostream_live_v2_test" name="DBName" id="DBName" maxlength="30" placeholder="Enter Database Name" required="" />
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Database User Name</label><span class="required"> *</span>                                        
                                        <input type="text" class="form-control " name="DBUserName" id="DBUserName" maxlength="30" placeholder="Enter Database User Name" required>
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Database Password</label><span class="required"> *</span>                                        
                                        <input type="text" class="form-control " name="DBPassword" id="DBPassword" maxlength="30" placeholder="Enter Database Password" required>
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Subscription From Date</label>
                                        <input type="text" class="datepicker form-control" onchange="return date(this.value);" name="SubFromDate" id="SubFromDate" maxlength="30" placeholder="  Enter Subscription From Date" />
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Subscription End Date</label>
                                        <input type="text" class="datepicker form-control" name="SubEndDate" id="SubEndDate" maxlength="30" placeholder="  Enter Subscription End Date" />
                                        <div class="help-block with-errors"></div>
                                    </div>



                                    <div class="form-group" style="display:none;">
                                        <label for="exampleInputPassword1">Subscription Charges</label><span class="required"> *</span>
                                        <input type="number" step="0.1" class="form-control" id="sub_charge"  name="sub_charge" placeholder="Enter Subscription Charges">
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group" style="display:none;">                            
                                        <label for="exampleInputPassword1">Transaction Share</label><span class="required"> *</span>
                                        <input type="number" step="0.1" class="form-control" id="transaction_share"  name="transaction_share" placeholder="Enter Transaction Share">
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group" style="display:none;">                          
                                        <label for="exampleInputPassword1">Video Purchase Share</label><span class="required"> *</span>
                                        <input type="number" step="0.1" class="form-control" id="VideoPurchaseShare"  name="VideoPurchaseShare" placeholder="Enter Video Purchase Share">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <div class="row">
                                <div class="col-sm-1">
                                    <button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
                                </div>
                                <div class="col-sm-1">
                                    <a href="<?php echo base_url('admin/Dealer/view_dealers');?>"><button type="button" name="cancel" id="cancel" value="cancel" class="btn btn-danger">Cancel</button></a>
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
</script>
<script>
    $('#add_client').validator();
    $.validate();
</script>