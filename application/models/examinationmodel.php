<?php
class Examinationmodel extends CI_Model {
    function __construct() {
        parent::__construct();
		$this->load->database();
		$ci = get_instance();
		$ci->load->helper('string');
    }
    
    // ********************  EXAMINATION SCHEDULE : START ********************
	function createExamSchedule() {
		$c_tbl = 'cnf_exam_subj';
		$data = array(
					  'exam_id'			=>$this->input->post('exam_id'),
				      'hall_id'	=>	$this->input->post('hall_id'),
				      'exam_subject'	=>	$this->input->post('exam_subject'),
				      'seat_cnt'	=>	$this->input->post('seat_cnt'),
				      'exam_is_active'	=>	($this->input->post('exam_is_active') == 'on') ? 1 : 0
				    );
		
		//print_r($data); exit();
		
		$status = $this->db->insert($c_tbl, $data);
		return $status;		
	}
	
	
	function updateExamSchedule() {
		$c_tbl = 'cnf_exam_subj';
		$data = array(
					  'exam_id'			=>$this->input->post('exam_id'),
				      'hall_id'	=>	$this->input->post('hall_id'),
				      'exam_subject'	=>	$this->input->post('exam_subject'),
				      'seat_cnt'	=>	$this->input->post('seat_cnt'),
				      'exam_is_active'	=>	($this->input->post('exam_is_active') == 'on') ? 1 : 0
				    );
		$this->db->where('exam_subj_id', $this->input->post('record_id'));					
		$status = $this->db->update($c_tbl, $data);
		return $status;		
	}	
	
	function deleteExamSchedule($id) {
		//echo $id; exit();
		$c_tbl = 'cnf_exam_subj';
		$this->db->delete($c_tbl, array('exam_subj_id' => $id)); 
		return "DELETED";
	}		
	
	function getAllExamSchedules() {
		$c_tbl = 'cnf_exam_subj';
		
		$sql = "SELECT 
						exam_subj_id, cnf_exam_subj.exam_id, cnf_exam_subj.hall_id, exam_subject, seat_cnt, cnf_exam_subj.exam_is_active,
						exam_date, exam_start_time, exam_end_time, 
						hall_number, hall_capacity,  cnf_hall.building_id, building_name, subj_name 
				FROM cnf_exam_subj 
				LEFT OUTER JOIN cnf_exam ON cnf_exam.exam_id = cnf_exam_subj.exam_id
				LEFT OUTER JOIN cnf_subjects ON cnf_subjects.subj_code = cnf_exam_subj.exam_subject
				LEFT OUTER JOIN cnf_hall ON cnf_hall.hall_id = cnf_exam_subj.hall_id
				LEFT OUTER JOIN cnf_building ON cnf_building.building_id = cnf_hall.building_id
				ORDER BY exam_date";
		
		$query = $this->db->query($sql);
		$r = $query->result();
		
		$results = array();	
		
		for($i=0; $i<count($r); $i++) {
			$results[$i] = array(
									'exam_subj_id' 			=>	$r[$i]->exam_subj_id,
									'exam_id' 			=>	$r[$i]->exam_id,
									'hall_id' 			=>	$r[$i]->hall_id,
									'exam_subject' 			=>	$r[$i]->exam_subject,
									'seat_cnt' 			=>	$r[$i]->seat_cnt,
									'exam_is_active' 			=>	$r[$i]->exam_is_active,
									'hall_number' 			=>	$r[$i]->hall_number,
									'hall_capacity' 			=>	$r[$i]->hall_capacity,
									'building_id' 			=>	$r[$i]->building_id,
									'building_name' 			=>	$r[$i]->building_name,
									'subj_name' 			=>	$r[$i]->subj_name,
									'exam_date_time' 		=> 	getDateFormat($r[$i]->exam_date, 'd-m-Y')." (" . $r[$i]->exam_start_time . " - " . $r[$i]->exam_end_time . ")",
								);
		}
		
		return $results;
	}
	
