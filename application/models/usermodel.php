<?php
class Usermodel extends CI_Model {
    function __construct() {
        parent::__construct();
		$this->load->database();
		$ci = get_instance();
		$ci->load->helper('string');
		$this->load->model('configmodel');	
    }
    
    function authenticate_user($username, $password) {
		$user_table = 'users';
		$this->db->select('*');
		$this->db->from($user_table);
		$this->db->where('LOWER(user_name)', strtolower($username));
		$this->db->where('user_password', $password);
		$this->db->where('is_active', 1);
		$query = $this->db->get();	
		
		if ($query->num_rows() == 1) {
			$row = $query->row(); 
			$user = array(
							'session_id'		=>	md5(date('Ymdhis')),
							'user_id'			=>	$row->user_id,
							'user_role' 		=> $row->role,
							'firstname' 		=> $row->user_firstname,
							'lastname' 			=> $row->user_lastname,
							'user_name' 		=> $row->user_name,
							'user_email' 		=> $row->user_email,
							'user_dept' 		=> $row->user_dept
						);	
							
			return $user;
		}
		return NULL;
    }
	
    function authenticate_student($username, $password) {
		$c_tbl = 'pg_appl_candidates';
		//echo $username . " ==== . ".$password;
		$this->db->select('*');
		$this->db->from($c_tbl);
		$this->db->where('LOWER(pg_appl_code)', trim(strtolower($username)));
		$this->db->where('LOWER(pg_appl_password)', trim(strtolower($password)));
		$query = $this->db->get();	
		
		if ($query->num_rows() == 1) {
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
			$rank = array('60PCT' => $rank_60pct, '40PCT' => $rank_40pct, 'CTGR'		=> $row->pg_appl_ctgr);
			
			$student = array(
							'session_id'	  => md5(date('Ymdhis')),
							'student_name'    => $row->pg_appl_name, 
							'student_email'   => $row->pg_appl_email,
							'student_mobile'  => $row->pg_appl_mobile,
							'student_pic'     => $row->pg_appl_profile_pic,
							'rank'     		  => $rank
						);
			
			$this->session->set_userdata('appl_subj',   $this->configmodel->getPgSubjectNameByCode($row->pg_appl_subj));
			$this->session->set_userdata('appl_code',   $row->pg_appl_code);	
			$this->session->set_userdata('appl_status', $row->pg_appl_status);
			$this->session->set_userdata('user_role', 'student');
			
			return $student;
		} else {
		
		}
		return NULL;
    }	
	
	
	
	//***************** USER : START ****************
	//search user: Done
	function getUsers(){
		$where = '';
		if($_POST['user_name'] !=null && $_POST['user_name'] !=''){
			$where .= ' AND UPPER(user_name) like "'.strtoupper($_POST['user_name'].'"');
		}
		if($_POST['user_firstname'] !=null && $_POST['user_firstname'] !=''){
			$where .= ' AND UPPER(user_firstname) like "%'.strtoupper($_POST['user_firstname']).'%"';
		}
		if($_POST['user_lastname'] !=null && $_POST['user_lastname'] !=''){
			$where .= ' AND UPPER(user_lastname) like "%'.strtoupper($_POST['user_lastname']).'%"';
		}
		if($_POST['user_phone'] !=null && $_POST['user_phone'] !=''){
			$where .= ' AND UPPER(user_phone) like "'.strtoupper($_POST['user_phone'].'"');
		}
		if($_POST['user_dept'] !=null && $_POST['user_dept'] !='' && $_POST['user_dept'] !='EMPTY'){
			$where .= ' AND UPPER(user_dept) like "'.strtoupper($_POST['user_dept'].'"');
		}
		if($_POST['role'] !=null && $_POST['role'] !='' && $_POST['role'] !='EMPTY'){
			$where .= ' AND UPPER(role) like "'.strtoupper($_POST['role'].'"');
		}
		
		$sql = "SELECT user_id, role, user_firstname, user_lastname, user_name, user_phone, user_dept, subj_name as user_dept_name, is_active as user_is_active 
				FROM users 
				LEFT OUTER JOIN cnf_pgsubj ON subj_code=user_dept
				WHERE 1=1 ".$where." ORDER BY user_name";
		
		$query = $this->db->query($sql);
		$results = $query->result();
		return $results;
	}
	
