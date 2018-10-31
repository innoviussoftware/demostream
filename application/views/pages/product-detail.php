<?php
$Video_ID = $this->session->userdata['Video_ID'];
$iscampaign = $this->session->userdata['iscampaign'];
//echo '<pre>';print_r($product_detail);exit;
$product_title = $product_detail['title'];
$product_price = $product_detail['product_price'];
$product_images = $product_detail['product_image'];
$product_image = $product_detail['product_image'][0]['src'];
$vendor = $product_detail['vendor'];
$handle = $product_detail['handle'];
$about = $product_detail['body_html'];
$url = '';
if (!empty($this->session->userdata('shop_url'))) {
    $shop_url = $this->session->userdata('shop_url');
    $url = 'https://' . $shop_url . '/products/' . $handle;
}
?>
<div class="container middle paper-craft-middle"> 
    <div class="row video-img">
    </div>
    <div>
        <div class="row" style="padding-right:15px;padding-left:15px;">
            <div class="col-md-offset-0 col-md-4">
                <div class="row top-title" style="font-size: 16px;background-color: #8B008B;color: white;">	
                    <div class="col-xs-6" style="text-align: left;">
                        <a href="#" onclick="history.back();" style="color: #fff;"><span class="fa fa-arrow-left"></span></a>&nbsp; <b> Product Detail</b>
                    </div>
                    <div class="col-xs-6" style="font-size: 18px;text-align: right;">
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

        <div class="col-md-offset-0 col-xs-12 col-md-4"  style="padding-right: 22px;overflow: overlay;max-height: 450px;background-color: whitesmoke;min-height: 400px;">
            <div id="myCarousel" class="carousel slide" data-ride="carousel" >
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <?php
                    for ($i = 1; $i < sizeof($product_images); $i++) {
                        ?>
                        <li data-target="#myCarousel" data-slide-to="<?php echo $i; ?>"></li>
                    <?php } ?>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner">	
                    <div class="item active">
                        <img src="<?php echo $product_image; ?>" >
                    </div>
                    <?php
                    for ($i = 1; $i < sizeof($product_images); $i++) {
                        ?>
                        <div class="item">
                            <img src="<?php echo $product_images[$i]['src']; ?>">
                        </div>
                    <?php } ?>
                </div>

                <!-- Left and right controls
                <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                  <span class="glyphicon glyphicon-chevron-left"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">
                  <span class="glyphicon glyphicon-chevron-right"></span>
                  <span class="sr-only">Next</span>
                </a>
                -->
            </div>

            <div class="row" style="margin-top: 15px;">
                <div class="col-xs-offset-0 col-xs-12 col-md-12">
                    <h4>About</h4>
                    <p style="font-size:14px;padding-bottom: 3%;"><?php echo $about; ?></p>
                </div>
                <div class="col-xs-12 col-md-12">
                    <h5 style="color:#8B008B;float:right;">
                        <a class = "pull-left" target="_blank" href = "<?php echo $url; ?>">				
                            <button class="" style="padding: 10px;color: white;background-color: #85298c;border: 0px;">Buy $ <?php echo $product_price; ?></button>
                        </a>
                    </h5>
                </div>
                <div class="col-xs-offset-0 col-xs-11 col-md-11"><br>
                    <h4>Vendor</h4><br>
                    <p style="font-size:14px;padding-bottom: 3%;"><?php echo $vendor; ?> </p>
                </div>			
            </div>
        </div>
    </div>
</div>