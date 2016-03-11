<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Operations extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper( array('url', 'form', 'text') );
		$this->load->library('authenticate', 'session');
		$this->load->model('usermodel');
		$this->load->model('configmodel');
		$this->load->model('staticconfigmodel');
		$this->load->model('admissionmodel');
		$this->load->model('operationmodel');
		$this->load->model('resultmodel');
	}
	//******************  FILE UPLOAD : START ************************	
	function uploadpayments() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center"){
				$data['payment_files'] = $this->operationmodel->getAllFiles();
				$data['page_title'] = "Configure Payment Files";
				$this->load->view('header', $data);
				$this->load->view('operations/uploadpayment', $data);
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
		
	//add payment file item
	function createpaymentfile() {
		//$this->output->enable_profiler(TRUE);
		//echo "PARTHA"; exit();
		
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center"){
				  if (isset($_FILES['userfile'])){
				  	
						$config['upload_path'] = '././upload/payments/';
						$config['allowed_types'] = 'csv|CSV';
						$config['overwrite'] = TRUE;
						
						$this->load->library('upload', $config);
						if ( ! $this->upload->do_upload()){
							$this->session->set_flashdata('failure', 'File not uploaded because '.$this->upload->display_errors());	
						}else{
							$status = $this->operationmodel->createFile();
							if($status){
								$this->session->set_flashdata('success', 'Record created succesfully');	
							}else{
								$this->session->set_flashdata('failure', 'Record not  created succesfully');
							}
						}
						
					}
				redirect('operations/uploadpayments');	
			} else {
				redirect('users/unauthorised');
			}
		}	
	}

	// load list of payment file in AJAX 
	function loadpaymentfiles() {
		echo json_encode($this->operationmodel->getAllFiles());
	}

	//delete payment file item
	function deletepaymentfile() {
		echo $this->operationmodel->deleteFile($_POST['id']);
	}

	function processpaymentfiles(){
		echo $this->operationmodel->processFile($_POST['id']);
	}
	
	function processpayments() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center"){
				$data['payment_files'] = $this->operationmodel->getAllProcessFiles();
				$data['page_title'] = "Process Payment";
				$this->load->view('header', $data);
				$this->load->view('operations/processpayment', $data);
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	// load list of payment file in AJAX 
	function loadpayments() {
		echo json_encode($this->operationmodel->getAllProcessFiles());
	}
	
	function verifysystempayments(){
		echo $this->operationmodel->processPayments($_POST['id']);
	}
	
	//download non verified records.
	function downloadnonverifiedrecord($id=null){
		$this->operationmodel->getNonVerifiedRecordById($id);	
	}
	
	function processexaminations(){
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center"){
					
				$data['subjects'] 	 = $this->operationmodel->getAllExamSubjectsInfo();
				
				$data['page_title'] = "Process Examination Seats";
				$this->load->view('header', $data);
				$this->load->view('operations/processexaminations', $data);
			} else {
				redirect('users/unauthorised');
			}
		}
	}
	
	function processsubject(){
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center"){
				  	
					$flag = $this->operationmodel->ValidateSeatSubject();
				
					if($flag){
						$status = $this->operationmodel->ProcessSeatSubject();
						if($status){
							$this->session->set_flashdata('success', 'Seat allotment done succesfully');	
						}else{
							$this->session->set_flashdata('failure', 'Seat allotment not done succesfully');
						}
					}else{
						$this->session->set_flashdata('failure', 'Number of student and alloted subject is not equal. Please alloted subject carefully');
					}
					
						
				redirect('operations/processexaminations');	
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	
	function revokesubject(){
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center"){
				  	
					$status = $this->operationmodel->RevokeSeatSubject();
					
					if($status){
						$this->session->set_flashdata('success', 'Seat allotment revoked succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Seat allotment not revoked succesfully');
					}
						
				redirect('operations/processexaminations');	
			} else {
				redirect('users/unauthorised');
			}
		}
	}
	
	function processrollnumbers(){
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center"){
				$data['page_title'] = "Process Roll Numbers";
				$this->load->view('header', $data);
				$this->load->view('operations/processrollnumbers', $data);
				
			} else {
				redirect('users/unauthorised');
			}
		}
	}
	
	function allocateRollNumber(){
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center"){
				  	
					$status = $this->operationmodel->allocateRollNumber();
					
					if($status){
						$this->session->set_flashdata('success', 'Roll number allocated succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Roll number not allocated  succesfully');
					}
						
				redirect('operations/processrollnumbers');	
			} else {
				redirect('users/unauthorised');
			}
		}
	}
	
	function revokeRollNumber(){
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center"){
				  	
					$status = $this->operationmodel->revokeRollNumber();
					
					if($status){
						$this->session->set_flashdata('success', 'Roll number revoked succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Roll number not revoked  succesfully');
					}
						
				redirect('operations/processrollnumbers');	
			} else {
				redirect('users/unauthorised');
			}
		}
	}
	
	function process60meritlists(){
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center"){
				$data['generated_subjects'] 	 = $this->resultmodel->getGenaratedMeritSubject('60PCT');
				$data['non_generated_subjects']  = $this->resultmodel->getNonGenaratedMeritSubject('60PCT');
				$data['page_title'] = "Process Merit Lists";
				$this->load->view('header', $data);
				$this->load->view('operations/process60meritlists', $data);
			} else {
				redirect('users/unauthorised');
			}
		}
	}
	
	function process60merits(){
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center"){
				$status = $this->resultmodel->ProcessMeritList('60PCT');
				if($status){
					$this->session->set_flashdata('success', 'Merit lists done succesfully');	
				}else{
					$this->session->set_flashdata('failure', 'Merit lists not done succesfully');
				}
				$data['generated_subjects'] 	 = $this->resultmodel->getGenaratedMeritSubject('60PCT');
				$data['non_generated_subjects']  = $this->resultmodel->getNonGenaratedMeritSubject('60PCT');
				redirect('operations/process60meritlists');	
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	
	function revoke60merits(){
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center"){
					$status = $this->resultmodel->RevokeMeritList('60PCT');
					if($status){
						$this->session->set_flashdata('success', 'Merit lists revoked succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Merit lists not revoked succesfully');
					}
					$data['generated_subjects'] 	 = $this->resultmodel->getGenaratedMeritSubject('60PCT');
					$data['non_generated_subjects']  = $this->resultmodel->getNonGenaratedMeritSubject('60PCT');
				redirect('operations/process60meritlists');	
			} else {
				redirect('users/unauthorised');
			}
		}
	}
	
	function process40meritlists(){
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center"){
				$data['generated_subjects'] 	 = $this->resultmodel->getGenaratedMeritSubject('40PCT');
				$data['non_generated_subjects']  = $this->resultmodel->getNonGenaratedMeritSubject('40PCT');
				$data['page_title'] = "Process Merit Lists";
				$this->load->view('header', $data);
				$this->load->view('operations/process40meritlists', $data);
			} else {
				redirect('users/unauthorised');
			}
		}
	}
	
	function process40merits(){
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center"){
				$status = $this->resultmodel->ProcessMeritList('40PCT');
				if($status){
					$this->session->set_flashdata('success', 'Merit lists done succesfully');	
				}else{
					$this->session->set_flashdata('failure', 'Merit lists not done succesfully');
				}
				$data['generated_subjects'] 	 = $this->resultmodel->getGenaratedMeritSubject('40PCT');
				$data['non_generated_subjects']  = $this->resultmodel->getNonGenaratedMeritSubject('40PCT');
				redirect('operations/process40meritlists');	
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	
	function revoke40merits(){
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center"){
					$status = $this->resultmodel->RevokeMeritList('40PCT');
					if($status){
						$this->session->set_flashdata('success', 'Merit lists revoked succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Merit lists not revoked succesfully');
					}
					$data['generated_subjects'] 	 = $this->resultmodel->getGenaratedMeritSubject('40PCT');
					$data['non_generated_subjects']  = $this->resultmodel->getNonGenaratedMeritSubject('40PCT');
				redirect('operations/process40meritlists');	
			} else {
				redirect('users/unauthorised');
			}
		}
	}
	//******************  FILE UPLOAD : END ************************

	
}
