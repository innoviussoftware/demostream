<?php // echo "<pre>"; print_r($Userdetail); exit;                                       ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            View Subscription
                        <!--<small>advanced tables</small>-->
        </h1>      
        <ol class="breadcrumb">		
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">View Subscription</li>
        </ol>

    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <!-- /.box -->
                <div class="box">
                    <div class="box-header">						
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
                    <div class="row">
                        <div class="col-xs-12">                         

                            <div class="col-xs-2 pull-right" style="text-align:  right;padding-right:  2%;">
                                <a href="<?php echo base_url('admin/Clients/add_subscription'); ?>" style="margin-top: 14%;" class="btn btn-primary">Add Subscription</a>
                            </div>

                            <!-- Date range -->
                            <div class="col-sm-4 form-group">
                                <label>Subscription date range</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" id="date" required="" placeholder="Enter subscription date range" name="date"  value="" class="form-control pull-left" autocomplete="off" />
                                </div>
                                <div class="help-block with-errors"></div>
                                <!-- /.input group -->
                            </div>
                            <!-- Date range -->
                            <div class="col-sm-4 form-group">
                                <label>Subscription end date range</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" id="date1"  placeholder="Enter subscription end date range" name="date"  value="" class="form-control pull-left" autocomplete="off" />
                                </div>
                                <div class="help-block with-errors"></div>
                                <!-- /.input group -->
                            </div>
                            <div class="col-xs-1">
                                <div class="form-group" style="margin-top: 37%;">
                                    <input type="button" class="btn btn-primary" style="padding: 5px 35px !important;" name="search" onclick="search();" value=" Search "/>
                                </div>
                            </div>
                            <!-- /.form group -->


                        </div>
                    </div>
                </div>
                <div class="box">
                    <?php if (sizeof($Userdetail) > 0) { ?>
                        <div class="row" style="display: none;">
                            <div class="col-xs-2 pull-right" style="margin-top: 1%;text-align:  right;padding-right:  2%;">
                                <a href="<?php echo base_url('admin/Export/subscription'); ?>" class="btn btn-primary">
                                    <i class="fa fa-download"> </i> Export CSV
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="table-responsive">
                                    <table id="view_sub" style="font-size:12px;" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>User Name</th>
                                                <th>Subscription Date</th>
                                                <th>Subscription Amount</th>
                                                <th>Invoice Id</th>
                                                <th>From Date</th>
                                                <th>End Date</th>
                                                <th>Account Name</th>
                                                <th>Action</th>
                                                <th>Email Address</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($Userdetail as $s) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $s['FirstName'] . ' ' . $s['LastName']; ?></td>
                                                    <?php $traveldate = strtotime($s['SubscriptionDate']); ?>
                                                    <td><?php echo date('m/d/Y', $traveldate) ?></td>
                                                    <td><?php echo $s['SubscriptionAmount']; ?></td>
                                                    <td><?php echo $s['InvoiceId']; ?></td>
                                                    <?php $SubFromDate = strtotime($s['SubFromDate']); ?>
                                                    <td><?php echo date('m/d/Y', $SubFromDate) ?></td>
                                                    <?php $SubEndDate = strtotime($s['SubEndDate']); ?>
                                                    <td><?php echo date('m/d/Y', $SubEndDate) ?></td>       
                                                    <td><?php echo $s['AccountName']; ?></td>
                                                    <td><a href="<?php echo base_url(); ?>admin/Clients/edit_view_subscription/<?php echo $s['SubscriptionId']; ?>"><i class="fa fa-pencil-square-o">&nbsp;</i></a></td>
                                                    <td><?php echo $s['EmailID']; ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<script>





    $('#search_form').validator();
    var table = $('#view_sub').DataTable({
        language: {
            emptyTable: "No Subscriptions yet to view"
        },
        dom: 'Bfrtip',
        lengthChange: false,
        buttons: [
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 8]
                }
            },
            {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 8]
                }
            }
        ],
        columnDefs: [
            {"visible": false, "targets": 8}
        ]
    });
    table.buttons().container()
            .insertBefore('#example_filter');

</script>
<script type="text/javascript">
    $(function () {
        $('input[name="date"]').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        $('input[name="date"]').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });

        $('input[name="date"]').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });

    });

    function search() {
        var search_date = $('#date').val();
        var search_date1 = $('#date1').val();
        $.ajax({
            type: "POST",
            data: {search_date: search_date, search_date1: search_date1},
            url: '<?php echo base_url() ?>admin/Clients/search_subscription',
            success: function (result) {
                if (result != '') {
                    $("#view_sub").dataTable().fnDestroy()
                    $('#view_sub').html(result);
                    var table = $('#view_sub').DataTable({
                        language: {
                            emptyTable: "No Subscriptions yet to view"
                        },
                        dom: 'Bfrtip',
                        lengthChange: false,
                        buttons: [
                            {
                                extend: 'excelHtml5',
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4, 5, 6, 8]
                                },
                                {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 8]
                }
            }
                            }
                        ],
                        columnDefs: [
                            {"visible": false, "targets": 8}
                        ]
                    });
                    table.buttons().container()
                            .insertBefore('#example_filter');

                } else {
                }
            }
        });
    }
</script>