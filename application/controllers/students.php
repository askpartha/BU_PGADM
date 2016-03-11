<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Students extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper( array('url', 'form', 'text') );
		$this->load->library('authenticate', 'session');
		$this->load->library('foto');
		$this->load->model('configmodel');
		$this->load->model('staticconfigmodel');
		$this->load->model('usermodel');
		$this->load->model('admissionmodel');
		$this->load->model('studentmodel');
		$this->load->model('resultmodel');
	}

	//student login
	function studentlogin($redirect=null) {
		if($redirect!=null){
			if($this->authenticate->authenticate_student($redirect, $this->session->userdata['student']['appl_passwd']) && $this->authenticate->is_logged_in()) {	
				redirect('students/dashboard');
			} else {
				//$this->session->set_flashdata('failure', 'Authentication failed');
				redirect('students/studentlogin');
			}	
		}else{
			if($this->input->post('appl_num')) {
				if ($this->authenticate->authenticate_student($this->input->post('appl_num'), $this->input->post('appl_passwd')) && $this->authenticate->is_logged_in()) {
					redirect('students/dashboard');
				} else {
					$this->session->set_flashdata('failure', 'Authentication failed');
					redirect('students/studentlogin');
				}	
			} 
		}
		$data['page_title'] = "Student Login";
		$this->load->view('students/login', $data);
	}
	
	//student dashboard :Done
	function dashboard() {
		if ( !$this->authenticate->is_logged_in()) {
			redirect('students/studentlogin');
		} else {
				
			$this->session->userdata['admitcard'] = $this->getAdmitCardDateCriteria();
			$this->session->userdata['rankcard_60']  = $this->getRankCardDateCriteria('60RD');
			$this->session->userdata['rankcard_40']  = $this->getRankCardDateCriteria('40RD');
			
			$data['page_title'] = "Student Dashboard";
			$this->load->view('web_header', $data);
			$this->load->view('students/dashboard', $data);
		}
	}

	function getAdmitCardDateCriteria(){
		$flag = 1;
		$todaysDate = new DateTime();
		$appl_start_date = $this->admissionmodel->getScheduleDate('AD');
		if($appl_start_date != "" && $todaysDate <= $appl_start_date){
			$flag = 0;
		}
		return $flag;
	}

	function getRankCardDateCriteria($param){
		$flag = 1;
		$todaysDate = new DateTime();
		$appl_start_date = $this->admissionmodel->getScheduleDate($param);
		if($appl_start_date != "" && $todaysDate <= $appl_start_date){
			$flag = 0;
		}
		return $flag;
	}

	//student upload photo : Done
	function uploadphoto() {
		if ( !$this->authenticate->is_logged_in()) {
			redirect('students/studentlogin');
		} else {
			if($this->input->post('pg_appl_code')){
				$status = true;
				$filename = $_FILES['upload']['name'];
				if($filename != "") {
					$file_arr = explode(".", $filename);
				
					$path = realpath(APPPATH . '../upload/students/profile_pic');
				
					$new_img_name = $this->input->post('pg_appl_code') . "." . $file_arr[1];
					$new_img_name = strtolower($new_img_name);
					$new_img_path = $path . "/" . $new_img_name;
					
					//$smImgPath = $path . "/s_" . $new_img_name;
					$thumbImgPath = $path . "/t_" . $new_img_name;

					//upload the photo
					move_uploaded_file($_FILES['upload']['tmp_name'], $path . "/" . $new_img_name);
					
					//echo $new_img_path; exit();
					
					//resize photos
					//$this->foto->resizePhoto($new_img_path, $smImgPath, 240, 240, 1);
					$status = $this->foto->resizePhoto($new_img_path, $thumbImgPath, 90, 90, 1);
					@unlink($new_img_path);
					$this->studentmodel->updateProfilePic($this->input->post('pg_appl_code'), $new_img_name); //update DB
				}	
				if($status){
					$this->session->set_flashdata('success', 'Photo Uploaded successfully. Logout from profile and login again.');	
				}else{
					$this->session->set_flashdata('failure', $status);
				}

				redirect('students/uploadphoto');
			} else {
				$data['page_title'] = "Upload Photo";
				$this->load->view('web_header', $data);
				$this->load->view('students/uploadphoto', $data);
				
			}
		}
	}

	//reset password
	function resetpasswd() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center"){
				$data['info'] = null;
				if($this->input->post('pg_appl_code') || $this->input->post('pg_appl_mobile') ){
					$data['info'] = $this->studentmodel->getDetailsForResetPassword();
				}	
				
				$data['page_title'] = "Reset Student Password";
				$this->load->view('header', $data);
				$this->load->view('students/resetpasswd', $data);
			} else {
				redirect('users/unauthorised');
			}
		}
	}
	
	//generate random password
	function generatepasswd() {
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			
			if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center"){
				if($_POST['pg_appl_sl_num'] != ''){
					$user_data = $this->usermodel->setStudentPasswordByStudentId($_POST['pg_appl_sl_num']);
					if($user_data['status']){
						sendStudentPassword($user_data);
						//echo $user_data['user_password'];
						if($user_data['user_email'] != ''){
							$this->sendForgotPassword($user_data);
						}
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
	
	//change password : Done
	function changepass() {
		if ( !$this->authenticate->is_logged_in()) {
			redirect('students/studentlogin');
		} else {
			if($this->input->post('pg_appl_password')){
				$modified_by = 'student';
				$status = $this->studentmodel->updatePassword($this->session->userdata('appl_code') , $this->input->post('pg_appl_password'), $modified_by);
				if($status){
					$this->session->set_flashdata('success', 'Password changed successfully');
				}else{
					$this->session->set_flashdata('failure', 'Password change unsuccessful');
				}	
				redirect('students/changepass');
			} else {
				$data['page_title'] = "Change Password";
				$this->load->view('web_header', $data);
				$this->load->view('students/changepass', $data);
			
			}	
		}
	}	

	function forgotpass(){
		$pg_appl_code = $_REQUEST['pg_appl_code'];
		$mobile_number = $_REQUEST['pg_apl_mobile'];
		
		$info = $this->studentmodel->isApplicationExistsForApplicationCodeMobileNumber($pg_appl_code, $mobile_number);
		
		if($info['status']){
			$user_data = $this->usermodel->setStudentPasswordByStudentId($info['pg_appl_sl_num']);
			if($user_data['status']){
				sendStudentPassword($user_data);
				//echo $user_data['user_password'];
				if($user_data['user_email'] != ''){
					$this->sendForgotPassword($user_data);
				}
				echo '(PASSWORD SEND TO YOUR REGISTERED MOBILE NUMBER AND REGISTERED EMAIL.)';
			}else{
				echo '(PASSWORD UPDATION FAILED.)';
			}
		}else{
			echo 'Applicaion Number, Mobile Number combination not available.';
		}
	}
	
	
	function sendForgotPassword($data){
		$config = array();
        $config['mailtype'] = 'html';
        $config['charset']  = 'utf-8';
        $config['newline']  = "\r\n";
        $config['wordwrap'] = TRUE;
		
	    $this->load->library('email'); // load email library
	    $this->email->initialize($config);
	    $this->email->from('buruniv@gmail.com', 'The University of Burdwan');
	    $this->email->to($data['user_email']);
	    $this->email->subject('Re-generated password');
		$message=$this->load->view('emails/forgotpass',$data,TRUE);
		$this->email->message($message);
		$this->email->send();
	}
	
	
	function results(){
		//$this->output->enable_profiler(TRUE);
		$data['result_notices'] = $this->admissionmodel->getNoticeByCategory('Result');
		$data['page_title'] = "Result for Applied Students";
		
		$data['subject_options'] = $this->configmodel->getPgSubjectOptions();
		
		$todaysDateObj = new DateTime();
		$res60PubDate = $this->admissionmodel->getScheduleDateByName('60RD');
		$res40PubDate = $this->admissionmodel->getScheduleDateByName('40RD');
		$res60PubDateObj = new DateTime($res60PubDate);
		$res40PubDateObj = new DateTime($res40PubDate);
		
		$result60_publication_flag = false;
		$result40_publication_flag = false;
		
		if(($todaysDateObj >= $res60PubDateObj)){
			$result60_publication_flag = true;
		}
		if(($todaysDateObj >= $res40PubDateObj)){
			$result40_publication_flag = true;
		}
		//echo $result_publication_flag; exit();
		
		$data['result60_publication_flag'] = $result60_publication_flag;
		$data['result40_publication_flag'] = $result40_publication_flag;
		$data['apl_result60_date'] = $res60PubDate;
		$data['apl_result40_date'] = $res40PubDate;
		
		if(isset($_POST['seat_ctgry']) && $_POST['seat_ctgry'] == '60PCT'){
			$data['result60']	= $this->resultmodel->getMeritLists($this->input->post('pg_subject'), '60PCT');
		}else{
			$data['result60'] = array();
		}
		
		//echo $this->input->post('pg_subject_40'); exit();
		
		if(isset($_POST['seat_ctgry']) && $_POST['seat_ctgry'] == '40PCT'){
			$data['result40']	= $this->resultmodel->getMeritLists($this->input->post('pg_subject_40'), '40PCT');
		}else{
			$data['result40'] = array();
		}
		
		$this->load->view('web_header', $data);
		$this->load->view('students/results', $data);
	}

	//confirm bank payments
	function confirmbankpayment(){
		if ( !$this->authenticate->is_logged_in()) {
			redirect('students/studentlogin');
		} else {
				
			$posted['amount'] 		= applicationFeesAmount();
			$posted['firstname'] 	= 'PARTHA';
			$posted['email'] 		= "partha.silicon@gmail.com";
			$posted['phone'] 		= "9007307259";
			$posted['txnid'] 		= "15CHEM00001";
			$posted['productinfo'] 		= "PG Online Application";
			
			//print_r($posted); exit();
			
			$data['cand'] = $posted;
			$data['page_title'] = "Student Dashboard";
			$this->load->view('web_header', $data);
			$this->load->view('students/confirmbankpayment', $data);
		}
	}
	//============================================== BELOW ARE NOT USED =============================
	//call for SMS notification
	function callfornotify() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" ||  
				$this->session->userdata['user']['user_role'] == "Center") {
					
				$current_page = 1;
				$per_page = (intval($this->input->post('records_per_page')) > 0) ? intval($this->input->post('records_per_page')) : $this->configmodel->getConfigByKey('records_per_page');
					
				$data['studycenter_options'] = $this->configmodel->getStudyCenterOption();
				
				$data['results'] = array('students'=>array());
				$data['records_per_page'] = $per_page;//$this->configmodel->getConfigByKey('records_per_page');
				
				if($this->session->userdata['user']['user_cntr_code'] == '00') {
					$data['cntr_code'] = 'EMPTY';
					$data['subj_code'] = 'EMPTY';
					$data['subject_options'] = array();
				} else {
					$data['cntr_code'] = $this->session->userdata['user']['user_cntr_code'];
					$data['subj_code'] = 'EMPTY';
					$data['subject_options'] = $this->configmodel->getSubjectNameByCenterCodeOption($this->session->userdata['user']['user_cntr_code']);
				}
				if($this->input->post('cntr_code')) {
					
					$data['results'] = $this->studentmodel->getStudentsForNotification($this->input->post('cntr_code'), $this->input->post('subj_code'), $current_page, $per_page);
					$data['cntr_code'] = $this->input->post('cntr_code');
					$data['subj_code'] = $this->input->post('subj_code');
				} 
				
				$data['page_title'] = "Call for Notification";
				$this->load->view('header', $data);
				$this->load->view('students/callfornotify', $data);
					
			} else {
				redirect('users/unauthorised');
			}
		}
	}

	//load for SMS notification by AJAX
	function loadfornotify() {
		if($_REQUEST['cntr_code']) {
			$cntr_code = $_REQUEST['cntr_code'];
		} else {
			$cntr_code = $this->session->userdata['user']['user_cntr_code'];
		}
		$subj_code = $_REQUEST['subj_code'];
		
		$per_page = (intval($_REQUEST['records_per_page']) > 0) ? intval($_REQUEST['records_per_page']) : $this->configmodel->getConfigByKey('records_per_page');
					
		echo json_encode($this->studentmodel->getStudentsForNotification($cntr_code, $subj_code, $_REQUEST['page'], $per_page));
	}				
	
	
	//send SMS notification
	function sendnotification() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" ||  
				$this->session->userdata['user']['user_role'] == "Center") {
				$this->session->set_userdata('student_sms', $this->input->post('notify_msg'));
				$msg = $this->studentmodel->sendSMSNotification($this->input->post('h_notify'), $this->input->post('notify_msg'));
				if ($msg) {
					$this->session->set_flashdata('success', 'SMS sent succesfully');
					redirect('students/callfornotify');
				}
	
			} else {
				redirect('users/unauthorised');
			}
		}
	}	
}