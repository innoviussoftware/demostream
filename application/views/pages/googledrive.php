<?php 
	//echo '<pre>';
	//print_r($collaborate_deatils);	
	$size= sizeof($collaborate_deatils['dropboxsharedfiles']);
	$Video_ID=$this->session->userdata['Video_ID'];
	$iscampaign=$this->session->userdata['iscampaign'];
?>		
<div class="container middle paper-craft-middle">
	<div class="row video-img">
		
	</div>
	 <div class="row">
		<div class="col-md-offset-0 col-md-4 col-xs-12">
		<div class="row back-row">
			<div class="col-xs-8" style="text-align: left;">
				<a href="#" onclick="history.back();" style="color:#000;"><span class="fa fa-arrow-left"></span></a>&nbsp; <b>Collaborate</b>
			</div>
			 <div class="col-xs-4" style="font-size: 18px;text-align: right;">
				<a href="<?php if($iscampaign == 1){  echo base_url('Video_curl/campaign/'.$Video_ID); }else{ echo base_url('Video_curl/video/'.$Video_ID); }?>" style="color:#000;"><span class="fa fa-home"></span></a>
			</div>
		</div>
		</div>
	</div>

  <div class="row">
	<div class="col-md-offset-0 col-md-4 col-xs-12"  style="background-color: whitesmoke;padding-right: 0px;padding-left: 0px;">
        <ul class="cmt nav comment-tabs" style="background-color: white;">
			<li class="active">
			<a data-toggle="tab" href="#my_files">&nbsp;MY FILES</a></li>
			<li>
			<a data-toggle="tab" href="#shared_files">SHAREDFILES</a></li>
        </ul>
	
		<div class="tab-content" style="color: black;height:300px;width:100%;">
			<div id="my_files" class="tab-pane fade in active" style="height:290px;">
					<div class="col-md-12 col-xs-12">
								<p style="text-align: center;font-size: 12px;padding-top: 5px">Tap here to refresh & Click item to share</p>
								<ul class="list-group">  
									<?php 
									$i=0;
									for($i==0; $i < $size; $i++){
										$files_data=$collaborate_deatils['dropboxsharedfiles'];
									
										 $shareTo=$files_data[$i]['SharedTo'];
										 $fileLink= $files_data[$i]['FileLink'];
										 $fileName=$files_data[$i]['FileName'];
										if($shareTo == 0){
											?>
											 <li class="list-group-item justify-content-between" style="margin-top: 10px;margin-bottom: 10px;">
												<i class="fa fa-play-circle collabrate-icon"></i> 											
												<a href="<?php echo base_url($fileLink);?>">
												<?php echo $fileName;?></a>
											 </li>
											<?php
										}
									}
									?>                                  
                                </ul>   
                           
					</div>
            </div>
			
			<div id="shared_files" class="tab-pane fade" style="height:290px;">
					<div class="col-md-12 col-xs-12">
						<ul class="list-group">
							<?php 
								$i=0;
								for($i==0; $i < $size; $i++){
									$files_data=$collaborate_deatils['dropboxsharedfiles'];
								
									$shareTo=$files_data[$i]['SharedTo'];
									 $fileLink= $files_data[$i]['FileLink'];
									 $fileName=$files_data[$i]['FileName'];
									if($shareTo == 1){
										?>
										 <li class="list-group-item justify-content-between" style="margin-top: 10px;margin-bottom: 10px;">
												<i class="fa fa-play-circle collabrate-icon">
												</i> 
											
												<a href="<?php echo $fileLink;?>" >
												<?php echo $fileName;?></a>
									    </li>
										<?php
									}
								}
							?>
							</ul>            
					</div>
			</div>		
		</div>
		</div>	
   </div>
   
   </div>