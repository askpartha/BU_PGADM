<?php
class Reportmodel extends CI_Model {
    function __construct() {
        parent::__construct();
		$this->load->database();
		$ci = get_instance();
		$ci->load->helper('string');
    }
    
	//get dashboard stats
	function getDashboardStats($subject = null) {
				$where = "";
				if($subject!= null && $subject != "" && $subject != 'EMPTY'){
					$where .= " AND pg_appl_subj like '".$subject."'";					
				}
		
				 $sql = "SELECT COUNT(pg_appl_code) AS total_form, 
						(SELECT COUNT(pg_appl_code) FROM pg_appl_candidates WHERE pg_appl_status  > 0 ".$where." ) AS total_application,
						(SELECT COUNT(pg_appl_code) FROM pg_appl_candidates WHERE pg_appl_status  > 1 ".$where." ) AS total_payment,
						(SELECT COUNT(pg_appl_code) FROM pg_appl_candidates WHERE pg_appl_status  > 2 ".$where." ) AS total_confirm,
						(SELECT COUNT(pg_appl_code) FROM pg_appl_candidates WHERE pg_appl_status  = 4 ".$where." ) AS total_appl_admitted,
						(SELECT COUNT(pg_appl_code) FROM pg_appl_candidates WHERE pg_appl_status  = 9 ".$where." ) AS total_appl_rejected,
						(SELECT COUNT(pg_appl_code) FROM pg_appl_candidates WHERE pg_appl_status  > 0 ".$where." AND pg_appl_ctgr like 'BU') AS total_bu_application,
						(SELECT COUNT(pg_appl_code) FROM pg_appl_candidates WHERE pg_appl_status  > 0 ".$where." AND pg_appl_ctgr like 'OU') AS total_ou_application,
						(SELECT COUNT(pg_appl_code) FROM pg_appl_candidates WHERE pg_appl_status  > 1 ".$where." AND pg_appl_ctgr like 'BU') AS total_bu_payment,
						(SELECT COUNT(pg_appl_code) FROM pg_appl_candidates WHERE pg_appl_status  > 1 ".$where." AND pg_appl_ctgr like 'OU') AS total_ou_payment
				FROM pg_appl_candidates 
				WHERE pg_appl_sl_num > 0";
				
		$r = $this->db->query($sql)->result();
		return array('stats'	=>	$r);		
	}
	
	//get dashboard users
	function getDashboardUsers() {
				 $sql = "SELECT COUNT(user_id) AS total_user, 
						(SELECT COUNT(user_id) FROM users WHERE is_active = 1) AS total_user_active,
						(SELECT COUNT(user_id) FROM users WHERE role= 'Admin' ) AS total_admin,
						(SELECT COUNT(user_id) FROM users WHERE role= 'Admin' AND is_active = 1) AS total_admin_active,
						(SELECT COUNT(user_id) FROM users WHERE role= 'Center'  ) AS total_center,
						(SELECT COUNT(user_id) FROM users WHERE role= 'Center' AND is_active = 1) AS total_center_active,
						(SELECT COUNT(user_id) FROM users WHERE role= 'Verifier') AS total_verifier,
						(SELECT COUNT(user_id) FROM users WHERE role= 'Verifier' AND is_active = 1) AS total_verifier_active,
						(SELECT COUNT(user_id) FROM users WHERE role= 'Staff') AS total_staff,
						(SELECT COUNT(user_id) FROM users WHERE role= 'Staff' AND is_active = 1) AS total_staff_active
				FROM users 
				WHERE user_id > 0";
				
		$r = $this->db->query($sql)->result();
		//return array('usrs'	=>	$r);
		return $r;		
	}
	
	function getPaymentByDateInfo(){
		 $sql =  "SELECT pg_appl_verified_on, count(*) AS COUNT FROM pg_appl_candidates WHERE pg_appl_status  > 1 GROUP BY pg_appl_verified_on ";
		 $r = $this->db->query($sql)->result();
		//return array('usrs'	=>	$r);
		return $r;
	}

	//get all challans by day count
	function getAllPaymentsByDayCount($sql) {
		$results = $this->db->query($sql)->result();
		return count($results);
	}
	
