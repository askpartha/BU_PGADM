<?php
class Configmodel extends CI_Model {

    function __construct() {
        parent::__construct();
		$this->load->database();
		$this->load->model('staticconfigmodel');
		$ci = get_instance();
		$ci->load->helper('string');
    }
	
	//************* STATE : START ***********
	function getStateOptionWithoutCode() {
		$sql = "SELECT state_name FROM cnf_states ORDER BY state_name";
		$query = $this->db->query($sql);
		$dropdowns = $query->result();
		$dropDownList['EMPTY'] = "";
        foreach($dropdowns as $dropdown)
        {
        	$dropDownList[$dropdown->state_name] = $dropdown->state_name;
        }
    	$finalDropDown = $dropDownList;
        return $finalDropDown;
	}
	
	function getStateOptionWithCode() {
		$sql = "SELECT state_name, state_code FROM cnf_states ORDER BY state_name";
		$query = $this->db->query($sql);
		$dropdowns = $query->result();
		$dropDownList['EMPTY'] = "";
        foreach($dropdowns as $dropdown)
        {
        	$dropDownList[$dropdown->state_code] = $dropdown->state_name;
        }
    	$finalDropDown = $dropDownList;
        return $finalDropDown;
	}
	
	function getStateNameByCode($state_code){
		$sql = "SELECT DISTINCT state_name FROM state_name WHERE state_code = '".$state_code."'";
		$query = $this->db->query($sql);
		$results = $query->result();
		$state_name = "";
		if(count($results) > 0){
			$state_name = $results[0]->state_name;
		}
		return $state_name;
	}
	//************* STATE : END ***********
	
	
	
	//************* SESSION : START ***********
	function createSession() {
		$c_tbl = 'cnf_sess';
		$data = array(
				      'sess_val'		=>	$this->input->post('sess_val'),
				      'sess_is_active'	=>	($this->input->post('sess_is_active') == 'on') ? 1 : 0
				    );
		$status = $this->db->insert($c_tbl, $data);
		return $status;		
	}
	
	function updateSession() {
		$c_tbl = 'cnf_sess';
		$data = array(
				      'sess_val'		=>	$this->input->post('sess_val'),
				      'sess_is_active'	=>	($this->input->post('sess_is_active') == 'on') ? 1 : 0
				    );
		$this->db->where('sess_id', $this->input->post('record_id'));					
		$status = $this->db->update($c_tbl, $data);
		return $status;		
	}	
	
	function deleteSession($id) {
		$c_tbl = 'cnf_sess';
		$this->db->delete($c_tbl, array('sess_id' => $id)); 
		return "DELETED";
	}
	
	function getAllSessions() {
		$c_tbl = 'cnf_sess';
		$this->db->select(array('sess_id', 'sess_val', 'sess_is_active'));
		$this->db->from($c_tbl);
		$this->db->order_by('sess_val', 'desc'); 
		//$this->db->limit($per_page, $offset);
		$query = $this->db->get();
		$results = $query->result();
		return $results;
	}
	
	function getActiveSession(){
		$sql = "SELECT sess_val FROM cnf_sess WHERE sess_is_active = 1 ORDER BY sess_val DESC";
		$query = $this->db->query($sql);
		$results = $query->result();
		$sess_val = "";
		if(count($results) > 0){
			$sess_val = $results[0]->stasess_valte_name;
		}
		return $sess_val;
	}
	
	function getSessionOptions() {
		$sql = "SELECT sess_val, sess_val FROM cnf_sess WHERE sess_is_active = 1 ORDER BY sess_val DESC";
		$query = $this->db->query($sql);
		$dropdowns = $query->result();
		//$dropDownList['EMPTY'] = "";
		$dropDownList = array();
        foreach($dropdowns as $dropdown)
        {
        	$dropDownList[$dropdown->sess_val] = $dropdown->sess_val;
        }
    	$finalDropDown = $dropDownList;
        return $finalDropDown;
	}	
	//************* SESSION : END ***********
	
	
	
	//************* RELIGION : START ***********
	function createreligion() {
		$c_tbl = 'cnf_religion';
		$data = array(
				      'relg_val'		=>	$this->input->post('relg_val'),
				      'relg_weight'		=>	$this->input->post('relg_weight'),
				      'relg_is_active'	=>	($this->input->post('relg_is_active') == 'on') ? 1 : 0
				    );
		$status = $this->db->insert($c_tbl, $data);
		return $status;		
	}
	
	function updatereligion() {
		$c_tbl = 'cnf_religion';

				$data = array(
				      'relg_val'	=>	$this->input->post('relg_val'),
				      'relg_weight'		=>	$this->input->post('relg_weight'),
				      'relg_is_active'	=>	($this->input->post('relg_is_active') == 'on') ? 1 : 0
				    );
		$this->db->where('relg_id', $this->input->post('record_id'));					
		$status = $this->db->update($c_tbl, $data);
		return $status;		
	}	
	
	function deletereligion($id) {
		$c_tbl = 'cnf_religion';
		$this->db->delete($c_tbl, array('relg_id' => $id)); 
		return "DELETED";
	}	
	
	function getAllreligions() {
		$c_tbl = 'cnf_religion';
		$this->db->select(array('relg_id', 'relg_val', 'relg_weight', 'relg_is_active'));
		$this->db->from($c_tbl);
		$this->db->order_by('relg_weight', 'asc'); 
		//$this->db->limit($per_page, $offset);
		$query = $this->db->get();
		$results = $query->result();
		return $results;
	}
	
	function getReligionOptions() {
		$sql = "SELECT relg_val FROM cnf_religion WHERE relg_is_active = 1 ORDER BY relg_weight, relg_val DESC";
		$query = $this->db->query($sql);
		$dropdowns = $query->result();
		$dropDownList['EMPTY'] = "";
		$dropDownList = array();
        foreach($dropdowns as $dropdown)
        {
        	$dropDownList[$dropdown->relg_val] = $dropdown->relg_val;
        }
    	$finalDropDown = $dropDownList;
        return $finalDropDown;
	}
	//************* RELIGION : END ***********
	
	
	
	//************* RESERVATION : START ***********
	function createReservation() {
		$c_tbl = 'cnf_reservation';
		$data = array(
					  'resv_code'		=>	$this->input->post('resv_code'),
				      'resv_name'		=>	$this->input->post('resv_name'),
				      'resv_weight'		=>	$this->input->post('resv_weight'),
				      'resv_is_active'	=>	($this->input->post('resv_is_active') == 'on') ? 1 : 0
				    );
		$status = $this->db->insert($c_tbl, $data);
		return $status;		
	}
	
	function updateReservation() {
		$c_tbl = 'cnf_reservation';

		$data = array(
				      'resv_code'		=>	$this->input->post('resv_code'),
				      'resv_name'		=>	$this->input->post('resv_name'),
				      'resv_weight'		=>	$this->input->post('resv_weight'),
				      'resv_is_active'	=>	($this->input->post('resv_is_active') == 'on') ? 1 : 0
				    );
		$this->db->where('resv_id', $this->input->post('record_id'));					
		$status = $this->db->update($c_tbl, $data);
		return $status;		
	}	
	
	function deleteReservation($id) {
		$c_tbl = 'cnf_reservation';
		$this->db->delete($c_tbl, array('resv_id' => $id)); 
		return "DELETED";
	}		

	function getAllReservations() {
		$c_tbl = 'cnf_reservation';
		$this->db->select(array('resv_id', 'resv_code', 'resv_name', 'resv_weight', 'resv_is_active'));
		$this->db->from($c_tbl);
		$this->db->order_by('resv_weight', 'asc'); 
		$query = $this->db->get();
		$results = $query->result();
		return $results;
	}
	
