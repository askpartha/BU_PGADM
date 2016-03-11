<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notifications extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper( array('url', 'form', 'text') );
		$this->load->library('authenticate', 'session');
		$this->load->model('admissionmodel');
		$this->load->model('configmodel');
		$this->load->model('reportmodel');
		$this->load->model('resultmodel');
	}
	
	//usernotifications
	function usernotifications() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" || 	$this->session->userdata['user']['user_role'] == "Center") {
				$data['page_title'] = "User Notifications";
				$this->load->view('header', $data);
				$this->load->view('notifications/usernotifications', $data);
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	//sendusernotifications
	function sendusernotifications() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" || 	$this->session->userdata['user']['user_role'] == "Center") {
				$phonenos = $this->input->post('notification_number');
				$message  = $this->input->post('notification_message');
				$info = array('phones'=>$phonenos, 'messages'=>$message);
				$status = sendGenericMessage($info);
				if($status){
						$this->session->set_flashdata('success', 'Notification send succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Some error in sending notification');
				}
				$data['page_title'] = "User Notifications";
				$this->load->view('header', $data);
				$this->load->view('notifications/usernotifications', $data);
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	
	//groupnotifications
	function groupnotifications() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" || 	$this->session->userdata['user']['user_role'] == "Center") {
				$data['page_title'] = "Group Notifications";
				$data['subject_options'] = $this->configmodel->getPgSubjectOptions();
				$data['status_options'] = $this->staticconfigmodel->getApplicationStatusOptions();
				$data['extra_resv_options'] = $this->staticconfigmodel->getExtraResvOptions();
				$this->load->view('header', $data);
				$this->load->view('notifications/groupnotifications', $data);
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	//sendgroupnotifications
	function sendgroupnotifications() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" || 	$this->session->userdata['user']['user_role'] == "Center") {
				
				$data['page_title'] = "Group Notifications";
				$data['subject_options'] = $this->configmodel->getPgSubjectOptions();
				$data['status_options'] = $this->staticconfigmodel->getApplicationStatusOptions();
				$data['extra_resv_options'] = $this->staticconfigmodel->getExtraResvOptions();
				
				$phonenos = $this->reportmodel->getContactNosByCategory();
				$message  = $this->input->post('notification_message');
				$info = array('phones'=>$phonenos, 'messages'=>$message);
				$status = sendGenericMessage($info);
				if($status){
						$this->session->set_flashdata('success', 'Notification send succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Some error in sending notification');
				}
				$this->load->view('header', $data);
				$this->load->view('notifications/groupnotifications', $data);
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	
	//admissionnotifications
	function admissionnotifications() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" || 	$this->session->userdata['user']['user_role'] == "Center") {
				$data['page_title'] = "Admission Notifications";
				$data['subject_options'] = $this->configmodel->getPgSubjectOptions();
				$this->load->view('header', $data);
				$this->load->view('notifications/admissionnotifications', $data);
			} else {
				redirect('users/unauthorised');
			}
		}	
	}

	//merit list option based on subject
	function getmeritlistoption(){
		echo json_encode($this->reportmodel->getMeritListOption($_REQUEST['subj_code']));
	}

	//sendadmissionnotifications
	function sendadmissionnotifications() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" || 	$this->session->userdata['user']['user_role'] == "Center") {
					
				$data['subject_options'] = $this->configmodel->getPgSubjectOptions();
				
				if($_REQUEST['flag_status'] == 'TRUE'){
					$phonenos = $this->resultmodel->getSelectedCandidateRankFromToMobileNo();
					$message  = $this->input->post('notification_message');
					$info = array('phones'=>$phonenos, 'messages'=>$message);
					$status = sendGenericMessage($info);
					if($status){
							$this->session->set_flashdata('success', 'Notification send succesfully');	
						}else{
							$this->session->set_flashdata('failure', 'Some error in sending notification');
					}
				}else
				if($_REQUEST['flag_status'] == 'FALSE'){
					$results = $this->resultmodel->downloadSelectedCandidateRankFromTo();
				    //$this->load->library('excel');
				    //$this->excel->download_merit_to_excel($results, 'RANK_LIST');
				}	
				$data['page_title'] = "Admission Notifications";
				$this->load->view('header', $data);
				$this->load->view('notifications/admissionnotifications', $data);
				
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
}