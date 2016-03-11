<?php
class Operationmodel extends CI_Model {

    function __construct() {
        parent::__construct();
		$this->load->database();
    }
	
	//create File: Done
	function createFile() {
		$c_tbl = 'pmt_upload_files';
		$created_on = gmdate('Y-m-d');
		$created_by = $this->session->userdata['user']['user_name']; //user id from session

		$uploadfilename = "";
		if (isset($_FILES['userfile'])){
			$uploadfilename = $_FILES['userfile']['name'];
		}
		
		$data = array(
					  'file_name'	=>	$_FILES['userfile']['name'],
				      'file_date'	=>	convertToMySqlDate($this->input->post('file_date')),
				      'file_status' =>  0,
				      'created_on'	=>	$created_on,
				      'created_by'	=>	$created_by,
				      'modified_on'	=>	$created_on,
				      'modified_by'	=>	$created_by
				    );
		$status = $this->db->insert($c_tbl, $data);
		return $status;		
	}
	
	//get all File: Done
	function getAllFiles($status=null) {
		$c_tbl = 'pmt_upload_files';
		$this->db->select(array('file_id', 'file_name', 'file_date', 'file_status', 'processed_on'));
		$this->db->from($c_tbl);
		if($status != null){
			$this->db->where('file_status', $status);
		}
		$this->db->order_by('file_date', 'asc'); 
		$this->db->order_by('file_name', 'asc'); 
		
		$query = $this->db->get();
		$results = $query->result();
		
		$records = array();
		for($i=0; $i<count($results); $i++){
			$records[$i] = array(
							 'file_id'     		=> $results[$i]->file_id,
							 'file_name'     	=> $results[$i]->file_name,
							 'file_date'	   	=> getDateFormat($results[$i]->file_date, 'd-m-Y'),
							 'file_status'		=> $results[$i]->file_status,
							 'file_status_name'	=> _getFileStatus($results[$i]->file_status),
							 'processed_on'	    => getDateFormat($results[$i]->processed_on, 'd-m-Y'),
						 );
		}
		return $records;
	}
	
	//delete File: Done
	function deleteFile($id = null) {
		$puf_tbl = 'pmt_upload_files';
		$ppi_tbl = 'pmt_prcs_info';
		
		$status = TRUE;
		$this->db->trans_begin();
		$this->db->delete($puf_tbl, array('file_id' => $id));
		if ($this->db->trans_status() === FALSE) {
			$status = FALSE;
		}
		
		$this->db->delete($ppi_tbl, array('pmt_file_id' => $id));
		if ($this->db->trans_status() === FALSE) {
			$status = FALSE;
		}
		
		if ($status === FALSE) {
		    $this->db->trans_rollback();
			$this->db->trans_complete();			
			return "NOTDELETED";
		} else {
		    $this->db->trans_commit();
			$this->db->trans_complete();
			return "DELETED";
		}
	}	
	
	function processFile($id){
		$process_file_path = $this->config->base_url()."upload/payments/";
		$processed_on = gmdate('Y-m-d');
		$processed_by = $this->session->userdata['user']['user_name']; //user id from session
		
		//Fetch the filename from database
		$c_tbl = 'pmt_upload_files';
		$this->db->select(array('file_id', 'file_name', 'file_date'));
		$this->db->from($c_tbl);
		$this->db->where('file_id', $id);
		
		$query = $this->db->get();
		$results = $query->result_array();
		
		$status = TRUE;
		
		if(count($results) >0){
			$csv_file_id			= $results[0]['file_id'];
			$csv_file_name			= $results[0]['file_name'];
			$csv_file_upload_date 	= $results[0]['file_date'];
			$pmt_prcs_on			= $processed_on;
			$pmt_prcs_by			= $processed_by;
			
			$process_data = getRecordFromCSV($process_file_path.$csv_file_name);
			
			$this->db->trans_begin();
			
			$row_num = 0;
			foreach ($process_data as $line) {
				//verifyy the document header for better restriction....
				if($row_num > 0){
					//$header = array('Application Code', 'Application Name', 'Mobile Number', 'Payment Number', 'Payment Date');
					$insert_data = array(
											'pmt_file'		=>  $csv_file_name,
											'pmt_file_id'	=>  $csv_file_id,
											'appl_code'		=> strtoupper(trim($line[0])),
											'appl_name'		=> $line[1],
											'appl_mobile'		=> $line[2],
											'pmt_code'		=> strtoupper(trim($line[3])),
											'pmt_date'		=> $line[4],
											
											'pmt_prcs_status'=> 0,
											'pmt_prcs_on'=> $pmt_prcs_on,
											'pmt_prcs_by'=> $pmt_prcs_by,
										);	
					$this->db->insert('pmt_prcs_info', $insert_data);
					if ($this->db->trans_status() === FALSE) {
						$status = FALSE;
					}
				}	
				$row_num++;
			}
					
			if ($status === TRUE) {
				$update_data = array('file_status'=> 1, 'processed_on'=>$pmt_prcs_on);
				$this->db->where('file_id', $id);
				$this->db->update('pmt_upload_files', $update_data);
			}
			//echo $status; 
			//echo $this->db->last_query();
			//exit();
			
			if ($status === FALSE) {
			    $this->db->trans_rollback();
				$this->db->trans_complete();
				return 'NOTPROCESS';
			} else {
			    $this->db->trans_commit();
				$this->db->trans_complete();
				return 'PROCESS';
			}
		}
		
	}