	function getReservationOptions() {
		$sql = "SELECT resv_code, resv_name FROM cnf_reservation WHERE resv_is_active = 1 ORDER BY resv_weight, resv_id";
		$query = $this->db->query($sql);
		$dropdowns = $query->result();
		$dropDownList = array();
		//$dropDownList['EMPTY'] = "";
        foreach($dropdowns as $dropdown)
        {
        	$dropDownList[$dropdown->resv_code] = $dropdown->resv_name;
        }
    	$finalDropDown = $dropDownList;
        return $finalDropDown;
	}
	
	//************* RESERVATION : END ***********
	
	
	
	//************* COURSE : START ***********
	function createCourse() {
		$c_tbl = 'cnf_course';
		$data = array(
					  'cors_code'		=>	$this->input->post('cors_code'),
				      'cors_name'		=>	$this->input->post('cors_name'),
				      'cors_weight'		=>	$this->input->post('cors_weight'),
				      'cors_is_active'	=>	($this->input->post('cors_is_active') == 'on') ? 1 : 0
				    );
		$status = $this->db->insert($c_tbl, $data);
		return $status;		
	}
	
	function updateCourse() {
		$c_tbl = 'cnf_course';
		$data = array(
				      'cors_code'		=>	$this->input->post('cors_code'),
				      'cors_name'		=>	$this->input->post('cors_name'),
				      'cors_weight'		=>	$this->input->post('cors_weight'),
				      'cors_is_active'	=>	($this->input->post('cors_is_active') == 'on') ? 1 : 0
				    );
		$this->db->where('cors_id', $this->input->post('record_id'));					
		$status = $this->db->update($c_tbl, $data);
		return $status;		
	}	
	
	function deleteCourse($id) {
		$c_tbl = 'cnf_course';
		$this->db->delete($c_tbl, array('cors_id' => $id)); 
		return "DELETED";
	}		
	
	function getAllCourses() {
		$c_tbl = 'cnf_course';
		$this->db->select(array('cors_id', 'cors_code', 'cors_name', 'cors_weight', 'cors_is_active'));
		$this->db->from($c_tbl);
		$this->db->order_by('cors_weight', 'asc'); 
		$query = $this->db->get();
		$results = $query->result();
		return $results;
	}
	
	function getCourseOptions() {
		$sql = "SELECT cors_code, cors_name FROM cnf_course WHERE cors_is_active = 1 ORDER BY cors_weight";
		$query = $this->db->query($sql);
		$dropdowns = $query->result();
		$dropDownList['EMPTY'] = "";
        foreach($dropdowns as $dropdown)
        {
        	$dropDownList[$dropdown->cors_code] = $dropdown->cors_name;
        }
    	$finalDropDown = $dropDownList;
        return $finalDropDown;
	}
	//************* COURSE : END ***********
	
	
	
	//************* COLLEGE : START ***********
	function createCollege() {
		$c_tbl = 'cnf_college';
		$data = array(
					  'col_code'		=>	$this->input->post('col_code'),
				      'col_name'		=>	$this->input->post('col_name'),
				      'col_ctgry'		=>	$this->input->post('col_ctgry'),
				      'col_address'		=>	$this->input->post('col_address'),
				      'col_city'		=>	$this->input->post('col_city'),
				      'col_state'		=>	$this->input->post('col_state'),
				      'col_phone'		=>	$this->input->post('col_phone'),
				      'col_email'		=>	$this->input->post('col_email'),
				      'col_is_active'	=>	($this->input->post('col_is_active') == 'on') ? 1 : 0
				    );
		$status = $this->db->insert($c_tbl, $data);
		return $status;		
	}
	
	function updateCollege() {
		$c_tbl = 'cnf_college';
		$data = array(
				      'col_code'		=>	$this->input->post('col_code'),
				      'col_name'		=>	$this->input->post('col_name'),
				      'col_ctgry'		=>	$this->input->post('col_ctgry'),
				      'col_address'	=>	$this->input->post('col_address'),
				      'col_city'		=>	$this->input->post('col_city'),
				      'col_state'		=>	$this->input->post('col_state'),
				      'col_phone'		=>	$this->input->post('col_phone'),
				      'col_email'		=>	$this->input->post('col_email'),
				      'col_is_active'	=>	($this->input->post('col_is_active') == 'on') ? 1 : 0
				    );
		$this->db->where('col_id', $this->input->post('record_id'));					
		$status = $this->db->update($c_tbl, $data);
		return $status;		
	}	
	
	function deleteCollege($id) {
		$c_tbl = 'cnf_college';
		$this->db->delete($c_tbl, array('col_id' => $id)); 
		return "DELETED";
	}	
	
	function getAllColleges() {
		$c_tbl = 'cnf_college';
		$this->db->select(array('col_id', 'col_code', 'col_name', 'col_ctgry', 'col_address', 'col_city', 'col_state', 'col_phone', 'col_email', 'col_is_active'));
		$this->db->from($c_tbl);
		$this->db->order_by('col_code', 'asc'); 
		//$this->db->limit($per_page, $offset);
		$query = $this->db->get();
		$results = $query->result();
		return $results;
	}
	
	function getCollegeOptions() {
		$sql = "SELECT col_code, col_name, col_ctgry FROM cnf_college WHERE col_is_active = 1 ORDER BY col_id";
		$query = $this->db->query($sql);
		$dropdowns = $query->result();
		$dropDownList['EMPTY'] = "";
        foreach($dropdowns as $dropdown)
        {
        	$dropDownList[$dropdown->col_code] = $dropdown->col_name;
        }
    	$finalDropDown = $dropDownList;
        return $finalDropDown;
	}
	//************* COLLEGE : END ***********
	
	
	
	//************* ORGANIZATION : START *********
	function createOrganization() {
		$c_tbl = 'cnf_organizations';
		$data = array(
				      'organization_name'		=>	$this->input->post('organization_name'),
				      'organization_state'		=>	$this->input->post('organization_state'),
				      'organization_ctgry'		=>	$this->input->post('organization_ctgry'),
				      'organization_is_active'	=>	($this->input->post('organization_is_active') == 'on') ? 1 : 0
				    );
		$status = $this->db->insert($c_tbl, $data);
		return $status;		
	}
	
	function updateOrganization() {
		$c_tbl = 'cnf_organizations';
		$data = array(
				      'organization_name'		=>	$this->input->post('organization_name'),
				      'organization_state'		=>	$this->input->post('organization_state'),
				      'organization_ctgry'		=>	$this->input->post('organization_ctgry'),
				      'organization_is_active'	=>	($this->input->post('organization_is_active') == 'on') ? 1 : 0
				    );
		$this->db->where('organization_id', $this->input->post('record_id'));					
		$status = $this->db->update($c_tbl, $data);
		return $status;		
	}	
	
	function deleteOrganization($id) {
		$c_tbl = 'cnf_organizations';
		$this->db->delete($c_tbl, array('organization' => $id)); 
		return "DELETED";
	}	
		
	function getAllOrganizations() {
		$c_tbl = 'cnf_organizations';
		$this->db->select(array('organization_id', 'organization_name', 'organization_state', 'organization_ctgry',  'organization_is_active'));
		$this->db->from($c_tbl);
		$this->db->order_by('organization_ctgry', 'asc');
		$this->db->order_by('organization_state', 'asc');
		$this->db->order_by('organization_name', 'asc'); 
		//$this->db->limit($per_page, $offset);
		$query = $this->db->get();
		$results = $query->result();
		return $results;
	}

	function getAllOrganizationsByCriteria($ctgry=null, $state=null, $name=null) {
		$c_tbl = 'cnf_organizations';
		$this->db->select(array('organization_id', 'organization_name', 'organization_state', 'organization_ctgry',  'organization_is_active'));
		$this->db->from($c_tbl);
		if($ctgry != null && $ctgry != ''){
			$this->db->where('organization_ctgry', $ctgry);
		}
		if($state != null && $state != ''){
			$this->db->where('organization_state', $state);
		}
		if($name != null && $name != ''){
			$this->db->where('UPPER(organization_name)', strtoupper($name));
		}
		//$this->db->where('organization_is_active', 1);
		
		$this->db->order_by('organization_name', 'asc'); 
		$query = $this->db->get();
		$results = $query->result();
		
		return $results;
	}
	
