<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Payment
<!--            <small>Preview</small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Add Payment</li>
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

                    <form class="form-reset" id="payment" method="post" action="<?php echo base_url('admin/Activities/payment_donation'); ?>">

                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-6">


                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Card Number</label><span class="required">*</span>                                        
                                        <input type="number" class="form-control" required="" maxlength="20" autocomplete="off" name="cardnumber" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="Card Number">

                                    </div>

                                    <div class="form-group">

                                        <label for="exampleInputEmail1">Card Expires</label><span class="required"> *</span>

                                        <div class="col-sm-12"> 
                                            <input type="hidden" name="package" value="<?php echo $package_name; ?>" />
                                            <div class="col-sm-6"> 
                                                <label>Month</label>

                                                <?php
                                                $monthArray = range(1, 12);
                                                ?>

                                                <select name="expirymonth" class="form-control" >

                                                    <option value="">Select Month</option>

                                                    <?php
                                                    foreach ($monthArray as $month) {

                                                        // padding the month with extra zero

                                                        $monthPadding = str_pad($month, 2, "0", STR_PAD_LEFT);

                                                        // you can use whatever year you want
                                                        // you can use 'M' or 'F' as per your month formatting preference

                                                        $fdate = date("m", strtotime("2015-$monthPadding-01"));

                                                        echo '<option value="' . $monthPadding . '">' . $fdate . '</option>';
                                                    }
                                                    ?>

                                                </select>

                                            </div>

                                            <div class="col-sm-6"> 
                                                <label>Year</label>
                                                <?php
                                                $yearArray = range(2018, 2050);
                                                ?>							
                                                <select name="expiryyear" class="form-control" >
                                                    <option value="">Select Year</option>
                                                    <?php
                                                    foreach ($yearArray as $year) {
                                                        // if you want to select a particular year
                                                        $selected = ($year == "") ? 'selected' : '';
                                                        echo '<option ' . $selected . ' value="' . $year . '">' . $year . '</option>';
                                                    }
                                                    ?>

                                                </select>			

                                            </div>

                                        </div>					

                                    </div>
                                    <br><br>
                                    <div class="form-group"> 

                                        <label for="exampleInputEmail1">Card Code</label><span class="required">*</span>
                                        <input type="number" class="form-control" required="" name="cvc" maxlength="3" id="cvc" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="Enter CVC Number">

                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="box-footer">
                            <div class="row">
                                <div class="col-sm-1">
                                    <button type="submit" name="submit" value="submit" class="btn btn-primary">Pay Now</button>
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