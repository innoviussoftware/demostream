<aside class="main-sidebar demo-sidebar">

    <section class="sidebar">

        <!--<a href="<?php echo base_url() . 'admin/Pages/home'; ?>">
            <div class="user-panel">
                <div class="pull-left image">
        <?php
        if (!empty($this->session->userdata['profile_picture'])) {
            $file = base_url() . 'uploads/' . $this->session->userdata['profile_picture'];
        } else {
            $file = base_url() . 'assets/images/unknown.jpg';
        }
        ?>  
                    <img src="<?php echo $file; ?>" class="img-circle" style="width: 50px;height: 40px !important;"  alt="User Image">
                </div>
                <div class="pull-left info">
                    <label style="font-size: 12px;margin-top:7%;margin-left:-8px;"><?php echo $this->session->userdata['user_name']; ?></label>
                </div>
            </div>
        </a>-->


        <?php
        $username = $this->session->userdata('admin_username');
        $password = $this->session->userdata('admin_password');

        $url_log = USER_AUTHEDICATE . "?Un=" . $username . "&Pwd=" . $password;
        $data_log = curl_init();
        curl_setopt($data_log, CURLOPT_URL, $url_log);
        curl_setopt($data_log, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($data_log, CURLOPT_PROXYPORT, 3128);
        curl_setopt($data_log, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($data_log, CURLOPT_SSL_VERIFYPEER, 0);
        $response_data_log = json_decode(curl_exec($data_log), true);
        $return_log = curl_errno($data_log); //returns 0 if no errors occured
        ?>

        <ul class="sidebar-menu" data-widget="tree">

            <li>
                <a href="<?php echo base_url() . 'admin/Pages/home'; ?>">
                    <i class="fa fa-user"></i>
                    <span>My Profile</span>
                </a>
            </li>
            <?php
            if ($response_data_log['userprofiledetails'][0]['IsSuperAdmin'] != 1) {
                ?>

                <li>
                    <?php if ($this->session->userdata('subscription_admin') || $response_data_log['userprofiledetails'][0]['IsAdmin'] == 1) {
                        ?>
                        <a href="<?php echo base_url() . 'admin/Video_Sync/view_video'; ?>">
                            <i class="fa fa-caret-square-o-right"></i>
                            <span>Video Sync</span>
                        </a>
                    <?php } else { ?>

                        <a href="<?php echo base_url() . 'admin/Activities/no_activities'; ?>">
                            <i class="fa fa-list"></i>
                            <span>Video Sync</span>
                        </a>

                    <?php } ?>
                </li>

                <li>
                    <?php if ($this->session->userdata('subscription_admin') || $response_data_log['userprofiledetails'][0]['IsAdmin'] == 1) { ?>
                        <a href="<?php echo base_url() . 'admin/Activities/view_activities'; ?>">
                            <i class="fa fa-tasks"></i>
                            <span>My Activities</span>
                        </a>

                    <?php } else { ?>

                        <a href="<?php echo base_url() . 'admin/Activities/no_activities'; ?>">
                            <i class="fa fa-tasks"></i>
                            <span>My Activities</span>
                        </a>

                    <?php } ?>
                </li>

                <li>
                    <a href="<?php echo base_url() . 'admin/Donation/view_donation'; ?>">
                        <i class="fa fa-list"></i>
                        <span>My Donations</span>
                    </a>          
                </li>

                <li>
                    <a href="<?php echo base_url() . 'admin/Banner/view_banner'; ?>">
                        <i class="fa fa-file-image-o"></i>
                        <span>Add Banner</span>
                    </a>          
                </li>

                <li>
                    <a href="<?php echo base_url() . 'admin/Banner/viewall_banner'; ?>">
                        <i class="fa fa-file-image-o"></i>
                        <span>View Banner</span>
                    </a>          
                </li>

            <?php } ?>
            <?php if ($response_data_log['userprofiledetails'][0]['IsAdmin'] == 1 && $response_data_log['userprofiledetails'][0]['IsSuperAdmin'] == 0) { ?>

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-users"></i> <span>Manage Clients</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?php echo base_url() . 'admin/Clients/add_clients'; ?>"><i class="fa fa-plus-circle"></i> Add Clients</a></li>
                        <li><a href="<?php echo base_url() . 'admin/Clients/view_clients'; ?>"><i class="fa fa-list"></i> View Clients</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-newspaper-o"></i> <span>Manage Subscriptions</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?php echo base_url() . 'admin/Clients/add_subscription'; ?>"><i class="fa fa-plus-circle"></i> Add Subscription</a></li>
                        <li><a href="<?php echo base_url() . 'admin/Clients/view_subscription'; ?>"><i class="fa fa-list"></i> View Subscription</a></li>
                    </ul>
                </li>
                <li class = "treeview">
                    <a href = "#">
                        <i class = "fa fa-gift"></i> <span>Manage Packages</span>
                        <span class = "pull-right-container">
                            <i class = "fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class = "treeview-menu">
                        <li><a href="<?php echo base_url() . 'admin/Clients/add_package'; ?>"><i class="fa fa-plus-circle"></i> Add Packages</a></li>
                        <li><a href="<?php echo base_url() . 'admin/Activities/view_packages'; ?>"><i class="fa fa-list"></i> View Packages</a></li>
                    </ul>
                </li>
                
                <li class = "treeview">
                    <a href = "#">
                        <i class = "fa fa-globe"></i> <span>Manage NING Network</span>
                        <span class = "pull-right-container">
                            <i class = "fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class = "treeview-menu">
                        <li>
                            <a href="<?php echo base_url() . 'admin/Network/index'; ?>"><i class="fa fa-plus-circle"></i> Add Network</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url() . 'admin/Network/ViewAllNetworks'; ?>"><i class="fa fa-list"></i> View Network</a></li>
                    </ul>
                </li>

            <?php }if ($response_data_log['userprofiledetails'][0]['IsSuperAdmin'] == 1) { ?>
                <li class = "treeview">
                    <a href = "#">
                        <i class = "fa fa-users"></i> <span>Manage Dealers</span>
                        <span class = "pull-right-container">
                            <i class = "fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class = "treeview-menu">
                        <li><a href = "<?php echo base_url() . 'admin/Dealer/add_dealer'; ?>"><i class = "fa fa-plus-circle"></i>Add Dealers</a></li>
                        <li><a href = "<?php echo base_url() . 'admin/Dealer/view_dealers'; ?>"><i class = "fa fa-list"></i>View Dealers</a></li>
                    </ul>
                </li>
                <?php
            }
            ?>


            <li>
                <a href="<?php echo base_url() . 'Logout/index'; ?>">
                    <i class="fa fa-power-off"></i>
                    <span>Logout</span>
                </a>

            </li>


        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
