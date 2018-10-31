<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            View Packages
                        <!--<small>advanced tables</small>-->
        </h1>      
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">View Packages</li>
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
                            <a href="<?php echo base_url('admin/Clients/add_package'); ?>" class="btn btn-primary">Add Package</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="example" style="font-size: 13px;" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="display: none;">#</th>
                                        <th>Package Name</th>
                                        <th>Package Amount</th>
                                        <th>Months</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    krsort($package);
                                   // print_r($package);
                                    for ($c = 0; $c < sizeof($package); $c++) {
                                        if ($package[$c]['IsDeleted'] == 0) {
                                      //  print_r($package[$c]);
                                            ?>
                                            <tr>
                                                <td style="display: none;"><?php echo $package[$c]['PackageID']; ?></td>
                                                <td><?php echo $package[$c]['PackageName']; ?></td>
                                                <td><?php echo '$ ' . $package[$c]['PackAmount']; ?></td>
                                                <td><?php echo $package[$c]['NoOfDays']; ?> Months</td>
                                                <td><a href="<?php echo base_url(); ?>admin/Activities/edit_package/<?php echo $package[$c]['PackageID']; ?>"><i class="fa fa-pencil-square-o">&nbsp;</i></a> 
                                                <a onclick="return confirm('<?php echo base_url('admin/Activities/delete_package/' . $package[$c]['PackageID']); ?>', 'Package');" href="#">
                                                        <i class="fa fa-trash" style="margin-right:2%;color:red;"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
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