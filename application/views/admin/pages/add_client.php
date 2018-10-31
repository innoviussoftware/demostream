<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Add Client
<!--            <small>Preview</small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Add Client</li>
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
                    <form role="form" class="form-reset" method="post" id="add_client" action="<?php echo base_url('admin/Clients/add_new_clients'); ?>" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class=" col-xs-6">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Account Name</label><span class="required"> *</span>
                                        <input type="text" class="form-control" id="account_name"  name="account_name" placeholder="Enter Account Name">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">First Name</label><span class="required"> *</span>                                        
                                        <input type="text" class="form-control " name="firstname" id="firstname" maxlength="30" placeholder="Enter First name"  autocomplete="off" required />
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Last Name</label><span class="required"> *</span>                                        
                                        <input type="text" class="form-control " name="lastname" id="lastname" maxlength="30" placeholder="Enter Last name"  autocomplete="off" required />
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email-ID</label><span class="required"> *</span>

                                        <input type="email" class="form-control" name="emailid" id="emailid" placeholder="Enter Your Email-ID"  autocomplete="off" required />
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Password</label><span class="required"> *</span>

                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password"  autocomplete="off" required /> 
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">City</label><span class="required"> *</span>

                                        <input type="text" class="form-control" id="city" name="city" placeholder="Enter City"> 
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">State</label><span class="required"> *</span>
                                        <input type="text" class="form-control" id="state" name="state" placeholder="Enter branch State"  autocomplete="off" required />
                                        <div class="help-block with-errors"></div>
                                    </div> 
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Country</label><span class="required"> *</span>
                                        <input type="text" class="form-control" id="country"  name="country" placeholder="Enter Country"  autocomplete="off" required />
                                        <div class="help-block with-errors"></div>
                                    </div>


                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Contact Number</label><span class="required"> *</span>
                                        <input type="number" class="form-control" id="phone"  name="phone" placeholder="Enter Contact Number">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>



                                <div class=" col-xs-6">


                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Website</label><span class="required"> *</span>
                                        <input type="text" class="form-control" id="website"  name="website" placeholder="Enter Website">
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Profile Pic</label>
                                        <input type="file" class="" id="userfile"  name="userfile" placeholder="Enter Website">
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Logo</label>
                                        <input type="file" class="" id="logo"  name="logo" placeholder="Enter Website">
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Domain</label>   <span class="required"> *</span>                                     
                                        <input type="text" class="form-control " name="domain" id="domain" maxlength="30" placeholder="Enter Domain name"  autocomplete="off" required />
                                        <div class="help-block with-errors"></div>
                                    </div>


                                    

                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Subscription Charges</label><span class="required"> *</span>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-dollar"></i>
                                            </div>
                                            <input type="number" step="0.1" class="form-control" id="sub_charge"  name="sub_charge" placeholder="Enter Subscription Charges">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Transaction Share</label><span class="required"> *</span>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-percent"></i>
                                            </div>
                                            <input type="number" step="0.1" class="form-control" id="transaction_share"  name="transaction_share" placeholder="Enter Transaction Share">
                                            <div class="help-block with-errors"></div>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Video Purchase Share</label><span class="required"> *</span>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-percent"></i>
                                            </div>

                                            <input type="number" step="0.1" class="form-control" id="VideoPurchaseShare"  name="VideoPurchaseShare" placeholder="Enter Video Purchase Share">
                                            <div class="help-block with-errors"></div>
                                        </div>

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
                                    <a href="<?php echo base_url('admin/Clients/view_clients');?>">
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



<script>
    $('#add_client').validator();
    $.validate();
</script>