	//create user : Done
	function insertUser() {
		$user_table = "users";
		$created_on = gmdate('Y-m-d h:i:s');
		$modified_on = $created_on;
		$created_by = $this->session->userdata['user']['user_name'];
		$modified_by = $created_by;
		
		$is_user_flag = $this->isUserExists($this->input->post('user_name'));
		
		$results = array();
		if($is_user_flag){
			$results['status'] = false;
			$results['cause'] = 'Username already in used';
		}else{
			$userpassword = $this->generatePassword();
			$data = array(
		              'role'			=>	$this->input->post('role'),
		              'user_firstname'	=>	$this->input->post('user_firstname'),
		              'user_lastname'	=>	$this->input->post('user_lastname'),
		              'user_name'		=>	$this->input->post('user_name'),
		              'user_password'	=>	$userpassword,
		              'user_phone'		=>	$this->input->post('user_phone'),
		              'user_dept'		=>	($this->input->post('user_dept') == 'EMPTY') ? '' : $this->input->post('user_dept'),
		              'is_active'		=>	($this->input->post('user_is_active') == 'on') ? 1 : 0,
		              'created_on'		=>	$created_on,
		              'modified_on'		=>	$modified_on,
					  'created_by'		=>	$created_by,
					  'modified_by'		=>	$modified_by
		            );
		    $status = $this->db->insert($user_table, $data);
			if($status){
				$results['status'] = true;
				$results['password'] = $userpassword;
			}else{
				$results['status'] = false;
				$results['cause'] = '';
			}
		}
		return $results;
	}
	
	//update user : Done
	function updateUser() {
		$user_table = "users";
		$modified_on = date('Y-m-d h:i:s');
		$modified_by = $this->session->userdata['user']['user_name'];
		
		$data = array(
	              'role'			=>	$this->input->post('role'),
	              'user_firstname'	=>	$this->input->post('user_firstname'),
	              'user_lastname'	=>	$this->input->post('user_lastname'),
	              'user_phone'		=>	$this->input->post('user_phone'),
	              'user_dept'		=>	($this->input->post('user_dept') == 'EMPTY') ? '' : $this->input->post('user_dept'),
	              'is_active'		=>	($this->input->post('user_is_active') == 'on') ? '1': '0',
	              'modified_on'		=>	$modified_on,
				  'modified_by'		=>	$modified_by
	            );
		//print_r($data); exit();
		
		$this->db->where('user_id', $this->input->post('record_id'));					
		$status = $this->db->update($user_table, $data);
		
		return $status;
	}	
	
	//delete user : Done
	function deleteUser($id) {
		$user_table = "users";
		$this->db->delete($user_table, array('user_id' => $id)); 
		return "DELETED";
	}	
	
	//check whether user is exists or not
	function isUserExists($userName){
		$sql = "SELECT * FROM users WHERE user_name = '". $userName . "'";
		$query = $this->db->query($sql);
		$results = $query->result();
		if(count($results) > 0){
			return true;
		}else{
			return false;
		}
	}
	
	//***************** USER : END ****************
	//change password by the user himself
	function changePassword() {
		$user_table = "users";
		$modified_on = gmdate('Y-m-d h:i:s');
		$modified_by = $this->session->userdata['user']['user_name'];
		
		$data = array(
	              'user_password'	=>	$this->input->post('user_password'),
	              'modified_on'		=>	$modified_on,
				  'modified_by'		=>	$modified_by
	            );
				
				
		$this->db->where('user_id', $this->session->userdata['user']['user_id']);					
		$status = $this->db->update($user_table, $data);
		return $status;
	}
	
	
	function getDetailsForResetPassword() {
		$u_tbl = 'users';
		$this->db->select(array('user_id', 'role', 'user_firstname', 'user_lastname', 'user_name', 'user_dept', 'user_phone', 'is_active'));
		$this->db->from($u_tbl);
		
		if($this->input->post('user_firstname') != null && $this->input->post('user_firstname') != ''){
			$this->db->like('lower(user_firstname)',  strtolower($this->input->post('user_firstname')), 'both');			
		}
		if($this->input->post('user_lastname') != null && $this->input->post('user_lastname') != ''){
			$this->db->where('lower(user_lastname)',  strtolower($this->input->post('user_lastname')));			
		}
		if($this->input->post('user_phone') != null && $this->input->post('user_phone') != ''){
			$this->db->where('lower(user_phone)',  strtolower($this->input->post('user_phone')));			
		}
		if($this->input->post('user_name') != null && $this->input->post('user_name') != ''){
			$this->db->like('lower(user_name)',  strtolower($this->input->post('user_name')), 'both');			
		}

		$query = $this->db->get();
		$r = $query->result();
		
		//echo $this->db->last_query();exit();
		
		$info = array();
		if(count($r) > 0) {
			for($i=0; $i<count($r); $i++){
				$info[$i] = array(
							'user_id'		=>	$r[$i]->user_id,
							'role'			=>	$r[$i]->role,
							'user_firstname'=>	$r[$i]->user_firstname,
							'user_lastname'	=>	$r[$i]->user_lastname,
							'user_name'		=>	$r[$i]->user_name,
							'user_dept'		=>	$this->configmodel->getPgSubjectNameByCode($r[$i]->user_dept),
							'user_phone'	=>	$r[$i]->user_phone,
						);
						
			}
		}				
		return $info;			
	}
	
	
	function setUserPasswordByUserId($user_id){
		$user_table = "users";
		$this->db->select('*');
		$this->db->from($user_table);
		$this->db->where('user_id', $user_id);
		$query = $this->db->get();	
		
		if ($query->num_rows() == 1) {
			$row = $query->row(); 
			
			$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
			$pass = substr(str_shuffle($chars),0,8);
			
			$status  = $this->setPassword($user_id, $pass);				
			
			$user = array(
							'user_id' => $row->user_id,
							'status' => $status,
							'user_firstname' => $row->user_firstname,
							'user_lastname' => $row->user_lastname,
							'user_name' => $row->user_name,
							'user_phone' => $row->user_phone,
							'user_email' => "",
							'user_password' => $pass
						);
			
			return $user;
		}
		return NULL;
	}
	
