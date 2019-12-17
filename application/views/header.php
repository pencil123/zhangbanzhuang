<!DOCTYPE html>
<html dir="ltr" lang="zh-CN">
<head>
	<meta charset="UTF-8" />
	<title><?php echo $site_title;?></title>
	<meta name="keywords" content="<?php
	if(!empty($goods_header->title)) {
		echo $goods_header->title."_".$site_name;
	}elseif(!empty($cat_header->category_keyword)){
		echo $cat_header->category_keyword;
	}else{
		echo $site_keyword;
	}
	?>">
	<link rel="shortcut icon" href="/juan.ico" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="<?php	echo $site_description;	?>">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url()?>assets/index.css?d=20120705" />
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.15.0/umd/popper.min.js" integrity="sha384-L2pyEeut/H3mtgCBaUNw7KWzp5n9+4pDQiExs933/5QfaTh8YStYFFkOzSoXjlTb" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="<?php echo base_url()?>assets/js/shop.js"></script>
	<!--[if lt IE 9]>
	<script src="<?php echo base_url()?>assets/js/html5shiv.js"></script>
	<![endif]-->
</head>
<body>

<header id="branding" role="banner">
	<div id="site-title" class="container">
		<div class="col-sm-3 d-none d-sm-block float-left">
			<a href="<?php echo site_url();?>" title="dfgfd" rel="home">
				<img src="/assets/img/logo.png" class="img-fluid logo-img">
			</a>
		</div>


		<div class="col-sm-6 col-12 float-left">
			<form action="<?php echo site_url('search/spring/');?>">
				<div class="input-group">
					<input  type="text" name="keyword" class="form-control">
					<span class="input-group-append">
						<input class="btn btn-outline-secondary" type="submit" value="搜索优惠券" />
					</span>
				</div>
			</form>
			<div class="keyword-list">
				<?php
				foreach($keyword_list->result() as $row){
					echo '<a href="'.site_url('/search/spring/?keyword='.$row->keyword_name).'">'.$row->keyword_name.'</a>&nbsp;&nbsp;';
				}
				?>
			</div>
		</div>

		<div class="col-sm-3 d-none d-sm-block float-left">
			<a href="<?php echo site_url();?>" title="dfgfd" rel="home">
				<img src="/assets/img/logo2.png" class="img-fluid">
			</a>
		</div>
	</div>

</header>


<nav class="navbar navbar-expand-md navbar-style navbar-static-top navbar-dark">
	<div class="container">
		<a class="navbar-brand" href="/">优惠券</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarTogglerDemo01">
			<ul class="navbar-nav nav-pills">
				<?php
				foreach($cat->result() as $row){
					$is_current = '';
					if(!empty($cat_slug) && $row->category_nick == $cat_slug){
						$is_current = 'active';
					}
					echo '<li role="presentation"  class="nav-item"><a  class="nav-link '.$is_current.'" href="'.site_url('cat/'.rawurlencode($row->category_nick)).'/">'.$row->category_name.'</a></li>';
				}
				?>
			</ul>
		</div>
  </div>
</nav>