	function getAllOrganizationsOptionByCriteria($ctgry) {
		$sql = "SELECT organization_id, organization_name, organization_state FROM cnf_organizations WHERE organization_is_active = 1 AND organization_ctgry = '".$ctgry."'ORDER BY organization_state, organization_name ";
		$query = $this->db->query($sql);
		$dropdowns = $query->result();
		$dropDownList['EMPTY'] = "";
        foreach($dropdowns as $dropdown)
        {
        	$dropDownList[$dropdown->organization_id] = $dropdown->organization_state . "-->" . $dropdown->organization_name;
        }
    	$finalDropDown = $dropDownList;
        return $finalDropDown;
		
	}
	
	function getOrganizationsNameById($organization_id){
		$sql = "SELECT DISTINCT organization_name FROM cnf_organizations WHERE organization_id = '".$organization_id."'";
		$query = $this->db->query($sql);
		$results = $query->result();
		$organization_name = "";
		if(count($results) > 0){
			$organization_name = $results[0]->organization_name;
		}
		return $organization_name;
	}
	//************* ORGANIZATION : END ***********
	
	
	
	//**************  SUBJECT : START  ************
	function getAllSubjects() {
		$c_tbl = 'cnf_subjects';
		
		$this->db->select(array('subj_id', 'subj_code', 'subj_name', 'subj_is_active'));
		$this->db->from($c_tbl);
		$this->db->order_by('subj_name', 'asc'); 
		$query = $this->db->get();
		$results = $query->result();
		return $results;
	}
	
	function createSubject() {
		$c_tbl = 'cnf_subjects';
		$data = array(
					  'subj_code'		=>	$this->input->post('subj_code'),
				      'subj_name'		=>	$this->input->post('subj_name'),
				      'subj_is_active'	=>	($this->input->post('subj_is_active') == 'on') ? 1 : 0,
				    );
		$status = $this->db->insert($c_tbl, $data);
		return $status;		
	}
	
	function updateSubject() {
		$c_tbl = 'cnf_subjects';
		$data = array(
				      'subj_code'		=>	$this->input->post('subj_code'),
				      'subj_name'		=>	$this->input->post('subj_name'),
				      'subj_is_active'	=>	($this->input->post('subj_is_active') == 'on') ? 1 : 0,
				    );
		$this->db->where('subj_id', $this->input->post('record_id'));					
		$status = $this->db->update($c_tbl, $data);
		return $status;		
	}	
	
	function deleteSubject($id) {
		$c_tbl = 'cnf_subjects';
		$this->db->delete($c_tbl, array('subj_id' => $id)); 
		//also association need to be deleted
		return "DELETED";
	}

	function getSubjectNameByCode($subj_code){
		$sql = "SELECT DISTINCT subj_name FROM cnf_subjects WHERE subj_code = '".$subj_code."'";
		$query = $this->db->query($sql);
		$results = $query->result();
		$subj_name = "";
		if(count($results) > 0){
			$subj_name = $results[0]->subj_name;
		}
		return $subj_name;
	}
	
	function getSubjectOptions() {
		$sql = "SELECT subj_code, subj_name FROM cnf_subjects WHERE subj_is_active = 1 ORDER BY subj_name";
		$query = $this->db->query($sql);
		$dropdowns = $query->result();
		$dropDownList['EMPTY'] = "";
        foreach($dropdowns as $dropdown)
        {
        	$dropDownList[$dropdown->subj_code] = $dropdown->subj_name;
        }
    	$finalDropDown = $dropDownList;
        return $finalDropDown;
	}
	//**************  SUBJECT : END  ************	
	
	
	//**************  BUILDING : START  ************
	function createBuilding() {
		$c_tbl = 'cnf_building';
		$data = array(
					  'building_name'		=>	$this->input->post('building_name'),
				      'building_address'		=>	$this->input->post('building_address'),
				      'building_is_active'	=>	($this->input->post('building_is_active') == 'on') ? 1 : 0,
				    );
		$status = $this->db->insert($c_tbl, $data);
		return $status;		
	}
	
	function updateBuilding() {
		$c_tbl = 'cnf_building';
		$data = array(
					  'building_name'		=>	$this->input->post('building_name'),
				      'building_address'		=>	$this->input->post('building_address'),
				      'building_is_active'	=>	($this->input->post('building_is_active') == 'on') ? 1 : 0,
				    );
		$this->db->where('building_id', $this->input->post('record_id'));					
		$status = $this->db->update($c_tbl, $data);
		return $status;		
	}	
	
	function deleteBuilding($id) {
		$c_tbl = 'cnf_building';
		$this->db->delete($c_tbl, array('building_id' => $id)); 
		//also association need to be deleted
		return "DELETED";
	}

	function getBuildingtNameById($building_id){
		$sql = "SELECT DISTINCT building_name FROM cnf_building WHERE building_id = '".$building_id."'";
		$query = $this->db->query($sql);
		$results = $query->result();
		$building_name = "";
		if(count($results) > 0){
			$building_name = $results[0]->building_name;
		}
		return $building_name;
	}
	
	function getAllBuildings() {
		$c_tbl = 'cnf_building';
		
		$this->db->select(array('building_id', 'building_name ', 'building_address', 'building_is_active'));
		$this->db->from($c_tbl);
		$this->db->order_by('building_name', 'asc'); 
		$query = $this->db->get();
		$results = $query->result();
		return $results;
	}
	
	function getBuildingtById($building_id){
		$sql = "SELECT DISTINCT building_name, building_address FROM cnf_building WHERE building_id = '".$building_id."'";
		$query = $this->db->query($sql);
		$results = $query->result_array();
		return $results;
	}
	
	function getBuildingOptions() {
		$sql = "SELECT building_id, building_name FROM cnf_building WHERE building_is_active = 1 ORDER BY building_name";
		$query = $this->db->query($sql);
		$dropdowns = $query->result();
		$dropDownList['EMPTY'] = "";
        foreach($dropdowns as $dropdown)
        {
        	$dropDownList[$dropdown->building_id] = $dropdown->building_name;
        }
    	$finalDropDown = $dropDownList;
        return $finalDropDown;
	}
	//**************  BUILDING : END  ************	
	
	
	//**************  Hall : START  ************
	function createHall() {
		$c_tbl = 'cnf_hall';
		$data = array(
					  'building_id'		=>	$this->input->post('building_id'),
				      'hall_number'		=>	$this->input->post('hall_number'),
				      'hall_row_num'		=>	$this->input->post('hall_row_num'),
				      'hall_column_num'		=>	$this->input->post('hall_column_num'),
				      'hall_per_unit_seat'		=>	$this->input->post('hall_per_unit_seat'),
				      'hall_capacity'		=>	$this->input->post('hall_capacity'),
				      'hall_is_active'	=>	($this->input->post('hall_is_active') == 'on') ? 1 : 0,
				    );
		$status = $this->db->insert($c_tbl, $data);
		return $status;		
	}
	
	function updateHall() {
		$c_tbl = 'cnf_hall';
		$data = array(
					  'building_id'		=>	$this->input->post('building_id'),
				      'hall_number'		=>	$this->input->post('hall_number'),
				      'hall_row_num'		=>	$this->input->post('hall_row_num'),
				      'hall_column_num'		=>	$this->input->post('hall_column_num'),
				      'hall_per_unit_seat'		=>	$this->input->post('hall_per_unit_seat'),
				      'hall_capacity'		=>	$this->input->post('hall_capacity'),
				      'hall_is_active'	=>	($this->input->post('hall_is_active') == 'on') ? 1 : 0,
				    );
		$this->db->where('hall_id', $this->input->post('record_id'));					
		$status = $this->db->update($c_tbl, $data);
		return $status;		
	}	
	
