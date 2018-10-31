<?php 
	//echo '<pre>';
	//print_r($activity_deatils['campaignactivityupdates']);exit;
	//print_r($video_deatils);exit;
	$iscampaign=$this->session->userdata['iscampaign'];
	$size_act=sizeof($activity_deatils['campaignactivityupdates']);
	$Video_ID=$this->session->userdata['Video_ID'];
	
?>		
<div class="container middle paper-craft-middle">
	<div class="row video-img">
	</div>
	 <div class="row">
		<div class="col-md-offset-0 col-md-4 col-xs-12">
		<div class="row back-row" style="background-color: #85298c;color: white;">
			<div class="col-xs-8" style="text-align: left;">
				<a href="#" onclick="history.back();" style="color:#fff;"><span class="fa fa-arrow-left"></span></a>&nbsp; <b><?php echo $this->session->userdata['title'];?></b>
			</div>
			 <div class="col-xs-4" style="font-size: 18px;text-align: right;">
				<a href="<?php if($iscampaign == 1){  echo base_url('Video_curl/campaign/'.$Video_ID); }else{ echo base_url('Video_curl/video/'.$Video_ID); }?>" style="color:#fff;"><span class="fa fa-home"></span></a>
			</div>
		</div>
		</div>
	</div>

  <div class="row">
	<div class="col-md-offset-0 col-md-4 col-xs-12" style="min-height: 450px;overflow-y: scroll;max-height: 500px;background-color: whitesmoke;padding-right: 0px;padding-left: 0px;">
       
						<div class="col-md-12 col-xs-12">															<a href="<?php echo base_url('Pages/view/donate');?>" class="btn" style="margin-top: 3%;float:right;color:#fff;background-color: #85298c;border-color: #85298c;"><h5>Proceed to donate</h5></a>
									<ul class="list-group" style="margin-top: 15%;">  
										<?php 
											$i=0;
											if($size_act > 0){ 
											for($i==0; $i < $size_act; $i++){
												 $act_data=$activity_deatils['campaignactivityupdates'];
												 
												 $img=$act_data[$i]['ActivityImgPath'];
												 $updatemsg=$act_data[$i]['UpdateMessage'];
												 $create_date=$act_data[$i]['CreatedOnMobile'];
												 $create_date=date('Y-m-d',strtotime($create_date));
												 $current_date=date('Y-m-d');
												 
												 $date1=date_create($create_date);
												 $date2=date_create($current_date);
												 $diff=date_diff($date1,$date2);
												 $year=$diff->format("%y");
												 $month=$diff->format("%m");										
												 if($year > 0){
													$d =$diff->format("%y year %m month %d days");
												 }elseif($month > 0){
													$d =$diff->format("%m Month %d days");
												 }else{
													$d =$diff->format("%d days");
												 }													 
												 if($img == ''){
													$img=base_url().'assets/images/noimage.png';
												 }
												?>
												<li class="list-group-item justify-content-between" style="margin-top: 3px;margin-bottom: 0px;">
													<div class="row">
														<div class="col-xs-3">
															<img class="comment-img" src="<?php echo $img;?>"/>										
														</div>
														<div class="col-md-offset-1 col-xs-7">
															<p style="font-size: 12px;"><?php echo $updatemsg;?></p>
															<p style="float: right;font-size:11px;font-weight: bold;"><?php echo $d;?></p>
														</div>
													</div>
												
												 </li>
												 <?php
											}
											
										?>										
									</ul>  
									<?php
											}else{
												echo '<span class="text-center" style="font-size: 12px;">No Activity Updates as of Yet</span>';
											}
																				
									?>								
						</div>
		</div>
		</div>				   
   </div>
   
   </div>