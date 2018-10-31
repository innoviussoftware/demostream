<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Add Package
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Add Package</li>
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

                    <form role="form" class="form-reset" method="post" id="add_new_package" action="<?php echo base_url('admin/Clients/add_new_package'); ?>" enctype="multipart/form-data">

                        <div class="" id='appending_div'>
                            <div class="box-body">
                                <div class="row">

                                    <div class="form-group col-xs-4">
                                        <label for="exampleInputEmail1">Package Name</label>                                       
                                        <input type="text" class="form-control" name="name[]" id="name" required="" placeholder="Enter Package Name">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group col-xs-4">
                                        <label for="exampleInputEmail1">Price</label>       
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-dollar"></i>
                                            </div>
                                            <input type="number" max="10000" class="form-control" name="price[]" id="price" required="" placeholder="Enter Price">
                                        </div>
                                        <div class="help-block with-errors"></div>

                                    </div>

                                    <div class="form-group col-xs-4">
                                        <label for="exampleInputEmail1">Months</label>                                        
                                        <input type="number" max="120" step="0.1" class="form-control" required="" name="month[]" id="month"  placeholder="Enter Months">
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group">
                                        <button type="button" style="float: right;margin-right:1%;;margin-top: 0px;margin-left:0;" class="add_city btn btn-primary"><i class="fa fa-plus"></i></button>
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
                                    <button type="button" name="cancel" id="cancel" value="cancel" class="btn btn-danger">Cancel</button>
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
    $('body').on('click', '.add_city', function () {

    //alert('aa');
    $('#appending_div').append('<div class="box box-primary"><div class="box-body"><div class="row"><div class="form-group col-xs-4"><label for="exampleInputEmail1">Package Name</label><input type="text" required=""  class="form-control" name="name[]"  placeholder="Enter Package Name"><div class="help-block with-errors"></div></div><div class="form-group col-xs-4"><label for="exampleInputEmail1">Price</label><input type="text" class="form-control" required=""  name="price[]"  placeholder="Enter Price"><div class="help-block with-errors"></div></div><div class="form-group col-xs-4"><label for="exampleInputEmail1">Months</label><input type="number" step="0.1" class="form-control" required="" name="month[]" placeholder="Enter Months"><div class="help-block with-errors"></div></div><div class="form-group"><button type="button"  style="float: right;margin-right:1%;;margin-top: 0px;margin-left:0;" class="remove_city btn btn-danger"><i class="fa fa-minus"></i></button></div></div></div></div>');
    init();
    });
    $(document).ready(function () {
    $('#add_new_package').validator();
    $.validate();
    });
    $('body').on('click', '.remove_city', function () {
    $('#appending_div').children().last().remove();
    count--;
    });
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

</script>
