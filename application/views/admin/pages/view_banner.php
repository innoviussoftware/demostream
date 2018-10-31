<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            View Banner
                        <!--<small>advanced tables</small>-->
        </h1>      
        <ol class="breadcrumb">			
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">View Banner</li>
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
                            <a href="<?php echo base_url('admin/Banner/view_banner'); ?>" class="btn btn-primary">Add Banner</a>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="example2" class="table table-bordered table-striped" style="font-size:14px;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Image</th>
                                        <th>URL</th>
                                        <th>Disccount Code</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    for ($r = 0; $r < sizeof($banner_detail); $r++) {
                                        ?>
                                        <?php $bn = json_decode($banner_detail[$r]['BackgroundImage']);
                                          $image_path = $banner_detail[$r]['BackgroundImage']; ?>
                                        <tr>
                                            <td><?php echo $r+1; ?></td>
                                            <td>
                                                <a href="<?php echo $image_path; ?>" target="_blank">
                                                    <img src="<?php echo $image_path; ?>" class="thumbnail" style="width:100px;height:100px;">
                                                </a>
                                            </td>
                                            <td><a href="<?php echo $banner_detail[$r]['redirecturl'];?>" target="_blank" ><?php echo $banner_detail[$r]['redirecturl'];?></a> </td>    
                                            <td><?php echo $banner_detail[$r]['code']; ?> </td>
                                            <td style="text-align: center;">
                                                <a onclick="return confirm('<?php echo base_url('admin/Banner/delete_banner/' . $banner_detail[$r]['Id']); ?>', 'Banner');" href="#">
                                                    <i class="fa fa-trash" style="color:red;"></i>
                                                </a>
                                            </td>    
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

<script>
    $(document).ready(function () {
        $('#example2').DataTable({
            responsive: true,
            scrollY: '55vh',
            scrollCollapse: true
        });

    });
</script>
