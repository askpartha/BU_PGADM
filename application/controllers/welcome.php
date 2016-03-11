<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper( array('url', 'form', 'text') );
		$this->load->library('authenticate', 'session');
		$this->load->model('usermodel');
		
	}
	
	function index() {
		$data['page_title'] = "Post Graduate Admission";
		$this->load->view('welcome', $data);
		//$this->load->view('comingsoon', $data);
		//$this->load->view('maintenance', $data);
	}
	
	function browser() {
		$data['page_title'] = "The University of Burdwan - Download the latest browser";
		$this->load->view('browser', $data);
	}

}
?>