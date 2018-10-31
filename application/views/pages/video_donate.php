<?php $Video_ID = $this->session->userdata['Video_ID'];
?>
<div class="container middle paper-craft-middle">
    <div class="row video-img">
    </div>
    <div class="row">
        <div class="col-md-offset-0 col-md-4">
            <div class="row top-title" style="font-size: 14px;background-color: #8B008B;color: white;">		
                <div class="col-xs-8" style="text-align: left;">
                    <a href="#" onclick="history.back();" style="color:#fff;"><span class="fa fa-arrow-left"></span></a>&nbsp; <b>Donate</b>
                </div>
                <div class="col-xs-4" style="font-size: 18px;text-align: right;">
                    <a href="<?php
                    if ($iscampaign == 1) {
                        echo base_url('Video_curl/campaign/' . $Video_ID);
                    } else {
                        echo base_url('Video_curl/video/' . $Video_ID);
                    }
                    ?>" style="color:#fff;"><span class="fa fa-home"></span></a>
                </div>
            </div>
        </div>
    </div>
    <div class="row" id="donate"> 
        <div class="col-md-offset-0 col-md-4 col-xs-12"  style="background-color: whitesmoke;">
            <div class="agileits-login" style="font-size: 13px;">
                <form class="form-horizontal" method="post" action="<?php echo base_url('Purchase/video_donate'); ?>">
                    <!-- <div class="form-group">
                        <div class="control-label col-sm-12">Amount $</div>
                        <div class="col-sm-12" style="margin-top: 10px;">
                            <input type="text" readonly="" class="form-control" name="amount" maxlength="20" id="amount" value="<?php echo $video_amount; ?>"/>
                        </div>
                    </div> -->
                    <div class="form-group">
                        <div class="control-label col-sm-12">Contact Info</div>
                        <div class="col-sm-12" style="margin-top: 10px;"> 
                            <input type="email" class="form-control" required="" name="email" id="email" maxlength="60" placeholder="Email ID" />
                            <input type="hidden" name="video_id" value="<?php echo $this->session->userdata('Video_ID');?>" />
                            <input type="hidden" name="user_id" value="<?php echo $this->session->userdata('User_ID');?>" />
                            <input type="number" class="form-control" required="" name="mobile" maxlength="11" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" id="mobile" placeholder="Mobile" />
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="offers-true" value="true" /> Accept to Receive offers and Promotions.</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group"> 
                        <div class="control-label col-sm-12">Payment Gateway</div>
                        <div class="col-sm-12">
                            <div class="radio">
                                <label class="background-color: #fff">
                                    <input type="radio" name="stripe-true" value="true"/> Ning - Accept all Credit/Debit cards</label>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" name="donor-true" value="true" /> I want to be an anonymous donor.</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="background: transparent;">
                        <div class="w3ls-submit" style="background-color: #8B008B;"> 
                            <input type="submit" name="donation" id="donation" style="color: white !important;" value="INVOICE DONATION" />  	
                        </div>	
                    </div>	
                </form>	
            </div>
        </div>
    </div>
</div>
