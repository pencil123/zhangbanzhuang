<?php

class M_guesslike extends CI_Model{

    var $cat_table = '';
    var $item_table = '';
    var $guesslike_table = '';
    var $tody = '';


    function __construct()
    {
        parent::__construct();
        $this->goods_table = $this->db->dbprefix('material');
        $this->guesslike_table = $this->db->dbprefix('guess_like');
        $this->today = date('Y-m-d');
    }

    function init()
    {
        $this->load->database();
    }

    public function guess_like($category_id,$goods_id){
    	$this->db->where('goods_id != '.$goods_id);
        $query = $this->db->get_where($this->guesslike_table,array("category_id"=>$category_id),10);
        return $query;
    }
}
