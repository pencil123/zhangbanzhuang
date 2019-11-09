<?php

class M_goods extends CI_Model{

	var $cat_table = '';
	var $item_table = '';
	var $tody = '';


	function __construct()
	{
		parent::__construct();
		$this->goods_table = $this->db->dbprefix('material');
		$this->today = date('Y-m-d');
	}

	function init()
	{
		$this->load->database();
	}

	public function goods_info($goods_id){
		$query = $this->db->get_where($this->goods_table,array('id'=>$goods_id));
		return $query->row();
	}

	public function coupon_share_url($goodsid){
		$this->db->select('coupon_share_url');
		$query = $this->db->get_where($this->goods_table,array('id'=>$goodsid));
		return $query->row();
	}
}