	//get all File: Done
	function getAllProcessFiles() {
		$c_tbl = 'pmt_upload_files';
		$this->db->select(array('file_id', 'file_name', 'file_date', 'file_status', 'processed_on'));
		$this->db->from($c_tbl);
		$this->db->where('file_status', 1);
		$this->db->or_where('file_status', 2);
		$this->db->order_by('file_date', 'asc'); 
		$this->db->order_by('file_name', 'asc'); 
		
		$query = $this->db->get();
		$results = $query->result();
		
		$records = array();
		for($i=0; $i<count($results); $i++){
			$sql_1 = "select * from pmt_prcs_info where pmt_file_id = ".$results[$i]->file_id;
			$sql_2 = "select * from pmt_prcs_info where pmt_file_id = ".$results[$i]->file_id . " and pmt_prcs_status=0";
			
			$records[$i] = array(
							 'file_id'     		=> $results[$i]->file_id,
							 'file_date'	   	=> getDateFormat($results[$i]->file_date, 'd-m-Y'),
							 'file_name'     	=> $results[$i]->file_name,
							 'processed_on'	    => getDateFormat($results[$i]->processed_on, 'd-m-Y'),
							 'file_status'		=> $results[$i]->file_status,
							 'file_status_name'	=> _getFileStatus($results[$i]->file_status),
							 'total_record'	=> $this->getRowCount($sql_1),
							 'unprocess_record'	=> $this->getRowCount($sql_2),
							 
						 );
		}
		return $records;
	}

	function processPayments($id=null){
		   	
		   	$processed_on = gmdate('Y-m-d');
			$processed_by = $this->session->userdata['user']['user_name']; //user id from session
		
		    $status = TRUE;
			//1. fetch all the record based on id from pmt_process_info table
			//2. Iterate the loop and macthed with main table if row update is happen in main table then update the process table or else dont update
			
			$sql = "select * from pmt_prcs_info where pmt_file_id = ".$id;
			
			
			//Fetch the payment records from database
			$c_tbl = 'pmt_prcs_info';
			$this->db->select(array('pmt_id', 'appl_code', 'pmt_code'));
			$this->db->from($c_tbl);
			$this->db->where('pmt_file_id', $id);
			
			$query = $this->db->get();
			$results = $query->result_array();
			
		
			//print_r($results); exit();
			
		
			$this->db->trans_begin();
			if(count($results) >0){
				for($i=0; $i<count($results); $i++){
					$update_data = array(
											'pg_appl_status'		=> 2, 
											'pg_appl_pmt_code'		=>$results[$i]['pmt_code'] , 
											'pg_appl_verified_by'	=>$processed_by , 
											'pg_appl_verified_on'	=>$processed_on
										);
					$this->db->where('pg_appl_code', $results[$i]['appl_code']);
					$this->db->update('pg_appl_candidates', $update_data);
					if ($this->db->trans_status() === FALSE) {
						$status = FALSE;
					}
					
					$cnt= $this->db->affected_rows();
					
					//echo "<br/>".$results[$i]['appl_code'];
					
					if($cnt > 0){
						//update pmt process info table
						$u_data = array('pmt_prcs_status' =>1);
						$this->db->where('pmt_id', $results[$i]['pmt_id']);
						$this->db->update('pmt_prcs_info', $u_data);
						if ($this->db->trans_status() === FALSE) {
							$status = FALSE;
						}
					}
				}
			}
			//exit();
			
			if ($status === TRUE) {
				$update_data = array('file_status'=> 2, 'processed_on'=>$processed_on);
				$this->db->where('file_id', $id);
				$this->db->update('pmt_upload_files', $update_data);
			}
			if ($status === FALSE) {
			    $this->db->trans_rollback();
				$this->db->trans_complete();
				return 'ERROR';
			} else {
			    $this->db->trans_commit();
				$this->db->trans_complete();
				return 'SUCCESS';
			}
	}


