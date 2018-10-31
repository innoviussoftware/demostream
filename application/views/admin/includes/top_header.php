<header class="main-header">
    <!-- Logo -->
    <a href="<?php echo base_url(); ?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Demo Stream</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?php
                        if (!empty($this->session->userdata['profile_picture'])) {
                            $haystack = $this->session->userdata['profile_picture'];
                            $needle = 'http';

                            if (strpos($haystack,$needle) !== false) {
                                // echo $haystack.' contains '.$needle;
                                $file = $haystack;   
                            }else{
                                $file = base_url() . 'uploads/' . $this->session->userdata['profile_picture'];
                            }
                        } else {
                            $file = base_url() . 'assets/images/unknown.jpg';
                        }
                        ?>  
                        <img src="<?php echo $file; ?>" class="user-image" alt="User Image">
                        <span class="hidden-xs">Welcome <?php echo $this->session->userdata['user_name']; ?></span>
                    </a>

                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header" style="background:none;">

                            <img src="<?php echo $file; ?>" class="img-circle" alt="User Image">
                            <p style="color: #000"><b><?php echo $this->session->userdata['user_name']; ?></b>
                            </p>
                        </li>

                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?php echo base_url() . 'admin/Pages/home'; ?>" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="<?php echo base_url() . 'Logout/index'; ?>" class="btn btn-default btn-flat">Log out</a>
                            </div>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </nav>
</header>