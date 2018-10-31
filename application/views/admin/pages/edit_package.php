<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Edit Package
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Edit Package</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12 col-xs-12">
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
                    <div class="box-body">
                        <form role="form" class="form-reset form-horizonatal" method="post" id="edit_package" action="<?php echo base_url('admin/Activities/update_package'); ?>">
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Package Name</label>   
                                    <input type="hidden" name="PackageID" value="<?php echo $edit_package['PackageID']; ?>"     />                                
                                    <input type="hidden" name="CreatedOnMobile" value="<?php echo $edit_package['CreatedOnMobile']; ?>"     />  
                                    <input type="hidden" name="CreatedOn" value="<?php echo $edit_package['CreatedOn']; ?>"     />                                
                                    <input type="hidden" name="IsDeleted" value="<?php echo $edit_package['IsDeleted']; ?>"     />                                

                                    <input type="text" class="form-control" name="PackageName" id="name" value="<?php echo $edit_package['PackageName']; ?>" required="" placeholder="Enter Package Name">
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Price</label>       
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-dollar"></i>
                                        </div>
                                        <input type="number" max="10000" class="form-control" value="<?php echo $edit_package['PackAmount']; ?>" name="PackAmount" id="price" required="" placeholder="Enter Price">
                                    </div>
                                    <div class="help-block with-errors"></div>

                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Months</label>                                        
                                    <input type="number" max="120" step="0.1" class="form-control" value="<?php echo $edit_package['NoOfDays']; ?>" required="" name="NoOfDays" id="month"  placeholder="Enter Months">
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="submit" value="submit" class="btn btn-primary"/>
                                    <button type="button" name="cancel" id="cancel" value="cancel" class="btn btn-danger">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> 
    </section>
</div>


<script>
    $('#edit_package').validator();
</script>
