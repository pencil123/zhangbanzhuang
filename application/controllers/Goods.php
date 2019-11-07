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
		$this->load->model('M_keyword');
	}

	public function info($goodsid)
	{
		var_dump($this->M_goods->goods_info($goodsid));

		$this->config->load('site_info');
		//站点信息
		$data['site_name'] = $this->config->item('site_name');
		//keysords和description
		$data['site_keyword'] = $this->config->item('site_keyword');
		$data['site_description'] = $this->config->item('site_description');

		//关键词列表，这个在后台配置
		$data['keyword_list'] = $this->M_keyword->get_all_keyword(5);

		//分类标题
		$data['cat']=$this->M_cat->get_all_cat();

		$this->load->view("header",$data);
		$this->load->view("goods_view");
		$this->load->view("footer");
	}
}