	function getNonVerifiedRecordById($id = null){
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		
		$delimeter = ",";
		$newline = "\r\n";
		$enclosure = "";
		
		$sql = 'select file_name from pmt_upload_files where file_id = '. $id;
		$query = $this->db->query($sql);
		$results = $query->result();
		$file_name = "";
		if(count($results) > 0){
			$file_name = $results[0]->file_name;
		}
		$file_name = "PROCESS-".$file_name;
		
		
		$select_sql = 'select appl_code AS "Application Code", appl_name AS "Application Name", appl_mobile AS "Mobile Number", pmt_code AS "Instrument Number" from pmt_prcs_info where pmt_file_id = '.$id .' and pmt_prcs_status != 1';
		$select_query = $this->db->query($select_sql);
		
		$data = $this->dbutil->csv_from_result($select_query, $delimeter, $newline, $enclosure);
		force_download($file_name, $data);
	}


	function getAllExamSubjectsInfo(){
		$sql1 = "SELECT subj_code, subj_name FROM cnf_pgsubj WHERE subj_code in 
				(	SELECT distinct exam_subject
					FROM cnf_exam_subj
					JOIN exam_seat_info ON exam_seat_info.exam_subj_id = cnf_exam_subj.exam_subj_id 
				)  
				ORDER BY subj_name";
		$query1 = $this->db->query($sql1);
		$dropdowns1 = $query1->result();
		$dropDownList1['EMPTY'] = "";
        foreach($dropdowns1 as $dropdown1)
        {
        	$dropDownList1[$dropdown1->subj_code] = $dropdown1->subj_name;
        }
		
		$sql2 = "SELECT subj_code, subj_name FROM cnf_pgsubj WHERE subj_code not in 
				(	SELECT distinct exam_subject
					FROM cnf_exam_subj
					WHERE `exam_subj_id` in (select distinct exam_subj_id from exam_seat_info)
				)  
				ORDER BY subj_name";
		$query2 = $this->db->query($sql2);
		$dropdowns2 = $query2->result();
		$dropDownList2['EMPTY'] = "";
        foreach($dropdowns2 as $dropdown2)
        {
        	$dropDownList2[$dropdown2->subj_code] = $dropdown2->subj_name;
        }
		
		$data = array('process'=>$dropDownList1, 'nonprocess'=>$dropDownList2);
		
		return $data;
	}
	
	function RevokeSeatSubject(){
		$sql = "DELETE from exam_seat_info WHERE exam_subj_id IN 
			   (SELECT DISTINCT exam_subj_id FROM cnf_exam_subj WHERE exam_subject like '".$this->input->post('revoke_subj_code')."')";
		$status = $this->db->query($sql);
		return $status;
	}
	
	function ProcessSeatSubject(){
		$subj_code =  $this->input->post('process_subj_code');
		
		
		
		$sql_cand = "SELECT pg_appl_code, pg_appl_name, pg_appl_mobile FROM pg_appl_candidates WHERE pg_appl_status >= 2 AND pg_appl_subj like '".$subj_code."' ";
		$query_cand = $this->db->query($sql_cand);
		$result_cand = $query_cand->result_array();
		
		$sql_exam = "SELECT exam_id, exam_subj_id, seat_cnt FROM cnf_exam_subj WHERE exam_subject like '".$subj_code."'";
		$query_exam = $this->db->query($sql_exam);
		$result_exam = $query_exam->result_array();
		
		
		//TRANSACTION START	
		$this->db->trans_begin();
		$status = TRUE;
		
		//DELETE ALL ENROLLED SUBJECTS
		$sql = "DELETE from exam_seat_info WHERE exam_subj_id IN 
			   (SELECT DISTINCT exam_subj_id FROM cnf_exam_subj WHERE exam_subject like '".$this->input->post('process_subj_code')."')";
		$this->db->query($sql);
		if ($this->db->trans_status() === FALSE) {
			$status = FALSE;
		}
		
		$index = 0;
		for($i=0; $i<count($result_exam); $i++){
			
			$seat_cnt = $result_exam[$i]['seat_cnt'];
			
			for($j=0; $j<$seat_cnt; $j++){
				$insert_data = array(
									'pg_appl_code'	=>  $result_cand[$index]['pg_appl_code'],
									'pg_appl_phone'	=>  $result_cand[$index]['pg_appl_mobile'],
									'exam_subj_id'	=>  $result_exam[$i]['exam_subj_id']
									);	
				$this->db->insert('exam_seat_info', $insert_data);
				if ($this->db->trans_status() === FALSE) {
					$status = FALSE;
				}
				$index++;
			}
		}
		
		if ($status === FALSE) {
		    $this->db->trans_rollback();
			$this->db->trans_complete();
			return false;
		} else {
		    $this->db->trans_commit();
			$this->db->trans_complete();
			return true;
		}	
		//TRANSACTION END
		
				
	}
	