	//get all challans by day
	function getAllPaymentsByDay($date, $current_page = 1, $per_page = 1) {
		$p_tbl 	= 'pg_appl_candidates';
		$u_tbl 	= 'users';
		
		$clause = '';
		if($this->session->userdata['user']['user_role'] == "Verifier"){
			$clause = " AND pg_appl_verified_by = '" . $this->session->userdata['user']['user_name'] ."'";
		}
		
		$sql = "SELECT DISTINCT pg_appl_code appl_code, pg_appl_ctgr appl_ctgr, pg_appl_name appl_name, pg_appl_status appl_status, pg_appl_pmt_code appl_pmt_code,  
				pg_appl_verified_by appl_verified_by , pg_appl_verified_on appl_verified_on , user_firstname, user_lastname
				FROM pg_appl_candidates
				LEFT OUTER JOIN users ON user_name = pg_appl_verified_by
				WHERE pg_appl_verified_on = '" . convertToMySqlDate($date) . "' AND pg_appl_status = 2 " . $clause;
				
		//get data for pagination
		$total_results = $this->getAllPaymentsByDayCount($sql);
		$total_pages = ceil($total_results / $per_page);
		$offset = ($current_page - 1) * $per_page;
		$paginate = array('total_records'	=>	$total_results,
						  'total_pages'		=>	$total_pages,
						  'current_page'	=>	$current_page,
						  'offset'			=>	$offset
						 );
		$sql .= " ORDER BY pg_appl_verified_on, appl_name ";				 
		$sql .= " LIMIT " . $offset . ", " . $per_page;

		//echo $sql; exit();

 		$r = $this->db->query($sql)->result();
		$results = array();	
		
		for($i=0; $i<count($r); $i++) {
			$results[$i] = array(
									'appl_code'			=>	$r[$i]->appl_code,
									'appl_ctgr'			=>	$r[$i]->appl_ctgr,
									'appl_name'			=>	$r[$i]->appl_name,
									'appl_status'		=>	_getApplicationStatus($r[$i]->appl_status),
									'appl_pmt_code'		=>	$r[$i]->appl_pmt_code,
									'appl_verified_by'	=>	getFullname($r[$i]->user_firstname, '', $r[$i]->user_lastname),
									'appl_verified_on'	=>	getDateFormat($r[$i]->appl_verified_on),
								);
		}
		$payments = array('payments'	=>	$results, 'search_date' =>  $date, 'paginate'	=>	$paginate);
		
		return $payments;		
	}


