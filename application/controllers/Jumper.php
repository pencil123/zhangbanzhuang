<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jumper extends CI_Controller {

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
		$this->load->model('M_keyword');
	}

	public function coupon($goodsid)
	{
		$goods_id  = (int) rawurldecode($goodsid);
		$this->load->library('user_agent');
		Header("HTTP/1.1 302 Moved Temporarily");
		Header("Location: ".$this->M_goods->coupon_share_url($goodsid)->coupon_share_url);
		exit;
	}
}
