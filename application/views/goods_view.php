<div id="wrapper">
<div class="span9">
	<div class="goods-details">
    <div class="img-area span3">
      <img src="<?php echo $details->pict_url ?>">
    </div>
    <div class="info-area span6">
      <div class="goods-title">
          <?php echo $details->title ?>
      </div>
      <div class="coupon-info">
        <div class="goods-price-area">
          <div class="zk-price">
            当前价格：<?php echo $details->zk_final_price ?>
          </div>
          <div class="discounted">
            卷后价格：<?php echo $details->zk_final_price - $details->coupon_amount ?>
          </div>
        </div>
        <div class="buy-now">
         <a href="<?php echo $details->coupon_share_url ?>"> 领券立减<?php echo $details->coupon_amount ?>元</a>
        </div>
      </div>
      <div class="shop-info">
        <div class="shop-title">
            <?php echo $details->shop_title ?>
        </div>
        <div class="sold30">
          近三十天销量：<?php echo $details->volume ?>
        </div>
      </div>
    </div>
    <div class="clearfloat"></div>
  </div>
  <div class="goods-imgs">
      <?php foreach($small_imgs as $small_img){
        echo '<img src="'.$small_img.'" class="goods-img">';
    }?>
  </div>
</div>
<div class="span3 guess-area">
	<div>
      <?php
      foreach($guess_like->result() as $like){?>
        <div class="guess">
        <img src="<?php echo $like->goods_img ?>">
        <p><?php echo $like->goods_name ?></p>
          <div class="clearfloat"></div>
        </div>
      <?php }?>
  </div>
</div>
</div>
