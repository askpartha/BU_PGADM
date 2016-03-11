<?php
class Admissionmodel extends CI_Model {

    function __construct() {
        parent::__construct();
		$this->load->database();
    }
	
	//get date format for the dropdown
	function getDateFormatOption() {
		$arr = array("d-m-y"=>date("d-m-y"), "d-m-Y"=>date("d-m-Y"), "d-M-Y"=>date("d-M-Y"), 
					 "d-F-Y"=>date("d-F-Y"), "l, j F Y"=>date("l, j F Y"),
					 "m-d-Y"=>date("m-d-Y"), "F d, Y"=>date("F d, Y"),
					 "M d, Y h:i A"=>date("M d, Y h:i A"));
		return $arr;
	}	
	
	//get records per page for the dropdown
	function getRecordsPerPageOption() {
		$arr = array("5"=>"5", "10"=>"10", "25"=>"25", "50"=>"50", "100"=>"100");
		return $arr;
	}
	
	
	
	
	
	
	
	//******************  NOTICE : START ************************
	//get all Notice
	function getAllNotices($status=null) {
		$c_tbl = 'cnf_notice';
		$this->db->select(array('notice_id', 'notice_ctgry', 'notice_title', 'notice_desc', 'notice_weight', 'notice_file', 'notice_is_active'));
		$this->db->from($c_tbl);
		if($status){
			$this->db->where('notice_is_active', 1);
		}
		if($status != ''){
			$this->db->where('notice_ctgry', $status);
		}
		
		$this->db->order_by('notice_ctgry', 'asc'); 
		$this->db->order_by('notice_weight', 'asc'); 
		$query = $this->db->get();
		$results = $query->result();
		
		$records = array();
		for($i=0; $i<count($results); $i++){
			$description = $results[$i]->notice_desc;
			
			$description = str_replace('"', '&quote;', $description);
			$description = str_replace('"', '&apos;', $description);
			
			$records[$i] = array(
							 'notice_id'     	=> $results[$i]->notice_id,
							 'notice_weight'     => $results[$i]->notice_weight,
							 'notice_ctgry'     => $results[$i]->notice_ctgry,
							 'notice_title'	    => $results[$i]->notice_title,
							 'notice_desc'		=> $description,
							 'notice_file'	    => $results[$i]->notice_file,
							 'notice_is_active'	=> $results[$i]->notice_is_active,
						 );
		}
		
		//print_r($records); exit();
		
		return $records;
	}
	
	//get notice by category
	function getNoticeByCategory($notice_ctgry) {
		$c_tbl = 'cnf_notice';
		$this->db->select(array('notice_id', 'notice_ctgry', 'notice_title', 'notice_weight',  'notice_file', 'notice_desc', 'notice_is_active'));
		$this->db->from($c_tbl);
		$this->db->where('notice_is_active', 1);
		$this->db->where('notice_ctgry', $notice_ctgry);
		$this->db->order_by('notice_weight', 'asc'); 
		$query = $this->db->get();
		$results = $query->result_array();
		return $results;
	}
	
	//create Notice
	function createNotice() {
		$c_tbl = 'cnf_notice';
		$created_on = gmdate('Y-m-d');
		$created_by = $this->session->userdata['user']['user_name']; //user id from session

		$uploadfilename = "";
		if (isset($_FILES['userfile'])){
			$uploadfilename = $_FILES['userfile']['name'];
		}
		
		$data = array(
					  'notice_ctgry'		=>	$this->input->post('notice_ctgry'),
					  'notice_title'		=>	$this->input->post('notice_title'),
					  'notice_weight'		=>	$this->input->post('notice_weight'),
					  'notice_file'			=>	$uploadfilename,
				      'notice_desc'			=>	$this->input->post('notice_desc'),
				      'notice_is_active'	=>	($this->input->post('notice_is_active') == 'on') ? 1 : 0,
				      'created_on'			=>	$created_on,
				      'created_by'			=>	$created_by,
				      'modified_on'			=>	$created_on,
				      'modified_by'			=>	$created_by
				    );
		$status = $this->db->insert($c_tbl, $data);
		
		//update the transaction history
		$event = "Notice Created";
		$this->createTransHistory('', $event, $created_by, $created_on);
		
		
		return $status;		
	}
	
	//update Notice
	function updateNotice() {
		$c_tbl = 'cnf_notice';
		$modified_on = gmdate('Y-m-d');
		$modified_by = $this->session->userdata['user']['user_name']; //user id from session

		if (isset($_FILES['userfile'])){
			$data = array(
				      'notice_ctgry'		=>	$this->input->post('notice_ctgry'),
				      'notice_title'		=>	$this->input->post('notice_title'),
				      'notice_weight'		=>	$this->input->post('notice_weight'),
				      'notice_file'			=>	$_FILES['userfile']['name'],
				      'notice_desc'			=>	$this->input->post('notice_desc'),
				      'notice_is_active'	=>	($this->input->post('notice_is_active') == 'on') ? 1 : 0,
				      'modified_on'			=>	$modified_on,
				      'modified_by'			=>	$modified_by
				    );
		}else{
			$data = array(
				      'notice_ctgry'		=>	$this->input->post('notice_ctgry'),
				      'notice_title'		=>	$this->input->post('notice_title'),
				      'notice_weight'		=>	$this->input->post('notice_weight'),
				      'notice_desc'			=>	$this->input->post('notice_desc'),
				      'notice_is_active'	=>	($this->input->post('notice_is_active') == 'on') ? 1 : 0,
				      'modified_on'			=>	$modified_on,
				      'modified_by'			=>	$modified_by
				    );
		}
		
		$this->db->where('notice_id', $this->input->post('record_id'));					
		$status = $this->db->update($c_tbl, $data);
		
		//update the transaction history
		$event = "Notice Updated";
		$this->createTransHistory('ID'.$this->input->post('record_id'), $event, $modified_by, $modified_on);
		
		return $status;		
	}	
	
	//delete Notice
	function deleteNotice($id) {
		$c_tbl = 'cnf_notice';
		$this->db->delete($c_tbl, array('notice_id' => $id)); 
		return "DELETED";
	}		
	//******************  NOTICE : END ************************
	
	
	//******************  SCHEDULE : START ************************
	function getAllSchedules() {
		$c_tbl = 'cnf_schedules';
		
		$this->db->select(array('schedule_id', 'schedule_name', 'schedule_date', 'schedule_time', 'schedule_is_active'));
		$this->db->from($c_tbl);
		$this->db->order_by('schedule_date', 'asc'); 
		$query = $this->db->get();
		$r = $query->result();
		
		$results = array();	
		
		for($i=0; $i<count($r); $i++) {
			$results[$i] = array(
									'schedule_id' 			=>	$r[$i]->schedule_id,
									'schedule_name' 		=> 	$r[$i]->schedule_name,
									'schedule_date' 		=> 	getDateFormat($r[$i]->schedule_date, 'd-m-Y'),
									'schedule_time' 		=> 	$r[$i]->schedule_time,
									'schedule_is_active' 	=> 	$r[$i]->schedule_is_active
								);
		}
		
		return $results;
	}
	
