<?php

class M_cat extends CI_Model{

	var $cat_table = '';
	var $item_table = '';
	var $tody = '';


	function __construct()
	{
		parent::__construct();
		$this->cat_table = $this->db->dbprefix('category');
		$this->item_table = $this->db->dbprefix('material');
		$this->today = date('Y-m-d');
	}


	function add_cat()
	{
		$data_decode = json_decode($_POST['data']);
		foreach($data_decode as $cat){
			$data = array(
				'cat_id' => $cat -> id ,
				'cat_name' =>$cat -> name,
				'cat_slug' =>$cat -> name
			);
			$this->db->insert($this->cat_table, $data);
		}
	}

	function get_cat_info($category_nick_decode = ''){
		if(!empty($category_nick_decode)){
			$query = $this->db->get_where($this->cat_table, array('category_nick'=>$category_nick_decode));
			return $query->row();
		}else {
			return false;
		}
	}

	function get_all_cat()
	{
		$this->db->order_by('hot_points desc');
		$this->db->limit(13);
		$query = $this->db->get($this->cat_table);
		return $query;
	}

	function update_cat(){
		$data_decode = json_decode($_POST['data']);
		foreach($data_decode as $cat){
			$data = array(
				'cat_name' => $cat -> name,
				'cat_slug' => $cat -> slug
			);

			$this->db->where('cat_id', $cat -> id);
			$this->db->update($this->cat_table, $data);
		}
	}

	function delete_cat($cat_id){
		$this->db->delete($this->cat_table,array('cat_id'=>$cat_id));
	}

	/**
	 * 查询每个类别对应的点击
	 *
	 * @return 查询结果
	 */
	function query_cats(){

		$this->db->select('cat_name,COUNT(id) as count, SUM(click_count) as sum');
		$where = "cid=cat_id";
		$this->db->join($this->cat_table,$where);
		$this->db->order_by('count DESC');
		$this->db->where(' end_time > ',$this->today);
		$this->db->group_by('cid');
		$query = $this->db->get($this->item_table);
		return $query;
	}

	/**
	 * 获取某类别点击总数
	 *
	 * @param integer cid 类别的id
	 * @return integer 类别点击总数
	 */
	function click_count_by_cid($cid=0){
		$cat_table = $this->cat_table;
		$item_table = $this->item_table;
		if($cid == 0){
			$this->db->select('SUM(click_count) as sum');
			$query = $this->db->get($item_table);
			$row = $query->row();
			return $row->sum;
		}else {
			$this->db->where('cid='.$cid);
			$this->db->select('SUM(click_count) as sum');
			$query = $this->db->get($item_table);
			if ($query->num_rows() > 0)
			{
				$row = $query->row();
				return $row->sum;
			}
		}
	}
}
