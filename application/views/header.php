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
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url()?>assets/bootstrap3.css" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url()?>assets/index.css?d=20120705" />
	<script src="<?php echo base_url()?>assets/js/jquery.js"></script>
	<script src="<?php echo base_url()?>assets/js/shop.js"></script>
	<!--[if lt IE 9]>
	<script src="<?php echo base_url()?>assets/js/html5shiv.js"></script>
	<![endif]-->
</head>
<body>

<header id="branding" role="banner">
	<div id="site-title" class="container">
		<div class="col-xs-3">
			<a href="<?php echo site_url();?>" title="dfgfd" rel="home">
				<img src="/assets/img/logo.png" class="img-responsive">
			</a>
		</div>


		<div class="col-md-6 col-xs-9">
			<form action="<?php echo site_url('search/spring/');?>">
				<div class="input-group">
					<input  type="text" name="keyword" class="form-control">
					<span class="input-group-btn">
						<input class="btn btn-default" type="submit" value="搜索优惠券" />
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

		<div class="col-md-3 visible-md">
			<a href="<?php echo site_url();?>" title="dfgfd" rel="home">
				<img src="/assets/img/logo2.png" class="img-responsive">
			</a>
		</div>
	</div>

</header>

<nav class="navbar navbar-default navbar-static-top navbar-style">
  <div class="container">
    <ul class="nav nav-pills">
        <?php
        $is_home = '';
        if(empty($cat_slug)){
            $is_home = 'active';
        }
        ?>
      <li role="presentation" class=" <?php echo $is_home;?>"><a href="<?php echo site_url()?>">全部</a></li>
        <?php
        foreach($cat->result() as $row){
            $is_current = '';
            if(!empty($cat_slug) && $row->category_nick == $cat_slug){
                $is_current = 'active';
            }
            echo '<li role="presentation"  class="'.$is_current.'"><a href="'.site_url('cat/'.rawurlencode($row->category_nick)).'/">'.$row->category_name.'</a></li>';
        }
        ?>
    </ul>
  </div>
</nav>