	//get schedule date by schedule name
	function getScheduleDateByName($schedule_name) {
		$c_tbl = 'cnf_schedules';
		
		$this->db->select(array('schedule_id', 'schedule_date', 'schedule_time', 'schedule_is_active'));
		$this->db->from($c_tbl);
		$this->db->where('schedule_name', $schedule_name); 
		$this->db->where('schedule_is_active', 1); 
		$query = $this->db->get();
		$results = $query->result();
		$scheduledate = "";
		if(count($results) > 0){
			$scheduledate = getDateFormat($results[0]->schedule_date, 'd-m-Y');
		}
		return $scheduledate;
	}
	
	//create schedule
	function createSchedule() {
		$c_tbl = 'cnf_schedules';
		$created_on = gmdate('Y-m-d H:i:s');
		$created_by = $this->session->userdata['user']['user_id']; //user id from session

		$data = array(
				  'schedule_name'		=>	$this->input->post('schedule_name'),
			      'schedule_date'		=>	convertToMySqlDate($this->input->post('schedule_date')),
			      'schedule_time'		=>	$this->input->post('schedule_time'),
			      'schedule_is_active'	=>	($this->input->post('schedule_is_active') == 'on') ? 1 : 0,
			    );
				
		$status = $this->db->insert($c_tbl, $data);
		return $status;		
	}
	
	//update schedule
	function updateSchedule() {
		$c_tbl = 'cnf_schedules';
		$modified_on = gmdate('Y-m-d H:i:s');
		$modified_by = $this->session->userdata['user']['user_id']; //user id from session

		$status = false;
		//if(!$this->isSchedulePresent($this->input->post('schedule_name'))){
			$data = array(
					      'schedule_name'		=>	$this->input->post('schedule_name'),
					      'schedule_date'		=>	convertToMySqlDate($this->input->post('schedule_date')),
					      'schedule_time'		=>	$this->input->post('schedule_time'),
					      'schedule_is_active'	=>	($this->input->post('schedule_is_active') == 'on') ? 1 : 0
					    );
			$this->db->where('schedule_id', $this->input->post('record_id'));	
			$status = $this->db->update($c_tbl, $data);
		//}				
		return $status;		
	}	
	
	//delete schedule
	function deleteSchedule($id) {
		$c_tbl = 'cnf_schedules';
		$this->db->delete($c_tbl, array('schedule_id' => $id)); 
		//also association need to be deleted
		return "DELETED";
	}
	
	function getScheduleDate($schedule_name){
		$c_tbl = "cnf_schedules";
		
		$scheduleDateTime    = "";
		
		$this->db->select(array('schedule_id', 'schedule_date', 'schedule_time', 'schedule_is_active'));
		$this->db->from($c_tbl);
		$this->db->where('schedule_name', $schedule_name); 
		$this->db->where('schedule_is_active', 1); 
		$query = $this->db->get();
		$results = $query->result();
		if(count($results) > 0){
			$scheduledate = getDateFormat($results[0]->schedule_date, 'd-m-Y');
			$scheduletime = $results[0]->schedule_time;
			
			$scheduleDateTime = new DateTime($scheduledate . " " . $scheduletime);
		}
		return $scheduleDateTime;
	}

	//******************  SCHEDULE : END ************************
	
	

	//application related functions : Start
	
