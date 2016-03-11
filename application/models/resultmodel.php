<?php
class Resultmodel extends CI_Model {
    function __construct() {
        parent::__construct();
		$this->load->database();
		$ci = get_instance();
		$ci->load->helper('string');
    }
	
	
	function getNonGenaratedMeritSubject($ctgry=null){
		$sql = "SELECT DISTINCT seat_subj subj_code, subj_name FROM cnf_seat_matrix 
				JOIN cnf_subjects ON cnf_subjects.subj_code = cnf_seat_matrix.seat_subj
				WHERE  seat_subj not in 
				(SELECT DISTINCT pg_appl_subj FROM cnf_merit_generation WHERE status='1' AND pg_appl_ctgry like '".$ctgry."')";
		$query = $this->db->query($sql);
		$dropdowns = $query->result();
		$dropDownList = array();
		$dropDownList['EMPTY'] = "";
        foreach($dropdowns as $dropdown)
        {
        	$dropDownList[$dropdown->subj_code] = $dropdown->subj_name;
        }
    	$finalDropDown = $dropDownList;
        return $finalDropDown;
	}
	
	function getGenaratedMeritSubject($ctgry = null){
		$sql = "SELECT DISTINCT pg_appl_subj subj_code, subj_name 
				FROM cnf_merit_generation 
				JOIN cnf_subjects ON cnf_subjects.subj_code = cnf_merit_generation.pg_appl_subj
				WHERE status='1' AND pg_appl_ctgry like '".$ctgry."'";
		$query = $this->db->query($sql);
		$dropdowns = $query->result();
		$dropDownList = array();
		$dropDownList['EMPTY'] = "";
        foreach($dropdowns as $dropdown)
        {
        	$dropDownList[$dropdown->subj_code] = $dropdown->subj_name;
        }
    	$finalDropDown = $dropDownList;
        return $finalDropDown;
	}

	//************************  QUERY FORMATION ******************************* : START
	
	function getSeatMatrixList($subject_code, $rank_ctgr){
		$sql = "SELECT * FROM cnf_seat_matrix WHERE seat_rank_ctgr like '".$rank_ctgr."' AND seat_subj like '".$subject_code."' AND seat_is_active = '1' AND seat_cnt > 0";
		$query = $this->db->query($sql);
		$results = $query->result_array();
		return $results;
	}
	
	function getSeatMatrixDetailsById($merit_type_no){
		$sql = "SELECT * FROM cnf_seat_matrix WHERE seat_id='".$merit_type_no."'";
		$query = $this->db->query($sql);
		$results = $query->result_array();
		if(count($results) == 1){
			$results = $results[0];	
		}
		return $results;
	}
	
	function getSubjectClause($arrays){
		$str = " AND pg_appl_subj like '". $arrays['seat_subj'] ."'";
		return $str;
	}
	
	function getReservationClause($arrays){
		$str = '';
		if(strtoupper($arrays['seat_resv']) != strtoupper('gen')){
			$str = " AND pg_appl_reservation like '". $arrays['seat_resv'] ."'";
		}
		return $str;
	}
	
	function getExtraReservationClause($arrays){
		$str = '';
		if(strtoupper($arrays['seat_resv_extra']) == 'PWD'){
			$str = " AND pg_appl_pwd = 'Y'";
		}else if(strtoupper($arrays['seat_resv_extra']) == 'SPORTS'){
			$str = " AND pg_appl_sports = 'Y'";
		}
		else if( strtoupper($arrays['seat_resv_extra']) == 'HONS'){
			$str = " AND pg_appl_grad_major_subj = '".$arrays['seat_subj']."'";
		}
		return $str;
	}
	
	function getApplicationCategory($arrays){
		$str = '';
		if($arrays['seat_rank_ctgr'] == '60PCT'){
			$str = " AND pg_appl_ctgr like 'BU'";
		}
		return $str;
	}
	
	function getWrittenMarksGtZero($arrays){
		$str = '';
		if($arrays['seat_rank_ctgr'] == '40PCT'){
			$str = " AND pg_appl_written_score > 0";
		}
		return $str;
	}
	
