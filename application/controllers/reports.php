<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper( array('url', 'form', 'text') );
		$this->load->library('authenticate', 'session');
		$this->load->model('reportmodel');
		$this->load->model('resultmodel');
		$this->load->model('admissionmodel');
		$this->load->model('configmodel');
		$this->load->model('staticconfigmodel');
	}
	
	//payments
	function payments() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Staff" ||
			$this->session->userdata['user']['user_role'] == "Center" || $this->session->userdata['user']['user_role'] == "Verifier" ) {
				$data['page_title'] = "Payment Report";
				$this->load->view('header', $data);
				$this->load->view('reports/payments', $data);
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	//load payments by AJAX
	function loadpayments() {
		$per_page = getRecordsPerPage('records_per_page_small');
		echo json_encode($this->reportmodel->getAllPaymentsByDay($_REQUEST['date'], $_REQUEST['page'], $per_page));
	}

	//download payments in excel
	function downloadpayments() {
		$this->load->library("excel");
		$this->excel->setActiveSheetIndex(0);
		$filename = "payments" . date('Ymdhis'). ".xls";
		$data = $this->reportmodel->getAllChallansForDownload();
		$this->excel->create_excel($filename, $data);
	}
	
	//seatexams
	function seatexams() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Staff" ||
			$this->session->userdata['user']['user_role'] == "Center") {
				$data['page_title'] = "Examination Seating Arrangement";
				
				$data['exams_options'] 		= $this->configmodel->getExaminationOptions();
				$data['pgsubject_options'] 	= array();//$this->configmodel->getPostGraduateSubjectOption();
				$data['halls_options'] 		= array();
				
				$this->load->view('header', $data);
				$this->load->view('reports/seatexams', $data);
			} else {
				redirect('users/unauthorised');
			}
		}	
	}
	
	//load payments by AJAX
	function loadseatarrangements() {
		$per_page = getRecordsPerPage('records_per_page_small');
		echo json_encode($this->reportmodel->getAllSeatingArrangements($_REQUEST['page'], $per_page));
	}

	//download load payments by AJAX
	function downloadseatarrangements() {
		$downloadtype = $_REQUEST['downloadtype'];
		
		if($downloadtype == 'excel'){
			$this->reportmodel->downloadAllSeatingArrangementsCSV();
		}else
		if($downloadtype == 'pdf'){
			$results = $this->reportmodel->downloadAllSeatingArrangementsPDF();
			$this->load->library('pdf');
			if($results != NULL) {
				$exam_subject = isset($_REQUEST['exam_subject'])?$_REQUEST['exam_subject'] : null;
				$hall_id = isset($_REQUEST['hall_id'])?$_REQUEST['hall_id']:null;
				$exam_id = $_REQUEST['exam_id'];
				
				$file_name = "SEAT-ARRANGEMENT-";
				if($exam_subject != null && $exam_subject != '' && $exam_subject != 'EMPTY'){
					$file_name .= "-".$exam_subject; 
				}
				if($hall_id != null && $hall_id != '' && $hall_id != 'EMPTY'){
					$file_name .= "-".$hall_id; 
				}
				$file_name .= ".pdf";
				//print_r($results);
				$this->pdf->convert_html_seats_to_pdf($results, $file_name);	
			}
		}	
	}

	/** /download payments in excel
	function downloadseatarrangements() {
		$this->load->library("excel");
		$this->excel->setActiveSheetIndex(0);
		$filename = "payments" . date('Ymdhis'). ".xls";
		$data = $this->reportmodel->getAllChallansForDownload();
		$this->excel->create_excel($filename, $data);
	}**/
	
	//===================== RANK LIST ================= : START
	//download meritlist in pdf
	function meritlists() {
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			$data['result']	= array();
				$data['page_title'] = "Download Merit Lists";
				$this->load->view('header', $data);
				
				$data['subject_options']  = $this->configmodel->getPgSubjectOptions();
				$data['category_options'] = $this->staticconfigmodel->getSeatCategoryOption();
				
				$data['seat_ctgry'] = $this->input->post('seat_ctgry');
				$data['pg_subject'] = $this->input->post('pg_subject');
				
				//echo  $this->input->post('seat_ctgry'). $this->input->post('pg_subject'); exit();
				
				$data['result']	= $this->resultmodel->getMeritLists($this->input->post('pg_subject'), $this->input->post('seat_ctgry'));
				
				$this->load->view('reports/meritlists', $data);
		}
	}
	
	function downloadmerits($resv_code, $merit_type_no, $seat_ctgry, $page_no){
		//$this->output->enable_profiler(TRUE);
		if ( !$this->authenticate->is_logged_in()) {
			redirect('users/login');
		} else {
			if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center" ||  $this->session->userdata['user']['user_role'] == "Staff") {
				//echo $resv_code ." ". $merit_type_no . "  " . $seat_ctgry . "   ". $page_no . "\n"; exit();
				$this->load->library('pdf');
				
				$form = $this->resultmodel->getMeritListData($resv_code, $merit_type_no, $seat_ctgry, $page_no);
				
				//print_r($form); exit();
				
				if($form != NULL) {
					$form['header'] = admissionName() . "PROVISIONAL RANKLIST OF <br/> SESSION -" . getCurrentSession();
					$form['univ_logo'] = $this->config->base_url() . 'assets/img/bu_logo90.jpg';
					$this->pdf->convert_html_meritlist_to_pdf($form, 'RANK-LIST-'.$form['info']['seat_ctgry']."-".$form['info']['resv_name'].".pdf", false);	
				}
				
			} else {
				redirect('users/unauthorised');
			}
		}
	}
	function downloadmeritspublic($resv_code, $merit_type_no, $seat_ctgry, $page_no){
		//$this->output->enable_profiler(TRUE);
		//if ( !$this->authenticate->is_logged_in()) {
		//	redirect('users/login');
		//} else {
			//if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center") {
				//echo $resv_code ." ". $merit_type_no . "  " . $seat_ctgry . "   ". $page_no . "\n"; exit();
				$this->load->library('pdf');
				
				$form = $this->resultmodel->getMeritListData($resv_code, $merit_type_no, $seat_ctgry, $page_no);
				
				//print_r($form); exit();
				
				if($form != NULL) {
					$form['header'] = admissionName() . "PROVISIONAL RANKLIST OF <br/> SESSION -" . getCurrentSession();
					$form['univ_logo'] = $this->config->base_url() . 'assets/img/bu_logo90.jpg';
					$this->pdf->convert_html_meritlist_to_pdf($form, 'RANK-LIST-'.$form['info']['seat_ctgry']."-".$form['info']['resv_name'].".pdf", true);	
				}
				
			//} else {
			//	redirect('users/unauthorised');
			//}
		//}
	}
	//===================== RANK LIST ================= : END
}