	//create application data
	function saveApplicationData($sess_id = null){
		
		$c_tbl = 'pg_appl_candidates';
		$f_tbl = 'pg_appl_fees';
		
		$created_on = gmdate('Y-m-d H:i:s');
		$timestamp = getDateFormat($created_on, 'ymdhis');
			
		$StepOneApplData = $this->session->userdata('StepOneAppl');
		
		$marks = array(
						'pg_appl_mp_pct'=> $this->input->post('pg_appl_mp_pct'), 
						'pg_appl_hs_pct'=> $this->input->post('pg_appl_hs_pct'), 
						'pg_appl_grad_pct'=> $StepOneApplData['pg_appl_grad_pct']
					);
		
		$data = array(
					  'pg_appl_ctgr'		=>	$StepOneApplData['pg_appl_ctgr'],
				      'pg_appl_reservation'	=>	$StepOneApplData['pg_appl_reservation'],
					  'pg_appl_name'		=>	$StepOneApplData['pg_appl_name'],
					  'pg_appl_gender'		=>	$StepOneApplData['pg_appl_gender'],
					  'pg_appl_subj'		=>	$StepOneApplData['pg_appl_subj'],
					  'pg_appl_grad_org'	=>	$StepOneApplData['pg_appl_grad_org'],
					  'pg_appl_grad_major_subj'	=>	$StepOneApplData['pg_appl_grad_major_subj'],
					  'pg_appl_grad_minor_subj'	=>	$StepOneApplData['pg_appl_grad_minor_subj'] == 'EMPTY' ? "" : $StepOneApplData['pg_appl_grad_minor_subj'] ,
					  'pg_appl_grad_pct'	=>	$StepOneApplData['pg_appl_grad_pct'],
					  'pg_appl_grad_pyear'	=>	$StepOneApplData['pg_appl_grad_pyear'],
				      
				      'pg_appl_dob'			=>	convertToMySqlDate($this->input->post('pg_appl_dob')),
				      'pg_appl_pwd'			=>	$this->input->post('pg_appl_pwd'),
				      'pg_appl_sports'		=>	$this->input->post('pg_appl_sports'),
				      'pg_appl_gurd_name'	=>	$this->input->post('pg_appl_gurd_name'),
				      'pg_appl_bu_reg_no'	=>	$this->input->post('pg_appl_bu_reg_no'),
				      'pg_appl_comm_address1'=>	$this->input->post('pg_appl_comm_address1'),
				      'pg_appl_comm_address2'=>	$this->input->post('pg_appl_comm_address2'),
				      'pg_appl_comm_city'	=>	$this->input->post('pg_appl_comm_city'),
				      'pg_appl_comm_district'=>	$this->input->post('pg_appl_comm_district'),
				      'pg_appl_comm_state'	=>	$this->input->post('pg_appl_comm_state'),
				      'pg_appl_comm_pin'	=>	$this->input->post('pg_appl_comm_pin'),
				      'pg_appl_mobile'		=>	$this->input->post('pg_appl_mobile'),
				      'pg_appl_email'		=>	$this->input->post('pg_appl_email'),
				      'pg_appl_mp_subj'		=>	$this->input->post('pg_appl_mp_subj'),
				      'pg_appl_hs_subj'		=>	$this->input->post('pg_appl_hs_subj'),
				      'pg_appl_mp_pct'		=>	$this->input->post('pg_appl_mp_pct'),
				      'pg_appl_hs_pct'		=>	$this->input->post('pg_appl_hs_pct'),
				      'pg_appl_mp_pyear'	=>	$this->input->post('pg_appl_mp_pyear'),
				      'pg_appl_hs_pyear'	=>	$this->input->post('pg_appl_hs_pyear'),
				      'pg_appl_mp_org'		=>	$this->input->post('pg_appl_mp_org'),
				      'pg_appl_hs_org'		=>	$this->input->post('pg_appl_hs_org'),
				      'pg_appl_password'	=>	$this->input->post('pg_appl_password'),
				      'pg_appl_merit_score'	=>	calculateScore($marks),
				      'pg_apl_center_option'=>	$this->input->post('center_option'),
				      'pg_appl_profile_pic'	=>	'',
				      'pg_appl_status'		=>	'1',
				      'pg_appl_created_on'	=>	$created_on
				    );
		
		$status = TRUE;
		$this->db->trans_begin();
		
		$this->db->insert($c_tbl, $data);
		if ($this->db->trans_status() === FALSE) {
			$status = FALSE;
		}
		
		$pg_appl_code = null;		
	
	
		if($status) {
			$pg_appl_sl_num	=	$this->db->insert_id();
			if($pg_appl_sl_num<10){
				$pg_appl_sl_num = "0000".$pg_appl_sl_num;
			}else
			if($pg_appl_sl_num<100){
				$pg_appl_sl_num = "000".$pg_appl_sl_num;
			}else
			if($pg_appl_sl_num<1000){
				$pg_appl_sl_num = "00".$pg_appl_sl_num;
			}else
			if($pg_appl_sl_num<10000){
				$pg_appl_sl_num = "0".$pg_appl_sl_num;
			}	
			
			$pg_appl_code =  /*$StepOneApplData['pg_appl_ctgr'] */"15". $StepOneApplData['pg_appl_subj'] . $pg_appl_sl_num;
			//update form number
			$fn_data = array('pg_appl_code' => $pg_appl_code );
			
			$this->db->where('pg_appl_sl_num', $pg_appl_sl_num);					
			$status = $this->db->update($c_tbl, $fn_data);
		
			$this->db->insert($f_tbl, $fn_data);	

			if ($this->db->trans_status() === FALSE) {
				$status = FALSE;
			}
		}
		
		$result  =array(
							'appl_name'		=>$StepOneApplData['pg_appl_name'],
							'appl_code'		=>$pg_appl_code,
							'appl_message'	=>" SUBMITTED",
							'appl_mobile'	=>$this->input->post('pg_appl_mobile'),
							'appl_email'	=>$this->input->post('pg_appl_email'),
							'appl_passwd'	=>$this->input->post('pg_appl_password'),
					   );
		
		if ($status === FALSE) {
		    $this->db->trans_rollback();
			$result['status'] = 0;
		} else {
		    $this->db->trans_commit();
			$result['status'] = 1;
		}		
					
		return $result;
		
	}
	
	//update application data
	function updateApplicationData(){
		$c_tbl = 'pg_appl_candidates';
		
		$modified_by = 'student';
		$modified_on = gmdate('Y-m-d H:i:s');
		$timestamp = getDateFormat($modified_on, 'ymdhis');
		
		if(isset($this->session->userdata['user'])) {
			$modified_by = $this->session->userdata['user_name'];
		}
		
		$marks = array(
						'pg_appl_mp_pct'=> $this->input->post('pg_appl_mp_pct'), 
						'pg_appl_hs_pct'=> $this->input->post('pg_appl_hs_pct'), 
						'pg_appl_grad_pct'=> $this->input->post('pg_appl_grad_pct')
					);
		
		$data = array(
					'pg_appl_ctgr' => $this->input->post('pg_appl_ctgr'),
					'pg_appl_gurd_name' => $this->input->post('pg_appl_gurd_name'),
					'pg_appl_dob' => convertToMySqlDate($this->input->post('pg_appl_dob')),
					'pg_appl_reservation' => $this->input->post('pg_appl_reservation'),
					'pg_appl_pwd' => $this->input->post('pg_appl_pwd'),
					'pg_appl_sports' => $this->input->post('pg_appl_sports'),
					'pg_appl_comm_address1' => $this->input->post('pg_appl_comm_address1'),
					'pg_appl_comm_address2' => $this->input->post('pg_appl_comm_address2'),
					'pg_appl_comm_city' => $this->input->post('pg_appl_comm_city'),
					'pg_appl_comm_state' => $this->input->post('pg_appl_comm_state'),
					'pg_appl_comm_district' => $this->input->post('pg_appl_comm_district'),
					'pg_appl_comm_pin' => $this->input->post('pg_appl_comm_pin'),
					'pg_appl_mobile' => $this->input->post('pg_appl_mobile'),
					'pg_appl_email' => $this->input->post('pg_appl_email'),
					'pg_appl_mp_org' => $this->input->post('pg_appl_mp_org'),
					'pg_appl_mp_pyear' => $this->input->post('pg_appl_mp_pyear'),
					'pg_appl_mp_subj' => $this->input->post('pg_appl_mp_subj'),
					'pg_appl_mp_pct' => $this->input->post('pg_appl_mp_pct'),
					'pg_appl_hs_org' => $this->input->post('pg_appl_hs_org'),
					'pg_appl_hs_pyear' => $this->input->post('pg_appl_hs_pyear'),
					'pg_appl_hs_pct' => $this->input->post('pg_appl_hs_pct'),
					'pg_appl_hs_subj' => $this->input->post('pg_appl_hs_subj'),
					'pg_appl_grad_org' => $this->input->post('pg_appl_grad_org'),
					'pg_appl_grad_pyear' => $this->input->post('pg_appl_grad_pyear'),
					'pg_appl_grad_major_subj' => $this->input->post('pg_appl_grad_major_subj'),
					//'pg_appl_grad_minor_subj' => $this->input->post('pg_appl_grad_minor_subj'),
					'pg_appl_grad_minor_subj' =>	$this->input->post('pg_appl_grad_minor_subj') == 'EMPTY' ? "" : $this->input->post('pg_appl_grad_minor_subj') ,
					'pg_appl_grad_pct' => $this->input->post('pg_appl_grad_pct'),
					'pg_appl_merit_score'	=>	calculateScore($marks),
				    'pg_apl_center_option'=>	$this->input->post('pg_apl_center_option'),
					'pg_appl_modified_on'	=>	$modified_on,
					'pg_appl_modified_by'	=>	$modified_by
	   );
			
		$status = TRUE;
		//$this->db->trans_begin();
		$this->db->where('pg_appl_sl_num', $this->input->post('pg_appl_sl_num'));
		$status = $this->db->update($c_tbl, $data);
		
		//Transaction logged
		$this->createTransHistory($this->input->post('pg_appl_code'), 'Application Modified', $modified_by, $modified_on);
	
		/*
		if ($this->db->trans_status() === FALSE) {
					$status = FALSE;
				}
				if ($status === FALSE) {
					$this->db->trans_rollback();
				} else {
					$this->db->trans_commit();
				}*/
		
	
		return $status;
	}
	
