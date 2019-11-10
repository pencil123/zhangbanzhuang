<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Goods extends CI_Controller {

	/**
	 * 类目类的构造函数
	 *
	 * pagination库用来翻页
	 * M_item用来查询条目
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('M_goods');
		$this->load->model('M_cat');
		$this->load->model('M_guesslike');
		$this->load->model('M_keyword');
	}

	public function info($goodsid)
	{
        $goods_id  = (int) rawurldecode($goodsid);
		$this->config->load('site_info');
		//站点信息
		$header['site_name'] = $this->config->item('site_name');
		//关键词列表，这个在后台配置
        $header['keyword_list'] = $this->M_keyword->get_all_keyword(5);
        $goods_header = $this->M_goods->goods_info($goods_id);
        $header['site_title'] = $goods_header->short_title;
        $header['site_keyword'] = $goods_header->short_title;
        $header['site_description'] = $goods_header->title;
		//分类标题
        $header['cat']=$this->M_cat->get_all_cat();

        //商品信息
        $goods['details'] = $this->M_goods->goods_info($goods_id);
		$small_imgs = json_decode($goods['details']->small_images);
        if (array_key_exists("string",$small_imgs)){
			$goods['small_imgs'] = $small_imgs->string;
		}else {
			$goods['small_imgs'] = array($goods['details']->pict_url);
		}

        //猜你喜欢
        $goods['guess_like'] = $this->M_guesslike->guess_like($goods['details']->my_category_id,$goods_id);

		$this->load->view("header",$header);
		$this->load->view("goods_view",$goods);
		$this->load->view("footer");
	}
}
