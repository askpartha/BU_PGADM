<?php
class Users extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->helper( array('url', 'form', 'text') );
		$this->load->library('authenticate', 'session');
		$this->load->model('usermodel');
		$this->load->model('configmodel');
		$this->load->model('reportmodel');	
	}
	
	function login() {
		if($this->input->post('username')) {
			if ( $this->authenticate->authenticate_user($this->input->post('username'), $this->input->post('userpass')) && $this->authenticate->is_logged_in()) {
				redirect('users/dashboard');
			} else {
				$this->session->set_flashdata('failure', 'Authentication failed');
				redirect('users/login');
			}
		}
		$data['page_title'] = "Login";
		$this->load->view('login', $data);
	}	
	
	function logout() {
		$this->session->sess_destroy();
		redirect('');
	}	
	
	//**********************  PASSWORD OPERATION : START ******************
	// change password : Done
	function changepass() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			$data['page_title'] = "Login";
			$this->load->view('login', $data);
		} else {
			if($this->input->post('user_password')) {
				$status = $this->usermodel->changePassword();
				if($status == 1) {
					$this->session->set_flashdata('success', 'Password changed succesfully');
				} else {
					$this->session->set_flashdata('failure', 'Password change unsuccesful');
				}		
				redirect('users/changepass');
			}	
			$data['page_title'] = "Change Password";
			$this->load->view('header', $data);
			$this->load->view('users/changepass');
		}
	}		
	
	//reset user password
	function resetpasswd(){
		//$this->output->enable_profiler(TRUE);
		
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center"){
				$data['info'] = null;
				if($this->input->post('user_name') || $this->input->post('user_firstname') || $this->input->post('user_phone')){
					$data['info'] = $this->usermodel->getDetailsForResetPassword();
				}	
				
				$data['page_title'] = "Reset Student Password";
				$this->load->view('header', $data);
				$this->load->view('users/resetpasswd', $data);
			} else {
				redirect('users/unauthorised');
			}
		}
	}
	
	//generate password from admin level
	function generatepasswd(){
		//$this->output->enable_profiler(TRUE);
		
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			
			if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center"){
				if($_POST['user_id'] != ''){
					$user_data = $this->usermodel->setUserPasswordByUserId($_POST['user_id']);
					if($user_data['status']){
						sendUserPassword($user_data);
						//echo $user_data['user_password'];
						echo '(PASSWORD UPDATED SUCCESSFULLY.)';
					}else{
						echo '(PASSWORD UPDATION FAILED.)';
					}
				}	
			} else {
				redirect('users/unauthorised');
			}
		}
	}
	
	
	//**********************  PASSWORD OPERATION : END ******************
	
	// user dashboard : Done
	function dashboard() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			$data['page_title'] = "Login";
			$this->load->view('login', $data);
		} else {
			$data['subject_options'] = $this->configmodel->getPgSubjectOptions();
			$data['stats'] = $this->reportmodel->getDashboardStats($this->input->post("pg_subj_code"));
			$data['payments'] = $this->reportmodel->getPaymentByDateInfo();
			//print_r($this->reportmodel->getDashboardUsers()); exit();
			
			$data['usrs'] = $this->reportmodel->getDashboardUsers();
			$data['page_title'] = "Dashboard";
			$data['active_link'] = "";
			$this->load->view('header', $data);
			$this->load->view('users/dashboard');
		}	
	}	
	
	//unauthorised
	public function unauthorised() {
		$data['page_title'] = "Unauthorised Access";
		$this->load->view('unauthorised', $data);
	}
	
	//***************** USER : START ****************
	// load list of users in AJAX 
	function loadusers() {
		echo json_encode($this->usermodel->getUsers());
	}	
	
	//list all users
	function musers() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				$data['user_role_options'] = $this->staticconfigmodel->getRoleOption();
				$data['dept_options'] = $this->configmodel->getPgSubjectOptions();
				$data['users'] = array();
				$data['page_title'] = "User management";
				$this->load->view('header', $data);
				$this->load->view('users/index', $data);
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	function createuser(){
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				if($this->input->post('form_action') == 'add') {
					$results = $this->usermodel->insertUser();
					if($results['status']){
						$msg = 'Record created succesfully';
						//$msg .= '<br/><b>Password : </b> ' . $results['password'];
						$this->session->set_flashdata('success', $msg);	
						
						$arr = array(
									"user_name"		=>$this->input->post('user_name'), 
									"user_phone"	=>$this->input->post('user_phone'),
									"user_password" =>$results['password'], 
									"user_email"	=>"",
									);
						sendUserPassword($arr);
						
					}else{
						$msg = 'Record not created';
						$msg .= '<br/><b>Cause : </b> ' . $results['cause'];
						$this->session->set_flashdata('failure', $msg);
					}
					$this->load->view('users/index', $data);
					redirect('users/musers');	
				} elseif($this->input->post('form_action') == 'edit') {
					$results = $this->usermodel->updateUser();
					if($results.status){
						$msg = 'Record updated succesfully';
						$this->session->set_flashdata('success', $msg);	
					}else{
						$msg = 'Record not updated';
						$msg .= '<br/><b>Cause : </b> '. $results['cause'];
						$this->session->set_flashdata('failure', $msg);
					}
					redirect('users/musers');	
				}
			} else {
				redirect('users/unauthorised');
			}
		}
	}

	// delete user 
	function deluser() {
		echo $this->usermodel->deleteUser($_POST['id']);
	}
	//***************** USER : END ****************
	
	
	
}