	//get application data
	function getApplicationData($pg_appl_code=null){
		$c_tbl   = 'pg_appl_candidates';
		$ps_tbl  = 'cnf_pgsubj';
		$us_tbl  = 'cnf_subjects';
		$res_tbl = 'cnf_reservation';
		$st_tbl  = 'cnf_states';
		$f_tbl   = 'pg_appl_fees';
		$clg_table = 'cnf_college';
		$o_tbl   = 'cnf_organizations';
		
		$this->db->select(array('DISTINCT ' . $c_tbl . '.pg_appl_sl_num', 'pg_appl_sess', 'pg_appl_ctgr', $c_tbl . '.pg_appl_code', 'pg_appl_subj', 'pg_apl_center_option', 'col_name pg_apl_center_option_name', 'pg_appl_name', 'pg_appl_profile_pic',
								'pg_appl_gurd_name', 'pg_appl_gurd_relation', 'pg_appl_gender', 'pg_appl_dob', 
								'pg_appl_comm_address1', 'pg_appl_comm_address2', 'pg_appl_comm_district', 'pg_appl_comm_state', 'pg_appl_comm_city', 'pg_appl_comm_pin', 
								'pg_appl_mobile', 'pg_appl_email', 
								'pg_appl_religion', 'pg_appl_reservation', 'pg_appl_pwd', 'pg_appl_sports', 'pg_appl_bu_reg_no', 
								'pg_appl_mp_subj', 'pg_appl_mp_org', 'pg_appl_mp_pyear', 'pg_appl_mp_pct',
								'pg_appl_hs_subj', 'pg_appl_hs_org', 'pg_appl_hs_pyear', 'pg_appl_hs_pct',
								'pg_appl_grad_major_subj', 'pg_appl_grad_minor_subj', 'pg_appl_grad_org', 'pg_appl_grad_pyear', 'pg_appl_grad_pct',
								'pg_appl_status', 'pg_appl_profile_pic', 'pg_appl_created_on', 
								'appl_fees_amount', 'appl_fees_type', 'pg_appl_pmt_code', 'appl_inst_num', 'appl_inst_type', 'appl_inst_branch', 'appl_inst_branch_code', 'appl_inst_date',
								'A.organization_name mp_organization_name', 'B.organization_name hs_organization_name', 'C.organization_name grad_organization_name',
								$ps_tbl.'.subj_name pg_subj_name', 'resv_name', 'MAJ.subj_name ug_major_subj_name', 'MIN.subj_name ug_minor_subj_name', 'state_name',
								), false);
								
		$this->db->from($c_tbl);
		$this->db->join($f_tbl, $f_tbl.'.pg_appl_code   	= '.$c_tbl.'.pg_appl_code', 'LEFT OUTER');
		$this->db->join($ps_tbl, $ps_tbl.'.subj_code 	= '.$c_tbl.'.pg_appl_subj', 'LEFT OUTER');
		$this->db->join($res_tbl, $res_tbl.'.resv_code 	= '.$c_tbl.'.pg_appl_reservation', 'LEFT OUTER');
		$this->db->join($st_tbl, $st_tbl.'.state_code 	= '.$c_tbl.'.pg_appl_comm_state', 'LEFT OUTER');
		$this->db->join($clg_table, $clg_table.'.col_code 	= '.$c_tbl.'.pg_apl_center_option', 'LEFT OUTER');
		
		
		$this->db->join($us_tbl. " MAJ", 'MAJ.subj_code 	= '.$c_tbl.'.pg_appl_grad_major_subj', 'LEFT OUTER');
		$this->db->join($us_tbl. " MIN", 'MIN.subj_code 	= '.$c_tbl.'.pg_appl_grad_minor_subj', 'LEFT OUTER');
		
		$this->db->join($o_tbl. " A", 'A.organization_id= '.$c_tbl.'.pg_appl_mp_org', 'LEFT OUTER');
		$this->db->join($o_tbl. " B", 'B.organization_id= '.$c_tbl.'.pg_appl_hs_org', 'LEFT OUTER');
		$this->db->join($o_tbl. " C", 'C.organization_id= '.$c_tbl.'.pg_appl_grad_org', 'LEFT OUTER');
		
		$this->db->where($c_tbl . '.pg_appl_code', $pg_appl_code);
		$query = $this->db->get();
		
		$results = $query->result_array();
		
		if(count($results) == 1){
			$results = $results[0];
			$results['univ_logo'] = $this->config->base_url() . 'assets/img/bu_logo90.jpg';
			$results['pg_appl_ctgr_name'] = _getUniversityCtgr($results['pg_appl_ctgr']);
			$results['pg_appl_gender_desc'] = _getGender($results['pg_appl_gender']);
			$profile_pic_path = $this->config->base_url() . "upload/students/profile_pic/";
			$profile_pic_path.= (($results['pg_appl_profile_pic'] != '') ? 't_' .$results['pg_appl_profile_pic'] : 'no-profile-pic_90.png');
			$results['pg_appl_profile_pic'] = $profile_pic_path;
		}
		return $results;
	}
	