	function getOrderByClause($arrays){
		$str = '';
		if($arrays['seat_rank_ctgr'] == '60PCT'){
			$str = " ORDER BY pg_appl_merit_score  DESC";
		}else
		if($arrays['seat_rank_ctgr'] == '40PCT'){
			$str = " ORDER BY pg_appl_written_score DESC, pg_appl_merit_score  DESC";
		}
		 
		return $str;
	}
	
	//************************  QUERY FORMATION ******************************* : END
	
	function ProcessMeritList($ctgry = null){
		$subj_code = $this->input->post('process_subj_code');
		//echo $subj_code; echo $ctgry; exit();
		$info_seat_matrix = $this->getSeatMatrixList($subj_code, $ctgry);	
		
		//print_r($info_seat_matrix); exit();
		
		//echo count($info_seat_matrix); exit();
		
		
		//TRANSACTION START
		$status = TRUE;
		$this->db->trans_begin();
		
		for($i=0; $i<count($info_seat_matrix); $i++){
			
			$sql = "SELECT * FROM pg_appl_candidates WHERE  pg_appl_status >= 2 ";
			$sql .= $this->getSubjectClause($info_seat_matrix[$i]);			
			$sql .= $this->getReservationClause($info_seat_matrix[$i]);
			$sql .= $this->getExtraReservationClause($info_seat_matrix[$i]);
			$sql .= $this->getApplicationCategory($info_seat_matrix[$i]);
			$sql .= $this->getWrittenMarksGtZero($info_seat_matrix[$i]);
			$sql .= $this->getOrderByClause($info_seat_matrix[$i]);
			
			//echo $sql . "<br/>"; exit();
			
			$query = $this->db->query($sql);
			$result = $query->result_array();
	
			//print_r($result) . "<br/>"; exit();
	
			$resv_col = 'pg_appl_'.$info_seat_matrix[$i]['seat_rank_ctgr'].'_'.$info_seat_matrix[$i]['seat_resv'].'_merit';
			
			if($info_seat_matrix[$i]['seat_resv_extra'] == 'PWD'){
				$resv_col = 'pg_appl_'.$info_seat_matrix[$i]['seat_rank_ctgr'].'_pwd_merit';
			}else
			if($info_seat_matrix[$i]['seat_resv_extra'] == 'SPORTS'){
				$resv_col = 'pg_appl_'.$info_seat_matrix[$i]['seat_rank_ctgr'].'_sports_merit';
			}else
			if($info_seat_matrix[$i]['seat_resv_extra'] == 'HONS'){
				$resv_col = 'pg_appl_'.$info_seat_matrix[$i]['seat_rank_ctgr'].'_hons_merit';
			}
			$resv_col = strtolower($resv_col);
			
			
			$total_record = count($result);
			for($index=0; $index < $total_record; $index++){
				$appl_sl_no = $result[$index]['pg_appl_sl_num'];
				
				$pg_appl_status = "";
				if($ctgry == '60PCT'){
					$pg_appl_status='pg_appl_status = 4';
				}else if($ctgry == '40PCT'){
					$pg_appl_status='pg_appl_status = 4';
				}
				
				$updateSQL = "UPDATE pg_appl_candidates SET ".$pg_appl_status.", " . $resv_col  . "=" . ($index+1) . ", ".$resv_col."_ctgr=".$info_seat_matrix[$i]['seat_id']." WHERE pg_appl_sl_num=" . $appl_sl_no; 
				//echo $updateSQL . "<br/>"; continue; exit();
				$flag = $this->db->query($updateSQL);
				//echo $flag;
				if ($this->db->trans_status() === FALSE) {
					$status = FALSE;
				}
			}// end of updation
			
			//update the count and status in cnf_seat_matrix table
			if($status === TRUE){
				$csi_tbl = 'cnf_seat_matrix';
				$data = array('cand_cnt'=>	$total_record,   'prcs_status'=>	'1' );
				$this->db->where('seat_id', $info_details_array[$i]['seat_id'] );	
				$this->db->update($csi_tbl, $data);
				if ($this->db->trans_status() === FALSE) {
					$status = FALSE;
				}
			}// end of update seat info table
		
		}// Emd of all type of seat info record operation
		
		//update merit generation table for further update : START
		if($status === TRUE){
			$modified_on = gmdate('Y-m-d H:i:s');
			$modified_by = $this->session->userdata['user']['user_name'];
			$cmg_tbl = 'cnf_merit_generation';
			
			$data = array('pg_appl_subj'	=>	$subj_code,
						  'pg_appl_ctgry'	=>	$ctgry,
						  'status'		=>	'1',
					      'generated_on'=>	$modified_on,
					      'generated_by'=>	$modified_by
						  );
						  
			$this->db->insert($cmg_tbl, $data);
			if ($this->db->trans_status() === FALSE) {
				$status = FALSE;
			}
		}
		//update merit generation table for further update : END
		//TRANSACTION END
		if ($status === FALSE) {
		    $this->db->trans_rollback();
		} else {
		    $this->db->trans_commit();
		}
		return $status;
	}
	
	
	
	
	function RevokeMeritList($ctgry = null){
		
		$subj_code = $this->input->post('revoke_subj_code');
		//echo $subj_code; echo $ctgry; exit();
		$info_seat_matrix = $this->getSeatMatrixList($subj_code, $ctgry);	
		//print_r($info_seat_matrix); exit();
		
		
		//TRANSACTION START
		$status = TRUE;
		$this->db->trans_begin();
		
		for($i=0; $i<count($info_seat_matrix); $i++){
			$sql = "SELECT * FROM pg_appl_candidates WHERE  pg_appl_status >= 3 ";
			$sql .= $this->getSubjectClause($info_seat_matrix[$i]);			
			$sql .= $this->getReservationClause($info_seat_matrix[$i]);
			$sql .= $this->getExtraReservationClause($info_seat_matrix[$i]);
			$sql .= $this->getApplicationCategory($info_seat_matrix[$i]);
			$sql .= $this->getOrderByClause($info_seat_matrix[$i]);
			
			//echo $sql . "<br/>"; continue; exit();
			
			$query = $this->db->query($sql);
			$result = $query->result_array();
	
			//print_r($result) . "<br/>"; exit();
	
			$resv_col = 'pg_appl_'.$info_seat_matrix[$i]['seat_rank_ctgr'].'_'.$info_seat_matrix[$i]['seat_resv'].'_merit';
			
			if($info_seat_matrix[$i]['seat_resv_extra'] == 'PWD'){
				$resv_col = 'pg_appl_'.$info_seat_matrix[$i]['seat_rank_ctgr'].'_pwd_merit';
			}else
			if($info_seat_matrix[$i]['seat_resv_extra'] == 'SPORTS'){
				$resv_col = 'pg_appl_'.$info_seat_matrix[$i]['seat_rank_ctgr'].'_sports_merit';
			}else
			if($info_seat_matrix[$i]['seat_resv_extra'] == 'HONS'){
				$resv_col = 'pg_appl_'.$info_seat_matrix[$i]['seat_rank_ctgr'].'_hons_merit';
			}
			$resv_col = strtolower($resv_col);
			
			
			$total_record = count($result);
			for($index=0; $index < $total_record; $index++){
				$appl_sl_no = $result[$index]['pg_appl_sl_num'];
				
				$updateSQL = "UPDATE pg_appl_candidates SET pg_appl_status=3, " . $resv_col  . "=0, ".$resv_col."_ctgr=0 WHERE pg_appl_sl_num=" . $appl_sl_no; 
				//echo $updateSQL . "<br/>"; continue; exit();
				$flag = $this->db->query($updateSQL);
				//echo $flag;
				if ($this->db->trans_status() === FALSE) {
					$status = FALSE;
				}
			}// end of updation
			
			//update the count and status in cnf_seat_matrix table
			if($status === TRUE){
				$csi_tbl = 'cnf_seat_matrix';
				$data = array('cand_cnt'=>	'0',   'prcs_status'=>	'0' );
				$this->db->where('seat_id', $info_details_array[$i]['seat_id'] );	
				$this->db->update($csi_tbl, $data);
				if ($this->db->trans_status() === FALSE) {
					$status = FALSE;
				}
			}// end of update seat info table
		
		}// Emd of all type of seat info record operation
		
		//update merit generation table for further update : START
		if($status === TRUE){
			$modified_on = gmdate('Y-m-d H:i:s');
			$modified_by = $this->session->userdata['user']['user_name'];
			$cmg_tbl = 'cnf_merit_generation';
			
			$data = array('pg_appl_subj'	=>	$subj_code,
						  'pg_appl_ctgry'	=>	$ctgry,
						  'status'		=>	'0',
					      'generated_on'=>	$modified_on,
					      'generated_by'=>	$modified_by
						  );
			$this->db->where('pg_appl_ctgry', $ctgry );		
			$this->db->where('pg_appl_subj', $subj_code );			  
			$this->db->update($cmg_tbl, $data);			  
			if ($this->db->trans_status() === FALSE) {
				$status = FALSE;
			}
		}
		//update merit generation table for further update : END
		//TRANSACTION END
		if ($status === FALSE) {
		    $this->db->trans_rollback();
		} else {
		    $this->db->trans_commit();
		}
		return $status;
	}
	
	
	
