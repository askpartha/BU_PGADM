<?php
class Staticconfigmodel extends CI_Model {

    function __construct() {
        parent::__construct();
		$this->load->database();
		$ci = get_instance();
		$ci->load->helper('string');
    }
	
	//random code genaration
	function randomString($length) {
		$key = '';
		$keys = array_merge(range(0, 9), range('A', 'Z'));

		for ($i = 0; $i < $length; $i++) {
			$key .= $keys[array_rand($keys)];
		}
		return $key;
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
	
	function getUniversityCtgrOption() {
		$arr = array("EMPTY"=>"", "BU"=>"BURDWAN UNIVERSITY", "OU"=>"OTHER UNIVERSITY");
		return $arr;
	}
	
	function getYesNoOption() {
		$arr = array("0"=>"NO", "1"=>"YES");
		return $arr;
	}
	
	function getScheduleTypeOption() {
		$arr = array("EMPTY"=>"", 
					 "ASD"=>"Application Start Date", 
					 "AED"=>"Application Last Date", 
					 "PED"=>"Payment Submission Last Date", 
					 "AD"=>"Admitcard Distribution Date", 
					 "ED"=>"Examination Date",
					 "60RD"=>"60% Rank List Publication Date",
					 "40RD"=>"40% Rank List Publication Date",
					 "60AD"=>"60% Admission Date",
					 "40AD"=>"40% Admission Date",
					 );
		return $arr;
	}
	
	function getTimeCtgrOption(){
		$arr = array("EMPTY"=>"",
					 "16:00:00"=>"4:00. PM", 
					 "00:00:01"=>"Day Start",
					 "23:59:00"=>"Day End", 
					 );
		return $arr;
	}
	
	function getOrganizationCtgrOption() {
		$arr = array("EMPTY"=>"", "1"=>"Secondary Board", "2"=>"Higher Secondary Board", "3"=>"University");
		return $arr;
	}
	
	function getNoticeCtgrOption() {
		$arr = array("EMPTY"=>"", "General"=>"General", "Application"=>"Application", "Admit"=>"Admit", "Examination"=>"Examination", "Rankcard"=>"Rank Card", "Admission"=>"Admission","Result"=>"Result");
		return $arr;
	}
	
	function getCollegeCtgrOption() {
		$arr = array("EMPTY"=>"", "BG"=>"Both", "B"=>"Boys", "G"=>"Girls");
		return $arr;
	}
	
	function getGenderOption() {
		$arr = array("EMPTY"=>"", "M"=>"Male", "F"=>"Female", "T"=>"Transgender");
		return $arr;
	}
	
	function getRoleOption() {
		$arr = array("EMPTY"=>"","Admin"=>"Admin", "Center"=>"Center", "Staff" => "Staff", "Verifier" => "Verifier");
		return $arr;
	}	

	function getSeatCategoryOption(){
		$arr = array("EMPTY"=>"", "60PCT"=>"MERIT", "40PCT"=>"WRITTEN");
		return $arr;
	}
	
	function getExtraReservationOptions(){
		$arr = array("EMPTY"=>"", "PWD"=>"PWD", "SPORTS"=>"SPORTS", "HONS"=>"HONOURS");
		return $arr;
	}
	
	function getApplicationStatusOptions(){
		$arr = array(" > 0"=>"Appl. Submitted", " >= 2"=>"Payment Confirmed", " = 1"=>"Payment Not Confirmed");
		return $arr;
	}
	
	function getExtraResvOptions(){
		$arr = array("EMPTY"=>"", "PWD"=>"PWD", "SPORTS"=>"SPORTS", "HONS"=>"HONOURS");
		return $arr;
	}
	
	function getSpclStatusOptions(){
		$arr = array("EMPTY"=>"", "1"=>"Active", "0"=>"Inactive");
		return $arr;
	}
}
?>