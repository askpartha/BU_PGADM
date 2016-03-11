<?php
class Studentmodel extends CI_Model {

    function __construct() {
        parent::__construct();
		$this->load->database();
		$ci = get_instance();
		$ci->load->helper('string');
    }
	
	
	//upload profile pic : Done
	function updateProfilePic($appl_code, $img_name) {
		$c_tbl = 'pg_appl_candidates';
		$modified_on = gmdate('Y-m-d H:i:s');
		$modified_by = (isset($this->session->userdata['student']) ? 'student' : $this->session->userdata['user']['user_name']);
		
		$data = array(
				      'pg_appl_profile_pic'	=>	$img_name
				    );
		$this->db->where('pg_appl_code', $appl_code);					
		$status = $this->db->update($c_tbl, $data);
		//$this->session->set_userdata('tmp_student_pic', $img_name);
		$this->session->userdata['student']['student_pic'] = $img_name;
		
		//update the transaction history
		$event = "Profile picture uploaded";
		$this->createTransHistory($appl_code, $event, $modified_by, $modified_on);
		
		return $status;
	}
	
	//get details for reset password
	function getDetailsForResetPassword() {
		
		$ar_tbl = 'pg_appl_candidates';
		$subj_tbl = 'cnf_pgsubj';
		$this->db->select(array('pg_appl_sl_num', 'pg_appl_code', 'pg_appl_name', 'pg_appl_subj', 'subj_name', 'pg_appl_gurd_name', 'pg_appl_mobile', 'pg_appl_email',  'pg_appl_profile_pic'));
		$this->db->from($ar_tbl);
		$this->db->join($subj_tbl, 'subj_code = pg_appl_subj');
		
		if($this->input->post('pg_appl_code') != null && $this->input->post('pg_appl_code') != ''){
			$this->db->where('pg_appl_code', $this->input->post('pg_appl_code'));			
		}
		if($this->input->post('pg_appl_mobile') != null && $this->input->post('pg_appl_mobile') != ''){
			$this->db->where('pg_appl_mobile', $this->input->post('pg_appl_mobile'));			
		}
		$query = $this->db->get();
		$r = $query->row();
		
		//echo $this->db->last_query();exit();
		
		$info = array();
		if(count($r) > 0) {
			$profile_pic_path = $this->config->base_url() . "upload/students/profile_pic/";
			$info = array(
							'pg_appl_sl_num'		=>	$r->pg_appl_sl_num,
							'pg_appl_code'			=>	$r->pg_appl_code,
							'pg_appl_name'			=>	$r->pg_appl_name,
							'pg_appl_subj'			=>	$r->pg_appl_subj,
							'subj_name'				=>	$r->subj_name,
							'pg_appl_gurd_name'		=>	$r->pg_appl_gurd_name,
							'pg_appl_mobile'		=>	$r->pg_appl_mobile,
							'pg_appl_email'			=>	$r->pg_appl_email,
							'pg_appl_profile_pic'		=>	$profile_pic_path . (($r->pg_appl_profile_pic != '') ? 't_' . $r->pg_appl_profile_pic : 'no-profile-pic_90.png')
						);
		}				
		return $info;			
	}

	//update password : Done
	function updatePassword($pg_appl_code, $new_passwd, $modified_by) {
		$c_tbl = 'pg_appl_candidates';
		$modified_on = gmdate('Y-m-d H:i:s');

		$data = array(
				      'pg_appl_password'	=>	$new_passwd,
				      'pg_appl_modified_on'	=>	$modified_on,
				      'pg_appl_modified_by'	=>	$modified_by
				    );
		$this->db->where('pg_appl_code', $pg_appl_code);	
		if($modified_by == 'student') {
			$this->db->where('pg_appl_mobile', $this->session->userdata['student']['student_mobile']);
		}				
		$this->db->update($c_tbl, $data);
		
		//update the transaction history
		$event = "Password changed";
		$this->createTransHistory($pg_appl_code, $event, $modified_by, $modified_on);
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;		
	}
		
	//get application status by application code
	function getApplicationStatusByApplicationCode($appl_code){
		$sql = "SELECT pg_appl_status FROM pg_appl_candidates WHERE pg_appl_code = '".$appl_code."'";
		$query = $this->db->query($sql);
		$results = $query->result();
		$pg_appl_status = "";
		if(count($results) > 0){
			$pg_appl_status = $results[0]->pg_appl_status;
		}
		return $pg_appl_status;
	}

	//check whether application exists for application code/ mobile number combination
	function isApplicationExistsForApplicationCodeMobileNumber($pg_appl_code, $pg_apl_mobile){
		$sql = "SELECT * FROM pg_appl_candidates WHERE pg_appl_code = '".$pg_appl_code."' AND pg_appl_mobile=".$pg_apl_mobile;
		$query = $this->db->query($sql);
		$results = $query->result_array();
		$info = array();
		if(count($results) > 0){
			$info['pg_appl_sl_num'] = $results[0]['pg_appl_sl_num'];
			$info['status'] = true;
		}else{
			$info['status'] = false;			
		}
		return $info;
	}
	