	function getAllSeatingArrangements($current_page = 1, $per_page = 1) {
		$exam_subject = $_REQUEST['exam_subject'];
		$hall_id = $_REQUEST['hall_id'];
		$exam_id = $_REQUEST['exam_id'];
		
		$where = "cnf_exam_subj.exam_id  = ".$exam_id ;
		
		if($hall_id != null && $hall_id != '' && $hall_id != 'EMPTY'){
			$where .= " AND cnf_exam_subj.hall_id=".$hall_id;
		}
		
		if($exam_subject != null && $exam_subject != '' && $exam_subject != 'EMPTY'){
			$where .= " AND cnf_exam_subj.exam_subject='".$exam_subject."'";
		}
		
		$sql = "SELECT 	pg_appl_candidates.pg_appl_code, 		pg_appl_candidates.pg_appl_name , subj_name pg_appl_subj_name,
						pg_appl_candidates.pg_appl_mobile, 	   	pg_appl_candidates.pg_appl_profile_pic,
						seat_no, roll_no, exam_date, cnf_hall.hall_number, cnf_building.building_name 
				FROM exam_seat_info
				LEFT OUTER JOIN pg_appl_candidates ON pg_appl_candidates.pg_appl_code = exam_seat_info.pg_appl_code
				LEFT OUTER JOIN cnf_exam_subj ON cnf_exam_subj.exam_subj_id = exam_seat_info.exam_subj_id
				LEFT OUTER JOIN cnf_exam ON cnf_exam.exam_id = cnf_exam_subj.exam_id
				LEFT OUTER JOIN cnf_hall ON cnf_hall.hall_id = cnf_exam_subj.hall_id
				LEFT OUTER JOIN cnf_building ON cnf_building.building_id = cnf_hall.building_id
				LEFT OUTER JOIN cnf_subjects ON cnf_subjects.subj_code = cnf_exam_subj.exam_subject
				
				WHERE ".$where;
		
		//get data for pagination
		$total_results = $this->getAllPaymentsByDayCount($sql);
		$total_pages = ceil($total_results / $per_page);
		$offset = ($current_page - 1) * $per_page;
		$paginate = array('total_records'	=>	$total_results,
						  'total_pages'		=>	$total_pages,
						  'current_page'	=>	$current_page,
						  'offset'			=>	$offset
						 );
		$sql .= " ORDER BY cnf_hall.hall_number, subj_name, roll_no";				 
		$sql .= " LIMIT " . $offset . ", " . $per_page;

		//echo $sql; exit();

 		$r = $this->db->query($sql)->result();
 		
		$results = array();	
		
		//print_r($r); exit();
		
		for($i=0; $i<count($r); $i++) {
			$profile_pic_path = $this->config->base_url() . "upload/students/profile_pic/";
			$profile_pic_path .= (($r[$i]->pg_appl_profile_pic != '') ? 't_' .$r[$i]->pg_appl_profile_pic : 'no-profile-pic_90.png');
			
			$results[$i] = array(
									'pg_appl_profile_pic'=>	$profile_pic_path,
									'pg_appl_code'		=>	$r[$i]->pg_appl_code,
									'pg_appl_name'		=>	$r[$i]->pg_appl_name,
									'pg_appl_subj_name'	=>	$r[$i]->pg_appl_subj_name,
									'roll_no'			=>	$r[$i]->roll_no,
									'hall_number'		=>	$r[$i]->hall_number,
									'building_name'		=>	$r[$i]->building_name,
									'seat_no'			=>	$r[$i]->seat_no,
									'pg_appl_mobile'	=>	$r[$i]->pg_appl_mobile,
									'exam_date'			=>	getDateFormat($r[$i]->exam_date)
								);
		}
		$payments = array('payments'	=>	$results, 'paginate'	=>	$paginate);
		
		return $payments;	
	}

	function downloadAllSeatingArrangementsCSV($current_page = 1, $per_page = 1) {
		$this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
		
		$exam_subject = isset($_REQUEST['exam_subject'])?$_REQUEST['exam_subject'] : null;
		$hall_id = isset($_REQUEST['hall_id'])?$_REQUEST['hall_id']:null;
		$exam_id = $_REQUEST['exam_id'];
		
		$file_name = "SEATDETAILS";
		if($exam_subject != null && $exam_subject != '' && $exam_subject != 'EMPTY'){
			$file_name .= "_".$exam_subject; 
		}
		if($hall_id != null && $hall_id != '' && $hall_id != 'EMPTY'){
			$file_name .= "_".$hall_id; 
		}
		
		$where = "cnf_exam_subj.exam_id  = ".$exam_id ;
		
		if($hall_id != null && $hall_id != '' && $hall_id != 'EMPTY'){
			$where .= " AND cnf_exam_subj.hall_id=".$hall_id;
		}
		
		if($exam_subject != null && $exam_subject != '' && $exam_subject != 'EMPTY'){
			$where .= " AND cnf_exam_subj.exam_subject='".$exam_subject."'";
		}
		
		$sql = "SELECT 	pg_appl_candidates.pg_appl_code 'APPLICATION CODE' , pg_appl_candidates.pg_appl_name  'APPLICANT NAME', pg_appl_candidates.pg_appl_mobile 'MOBILE NUMBER', subj_name 'SUBJECT NAME',
						roll_no 'ROLL NO', exam_date 'EXAMINATION DATE', exam_start_time 'EXAMINATION START TIME',  exam_end_time 'EXAMINATION END TIME',  cnf_building.building_name 'BUILDING NAME', cnf_hall.hall_number 'HALL NUMBER'
				FROM exam_seat_info
				LEFT OUTER JOIN pg_appl_candidates ON pg_appl_candidates.pg_appl_code = exam_seat_info.pg_appl_code
				LEFT OUTER JOIN cnf_exam_subj ON cnf_exam_subj.exam_subj_id = exam_seat_info.exam_subj_id
				LEFT OUTER JOIN cnf_exam ON cnf_exam.exam_id = cnf_exam_subj.exam_id
				LEFT OUTER JOIN cnf_hall ON cnf_hall.hall_id = cnf_exam_subj.hall_id
				LEFT OUTER JOIN cnf_building ON cnf_building.building_id = cnf_hall.building_id
				LEFT OUTER JOIN cnf_subjects ON cnf_subjects.subj_code = cnf_exam_subj.exam_subject
				WHERE ".$where;
		$sql .= " ORDER BY cnf_hall.hall_number, subj_name, roll_no";
		
		$query = $this->db->query($sql);
		$delimiter = ",";
        $newline = "\r\n";
        $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
        force_download($file_name.'.csv', $data);		
	}
	