	//search applications by search criteria
	function searchApplicationsByCriteria($page=1, $per_page=100){
		
		$pg_appl_code 	= $this->input->post('pg_appl_code');
		$pg_appl_name 	= $this->input->post('pg_appl_name');
		$pg_appl_mobile	=$this->input->post('pg_appl_mobile');
		$pg_appl_subj 	= $this->input->post('pg_appl_subj');
		$pg_appl_status = $this->input->post('pg_appl_status');
		$pg_appl_resv_extra = $this->input->post('pg_appl_resv_extra');
		$pg_appl_spcl_status = $this->input->post('pg_appl_spcl_status');
		$pg_appl_pmt_code    = $this->input->post('pg_appl_pmt_code');
		
		if(isset($_POST['pageno'])){
			$page = $this->input->post('pageno');
		}
		
		//echo $page; exit();
		
		
		$CRITERIA = array();
		$CRITERIA['pg_appl_code'] 	= $pg_appl_code;
		$CRITERIA['pg_appl_name'] 	= $pg_appl_name;
		$CRITERIA['pg_appl_mobile'] = $pg_appl_mobile;
		$CRITERIA['pg_appl_subj'] 	= $pg_appl_subj;
		$CRITERIA['pg_appl_status'] = $pg_appl_status;
		$CRITERIA['pg_appl_resv_extra'] = $pg_appl_resv_extra;
		$CRITERIA['pg_appl_spcl_status'] = $pg_appl_spcl_status;
		$CRITERIA['pg_appl_pmt_code'] = $pg_appl_pmt_code;
		
		
		$where = "pg_appl_status > 0";
		
		if(trim($pg_appl_code) != ''){
			$where .= " AND pg_appl_code like '".$pg_appl_code."'";
		}
		if(trim($pg_appl_name) != ''){
			$where .= " AND UPPER(pg_appl_name) like '%".strtoupper($pg_appl_name)."%'";
		}
		if(trim($pg_appl_mobile) != ''){
			$where .= " AND pg_appl_mobile like '".$pg_appl_mobile."'";
		}
		if(trim($pg_appl_subj) != 'EMPTY' && trim($pg_appl_subj) != '' && trim($pg_appl_subj) != 'undefined'){
			$where .= " AND pg_appl_subj like '".$pg_appl_subj."'";
		}
		if(trim($pg_appl_status) != ''){
			$where .= " AND pg_appl_status  ".$pg_appl_status;
		}
		if($pg_appl_resv_extra == 'PWD'){
			$where .= " AND pg_appl_pwd ='Y'";
		}
		if($pg_appl_resv_extra == 'SPORTS'){
			$where .= " AND pg_appl_sports ='Y'";
		}
		
		if($pg_appl_spcl_status == '1' || $pg_appl_spcl_status == '' || $pg_appl_spcl_status == null || $pg_appl_spcl_status == 'undefined'){
			$where .= " AND pg_appl_spcl_status = 1";
		}else 
		if($pg_appl_spcl_status == '0'){
			$where .= " AND pg_appl_spcl_status = 0";
		}
		
		if(trim($pg_appl_pmt_code) != ''){
			$where .= " AND UPPER(pg_appl_pmt_code) like '%".strtoupper($pg_appl_pmt_code)."%'";
		}
		
		//echo $where; exit();

		$orderby = " ORDER BY pg_appl_subj, pg_appl_reservation, pg_appl_status, pg_appl_name";

		$sql = "SELECT 
						pg_appl_sl_num, 		pg_appl_ctgr, 		pg_appl_code, 		pg_appl_subj, 
						pg_apl_center_option, 	pg_appl_name,		pg_appl_gurd_name,  pg_appl_mobile, 
						pg_appl_email,			pg_appl_reservation,pg_appl_pwd, 		pg_appl_sports,
						pg_appl_mp_pct,			pg_appl_hs_pct, 	pg_appl_grad_pct,	pg_appl_merit_score, pg_appl_written_score,
						pg_appl_status, 		pg_appl_profile_pic, pg_appl_spcl_status, pg_appl_status_remarks, pg_appl_pmt_code,
						pg_appl_grad_major_subj, pg_appl_grad_minor_subj, pg_appl_grad_org,
						col_name pg_apl_center_option_name, resv_name pg_appl_reservation_name, organization_name pg_appl_grad_org_name 
				FROM    pg_appl_candidates
	 LEFT OUTER JOIN    cnf_college ON col_code = pg_apl_center_option
	 LEFT OUTER JOIN    cnf_reservation ON resv_code = pg_appl_reservation 
	 LEFT OUTER JOIN    cnf_organizations ON organization_id = pg_appl_grad_org
				WHERE ".$where. $orderby;
		$total_results = $this->getRowCount($sql);
		$total_pages = ceil($total_results / $per_page);

		$sql .= " LIMIT " . ($page-1)*$per_page . ", " . $per_page;

		//echo $sql; exit();
		
		$r = $this->db->query($sql)->result();
		$result = array();
		$profile_pic_path = $this->config->base_url() . "upload/students/profile_pic/";
		for($i=0; $i<count($r); $i++) {
				$result[$i]=array(
							'pg_appl_sl_num' 		=>	$r[$i]->pg_appl_sl_num,
							'pg_appl_profile_pic'	=>	$profile_pic_path . (($r[$i]->pg_appl_profile_pic != '') ? 't_' . $r[$i]->pg_appl_profile_pic : 'no-profile-pic_90.png'),
							'pg_appl_ctgr'			=>	$r[$i]->pg_appl_ctgr,
							'pg_appl_ctgr_name'		=>	_getUniversityCtgr($r[$i]->pg_appl_ctgr),
							'pg_appl_code'			=>	$r[$i]->pg_appl_code,
							'pg_appl_subj'			=>	$r[$i]->pg_appl_subj,
							'pg_appl_subj_name'		=>	$this->configmodel->getSubjectNameByCode($r[$i]->pg_appl_subj),
							'pg_appl_grad_major_subj'			=>	$r[$i]->pg_appl_grad_major_subj,
							'pg_appl_grad_major_subj_name'		=>	$this->configmodel->getSubjectNameByCode($r[$i]->pg_appl_grad_major_subj),
							'pg_appl_grad_minor_subj'			=>	$r[$i]->pg_appl_grad_minor_subj,
							'pg_appl_grad_minor_subj_name'		=>	$this->configmodel->getSubjectNameByCode($r[$i]->pg_appl_grad_minor_subj),
							'pg_apl_center_option'	=>	$r[$i]->pg_apl_center_option,
							'pg_apl_center_option_name'	=>	$r[$i]->pg_apl_center_option_name,
							'pg_appl_name'	=>	$r[$i]->pg_appl_name,
							'pg_appl_gurd_name'	=>	$r[$i]->pg_appl_gurd_name,
							'pg_appl_mobile'	=>	$r[$i]->pg_appl_mobile,
							'pg_appl_reservation'	=>	$r[$i]->pg_appl_reservation,
							'pg_appl_reservation_name'	=>	$r[$i]->pg_appl_reservation_name,
							'pg_appl_pwd'	=>	$r[$i]->pg_appl_pwd,
							'pg_appl_sports'	=>	$r[$i]->pg_appl_sports,
							'pg_appl_mp_pct'	=>	$r[$i]->pg_appl_mp_pct,
							'pg_appl_hs_pct'	=>	$r[$i]->pg_appl_hs_pct,
							'pg_appl_grad_pct'	=>	$r[$i]->pg_appl_grad_pct,
							'pg_appl_merit_score'	=>	$r[$i]->pg_appl_merit_score,
							'pg_appl_written_score'	=>	$r[$i]->pg_appl_written_score,
							'pg_apl_center_option'	=>	$r[$i]->pg_apl_center_option,
							'pg_appl_grad_org'	=>	$r[$i]->pg_appl_grad_org,
							'pg_appl_grad_org_name'	=>	$r[$i]->pg_appl_grad_org_name,
							'pg_appl_status'	=>	$r[$i]->pg_appl_status,
							'pg_appl_pmt_code'	=>	$r[$i]->pg_appl_pmt_code,
							'pg_appl_spcl_status'	=>	$r[$i]->pg_appl_spcl_status,
							'pg_appl_status_remarks'	=>	$r[$i]->pg_appl_status_remarks,
							);
		}

		$data   = array();
		$data['CRITERIA'] = $CRITERIA;
		$data['RESULT'] = $result;
		$data['PAGENO'] = $page;
		$data['TOTALPAGES'] = $total_pages;
		//print_r($data);	exit();
		return $data;
	}
	
