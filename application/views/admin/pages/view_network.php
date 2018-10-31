<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            View NING Networks
                        <!--<small>advanced tables</small>-->
        </h1>      
        <ol class="breadcrumb">     
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">View NING Networks</li>
        </ol>

    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <!-- /.box -->
                <div class="box">
                    <div class="box-header">                        
                        <?php if ($this->session->flashdata("success")) { ?>
                            <div class="alert alert-success alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <span class="text-center"><?php echo $this->session->flashdata('success'); ?></span>
                            </div>
                        <?php }if ($this->session->flashdata("danger")) { ?>
                            <div class="alert alert-danger alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <span class="text-center"><?php echo $this->session->flashdata('danger'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="row">
                        <div class="col-xs-2 pull-right" style="text-align:  right;padding-right:  2%;">
                            <a href="<?php echo base_url('admin/Network/index'); ?>" class="btn btn-primary">Add Network</a>
                        </div>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">


                        <div class="table-responsive">
                            <table id="example" style="font-size: 13px;" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="display: none;">#</th>
                                        <th>User Name</th>
                                        <th>Network Key</th>
                                        <!-- <th>Payment Gateway</th> -->
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    krsort($users);
                                    $users_data =array_filter($users,function ($a){
                                        return ($a['FirstName'] != '' && $a['IsSubscribed'] == '1' && $a['NetworkKey'] != '' && $a['NetworkKey'] != 'null');
                                    });
                                    foreach ($users_data as $user) {
                                        ?>
                                        <tr>
                                            <td style="display: none;"><?php echo $user['UserID'];?></td>
                                            <td><?php echo $user['FirstName']; ?></td>
                                            <td><?php echo $user['NetworkKey']; ?></td>                                            
                                            <!-- <td>                                                
                                                <a href="#" onclick="return Payment_status('<?php echo $payment_status;?>','<?php echo $uid; ?>')"><label class="label label-danger">Disabled</label></a>                                    
                                                     </td> -->
                                            <td>
                                                <?php 
                                                $uid = $user['UserID'];
                                                $payment_status = 1;
                                                    $this->load->library('NingNetwork');
                                                    
                                                        $network_key = $user['NetworkKey'];
                                                        $ningnetwork = $this->ningnetwork->GetOtpForNetwork($user['EmailID'], $network_key); //email and network key
                                                        if ($ningnetwork['error_code'] == 0) {
                                                            $network_url= $ningnetwork['data'];
                                                        }
                                                 
                                                ?>
                                                <a href="<?php echo $network_url;?>" target="_blank">View</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<script type="text/javascript">
    function Payment_status(Payment_status,UserID,NetworkKey) {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url() ?>admin/Network/UpdatePayemtStatus',
            data: {network_key: NetworkKey,payment_status: Payment_status,user_id: UserID},
            success: function (result) {
                if (result == 0) {
                    alert(NetworkKey + " 's payment gateway is enabled.");
                }else{
                    alert("Something went wrong.");
                }
            }
        });
    }
</script>