<div class="container middle paper-craft-middle">
    <div class="row" id="login">
        <div class="col-md-offset-0 col-md-4 col-xs-12" style="border-top-left-radius: 1em;border-top-right-radius: 1em; margin-top: 4%;">		
            <div class="login-page bg"><!-- login-page -->     
                <?php if ($this->session->flashdata("Duplicate")) { ?>
                    <div class="alert-danger">
                        <span class="text-center"><?php echo $this->session->flashdata('Duplicate'); ?></span>
                    </div>
                <?php } ?>
                <div class="agileits-login" style="padding: 0px !important">

                    <form class="form" action="<?php echo base_url('users/login'); ?>" method="post">
                        <div class="form-group">
                            <input type="text" class="form-control" name="username" placeholder="Please Enter Email id" required=""/>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Submit Password" required=""/>
                        </div>
                        <div class="wthree-text"> 
                            <ul> 
                                <li>
                                    <label class="anim">
                                        <input type="checkbox" class="checkbox"  onchange="document.getElementById('password').type = this.checked ? 'text' : 'password'">
                                        <span style="color: #000;font-size: 13px;"> Show Password</span> 
                                    </label> 
                                </li>
                                <li> <a href="<?php echo base_url();?>Users/forgot_password" style="color: #000;font-size: 13px;">Forgot password?</a> </li>
                            </ul>
                            <div class="clearfix"> </div>
                        </div>  
                        <div class="w3ls-submit" style="margin-top:15px !important;background-color:#fff;">
                            <div class="email"> 				
                                <input type="submit" name="login" style="padding: 0px !important;color:#fff !important;" value="LOGIN">  	
                            </div>	
                        </div>	
                        <!--<div class="w3ls-submit" style="margin-top:5px !important"> 
                                <i class="fa fa-facebook" style="border-radius: 5px;color:#fff;padding: 12px;background-color:#4267b2">   Log in with Facebook</i>
                                </div>	
                                <div class="w3ls-submit" style="margin-top:5px !important"> 
                                        <i class="fa fa-twitter" style="border-radius: 5px;color:#fff;padding: 12px;background-color:#0084b4">   Log in with Twitter</i>
                                </div>	
                                <div class="w3ls-submit" style="margin-top:5px !important"> 
                                        <i class="fa fa-google-plus" style="border-radius: 5px;color:#fff;padding: 12px;background-color:#d34836">   Log in with GooglePlus</i> 
                                </div>-->
                                
                       <!-- <div class="w3ls-submit" style="border-radius: 5px;margin-top:5px !important;background-color:#4267b2 !important;"> 
                            <a href="<?php echo base_url('Hauth/facebook_login'); ?>">
                                <div class="Facebook">
                                    <a href="<?php echo base_url('Hauth/facebook_login'); ?>" >
                                        Facebook
                                    </a>
                                </div>
                            </a>
                        </div>
                        <?php
                        unset($providers[3]);
                        foreach ($providers as $provider):
                            ?>							
                            <div class="w3ls-submit" style="margin-top:5px !important;background-color:#fff;">
                                <?php print $provider; ?>
                            </div>
                        <?php endforeach; ?>	-->			
                        <div class="w3ls-submit" style="font-size:15px;color: #000;text-decoration: underline;">
                            <a href="<?php echo base_url('hauth/users/register'); ?>">
                                <span>To sign up click here</span>
                            </a>
                        </div>
                    </form>
                </div>  

            </div>
        </div>	
    </div>	
</div>
</div>