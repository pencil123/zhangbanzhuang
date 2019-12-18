<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cat extends CI_Controller {

	/**
	 * 类目类的构造函数
	 *
	 * pagination库用来翻页
	 * M_item用来查询条目
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('M_item');
		$this->load->model('M_cat');
		$this->load->model('M_keyword');
		$this->load->library('pagination');
	}

	/**
	 * 类目页
	 *
	 * @cat_slug string 类目slug，比如pants
	 *@offset integer 数据库偏移，如果是40则从40开始读取数据
	 *
	 */
	public function index($category_nick,$page = 1)
	{
	    // 判断类别是否有效
        $category_nick_decode = rawurldecode($category_nick);
        $cat_header = $this->M_cat->get_cat_info($category_nick_decode);
        if (!$cat_header) {
			show_404();
        }
		$page = ($page ==1 ) ? $page : substr($page,0,-5);
		$limit=36;
		//每页显示数目
		//所有条目数据
		$data['items']=$this->M_item->get_all_item($limit,($page-1)*$limit,$category_nick_decode);
		if(!$data['items']->num_rows()){
			show_404();
		}

		$config['base_url'] = site_url('/cat/'.$category_nick);
		//site_url可以防止换域名代码错误。
		$config['total_rows'] = $this->M_item->count_items($category_nick_decode);
		//echo $this->db->last_query();
		//这是模型里面的方法，获得总数。
		$config['suffix'] = '.html';
		$config['per_page'] = $limit;
		$config['use_page_numbers'] = TRUE;
		//上面是自定义文字以及左右的连接数
		$this->pagination->initialize($config);
		//初始化配置
		$data['pagination']=$this->pagination->create_links();
		//通过数组传递参数

		$this->config->load('site_info');
		//站点信息
		$header['site_name'] = $this->config->item('site_name');
		//分类标题

		$header['site_title'] = $cat_header->category_title;
		$header['site_keyword'] = $cat_header->category_keyword;
		$header['site_description'] = $cat_header->category_description;

		//关键词列表，这个在后台配置
		$header['keyword_list'] = $this->M_keyword->get_all_keyword(5);
		//分类标题
		$header['cat']=$this->M_cat->get_all_cat();
		$header['cat_slug'] = $category_nick_decode;

		$this->load->view("header",$header);
		$this->load->view('welcome_message',$data);
		$this->load->view('footer');
	}

	/**
	 * url转移
	 *
	 * 把/cat/pants/50这样的url转到index($cat_slug,$offset = 0)来处理
	 * 好处是只用创建一个function index就可以处理所有的类别/shirts或者/pants等等
	 *
	 * @slug String 类别slug，比如pants
	 * @params array 其他后续参数
	 */
	public function _remap($slug, $params = array())
	{
		//把$slug插入到$param后面，然后$param作为一个整体传递给index()调用
		array_unshift($params,$slug);

		return call_user_func_array(array('Cat', 'index'), $params);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