	function getRowCount($sql) {
		$results = $this->db->query($sql)->result();
		return count($results);
	}
	
	function updateStudentStaus(){
		$pg_appl_spcl_status 	= $_REQUEST['pg_appl_spcl_status'];
		$pg_appl_status_remarks = $_REQUEST['pg_appl_status_remarks'];
		$pg_appl_sl_num 	= $_REQUEST['pg_appl_sl_no'];
		
		$modified_on = gmdate('Y-m-d');
		$modified_by = $this->session->userdata['user']['user_name']; //user id from session
		
		
		$c_tbl = 'pg_appl_candidates';
		
		$data = array(
					  'pg_appl_spcl_status'		=>	$pg_appl_spcl_status,
					  'pg_appl_status_remarks'	=>	$pg_appl_status_remarks,
					  'pg_appl_modified_by'		=>	$modified_by,
					  'pg_appl_modified_on'		=>	$modified_on,
				    );
		$this->db->where('pg_appl_sl_num', $pg_appl_sl_num);	
		$status = $this->db->update($c_tbl, $data);
		if($status){
			return 'TRUE';
		}else{
			return 'FALSE';
		}
	}
	
	function updateStudentReservation(){
		$status 		= $_REQUEST['status'];
		$resv 			= $_REQUEST['resv'];
		$pg_appl_sl_num = $_REQUEST['pg_appl_sl_no'];
		
		$modified_on = gmdate('Y-m-d');
		$modified_by = $this->session->userdata['user']['user_name']; //user id from session
		
		
		$c_tbl = 'pg_appl_candidates';
		
		$data = array(
					   $resv		=>	$status,
					  'pg_appl_modified_by'		=>	$modified_by,
					  'pg_appl_modified_on'		=>	$modified_on,
				    );
		$this->db->where('pg_appl_sl_num', $pg_appl_sl_num);	
		$status = $this->db->update($c_tbl, $data);
		
		$data = $this->getUserMinimalInfoByIdCode($pg_appl_sl_num, null);
		
		if($status){
			$data['appl_message'] = ' special Reservation updated';
			$data['status'] = 'TRUE';
		}else{
			$data['appl_message'] = ' special Reservation not updated';
			$data['status'] = 'FALSE';
		}
		//print_r($data); exit();
		
		return $data;
	}

	function updatePaymentStaus(){
		$pg_appl_status	= $_REQUEST['pg_appl_status'];
		$pg_appl_pmt_code	= $_REQUEST['pg_appl_pmt_code'];
		$pg_appl_sl_num = $_REQUEST['pg_appl_sl_no'];
		
		if($pg_appl_status == '1'){//only for revoke
			$pg_appl_pmt_code = "";
		}

		$verified_on = gmdate('Y-m-d');
		$verified_by = $this->session->userdata['user']['user_name']; //user id from session
		
		
		$c_tbl = 'pg_appl_candidates';
		
		$data = array(
					  'pg_appl_pmt_code'	=>	$pg_appl_pmt_code,
					  'pg_appl_status'		=>	$pg_appl_status,
					  'pg_appl_verified_by'	=>	$verified_by,
					  'pg_appl_verified_on'	=>	$verified_on,
				    );
		$this->db->where('pg_appl_sl_num', $pg_appl_sl_num);	
		$status = $this->db->update($c_tbl, $data);
		if($status){
			return 'TRUE';
		}else{
			return 'FALSE';
		}
	}
	