	function downloadAllSeatingArrangementsPDF(){
		$exam_subject 	= $_REQUEST['exam_subject'];
		$hall_id 		= $_REQUEST['hall_id'];
		$exam_id 		= $_REQUEST['exam_id'];
		
		$where = "cnf_exam_subj.exam_id  = ".$exam_id ;
		
		if($hall_id != null && $hall_id != '' && $hall_id != 'EMPTY'){
			$where .= " AND cnf_exam_subj.hall_id=".$hall_id;
		}
		
		if($exam_subject != null && $exam_subject != '' && $exam_subject != 'EMPTY'){
			$where .= " AND cnf_exam_subj.exam_subject='".$exam_subject."'";
		}
		
		$sql = "SELECT 	pg_appl_candidates.pg_appl_code, 		pg_appl_candidates.pg_appl_name , subj_name pg_appl_subj_name,
						pg_appl_candidates.pg_appl_mobile, 	   	pg_appl_candidates.pg_appl_profile_pic,
						seat_no, roll_no, exam_date, cnf_hall.hall_number, cnf_building.building_name 
				FROM exam_seat_info
				LEFT OUTER JOIN pg_appl_candidates ON pg_appl_candidates.pg_appl_code = exam_seat_info.pg_appl_code
				LEFT OUTER JOIN cnf_exam_subj ON cnf_exam_subj.exam_subj_id = exam_seat_info.exam_subj_id
				LEFT OUTER JOIN cnf_exam ON cnf_exam.exam_id = cnf_exam_subj.exam_id
				LEFT OUTER JOIN cnf_hall ON cnf_hall.hall_id = cnf_exam_subj.hall_id
				LEFT OUTER JOIN cnf_building ON cnf_building.building_id = cnf_hall.building_id
				LEFT OUTER JOIN cnf_subjects ON cnf_subjects.subj_code = cnf_exam_subj.exam_subject
				
				WHERE ".$where;
		$sql .= " ORDER BY cnf_hall.hall_number, subj_name, roll_no";	
		$r = $this->db->query($sql)->result();
		
		$results = array();	
		//print_r($r); exit();
		for($i=0; $i<count($r); $i++) {
			$profile_pic_path = $this->config->base_url() . "upload/students/profile_pic/";
			$profile_pic_path .= (($r[$i]->pg_appl_profile_pic != '') ? 't_' .$r[$i]->pg_appl_profile_pic : 'no-profile-pic_90.png');
			
			$results[$i] = array(
									'pg_appl_profile_pic'=>	$profile_pic_path,
									'pg_appl_code'		=>	$r[$i]->pg_appl_code,
									'pg_appl_name'		=>	$r[$i]->pg_appl_name,
									'pg_appl_subj_name'	=>	$r[$i]->pg_appl_subj_name,
									'roll_no'			=>	$r[$i]->roll_no,
									'hall_number'		=>	$r[$i]->hall_number,
									'building_name'		=>	$r[$i]->building_name,
									'seat_no'			=>	$r[$i]->seat_no,
									'pg_appl_mobile'	=>	$r[$i]->pg_appl_mobile,
									'exam_date'			=>	getDateFormat($r[$i]->exam_date)
								);
		}
		
		$sql_subj = "SELECT count(pg_appl_candidates.pg_appl_code) as count,  subj_name pg_appl_subj_name
				FROM exam_seat_info
				LEFT OUTER JOIN pg_appl_candidates ON pg_appl_candidates.pg_appl_code = exam_seat_info.pg_appl_code
				LEFT OUTER JOIN cnf_exam_subj ON cnf_exam_subj.exam_subj_id = exam_seat_info.exam_subj_id
				LEFT OUTER JOIN cnf_exam ON cnf_exam.exam_id = cnf_exam_subj.exam_id
				LEFT OUTER JOIN cnf_hall ON cnf_hall.hall_id = cnf_exam_subj.hall_id
				LEFT OUTER JOIN cnf_building ON cnf_building.building_id = cnf_hall.building_id
				LEFT OUTER JOIN cnf_subjects ON cnf_subjects.subj_code = cnf_exam_subj.exam_subject WHERE ".$where." GROUP BY subj_name";
		$r = $this->db->query($sql_subj)->result();
		$subjects = array();	
		for($i=0; $i<count($r); $i++) {
			$subjects[$i] = array(
									'pg_appl_subj_name'	=>	$r[$i]->pg_appl_subj_name,
									'count'				=>	$r[$i]->count,
								);
		}

		$sql_hall = "SELECT count(pg_appl_candidates.pg_appl_code) as count,  cnf_hall.hall_number hall_name, cnf_building.building_name building
				FROM exam_seat_info
				LEFT OUTER JOIN pg_appl_candidates ON pg_appl_candidates.pg_appl_code = exam_seat_info.pg_appl_code
				LEFT OUTER JOIN cnf_exam_subj ON cnf_exam_subj.exam_subj_id = exam_seat_info.exam_subj_id
				LEFT OUTER JOIN cnf_exam ON cnf_exam.exam_id = cnf_exam_subj.exam_id
				LEFT OUTER JOIN cnf_hall ON cnf_hall.hall_id = cnf_exam_subj.hall_id
				LEFT OUTER JOIN cnf_building ON cnf_building.building_id = cnf_hall.building_id
				LEFT OUTER JOIN cnf_subjects ON cnf_subjects.subj_code = cnf_exam_subj.exam_subject WHERE ".$where." GROUP BY hall_number";
		$r = $this->db->query($sql_hall)->result();
		$halls = array();	
		for($i=0; $i<count($r); $i++) {
			$halls[$i] = array(
									'building'	=>	$r[$i]->building,
									'hall_name'	=>	$r[$i]->hall_name,
									'count'		=>	$r[$i]->count,
								);
		}
		
		$returnResult = array(
								'seats'	=>	$results, 
								'subjects' => $subjects, 
								'halls' => $halls, 
								'univ_logo' => $this->config->base_url() . 'assets/img/bu_logo60.png',
								'schedule'  => $this->getExamSchedule($exam_id)
							);
		
		return $returnResult;	
	}

