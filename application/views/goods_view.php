<div id="wrapper" class="container">
	<div class="row">
		<div class="col-sm-9 col-xs-12">
			<div class="goods-details">
				<div class="img-area col-sm-4 col-xs-12">
					<img src="<?php echo $details->pict_url ?>_300x300.jpg" alt="<?php echo $details->title ?>" title="<?php echo $details->title ?>" class="img-fluid">
				</div>
				<div class="info-area col-sm-8 col-xs-12">
					<div class="goods-title">
						<?php echo $details->short_title ?>
					</div>
					<div class="coupon-info">
						<div class="goods-price-area">
							<div class="zk-price">当前价格：<?php echo $details->zk_final_price ?></div>
							<div class="discounted">卷后价格：<?php echo $details->zk_final_price - $details->coupon_amount ?></div>
						</div>
						<div class="buy-now">
							<a href="/jumper/coupon/<?php echo $details->id ?>.html" target="_blank"> 领券立减<?php echo $details->coupon_amount ?>元</a>
						</div>
					</div>
					<div class="shop-info">
						<ul class="itemview">
							<li class="tname">店铺: </li>
							<li class="tval"><?php echo $details->shop_title ?></li>
						</ul>
						<ul class="itemview">
							<li class="tname">近30天销量: </li>
							<li class="tval"><?php echo $details->volume ?>件</li>
						</ul>
					</div>
				</div>
				<div class="clearfloat"></div>
			</div>
			<div class="goods-imgs">
				<?php foreach($small_imgs as $small_img){echo '<img src="'.$small_img.'" class="img-fluid">';}?>
			</div>
		</div>
		<div class="col-sm-3 guess-area hidden-xs">
			<?php
			foreach($guess_like->result() as $like){?>
				<div class="guess">
					<a href="/goods/info/<?php echo $like->goods_id?>.html">
						<img src="<?php echo $like->goods_img ?>_300x300.jpg" class="img-fluid"><p><?php echo $like->goods_name ?></p></a>
					<div class="clearfloat"></div>
				</div>
			<?php }?>
		</div>
	</div>
</div>

<script type="text/javascript">
  function is_weixin() {
    var ua = navigator.userAgent.toLowerCase();
    if (ua.match(/MicroMessenger/i) == "micromessenger") {
      return true;
    } else {
      return false;
    }
  }
  var isWeixin = is_weixin();
  var winHeight = typeof window.innerHeight != 'undefined' ? window.innerHeight : document.documentElement.clientHeight;
  function loadHtml(){
    var div = document.createElement('div');
    div.id = 'weixin-tip';
    div.innerHTML = '<p><img src="/assets/img/live_weixin.png" alt="微信打开"/></p>';
    document.body.appendChild(div);
  }

  function loadStyleText(cssText) {
    var style = document.createElement('style');
    style.rel = 'stylesheet';
    style.type = 'text/css';
    try {
      style.appendChild(document.createTextNode(cssText));
    } catch (e) {
      style.styleSheet.cssText = cssText; //ie9以下
    }
    var head=document.getElementsByTagName("head")[0]; //head标签之间加上style样式
    head.appendChild(style);
  }
  var cssText = "#weixin-tip{position: fixed; left:0; top:0; background: rgba(0,0,0,0.8); filter:alpha(opacity=80); width: 100%; height:100%; z-index: 100;} #weixin-tip p{text-align: center; margin-top: 10%; padding:0 5%;}";
  if(isWeixin){
    loadHtml();
    loadStyleText(cssText);
  }
</script>
