<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admissions extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper( array('url', 'form', 'text') );
		$this->load->library('authenticate', 'session');
		$this->load->model('usermodel');
		$this->load->model('studentmodel');
		$this->load->model('configmodel');
		$this->load->model('staticconfigmodel');
		$this->load->model('admissionmodel');
		$this->load->model('examinationmodel');
	}


	//******************  SCHEDULE : START ************************	
	//list all schedule
	function schedules() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				$data['schedule_options'] = $this->staticconfigmodel->getScheduleTypeOption();
				$data['time_options'] = $this->staticconfigmodel->getTimeCtgrOption();
				$data['schedules'] = $this->admissionmodel->getAllSchedules();
				$data['page_title'] = "Configure Schedules";
				$this->load->view('header', $data);
				$this->load->view('admissions/schedules', $data);
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	// load list of pg subjects in AJAX 
	function loadschedules() {
		echo json_encode($this->admissionmodel->getAllSchedules());
	}	
	
	//add schedule item
	function createschedule() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				if($this->input->post('form_action') == 'add') {
					$status = $this->admissionmodel->createSchedule();
					if($status){
						$this->session->set_flashdata('success', 'Record created succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not created');
					}
					redirect('admissions/schedules');	
				} elseif($this->input->post('form_action') == 'edit') {
					$status = $this->admissionmodel->updateSchedule();
					if($status){
						$this->session->set_flashdata('success', 'Record updated succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not updated');
					}
					redirect('admissions/schedules');	
				}
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	//delete schedules item
	function delschedule() {
		echo $this->admissionmodel->deleteSchedule($_POST['id']);
	}	
	//******************  SCHEDULE : END ************************

	//******************  NOTICE : START ************************	
	//list all notice
	function notices() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				//$data['notices'] = $this->admissionmodel->getAllNotices();
				$data['notices'] = array();
				$data['notice_ctgry_options'] = $this->staticconfigmodel->getNoticeCtgrOption();
				$data['page_title'] = "Configure Notices";
				$this->load->view('header', $data);
				$this->load->view('admissions/notices', $data);
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	// load list of notices in AJAX 
	function loadnotices() {
		if(isset($_REQUEST['notice_ctgr'])){
			echo json_encode($this->admissionmodel->getAllNotices($_REQUEST['notice_ctgr']));
		}else{
			echo json_encode($this->admissionmodel->getAllNotices());	
		}
	}	
	
	//add notice item
	function createnotice() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				if($this->input->post('form_action') == 'add') {
					$status = $this->admissionmodel->createNotice();
					if($status){
						$this->session->set_flashdata('success', 'Record created succesfully');	
						
						if (isset($_FILES['userfile'])){
							$config['upload_path'] = '././upload/notices/';
							$config['allowed_types'] = '*';
							
							$this->load->library('upload', $config);
							if ( ! $this->upload->do_upload()){
								$this->session->set_flashdata('success', 'Notice created but file not uploaded because '.$this->upload->display_errors());	
							}
						}

					}else{
						$this->session->set_flashdata('failure', 'Record not created');
					}
					redirect('admissions/notices');	
				} elseif($this->input->post('form_action') == 'edit') {
					$status = $this->admissionmodel->updateNotice();
					if($status){
						$this->session->set_flashdata('success', 'Record updated succesfully');	
						
						if (isset($_FILES['userfile'])){
							$config['upload_path'] = '././upload/notices/';
							$config['allowed_types'] = '*';
							
							$this->load->library('upload', $config);
							if ( ! $this->upload->do_upload()){
								$this->session->set_flashdata('success', 'Notice created but file not uploaded because '.$this->upload->display_errors());	
							}							
						}

					}else{
						$this->session->set_flashdata('failure', 'Record not updated');
					}
					redirect('admissions/notices');	
				}
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	//delete notice item
	function delnotice() {
		echo $this->admissionmodel->deleteNotice($_POST['id']);
	}	
	//******************  NOTICE : END ************************

	
	//***************  INSTRUCTION : START ********************
	//general instruction for students
	function instructions(){
		//$this->output->enable_profiler(TRUE);
		$data['general_notices'] = $this->admissionmodel->getNoticeByCategory('General');
		$data['page_title'] = "General Instructions to the user";
		$this->load->view('web_header', $data);
		$this->load->view('admissions/instructions', $data);
	}
	//***************  INSTRUCTION: END ***********************
	
	function getApplStartDateCriteria(){
		$flag = true;
		$todaysDate = new DateTime();
		$appl_start_date = $this->admissionmodel->getScheduleDate('ASD');
		//print_r($todaysDate); print_r($appl_start_date); exit();
		if($appl_start_date != "" && $todaysDate <= $appl_start_date){
			$flag = false;
		}
		return $flag;
	}
	
	function getApplEndDateCriteria(){
		$flag = true;
		$todaysDate = new DateTime();
		$appl_end_date = $this->admissionmodel->getScheduleDate('AED');
		if($appl_end_date != "" && $todaysDate >= $appl_end_date){
			$flag = false;
		}
		return $flag; 
	}
	
	function generalValidation($data){
		$flag = true;
		$msg = "";
		if($data['pg_appl_grad_pct'] == '' ||  $data['pg_appl_grad_org'] =='EMPTY' || $data['pg_appl_grad_org'] == '' || 
		   $data['pg_appl_grad_major_subj'] =='EMPTY' || $data['pg_appl_grad_major_subj'] == '' || $data['pg_appl_subj'] == '' || $data['pg_appl_subj'] =='EMPTY'){
			$msg .= "<li>Some wrong in your application. Please use different browser.</li>";
			$flag = false;
		}
		return $flag;
	}
	
	function formOneValidation($data){
		$msg = "";

		if(!$this->getApplStartDateCriteria()){
			$msg .= "<li>Online application yet to be started.</li>";
		}
		if(!$this->getApplEndDateCriteria()){
			$msg .= "<li>Online application has closed.</li>";
		}
		
		if(trim($data['pg_appl_grad_pct']) < getMarksCriteria($data)){
			$msg .= "<li>Does not have sufficient graduation marks to apply in the courses </li>";
		}
		if(!$this->configmodel->getSubjectCriteria($data)){
			$msg .= "<li>Under graduate subject combination  did not offer for courses.</li>";
		}
		
		if(!$this->generalValidation($data)){
			$msg .= "<li>Some wrong in your application. Please use different browser.</li>";
		}
		
		if(!is_numeric($data['pg_appl_grad_pct'])){
			$msg .= "<li>Inserted marks is not proper format.</li>";
		}else{
			if($data['pg_appl_grad_pct'] > 100){
				$msg .= "<li>Some of the inserted marks is greater than 100 %.</li>";
			}
		}
		return $msg;
	}
	
	function initFormOne($data){
		$data['application_notices'] 		= $this->admissionmodel->getNoticeByCategory('Application');
		$data['subject_options'] 			= $this->configmodel->getPgSubjectOptions();
		$data['university_options'] 		= $this->configmodel->getAllOrganizationsOptionByCriteria('3');
		$data['university_ctgry_options'] 	= $this->staticconfigmodel->getUniversityCtgrOption();
		$data['gender_options'] 			= $this->staticconfigmodel->getGenderOption(); 
		$data['reservation_options'] 		= $this->configmodel->getReservationOptions();
		return $data;
	}

	function resetFormOne($data){
		$data['_pg_appl_ctgr'] 				= "EMPTY";
		$data['_pg_appl_reservation'] 		= "GEN";
		$data['_pg_appl_name'] 				= "";
		$data['_pg_appl_gender'] 			= "EMPTY";
		$data['_pg_appl_subj'] 				= "EMPTY";
		$data['_pg_appl_grad_org'] 			= "EMPTY";
		$data['_pg_appl_grad_major_subj'] 	= "EMPTY";
		$data['_pg_appl_grad_minor_subj'] 	= "EMPTY";
		$data['_pg_appl_grad_pct'] 			= "";
		$data['_pg_appl_grad_pyear'] 		= "";
		
		return $data;
	}
	
	function setFormOneFromSession($data){
		$tempData = $this->session->userdata('StepOneAppl');
		
		$data['_pg_appl_ctgr'] 				= $tempData['pg_appl_ctgr'];
		$data['_pg_appl_reservation'] 		= $tempData['pg_appl_reservation'];
		$data['_pg_appl_name'] 				= $tempData['pg_appl_name'];
		$data['_pg_appl_gender'] 			= $tempData['pg_appl_gender'];
		$data['_pg_appl_subj'] 				= $tempData['pg_appl_subj'];
		$data['_pg_appl_grad_org'] 			= $tempData['pg_appl_grad_org'];
		$data['_pg_appl_grad_major_subj'] 	= $tempData['pg_appl_grad_major_subj'];
		$data['_pg_appl_grad_minor_subj'] 	= $tempData['pg_appl_grad_minor_subj'];
		$data['_pg_appl_grad_pct'] 			= $tempData['pg_appl_grad_pct'];
		$data['_pg_appl_grad_pyear'] 		= $tempData['pg_appl_grad_pyear'];
		
		return $data;
	}
	
	function setFormOneFromRequest($data){
		$appl_data['pg_appl_ctgr'] 				= $_REQUEST['pg_appl_ctgr'];
		$appl_data['pg_appl_reservation'] 		= $_REQUEST['pg_appl_reservation'];
		$appl_data['pg_appl_name'] 				= $_REQUEST['pg_appl_name'];
		$appl_data['pg_appl_gender'] 			= $_REQUEST['pg_appl_gender'];
		$appl_data['pg_appl_subj'] 				= $_REQUEST['pg_appl_subj'];
		$appl_data['pg_appl_grad_org'] 			= $_REQUEST['pg_appl_grad_org'];
		$appl_data['pg_appl_grad_major_subj'] 	= $_REQUEST['pg_appl_grad_major_subj'];
		$appl_data['pg_appl_grad_minor_subj'] 	= $_REQUEST['pg_appl_grad_minor_subj'];
		$appl_data['pg_appl_grad_pct'] 			= $_REQUEST['pg_appl_grad_pct'];
		$appl_data['pg_appl_grad_pyear'] 		= $_REQUEST['pg_appl_grad_pyear'];
		
		return $appl_data;
	}
	
	function pgadmstepone($redirection=null) {
		//$this->output->enable_profiler(TRUE);
		$data = array();
		
		$data = $this->initFormOne($data);
		
		if($redirection == 'failed'){
			//set form with dataset
			$data = $this->setFormOneFromSession($data);
		}else{
			//reset form with dataset
			$data = $this->resetFormOne($data);
		}		
		
		$data['page_title'] = "Admission Form for MA/MSc/MCom Courses";
		$this->load->view('web_header', $data);
		$this->load->view('admissions/pgadmstepone', $data);
	}

	function submitpgstepone(){
		//$this->output->enable_profiler(TRUE);
		$errorMessage = "";
		$isValidationFailed = false;
		
		$appl_data = array();
		$appl_data = $this->setFormOneFromRequest($appl_data);
		$this->session->set_userdata('StepOneAppl', $appl_data);
		
		$errorMessage .= $this->formOneValidation($appl_data);
		
		if($errorMessage != ""){
			$data = $this->initFormOne($data);
			$this->session->set_flashdata('failure', $errorMessage);	
			redirect('admissions/pgadmstepone/failed');
		}else{
			redirect('admissions/pgadmsteptwo/'.sha1(time()));
		}
	}

	
	//initialize lists and parameter
	function initFormTwo($data){
		$tempData = $this->session->userdata('StepOneAppl');
		
		$data['council_options'] 	= $this->configmodel->getAllOrganizationsOptionByCriteria('2'); 
		$data['board_options'] 		= $this->configmodel->getAllOrganizationsOptionByCriteria('1');
		$data['state_options'] 		= $this->configmodel->getStateOptionWithCode();
		$data['center_options'] 	= $this->configmodel->getCollegesByCategoryPgSubject($tempData['pg_appl_gender'], $tempData['pg_appl_subj']);
		
		$data['appl_subj'] 			= $this->configmodel->getPgSubjectNameByCode($tempData['pg_appl_subj']);
		$data['appl_name'] 			= $tempData['pg_appl_name'];;
		$data['appl_ctgry'] 		= $tempData['pg_appl_ctgr'];; 
		
		
		
		return $data;
	}
	
	function resetFormTwo($data){
		$data['_center_option']		 = "EMPTY";
		$data['_pg_appl_dob']		 = "";
		$data['_pg_appl_pwd'] 		 = "0";
		$data['_pg_appl_sports'] 	 = "0";
		$data['_pg_appl_gurd_name']  = "";
		$data['_pg_appl_bu_reg_no']  = "";
		$data['_pg_appl_comm_address1'] = "";
		$data['_pg_appl_comm_address2'] = "";
		$data['_pg_appl_comm_city'] = "";
		$data['_pg_appl_comm_district'] = "";
		$data['_pg_appl_comm_state'] = 'EMPTY';
		$data['_pg_appl_comm_pin'] = "";
		$data['_pg_appl_mobile'] = "";
		$data['_pg_appl_email'] = "";
		$data['_pg_appl_mp_subj'] 	= "";
		$data['_pg_appl_hs_subj'] 	= "";
		$data['_pg_appl_mp_pct'] = "";
		$data['_pg_appl_hs_pct'] = "";
		$data['_pg_appl_mp_org'] = "EMPTY";
		$data['_pg_appl_hs_org'] = "EMPTY";
		$data['_pg_appl_mp_pyear'] = "";
		$data['_pg_appl_hs_pyear'] = "";
		$data['pg_appl_password'] = "";
		$data['pg_appl_password_confirm'] = "";
		
		return $data;
	}
	
	function setFormTwoFromSession($data){
		$tempTwoData = $this->session->userdata('StepTwoAppl');
		
		$data['_pg_appl_dob']= $tempTwoData['_pg_appl_dob'];
		$data['_center_option']		 = $tempTwoData['_center_option'];
		$data['_pg_appl_pwd'] 		= $tempTwoData['_pg_appl_pwd'];;
		$data['_pg_appl_sports'] 	= $tempTwoData['_pg_appl_sports'];;
		$data['_pg_appl_bu_reg_no']  = $tempTwoData['_pg_appl_bu_reg_no'];
		$data['_pg_appl_gurd_name']  = $tempTwoData['_pg_appl_gurd_name'];
		$data['_pg_appl_comm_address1'] = $tempTwoData['_pg_appl_comm_address1'];
		$data['_pg_appl_comm_address2'] = $tempTwoData['_pg_appl_comm_address2'];
		$data['_pg_appl_comm_city'] = $tempTwoData['_pg_appl_comm_city'];
		$data['_pg_appl_comm_district'] = $tempTwoData['_pg_appl_comm_district'];
		$data['_pg_appl_comm_state'] = $tempTwoData['_pg_appl_comm_state'];
		$data['_pg_appl_comm_pin'] = $tempTwoData['_pg_appl_comm_pin'];
		$data['_pg_appl_mobile'] = $tempTwoData['_pg_appl_mobile'];
		$data['_pg_appl_email'] = $tempTwoData['_pg_appl_email'];
		$data['_pg_appl_mp_subj'] 	= $tempTwoData['_pg_appl_mp_subj'];
		$data['_pg_appl_hs_subj'] 	= $tempTwoData['_pg_appl_hs_subj'];
		$data['_pg_appl_mp_pct'] = $tempTwoData['_pg_appl_mp_pct'];
		$data['_pg_appl_hs_pct'] = $tempTwoData['_pg_appl_hs_pct'];
		$data['_pg_appl_mp_org'] = $tempTwoData['_pg_appl_mp_org'];
		$data['_pg_appl_hs_org'] = $tempTwoData['_pg_appl_hs_org'];
		$data['_pg_appl_mp_pyear'] = $tempTwoData['_pg_appl_mp_pyear'];
		$data['_pg_appl_hs_pyear'] = $tempTwoData['_pg_appl_hs_pyear'];
		
	$tempData = $this->session->userdata('StepOneAppl');
		$data['appl_name'] 			= $tempData['pg_appl_name'];;
		$data['appl_ctgry'] 		= $tempData['pg_appl_ctgr'];; 
		
		return $data;
	}
	
	function setFormTwoFromRequest($sessTwoData){
		
		    $sessTwoData['_pg_appl_dob']= $_REQUEST['pg_appl_dob'];
			$sessTwoData['_center_option']= $_REQUEST['center_option'];
			$sessTwoData['_pg_appl_pwd'] 		= $_REQUEST['pg_appl_pwd'];
			$sessTwoData['_pg_appl_sports'] 	= $_REQUEST['pg_appl_sports'];
			$sessTwoData['_pg_appl_gurd_name']  = $_REQUEST['pg_appl_gurd_name'];
			$sessTwoData['_pg_appl_bu_reg_no']  = $_REQUEST['pg_appl_bu_reg_no'];
			$sessTwoData['_pg_appl_comm_address1'] = $_REQUEST['pg_appl_comm_address1'];
			$sessTwoData['_pg_appl_comm_address2'] = $_REQUEST['pg_appl_comm_address2'];
			$sessTwoData['_pg_appl_comm_city'] = $_REQUEST['pg_appl_comm_city'];
			$sessTwoData['_pg_appl_comm_district'] = $_REQUEST['pg_appl_comm_district'];
			$sessTwoData['_pg_appl_comm_state'] = $_REQUEST['pg_appl_comm_state'];
			$sessTwoData['_pg_appl_comm_pin'] = $_REQUEST['pg_appl_comm_pin'];
			$sessTwoData['_pg_appl_mobile'] = $_REQUEST['pg_appl_mobile'];
			$sessTwoData['_pg_appl_email'] = $_REQUEST['pg_appl_email'];
			$sessTwoData['_pg_appl_mp_subj'] 	= $_REQUEST['pg_appl_mp_subj'];
			$sessTwoData['_pg_appl_hs_subj'] 	= $_REQUEST['pg_appl_hs_subj'];
			$sessTwoData['_pg_appl_mp_pct'] = $_REQUEST['pg_appl_mp_pct'];
			$sessTwoData['_pg_appl_hs_pct'] = $_REQUEST['pg_appl_hs_pct'];
			$sessTwoData['_pg_appl_mp_pyear'] = $_REQUEST['pg_appl_mp_pyear'];
			$sessTwoData['_pg_appl_hs_pyear'] = $_REQUEST['pg_appl_hs_pyear'];
			$sessTwoData['_pg_appl_mp_org'] = $_REQUEST['pg_appl_mp_org'];
			$sessTwoData['_pg_appl_hs_org'] = $_REQUEST['pg_appl_hs_org'];
		
		return $sessTwoData;
	}
	
	//second part of the application form along with 
	function pgadmsteptwo($redirct=null) {
		//$this->output->enable_profiler(TRUE);
		
		$data = array();
		$data = $this->initFormTwo($data);
		
		if($redirct =='failed'){
			//set form with dataset
			$data = $this->setFormTwoFromSession($data);
		}else{
			$data = $this->resetFormTwo($data);
		}
		
		$data['page_title'] = "Admission Form for MA/MSc/MCom Courses";
		$this->load->view('web_header', $data);
		$this->load->view('admissions/pgadmsteptwo', $data);
	}

	function submitpgsteptwo(){
		//$this->output->enable_profiler(TRUE);
		$sessOneData = $this->session->userdata('StepOneAppl');
		
		$sessTwoData = array();
		//set all data in session
		$sessTwoData = $this->setFormTwoFromRequest($sessTwoData);
			
		$this->session->set_userdata('StepTwoAppl', $sessTwoData);
		
		$isValidationFailed = false;
		$errorMessage = "";
		if($sessOneData == null){
			$isValidationFailed = true;
			$errorMessage .= "<li>There are some problem in your application.</li>";
		}
		if(!is_numeric($_REQUEST['pg_appl_hs_pct']) && !is_numeric($_REQUEST['pg_appl_hs_pct'])){
			$isValidationFailed = true;
			$errorMessage .= "<li>Please entered the correct marks of secondary and higher secondary.</li>";
		}
		
		if($isValidationFailed){
			$this->session->set_flashdata('failure', $errorMessage);	
			redirect('admissions/pgadmsteptwo/failed');
		}else{
			$results = $this->admissionmodel->saveApplicationData();
			
			if($results['status'] == 1){
				$this->session->set_userdata('StepOneAppl', null);
				$this->session->set_userdata('StepTwoAppl', null);
				$this->session->set_flashdata('success', 'Record saved succesfully');
				
				//TRIGGERED SMS
				sendApplicationCode($results);
				
				//TRIGGERED MAIL HERE
				$this->sendApplicationCodeEmail($results);
				
				$this->session->set_userdata('student', $results);				
				redirect('students/studentlogin/' . $results['appl_code']);
			}else{
				$this->session->set_flashdata('failure', 'Record not saved succesfully');	
				redirect('admissions/pgadmsteptwo/failed');
			}
		}
		
	}
	
	//on selection of post graduation subject, respective graduation subject will  populate  
	function getUGMajorSubjects(){
		$result = $this->configmodel->getUGSubjectByPGSubject($_REQUEST['pg_appl_subj']);
		echo json_encode($result);
	}
	
	//on selection of post graduation subject, respective graduation subject will  populate  
	function getUGMinorSubjects(){
		$result = $this->configmodel->getUGSubjectByUGSubject($_REQUEST['pg_appl_grad_major_subj']);
		echo json_encode($result);
	}

	//display pg part one admission form in edit mode
	function pgadmedit($appl_code = null) {
		//$this->output->enable_profiler(TRUE);
		
		$data['subject_options'] 			= $this->configmodel->getPgSubjectOptions();
		$data['university_ctgry_options'] 	= $this->staticconfigmodel->getUniversityCtgrOption();
		$data['university_options'] 		= $this->configmodel->getAllOrganizationsOptionByCriteria('3');
		$data['council_options'] 	      = $this->configmodel->getAllOrganizationsOptionByCriteria('2'); 
		$data['board_options'] 		      = $this->configmodel->getAllOrganizationsOptionByCriteria('1');
		$data['gender_options'] 			= $this->staticconfigmodel->getGenderOption(); 
		$data['reservation_options'] 		= $this->configmodel->getReservationOptions();
		$data['state_options'] 		      = $this->configmodel->getStateOptionWithCode();
		
		if($appl_code == null && $this->session->userdata('user_role') == 'student') {
			$appl_code = $this->session->userdata('appl_code');
		}
		$data['result'] = $this->admissionmodel->getApplicationData($appl_code);
		
		//echo $appl_code; print_r($data['result']); exit();
		
		$data['center_options'] 		  = $this->configmodel->getCollegesByCategoryPgSubject($data['result']['pg_appl_gender'], $data['result']['pg_appl_subj']);
		$data['ug_subject_major_options'] = $this->configmodel->getUGSubjectByPGSubjectOption($data['result']['pg_appl_subj']);
		$data['ug_subject_minor_options'] = $this->configmodel->getUGSubjectByUGSubjectOption($data['result']['pg_appl_grad_major_subj']);
		
		$data['page_title'] = "Admission Form for MA/MSc/MCom Courses";
		$this->load->view('web_header', $data);
		if(isset($this->session->userdata['user'])) {
			if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center") { 
				$this->load->view('admissions/editpgadm_center', $data);
			}else{ 
				$this->load->view('admissions/viewpgadm', $data);
			}
		} elseif(isset($this->session->userdata['student'])) { 
			$this->load->view('admissions/editpgadm_student', $data);
		} else {
			redirect('users/unauthorised');
		}		
	}	

	function pgadmupdate(){
		$data['subject_options'] 			= $this->configmodel->getPgSubjectOptions();
		$data['university_ctgry_options'] 	= $this->staticconfigmodel->getUniversityCtgrOption();
		$data['university_options'] 		= $this->configmodel->getAllOrganizationsOptionByCriteria('3');
		$data['council_options'] 	      = $this->configmodel->getAllOrganizationsOptionByCriteria('2'); 
		$data['board_options'] 		      = $this->configmodel->getAllOrganizationsOptionByCriteria('1');
		$data['gender_options'] 			= $this->staticconfigmodel->getGenderOption(); 
		$data['reservation_options'] 		= $this->configmodel->getReservationOptions();
		$data['state_options'] 		      = $this->configmodel->getStateOptionWithCode();
		
		
		$data['center_options'] 		  = $this->configmodel->getCollegesByCategoryPgSubject($this->input->post('pg_appl_gender'), $this->input->post('pg_appl_subj'));
		$data['ug_subject_major_options'] = $this->configmodel->getUGSubjectByPGSubjectOption($this->input->post('pg_appl_subj'));
		$data['ug_subject_minor_options'] = $this->configmodel->getUGSubjectByUGSubjectOption($this->input->post('pg_appl_grad_major_subj'));
		
		
		$isValidationFailed = false;
		$errorMessage = "";
		if(!is_numeric($this->input->post('pg_appl_hs_pct')) && !is_numeric($this->input->post('pg_appl_hs_pct') && !is_numeric($this->input->post('pg_appl_grad_pct')))){
			$isValidationFailed = true;
			$errorMessage .= "<li>Please entered the correct marks of secondary and higher secondary.</li>";
		}
		if($this->input->post('pg_appl_reservation') =='EMPTY' || $this->input->post('pg_appl_reservation') == 'undefined' || $this->input->post('pg_appl_reservation') =='' ){
			$isValidationFailed = true;
			$errorMessage .= "<li>Please use different browser.</li>";
		}
		
		$appl_data = array();
		$appl_data = $this->setFormOneFromRequest($appl_data);
		$this->session->set_userdata('StepOneAppl', $appl_data);
		
		$errorMessage .= $this->formOneValidation($appl_data);
		if($errorMessage == ""){
			$status = $this->admissionmodel->updateApplicationData();
			if($status){
				$this->session->set_flashdata('success', 'Record Updated succesfully');
			}else{
				$this->session->set_flashdata('failure', 'Record not Updated succesfully');	
			}
		}else{
			$this->session->set_flashdata('failure', $errorMessage);
		}
		
		
		//$data['result'] = $this->admissionmodel->getApplicationData($this->input->post('pg_appl_code'));
		//$data['page_title'] = "Admission Form for MA/MSc/MCom Courses";
		//$this->load->view('web_header', $data);
		
		if(isset($this->session->userdata['user']) || isset($this->session->userdata['student'])) {
			redirect('admissions/pgadmedit/'.$this->input->post('pg_appl_code'));
		} else {
			redirect('users/unauthorised');
		}	
		
	}
	
	//*******************  ADMISSSION FORM OPERATION : END ************************
	
	//*******************  DOWNLOAD  : START ************************
	//download application form
	function downloadpgform($appl_code=null) {
		if($appl_code == null && $this->session->userdata('user_role') == 'student') {
			$appl_code = $this->session->userdata('appl_code');
		}
		$form = $this->admissionmodel->getApplicationData($appl_code);
		
		$this->load->library('pdf');
		if($form != NULL) {
			//print_r($form);
			$this->pdf->convert_html_applform_to_pdf($form, "Application-".$appl_code.".pdf");	
		}
	}
	
	//download rank card
	function downloadrankcard($appl_code=null) {
		if($appl_code == null && $this->session->userdata('user_role') == 'student') {
			$appl_code = $this->session->userdata('appl_code');
		}
		$enrolment = $this->admissionmodel->getRankCardInfo($appl_code);
		$this->load->library('pdf');
		if($enrolment != NULL) {
			//print_r($enrolment); exit();
			$this->pdf->convert_html_rank_to_pdf($enrolment, "Rankcard-".$appl_code.".pdf");	
		}
	}

	//download admit card
	function downloadadmitcard($appl_code=null) {
		if($appl_code == null && $this->session->userdata('user_role') == 'student') {
			$appl_code = $this->session->userdata('appl_code');
		}
		$enrolment = $this->admissionmodel->getAdmitCardInfo($appl_code);
		$this->load->library('pdf');
		if($enrolment != NULL) {
			//print_r($enrolment);
			$this->pdf->convert_html_admit_to_pdf($enrolment, "Admitcard-".$appl_code);	
		}
	}	
	
	//download printed challan
	function downloadchallan($appl_code=null){
		if($appl_code == null && $this->session->userdata('user_role') == 'student') {
			$appl_code = $this->session->userdata('appl_code');
		}
		$form = $this->admissionmodel->getApplicationData($appl_code);
		
		$this->load->library('pdf');
		if($form != NULL) {
			//print_r($form);
			$this->pdf->convert_html_appl_fees_challan_to_pdf($form, "Application-".$appl_code);	
		}
	}
	//*******************  DOWNLOAD  : END ************************
	
    //*******************  VARIOUS SEARCH OPTIONS  : START ************************

	/**
	 * 1. Search for normal application
	 * 2. Search for rejecting the application at any point of time
	 * 3. Search application for converting extra reserve application to general application
	 */
	 function searchapplication($redirect=null){
	 	//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			$auth_flag = true;
			$redirect_page = "";
			
			$data['subject_options'] 			= $this->configmodel->getPgSubjectOptions();
			$data['reservation_options'] 		= $this->configmodel->getReservationOptions();
			$data['application_status_options'] = $this->staticconfigmodel->getApplicationStatusOptions();
			$data['reservation_extra_options']  = $this->staticconfigmodel->getExtraResvOptions();
			$data['spcl_status_options'] 		= $this->staticconfigmodel->getSpclStatusOptions();
			
			if($this->input->post('form_action') == 'search'){
				$data['info'] = $this->admissionmodel->searchApplicationsByCriteria();	
			}else{
				$data['info'] = array();
			}
			
			switch ($redirect) {
				case 'SEARCH':
					$data['page_title'] = "Search Application";
					$redirect_page = 'admissions/search_application';
					break;
				
				case 'CANCEL':
					$data['page_title'] = "Search Application for Cancelation";
					if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center"){
						$redirect_page = 'admissions/search_application_cancelation';
					}else{
						$auth_flag = false;
					}
					break;
				
				case 'CONVERT':
					$data['page_title'] = "Search Application for Convertion";
					if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center"){
						$redirect_page = 'admissions/search_application_convertion';
					}else{
						$auth_flag = false;
					}
					break;
			
			case 'PAYMENT':
					$data['page_title'] = "Search Application for Convertion";
					if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center" || $this->session->userdata['user']['user_role'] == "Verifier"){
						$redirect_page = 'admissions/search_application_payment';
					}else{
						$auth_flag = false;
					}
					break;
			case 'DUPLICATE':
					$data['page_title'] = "Search Application for Convertion";
					if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center" || $this->session->userdata['user']['user_role'] == "Staff"){
						$redirect_page = 'admissions/search_application_duplicate';
					}else{
						$auth_flag = false;
					}
					break;
			}	
			if($auth_flag){
				$this->load->view('header', $data);
				$this->load->view($redirect_page, $data);
			}else{
				redirect('users/unauthorised');				
			}
		}
	 }
	 
	 function updatestudentstaus(){
	 	$status = $this->admissionmodel->updateStudentStaus();
		echo $status;	
	 }
	 
	 function updatepaymentstaus(){
	 	$status = $this->admissionmodel->updatePaymentStaus();
		echo $status;	
	 }
	 
	 function updatestudentreservation(){
	 	$data = $this->admissionmodel->updateStudentReservation();
		sendApplicationCode($data);
		echo $data['status'];	
	 }
	 
	 
	//************* EXAMINATION : START ***********
	function examinations() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center" ){
				$data['examinations'] 		= $this->examinationmodel->getAllExamSchedules();
				//$data['examinations'] 		= array();
				$data['examination_options']= $this->configmodel->getExaminationOptions();
				$data['buildings_options'] 	= $this->configmodel->getBuildingOptions();
				$data['pgsubject_options'] 	= $this->configmodel->getPostGraduateSubjectOption();
				$data['halls_options'] 		= array();
				
				$data['page_title'] 	= "Configure Examination Schedule";
				$this->load->view('header', $data);
				$this->load->view('admissions/examination_schedule', $data);
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	function loadhalls($building_id) {
		echo json_encode($this->configmodel->getAllHalls($building_id));
	}
	
	function loadexamschedules() {
		echo json_encode($this->examinationmodel->getAllExamSchedules());
	}
	
	function loadsearchexamschedules() {
		echo json_encode($this->examinationmodel->getSearchExamSchedules($_REQUEST['exam_id'], $_REQUEST['exam_subject'], $_REQUEST['hall_id']));
	}	
	
	function gethallinfo(){
		echo $this->examinationmodel->unreservedHallSeat();
	}
	
	function getsubjectinfo(){
		echo $this->examinationmodel->unAllocatedSubjectSeat();
	}
	
	function createexamschedules() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center"){
				if($this->input->post('form_action') == 'add') {
					$status = $this->examinationmodel->createExamSchedule();
					if($status){
						$this->session->set_flashdata('success', 'Record created succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not created');
					}
					redirect('admissions/examinations');	
				} elseif($this->input->post('form_action') == 'edit') {
					$status = $this->examinationmodel->updateExamSchedule();
					if($status){
						$this->session->set_flashdata('success', 'Record updated succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not updated');
					}
					redirect('admissions/examinations');	
				}
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	function delexamschedules() {
		echo $this->examinationmodel->deleteExamSchedule($_POST['id']);
	}	
	
	function gethalls(){
		echo json_encode($this->configmodel->getAllHalls($_POST['building_id']));
	}
	
	function gethallsforexam(){
		echo json_encode($this->configmodel->getAllHallsForExam($_POST['exam_id']));
	}
	function getsubjectsforexam(){
		echo json_encode($this->configmodel->getAllSubjectsForExam($_POST['exam_id']));
	}
	
	//************* EXAMINATION : END ***********
	
	
	function sendApplicationCodeEmail($data){
		$config = array();
        $config['mailtype'] = 'html';
        $config['charset']  = 'utf-8';
        $config['newline']  = "\r\n";
        $config['wordwrap'] = TRUE;
		
	    $this->load->library('email'); // load email library
	    $this->email->initialize($config);
	    $this->email->from('buruniv@gmail.com', 'The University of Burdwan');
	    $this->email->to($data['appl_email']);
	    $this->email->subject('Application Submitted');
		$message=$this->load->view('emails/applicationcreate',$data,TRUE);
		$this->email->message($message);
		$this->email->send();
	}
}
