<?php

class Mwelcome extends CI_Model{
	var $cat_table = '';
	var $item_table = '';

	function __construct()
	{
		parent::__construct();
		$this->cat_table = $this->db->dbprefix('cat');
		$this->item_table = $this->db->dbprefix('item');
	}

	/**
	 * 初始化函数
	 *
	 * 在已经创建数据库的情况下，初始化数据库表信息
	 * 之后接受输入管理员邮箱密码，保存到数据库
	 */
	function init()
	{
		$this->load->database();
		$this->load->library('pagination');
	}

	public function get_all_items($limit=40,$offset='0',$cat=''){
		//如果是分类页
		if(!empty($cat)){
			$where = "cid=cat_id AND cat_slug='".$cat."'";
			$this->db->join($this->cat_table,$where);
			$this->db->order_by('id DESC');
			$query = $this->db->get($this->item_table,$limit,$offset);
		}
		//如果是主页
		else{
			$this->db->order_by("id", "desc");
			$query = $this->db->get($this->item_table,$limit,$offset);
		}

		return $query;
	}

	/**
	 * 获得某类别条目总数
	 *
	 * @param string cat_slug 类别的slug
	 * @return integer 类别的数目
	 */
	public function items_count(){
		if(empty($cat_slug)){
			return $this->db->count_all_results($this->item_table);
		}else{
			$this->db->select('COUNT(id) AS count');
			$where = "cid=cat_id AND cat_slug='".$cat_slug."'";
			$this->db->join($this->cat_table,$where);
			$this->db->order_by('id DESC');
			$query = $this->db->get($this->item_table);

			if ($query->num_rows() > 0)
			{
				$row = $query->row();
				return $row->count;
			}else{
				return 0;
			}
		}
	}

	/*
  * 通过条目ID获得点击url
   */
	function get_item_clickurl($item_id){
		$this->db->select('click_url');
		$data = array(
			'id' => $item_id
		);
		$query = $this->db->get_where('item', $data);
		if($query->num_rows()>0){
			foreach($query->result() as $array){
				$return_clickurl = $array->click_url;
				return $return_clickurl;
			}
		}else return 0;
	}


	/*
 * 增加条目click_count
 *  */
	function add_click_count($item_id)	{
		$this->db->set('click_count', 'click_count+1', FALSE);
		$this->db->where('id', $item_id);
		$this->db->update($this->item_table);
		return $item_id;
	}
}