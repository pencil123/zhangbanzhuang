<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct()
	{
		parent::__construct();
		$this->load->model('mwelcome');
		$this->load->model('M_keyword');
		$this->load->model('M_cat');
		$this->load->library('pagination');

		$this->config->load('site_info');
	//	$this->load->helper('url_helper');
	}

	public function index(){
		$this->page();
	}

	public function page($page = 1)
	{
		$limit=40;
		$config['base_url'] = site_url('/welcome/page');
		$config['first_url'] = site_url('/welcome');
		$config['first_link'] = '首页';
		$config['last_link'] = '尾页';
		$config['suffix'] = '.html';
		$config['num_links']=10;
		$config['per_page'] = $limit;
		$config['total_rows'] = $this->mwelcome->items_count();
		$config['use_page_numbers'] = TRUE;
		$this->pagination->initialize($config);
		$data['pagination']=$this->pagination->create_links();
		$data['site_name'] = $this->config->item('site_name');
		//$data['news'] = $this->mwelcome->get_all_items();

		//站点信息
		$data['site_name'] = $this->config->item('site_name');
		//keysords和description
		$data['site_keyword'] = $this->config->item('site_keyword');
		$data['site_description'] = $this->config->item('site_description');

		//类别
		$data['cat'] = $this->M_cat->get_all_cat();

		//关键词列表，这个在后台配置
		$data['keyword_list'] = $this->M_keyword->get_all_keyword(5);

		//条目数据
		$page = ($page ==1 ) ? $page : substr($page,0,-5);
		$data['items']=$this->mwelcome->get_all_items($limit,($page-1)*$limit);
		$this->load->view('welcome_message',$data);
	}

	/**
	 * 跳转函数，同时记录点击数量
	 *
	 * 点击记数要排除机器访问
	 */
	public function redirect($item_id){
	echo $item_id;
		$this->load->library('user_agent');
		if(!$this->agent->is_robot()){
			$this->mwelcome->add_click_count($item_id);
		}

		Header("HTTP/1.1 303 See Other");
		Header("Location: ".$this->mwelcome->get_item_clickurl($item_id));
		exit;
	}


	/**
	 * 搜索结果页
	 *
	 */
	public function search($page = 1){
/*		$this->load->model('M_taobaoapi');
		$data['cat'] = $this->M_cat->get_all_cat();*/

		//获取搜索关键词+过滤
		$data['keyword'] = trim($this->input->get('keyword', TRUE),"'\"><");
		$limit=40;
		$config['base_url'] = site_url('/welcome/search');
		$config['first_url'] = site_url('/welcome');
		$config['first_link'] = '首页';
		$config['last_link'] = '尾页';
		$config['num_links']=10;
		$config['per_page'] = $limit;
		$config['total_rows'] = $this->mwelcome->searchItems_count($data['keyword']);
		$config['use_page_numbers'] = TRUE;
		$config['reuse_query_string'] = TRUE;
		$this->pagination->initialize($config);
		$data['pagination']=$this->pagination->create_links();

		//类别
		$data['cat'] = $this->M_cat->get_all_cat();

		$this->mwelcome->add_keyword_if_not_exist($data['keyword']);

		//关键词列表，这个在后台配置
		$data['keyword_list'] = $this->M_keyword->get_all_keyword(5);

		//搜索条目的结果
		$data['resp'] = $this->mwelcome->searchItem($data['keyword'],$limit,($page-1)*$limit);


		//站点信息
		$data['site_name'] = $this->config->item('site_name');
		//keysords和description
		$data['site_keyword'] = $this->config->item('site_keyword');
		$data['site_description'] = $this->config->item('site_description');

		$this->load->view('search_view',$data);
	}
}
