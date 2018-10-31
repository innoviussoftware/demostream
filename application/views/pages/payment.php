<?php 
$donation=$this->session->userdata['Donation_data'];
$Owner_data=$this->session->userdata['Owner_data'];
$Video_ID=$this->session->userdata['Video_ID'];
?>

<div class="container middle paper-craft-middle">
    <div class="row video-img">		
	</div>
	 <div class="row">
		<div class="col-md-offset-0 col-md-4">
		<div class="row back-row">
			<div class="col-xs-6" style="text-align: left;">
			<a href="#" onclick="history.back();" style="color:#000;"><span class="fa fa-arrow-left"></span></a>&nbsp; <b>Payment</b>
			</div>
			 <div class="col-xs-6" style="font-size: 16px;text-align: right;">
			<a href="<?php echo base_url('Video_curl/campaign/'.$Video_ID);?>" style="color:#000;"><span class="fa fa-home"></span></a>
			</div>
		</div>
		</div>
	</div>
	<div class="row" style="height:450px;" id="payment-stripe"> 
		<div class="col-md-offset-0 col-md-4 col-xs-12"  style="background-color: whitesmoke;">
			<div class="agileits-login" style="font-size: 13px;">
			<form class="form-horizontal" id="payment" method="post" action="<?php echo base_url('Donate/payment_donation');?>">
				<div class="form-group">
					<div class="control-label col-sm-12">Card Number</div>
					<div class="col-sm-12" style="margin-top: 10px;">
						<input type="number" class="form-control" required="" maxlength="20" autocomplete="off" name="cardnumber" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="Card Number">
					</div>
				</div>
				<div class="form-group">
					<div class="control-label col-sm-12">Card Expires</div>
					<div class="col-sm-12" style="margin-top: 10px;"> 
						<div class="col-sm-6" style="margin-top: 10px;"> 
							<label>Month</label>
						</div>
						<div class="col-sm-6" style="margin-top: 10px;"> 
							<?php
							 $monthArray = range(1, 12);
							?>
							<select name="expirymonth" style="width: 100%;">
								<option value="">Select Month</option>
								<?php
								foreach ($monthArray as $month) {
									// padding the month with extra zero
									$monthPadding = str_pad($month, 2, "0", STR_PAD_LEFT);
									// you can use whatever year you want
									// you can use 'M' or 'F' as per your month formatting preference
									$fdate = date("m", strtotime("2015-$monthPadding-01"));
									echo '<option value="'.$monthPadding.'">'.$fdate.'</option>';
								}
								?>
							</select>
						</div>
						<div class="col-sm-6" style="margin-top: 10px;"> 								
								<!-- displaying the dropdown list -->
							<label>Year</label>
						</div>
						<div class="col-sm-6" style="margin-top: 10px;"> 
							<?php 
								$yearArray = range(2000, 2050);
							?>							
							<select name="expiryyear" style="width: 100%;">
							<option value="">Select Year</option>
							<?php
							foreach ($yearArray as $year) {
							// if you want to select a particular year
							$selected = ($year == "") ? 'selected' : '';
								echo '<option '.$selected.' value="'.$year.'">'.$year.'</option>';
							}
							?>
							</select>			
						</div>
					</div>					
				</div>
				
				<div class="form-group"> 
					<div class="control-label col-sm-12">Card Code</div>
					<div class="col-sm-12" style="margin-top: 10px;">
						<input type="number" class="form-control" required="" name="cvc" maxlength="3" id="cvc" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="Enter CVC Number">
					</div>
				</div>
				<div class="form-group" style="background: transparent;">
				<div class="w3ls-submit" style="background-color: #8B008B;"> 
				<input type="hidden" class="form-control" name="amount" value="<?php echo $donation['amount'];?>"/>
					<input type="submit" name="payment-stripe" id="payment-stripe" style="color: white !important;" value="Pay $ <?php echo $donation['amount'];?>">  	
				</div>	
				</div>	
			</form>	
			</div>
		</div>
	</div>
</div>
