<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Add Banners
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Add Banner</li>
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

                    <form role="form" class="form-reset" method="post" id="add_logo" action="<?php echo base_url('admin/Banner/add_new_banner'); ?>" enctype="multipart/form-data">

                        <div class="box box-primary" id='appending_div'>
                            <div class="box-body">
                                <div class="row">

                                    <div class="form-group col-xs-4">
                                        <label for="exampleInputEmail1">Background Image</label>                                        
                                        <input type="file" class="form-control" name="background_image[]" id="background_image"  placeholder="Enter Number Of Background Image" >
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group col-xs-4">
                                        <label for="exampleInputEmail1">Image URL</label>                                       
                                        <input type="text" class="form-control" name="image_url[]" id="image_url"  placeholder="Enter Background Image URL">
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group col-xs-4">
                                        <label for="exampleInputEmail1">Discount Code</label>                                        
                                        <input type="text" class="form-control" name="code[]" id="code"  placeholder="Enter Discount Code">
                                        <div class="help-block with-errors"></div>

                                        <div class="form-group">
                                            <button type="button" style="float: right;margin-top: 0px;margin-left:0;" class="add_city btn btn-primary"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>       
                                </div>
                            </div>
                        </div>

                        <div class="box-footer">
                            <div class="row">
                                <div class="col-sm-1">
                                    <button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
                                </div>
                                <div class="col-sm-1">
                                    <a href="<?php echo base_url('admin/Banner/viewall_banner'); ?>">
                                        <button type="button" name="cancel" id="cancel" value="cancel" class="btn btn-danger">Cancel</button>
                                    </a>
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
    function btn(total)
    {
        if (total > 1)
        {
            document.getElementById('pluse').style.display = '';
        } else if (total = 1)
        {
            document.getElementById('pluse').style.display = 'none';
        }
    }
    $(document).ready(function () {
        init();
        $(document).ready(function () {
            $('body').on('click', '.remove_city', function () {
                $('#appending_div').children().last().remove();
                count--;
            });
        });
        function init()
        {
            var autocomplete;
            $(".city").each(function () {
                var id = $(this).attr('id');
                var input = document.getElementById(id);
                autocomplete = new google.maps.places.Autocomplete(input,
                        {types: ['(cities)']
                        });
            });
        }


        $('body').on('click', '.add_city', function () {

            //alert('aa');
            $('#appending_div').append('<div class="box box-primary"><div class="box-body"><div class="row"><div class="form-group col-xs-4"><label for="exampleInputEmail1">Background Image</label><input type="file" class="form-control" name="background_image[]" id="background_image"  placeholder="Enter Number Of Background Image"><div class="help-block with-errors"></div></div><div class="form-group col-xs-4"><label for="exampleInputEmail1">Image URL</label><input type="text" class="form-control" name="image_url[]" id="image_url"  placeholder="Enter Background Image URL"><div class="help-block with-errors"></div></div><div class="form-group col-xs-4"><label for="exampleInputEmail1">Discount Code</label><input type="text" class="form-control" name="code[]" id="code"  placeholder="Enter Discount Code"><div class="help-block with-errors"></div><div class="form-group"><button type="button"  style="float: right;margin-top: 20px;margin-left: 2%;" class="remove_city btn btn-danger"><i class="fa fa-minus"></i></button></div></div></div></div></div>');
            init();
        });
    })
</script>

<script>
    $('#add_logo').validator();
    $.validate();
</script>