	function getAdmitCardInfo($appl_code = null){
		
		$sql = "SELECT 
						pg_appl_code appl_code, pg_appl_name appl_name, pg_appl_gurd_name appl_gurd_name,
						cnf_subjects.subj_name appl_subject, pg_appl_profile_pic,subj_cors_code course_code
				FROM pg_appl_candidates
				LEFT OUTER JOIN cnf_subjects ON cnf_subjects.subj_code = pg_appl_subj
				LEFT OUTER JOIN cnf_pgsubj ON cnf_pgsubj.subj_code = pg_appl_subj
				WHERE pg_appl_code like '".$appl_code."'";
		
		$info = array();
		  
		$query 	= $this->db->query($sql);
		$result = $query->result_array();
		if(count($result) > 0){
			$image_path = $this->config->base_url() . "assets/img/";
			$profile_pic_path = $this->config->base_url() . "upload/students/profile_pic/";
			$profile_pic_path.= (($result[0]['pg_appl_profile_pic'] != '') ? 't_' .$result[0]['pg_appl_profile_pic'] : 'no-profile-pic_90.png');
			
			
			$info['logo'] 		= $image_path."bu_logo120.png";
			$info['appl_code'] 	= $result[0]['appl_code'];
			$info['appl_name'] 	= $result[0]['appl_name'];
			$info['appl_gurd_name'] = $result[0]['appl_gurd_name'];
			$info['appl_image'] = $profile_pic_path;
			$info['appl_subject'] = $result[0]['appl_subject'];
			$info['auth_signature'] = $image_path._getAuthoritySignature($result[0]['course_code']);
			$info['auth_designation'] = _getAuthorityDesignation($result[0]['course_code']);
		}
		
		$sql = "select roll_no, exam_date, exam_start_time, exam_end_time, hall_number, building_name, building_address
				FROM exam_seat_info
				LEFT OUTER JOIN  cnf_exam_subj ON cnf_exam_subj.exam_subj_id = exam_seat_info.exam_subj_id
				LEFT OUTER JOIN  cnf_exam ON cnf_exam.exam_id = cnf_exam_subj.exam_id
				LEFT OUTER JOIN  cnf_hall ON cnf_hall.hall_id = cnf_exam_subj.hall_id
				LEFT OUTER JOIN  cnf_building ON cnf_building.building_id = cnf_hall.building_id
				WHERE pg_appl_code like '".$appl_code."'";		
		
		$query 	= $this->db->query($sql);
		$result = $query->result_array();
		if(count($result) > 0){
			$info['roll_no']    = $result[0]['roll_no'];
			$info['exam_date']  = getDateFormat($result[0]['exam_date'], 'd-m-Y');
			$info['exam_time']  = $result[0]['exam_start_time'] ." - " . $result[0]['exam_end_time'];
			$info['exam_venue'] = $result[0]['hall_number'] ." (" . $result[0]['building_name'] .", " .$result[0]['building_address'] . ")";
		}else{
			$info['roll_no']    = '';
			$info['exam_date']  = '';
			$info['exam_time']  = '';
			$info['exam_venue'] = '';
		}
		
		return $info;
		//print_r($info); exit();
	}
	
	
	//get student rank info by application code: Done
	function getRankCardInfo($appl_code){
		$c_tbl = 'pg_appl_candidates';
		$this->db->select('*');
		$this->db->from($c_tbl);
		$this->db->where('LOWER(pg_appl_code)', trim(strtolower($appl_code)));
		$query = $this->db->get();	
		
		$rankinfo = array();
		
		if ($query->num_rows() >= 1) {
			$row = $query->row(); 
			
			$rank_60pct = array(
							'GEN'   => $row->pg_appl_60pct_gen_merit,
							'OBCA'	=> $row->pg_appl_60pct_obca_merit,
							'OBCB'	=> $row->pg_appl_60pct_obcb_merit,
							'SC'	=> $row->pg_appl_60pct_sc_merit,
							'ST'	=> $row->pg_appl_60pct_st_merit,
							'PWD'	=> $row->pg_appl_60pct_pwd_merit,
							'SPORTS'=> $row->pg_appl_60pct_sports_merit,
							'HONS'	=> $row->pg_appl_60pct_hons_merit,
							
							'GEN_TYPE'  => $this->configmodel->getMeritInfo($row->pg_appl_60pct_gen_merit_ctgr),
							'OBCA_TYPE'	=> $this->configmodel->getMeritInfo($row->pg_appl_60pct_obca_merit_ctgr),
							'OBCB_TYPE'	=> $this->configmodel->getMeritInfo($row->pg_appl_60pct_obcb_merit_ctgr),
							'SC_TYPE'	=> $this->configmodel->getMeritInfo($row->pg_appl_60pct_sc_merit_ctgr),
							'ST_TYPE'	=> $this->configmodel->getMeritInfo($row->pg_appl_60pct_st_merit_ctgr),
							'PWD_TYPE'	=> $this->configmodel->getMeritInfo($row->pg_appl_60pct_pwd_merit_ctgr),
							'SPORTS_TYPE'=> $this->configmodel->getMeritInfo($row->pg_appl_60pct_sports_merit_ctgr),
							'HONS_TYPE'	=> $this->configmodel->getMeritInfo($row->pg_appl_60pct_hons_merit_ctgr),
						 );
			
			$rank_40pct = array(
							'GEN'   => $row->pg_appl_40pct_gen_merit,
							'OBCA'	=> $row->pg_appl_40pct_obca_merit,
							'OBCB'	=> $row->pg_appl_40pct_obcb_merit,
							'SC'	=> $row->pg_appl_40pct_sc_merit,
							'ST'	=> $row->pg_appl_40pct_st_merit,
							'PWD'	=> $row->pg_appl_40pct_pwd_merit,
							'SPORTS'=> $row->pg_appl_40pct_sports_merit,
							'HONS'	=> $row->pg_appl_40pct_hons_merit,
							
							'GEN_TYPE'  => $this->configmodel->getMeritInfo($row->pg_appl_40pct_gen_merit_ctgr),
							'OBCA_TYPE'	=> $this->configmodel->getMeritInfo($row->pg_appl_40pct_obca_merit_ctgr),
							'OBCB_TYPE'	=> $this->configmodel->getMeritInfo($row->pg_appl_40pct_obcb_merit_ctgr),
							'SC_TYPE'	=> $this->configmodel->getMeritInfo($row->pg_appl_40pct_sc_merit_ctgr),
							'ST_TYPE'	=> $this->configmodel->getMeritInfo($row->pg_appl_40pct_st_merit_ctgr),
							'PWD_TYPE'	=> $this->configmodel->getMeritInfo($row->pg_appl_40pct_pwd_merit_ctgr),
							'SPORTS_TYPE'=> $this->configmodel->getMeritInfo($row->pg_appl_40pct_sports_merit_ctgr),
							'HONS_TYPE'	=> $this->configmodel->getMeritInfo($row->pg_appl_40pct_hons_merit_ctgr),
						 );
			
			$profile_pic_path = $this->config->base_url() . "upload/students/profile_pic/";
			$image_path = $this->config->base_url() . "assets/img/";
			
			$rankinfo = array(	'60PCT' => $rank_60pct, 
								'40PCT' => $rank_40pct, 
								'CTGR'		=> $row->pg_appl_ctgr,
								'univ_logo'     	=> $this->config->base_url() . 'assets/img/bu_logo90.jpg',
								'appl_name'    		=> $row->pg_appl_name, 
								'appl_email'   		=> $row->pg_appl_email,
								'appl_phone'   		=> $row->pg_appl_mobile,
								'appl_profile_pic'	=>	$profile_pic_path . (($row->pg_appl_profile_pic != '') ? 't_' . $row->pg_appl_profile_pic : 'no-profile-pic_90.png'),
								'appl_subject'      => $this->configmodel->getPgSubjectNameByCode($row->pg_appl_subj),
								'appl_code'         => $row->pg_appl_code,
								
								'auth_signature' 	=> $image_path._getAuthoritySignature($this->configmodel->getCourseCodeBySubjectCode($row->	pg_appl_subj)),
								'auth_designation' 	=> _getAuthorityDesignation($this->configmodel->getCourseCodeBySubjectCode($row->	pg_appl_subj)),
							);
			
			
		} 
		return $rankinfo;
			
	}
	
	
	
