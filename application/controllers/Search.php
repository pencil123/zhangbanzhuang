<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {

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
	/**
	 * 搜索结果页
	 *
	 */
	public function index($page = 1){

		//获取搜索关键词+过滤
		$keyword = trim($this->input->get('keyword', TRUE),"'\"><");

		$limit=36;
		$config['base_url'] = site_url('/search/index');
		//$config['first_url'] = site_url('/welcome');
		$config['per_page'] = $limit;
		$config['total_rows'] = $this->mwelcome->searchItems_count($keyword);
		$config['use_page_numbers'] = TRUE;
		$config['reuse_query_string'] = TRUE;
		$this->pagination->initialize($config);
		$data['pagination']=$this->pagination->create_links();

		$this->config->load('site_info');
		//站点信息
		$header['site_name'] = $this->config->item('site_name');
		//keysords和description
		$header['site_title'] = $keyword."_".$header['site_name'];
		$header['site_keyword'] = $this->config->item('site_keyword');
		$header['site_description'] = $this->config->item('site_description');
		//关键词列表，这个在后台配置
		$header['keyword_list'] = $this->M_keyword->get_all_keyword(5);
		//分类标题
		$header['cat']=$this->M_cat->get_all_cat();

		$this->mwelcome->add_keyword_if_not_exist($keyword);

		//搜索条目的结果
		$data['resp'] = $this->mwelcome->searchItem($keyword,$limit,($page-1)*$limit);
		$data['keyword'] = $keyword;

		$this->load->view("header",$header);
		$this->load->view('search_view',$data);
		$this->load->view("footer");
	}
}