	function getExamSchedule($exam_id){
		$sql = "SELECT exam_id, exam_date, exam_start_time, exam_end_time FROM cnf_exam WHERE exam_is_active = 1 AND exam_id = ".$exam_id;
		$query = $this->db->query($sql);
		$results = $query->result_array();
		return $results;
	}
	
	
	function getContactNosByCategory(){
		$pg_appl_subj = $this->input->post('pg_subj_code');
		$pg_appl_status = $this->input->post('pg_appl_status');
		$resv = $this->input->post('extra_resv');
		$clause = "";
		if($resv != 'EMPTY' && $resv != ""){
			$resv = strtolower($resv);
			$clause .= " AND pg_appl_".$resv."='Y' ";
		}
		
		$sql = "Select DISTINCT pg_appl_mobile  FROM pg_appl_candidates WHERE pg_appl_subj like '".$pg_appl_subj."' AND pg_appl_status".$pg_appl_status. $clause;
		
		//echo $sql; exit();
		
		$r = $this->db->query($sql)->result();
		$phonenos = ""; 		
		for($i=0; $i<count($r); $i++) {
			if($i == count($r)-1){
				$phonenos .= $r[$i]->pg_appl_mobile;
			}else{
				$phonenos .= $r[$i]->pg_appl_mobile.",";
			}
		}
		return $phonenos;
	}
	
	function getMeritListOption($appl_ctgr = null){
		$sql = "SELECT seat_id, seat_desc, seat_cnt FROM cnf_seat_matrix WHERE seat_subj = '".$appl_ctgr."' AND  seat_cnt > 0 ORDER BY seat_rank_ctgr, seat_resv";
		$query = $this->db->query($sql);
		$results = $query->result_array();
		
        return $results;
	}
	
	
}
?>