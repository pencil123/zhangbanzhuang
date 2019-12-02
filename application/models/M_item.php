<?php

class M_item extends CI_Model{

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
	function get_all_item($limit='40',$offset='0',$category_nick='')
	{

		//如果是分类页
		if(!empty($category_nick)){
            $select_sql = "select id from category where parent_id = (select id from category where category_nick = ?);";
            $id_query = $this->db->query($select_sql,$category_nick);

            $this->db->where_in('my_category_id',$id_query->row_array());
			$this->db->order_by('volume DESC');
			$query = $this->db->get($this->item_table,$limit,$offset);
			}
		//如果是主页
		else{
			$this->db->where(' coupon_end_time > ',$this->today);
			$this->db->order_by("volume", "desc");
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
	function count_items($category_nick=''){
		if(empty($category_nick)){
			return $this->db->count_all_results($this->item_table);
		}else{
		    $select_sql = "select id from category where parent_id = (select id from category where category_nick = ?);";
		    $id_query = $this->db->query($select_sql,$category_nick);
			$this->db->select('COUNT(1) AS count');
			$this->db->where_in('my_category_id',$id_query->row_array());
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

    /**
     * 根据id查找条目
     *
     * @param integer $item_id 条目ID
     * @return
     */
    // function getItem($item_id){
    //     $data = array(
    //            'id' => $item_id
    //         );
    //     $query = $this->db->get_where($this->item_table, $data);
    //     if($query->num_rows()>0){
    //     	$result = $query->result();
    //     	return $result[0];
    //     }else return null;
    // }

    /**
     * 根据关键词搜索条目
     *
     * @param string $keyword 搜索关键词
     * @return
     */
    function searchItem($keyword){
		$this->db->like('title',$keyword);
		$query = $this->db->get($this->item_table);
		return $query;
    }

    /**
     * 查询每个店铺对应的点击
     *
     * @return 查询结果
     */
	function query_shops(){
		$this->db->select("sellernick,count(sellernick) as count,SUM(click_count) as sum");
		$this->db->group_by('sellernick')->order_by('count DESC');
		$query = $this->db->get($this->item_table);
		return $query;
	}

    /**
     * 判断条目是否已经存在
     *
     * @param integer $item_id 条目ID
     * @return boolean 是否存在
     */
    // function itemExist($item_id){
    //     $data = array(
    //                   'id' => $item_id
    //                );
    //            $query = $this->db->get_where($this->item_table, $data);
    //     if($query->num_rows() > 0){
    //         return true;
    //     }else {
    //         return false;
    //     }
    // }



}
