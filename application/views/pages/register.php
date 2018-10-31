<div class="container middle paper-craft-middle">
    <div class="row">

        <div class="col-md-offset-0 col-md-4" style="float: none;">
            <!-- modal -->
            <div class="modal about-modal w3-agileits fade" id="register" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content col-md-offset-2 col-md-8 modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>						
                        </div> 
                        <div class="modal-body login-page "><!-- login-page -->     
                            <div class="">
                                <div class="agileits-login register-form" style="padding: 0px;">
                                    <h5>Register</h5>
                                    <form action="<?php echo base_url('users/register/0'); ?>" method="post">
                                        <input type="hidden" name="type" value="0"/>
                                        <input type="text" name="name" placeholder="Enter Your Name" required=""/>
                                        <input type="email" name="email-address" placeholder="Enter Your Email-ID" required=""/>
                                        <input type="text" name="city" placeholder="Enter Your City" required=""/>											
                                        <input type="password" name="password1" placeholder="Enter Your Password" required=""/>
                                        <input type="password" name="password2" placeholder="Confirm Password" required=""/> 
                                        <div class="w3ls-submit" style="background-color: #8B008B;"> 
                                            <input type="submit" name="register" id="register" style="color: white !important;" value="Register">  	
                                        </div>	
                                    </form>

                                </div>  
                            </div>
                        </div>  
                    </div> <!-- //login-page -->
                </div>
            </div>
            <!-- //modal --> 
        </div>


        <div class="col-md-offset-0 col-md-4 col-xs-12" style="float: none;padding-top: 5%;">
            <div class="login-page bg"><!-- login-page -->     
                <div class="agileits-login" style="padding: 0px !important;">										
                    <form class="form" method="post">
                        <div class="w3ls-submit"> 
                            <div class="email">
                                <a href="#register" data-toggle="modal"  style="color:#fff;margin-top:5px !important;background-color:green;">
                                    Register With Email-ID
                                </a>
                            </div>
                        </div>	
                        <!--<div class="w3ls-submit" style="margin-top:5px !important"> 
                                <i class="fa fa-facebook" style="border-radius: 5px;color:#fff;padding: 12px;background-color:#4267b2">  REGISTER WITH FACEBOOK</i>
                                </div>	
                                <div class="w3ls-submit" style="margin-top:5px !important"> 
                                        <i class="fa fa-twitter" style="border-radius: 5px;color:#fff;padding: 12px;background-color:#0084b4">  REGISTER WITH TWITTER</i>
                                </div>	
                                <div class="w3ls-submit" style="margin-top:5px !important"> 
                                        <i class="fa fa-google-plus" style="border-radius: 5px;color:#fff;padding: 12px;background-color:#d34836">   REGISTER WITH GOOGLEPLUS</i> 
                                </div>-->
                        <!-- <div class="w3ls-submit" style="border-radius: 5px;margin-top:5px !important;background-color:#4267b2 !important;"> 
                            <a href="<?php echo base_url('Hauth/facebook_login'); ?>">
                                <div class="Facebook">
                                    <a href="<?php echo base_url('Hauth/facebook_login'); ?>" >
                                        Facebook
                                    </a>
                                </div>
                            </a>
                        </div> -->
                        <!-- <?php
                        unset($providers[3]);
                        foreach ($providers as $provider):
                            ?>							
                            <div class="w3ls-submit" style="margin-top:5px !important;background-color:#fff;">
                                <?php print $provider; ?>
                            </div>
                        <?php endforeach; ?>	 -->				
                        <div class="checkbox">
                            <label style="color: black;font-size: 14px;"><input type="checkbox"> By signing up.you agree to our terms and privacy policy.</label>
                        </div>				
                    </form>	<center><a href="<?php echo base_url('hauth/users'); ?>">														<span>To sign in click here</span>													</a></center>

                </div>  
                <div class="clearfix"></div>
            </div>
        </div>
    </div>	
</div>