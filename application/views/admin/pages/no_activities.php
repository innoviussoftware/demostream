<?php
$package = $subscriptionpackage;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Subscription 	
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Subscription</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-12">

                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body">
                        <label class="col-md-12">
                            <center><i class="fa fa-lock" style="font-size:100px;"></i></center>
                        </label>
                        <div class="col-md-3"></div>
                        <label class="col-md-6">
                            <center>
                                <p>Transferring data into 3D secure Payment Gateway Please,do not go back or interrupt the data connection.</p>
                                <p>Demostreame One year subscription charge is 
                                    <?php
                                    if ($this->session->userdata('SubscriptionCharges')) {
                                        echo '<h3><b>$ ' .$this->session->userdata('SubscriptionCharges').'</b></h3>';
                                    }
                                    ?></p>
                                <h4><b></b></h4>
                                <a onclick="return add_package()"><button class="btn btn-info">Subscribe Now</button></a>
                            </center>
                        </label>

                        <div class="form-control" id="view_package" style="display:none;">
                            <form method="post" id="package" action="<?php echo base_url('admin/Activities/view_payment'); ?>">
                                <div class="col-xs-12">
                                    <div class="col-xs-4"></div>
                                    <div class="col-xs-4">
                                        <select class="form-control" id="pack" required="" name="package" >
                                            <option value="">Select Package</option>
                                            <?php
                                            if (sizeof($package) > 0) {
                                                for ($i = 0; $i < sizeof($package); $i++) {
                                                    ?>
                                                    <option value="<?php echo $package[$i]['PackageID']; ?>" data-key="<?php echo $package[$i]['PackAmount']; ?>"><?php echo $package[$i]['PackageName']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>

                                        </select>
                                    </div>

                                    <div class="col-xs-4">
                                        <input type="submit" name="submit" value="Subscribe" class="btn btn-info" />
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- /.box-body -->
                    </div>
                </div>



            </div>
            <!-- /.row -->

            <!-- /.content -->

        </div>

    </section>
</div>
<script>
    $(document).ready(function () {
        $('#package').validator();
        $.validate();
    });
    function add_package()
    {
        var package = $('#view_package').show();
    }
</script> 