	function ValidateSeatSubject(){
		$sql = "SELECT * FROM pg_appl_candidates WHERE pg_appl_status >= 2 AND pg_appl_subj like '".$this->input->post('process_subj_code')."'";	
		$total_student = $this-> getRowCount($sql);
		
		$sql = "SELECT sum(seat_cnt) SEAT_COUNT FROM cnf_exam_subj WHERE exam_is_active = 1 AND exam_subject like '".$this->input->post('process_subj_code')."'";	
		$query = $this->db->query($sql);
		$result = $query->result_array();
		$alloted_seat = $result[0]['SEAT_COUNT'];
		
		if($total_student == $alloted_seat){
			return true;
		}else{
			return false;
		}
	}
	
	//alocate roll number to individual student
	function allocateRollNumber(){
		$this->output->enable_profiler(TRUE);
		$c_tbl = 'cnf_pgsubj';
		$this->db->select(array('subj_id', 'subj_code'));
		$this->db->from($c_tbl);
		$query = $this->db->get();
		$results = $query->result();
		
		$status = TRUE;
		$this->db->trans_begin();
		
		foreach($results as $result)
        {
        	$subj_code = $result->subj_code;
			$subj_id   = $result->subj_id;
			$startRollNo = startingExamRollNumber($subj_id); 
			
			//echo $startRollNo; exit();
			
			$sql = "SELECT exam_seat_id 
			        FROM exam_seat_info 
			        JOIN cnf_exam_subj ON cnf_exam_subj.exam_subj_id = exam_seat_info.exam_subj_id
			        WHERE cnf_exam_subj.exam_subject like '".$subj_code."'";
			 
        	$query = $this->db->query($sql);
			$results = $query->result();
			
			//print_r($results); //continue; 
			
	        foreach($results as $result){
				$data = array('roll_no'	=>	$startRollNo);
				$this->db->where('exam_seat_id',$result->exam_seat_id);	
				$status = $this->db->update('exam_seat_info', $data);
				
				//echo $this->db->last_query(); 
				
				$startRollNo++;
				if ($this->db->trans_status() === FALSE) {
					$status = FALSE;
				}
			}
        }
		//exit();
		
		if ($status === FALSE) {
		    $this->db->trans_rollback();
			$this->db->trans_complete();
			return false;
		} else {
		    $this->db->trans_commit();
			$this->db->trans_complete();
			return true;
		}	
		
	}
	
	function revokeRollNumber(){
		$c_tbl = 'cnf_pgsubj';
		$this->db->select(array('subj_id', 'subj_code'));
		$this->db->from($c_tbl);
		$query = $this->db->get();
		$results = $query->result();
		
		$status = TRUE;
		$this->db->trans_begin();
		
		foreach($results as $result)
        {
        	$subj_code = $result->subj_code;
			$subj_id   = $result->subj_id;
			$startRollNo = 0; 
			
			$sql = "SELECT exam_seat_id 
			        FROM exam_seat_info 
			        JOIN cnf_exam_subj ON cnf_exam_subj.exam_subj_id = exam_seat_info.exam_subj_id
			        WHERE cnf_exam_subj.exam_subject like '".$subj_code."'";
			 
        	$query = $this->db->query($sql);
			$results = $query->result();
			
	        foreach($results as $result){
				$data = array('roll_no'	=>	$startRollNo);
				$this->db->where('exam_seat_id',$result->exam_seat_id);	
				$this->db->update('exam_seat_info', $data);
				
				if ($this->db->trans_status() === FALSE) {
					$status = FALSE;
				}
			}
        }
		if ($status === FALSE) {
		    $this->db->trans_rollback();
			$this->db->trans_complete();
			return false;
		} else {
		    $this->db->trans_commit();
			$this->db->trans_complete();
			return true;
		}
	}

	function getRowCount($sql) {
		$results = $this->db->query($sql)->result();
		return count($results);
	}
	
}
?>