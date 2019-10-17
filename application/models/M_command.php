<?php

class M_command extends CI_Model{

        var $juan_table = '';
        var $item_table = '';
        var $cat_table = '';

	function __construct()
	{
		parent::__construct();
        $this->item_table = $this->db->dbprefix('item');
		$this->juan_table = $this->db->dbprefix('juan');
		$this->cat_table = $this->db->dbprefix('cat');
	}

	public function get_all_items(){
		$query = $this->db->get($this->juan_table);
/*		foreach ($query->result() as $row ){
			$row->type = ((mb_strpos($row->type,"/")) == false)? $row->type : mb_substr($row->type,0,mb_strpos($row->type,"/"));
			$row->cid = 2000;
			$row->num_iid = "not found";
			try {
				$this->db->insert($this->item_table,$row);
			} catch (Exception $e) {

			}

		}*/

/*		$cat_query = $this->db->query("select type as cat_name,count(1) as cat_count from item group by type");
		foreach ($cat_query->result() as $row) {
			$row->cat_slug = $row->cat_name;
			$this->db->insert($this->cat_table,$row);
		}*/

		$this->db->query("update item,cat set item.cid = cat.cat_id where item.type = cat.cat_name");

		return true;
	}

	//通过POST传递过来的参数，可以存入到数据库中，然后返回一个“添加成功！”
	function set_item(){
		$data = array(
               'title' => $_POST['title'],
               'img_url' => $_POST['img_url'],
               'cid' => $_POST['cid'],
               'click_url' =>  $_POST['click_url'],
               'price' => $_POST['price'],
               'sellernick' => $_POST['sellernick'],
               'num_iid' => $_POST['num_iid']
            );
		return $this->db->insert('item', $data);
	}

	function delete_item($item_id){
		$data = array(
               'id' => $item_id
            );
		$this->db->delete('item', $data);
		echo '1';
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

	//获得所有条目
	//$limit为每页书目，必填
	//$offset为偏移，必填
	function get_all_item($limit='40',$offset='0',$cat='')
	{

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
	function count_items($cat_slug=''){
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
}