	function getMeritLists($subj_code, $ctgry, $per_page = 50){
		
  		$info_seat_matrix = $this->getSeatMatrixList($subj_code, $ctgry);	
		
		$return_result = array();
		
		for($i=0; $i<count($info_seat_matrix); $i++){
				
			$col_merit_ctgr = "pg_appl_".$info_seat_matrix[$i]['seat_rank_ctgr']."_". $info_seat_matrix[$i]['seat_resv'] ."_merit_ctgr";
			$col_merit 		= "pg_appl_".$info_seat_matrix[$i]['seat_rank_ctgr']."_". $info_seat_matrix[$i]['seat_resv'] ."_merit";
			$resv_code		=  $info_seat_matrix[$i]['seat_resv'] ;
			$extra_resv_code=  $info_seat_matrix[$i]['seat_resv_extra'] ;
			
			if($info_seat_matrix[$i]['seat_resv_extra'] == 'PWD'){
				$col_merit = 'pg_appl_'.$info_seat_matrix[$i]['seat_rank_ctgr'].'_pwd_merit';
				$col_merit_ctgr = 'pg_appl_'.$info_seat_matrix[$i]['seat_rank_ctgr'].'_pwd_merit_ctgr';
			}else
			if($info_seat_matrix[$i]['seat_resv_extra'] == 'SPORTS'){
				$col_merit = 'pg_appl_'.$info_seat_matrix[$i]['seat_rank_ctgr'].'_sports_merit';
				$col_merit_ctgr = 'pg_appl_'.$info_seat_matrix[$i]['seat_rank_ctgr'].'_sports_merit_ctgr';
			}else
			if($info_seat_matrix[$i]['seat_resv_extra'] == 'HONS'){
				$col_merit = 'pg_appl_'.$info_seat_matrix[$i]['seat_rank_ctgr'].'_hons_merit';
				$col_merit_ctgr = 'pg_appl_'.$info_seat_matrix[$i]['seat_rank_ctgr'].'_hons_merit_ctgr';
			}
			$col_merit_ctgr = strtolower($col_merit_ctgr);
			$col_merit 		= strtolower($col_merit);
			

			$sql = "SELECT * FROM pg_appl_candidates 
							 WHERE pg_appl_status >= 3 AND pg_appl_subj like '".$subj_code."' AND 
							 	   " . $col_merit_ctgr . " = ". $info_seat_matrix[$i]['seat_id'] ." AND " . $col_merit . " > 0 
							 ORDER BY " . $col_merit . " DESC";
			
			//echo "<br/>" . $sql ."<br/>"; continue; exit();
			
			$total_results = $this->getTotalResultPageCount($sql);
			$total_pages = ceil($total_results / $per_page);
			
			$return_result[$i]['description'] = $info_seat_matrix[$i]['seat_desc'];
			$return_result[$i]['sl_no'] 	  = $info_seat_matrix[$i]['seat_id'];
			$return_result[$i]['total_record']= $total_results;
			$return_result[$i]['total_pages']= $total_pages;
			$return_result[$i]['seat_ctgry']  = $ctgry;
			$return_result[$i]['reservation'] = $resv_code;
			$return_result[$i]['extra_reservation'] = $extra_resv_code;
			$return_result[$i]['no_of_seats'] = $info_seat_matrix[$i]['seat_cnt'];
			if($extra_resv_code == 'PWD' || $extra_resv_code =='SPORTS' || $extra_resv_code == 'HONS'){
				$return_result[$i]['reservation'] = $extra_resv_code;
			}
		}
		
		//print_r($return_result); exit();
		
		return $return_result;
  	}