	function getSearchExamSchedules($exam_id, $exam_subject , $hall_id) {
								
		$c_tbl = 'cnf_exam_subj';
		
		$where = "";
		if($exam_id != null && $exam_id != 'null'){
			$where .= " AND cnf_exam_subj.exam_id='".$exam_id."'";	
		}
		if($exam_subject != null && $exam_subject != 'null'){
			$where .= " AND exam_subject='".$exam_subject."'";
		}
		if($hall_id != null && $hall_id != 'null'){
			$where .= " AND cnf_exam_subj.hall_id='".$hall_id."'";			
		}
		
		$sql = "SELECT 
						exam_subj_id, cnf_exam_subj.exam_id, cnf_exam_subj.hall_id, exam_subject, seat_cnt, cnf_exam_subj.exam_is_active,
						exam_date, exam_start_time, exam_end_time, 
						hall_number, hall_capacity,  cnf_hall.building_id, building_name, subj_name 
				FROM cnf_exam_subj 
				LEFT OUTER JOIN cnf_exam ON cnf_exam.exam_id = cnf_exam_subj.exam_id
				LEFT OUTER JOIN cnf_subjects ON cnf_subjects.subj_code = cnf_exam_subj.exam_subject
				LEFT OUTER JOIN cnf_hall ON cnf_hall.hall_id = cnf_exam_subj.hall_id
				LEFT OUTER JOIN cnf_building ON cnf_building.building_id = cnf_hall.building_id
				WHERE 1=1 ".$where."
				ORDER BY exam_subject, cnf_exam_subj.exam_id, cnf_exam_subj.hall_id";
		
		$query = $this->db->query($sql);
		$r = $query->result();
		
		$results = array();	
		
		for($i=0; $i<count($r); $i++) {
			$results[$i] = array(
									'exam_subj_id' 			=>	$r[$i]->exam_subj_id,
									'exam_id' 			=>	$r[$i]->exam_id,
									'hall_id' 			=>	$r[$i]->hall_id,
									'exam_subject' 			=>	$r[$i]->exam_subject,
									'seat_cnt' 			=>	$r[$i]->seat_cnt,
									'exam_is_active' 			=>	$r[$i]->exam_is_active,
									'hall_number' 			=>	$r[$i]->hall_number,
									'hall_capacity' 			=>	$r[$i]->hall_capacity,
									'building_id' 			=>	$r[$i]->building_id,
									'building_name' 			=>	$r[$i]->building_name,
									'subj_name' 			=>	$r[$i]->subj_name,
									'exam_date_time' 		=> 	getDateFormat($r[$i]->exam_date, 'd-m-Y')." (" . $r[$i]->exam_start_time . " - " . $r[$i]->exam_end_time . ")",
								);
		}
		
		return $results;
	}
	
	function unAllocatedSubjectSeat(){
		//total candidates
		$sql1 = "select count(*) TOTAL_COUNT from pg_appl_candidates where pg_appl_status >= 2 AND pg_appl_subj like '".$_REQUEST['exam_subject']."'";	
		$query1 = $this->db->query($sql1);
		$result1 = $query1->result_array();
		$TOTAL_COUNT = 0;
		if(count($result1) > 0){
			$TOTAL_COUNT = $result1[0]['TOTAL_COUNT'];
		}
		
		
		//allocated seats for that subject
		$sql2 = "select sum(seat_cnt) SEAT_COUNT from cnf_exam_subj where exam_is_active=1 AND exam_subject like '".$_REQUEST['exam_subject']."'";
		$query2 = $this->db->query($sql2);
		$result2 = $query2->result_array();
		$SEAT_COUNT = $result2[0]['SEAT_COUNT'];
		
		return ($TOTAL_COUNT - $SEAT_COUNT);
	}
	
	function unreservedHallSeat(){
		//total hall size from hall table
		$sql1 = "select hall_capacity TOTAL_COUNT from cnf_hall where hall_id = ".$_REQUEST['hall_id'];	
		$query1 = $this->db->query($sql1);
		$result1 = $query1->result_array();
		$TOTAL_COUNT = 0;
		if(count($result1) > 0){
			$TOTAL_COUNT = $result1[0]['TOTAL_COUNT'];
		}
		
		
		//allocated seats to that hall in that schedule
		$sql2 = "select sum(seat_cnt) SEAT_COUNT from cnf_exam_subj where hall_id = ".$_REQUEST['hall_id']." AND  exam_id  = '".$_REQUEST['exam_id']."'";
		
		$query2 = $this->db->query($sql2);
		$result2 = $query2->result_array();
		$SEAT_COUNT = $result2[0]['SEAT_COUNT'];
		
		//echo $TOTAL_COUNT . "<br/>". $SEAT_COUNT;  exit();
		
		return ($TOTAL_COUNT - $SEAT_COUNT);
	}
	// ********************  EXAMINATION SCHEDULE : END***********************
}
?>