	function deleteHall($id) {
		$c_tbl = 'cnf_hall';
		$this->db->delete($c_tbl, array('hall_id' => $id)); 
		//also association need to be deleted
		return "DELETED";
	}

	function getAllHalls($building_id = null) {
		$c_tbl = 'cnf_hall';
		
		$this->db->select(array('hall_id', 'cnf_hall.building_id', 'hall_number ', 'hall_row_num', 'hall_column_num', 'hall_per_unit_seat', 'hall_capacity', 'building_name', 'hall_is_active'));
		$this->db->from($c_tbl);
		$this->db->join('cnf_building', 'cnf_building.building_id = cnf_hall.building_id');
		if($building_id != null){
			$this->db->where('cnf_hall.building_id', $building_id);
		}
		$this->db->order_by('building_name', 'asc'); 
		$this->db->order_by('hall_id', 'asc'); 
		$query = $this->db->get();
		$results = $query->result();
		return $results;
	}
	
	function getHallNoById($hall_id){
		$sql = "SELECT DISTINCT hall_number FROM cnf_hall WHERE hall_id = '".$hall_id."'";
		$query = $this->db->query($sql);
		$results = $query->result();
		$hall_number = "";
		if(count($results) > 0){
			$hall_number = $results[0]->hall_number;
		}
		return $hall_number;
	}
	
	function getHallById($hall_id){
		$c_tbl = 'cnf_hall';
		
		$this->db->select(array('hall_id', 'cnf_hall.building_id', 'hall_number ', 'hall_row_num', 'hall_column_num', 'hall_per_unit_seat', 'hall_capacity', 'building_name'));
		$this->db->from($c_tbl);
		$this->db->join('cnf_building', 'cnf_building.building_id = cnf_hall.building_id');
		$this->db->where('hall_id', $hall_id);
		$query = $this->db->get();
		$results = $query->result_array();
		return $results;
	}
	
	function getHallOptions($building_id = null) {
		$added_sql = "";
		if($building_id != null){
			$added_sql = "building_id = ".$building_id." AND";
		}
		$sql = "SELECT hall_id, hall_number FROM cnf_hall WHERE ". $added_sql ." hall_is_active = 1 ORDER BY hall_number";
		$query = $this->db->query($sql);
		$dropdowns = $query->result();
		$dropDownList['EMPTY'] = "";
        foreach($dropdowns as $dropdown)
        {
        	$dropDownList[$dropdown->hall_id] = $dropdown->hall_number;
        }
    	$finalDropDown = $dropDownList;
        return $finalDropDown;
	}
	//**************  HALL : END  ************	
	
	//**************  POST GRADUATE SUBJECT : START  ************	
	function createPgSubject() {
		$c_tbl = 'cnf_pgsubj';
		$data = array(
					  'subj_code'		=>	$this->input->post('subj_code'),
				      'subj_name'		=>	$this->getSubjectNameByCode($this->input->post('subj_code')),
				      'subj_cors_code'	=>	$this->input->post('subj_cors_code'),
				      'subj_criteria'	=>	$this->input->post('subj_criteria'),
				      'subj_is_active'	=>	($this->input->post('subj_is_active') == 'on') ? 1 : 0,
				      'subj_can_apply'	=>	($this->input->post('subj_can_apply') == 'on') ? 1 : 0
				    );
		$status = $this->db->insert($c_tbl, $data);
		return $status;		
	}
	
	function updatePgSubject() {
		$c_tbl = 'cnf_pgsubj';
		$data = array(
				      'subj_code'		=>	$this->input->post('subj_code'),
				      'subj_name'		=>	$this->getSubjectNameByCode($this->input->post('subj_code')),
				      'subj_criteria'	=>	$this->input->post('subj_criteria'),
				      'subj_cors_code'	=>	$this->input->post('subj_cors_code'),
				      'subj_is_active'	=>	($this->input->post('subj_is_active') == 'on') ? 1 : 0,
				      'subj_can_apply'	=>	($this->input->post('subj_can_apply') == 'on') ? 1 : 0
				    );
		$this->db->where('subj_id', $this->input->post('record_id'));					
		$status = $this->db->update($c_tbl, $data);
		return $status;		
	}	
	
	function deletePgSubject($id) {
		$c_tbl = 'cnf_pgsubj';
		$this->db->delete($c_tbl, array('subj_id' => $id)); 
		//also association need to be deleted
		return "DELETED";
	}
	
	function getAllPgSubjects() {
		$c_tbl = 'cnf_pgsubj';
		$crs_tbl = 'cnf_course';
		
		$this->db->select(array('subj_id', 'subj_code', 'subj_name', 'subj_criteria', 'subj_cors_code', 'cors_name', 'subj_is_active', 'subj_can_apply'));
		$this->db->from($c_tbl);
		$this->db->join($crs_tbl, 'cors_code = subj_cors_code');
		$this->db->order_by('cors_name', 'asc'); 
		$this->db->order_by('subj_name', 'asc'); 
		$query = $this->db->get();
		$results = $query->result();
		return $results;
	}
	
	function getPgSubjectNameByCode($subj_code) {
		$sql = "SELECT subj_name FROM cnf_pgsubj WHERE subj_code = '".$subj_code."'";
		$query = $this->db->query($sql);
		$results = $query->result();
		$subj_name = "";
		if(count($results) > 0){
			$subj_name = $results[0]->subj_name;
		}
		return $subj_name;
	}
	
	function getCourseCodeBySubjectCode($subj_code) {
		$sql = "SELECT subj_cors_code FROM cnf_pgsubj WHERE subj_code = '".$subj_code."'";
		$query = $this->db->query($sql);
		$results = $query->result();
		$subj_name = "";
		if(count($results) > 0){
			$subj_name = $results[0]->subj_cors_code;
		}
		return $subj_name;
	}
	
	function getPgSubjectOptions() {
		$sql = "SELECT subj_code, subj_name FROM cnf_pgsubj WHERE subj_is_active = 1 ORDER BY subj_name";
		$query = $this->db->query($sql);
		$dropdowns = $query->result();
		$dropDownList['EMPTY'] = "";
        foreach($dropdowns as $dropdown)
        {
        	$dropDownList[$dropdown->subj_code] = $dropdown->subj_name;
        }
    	$finalDropDown = $dropDownList;
        return $finalDropDown;
	}
	
	function getWrittenPgSubjectOptions() {
		$sql = "SELECT subj_code, subj_name 
				FROM cnf_pgsubj 
				WHERE subj_code IN (SELECT DISTINCT seat_subj FROM cnf_seat_matrix WHERE seat_rank_ctgr LIKE '40PCT' AND seat_is_active = 1 AND seat_cnt > 0) AND subj_is_active = 1 ORDER BY subj_name";
		$query = $this->db->query($sql);
		$dropdowns = $query->result();
		$dropDownList['EMPTY'] = "";
        foreach($dropdowns as $dropdown)
        {
        	$dropDownList[$dropdown->subj_code] = $dropdown->subj_name;
        }
    	$finalDropDown = $dropDownList;
        return $finalDropDown;
	}
	//**************  POST GRADUATE SUBJECT : END  ************
	
