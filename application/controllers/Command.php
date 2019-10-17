<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Command extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('M_command');
	}

	/**
	 * 翻页控制器
	 *
	 * @param integer $page 第几页
	 */
	public function items($page = 1)
	{
		echo date('Y-m-d');
		$this->M_command->get_all_items();

	}
}
