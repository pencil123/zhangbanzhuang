<script type="text/javascript">
  window.onload = function () {
    var elems = document.getElementsByName("goods_imgs");
    for (var i=0;i<elems.length;i++) {
      //alert("width: " + elems[i].offsetWidth);
      elems[i].style.height = elems[i].offsetWidth +"px";
    }
  };
  //	reheight();
</script>

<ul id="wrapper" class="container">
	<?php if($items->num_rows()>0){ ?>
		<div class="goods-all transitions-enabled masonry row">
			<?php foreach ($items->result() as $array):
				//条目
				?>
				<article class="goods col-xs-6 col-md-4 col-lg-3 ">
					<div class="entry-content">
						<div class="goods-pic">
							<a href="/goods/info/<?php echo $array->id ?>.html" target="_blank">
							<img src="<?php echo $array->pict_url ?>_300x300.jpg" alt="<?php echo $array->title ?>" title="<?php echo $array->title ?>"  class="img-responsive" name="goods_imgs">
							</a>
						</div>
						<p class="title-area">
							<span class="shop-type">天猫</span><?php echo $array->short_title ?>
						</p>
						<div class="raw-price-area hidden-xs">
							现价：¥<?php echo $array->zk_final_price ?>
							<p class="sold">30天销售:<?php echo $array->volume ?></p>
						</div>
						<span class="info">
							<div class="price-area">
								<span class="rmb">¥
								<em class="coupon-price"><?php echo $array->zk_final_price - $array->coupon_amount ?></em>
								<i></i></span>
							</div>
							<div class="buy-area">
								<a href="/jumper/coupon/<?php echo $array->id?>.html" target="_blank">
									<span class="btn-title">去领券</span>
								</a>
							</div>
						</span>
					</div>
				</article>
			<?php endforeach;?>
		</div>
		<nav aria-label="Page navigation" style="text-align: center">
			<ul class="pagination pagination-new">
				<?=$pagination;?>
			</ul>
		</nav ><!-- .pagenav_wrapper -->

	<?php } ?>
</div>