	//**************  COLLEGE SUBJECT ASSOCIATION : START *************
	function createCollegePgSubjAssoc() {
		$colsubj_tbl = 'cnf_colpgsubj';
		$subj_code = $this->input->post("subj_code");
		 
		 //echo $this->input->post("col_code") . "<br/>";
		 //print_r($subj_code); exit();
		
		$status = TRUE;
		$this->db->trans_begin();
		$this->db->delete($colsubj_tbl, array('col_code' => $this->input->post("col_code"))); 
		for($i=0; $i<count($subj_code); $i++) {
			if($subj_code[$i] != '' && $subj_code[$i] != 'EMPTY') {
				$sub_data = array(
								'col_code'	=>	$this->input->post("col_code"),
					      		'subj_code'	=>	$subj_code[$i]
						  );
				$this->db->insert($colsubj_tbl, $sub_data);	
				if ($this->db->trans_status() === FALSE) {
					$status = FALSE;
				}	
			}		  
		}
		if ($status === FALSE) {
		    $this->db->trans_rollback();
		} else {
		    $this->db->trans_commit();
		}
		return $status;		
	}
	
	function getCollegesBySubj($subj_code) {
		$s_tbl = 'cnf_colpgsubj';
		$c_tbl = 'cnf_college';
		
		$this->db->select(array('cnf_colpgsubj.col_code', 'col_name'));
		$this->db->from($s_tbl);
		$this->db->join($c_tbl, "cnf_college.col_code = cnf_colpgsubj.col_code");
		
		$this->db->order_by('col_name');
		$query = $this->db->get();
		$results = $query->result_array();
		return $results;
	}
	
	function createPgSubjUgSubjAssoc() {
		$subj_tbl = 'cnf_pgsubj_ugsubj';
		$ug_subj_code = $this->input->post("ug_subj_code");
		
		$status = TRUE;
		$this->db->trans_begin();
		$this->db->delete($subj_tbl, array('pg_subj_code' => $this->input->post("pg_subj_code"))); 
		
		
		for($i=0; $i<count($ug_subj_code); $i++) {
			if($ug_subj_code[$i] != 'EMPTY' && $ug_subj_code[$i] != '' && $ug_subj_code[$i] != NULL && $ug_subj_code[$i] != 'NULL') {
				$sub_data = array(
								'pg_subj_code'	=>	$this->input->post("pg_subj_code"),
					      		'ug_subj_code'	=>	$ug_subj_code[$i],
						  );
				$this->db->insert($subj_tbl, $sub_data);	
				if ($this->db->trans_status() === FALSE) {
					$status = FALSE;
				}	
			}		  
		}
		if ($status === FALSE) {
		    $this->db->trans_rollback();
		} else {
		    $this->db->trans_commit();
		}
		return $status;		
	}
	
	function getPgSubjOptionByCollege($college_code=null) {
		$s_tbl 		= 'cnf_pgsubj';
		$cs_tbl 	= 'cnf_colpgsubj';	
		$sql1 = "SELECT DISTINCT subj_code, subj_name
				FROM " . $s_tbl . " cs
				WHERE cs.subj_is_active = 1 
				AND cs.subj_code NOT IN (SELECT scs.subj_code FROM " . $cs_tbl . " scs WHERE col_code = '" . $college_code . "') 
				ORDER BY subj_name";
				
		$sql2 = "SELECT DISTINCT subj_code, subj_name
				FROM " . $s_tbl . " cs
				WHERE cs.subj_is_active = 1 
				AND cs.subj_code IN (SELECT scs.subj_code FROM " . $cs_tbl . " scs WHERE col_code = '" . $college_code . "') 
				ORDER BY subj_name";	
				
		$results1 = $this->db->query($sql1)->result_array();
		$results2 = $this->db->query($sql2)->result_array();
		$subjects = array('notavailable' => $results1, 'available' => $results2);
		return $subjects;
	}
	
	function getSubjectOptionByPostGraduateSubject($pg_subj_code=null) {
		$s_tbl 		= 'cnf_subjects';
		$cs_tbl 	= 'cnf_pgsubj_ugsubj';	
		
		$sql1 = "SELECT DISTINCT subj_code, subj_name
				FROM " . $s_tbl . " cs
				WHERE cs.subj_is_active = 1 
				AND cs.subj_code NOT IN (SELECT scs.ug_subj_code_major FROM " . $cs_tbl . " scs WHERE pg_subj_code = '" . $pg_subj_code . "') 
				ORDER BY subj_name";
				
		$sql2 = "SELECT DISTINCT subj_code, subj_name
				FROM " . $s_tbl . " cs
				WHERE cs.subj_is_active = 1 
				AND cs.subj_code IN (SELECT scs.ug_subj_code_major FROM " . $cs_tbl . " scs WHERE pg_subj_code = '" . $pg_subj_code . "') 
				ORDER BY subj_name";	
				
		$results1 = $this->db->query($sql1)->result_array();
		$results2 = $this->db->query($sql2)->result_array();
		$subjects = array('notavailable' => $results1, 'available' => $results2);
		return $subjects;
	}
	//**************  COLLEGE  SUBJECT ASSOCIATION : END *************

	//**************  PG-UG SUBJECT ASSOCIATION : START *************
	function getPostGraduateSubjectOption() {
		$sql = "SELECT subj_code, subj_name FROM cnf_pgsubj WHERE subj_is_active = 1 ORDER BY subj_name";
		$query = $this->db->query($sql);
		$dropdowns = $query->result();
		$dropDownList['EMPTY'] = "";
        foreach($dropdowns as $dropdown)
        {
        	$dropDownList[$dropdown->subj_code] = $dropdown->subj_name;
        }
    	$finalDropDown = $dropDownList;
		
        return $finalDropDown;	
	}
	
	function getUgSubjectOptionByPgSubject($pg_subj_code=null) {
		$s_tbl 		= 'cnf_subjects';
		$cs_tbl 	= 'cnf_pgsubj_ugsubj';	
		
		$sql1 = "SELECT DISTINCT subj_code, subj_name
				FROM " . $s_tbl . " cs
				WHERE cs.subj_is_active = 1 
				AND cs.subj_code NOT IN (SELECT scs.ug_subj_code FROM " . $cs_tbl . " scs WHERE pg_subj_code = '" . $pg_subj_code . "') 
				ORDER BY subj_name";
				
		$sql2 = "SELECT DISTINCT subj_code, subj_name
				FROM " . $s_tbl . " cs
				WHERE cs.subj_is_active = 1 
				AND cs.subj_code IN (SELECT scs.ug_subj_code FROM " . $cs_tbl . " scs WHERE pg_subj_code = '" . $pg_subj_code . "') 
				ORDER BY subj_name";	
				
		$results1 = $this->db->query($sql1)->result_array();
		$results2 = $this->db->query($sql2)->result_array();
		$subjects = array('notavailable' => $results1, 'available' => $results2);
		return $subjects;
	}
	
	function getPgUgSubjectOptions() {
		$s_tbl 	= 'cnf_pgsubj';

		$sql = "SELECT DISTINCT subj_code, subj_name
				FROM cnf_pgsubj
				WHERE subj_is_active = 1 
				ORDER BY subj_name";	
				
		$query = $this->db->query($sql);
		$dropdowns = $query->result();
		$dropDownList['EMPTY'] = "";
        foreach($dropdowns as $dropdown)
        {
        	$dropDownList[$dropdown->subj_code] = $dropdown->subj_name;
        }
    	$finalDropDown = $dropDownList;
        return $finalDropDown;
	}
	
	function createPgUgSubjectAssoc() {
		$subj_tbl = 'cnf_pgsubj_ugsubj';
		$created_on = gmdate('Y-m-d H:i:s');
		$created_by = $this->session->userdata['user']['user_id']; //user id from session

		$subj_code_major = $this->input->post("ug_subj_code_major");
		
		$status = TRUE;
		$this->db->trans_begin();
		$this->db->delete($subj_tbl, array('pg_subj_code' => $this->input->post("pg_subj_code"))); 
		for($i=0; $i<count($subj_code_major); $i++) {
			//if($subj_code_major[$i] != 'EMPTY') {
			if($subj_code_major[$i] != 'EMPTY' && $subj_code_major[$i] != '' && $subj_code_major[$i] != NULL && $subj_code_major[$i] != 'NULL') {
				$sub_data = array(
								'pg_subj_code'	=>	$this->input->post("pg_subj_code"),
					      		'ug_subj_code'	=>	$subj_code_major[$i],
						  );
				$this->db->insert($subj_tbl, $sub_data);	
				if ($this->db->trans_status() === FALSE) {
					$status = FALSE;
				}	
			}		  
		}
		
		if ($status === FALSE) {
		    $this->db->trans_rollback();
		} else {
		    $this->db->trans_commit();
		}
		return $status;		
	}
	
