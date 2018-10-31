<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            View Dealers
                        <!--<small>advanced tables</small>-->
        </h1>      
        <ol class="breadcrumb">		
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">View Dealers</li>
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
                            <a href="<?php echo base_url('admin/Dealer/add_dealer'); ?>" class="btn btn-primary">Add Dealer</a>
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

                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    krsort($dealers);
                                    for ($c = 0; $c < sizeof($dealers); $c++) {
                                        ?>
                                        <tr>
                                            <td style="display: none;"><?php echo $dealers[$c]['DealerID']; ?></td>
                                            <td><?php echo $dealers[$c]['FirstName']; ?></td>
                                            <td><?php echo $dealers[$c]['LastName']; ?></td>
                                            <td><?php echo $dealers[$c]['AccountName']; ?></td>
                                            <td><?php echo $dealers[$c]['EmailID']; ?></td>

                                            <td><a href="<?php echo base_url(); ?>admin/Dealer/edit_dealer/<?php echo $dealers[$c]['DealerID']; ?>"><i class="fa fa-pencil-square-o">&nbsp;</i></a></td>
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