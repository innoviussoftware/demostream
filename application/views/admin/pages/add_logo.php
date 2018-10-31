<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Add Logo/Banners
<!--            <small>Preview</small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Add Banners</li>
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
                    
                    <form role="form" class="form-reset" method="post" id="add_logo" action="<?php echo base_url('admin/Clients/add_new_logo'); ?>" enctype="multipart/form-data">
                        
                        <div class="box-body">
                            <div class="row">
                                <div class=" col-xs-6">
                                
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Logo</label><span class="required"> *</span>
                                        <input type="file" class="form-control" id="logo"  name="logo" placeholder="Enter Website">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    
                                   </div>
                                    
                                <div class=" col-xs-6">
									
                                     <div class="form-group">
                                        <label for="exampleInputEmail1">Domain</label><span class="required"> *</span>                                        
                                        <input type="text" class="form-control " name="domain" id="domain" maxlength="30" placeholder="Enter Domain name" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                   
                                </div>
                               
                                <div class="col-md-6">
                               		<div class="form-group" style="float:left;width:50%;">
                                        <label for="exampleInputEmail1">Number Of Background Images</label><span class="required"> *</span>                                        
                                        <input type="number" class="form-control" onChange="return btn(this.value);" name="background_image_total" id="total"  placeholder="Enter Number Of Background Image" required>
                                        <div class="help-block with-errors"></div>
                                    	     
                                    </div>
                                   
                                    <div class="from-group">
                                    <button id="pluse" type="button" style="display:none;float:left;margin-top:28px;margin-left:42%;" class="add_city btn btn-primary"><i class="fa fa-plus"></i></button>
                                    
                                   </div> 

								</div>
                                
                                <div class="col-md-6">
                                	 <label for="exampleInputEmail1">User</label><span class="required"> *</span>
                                     <select class="form-control" name="user_id">
                                     	<option>Select User</option>
                                     	<option value="">Abc</option>
                                     </select>
                                </div>	
                            </div>
                        </div>
                        
                        <div class="box box-primary">
						<div class="box-body">
                            <div class="row">
                        <div class="col-xs-12" id='appending_div'>
                                
                                <div class="form-group col-xs-4">
                                        <label for="exampleInputEmail1">Background Image</label><span class="required"> *</span>                                        
                                        <input type="file" class="form-control" name="background_image[]" id="background_image"  placeholder="Enter Number Of Background Image" >
                                        <div class="help-block with-errors"></div>
                                    </div>
								
                                <div class="form-group col-xs-4">
                                        <label for="exampleInputEmail1">Image URL</label><span class="required"> *</span>                                        
                                        <input type="text" class="form-control" name="image_url[]" id="image_url"  placeholder="Enter Background Image URL" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
								
                                
                                <div class="form-group col-xs-4">
                                        <label for="exampleInputEmail1">Discount Code</label><span class="required"> *</span>                                        
                                        <input type="text" class="form-control" name="code[]" id="code"  placeholder="Enter Discount Code" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
								</div>
                        </div></div></div>
                        
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
function btn(total)
{
	if(total>1)
	{
		document.getElementById('pluse').style.display='';
	}
	else if(total=1)
	{
		document.getElementById('pluse').style.display='none';	
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
		var count = 0;	
        $('body').on('click', '.add_city', function () {
			$("#total").prop("readonly", true);
			var limite = $('#total').val();
		 	count++;
			if(count<limite){
            $('#appending_div').append('<div class="form-group col-xs-4"><label for="exampleInputEmail1">Background Image</label><span class="required">*</span><input type="file" class="form-control" name="background_image[]" placeholder="Enter Number Of Background Image"><div class="help-block with-errors"></div></div><div class="form-group col-xs-4"><label for="exampleInputEmail1">Image URL</label><span class="required"> *</span><input type="text" class="form-control" name="image_url[]" id="image_url" placeholder="Enter Background Image URL" required><div class="help-block with-errors"></div></div><div class="form-group col-xs-4"><label for="exampleInputEmail1"> Discount Code</label><span class="required"> *</span><input type="text" class="form-control" name="code[]" id="code" placeholder="Enter Discount Code" required><div class="help-blockwith-errors"></div></div>');}
			 init();
        });
    });


</script>

<script>
    $('#add_logo').validator();
    $.validate();
</script>