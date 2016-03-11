<?php
class Configs extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->helper( array('url', 'form', 'text') );
		$this->load->library('authenticate', 'session');
		
		$this->load->model('staticconfigmodel');
		$this->load->model('configmodel');
		$this->load->model('usermodel');
	}

	//************* SESSION : START ***********
	function sessions() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				$data['sessions'] = $this->configmodel->getAllSessions();
				$data['page_title'] = "Configure Sessions";
				$this->load->view('header', $data);
				$this->load->view('configs/sessions', $data);
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	function loadsessions() {
		echo json_encode($this->configmodel->getAllSessions());
	}	
	
	function createsession() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				if($this->input->post('form_action') == 'add') {
					$status = $this->configmodel->createSession();
					if($status){
						$this->session->set_flashdata('success', 'Record created succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not created');
					}
					redirect('configs/sessions');	
				} elseif($this->input->post('form_action') == 'edit') {
					$status = $this->configmodel->updateSession();
					if($status){
						$this->session->set_flashdata('success', 'Record updated succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not updated');
					}
					redirect('configs/sessions');	
				}
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	function delsession() {
		echo $this->configmodel->deleteSession($_POST['id']);
	}	
	//************* SESSION : END ***********
	
	//************* RELIGION : START ***********
	function religions() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				$data['religions'] = $this->configmodel->getAllreligions();
				$data['page_title'] = "Configure religions";
				$this->load->view('header', $data);
				$this->load->view('configs/religions', $data);
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	function loadreligions() {
		echo json_encode($this->configmodel->getAllreligions());
	}	
	
	function createreligion() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				if($this->input->post('form_action') == 'add') {
					$status = $this->configmodel->createreligion();
					if($status){
						$this->session->set_flashdata('success', 'Record created succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not created');
					}
					redirect('configs/religions');	
				} elseif($this->input->post('form_action') == 'edit') {
					$status = $this->configmodel->updatereligion();
					if($status){
						$this->session->set_flashdata('success', 'Record updated succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not updated');
					}
					redirect('configs/religions');	
				}
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	function delreligion() {
		echo $this->configmodel->deletereligion($_POST['id']);
	}
	//************* RELIGION : END ***********
	
	//************* RESERVATION : START ***********
	function reservations() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				$data['reservations'] = $this->configmodel->getAllReservations();
				$data['page_title'] = "Configure Reservations";
				$this->load->view('header', $data);
				$this->load->view('configs/reservations', $data);
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	// load list of reservation in AJAX 
	function loadreservations() {
		echo json_encode($this->configmodel->getAllReservations());
	}	
	
	//add reservation item
	function createreservation() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				if($this->input->post('form_action') == 'add') {
					$status = $this->configmodel->createReservation();
					if($status){
						$this->session->set_flashdata('success', 'Record created succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not created');
					}
					redirect('configs/reservations');	
				} elseif($this->input->post('form_action') == 'edit') {
					$status = $this->configmodel->updateReservation();
					if($status){
						$this->session->set_flashdata('success', 'Record updated succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not updated');
					}
					redirect('configs/reservations');	
				}
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	//delete reservation item
	function delreservation() {
		echo $this->configmodel->deleteReservation($_POST['id']);
	}	
	//************* RESERVATION : END ***********	
	
	//************* ORGANIZATIONS : START*********
	function organizations() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				$data['organization_category_options'] 	= $this->staticconfigmodel->getOrganizationCtgrOption();
				$data['state_options'] 	= $this->configmodel->getStateOptionWithOutCode();
				$data['organizations'] 	= array();
				
				$data['page_title'] = "Configure Organizations";
				$this->load->view('header', $data);
				$this->load->view('configs/organizations', $data);
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	function loadorganizations() {
		echo json_encode($this->configmodel->getAllOrganizationsByCriteria($_POST['organization_ctgry'], $_POST['organization_state'], $_POST['organization_name']));
	}	
	
	function createorganization() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				if($this->input->post('form_action') == 'add') {
					$status = $this->configmodel->createOrganization();
					if($status){
						$this->session->set_flashdata('success', 'Record created succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not created');
					}
					redirect('configs/organizations');	
				} elseif($this->input->post('form_action') == 'edit') {
					$status = $this->configmodel->updateOrganization();
					if($status){
						$this->session->set_flashdata('success', 'Record updated succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not updated');
					}
					redirect('configs/organizations');	
				}
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	function delorganization() {
		echo $this->configmodel->deleteOrganization($_POST['id']);
	}	
	//************* ORGANIZATIONS : END***********
	
	//************* COLLEGES : START*********
	function colleges() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				$data['college_category_options'] 	= $this->staticconfigmodel->getCollegeCtgrOption();
				$data['colleges'] = $this->configmodel->getAllColleges();
				$data['page_title'] = "Configure Colleges";
				$this->load->view('header', $data);
				$this->load->view('configs/colleges', $data);
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	function loadcolleges() {
		echo json_encode($this->configmodel->getAllColleges());
	}	
	
	function createcollege() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				if($this->input->post('form_action') == 'add') {
					$status = $this->configmodel->createCollege();
					if($status){
						$this->session->set_flashdata('success', 'Record created succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not created');
					}
					redirect('configs/colleges');	
				} elseif($this->input->post('form_action') == 'edit') {
					$status = $this->configmodel->updateCollege();
					if($status){
						$this->session->set_flashdata('success', 'Record updated succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not updated');
					}
					redirect('configs/colleges');	
				}
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	function delcollege() {
		echo $this->configmodel->deleteCollege($_POST['id']);
	}	
	//************* COLLEGES : END***********
	
	//************* COLLEGE PG SUBJECT ASSOCIATION : START*********
	function collegepgsubject() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				$data['college_options'] = $this->configmodel->getCollegeOptions();
				$data['subject_options'] = array();//$this->configmodel->getPostGraduateSubjectOptionByCollege();
				$data['page_title'] = "Configure Post Graduate Subjects in Colleges";
				$this->load->view('header', $data);
				$this->load->view('configs/collegepgsubject', $data);
			} else {
				redirect('users/unauthorised');
			}
		}
	}
	
	function collegepgsubjectassoc() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				if($this->input->post('form_action') == 'add') {
					$status = $this->configmodel->createCollegePgSubjAssoc();
					if($status){
						$this->session->set_flashdata('success', 'Record created succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not created');
					}
					redirect('configs/collegepgsubject');	
				} 
			} else {
				redirect('users/unauthorised');
			}
		}
	}
	
	function loadcollegepgsubjects() {
		echo json_encode($this->configmodel->getPgSubjOptionByCollege($_POST['col_code']));
	}
	//************* COLLEGE PG SUBJECT ASSOCIATION : END*********
    
	
	//************* SUBJECTS : START ***********************
	function subjects() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				$data['subjects'] = $this->configmodel->getAllSubjects();
				$data['page_title'] = "Configure Subjects";
				$this->load->view('header', $data);
				$this->load->view('configs/subjects', $data);
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	function loadsubjects() {
		echo json_encode($this->configmodel->getAllSubjects());
	}	
	
	function createsubject() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				if($this->input->post('form_action') == 'add') {
					$status = $this->configmodel->createSubject();
					if($status){
						$this->session->set_flashdata('success', 'Record created succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not created');
					}
					redirect('configs/subjects');	
				} elseif($this->input->post('form_action') == 'edit') {
					$status = $this->configmodel->updateSubject();
					if($status){
						$this->session->set_flashdata('success', 'Record updated succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not updated');
					}
					redirect('configs/subjects');	
				}
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	function delugsubject() {
		echo $this->configmodel->deleteSubject($_POST['id']);
	}		
	//************* SUBJECTS : END ***********************
	
	//************* COURSE : START ***********************
	function courses() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				$data['courses'] = $this->configmodel->getAllCourses();
				$data['page_title'] = "Configure Courses";
				$this->load->view('header', $data);
				$this->load->view('configs/courses', $data);
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	function loadcourses() {
		echo json_encode($this->configmodel->getAllCourses());
	}	
	
	function createcourse() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				if($this->input->post('form_action') == 'add') {
					$status = $this->configmodel->createCourse();
					if($status){
						$this->session->set_flashdata('success', 'Record created succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not created');
					}
					redirect('configs/courses');	
				} elseif($this->input->post('form_action') == 'edit') {
					$status = $this->configmodel->updateCourse();
					if($status){
						$this->session->set_flashdata('success', 'Record updated succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not updated');
					}
					redirect('configs/courses');	
				}
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	function delcourse() {
		echo $this->configmodel->deleteCourse($_POST['id']);
	}	
	//************* COURSE : END ***********************
	
	//************* PG SUBJECTS : START *********************
	function pgsubjects() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				$data['course_options'] = $this->configmodel->getCourseOptions();
				$data['subject_options'] = $this->configmodel->getSubjectOptions();
				$data['pg_subjects'] = $this->configmodel->getAllPgSubjects();
				
				$data['page_title'] = "Configure Postgraduate Subjects";
				$this->load->view('header', $data);
				$this->load->view('configs/pgsubjects', $data);
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	function loadpgsubjects() {
		echo json_encode($this->configmodel->getAllPgSubjects());
	}	
	
	function createpgsubject() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				if($this->input->post('form_action') == 'add') {
					$status = $this->configmodel->createPgSubject();
					if($status){
						$this->session->set_flashdata('success', 'Record created succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not created');
					}
					redirect('configs/pgsubjects');	
				} elseif($this->input->post('form_action') == 'edit') {
					$status = $this->configmodel->updatePgSubject();
					if($status){
						$this->session->set_flashdata('success', 'Record updated succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not updated');
					}
					redirect('configs/pgsubjects');	
				}
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	function delpgsubject() {
		echo $this->configmodel->deletePgSubject($_POST['id']);
	}		
	//************* PG SUBJECTS : END ***********************
	
	
	
    //************* PG SUBJECT UG SUBJECT ASSOCIATION : START*********
	function pgugsubjects() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				$data['pgsubject_options'] = $this->configmodel->getPostGraduateSubjectOption();
				$data['ugsubject_options'] = array();//$this->configmodel->getPostGraduateSubjectOptionByCollege();
				$data['page_title'] = "Association between Post Graduate Subjects and Under Graduate Subjects";
				$this->load->view('header', $data);
				$this->load->view('configs/pgugsubjects', $data);
			} else {
				redirect('users/unauthorised');
			}
		}
	}

	function loadpgugsubjects() {
		echo json_encode($this->configmodel->getUgSubjectOptionByPgSubject($_POST['pg_subj_code']));
	}
	
	function pgugsubjectassoc() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				if($this->input->post('form_action') == 'add') {
					$status = $this->configmodel->createPgUgSubjectAssoc();
					if($status){
						$this->session->set_flashdata('success', 'Record created succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not created');
					}
					redirect('configs/pgugsubjects');	
				} 
			} else {
				redirect('users/unauthorised');
			}
		}
	}
	
    //************* PG SUBJECT UG SUBJECT  ASSOCIATION : END*********
		
	
    //************* UG SUBJECT UG SUBJECT ASSOCIATION : START*********
	function pgugugsubjects() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				$data['pgsubject_options'] = $this->configmodel->getPostGraduateSubjectOption();
				$data['ug_subj_code_major_options'] = array();//$this->configmodel->getPostGraduateSubjectOptionByCollege();
				$data['ugsubject_options'] = array();//$this->configmodel->getPostGraduateSubjectOptionByCollege();
				$data['page_title'] = "Association between Under Graduate Subjects and Under Graduate Subjects";
				$this->load->view('header', $data);
				$this->load->view('configs/pgugugsubjects', $data);
			} else {
				redirect('users/unauthorised');
			}
		}
	}

	function loadpgugugsubjects() {
		echo json_encode($this->configmodel->getUgSubjectOptionByUgSubject($_POST['pg_subj_code'], $_POST['ug_subj_code_major']));
	}
	
	function pgugugsubjectassoc() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				if($this->input->post('form_action') == 'add') {
					$status = $this->configmodel->createPgUgUgSubjectAssoc();
					if($status){
						$this->session->set_flashdata('success', 'Record created succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not created');
					}
					redirect('configs/pgugugsubjects');	
				} 
			} else {
				redirect('users/unauthorised');
			}
		}
	}
	
    //************* UG SUBJECT UG SUBJECT  ASSOCIATION : END*********
		
	
	
	//************* BUILDING : START ***********
	function buildings() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				$data['buildings'] = $this->configmodel->getAllBuildings();
				$data['page_title'] = "Configure buildings";
				$this->load->view('header', $data);
				$this->load->view('configs/buildings', $data);
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	function loadbuildings() {
		echo json_encode($this->configmodel->getAllBuildings());
	}	
	
	function createbuilding() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				if($this->input->post('form_action') == 'add') {
					$status = $this->configmodel->createBuilding();
					if($status){
						$this->session->set_flashdata('success', 'Record created succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not created');
					}
					redirect('configs/buildings');	
				} elseif($this->input->post('form_action') == 'edit') {
					$status = $this->configmodel->updateBuilding();
					if($status){
						$this->session->set_flashdata('success', 'Record updated succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not updated');
					}
					redirect('configs/buildings');	
				}
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	function delbuilding() {
		echo $this->configmodel->deleteBuilding($_POST['id']);
	}
	//************* BUILDING : END ***********
	
	
	
	//************* HALL : START ***********
	function halls() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				$data['building_options'] = $this->configmodel->getBuildingOptions();
				$data['halls'] = $this->configmodel->getAllHalls();
				$data['page_title'] = "Configure Halls";
				$this->load->view('header', $data);
				$this->load->view('configs/halls', $data);
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	function loadhalls() {
		echo json_encode($this->configmodel->getAllHalls());
	}	
	
	function createhall() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				if($this->input->post('form_action') == 'add') {
					$status = $this->configmodel->createHall();
					if($status){
						$this->session->set_flashdata('success', 'Record created succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not created');
					}
					redirect('configs/halls');	
				} elseif($this->input->post('form_action') == 'edit') {
					$status = $this->configmodel->updateHall();
					if($status){
						$this->session->set_flashdata('success', 'Record updated succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not updated');
					}
					redirect('configs/halls');	
				}
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	function delhall() {
		echo $this->configmodel->deleteHall($_POST['id']);
	}
	//************* HALL : END ***********
	
	
	//************* SEAT MATRIX : START ***********
	//list all seats
	function seats() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				$data['seat_category_options'] 	= $this->staticconfigmodel->getSeatCategoryOption();
				$data['extra_reservation_options'] 	= $this->staticconfigmodel->getExtraReservationOptions();
				$data['subject_options'] 		= $this->configmodel->getPgSubjectOptions();
				$data['reservation_options'] 	= $this->configmodel->getReservationOptions();
				
				$data['seats'] 					= $this->configmodel->getAllSeats();

				$data['page_title'] = "Configure Seat Matrix";
				$this->load->view('header', $data);
				$this->load->view('configs/seats', $data);
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	
	//************* SEAT MATRIX : END ***********
	

	
	
	
	// load list of seats in AJAX 
	function loadseats() {
		echo json_encode($this->configmodel->getAllSeats());
	}	
	
	//add seat item
	function createseat() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin"){
				if($this->input->post('form_action') == 'add') {
					$status = $this->configmodel->createSeat();
					if($status){
						$this->session->set_flashdata('success', 'Record created succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not created');
					}
					redirect('configs/seats');	
				} elseif($this->input->post('form_action') == 'edit') {
					$status = $this->configmodel->updateSeat();
					if($status){
						$this->session->set_flashdata('success', 'Record updated succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not updated');
					}
					redirect('configs/seats');	
				}
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	//delete seat item
	function delseat() {
		echo $this->configmodel->deleteSeat($_POST['id']);
	}		

	
	//********************  EXAMINATIONS ************************* : START
	function examinations() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center" ){
				$data['examinations'] 	= $this->configmodel->getAllExaminations();
				
				$data['page_title'] 	= "Configure Examination";
				$this->load->view('header', $data);
				$this->load->view('configs/examinations', $data);
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	function loadexaminations() {
		echo json_encode($this->configmodel->getAllExaminations());
	}
	function createexamination() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center"){
				if($this->input->post('form_action') == 'add') {
					$status = $this->configmodel->createExamination();
					if($status){
						$this->session->set_flashdata('success', 'Record created succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not created');
					}
					redirect('configs/examinations');	
				} elseif($this->input->post('form_action') == 'edit') {
					$status = $this->configmodel->updateExamination();
					if($status){
						$this->session->set_flashdata('success', 'Record updated succesfully');	
					}else{
						$this->session->set_flashdata('failure', 'Record not updated');
					}
					redirect('configs/examinations');	
				}
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	function delexamination() {
		echo $this->configmodel->deleteExamination($_POST['id']);
	}
	//********************  EXAMINATIONS ************************* : END
	
	

	
}