	function setPassword($userId, $pass) {
		$user_table = "users";
		$modified_on = date('Y-m-d h:i:s');
		$modified_by = $this->session->userdata['user']['user_name'];
		
		$data = array(
	              'user_password'	=>	$pass,
	              'modified_on'		=>	$modified_on,
				  'modified_by'		=>	$modified_by
	            );
		$this->db->where('user_id', $userId);					
		$status = $this->db->update($user_table, $data);
		return $status;
	}
	
	function setStudentPasswordByStudentId($pg_appl_sl_num){
		$pg_appl_candidates_table = "pg_appl_candidates";
		$this->db->select('*');
		$this->db->from($pg_appl_candidates_table);
		$this->db->where('pg_appl_sl_num', $pg_appl_sl_num);
		$query = $this->db->get();	
		
		if ($query->num_rows() == 1) {
			$row = $query->row(); 
			
			$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
			$pass = substr(str_shuffle($chars),0,8);
			
			$status  = $this->setStudentPassword($pg_appl_sl_num, $pass);				
			
			$user = array(
							'appl_name' => $row->pg_appl_name,
							'user_name' => $row->pg_appl_code,
							'status' 	=> $status,
							'user_phone' => $row->pg_appl_mobile,
							'user_email' => $row->pg_appl_email,
							'user_password' => $pass
						);
			
			return $user;
		}
		return NULL;
	}
	
	function setStudentPassword($pg_appl_sl_num, $pass) {
		$user_table = "pg_appl_candidates";
		$modified_on = date('Y-m-d h:i:s');
		$modified_by = "student";
		if(isset($this->session->userdata['user'])){
			$modified_by = $this->session->userdata['user']['user_name'];	
		}
		
		$data = array(
	              'pg_appl_password'	=>	$pass,
	              'pg_appl_modified_on'	=>	$modified_on,
				  'pg_appl_modified_by'	=>	$modified_by
	            );
		$this->db->where('pg_appl_sl_num', $pg_appl_sl_num);					
		$status = $this->db->update($user_table, $data);
		return $status;
	}
	
	

	//generate password : Done
	function generatePassword(){
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$pass = substr(str_shuffle($chars),0,8);
		return $pass;
	}
	
	//send password
	function getUserPasswordByEmail($email){
		$user_table = "users";
		$this->db->select('*');
		$this->db->from($user_table);
		$this->db->where('user_email', $email);
		$this->db->where('is_active', 1);
		$query = $this->db->get();	
		
		if ($query->num_rows() == 1) {
			$row = $query->row(); 
			
			$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
			$pass = substr(str_shuffle($chars),0,8);
			
			$user = array(
							'emp_firstname' => $row->user_firstname,
							'emp_lastname' => $row->user_lastname,
							'user_name' => $row->user_name,
							'user_email' => $row->user_email,
							'user_password' => $pass
						);	
			$this->setPassword($email, $pass);				
			return $user;
		}
		return NULL;
	}
	

	
	//send password
	function getUserPasswordByUserId($user_id){
		$user_table = "users";
		$this->db->select('*');
		$this->db->from($user_table);
		$this->db->where('user_id', $user_id);
		$query = $this->db->get();	
		
		if ($query->num_rows() == 1) {
			$row = $query->row(); 
			
			$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
			$pass = substr(str_shuffle($chars),0,8);
			
			$user = array(
							'user_id' => $row->user_id,
							'user_firstname' => $row->user_firstname,
							'user_lastname' => $row->user_lastname,
							'user_name' => $row->user_name,
							'user_password' => $pass
						);	
			$this->setPassword($user_id, $pass);				
			return $user;
		}
		return NULL;
	}
	
	
	
	
		
	
	/*/last user activities
	function getActivities($username, $num = 10) {
		$a_tbl = 'appl_trans_history';
		$this->db->select(array('ath_form_num', 'ath_event', 'ath_event_date'));
		$this->db->from($a_tbl);
		$this->db->where('ath_event_by', $username);
		$this->db->order_by('ath_event_date', 'DESC');
		$this->db->limit($num);	
		$query = $this->db->get();
		$r = $query->result();
		
		return $r;
	}	
	*/

}
?>