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
<div id="wrapper" class="container">
<?php 
if($resp->num_rows() == 0){
	//http://s8.taobao.com/search?cat=xx&sort=coefp&q=关键词&pid=mm_11111111_0_0&style=grid 

	//cat                   类目号（后面加上该关键词相对应的类目编号，具体对应代码见附表）  
	//sort=coefp    人气宝贝（加上这个内容使出现的搜索结果都是人气宝贝）  
	//q                      关键词（后面直接添加上你想要搜的关键词中文）  
	//style=grid      大图（加上这个代码可以使搜索的结果保证以大图展示）  
		echo '你搜索的“'.$keyword.'”没有找到本站条目。<a href="https://s.taobao.com/search?q='.
			$keyword.'" target="_blank">在淘宝搜索更多'.$keyword.'。</a>';
	}else if($resp->num_rows()>0){ ?>
	<div class="goods-all transitions-enabled masonry row" >
	<?php foreach ($resp->result() as $array):
	//条目
		?>

		<article class="goods col-xs-6 col-md-4 col-lg-3">
			<div class="entry-content">
				<div class="goods-pic">
					<a href="/goods/info/<?php echo $array->id ?>.html" target="_blank">
						<img src="<?php echo $array->pict_url ?>"  alt="<?php echo $array->title ?>" title="<?php echo $array->title ?>" class="img-responsive">
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
	<?php
	echo '没有找到满意的结果？<a href="https://s.taobao.com/search?q='.
		$keyword.'" target="_blank" >在淘宝搜索更多'.$keyword.'。</a>';
     } ?>
</div>


<div class="pagenav_wrapper">
	<div class="pagenav">
		<?=$pagination;?>
	</div>
</div><!-- .pagenav_wrapper -->
