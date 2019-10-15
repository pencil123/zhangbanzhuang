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
		$this->load->library('pagination');
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
		$config['num_links']=10;
		$config['per_page'] = $limit;
		$config['total_rows'] = $this->mwelcome->items_count();
		$config['use_page_numbers'] = TRUE;
		$this->pagination->initialize($config);
		$data['pagination']=$this->pagination->create_links();
		//$data['news'] = $this->mwelcome->get_all_items();

		//条目数据
		$data['news']=$this->mwelcome->get_all_items($limit,($page-1)*$limit);

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
}
