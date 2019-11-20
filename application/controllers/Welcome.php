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

	public function wechat($page = 1){
	    $limit = 20;
        $result =$this->mwelcome->get_all_items($limit,($page-1)*$limit);
        $data['result'] = true;
        $data['data'] = $result->result_array();
        echo json_encode($data);
    }

	public function page($page = 1)
	{
		$this->config->load('site_info');
		//站点信息
		$header['site_name'] = $this->config->item('site_name');
		//keysords和description
		$header['site_title'] = $this->config->item('site_title');
		$header['site_keyword'] = $this->config->item('site_keyword');
		$header['site_description'] = $this->config->item('site_description');
		//关键词列表，这个在后台配置
		$header['keyword_list'] = $this->M_keyword->get_all_keyword(5);
		//分类标题
		$header['cat']=$this->M_cat->get_all_cat();

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

		//条目数据
		$page = ($page ==1 ) ? $page : substr($page,0,-5);
		$data['items']=$this->mwelcome->get_all_items($limit,($page-1)*$limit);
		$this->load->view("header",$header);
		$this->load->view('welcome_message',$data);
		$this->load->view('footer');
	}
}
