
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            User Profile
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">User profile</li>
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
                 <!-- Profile Image -->
                <div class="box box-primary">

                    <div class="box-body box-profile">
                        <?php
                            if (!empty($this->session->userdata['profile_picture'])) {
                            
                            $haystack = $this->session->userdata['profile_picture'];
                            $needle = 'http';

                            if (strpos($haystack,$needle) !== false) {
                                // echo $haystack.' contains '.$needle;
                                $file = $haystack;   
                            }else{
                                $file = base_url() . $this->session->userdata['profile_picture'];
                            }
                        } else {
                            $file = base_url() . 'assets/images/unknown.jpg';
                        }
                        ?> 

                        <img class="profile-user-img img-responsive hidden-xs" style="width: 200px;height: 200px;float: left;" src="<?php echo $file; ?>" alt="User profile picture">
                        
                        <img class="profile-user-img img-responsive hidden-sm hidden-lg hidden-md" style="width: 100%;height: 200px;" src="<?php echo $file; ?>" alt="User profile picture">
                        
                        <h3 class="profile-username text-center hidden-xs"><b><?php echo $profile['userID']['FirstName'] . ' ' . $profile['userID']['LastName']; ?></b></h3>
                        <br />
                        <table class="" id="pro_detail">
                            <tr class="hidden-sm hidden-lg hidden-md">
                                <td colspan="2" style="padding: 8px 15px;text-align: center;">
                                    <h3><?php echo $profile['userID']['FirstName'] . ' ' . $profile['userID']['LastName']; ?></h3>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 8px 15px;text-align: left;"><b>Account Name</b></td>
                                <td><?php echo $profile['userID']['AccountName']; ?></td>
                            </tr>
                            <tr>
                                <td style="padding: 8px 15px;text-align: left;"><b>City</b></td>
                                <td><?php echo $profile['userID']['City']; ?></td>
                            </tr>
                            <tr>
                                <td style="padding: 8px 15px;text-align: left;"><b>State</b></td>
                                <td><?php echo $profile['userID']['State']; ?></td>
                            </tr>
                            <tr>
                                <td style="padding: 8px 15px;text-align: left;"><b>Country</b></td>
                                <td><?php echo $profile['userID']['Country']; ?></td>
                            </tr>
                        </table>

                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <!-- /.box -->

            <!-- About Me Box -->

            <!-- /.col -->
            <div class="col-md-6">
                <div class="nav-tabs-custom">

                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#edit" data-toggle="tab">Edit Profile</a></li>
                        <li><a href="#reset" data-toggle="tab">Change Password</a></li>
                    </ul>

                    <div class="tab-content">

                        <!--<div class="active tab-pane" id="profile">
                                  <table class="table table-striped">
                                      <tr>
                                          <td style="width: 30%;">First Name :</td>
                                          <td><?php echo $profile['userID']['FirstName']; ?></td>
                                      </tr> 
                                      <tr>
                                          <td style="width: 30%;">Last Name</td>
                                          <td><?php echo $profile['userID']['LastName']; ?></td>
                                      </tr>
                                      <tr>
                                          <td style="width: 30%;">AccountName</td>
                                          <td><?php echo $profile['userID']['AccountName']; ?></td>
                                      </tr>
                                      <tr>
                                          <td style="width: 30%;">City</td>
                                          <td><?php echo $profile['userID']['City']; ?></td>
                                      </tr>
                                      <tr>
                                          <td style="width: 30%;">State</td>
                                          <td><?php echo $profile['userID']['State']; ?></td>
                                      </tr>
                                      <tr>
                                          <td style="width: 30%;">Country</td>
                                          <td><?php echo $profile['userID']['Country']; ?></td>
                                      </tr>
      
                                  </table>
                              </div>-->

                        <div class="active tab-pane" style="padding: 5%;" id="edit">

                            <form method="post" enctype="multipart/form-data" class="form-horizontal" action="<?php echo base_url('admin/Users/edit_profile'); ?>">

                                <input type="hidden" name="ProfileID" value="<?php echo $profile['userID']['ProfileID']; ?>">
                                <input type="hidden" name="UserID" value="<?php echo $profile['userID']['UserID']; ?>">
                                <input type="hidden" name="ProfilePICPath" value="<?php echo $profile['userID']['ProfilePICPath']; ?>">
                                <input type="hidden" name="DeviceID" value="<?php echo $profile['userID']['DeviceID']; ?>">
                                <input type="hidden" name="CreatedOnMobile" value="<?php echo $profile['userID']['CreatedOnMobile']; ?>">
                                <input type="hidden" name="CreatedOn" value="<?php echo $profile['userID']['CreatedOn']; ?>">
                                <input type="hidden" name="UpdatedOnMobile" value="<?php echo $profile['userID']['UpdatedOnMobile']; ?>">
                                <input type="hidden" name="UpdatedOn" value="<?php echo $profile['userID']['UpdatedOn']; ?>">
                                <input type="hidden" name="MobileRowOrderNo" value="<?php echo $profile['userID']['MobileRowOrderNo']; ?>">

                                <input type="hidden" name="EmailID" value="<?php echo $profile['userID']['EmailID']; ?>">
                                <input type="hidden" name="Password" value="<?php echo $profile['userID']['Password']; ?>">
                                <input type="hidden" name="IsSignWithSocialMedia" value="<?php echo $profile['userID']['IsSignWithSocialMedia']; ?>">
                                <input type="hidden" name="SubscriptionCharges" value="<?php echo $profile['userID']['SubscriptionCharges']; ?>">
                                <input type="hidden" name="TransactionShare" value="<?php echo $profile['userID']['TransactionShare']; ?>">
                                <input type="hidden" name="VideoPurchaseShare" value="<?php echo $profile['userID']['VideoPurchaseShare']; ?>">
                                <input type="hidden" name="Region" value="<?php echo $profile['userID']['Region']; ?>">
                                <input type="hidden" name="IsAdmin" value="<?php echo $profile['userID']['IsAdmin']; ?>">
                                <input type="hidden" name="IsSuperAdmin" value="<?php echo $profile['userID']['IsSuperAdmin']; ?>">
                                <input type="hidden" name="website" value="<?php echo $profile['userID']['Website']; ?>">
                                <input type="hidden" name="logo" value="<?php echo $profile['userID']['Logo']; ?>">
                                <input type="hidden" name="mobile" value="<?php echo $profile['userID']['MobileNo']; ?>">
                                <input type="hidden" name="Domain" value="<?php echo $profile['userID']['Domain']; ?>">

                                <div class="form-group">
                                    <label style="text-align:left;font-style: normal" for="inputName" class="col-sm-4 control-label">First Name</label>

                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" value="<?php echo $profile['userID']['FirstName']; ?>" name="FirstName"   placeholder="First Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label style="text-align:left;font-style: normal" for="inputEmail" class="col-sm-4 control-label">Last Name</label>

                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" value="<?php echo $profile['userID']['LastName']; ?>" name="LastName"   placeholder="Last Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label style="text-align:left;font-style: normal" for="inputName" class="col-sm-4 control-label">Account Name</label>

                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" value="<?php echo $profile['userID']['AccountName']; ?>" name="AccountName"   placeholder="AccountName">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label style="text-align:left;font-style: normal" for="inputExperience" class="col-sm-4 control-label">City</label>

                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" value="<?php echo $profile['userID']['City']; ?>" name="City"   placeholder="City">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="text-align:left;font-style: normal" for="inputExperience" class="col-sm-4 control-label">State</label>

                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" value="<?php echo $profile['userID']['State']; ?>" name="State"   placeholder="State">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="text-align:left;font-style: normal" for="inputExperience" class="col-sm-4 control-label">Country</label>

                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" value="<?php echo $profile['userID']['Country']; ?>" name="Country"   placeholder="Country">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="text-left col-sm-4">Profile Image</label>


                                    <input type="file" class="col-sm-8" name="userfile" id="image"/>
                                    <?php
                                    $filename = $file;
                                    if ($filename != '') {
                                        ?>
                                        <img src="<?php echo $filename; ?>" alt="Image preview" style="margin-top: 2%;margin-left: 3%;" class="col-xs-12 col-sm-3 img-thumbnail thumbnail">
                                        <?php
                                    }
                                    ?>	

                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-4 col-sm-8">
                                        <button  type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane" style="padding: 5%;" id="reset">
                            <form method="post" class="form-horizontal" action="<?php echo base_url('admin/Users/reset_password'); ?>">

                                <input type="hidden" name="ProfileID" value="<?php echo $profile['userID']['ProfileID']; ?>">
                                <input type="hidden" name="UserID" value="<?php echo $profile['userID']['UserID']; ?>">

                                <input type="hidden" value="<?php echo $profile['userID']['FirstName']; ?>" name="FirstName">
                                <input type="hidden" value="<?php echo $profile['userID']['LastName']; ?>" name="LastName">
                                <input type="hidden" value="<?php echo $profile['userID']['AccountName']; ?>" name="AccountName">
                                <input type="hidden" value="<?php echo $profile['userID']['City']; ?>" name="City">
                                <input type="hidden" value="<?php echo $profile['userID']['State']; ?>" name="State" >
                                <input type="hidden" name="UserID" value="<?php echo $profile['userID']['UserID']; ?>">
                                <input type="hidden"value="<?php echo $profile['userID']['Country']; ?>" name="Country">

                                <input type="hidden" name="ProfilePICPath" value="<?php echo $profile['userID']['ProfilePICPath']; ?>">
                                <input type="hidden" name="DeviceID" value="<?php echo $profile['userID']['DeviceID']; ?>">
                                <input type="hidden" name="CreatedOnMobile" value="<?php echo $profile['userID']['CreatedOnMobile']; ?>">
                                <input type="hidden" name="CreatedOn" value="<?php echo $profile['userID']['CreatedOn']; ?>">
                                <input type="hidden" name="UpdatedOnMobile" value="<?php echo $profile['userID']['UpdatedOnMobile']; ?>">
                                <input type="hidden" name="UpdatedOn" value="<?php echo $profile['userID']['UpdatedOn']; ?>">
                                <input type="hidden" name="MobileRowOrderNo" value="<?php echo $profile['userID']['MobileRowOrderNo']; ?>">

                                <input type="hidden" name="EmailID" value="<?php echo $profile['userID']['EmailID']; ?>">
                                <input type="hidden" id="password" name="Password" value="<?php echo $profile['userID']['Password']; ?>">

                                <input type="hidden" name="IsSignWithSocialMedia" value="<?php echo $profile['userID']['IsSignWithSocialMedia']; ?>">
                                <input type="hidden" name="SubscriptionCharges" value="<?php echo $profile['userID']['SubscriptionCharges']; ?>">
                                <input type="hidden" name="TransactionShare" value="<?php echo $profile['userID']['TransactionShare']; ?>">
                                <input type="hidden" name="VideoPurchaseShare" value="<?php echo $profile['userID']['VideoPurchaseShare']; ?>">
                                <input type="hidden" name="Region" value="<?php echo $profile['userID']['Region']; ?>">
                                <input type="hidden" name="IsAdmin" value="<?php echo $profile['userID']['IsAdmin']; ?>">


                                <div class="form-group">
                                    <label style="text-align:left;font-style: norma" for="inputName" class="col-sm-5 control-label">Old Password</label>

                                    <div class="col-sm-7">
                                        <input type="password" class="form-control" onchange="return reset_password();"  name="old_password" id="old_password" placeholder="Enter Old Password">
                                        <span id="old_error" style="display:none;color:red;">Not Match</span>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label style="text-align:left;font-style: norma" for="inputName" class="col-sm-5 control-label">New Password</label>

                                    <div class="col-sm-7">
                                        <input type="password" class="form-control" name="new_password" id="new_password" placeholder="Enter New Password">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="text-align:left;font-style: norma" for="inputName" class="col-sm-5 control-label" >Confirm Password</label>

                                    <div class="col-sm-7">
                                        <input type="password" class="form-control" name="confirm_password" onchange="return con_password();" id="confirm_password" placeholder="Enter Confirm Password">
                                        <span id="error" style="display:none;color:red;">Not Match</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-5 col-sm-7">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>

    <!-- /.content -->

</div>
<!-- /.content-wrapper -->

<script>
    function reset_password()
    {
        var pass = document.getElementById("password").value;
        var old_pass = document.getElementById("old_password").value;

        //alert(pass);
        if (pass == old_pass)
        {
            document.getElementById('old_error').style.display = 'none';
        } else
        {
            document.getElementById('old_error').style.display = '';
            old_pass.focus();
        }
    }

    function con_password()
    {
        var new_pass = document.getElementById("new_password").value;
        var cpass = document.getElementById("confirm_password").value;
        //alert(pass);
        if (new_pass == cpass)
        {
            document.getElementById('error').style.display = 'none';
        } else
        {
            document.getElementById('error').style.display = '';
            cpass.focus();
        }
    }
</script>


