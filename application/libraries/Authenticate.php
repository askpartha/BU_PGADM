<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
* Authenticate security library for Code Igniter applications
* Author: Partha Sarathi Ghosh, 2015
*
*/
define('STATUS_ACTIVATED', '1');
define('STATUS_NOT_ACTIVATED', '0');

class Authenticate 
{

	function Authenticate()
	{
		$this->ci =& get_instance();
		$this->ci->load->library('session');
		$this->ci->load->database();
		$this->ci->load->model('usermodel');
		$this->ci->load->model('configmodel');
	}

	//user authentication
	function authenticate_user($username, $password) {
		if(!is_null($this->ci->usermodel->authenticate_user($username, $password))) {			
			$authenticate_user = $this->ci->usermodel->authenticate_user($username, $password);
			$this->ci->session->set_userdata('user', $authenticate_user);	
			return true;
		}
		return false;
	}
	
	//student authentication
	function authenticate_student($username, $password) {
		if(!is_null($this->ci->usermodel->authenticate_student($username, $password))) {			
			$authenticate_student = $this->ci->usermodel->authenticate_student($username, $password);
			$this->ci->session->set_userdata('student', $authenticate_student);	
			return true;
		}
		return false;
	}
	
	function is_logged_in() {	
		if ($this->ci->session) {
			//If user has valid session, and such is logged in
			if( (count($this->ci->session->userdata('user')) > 1) OR (count($this->ci->session->userdata('student')) > 1)  )  {
				return TRUE;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	} 

	function has_access($permission = null) {
		//echo $this->ci->router->fetch_class();
		//echo $this->ci->router->fetch_method();
		
		$user_permission = $this->ci->usermodel->get_user_permission($permission);
		if($user_permission) {		
			return true;
		}
		
		return false;
	}
}
?>