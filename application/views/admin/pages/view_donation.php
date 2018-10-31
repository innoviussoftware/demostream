<div class="content-wrapper">
    <!--Content Header (Page header)--> 
    <section class="content-header">
        <h1>
            My Donations
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">My Donations</li>
        </ol>
    </section>
    <!--Main content--> 
    <section class="content">

        <div class="row">

            <div class="col-md-6 col-xs-12">
                <div class="nav-tabs-custom">


                    <ul class="nav nav-tabs" style="background:#8B008B;color:white;">
                        <label style="font-size:inherit;padding:2%;">My Donations</label>
                    </ul>

                    <div class="tab-content" id="video">

                        <div class="active tab-pane" id="donors">

                            <table id="donation" style="font-size:12px;" class="table table-bordered table-striped">
                                <thead style="display: none;">
                                    <tr>
                                        <th>1</th>
                                        <th>2</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (sizeof($donationdetails) > 0) {
                                        for ($r = 0; $r < sizeof($donationdetails); $r++) {
                                            ?>


                                            <tr>
                                                <td style="width:20%;">
                                                    <img src="<?php echo $donationdetails[$r]['WrapperPath']; ?>" style="width:100%;height:80px;"/>
                                                </td>
                                                <td>   
                                                    <label><b><?php echo $donationdetails[$r]['Title']; ?></b></label><br />
                                                    <h5>$ <?php echo $donationdetails[$r]['DonationAmount']; ?></h5>

                                                    <?php
                                                    $create_date = $donationdetails[$r]['DonatedOn'];
                                                    $create_date = date('Y-m-d', strtotime($create_date));
                                                    $current_date = date('Y-m-d');

                                                    $date1 = date_create($create_date);
                                                    $date2 = date_create($current_date);
                                                    $diff = date_diff($date1, $date2);
                                                    $year = $diff->format("%y");
                                                    $month = $diff->format("%m");
                                                    if ($year > 0) {
                                                        $d = $diff->format("%y year %m month %d days");
                                                    } elseif ($month > 0) {
                                                        $d = $diff->format("%m Month %d days");
                                                    } else {
                                                        $d = $diff->format("%d days");
                                                    }
                                                    ?>

                                                    <h5 style="float:right;"><?php echo $d; ?></h5>   
                                                </td>
                                            </tr>

                                            <?php
                                        }
                                    }
                                    ?>                                    
                                </tbody>
                            </table>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
        </div>
    </section>
</div>
<script>
    $('#donation').DataTable({
        responsive: true,
        language: {
            emptyTable: "No Donations yet to view"
        }

    });
</script>