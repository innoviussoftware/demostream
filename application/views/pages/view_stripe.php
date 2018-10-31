<?php $Video_ID=$this->session->userdata['Video_ID'];?>
<div class="container middle paper-craft-middle">
    <div class="row video-img">
	</div>
	<div class="row">
		<div class="col-md-offset-0 col-md-4">
		<div class="row back-row">
			<div class="col-xs-6" style="text-align: left;">
				<a href="#" onclick="history.back();" style="color:#000;"><span class="fa fa-arrow-left"></span></a>&nbsp; <b>Success</b>
			</div>
			 <div class="col-xs-6" style="font-size: 22px;text-align: right;">
			   <a href="<?php echo base_url('Video_curl/campaign/'.$Video_ID);?>" style="color:#000;"><span class="fa fa-home"></span></a>
			</div>
		</div>
		</div>
	</div>
	<div class="row" id="donate"> 
		<div class="col-md-offset-0 col-md-4 col-xs-12"  style="background-color: whitesmoke;">
			<div class="agileits-login" style="font-size: 13px;">
			<?php echo $data_msg;?>
			</div>
		</div>
	</div>
</div>