	//get students for notification by study center, subject count
	function getStudentsForNotificationCount($sql) {
		$results = $this->db->query($sql)->result();
		return count($results);
	}

	//get students for notification by study center, subject
	function getStudentsForNotification($cntr_code, $subj_code, $current_page = 1, $per_page = 50) {
		$ar_tbl = 'appl_register_tmp';
		$subj_tbl 	= 'cnf_subj';
		$cntr_tbl = 'cnf_cntr';
		$pmnt_tbl = 'appl_payments';
		
		$sql = "SELECT DISTINCT cntr_code, cntr_name, appl_subj_code, subj_name, 
					appl_form_num, appl_enrl_num, appl_fname, appl_mname, appl_lname, appl_father_name, appl_mobile_num, appl_status,
					pmnt_journal_num, pmnt_challan_date, pmnt_challan_amount
				FROM " . $ar_tbl . "
				JOIN " . $cntr_tbl . " ON cntr_code = appl_cntr_code
				JOIN " . $subj_tbl . " ON subj_code = appl_subj_code 
				LEFT OUTER JOIN " . $pmnt_tbl . " ON pmnt_challan_num = appl_form_num
				WHERE appl_id > 0 AND appl_status = 3";
		if($cntr_code != '00') {
			$sql .= " AND cntr_code = '" . $cntr_code . "'";
		}

		if($subj_code != '00') {
			$sql .= " AND subj_code = '" . $subj_code . "'";
		}

		//get data for pagination
		$total_results = $this->getStudentsForNotificationCount($sql);
		$total_pages = ceil($total_results / $per_page);
		$offset = ($current_page - 1) * $per_page;
		$paginate = array('total_records'	=>	$total_results,
						  'total_pages'		=>	$total_pages,
						  'per_page'		=>	$per_page,
						  'current_page'	=>	$current_page
						 );

		$sql .= " ORDER BY appl_form_num, appl_enrl_num, appl_fname, appl_lname";
		$sql .= " LIMIT " . $offset . ", " . $per_page;
	
		//echo $sql;
				
		$r = $this->db->query($sql)->result();
		$results = array();	
		
		for($i=0; $i<count($r); $i++) {
			$results[$i] = array(
									'cntr_code'				=>	$r[$i]->cntr_code,
									'cntr_name'				=>	$r[$i]->cntr_name,
									'appl_subj_code'		=>	$r[$i]->appl_subj_code,
									'subj_name'				=>	$r[$i]->subj_name,
									'appl_form_num'			=>	$r[$i]->appl_form_num,
									'appl_enrl_num'			=>	$r[$i]->appl_enrl_num,
									'appl_name'				=>	getFullname($r[$i]->appl_fname, $r[$i]->appl_mname, $r[$i]->appl_lname),
									'appl_father_name'		=>	$r[$i]->appl_father_name,
									'appl_mobile_num'		=>	$r[$i]->appl_mobile_num,
									'appl_status'			=>	getApplicationStatusText($r[$i]->appl_status),
									'pmnt_journal_num'		=>	($r[$i]->pmnt_journal_num == NULL) ? '' : $r[$i]->pmnt_journal_num,
									'pmnt_challan_date'		=>	getDateFormat($r[$i]->pmnt_challan_date),
									'pmnt_challan_amount'	=>	$r[$i]->pmnt_challan_amount
								);
		}	
		$students = array('students'	=>	$results, 'paginate'	=>	$paginate);
		return $students;	
	}		

	//send approval SMS notification
	function sendApprovalSMSNotification($appl_id) {
		$ar_tbl = 'appl_register_tmp';
		$this->db->select(array('appl_enrl_num', 'appl_mobile_num'), FALSE);
		$this->db->from($ar_tbl);
		$this->db->where('appl_id', $appl_id);
		$query = $this->db->get();
		$r = $query->row();
		
		$ph_num = $r->appl_mobile_num;
		$sms_msg = "Your application is verified and approved. Please note your permanent Enrolment Number: " . $r->appl_enrl_num;
		
		$this->sendSMSNotification($ph_num, $sms_msg);
	}
	
	//send SMS notification
	function sendSMSNotification($ph_nos, $sms_msg) {
		$sms_msg	=	str_replace(" ", "+", $sms_msg);
		
		$url		=	'http://sms99.co.in/pushsms.php';
		$curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, $url . "?username=trbudedu&password=43185&sender=BUDEDU&message=" . $sms_msg . "&numbers=" . $ph_nos);
	    $output = curl_exec($curl);
	    curl_close ($curl);
		return TRUE;
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
}	
?>	