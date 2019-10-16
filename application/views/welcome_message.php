<!DOCTYPE html>
<html dir="ltr" lang="zh-CN">
<head>
	<meta charset="UTF-8" />
	<title><?php
		if(!empty($cat_name)){
			echo $cat_name.' - ';
		}
		echo $site_name;
		?></title>
	<meta name="keywords" content="<?php
	if(!empty($cat_name)){
		echo $cat_name.',';
	}
	echo $site_keyword; ?>">
	<link rel="shortcut icon" href="/juan.ico" />
	<meta name="description" content="<?php echo $site_description; ?>">
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url()?>assets/bootstrap.css" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url()?>assets/index.css?d=20120705" />
	<!--[if lt IE 9]>
	<script src="<?php echo base_url()?>assets/js/html5shiv.js"></script>
	<![endif]-->
</head>
<body>

<header id="branding" role="banner">
	<div id="site-title">
		<h1>
			<a href="<?php echo site_url();?>" title="dfgfd" rel="home" class="logo"><?php echo $site_name;?></a>
		</h1>
		<div id="site-op">
			<form action="<?php echo site_url('welcome/search');?>">
				<div class="input-append">
					<input class="span2" id="appendedInputButton" type="text" name="keyword">
					<input class="btn" type="submit" value="搜索">
				</div>
				<div class="keyword-list">
				</div>
			</form>
		</div>
	</div>

</header>


<div id="wrapper">

	<?php if($news->num_rows()>0){ ?>
		<div class="goods-all transitions-enabled masonry">
			<?php foreach ($news->result() as $array):
				//条目
				?>

				<article class="goods">
					<div class="entry-content">
						<div class="goods-pic">
							<img src="<?php echo $array->img_url ?>" class="" alt="" title="<?php echo $array->title ?>">

						</div>
						<div class="op"><div class="desc"><?php echo mb_substr($array->sellernick,0,20) ?>   / <strong>RMB<?php echo $array->price ?></strong></div>
							<div class="buttonline">
								<a href="<?php echo site_url('welcome/redirect').'/'.$array->id ?>" title="去购买" class="btn btn-success" target="_blank">去购买</a>
							</div></div>
					</div>
				</article>
			<?php endforeach;?>
		</div>
		<div class="pagenav_wrapper">
			<div class="pagenav">
				<?=$pagination;?>
			</div>
		</div><!-- .pagenav_wrapper -->

	<?php } ?>
</div>

</body>
</html>