	//**************  PG-UG SUBJECT ASSOCIATION : END *************
	
	//************** UG-UG SUBJECT ASSOCIATION :START
	function getUgSubjectOptionByUgSubject($pg_subj_code=null, $ug_subj_major_code=null) {
		$s_tbl 		= 'cnf_subjects';
		$cs_tbl 	= 'cnf_pgsubj_ugsubj_ugsubj';	
		
		$sql1 = "SELECT DISTINCT subj_code, subj_name
				FROM " . $s_tbl . " cs
				WHERE cs.subj_is_active = 1 
				AND cs.subj_code NOT IN (SELECT scs.ug_subj_minor_code FROM " . $cs_tbl . " scs WHERE pg_subj_code = '" . $pg_subj_code . "' AND ug_subj_major_code = '" . $ug_subj_major_code . "') 
				ORDER BY subj_name";
				
		$sql2 = "SELECT DISTINCT subj_code, subj_name
				FROM " . $s_tbl . " cs
				WHERE cs.subj_is_active = 1 
				AND cs.subj_code IN (SELECT scs.ug_subj_minor_code FROM " . $cs_tbl . " scs WHERE pg_subj_code = '" . $pg_subj_code . "' AND ug_subj_major_code = '" . $ug_subj_major_code . "') 
				ORDER BY subj_name";	
				
		$results1 = $this->db->query($sql1)->result_array();
		$results2 = $this->db->query($sql2)->result_array();
		$subjects = array('notavailable' => $results1, 'available' => $results2);
		return $subjects;
	}
	
	function createPgUgUgSubjectAssoc() {
		$subj_tbl = 'cnf_pgsubj_ugsubj_ugsubj';

		$pg_subj_code = $this->input->post("pg_subj_code");
		$subj_code_major = $this->input->post("ug_subj_code_major");
		$subj_code_minor = $this->input->post("ug_subj_code_minor");
		
		$status = TRUE;
		$this->db->trans_begin();
		$this->db->delete($subj_tbl, array('pg_subj_code' => $this->input->post("pg_subj_code"), 'ug_subj_major_code' => $this->input->post("ug_subj_code_major"))); 
		
		//echo count($subj_code_minor); exit();
		
		for($i=0; $i<count($subj_code_minor); $i++) {
			if($subj_code_minor[$i] != 'EMPTY' && $subj_code_minor[$i] != '' && $subj_code_minor[$i] != NULL) {
				$sub_data = array(
								'pg_subj_code'		=>	$this->input->post("pg_subj_code"),
					      		'ug_subj_major_code'=>	$subj_code_major,
					      		'ug_subj_minor_code'=>	$subj_code_minor[$i],
						  );
				$this->db->insert($subj_tbl, $sub_data);	
				if ($this->db->trans_status() === FALSE) {
					$status = FALSE;
				}	
			}		  
		}
		
		if ($status === FALSE) {
		    $this->db->trans_rollback();
		} else {
		    $this->db->trans_commit();
		}
		return $status;		
	}
	//************** UG-UG SUBJECT ASSOCIATION : END
	
	//**************  SEAT MATRIX : START *************/
	
	//get all seats
	function getAllSeats_() {
		$c_tbl = 'cnf_seat_matrix';
		$subj_tbl = 'cnf_pgsubj';
		$resv_tbl = 'cnf_reservation';
				
		$this->db->select(array('seat_id', 'seat_subj', 'subj_name', 'seat_rank_ctgr', 'seat_resv', 'resv_name', 'seat_resv_extra', 'seat_cnt', 'seat_desc'));
		$this->db->from($c_tbl);
		$this->db->join($subj_tbl, 'subj_code = seat_subj');
		$this->db->join($resv_tbl, 'resv_code = seat_resv');
		
		$this->db->order_by('subj_name', 'asc'); 
		$this->db->order_by('seat_rank_ctgr', 'asc'); 
		$this->db->order_by('resv_weight', 'desc'); 
		
		$query = $this->db->get();
		$results = $query->result();
		
		//print_r($results); exit();
		
		return $results;
	}
	
	//get all seats
	function getAllSeats() {
		$c_tbl = 'cnf_seat_matrix';
		$subj_tbl = 'cnf_pgsubj';
		$resv_tbl = 'cnf_reservation';
				
		$this->db->select(array('seat_id', 'seat_subj', 'subj_name', 'seat_rank_ctgr', 'seat_resv', 'resv_name', 'seat_resv_extra', 'seat_cnt', 'seat_desc'));
		$this->db->from($c_tbl);
		$this->db->join($subj_tbl, 'subj_code = seat_subj');
		$this->db->join($resv_tbl, 'resv_code = seat_resv');
		
		if(isset($_REQUEST['seat_subj'])){
			$this->db->where('seat_subj', $this->input->post('seat_subj'));
		}
		if(isset($_REQUEST['seat_rank_ctgr'])){
			$this->db->where('seat_rank_ctgr', $this->input->post('seat_rank_ctgr'));
		}
		
		$this->db->order_by('subj_name', 'asc'); 
		$this->db->order_by('seat_rank_ctgr', 'asc'); 
		$this->db->order_by('resv_weight', 'desc'); 
		
		$query = $this->db->get();
		$results = $query->result();
		$return_result = array();
		for($i=0; $i<count($results); $i++){
			$return_result[$i]['seat_id'] = $results[$i]->seat_id;
			$return_result[$i]['seat_subj'] = $results[$i]->seat_subj;
			$return_result[$i]['subj_name'] = $results[$i]->subj_name;
			$return_result[$i]['seat_rank_ctgr'] = $results[$i]->seat_rank_ctgr;
			$return_result[$i]['seat_rank_ctgr_name'] = _getMeritCategory($results[$i]->seat_rank_ctgr);
			$return_result[$i]['seat_resv'] = $results[$i]->seat_resv;
			$return_result[$i]['resv_name'] = $results[$i]->resv_name;
			$return_result[$i]['seat_resv_extra'] = $results[$i]->seat_resv_extra;
			$return_result[$i]['seat_cnt'] = $results[$i]->seat_cnt;
			$return_result[$i]['seat_desc'] = $results[$i]->seat_desc;
		}
		return $return_result;
	}
	
	//create seats
	function createSeat() {
		$c_tbl = 'cnf_seat_matrix';
		$created_on = gmdate('Y-m-d H:i:s');
		$created_by = $this->session->userdata['user']['user_name']; //user id from session

		$data = array(
					  'seat_subj'		=>	$this->input->post('seat_subj'),
				      'seat_rank_ctgr'	=>	$this->input->post('seat_rank_ctgr'),
				      'seat_resv'		=>	$this->input->post('seat_resv'),
				      'seat_resv_extra'	=>	$this->input->post('seat_resv_extra'),
				      'seat_cnt'		=>	$this->input->post('seat_cnt'),
				      'seat_desc'		=>	$this->input->post('seat_desc'),
				      'created_on'		=>	$created_on,
				      'created_by'		=>	$created_by,
				      'modified_on'		=>	$created_on,
				      'modified_by'		=>	$created_by
				    );
		$status = $this->db->insert($c_tbl, $data);
		return $status;		
	}
	