	function getMeritListData($resv, $merit_type_no, $seat_ctgry, $page=1, $per_page=50){
		$col_merit 		= strtolower("pg_appl_".$seat_ctgry."_".$resv."_merit");
		$col_merit_ctgr = strtolower("pg_appl_".$seat_ctgry."_".$resv."_merit_ctgr");
		
		$sql = "SELECT 	pg_appl_sl_num, 
						pg_appl_code, 
						pg_appl_ctgr, 
					  	A.subj_name pg_subject_name, 
					  	B.subj_name ug_subject_name, 
					  	pg_appl_subj, 
					  	pg_appl_name, 
					  	pg_appl_grad_pct,
					  	pg_appl_written_score,
					  	resv_name,
					  	" .  $col_merit  . " as resv_merit 
					  	FROM pg_appl_candidates
				LEFT OUTER JOIN  cnf_subjects A ON A.subj_code = pg_appl_subj 
				LEFT OUTER JOIN  cnf_subjects B ON B.subj_code = pg_appl_grad_major_subj 
				LEFT OUTER JOIN cnf_reservation on resv_code=pg_appl_reservation ";
		$sql .= " WHERE " . $col_merit_ctgr . " = " . $merit_type_no . "  AND pg_appl_status>=3 ORDER BY " . $col_merit . " ASC";
				
		$total_results = $this->getTotalResultPageCount($sql);
		$total_pages = ceil($total_results / $per_page);

		$sql .= " LIMIT " . ($page-1)*$per_page . ", " . $per_page;

		$r = $this->db->query($sql)->result();
		
		//print_r($r); exit();
		
		$data = array();
		
		for($i=0; $i<count($r); $i++) {
				$data[$i]=array('pg_appl_sl_num' 	=>	$r[$i]->pg_appl_sl_num,
								'pg_appl_code'		=>	$r[$i]->pg_appl_code,
								'pg_appl_ctgr'		=>	$r[$i]->pg_appl_ctgr,
								'pg_subject_name'	=>	$r[$i]->pg_subject_name,
								'ug_subject_name'	=>	$r[$i]->ug_subject_name,
								'pg_appl_subj'		=>	$r[$i]->pg_appl_subj,
								'pg_appl_name'		=>	$r[$i]->pg_appl_name,
								'pg_appl_grad_pct'	=>	$r[$i]->pg_appl_grad_pct,
								'pg_appl_written_score'		=>	$r[$i]->pg_appl_written_score,
								'resv_merit'		=>	$r[$i]->resv_merit,
								'resv_name'			=>	$r[$i]->resv_name,
								'PAGENO'			=>	$page,
								'TOTALPAGES'		=>	$total_pages
							);
		}
		
		$info_details_array = $this->getSeatInfoDetailsById($merit_type_no);
		
		$resv_name 			= $this->configmodel->getReservationNameByCode($resv);
		$subject_code	 	= $info_details_array['seat_subj'];
		$subject_name 		= $this->configmodel->getSubjectNameByCode($subject_code);
		$seat_ctgry			= $info_details_array['seat_rank_ctgr'];
		$seat_ctgry_name	= _getMeritCategory($seat_ctgry);
		
		$info['resv_code'] 		= $resv;
		$info['resv_name'] 		= $resv_name;
		$info['seat_ctgry'] 	= $seat_ctgry;
		$info['seat_ctgry_name']= $seat_ctgry_name;
		$info['subject_code'] 	= $subject_code;
		$info['subject_name'] 	= $subject_name;
		$info['description'] 	= $info_details_array['seat_desc'];
		$info['seat_cnt'] 		= $info_details_array['seat_cnt'];
		
		//$data['info'] = $info;
		
		//print_r($info); exit();
		
		return array("data"	=>	$data, 'info' => $info); 			
	}
	
	
	function downloadSelectedCandidateRankFromTo(){
		$this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
	   
	   $subj_code 	= $_REQUEST['subj_code'];
	   $merit_type 	= $_REQUEST['merit_type'];
	   $start_rank 	= $_REQUEST['start_rank'];
	   $end_rank 	= $_REQUEST['end_rank'];
	   
	   $info_seat_matrix = $this->getSeatMatrixDetailsById($merit_type);	
		
	   //print_r($info_seat_matrix); exit();
		
		$return_result = array();
		
	   //echo count($info_seat_matrix);
		
			//$i=0;
			$col_merit_ctgr = "pg_appl_".$info_seat_matrix['seat_rank_ctgr']."_". $info_seat_matrix['seat_resv'] ."_merit_ctgr";
			$col_merit 		= "pg_appl_".$info_seat_matrix['seat_rank_ctgr']."_". $info_seat_matrix['seat_resv'] ."_merit";
			$resv_code		=  $info_seat_matrix['seat_resv'] ;
			$extra_resv_code=  $info_seat_matrix['seat_resv_extra'] ;
			
			if($info_seat_matrix['seat_resv_extra'] == 'PWD'){
				$col_merit = 'pg_appl_'.$info_seat_matrix['seat_rank_ctgr'].'_pwd_merit';
				$col_merit_ctgr = 'pg_appl_'.$info_seat_matrix['seat_rank_ctgr'].'_pwd_merit_ctgr';
			}else
			if($info_seat_matrix['seat_resv_extra'] == 'SPORTS'){
				$col_merit = 'pg_appl_'.$info_seat_matrix['seat_rank_ctgr'].'_sports_merit';
				$col_merit_ctgr = 'pg_appl_'.$info_seat_matrix['seat_rank_ctgr'].'_sports_merit_ctgr';
			}else
			if($info_seat_matrix['seat_resv_extra'] == 'HONS'){
				$col_merit = 'pg_appl_'.$info_seat_matrix['seat_rank_ctgr'].'_hons_merit';
				$col_merit_ctgr = 'pg_appl_'.$info_seat_matrix['seat_rank_ctgr'].'_hons_merit_ctgr';
			}
			$col_merit_ctgr = strtolower($col_merit_ctgr);
			$col_merit 		= strtolower($col_merit);
			
			$sql = "SELECT  pg_appl_name as 'APPLICANT NAME', pg_appl_ctgr as 'APPLICATION CATEGORY', pg_appl_code as 'APPLICATION CODE', pg_appl_mobile as 'MOBILE NO',  resv_name as  'RESERVATION', subj_name as 'GRADUATION SUBJECT', ". $col_merit . " AS RANK
							 FROM pg_appl_candidates 
							 JOIN cnf_reservation ON resv_code = pg_appl_reservation 
							 JOIN cnf_pgsubj ON subj_code = pg_appl_grad_major_subj 
							 WHERE pg_appl_status >= 3 AND pg_appl_subj like '".$subj_code."' AND 
							 	   " . $col_merit_ctgr . " = ". $info_seat_matrix['seat_id'] 
							 	  ." AND " . $col_merit . " >= ". $start_rank ." AND " . $col_merit . " <= ". $end_rank ." 
							 ORDER BY " . $col_merit . " DESC";
			
			//echo "<br/>" . $sql ."<br/>"; exit();//
			$query = $this->db->query($sql);
			$delimiter = ",";
	        $newline = "\r\n";
	        $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
	        force_download('CSV_Notification_Report.csv', $data);

	        		    //$results = $query->result_array();
			//$header = array('APPLICANT NAME', 'APPLICATION CATEGORY', 'APPLICATION CODE', 'MOBILE NO', 'RESERVATION', 'GRADUATION SUBJECT', 'RANK');
		    //return array('header'=> $header, 'result'=> $results, 'title' => $info_seat_matrix['seat_desc']);
	}

	
	function getSelectedCandidateRankFromToMobileNo(){
		$this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
	   
	   $subj_code 	= $_REQUEST['subj_code'];
	   $merit_type 	= $_REQUEST['merit_type'];
	   $start_rank 	= $_REQUEST['start_rank'];
	   $end_rank 	= $_REQUEST['end_rank'];
	   
	   $info_seat_matrix = $this->getSeatMatrixDetailsById($merit_type);	
		
	   //print_r($info_seat_matrix); exit();
		
		$return_result = array();
		
	   //echo count($info_seat_matrix);
		
			//$i=0;
			$col_merit_ctgr = "pg_appl_".$info_seat_matrix['seat_rank_ctgr']."_". $info_seat_matrix['seat_resv'] ."_merit_ctgr";
			$col_merit 		= "pg_appl_".$info_seat_matrix['seat_rank_ctgr']."_". $info_seat_matrix['seat_resv'] ."_merit";
			$resv_code		=  $info_seat_matrix['seat_resv'] ;
			$extra_resv_code=  $info_seat_matrix['seat_resv_extra'] ;
			
			if($info_seat_matrix['seat_resv_extra'] == 'PWD'){
				$col_merit = 'pg_appl_'.$info_seat_matrix['seat_rank_ctgr'].'_pwd_merit';
				$col_merit_ctgr = 'pg_appl_'.$info_seat_matrix['seat_rank_ctgr'].'_pwd_merit_ctgr';
			}else
			if($info_seat_matrix['seat_resv_extra'] == 'SPORTS'){
				$col_merit = 'pg_appl_'.$info_seat_matrix['seat_rank_ctgr'].'_sports_merit';
				$col_merit_ctgr = 'pg_appl_'.$info_seat_matrix['seat_rank_ctgr'].'_sports_merit_ctgr';
			}else
			if($info_seat_matrix['seat_resv_extra'] == 'HONS'){
				$col_merit = 'pg_appl_'.$info_seat_matrix['seat_rank_ctgr'].'_hons_merit';
				$col_merit_ctgr = 'pg_appl_'.$info_seat_matrix['seat_rank_ctgr'].'_hons_merit_ctgr';
			}
			$col_merit_ctgr = strtolower($col_merit_ctgr);
			$col_merit 		= strtolower($col_merit);
			
			$sql = "SELECT  pg_appl_mobile FROM pg_appl_candidates 
							 WHERE pg_appl_status >= 3 AND pg_appl_subj like '".$subj_code."' AND 
							 	   " . $col_merit_ctgr . " = ". $info_seat_matrix['seat_id'] 
							 	  ." AND " . $col_merit . " >= ". $start_rank ." AND " . $col_merit . " <= ". $end_rank ." 
							 ORDER BY " . $col_merit . " DESC";
			
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
	
	function getSeatInfoDetailsById($merit_type_no){
		$sql = "SELECT * FROM cnf_seat_matrix WHERE seat_id=".$merit_type_no."";
		$query = $this->db->query($sql);
		$results = $query->result_array();
		if(count($results) == 1){
			$results = $results[0];	
		}
		return $results;
	}
	
	function getTotalResultPageCount($sql) {
		$results = $this->db->query($sql)->result();
		return count($results);
	}
		
}
?>