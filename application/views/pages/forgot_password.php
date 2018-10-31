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

                    <form class="form" action="<?php echo base_url('users/forgot_pass'); ?>" method="post">
                        <div class="form-group">
                            <input type="text" class="form-control" name="email" placeholder="Please Enter Email id" required=""/>
                        </div>
                        <div class="w3ls-submit" style="margin-top:15px !important;background-color:#fff;">
                            <div class="email"> 				
                                <input type="submit" style="padding: 0px !important;color:#fff !important;text-transform: capitalize !important;" value="Submit">  	
                            </div>	
                        </div>	

                        <div class="w3ls-submit" style="font-size:15px;color: #000;text-decoration: underline;">
                            <a href="<?php echo base_url('Hauth/users'); ?>">
                                <span>Click here to login</span>
                            </a>
                        </div>

                    </form>
                </div>  

            </div>
        </div>	
    </div>	
</div>
</div>