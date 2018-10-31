<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            View Clients
                        <!--<small>advanced tables</small>-->
        </h1>      
        <ol class="breadcrumb">	
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">View Clients</li>
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
                        <div class="col-xs-2 pull-right" style="text-align:  right;padding-right:  2%;">
                            <a href="<?php echo base_url('admin/Clients/add_clients'); ?>" class="btn btn-primary">Add Client</a>
                        </div>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="example" style="font-size: 13px;" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="display: none;">#</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Account Name</th>
                                        <th style="width: 30%;">Email ID</th>
                                        <th>Subscribed</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                   // echo '<pre>';print_r($clients);
                                    krsort($clients);
                                    for ($c = 0; $c < sizeof($clients); $c++) {
                                   // echo $clients[$c]['FirstName'];
                                        ?>
                                        <tr>
                                            <td style="display: none;"><?php echo $clients[$c]['UserID']; ?></td>
                                            <td><?php echo $clients[$c]['FirstName']; ?></td>
                                            <td><?php echo $clients[$c]['LastName']; ?></td>
                                            <td><?php echo $clients[$c]['AccountName']; ?></td>
                                            <td><?php echo $clients[$c]['EmailID']; ?></td>
                                            <td><?php
                                                if ($clients[$c]['IsSubscribed'] != '') {
                                                    echo 'Yes';
                                                } else {
                                                    echo 'No';
                                                }
                                                ?>
                                            </td>
                                            <td><a href="<?php echo base_url(); ?>admin/Clients/edit_client/<?php echo $clients[$c]['UserID']; ?>"><i class="fa fa-pencil-square-o">&nbsp;</i></a></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
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