	//update seats
	function updateSeat() {
		$c_tbl = 'cnf_seat_matrix';
		$modified_on = gmdate('Y-m-d H:i:s');
		$modified_by = $this->session->userdata['user']['user_id']; //user id from session

		$data = array(
				       'seat_subj'		=>	$this->input->post('seat_subj'),
				      'seat_rank_ctgr'	=>	$this->input->post('seat_rank_ctgr'),
				      'seat_resv'	=>	$this->input->post('seat_resv'),
				      'seat_resv_extra'	=>	$this->input->post('seat_resv_extra'),
				      'seat_cnt'		=>	$this->input->post('seat_cnt'),
				      'seat_desc'		=>	$this->input->post('seat_desc'),
				      'modified_on'		=>	$modified_on,
				      'modified_by'		=>	$modified_by
				    );
		$this->db->where('seat_id', $this->input->post('record_id'));					
		$status = $this->db->update($c_tbl, $data);
		return $status;		
	}	
	
	//delete saets
	function deleteSeat($id) {
		$c_tbl = 'cnf_seat_matrix';
		//echo $id; exit();
		$this->db->delete($c_tbl, array('seat_id' => $id)); 
		//also association need to be deleted
		return "DELETED";
	}
	//**************  SEAT MATRIX : END *************
	
	
	
	//get ugsubject based on post graduate subjects
	function getUGSubjectByPGSubject($pg_subj_code){
		$sql = "SELECT ug_subj_code, subj_name as ug_subj_name 
				FROM cnf_pgsubj_ugsubj 
				JOIN cnf_subjects on subj_code = ug_subj_code
				WHERE pg_subj_code = '" . $pg_subj_code . "'";
		$query = $this->db->query($sql);
		$results = $query->result();
		$r = array();
		for($i=0; $i<count($results); $i++) {
			$r[$i] = array(
						 'ug_subj_code' =>	$results[$i]->ug_subj_code,
						 'ug_subj_name' =>	$results[$i]->ug_subj_name,
						);
		     }
		return $r;
	}
	
	function getUGSubjectByUGSubject($pg_appl_grad_major_subj){
		$sql = "SELECT ug_subj_minor_code, subj_name 
				FROM cnf_pgsubj_ugsubj_ugsubj 
				JOIN cnf_subjects on subj_code = ug_subj_minor_code
				WHERE ug_subj_major_code = '" . $pg_appl_grad_major_subj . "'";
		
		//echo $sql; exit();
		
		$query = $this->db->query($sql);
		$results = $query->result();
		$r = array();
		for($i=0; $i<count($results); $i++) {
			$r[$i] = array(
						 'ug_subj_code' =>	$results[$i]->ug_subj_minor_code,
						 'ug_subj_name' =>	$results[$i]->subj_name,
						);
		     }
		return $r;
	}
	
	//get ugsubject based on post graduate subjects
	function getUGSubjectByPGSubjectOption($pg_subj_code){
		$sql = "SELECT ug_subj_code, subj_name 
				FROM cnf_pgsubj_ugsubj 
				JOIN cnf_subjects on subj_code = ug_subj_code
				WHERE pg_subj_code = '" . $pg_subj_code . "'";
		
		$query = $this->db->query($sql);
		$dropdowns = $query->result();
		$dropDownList['EMPTY'] = "";
        foreach($dropdowns as $dropdown)
        {
        	$dropDownList[$dropdown->ug_subj_code] = $dropdown->subj_name;
        }
    	$finalDropDown = $dropDownList;
		
        return $finalDropDown;
	}
	
	//get ugsubject based on post graduate subjects
	function getUGSubjectByUGSubjectOption($pg_appl_grad_major_subj){
		$sql = "SELECT ug_subj_minor_code, subj_name 
				FROM cnf_pgsubj_ugsubj_ugsubj 
				JOIN cnf_subjects on subj_code = ug_subj_minor_code
				WHERE ug_subj_major_code = '" . $pg_appl_grad_major_subj . "'";
		
		$query = $this->db->query($sql);
		$dropdowns = $query->result();
		$dropDownList['EMPTY'] = "";
        foreach($dropdowns as $dropdown)
        {
        	$dropDownList[$dropdown->ug_subj_minor_code] = $dropdown->subj_name;
        }
    	$finalDropDown = $dropDownList;
		
        return $finalDropDown;
	}		
	
	function getSubjectCriteria($data){
		$pg_subj_code 		= $data['pg_appl_subj'];
		$ug_subj_major_code = $data['pg_appl_grad_major_subj'];
		$ug_subj_minor_code = $data['pg_appl_grad_minor_subj'];
		
		$flag = false;
		
		$sql = "SELECT ug_subj_minor_code FROM cnf_pgsubj_ugsubj_ugsubj WHERE pg_subj_code like '".$pg_subj_code."' AND ug_subj_major_code like '".$ug_subj_major_code."'";
		
		//echo $sql; exit();
		
		$query = $this->db->query($sql);
		$dropdowns = $query->result();
		
		if(count($dropdowns) == 0){
			$flag = true;
		}
		//print_r($dropdowns); exit();
		
        foreach($dropdowns as $dropdown){
        	if($ug_subj_minor_code == $dropdown->ug_subj_minor_code){
        		$flag = true;
        		break;
        	}
        }
		return $flag;
	}
	
	//get colleges by category
	function getCollegesByCategory($ctgry) {
		$c_tbl = 'cnf_college';
		$male_college = array("B", "BG");
		$female_college = array("G", "BG");
		
		$this->db->select(array('col_id', 'col_code', 'col_name', 'col_ctgry', 'col_address', 'col_city', 'col_state', 'col_phone', 'col_email', 'col_is_active'));
		$this->db->from($c_tbl);
		if(strtoupper($ctgry) == 'MALE' || strtoupper($ctgry) == 'M'){
			$this->db->where_in('col_ctgry', $male_college);
		}else
		if(strtoupper($ctgry) == 'FEMALE' || strtoupper($ctgry) == 'F'){
			$this->db->where_in('col_ctgry', $female_college);
		}else
		if(strtoupper($ctgry) == 'TRANSGENDER' || strtoupper($ctgry) == 'T'){
			$this->db->where_in('col_ctgry', $male_college);
		}
		
		$this->db->order_by('col_code', 'asc'); 
		//$this->db->limit($per_page, $offset);
		$query = $this->db->get();
		$results = $query->result();
		return $results;
	}

	//get colleges by category
	function getCollegesByCategoryPgSubject($ctgry, $pg_appl_subj) {
		$c_tbl = 'cnf_college';
		$college = "()";
		
		if(strtoupper($ctgry) == 'MALE' || strtoupper($ctgry) == 'M'){
			$college = "('B', 'BG')";
		}else
		if(strtoupper($ctgry) == 'FEMALE' || strtoupper($ctgry) == 'F'){
			$college = "('G', 'BG')";
		}else
		if(strtoupper($ctgry) == 'TRANSGENDER' || strtoupper($ctgry) == 'T'){
			$college = "('B', 'BG')";
		}
		
		
		$sql = "SELECT cnf_colpgsubj.col_code, col_name 
				FROM cnf_colpgsubj 
				JOIN cnf_college ON cnf_college.col_code = cnf_colpgsubj.col_code
				WHERE subj_code like '".$pg_appl_subj."' AND col_ctgry in ".$college;
		
	
		$query = $this->db->query($sql);
		$dropdowns = $query->result();
		$dropDownList['EMPTY'] = "";
        foreach($dropdowns as $dropdown)
        {
        	$dropDownList[$dropdown->col_code] = $dropdown->col_name;
        }
    	$finalDropDown = $dropDownList;
        return $finalDropDown;
	}
	
	//----------------------------------------------------PARTHA END
	
	function getSubjectNameOption() {
		$sql = "SELECT subj_code, subj_name FROM cnf_subj WHERE subj_is_active = 1 ORDER BY subj_name";
		$query = $this->db->query($sql);
		$dropdowns = $query->result();
		$dropDownList['EMPTY'] = "";
        foreach($dropdowns as $dropdown)
        {
        	$dropDownList[$dropdown->subj_code] = $dropdown->subj_name;
        }
    	$finalDropDown = $dropDownList;
        return $finalDropDown;
	}
	