	function getUserMinimalInfoByIdCode($pg_appl_sl_num = null, $pg_appl_code = null){
		$sql = "SELECT pg_appl_code appl_code, pg_appl_name, pg_appl_email, pg_appl_mobile appl_mobile FROM pg_appl_candidates WHERE 1=1";
		if($pg_appl_sl_num != null && $pg_appl_sl_num != ""){
			$sql .= " AND pg_appl_sl_num = ".$pg_appl_sl_num ;
		}
		if($pg_appl_code != null && $pg_appl_code != ""){
			$sql .= " AND pg_appl_code = '".$pg_appl_code."'" ;
		}
		$query = $this->db->query($sql);
		$results = $query->result_array();
		if(count($results) > 0){
			$results = $results[0];
		}
		return $results;
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//get applicant's challan for application fees
	function getChallanByApplCode($pg_appl_code) {
		$c_tbl = 'pg_appl_candidates';
		$s_tbl = 'cnf_pgsubj';
		
		$fees_amount = applicationFeesAmount();
		
		$this->db->select(array('DISTINCT pg_appl_code', 'pg_appl_ctgr', 'pg_appl_subj', 'subj_name', 'pg_appl_name', 
								'pg_appl_comm_address1', 'pg_appl_comm_address2', 'pg_appl_comm_district', 'pg_appl_comm_state', 
								'pg_appl_comm_city', 'pg_appl_comm_pin', 'pg_appl_mobile'), false);
		$this->db->from($c_tbl);
		$this->db->join($s_tbl, 'subj_code = pg_appl_subj');
		$this->db->where('pg_appl_code', $pg_appl_code);
		$query = $this->db->get();
		$results = $query->result();
		$challan = array();
		if(count($results) > 0){
			$challan = array('univ_logo'     => $this->config->base_url() . 'assets/img/bu_logo90.jpg',
							 'appl_code'     => $results[0]->pg_appl_code,
							 'subj_name'     => $results[0]->subj_name,
							 'appl_name'     => $results[0]->pg_appl_name,
							 'appl_address'  => $results[0]->pg_appl_comm_address1 . ', ' . $results[0]->pg_appl_comm_address2 . ', ' .
												$results[0]->pg_appl_comm_city . ', ' . $results[0]->pg_appl_comm_district . ', ' .
												$results[0]->pg_appl_comm_state . ', ' . $results[0]->pg_appl_comm_pin,
							 'appl_mobile_num'=> $results[0]->pg_appl_mobile,
							 'total_amt'	  =>	getFormatedAmount($fees_amount),
							 'total_amt_word' => getAmtInWords($fees_amount),
							 'bank_account_no'=> PowerJyotiAccountNo()
						 );
		}
		return $challan;
	}	

	//get journal information based on application code
	function getJournalInfoByApplCode($appl_code=null){
		$f_tbl = 'pg_appl_fees';
		$c_tbl = 'pg_appl_candidates';
		
		$fees_amount = applicationFeesAmount();
		
		$this->db->select(array('DISTINCT pg_appl_fees.pg_appl_code', 'appl_fees_amount', 'appl_fees_type',  
								'appl_inst_num', 'appl_inst_type', 'appl_inst_branch', 'appl_inst_branch_code', 'appl_inst_date', 
								'pg_appl_status', 'fees_verified_on'), false);
		$this->db->from($f_tbl);
		$this->db->join($c_tbl, 'pg_appl_candidates.pg_appl_code = pg_appl_fees.pg_appl_code');
		if($appl_code != null){
			$this->db->where('pg_appl_fees.pg_appl_code', $appl_code);			
		}
		
		$query = $this->db->get();
		$results = $query->result();
		$challan = array();
		for($i=0; $i<count($results); $i++){
			$challan[$i] = array('univ_logo'     	=> $this->config->base_url() . 'assets/img/bu_logo90.jpg',
							 'pg_appl_code'     	=> $results[$i]->pg_appl_code,
							 'appl_fees_amount'     => $results[$i]->appl_fees_amount,
							 'appl_fees_type'     	=> $results[$i]->appl_fees_type,
							 'appl_inst_num'		=> $results[$i]->appl_inst_num,
							 'appl_inst_type'	    => $results[$i]->appl_inst_num,
							 'appl_inst_branch'	    => $results[$i]->appl_inst_branch,
							 'appl_inst_branch_code'	    => $results[$i]->appl_inst_branch_code,
							 'appl_inst_date'	    => getDateFormat($results[$i]->appl_inst_date, 'd-m-Y'),
							 'pg_appl_status'	    => $results[$i]->pg_appl_status,
							 'fees_verified_on'	    => getDateFormat($results[$i]->fees_verified_on, 'd-m-Y'),
						 );
		}
		$r = array('challan' => $challan);
		
		return $r;
	}	

	//submit application journal number
	function submitJournalInformation(){
		$c_tbl = 'pg_appl_candidates';
		$f_tbl = 'pg_appl_fees';
		
		$created_on = gmdate('Y-m-d H:i:s');
		$timestamp = getDateFormat($created_on, 'ymdhis');
			
		$data = array(
					  'appl_fees_amount'	=>	applicationFeesAmount(),
					  'appl_fees_type'		=>	'Application Fees',
					  'appl_inst_type'		=>	'Challan',
				      'appl_inst_num'		=>	$this->input->post('appl_inst_num'),
				      'appl_inst_branch'	=>	$this->input->post('appl_inst_branch'),
				      'appl_inst_branch_code'=>	$this->input->post('appl_inst_branch_code'),
				      'appl_inst_date'		=>	convertToMySqlDate($this->input->post('appl_inst_date')),
				    );
		
		$status = TRUE;
		$this->db->trans_begin();
		
		$this->db->where('pg_appl_code', $this->input->post('pg_appl_code'));	
		$this->db->update($f_tbl, $data);
		if ($this->db->trans_status() === FALSE) {
			$status = FALSE;
		}
		
		if($status) {
			$fn_data = array('pg_appl_status' => '2' );
			$this->db->where('pg_appl_code', $this->input->post('pg_appl_code'));					
			$status = $this->db->update(pg_appl_candidates, $fn_data);
		
			if ($this->db->trans_status() === FALSE) {
				$status = FALSE;
			}
		}
		$result = false;
		
		if ($status === FALSE) {
		    $this->db->trans_rollback();
			$result = false;
		} else {
		    $this->db->trans_commit();
			$result = true;
		}		
					
		return $result;
	}	
	
	//insert into transaction history
	function createTransHistory($form_num, $event, $user, $date) {
		$ath_tbl = 'appl_trans_history';
		$data = array(
							'ath_form_num'		=>	$form_num,
				      		'ath_event'			=>	$event,
				      		'ath_event_by'		=>	$user,
				      		'ath_event_date'	=>	$date
					  );
		$status = $this->db->insert($ath_tbl, $data);	
	}
	
	//application related funcstion : End
}
?>