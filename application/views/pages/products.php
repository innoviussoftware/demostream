<?php
$Video_ID = $this->session->userdata['Video_ID'];
$iscampaign = $this->session->userdata['iscampaign'];
//echo '<pre>';print_r($product_list);exit;
$size = sizeof($product_list);
?>
<div class="container middle paper-craft-middle"> 
    <div class="row video-img">
    </div>
    <div class="">
        <div class="row" style="padding-right:15px;padding-left:15px;">
            <div class="col-md-offset-0 col-md-4">
                <div class="row top-title" style="background-color: #8B008B;color: white;">	
                    <div class="col-xs-6" style="text-align: left;">
                        <a href="#" onclick="history.back();" style="color: #fff;"><span class="fa fa-arrow-left"></span></a>&nbsp; <b> Product List</b>
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
        <div class="col-md-offset-0 col-xs-12 col-md-4"  style="overflow-y: scroll;max-height: 450px;background-color: whitesmoke;padding: 10px 7px 0px 10px;min-height: 400px;">
            <ul class = "media-list">
                <?php
                if ($size > 0) {
                    for ($i = 0; $i < $size; $i++) {
                        $product_title = $product_list[$i]['title'];
                        $product_price = $product_list[$i]['variants'][0]['price'];
                        $product_image = $product_list[$i]['images'][0]['src'];
                        $vendor = $product_list[$i]['vendor'];
                        $handle = $product_list[$i]['handle'];
                        $about = $product_list[$i]['body_html'];

                        $single_product = array('id' => $product_list[$i]['id'], 'title' => $product_title, 'product_price' => $product_price, 'product_image' => $product_list[$i]['images'], 'vendor' => $vendor, 'handle' => $handle, 'body_html' => $about);
                        $this->session->set_userdata('product_detail' . $product_list[$i]['id'], $single_product);
                        $url = '';
                        if (!empty($this->session->userdata('shop_url'))) {
                            $shop_url = $this->session->userdata('shop_url');
                            $url = 'https://' . $shop_url . '/products/' . $handle;
                        }
                        ?>
                        <li class = "media product-li">
                            <div class="col-xs-4">
                                <a class = "pull-left" href = "<?php echo base_url() . 'Shopify/product_detail/' . $product_list[$i]['id']; ?>">				
                                    <img class = "img-responsive" src = "<?php echo $product_image; ?>">				
                                </a>
                            </div>
                            <div class="col-xs-8">
                                <div class = "media-body">
                                    <h5 style="font-size:13px;" class = "media-heading">					<a style="color: #000 !important;" href = "<?php echo base_url() . 'Shopify/product_detail/' . $product_list[$i]['id']; ?>">						<?php echo $product_title; ?>					</a>				</h5>
                                    <p style="font-size:12px;"><?php echo $vendor; ?></p><br>
                                    <a href="<?php echo $url; ?>" class="btn" style="color:#fff;background-color: #85298c;border-color: #85298c;"target="_blank"><h5>Buy $ <?php echo $product_price; ?></h5></a>
                                </div>
                            </div>
                        </li>	

                        <?php
                    }
                } else {
                    echo 'No Products as of yet.';
                }
                ?>	
            </ul>

        </div>         
    </div>
</div>
</div>