	function getSubjectNameByCenterCodeOption($cntr_code) {
		$sql = "SELECT DISTINCT s.subj_code, subj_name 
				FROM cnf_subj s 
				JOIN cnf_scsubj ss ON ss.subj_code = s.subj_code 
				WHERE subj_is_active = 1 AND ss.cntr_code = '" . $cntr_code . "' 
				ORDER BY subj_name";
		$query = $this->db->query($sql);
		$dropdowns = $query->result();
		$dropDownList['EMPTY'] = "";
        foreach($dropdowns as $dropdown)
        {
        	$dropDownList[$dropdown->subj_code] = $dropdown->subj_name;
        }
    	$finalDropDown = $dropDownList;
        return $finalDropDown;
	}	
	
	function getStudyCenterOption() {
		$sql = "SELECT cntr_code, cntr_name, cntr_city FROM cnf_cntr WHERE cntr_is_active = 1 ORDER BY cntr_name";
		$query = $this->db->query($sql);
		$dropdowns = $query->result();
		$dropDownList['EMPTY'] = "";
        foreach($dropdowns as $dropdown)
        {
        	$dropDownList[$dropdown->cntr_code] = $dropdown->cntr_name . ", " . $dropdown->cntr_city;
        }
    	$finalDropDown = $dropDownList;
        return $finalDropDown;
	}

	function getStudyCenterSubjects($cntr_code) {
		$s_tbl 		= 'cnf_subj';
		$scs_tbl 	= 'cnf_scsubj';	
		$sql1 = "SELECT DISTINCT subj_code, subj_name
				FROM " . $s_tbl . " cs
				WHERE cs.subj_is_active = 1 
				AND cs.subj_code NOT IN (SELECT scs.subj_code FROM " . $scs_tbl . " scs WHERE cntr_code = " . $cntr_code . ") 
				ORDER BY subj_name";
				
		$sql2 = "SELECT DISTINCT subj_code, subj_name
				FROM " . $s_tbl . " cs
				WHERE cs.subj_is_active = 1 
				AND cs.subj_code IN (SELECT scs.subj_code FROM " . $scs_tbl . " scs WHERE cntr_code = " . $cntr_code . ") 
				ORDER BY subj_name";	
				
		$results1 = $this->db->query($sql1)->result_array();
		$results2 = $this->db->query($sql2)->result_array();
		
		$subjects = array('notavailable' => $results1, 'available' => $results2);
		return $subjects;
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
	
	
	//************* EXAMINATION : START ***********
	function createExamination() {
		$c_tbl = 'cnf_exam';
		$data = array(
					  'exam_date'		=>	convertToMySqlDate($this->input->post('exam_date')),
				      'exam_start_time'	=>	$this->input->post('exam_start_time'),
				      'exam_end_time'	=>	$this->input->post('exam_end_time'),
				      'exam_is_active'	=>	($this->input->post('exam_is_active') == 'on') ? 1 : 0
				    );
		
		//print_r($data); exit();
		
		$status = $this->db->insert($c_tbl, $data);
		return $status;		
	}
	
	
	function updateExamination() {
		$c_tbl = 'cnf_exam';
		$data = array(
					  'exam_date'		=>	convertToMySqlDate($this->input->post('exam_date')),
				      'exam_start_time'	=>	$this->input->post('exam_start_time'),
				      'exam_end_time'	=>	$this->input->post('exam_end_time'),
				      'exam_is_active'	=>	($this->input->post('exam_is_active') == 'on') ? 1 : 0
				    );
		$this->db->where('exam_id', $this->input->post('record_id'));					
		$status = $this->db->update($c_tbl, $data);
		return $status;		
	}	
	
	function deleteExamination($id) {
		$c_tbl = 'cnf_exam';
		$this->db->delete($c_tbl, array('exam_id' => $id)); 
		return "DELETED";
	}		
	
	function getAllExaminations() {
		$c_tbl = 'cnf_exam';
		
		$sql = "SELECT exam_id, exam_date, exam_start_time, exam_end_time, exam_is_active 
				FROM cnf_exam 
				ORDER BY exam_date";
		
		$query = $this->db->query($sql);
		$r = $query->result();
		
		$results = array();	
		
		for($i=0; $i<count($r); $i++) {
			$results[$i] = array(
									'exam_id' 			=>	$r[$i]->exam_id,
									'exam_date' 		=> 	getDateFormat($r[$i]->exam_date, 'd-m-Y'),
									'exam_start_time' 	=> 	$r[$i]->exam_start_time,
									'exam_end_time' 	=> 	$r[$i]->exam_end_time	,
									'exam_is_active' 	=> 	$r[$i]->exam_is_active
								);
		}
		
		return $results;
	}
	
	//---------------------------------------------------	
	function getExaminationOptions() {
		$sql = "SELECT exam_id, exam_date, exam_start_time, exam_end_time FROM cnf_exam WHERE exam_is_active = 1 ORDER BY exam_date";
		$query = $this->db->query($sql);
		$dropdowns = $query->result();
		$dropDownList['EMPTY'] = "";
        foreach($dropdowns as $dropdown)
        {
        	$dropDownList[$dropdown->exam_id] = getDateFormat($dropdown->exam_date, 'd-m-Y') . " == " . $dropdown->exam_start_time . " - " . $dropdown->exam_end_time;
        }
    	$finalDropDown = $dropDownList;
        return $finalDropDown;
	}
	
	//************* EXAMINATION : END ***********
	
		function getMeritInfo($merit_ctgr_index){
		$sql = "SELECT seat_desc FROM cnf_seat_matrix WHERE seat_id = ".$merit_ctgr_index;
		$query = $this->db->query($sql);
		$results = $query->result();
		$description = "";
		if(count($results) > 0){
			$description = $results[0]->seat_desc;
		}
		return $description;
	}
		
	function getReservationNameByCode($resv_code) {
		if(strtolower($resv_code) == strtolower('pwd')){
			return 'D.A.';
		}else
		if(strtolower($resv_code) == strtolower('HONS')){
			return 'HONOURS';
		}
		if(strtolower($resv_code) == strtolower('sports')){
			return 'SPORTS';
		}
		$sql = "SELECT resv_name FROM cnf_reservation WHERE resv_code = '".$resv_code."'";
		$query = $this->db->query($sql);
		$results = $query->result();
		$resv_name = "";
		if(count($results) > 0){
			$resv_name = $results[0]->resv_name;
		}
		return $resv_name;
	}
	
	function getAllHallsForExam($exam_id = null) {
		$c_tbl = 'cnf_hall';
		$this->db->distinct();
		$this->db->select(array('cnf_exam_subj.hall_id', 'hall_number', 'building_name'));
		$this->db->from($c_tbl);
		$this->db->join('cnf_building', 'cnf_building.building_id = cnf_hall.building_id');
		$this->db->join('cnf_exam_subj', 'cnf_exam_subj.hall_id = cnf_hall.hall_id');
		$this->db->where('cnf_exam_subj.exam_id', $exam_id);
		$this->db->order_by('building_name', 'asc'); 
		$query = $this->db->get();
		$results = $query->result();
		return $results;
	}
	
	function getAllSubjectsForExam($exam_id = null) {
		$c_tbl = 'cnf_pgsubj';
		$this->db->distinct();
		$this->db->select(array('subj_code', 'subj_name'));
		$this->db->from($c_tbl);
		$this->db->join('cnf_exam_subj', 'cnf_exam_subj.exam_subject = subj_code');
		$this->db->where('exam_id', $exam_id);
		$this->db->order_by('subj_name', 'asc'); 
		$query = $this->db->get();
		$results = $query->result();
		return $results;
	}
}
?>