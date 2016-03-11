<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class Pdf {
 
	var $_dompdf = NULL;

	function __construct() {
		require_once APPPATH."third_party/dompdf/dompdf_config.inc.php";
		if(is_null($this->_dompdf)) {
			$this->_dompdf = new DOMPDF();
		}
	}
	
	function convertToPDF($str, $filename, $stream = true, $paper = 'A4', $orientation = 'landscape') {
		$this->_dompdf->load_html($str);
		$this->_dompdf->set_paper($paper, $orientation);
		$this->_dompdf->render();
		if ($stream) {
			$this->_dompdf->stream($filename);
		} else {
			return $this->_dompdf->output();
		}
	}
	
	//APPLICATION FORM
	function convert_html_applform_to_pdf($data, $filename ='', $stream = TRUE, $paper = 'A4', $orientation = 'landscape') {
		$s = "<style type='text/css'>
				body{
					font:9pt Helvetica, serif;
					margin-top: 0.2em;
            		margin-left: 0.2em;
				}
				p {margin:0.2em 0 0 0;padding:0;}
				
				td.header {font-weight:700;font-size:14pt;}
				
				</style>";
		
		$s .= "<table border=0 cellpadding=0 cellspacing=0 style='border-collapse:collapse;table-layout:fixed;width:530pt;margin-bottom:20pt;'>";
		$s .= "<tr style='height:120.0pt'>";
		$s .= "<td style='width:86pt'><img src='" . $data['univ_logo'] . "'></td>";
		$s .= "<td align=center style='width:350pt' class='header'>";
		$s .= "The University of Burdwan<br/>Rajbati, Burdwan, 713104<br/>"._getExamination();
		$s .= "</td>";
		$s .= "<td align=center style='width:94pt'><img src='" . $data['pg_appl_profile_pic'] . "' style='padding:2pt;border:thin solid;border-color:#666;'></td>";
		$s .= "</tr>";
		$s .= "<tr style='height:20.0pt'>";
		$s .= "<td colspan=2 style='width:436pt'>&nbsp;</td>";
		$s .= "<td style='width:94pt; height:20.0pt; border-bottom:thin solid;'></td>";
		$s .= "</tr>";
		$s .= "<tr style='height:12.0pt'>";
		$s .= "<td colspan=2 style='width:436pt'>&nbsp;</td>";
		$s .= "<td align=center style='width:94pt; height:12.0pt; font-size:7pt;'>Signature of the Candidate</td>";
		$s .= "</tr>";
		$s .= "</table>";
			
		$pwd_flag = 'NO';
		$sports_flag = 'NO';
		if($data['pg_appl_pwd'] == 'Y'){
			$pwd_flag = 'YES';
		}
		if($data['pg_appl_sports'] == 'Y'){
			$sports_flag = 'YES';
		}
			
		$s .= "<table border=0 cellpadding=0 cellspacing=0 style='border-collapse:collapse;table-layout:fixed;width:520pt;'>";
		
		$s .= "<tr style='height:20.0pt'>";
  		$s .= "<td style='height:20.0pt; width:100pt;'><b>Application Number:</b></td>";
  		$s .= "<td style='height:20.0pt; width:130pt;'>" . $data['pg_appl_code'] . "</td>";
  		$s .= "<td style='height:20.0pt; width:120pt;'><b>Payment Instrument No:</b></td>";
  		$s .= "<td style='height:20.0pt; width:110pt;'>" . $data['pg_appl_pmt_code'] . "</td>";
 		$s .= "</tr>";
 		$s .= "<tr style='height:20.0pt'>";
  		$s .= "<td style='height:20.0pt; width:100pt;'></td>";
  		$s .= "<td style='height:20.0pt; width:130pt;'></td>";
  		$s .= "<td style='height:20.0pt; width:120pt;'><b>Payment Instrument Date:</b></td>";
  		$s .= "<td style='height:20.0pt; width:110pt;'>" . getDateFormatNoDateBlank($data['appl_inst_date']) . "</td>";
 		$s .= "</tr>";
		
		$s .= "<tr style='height:20.0pt;'>";
  		$s .= "<td style='height:20.0pt; width:100pt; border-top:thin solid;' colspan=4></td>";
 		$s .= "</tr>";
		
		$s .= "<tr style='height:20.0pt'>";
  		$s .= "<td style='height:20.0pt'>Session:</td>";
  		$s .= "<td>" . getCurrentSession() . "</td>";
  		$s .= "<td>Category:</td>";
  		$s .= "<td>" . $data['pg_appl_ctgr_name'] . "</td>";
 		$s .= "</tr>";
 		
 		$s .= "<tr style='height:20.0pt'>";
  		$s .= "<td style='height:20.0pt'>Applied Subject:</td>";
  		$s .= "<td>" . $data['pg_subj_name'] . "</td>";
  		$s .= "<td>Center Preference:</td>";
  		$s .= "<td>" . $data['pg_apl_center_option_name'] . "</td>";
 		$s .= "</tr>"; 	

 		$s .= "<tr style='height:20.0pt'>";
  		$s .= "<td style='height:20.0pt'>Name of Applicant:</td>";
  		$s .= "<td>" . $data['pg_appl_name'] . "</td>";
  		$s .= "<td>Date of Birth:</td>";
  		$s .= "<td>" . getDateFormat($data['pg_appl_dob']) . "</td>";
 		$s .= "</tr>";
 
  		$s .= "<tr style='height:20.0pt'>";
  		$s .= "<td style='height:20.0pt'>Gender:</td>";
  		$s .= "<td>" . $data['pg_appl_gender_desc'] . "</td>";
  		$s .= "<td>Reservation:</td>";
  		$s .= "<td>" . $data['resv_name'] . "</td>";
 		$s .= "</tr>";
 		
 		$s .= "<tr style='height:20.0pt'>";
  		$s .= "<td style='height:20.0pt'>PWD:</td>";
  		$s .= "<td>" . $pwd_flag. "</td>";
  		$s .= "<td>Sports:</td>";
  		$s .= "<td>" . $sports_flag . "</td>";
 		$s .= "</tr>";
 	
 	 	$s .= "<tr style='height:20.0pt'>";
  		$s .= "<td style='height:20.0pt'>Gurdian Name:</td>";
  		$s .= "<td>" . $data['pg_appl_gurd_name'] . "</td>";
  		$s .= "<td></td>";
  		$s .= "<td></td>";
 		$s .= "</tr>";
 
  		$s .= "<tr style='height:20.0pt'>";
  		$s .= "<td style='height:20.0pt'>Address:</td>";
  		$s .= "<td>" . $data['pg_appl_comm_address1'] . "</td>";
  		$s .= "<td>Address 2:</td>";
  		$s .= "<td>" . $data['pg_appl_comm_address2'] . "</td>";
 		$s .= "</tr>";

 		$s .= "<tr style='height:20.0pt'>";
  		$s .= "<td style='height:20.0pt'>City / Town / Village:</td>";
  		$s .= "<td>" . $data['pg_appl_comm_city'] . "</td>";
  		$s .= "<td>District:</td>";
  		$s .= "<td>" . $data['pg_appl_comm_district'] . "</td>";
 		$s .= "</tr>";
 
   		$s .= "<tr style='height:20.0pt'>";
  		$s .= "<td style='height:20.0pt'>State / Union Territory:</td>";
  		$s .= "<td>" . $data['state_name'] . "</td>";
  		$s .= "<td>PIN Code:</td>";
  		$s .= "<td>" . $data['pg_appl_comm_pin'] . "</td>";
 		$s .= "</tr>";
 
  		$s .= "<tr style='height:20.0pt'>";
  		$s .= "<td style='height:20.0pt'>Mobile No:</td>";
  		$s .= "<td>" . $data['pg_appl_mobile'] . "</td>";
  		$s .= "<td></td>";
  		$s .= "<td></td>";
 		$s .= "</tr>";
 
  		$s .= "<tr style='height:20.0pt'>";
  		$s .= "<td style='height:20.0pt'>Email Address:</td>";
  		$s .= "<td colspan=3>" . $data['pg_appl_email'] . "</td>";
 		$s .= "</tr>";
 
		$s .= "<tr style='height:20.0pt'>";
  		$s .= "<td style='height:20.0pt'>BU Registration No:</td>";
  		$s .= "<td>" . $data['pg_appl_bu_reg_no'] . "</td>";
  		$s .= "<td></td>";
  		$s .= "<td></td>";
 		$s .= "</tr>";
		
		$s .= "<tr><td>&nbsp;</td><td></td><td></td><td></td></tr>";
		
 		$s .= "<tr style='height:20.0pt'>";
  		$s .= "<td style='height:20.0pt'>Exam Passed:</td>";
  		$s .= "<td>10th or Equivalent</td>";
  		$s .= "<td>Board / University:</td>";
  		$s .= "<td>" . $data['mp_organization_name'] . "</td>";
 		$s .= "</tr>";		
		
 		$s .= "<tr style='height:20.0pt'>";
  		$s .= "<td style='height:20.0pt'>Year of Passing:</td>";
  		$s .= "<td>" . $data['pg_appl_mp_pyear'] . "</td>";
  		$s .= "<td>Subject(s) Studied:</td>";
  		$s .= "<td>" . $data['pg_appl_mp_subj'] . "</td>";
 		$s .= "</tr>";		
 
  		$s .= "<tr style='height:20.0pt'>";
  		$s .= "<td style='height:20.0pt'>% of Marks:</td>";
  		$s .= "<td>" . $data['pg_appl_mp_pct'] . "</td>";
  		$s .= "<td></td>";
  		$s .= "<td></td>";
 		$s .= "</tr>";
		
		$s .= "<tr><td>&nbsp;</td><td></td><td></td><td></td></tr>";
		
		
		$s .= "<tr style='height:20.0pt'>";
  		$s .= "<td style='height:20.0pt'>Exam Passed:</td>";
  		$s .= "<td>12th/ Equivalent</td>";
  		$s .= "<td>Board / University:</td>";
  		$s .= "<td>" . $data['hs_organization_name'] . "</td>";
 		$s .= "</tr>";		
		
 		$s .= "<tr style='height:20.0pt'>";
  		$s .= "<td style='height:20.0pt'>Year of Passing:</td>";
  		$s .= "<td>" . $data['pg_appl_hs_pyear'] . "</td>";
  		$s .= "<td>Subject(s) Studied:</td>";
  		$s .= "<td>" . $data['pg_appl_hs_subj'] . "</td>";
 		$s .= "</tr>";		
 
  		$s .= "<tr style='height:20.0pt'>";
  		$s .= "<td style='height:20.0pt'>% of Marks:</td>";
  		$s .= "<td>" . $data['pg_appl_hs_pct'] . "</td>";
  		$s .= "<td></td>";
  		$s .= "<td></td>";
 		$s .= "</tr>";
 		
 		$s .= "<tr><td>&nbsp;</td><td></td><td></td><td></td></tr>";
		
		
		$s .= "<tr style='height:20.0pt'>";
  		$s .= "<td style='height:20.0pt'>Exam Passed:</td>";
  		$s .= "<td>Graduation</td>";
  		$s .= "<td>University:</td>";
  		$s .= "<td>" . $data['grad_organization_name'] . "</td>";
 		$s .= "</tr>";		
		
 		$s .= "<tr style='height:20.0pt'>";
  		$s .= "<td style='height:20.0pt'>Year of Passing:</td>";
  		$s .= "<td>" . $data['pg_appl_grad_pyear'] . "</td>";
  		$s .= "<td>Subject(s) Studied:</td>";
  		$s .= "<td>" . $data['ug_major_subj_name'] . "</td>";
 		$s .= "</tr>";		
 
  		$s .= "<tr style='height:20.0pt'>";
  		$s .= "<td style='height:20.0pt'>% of Marks:</td>";
  		$s .= "<td>" . $data['pg_appl_grad_pct'] . "</td>";
  		$s .= "<td>Subject(s) Studied Optional:</td>";
  		$s .= "<td>" . $data['ug_minor_subj_name'] . "</td>";
 		$s .= "</tr>";
 		
 		$s .= "<tr><td>&nbsp;</td><td></td><td></td><td></td></tr>";
 		$s .= "<tr><td>&nbsp;</td><td></td><td></td><td></td></tr>";
 		$s .= "<tr><td>&nbsp;</td><td></td><td></td><td></td></tr>";
		$s .= "<tr><td>&nbsp;</td><td></td><td></td><td></td></tr>";
		
		$s .= "<tr><td style='height:20.0pt; width:100pt; border-top:thin solid;' colspan=4></td></tr>";
		
		$s .= "<tr><td colspan=2><small>Form submitted on: " .  getDateFormat($data['pg_appl_created_on']) . "</small></td><td></td><td><small> Download On : ". date("d-M-Y h:i:s", time()) ."</small></td></tr>";
		
		$s .= "</table>";
		//echo $s;
			
		$this->convertToPDF($s, $filename, true, 'A4', 'portrait');
	}	
	
	//ADMISSION TEST ADMIT CARD
	function convert_html_admit_to_pdf($data, $filename ='', $stream = TRUE, $paper = 'A4', $orientation = 'portrait') {
		$html = '';
		
	 	if(count($data)>0){
	 		$filename = $data['appl_code'] . "_Admitcard.pdf";
			
			$html = "<style type='text/css'>
				body{
					font:14pt Helvetica, serif;
					margin-top: 0.2em;
            		margin-left: 0.2em;
				}
				p {margin:0.2em 0 0 0;padding:0;}
				
				td.header {font-weight:700;font-size:16pt;}
				
				</style>";
			
			$s = "";
			$s .= "<table border=2 cellpadding=10 cellspacing=0 style='text-align: center; border-collapse:collapse;table-layout:fixed;width:650pt;margin-bottom:20pt;margin-left:50pt;'><tr><td>";
			$s .= "<table border=0 cellpadding=0 cellspacing=0 style='text-align: center; border-collapse:collapse;table-layout:fixed;width:630pt;margin-bottom:20pt;'>";
			$s .= "<tr style='height:120.0pt'>";
			$s .= "<td style='width:86pt'><img src='" . $data['logo'] . "'></td>";
			$s .= "<td align=center style='width:450pt' class='header'>";
			$s .= "THE UNIVERSITY OF BURDWAN<br/>RAJBATI, BURDWAN, 713104<br/>"._getExamination()."<br/><br/> <B><h2>HALL TICKET</h2></b>";
			$s .= "</td>";
			$s .= "<td align=center style='width:94pt'><img src='" . $data['appl_image'] . "' style='padding:2pt;border:thin solid;border-color:#666;'></td>";
			$s .= "</tr>";
			
			$s .= "<tr style='height:8.0pt'>";
			$s .= "<td colspan=2 style='width:436pt'>&nbsp;</td>";
			$s .= "<td align=center style='width:114pt; height:8; font-size:7pt; border-bottom:thin solid;'>Signature of the Candidate</td>";
			$s .= "</tr>";
			$s .= "</table>";
			
			
			$s .= "<table border=0 cellpadding=0 cellspacing=0 style='border-collapse:collapse;table-layout:fixed;width:630pt;margin-bottom:20pt;'>";
			
			$s .= "<tr style='height:30.0pt'>";
			$s .= "<td style='width:120pt'><b>CANDIDATE NAME:</b></td>";
			$s .= "<td style='width:165pt'>".$data['appl_name']."</td>";
			$s .= "<td style='width:125pt'><b>APPLICATION NO:</b></td>";
			$s .= "<td style='width:120pt'> &nbsp;".$data['appl_code']."</td>";
			$s .= "</tr>";
		
			$s .= "<tr><td>&nbsp;</td><td></td><td></td><td></td></tr>";
			
			$s .= "<tr style='height:30.0pt'>";
			$s .= "<td style='width:120pt'><b>ROLL NUMBER:</b></td>";
			$s .= "<td style='width:165pt'>".$data['roll_no']."</td>";
			$s .= "<td style='width:125pt'></td>";
			$s .= "<td style='width:120pt'></td>";
			$s .= "</tr>";
		
			$s .= "<tr><td>&nbsp;</td><td></td><td></td><td></td></tr>";
			
			$s .= "<tr style='height:30.0pt'>";
			$s .= "<td style='width:120pt'><b>GURDIAN NAME:</b></td>";
			$s .= "<td style='width:165pt'>".$data['appl_gurd_name']."</td>";
			$s .= "<td style='width:125pt'><b>SUBJECT:</b></td>";
			$s .= "<td style='width:120pt'> &nbsp;".$data['appl_subject']."</td>";
			$s .= "</tr>";
			
			$s .= "<tr><td>&nbsp;</td><td></td><td></td><td></td></tr>";
			$s .= "<tr><td>&nbsp;</td><td></td><td></td><td></td></tr>";
			
			$s .= "<tr style='height:35.0pt'>";
			$s .= "<td style='width:120pt'><b>DATE:</b></td>";
			$s .= "<td colspan=3>".$data['exam_date']."</td>";
			$s .= "</tr>";

			$s .= "<tr><td>&nbsp;</td><td></td><td></td><td></td></tr>";
						
			$s .= "<tr style='height:35.0pt'>";
			$s .= "<td style='width:120pt'><b>TIME:</b></td>";
			$s .= "<td colspan=3>".$data['exam_time']."</td>";
			$s .= "</tr>";
			
			$s .= "<tr><td>&nbsp;</td><td></td><td></td><td></td></tr>";
			
			$s .= "<tr style='height:25.0pt'>";
			$s .= "<td style='width:120pt'><b>VENUE:</b></td>";
			$s .= "<td colspan=3>Hall - ".$data['exam_venue']."</td>";
			$s .= "</tr>";
			
			$s .= "<tr><td>&nbsp;</td><td></td><td></td><td></td></tr>";
			
			$s .= "<tr style='height:10.0pt'>";
			$s .= "<td style='width:120pt' colspan=2></td>";
			$s .= "<td colspan=2 style='text-align:center'><img src='" . $data['auth_signature'] . "' style='padding:2pt;'><br/>".$data['auth_designation']."</td>";
			$s .= "</tr>";
			
			
			
			$s .= "</table>";
			$s .= "</td></tr></table>";
			$s .= "<span style='margin-left:50pt;'>";
			$s .= "</span>";
			
			
			//echo $s; exit();
	 	}
	 	$this->convertToPDF($s, $filename, $stream, $paper);	 
	}

	//RANK CARD
	function convert_html_rank_to_pdf($data, $filename ='', $stream = TRUE, $paper = 'A6', $orientation = 'landscape') {
		$s = "<style type='text/css'>
				body{
					font:8pt Helvetica, serif;
					margin-top: 0.2em;
            		margin-left: 0.2em;
				}
				p {margin:0.2em 0 0 0;padding:0;}
				
				td.header {font-weight:700;font-size:14pt;}
				
				</style>";
		
		$s .= "<table border=0 cellpadding=0 cellspacing=0 style='border-collapse:collapse;table-layout:fixed;width:420pt;margin-bottom:20pt;'>";
		$s .= "<tr style='height:120.0pt'>";
		$s .= "<td style='width:86pt'><img src='" . $data['univ_logo'] . "'></td>";
		$s .= "<td align=center style='width:340pt' class='header'>";
		$s .= "The University of Burdwan<br/>Rajbati, Burdwan, 713104<br/>RANK CARD - " . admissionName() ;
		$s .= "</td>";
		$s .= "<td align=center style='width:94pt'><img src='" . $data['appl_profile_pic'] . "' style='padding:2pt;border:thin solid;border-color:#666;'></td>";
		$s .= "</tr>";
		$s .= "<tr style='height:20.0pt'>";
		$s .= "<td colspan=2 style='width:426pt'>&nbsp;</td>";
		$s .= "<td style='width:94pt; height:20.0pt; border-bottom:thin solid;'></td>";
		$s .= "</tr>";
		$s .= "<tr style='height:12.0pt'>";
		$s .= "<td colspan=2 style='width:426pt'>&nbsp;</td>";
		$s .= "<td align=center style='width:94pt; height:12.0pt; font-size:7pt;'>Signature of the Candidate</td>";
		$s .= "</tr>";
		$s .= "</table>";
		
		$s .= "<table border=1 cellpadding=10 cellspacing=10 style='border-collapse:collapse;table-layout:fixed;width:520pt'><tr><td>";
		$s .= "<table border=0 cellpadding=0 cellspacing=0 style='border-collapse:collapse;table-layout:fixed;width:500pt'>";
		$s .= "<tr style='height:15.0pt'>";
		$s .= "<td style='height:15.0pt;width:110pt'>Subject:</td>";
		$s .= "<td>" . $data['appl_subject'] . "</td>";
		$s .= "<td style='width:110pt'>Application Code:</td>";
		$s .= "<td style='width:150pt'>" . $data['appl_code'] . "</td>";
		$s .= "</tr>";
		
		$s .= "<tr style='height:15.0pt'>";
		$s .= "<td style='height:15.0pt;'>Name of the Candidate:</td>";
		$s .= "<td>" . $data['appl_name'] . "</td>";
		$s .= "<td style='width:110pt'>Session:</td>";
		$s .= "<td style='width:150pt'>2015-2017</td>";
		$s .= "</tr>";
		
		$s .= "<tr style='height:15.0pt'>";
		$s .= "<td style='height:15.0pt;'>Candidate Category:</td>";
		$s .= "<td>" . _getUniversityCtgr($data['CTGR']). "</td>";
		$s .= "<td style='width:110pt'></td>";
		$s .= "<td style='width:150pt'></td>";
		$s .= "</tr>";
		$s .= "<tr style='height:15.0pt'><td colspan='4'><hr/></td></tr>";
		
		$genaral_rank_60 = '';
		$obca_rank_60 = '';
		$obcb_rank_60 = '';
		$sc_rank_60 = '';
		$st_rank_60 = '';
		$pwd_rank_60 = '';
		$sports_rank_60 = '';
		$hons_rank_60 = '';
		
		$genaral_rank_40 = '';
		$obca_rank_40 = '';
		$obcb_rank_40 = '';
		$sc_rank_40 = '';
		$st_rank_40 = '';
		$pwd_rank_40 = '';
		$sports_rank_40 = '';
		$hons_rank_40 = '';
		
		if($data['60PCT']['GEN'] != '' 		&& $data['60PCT']['GEN'] != 0) 		$genaral_rank_60 = $data['60PCT']['GEN']; else $genaral_rank_60 = '---';
		if($data['60PCT']['OBCA'] != '' 	&& $data['60PCT']['OBCA'] != 0) 	$obca_rank_60 = $data['60PCT']['OBCA']; else $obca_rank_60 = '---';
		if($data['60PCT']['OBCB'] != '' 	&& $data['60PCT']['OBCB'] != 0) 	$obcb_rank_60 = $data['60PCT']['OBCB']; else $obcb_rank_60 = '---';
		if($data['60PCT']['SC'] != '' 		&& $data['60PCT']['SC'] != 0) 		$sc_rank_60 = $data['60PCT']['SC']; else $sc_rank_60 = '---'; 
		if($data['60PCT']['ST'] != '' 		&& $data['60PCT']['ST'] != 0) 		$st_rank_60 = $data['60PCT']['ST']; else $st_rank_60 = '---';
		if($data['60PCT']['PWD'] != '' 		&& $data['60PCT']['PWD'] != 0) 		$pwd_rank_60 = $data['60PCT']['PWD']; else $pwd_rank_60 = '---';
		if($data['60PCT']['SPORTS'] != ''	&& $data['60PCT']['SPORTS'] != 0) 	$sports_rank_60 = $data['60PCT']['SPORTS']; else $sports_rank_60 = '---';
		if($data['60PCT']['HONS'] != '' 	&& $data['60PCT']['HONS'] != 0) 	$hons_rank_60 = $data['60PCT']['HONS']; else $hons_rank_60 = '---';  
		
		if($data['40PCT']['GEN'] != '' 		&& $data['40PCT']['GEN'] != 0) 		$genaral_rank_40 = $data['40PCT']['GEN']; else $genaral_rank_40 = '---';
		if($data['40PCT']['OBCA'] != '' 	&& $data['40PCT']['OBCA'] != 0) 	$obca_rank_40 = $data['40PCT']['OBCA']; else $obca_rank_40 = '---';
		if($data['40PCT']['OBCB'] != '' 	&& $data['40PCT']['OBCB'] != 0) 	$obcb_rank_40 = $data['40PCT']['OBCB']; else $obcb_rank_40 = '---';
		if($data['40PCT']['SC'] != '' 		&& $data['40PCT']['SC'] != 0) 		$sc_rank_40 = $data['40PCT']['SC']; else $sc_rank_40 = '---'; 
		if($data['40PCT']['ST'] != '' 		&& $data['40PCT']['ST'] != 0) 		$st_rank_40 = $data['40PCT']['ST']; else $st_rank_40 = '---';
		if($data['40PCT']['PWD'] != '' 		&& $data['40PCT']['PWD'] != 0) 		$pwd_rank_40 = $data['40PCT']['PWD']; else $pwd_rank_40 = '---';
		if($data['40PCT']['SPORTS'] != ''	&& $data['40PCT']['SPORTS'] != 0) 	$sports_rank_40 = $data['40PCT']['SPORTS']; else $sports_rank_40 = '---';
		if($data['40PCT']['HONS'] != '' 	&& $data['40PCT']['HONS'] != 0) 	$hons_rank_40 = $data['40PCT']['HONS']; else $hons_rank_40 = '---';  
		
		$s .= "<tr style='height:15.0pt'><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
		$s .= "<tr style='height:25.0pt'><td colspan=3><b>Rank category</b></td><td><b>Provisional Rank</B></td></tr>";
		$s .= "<tr style='height:15.0pt'><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
		
		if($genaral_rank_60 > 0){
			$s .= "<tr style='height:25.0pt'><td colspan=3>". $data['60PCT']['GEN_TYPE'] ."</td><td>". $genaral_rank_60 ."</td></tr>";	
		}
		if($obca_rank_60 > 0){
			$s .= "<tr style='height:25.0pt'><td colspan=3>". $data['60PCT']['OBCA_TYPE'] ."</td><td>". $obca_rank_60 ."</td></tr>";	
		}
		if($obcb_rank_60 > 0){
			$s .= "<tr style='height:25.0pt'><td colspan=3>". $data['60PCT']['OBCB_TYPE'] ."</td><td>". $obcb_rank_60 ."</td></tr>";	
		}
		if($sc_rank_60 > 0){
			$s .= "<tr style='height:25.0pt'><td colspan=3>". $data['60PCT']['SC_TYPE'] ."</td><td>". $sc_rank_60 ."</td></tr>";	
		}
		if($st_rank_60 > 0){
			$s .= "<tr style='height:25.0pt'><td colspan=3>". $data['60PCT']['ST_TYPE'] ."</td><td>". $st_rank_60 ."</td></tr>";	
		}
		if($pwd_rank_60 > 0){
			$s .= "<tr style='height:25.0pt'><td colspan=3>". $data['60PCT']['PWD_TYPE'] ."</td><td>". $pwd_rank_60 ."</td></tr>";	
		}
		if($sports_rank_60 > 0){
			$s .= "<tr style='height:25.0pt'><td colspan=3>". $data['60PCT']['SPORTS_TYPE'] ."</td><td>". $sports_rank_60 ."</td></tr>";	
		}
		if($hons_rank_60 > 0){
			$s .= "<tr style='height:25.0pt'><td colspan=3>". $data['60PCT']['HONS_TYPE'] ."</td><td>". $hons_rank_60 ."</td></tr>";	
		}
		
		
		if($genaral_rank_40 > 0){
			$s .= "<tr style='height:25.0pt'><td colspan=3>". $data['40PCT']['GEN_TYPE'] ."</td><td>". $genaral_rank_40 ."</td></tr>";	
		}
		if($obca_rank_40 > 0){
			$s .= "<tr style='height:25.0pt'><td colspan=3>". $data['40PCT']['OBCA_TYPE'] ."</td><td>". $obca_rank_40 ."</td></tr>";	
		}
		if($obcb_rank_40 > 0){
			$s .= "<tr style='height:25.0pt'><td colspan=3>". $data['40PCT']['OBCB_TYPE'] ."</td><td>". $obcb_rank_40 ."</td></tr>";	
		}
		if($sc_rank_40 > 0){
			$s .= "<tr style='height:25.0pt'><td colspan=3>". $data['40PCT']['SC_TYPE'] ."</td><td>". $sc_rank_40 ."</td></tr>";	
		}
		if($st_rank_40 > 0){
			$s .= "<tr style='height:25.0pt'><td colspan=3>". $data['40PCT']['ST_TYPE'] ."</td><td>". $st_rank_40 ."</td></tr>";	
		}
		if($pwd_rank_40 > 0){
			$s .= "<tr style='height:25.0pt'><td colspan=3>". $data['40PCT']['PWD_TYPE'] ."</td><td>". $pwd_rank_40 ."</td></tr>";	
		}
		if($sports_rank_40 > 0){
			$s .= "<tr style='height:25.0pt'><td colspan=3>". $data['40PCT']['SPORTS_TYPE'] ."</td><td>". $sports_rank_40 ."</td></tr>";	
		}
		if($hons_rank_40 > 0){
			$s .= "<tr style='height:25.0pt'><td colspan=3>". $data['40PCT']['HONS_TYPE'] ."</td><td>". $hons_rank_40 ."</td></tr>";	
		}
		
		
		$s .= "<tr style='height:15.0pt'><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
		
		$s .= "<tr style='height:15.0pt'><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
		$s .= "<tr style='height:15.0pt'><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
		$s .= "<tr style='height:15.0pt'><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
		
		$s .= "<tr style='height:10.0pt;font-weight:700;font-size:10pt;'>";
		$s .= "<td colspan=2 valign=bottom style='height:10.0pt;'>&nbsp;</td>";
		$s .= "<td colspan=2 style='text-align:center'><img src='" . $data['auth_signature'] . "' style='padding:2pt;'><br/>".$data['auth_designation']."</td>";
		$s .= "</tr>";	
		
		$s .= "<tr style='height:36pt;'>";
		$s .= "<td colspan=4 style='height:36pt;'>";
		$s .= "<p width=320 style='border:thin solid;padding:6pt;font-size:8pt;'>Carefully preserve this card. Show this card at the time of admission.</p>";
		$s .= "</td></tr>";
						
		$s .= "</table>";
		$s .= "</td></tr>";
						
		$s .= "</table>";	
		$s .= "Download Date & Time : ". date("d-M-Y h:i:s", time()) ;	
		//echo $s; exit();
		$this->convertToPDF($s, $filename, true, 'A4', 'portrait');
	}

	//APPLICATION FEES CHALLAN
	function convert_html_appl_fees_challan_to_pdf($data, $filename ='', $stream = TRUE, $paper = 'A4', $orientation = 'landscape') {
	 	$html = '';
	 	if(count($data)>0){
	 		$filename = $data['pg_appl_code'] . "_CHALAN.pdf";
			
			$html .= "<table border=0 cellpadding=0 cellspacing=0 style='border-collapse:collapse;table-layout:fixed;width:750pt; margin-left:-20px; margin-top:-35px;'> ";
		
			$html .= "<tr height=20 style='height:15.0pt;font-size:14pt;font-weight:bold;'>";
			$html .= "	<td colspan=4 height=20 align='center' style='height:15.0pt;width:270pt; border-right: thin solid;'><img height='50px;' src='" . $data['univ_logo'] . "'></td>";
			$html .= "	<td colspan=4 height=20 align='center' style='height:15.0pt;width:270pt; border-right: thin solid;'><img height='50px;' src='" . $data['univ_logo'] . "'></td>";
			$html .= "	<td colspan=4 height=20 align='center' style='height:15.0pt;width:270pt; border-left: thin solid;'><img height='50px;' src='" . $data['univ_logo'] . "'></td>";
			$html .= "</tr>";
			
			$html .= "<tr height=20 style='height:15.0pt;font-size:14pt;font-weight:bold;'>";
			$html .= "	<td colspan=4 height=20 align='center' style='height:15.0pt;width:270pt; border-right: thin solid;'>THE UNIVERSITY OF BURDWAN</td>";
			$html .= " 	<td colspan=4  align='center' style='width:270pt; border-right: thin solid;'>THE UNIVERSITY OF BURDWAN</td>";
			$html .= "	<td colspan=4  align='center' style='width:270pt; border-left: thin solid;'>THE UNIVERSITY OF BURDWAN</td>";
			$html .= "</tr>";
			
			$html .= "<tr height=20 style='height:15.0pt;font-weight:bold; '>";
			$html .= "	<td colspan=4 align='center' height=20  style='height:15.0pt; border-right: thin solid;'>CHALLAN FOR APPLICATION FEES COLLECTION</td>";
			$html .= "	<td colspan=4 align='center' style='border-right: thin solid;'>CHALLAN FOR APPLICATION FEES COLLECTION</td>";
			$html .= "	<td colspan=4 align='center' style='border-left: thin solid;'>CHALLAN FOR APPLICATION FEES COLLECTION</td>";
			$html .= "</tr>";
			
			$html .= "<tr height=20 style='height:15.0pt;font-weight:bold; '>";
			$html .= "	<td colspan=4 align='center' height=20  style='height:15.0pt; border-right: thin solid;'>STATE BANK OF INDIA</td>";
			$html .= "	<td colspan=4 align='center' style='border-right: thin solid;'>STATE BANK OF INDIA</td>";
			$html .= "	<td colspan=4 align='center' style='border-left: thin solid;'>STATE BANK OF INDIA</td>";
			$html .= "</tr>";
			
			$html .= "<tr height=20 style='height:15.0pt;font-weight:bold;'>";
			$html .= "	<td colspan=4 align='center' height=20  style='height:15.0pt; border-right: thin solid;'>POWER JYOTI A/C No. ".PowerJyotiAccountNo()."</td>";
			$html .= "	<td colspan=4 align='center' style='border-right: thin solid;'>POWER JYOTI A/C No. ".PowerJyotiAccountNo()."</td>";
			$html .= "	<td colspan=4 align='center' style='border-left: thin solid;'>POWER JYOTI A/C No. ".PowerJyotiAccountNo()." </td>";
			$html .= "</tr>";
			
			$html .= "<tr height=20 style='height:15.0pt;font-weight:bold;'>";
			$html .= "	<td colspan=4 align='center' height=20  style='height:15.0pt; border-bottom: thin solid; border-right: thin solid; '>(BANK'S COPY)</td>";
			$html .= "	<td colspan=4 align='center' style='height:15.0pt; border-bottom: thin solid; border-right: thin solid;'>(UNIVERSITY COPY)</td>";
			$html .= "	<td colspan=4 align='center' style='height:15.0pt; border-bottom: thin solid; border-left: thin solid;'>(STUDENT COPY)</td>";
			$html .= "</tr>";
			$html .= "</table>";
			
			
			$html .= "<table border=0 cellpadding=0 cellspacing=0 style='border-collapse:collapse;table-layout:fixed;width:750pt;margin-left:-20px;'> ";
			
			$html .= "<tr height=20 style='height:15.0pt'>";
			$html .= "	<td height=20 style='height:15.0pt'>CHALLAN NO.</td>";
			$html .= "	<td colspan=3>" . $data['pg_appl_mobile'] . "</td>";
			$html .= "	<td>CHALLAN NO.</td>";
			$html .= "	<td colspan=3>" . $data['pg_appl_mobile'] . "</td>";
			$html .= "	<td>CHALLAN NO.</td>";
			$html .= "	<td colspan=3>" . $data['pg_appl_mobile'] . "</td>";
			$html .= "</tr>";
			
			$html .= "<tr height=20 style='height:15.0pt'>";
			$html .= "	<td colspan=4 height=20 style='height:15.0pt;width:270pt'><small>(Your mobile no. will be treated as your challan no.)</small></td>";
			$html .= "	<td colspan=4 style='width:270pt'><small>(Your mobile no. will be treated as your challan no.)</small></td>";
			$html .= "	<td colspan=4 style='width:270pt'><small>(Your mobile no. will be treated as your challan no.)</small></td>";
			$html .= "</tr>";
			
			$html .= "<tr height=20 style='height:15.0pt'>";
			$html .= "	<td colspan=4 height=20 style='height:15.0pt'>STUDENT NAME: " . $data['pg_appl_name'] . "</td>";
			$html .= "	<td colspan=4 height=20 style='height:15.0pt'>STUDENT NAME: " . $data['pg_appl_name'] . "</td>";
			$html .= "	<td colspan=4 height=20 style='height:15.0pt'>STUDENT NAME: " . $data['pg_appl_name'] . "</td>";
			$html .= "</tr>";
			
			$html .= "<tr height=20 style='height:15.0pt'>";
			$html .= "	<td height=20 style='height:15.0pt'>SUBJECT:</td>";
			$html .= "	<td colspan=3>" . $data['pg_subj_name'] . "</td>";
			$html .= "	<td>SUBJECT:</td>";
			$html .= "	<td colspan=3>" . $data['pg_subj_name'] . "</td>";
			$html .= "	<td>SUBJECT:</td>";
			$html .= "	<td colspan=3>" . $data['pg_subj_name'] . "</td>";
			$html .= "</tr>";
			
			$html .= "<tr height=20 style='height:15.0pt'>";
			$html .= "	<td height=20 style='height:15.0pt'>APPL. CODE:</td>";
			$html .= "	<td colspan=3>" . $data['pg_appl_code'] . "</td>";
			$html .= "	<td>APPL. CODE:</td>";
			$html .= "	<td colspan=3>" . $data['pg_appl_code'] . "</td>";
			$html .= "	<td>APPL. CODE:</td>";
			$html .= "	<td colspan=3>" . $data['pg_appl_code'] . "</td>";
			$html .= "</tr>";
			
			$html .= "<tr height=20 style='height:15.0pt'>";
			$html .= "	<td colspan=4 height=20 style='height:15.0pt'></td>";
			$html .= "	<td colspan=4></td>";
			$html .= "	<td colspan=4></td>";
			$html .= "</tr>";
			
			
			$html .= "<tr height=20 style='height:15.0pt;font-weight:bold;'>";
			$html .= "	<td colspan=2 height=20 style='height:15.0pt; border-top:thin solid; border-bottom:thin solid;'>FEES TYPE</td>";
			$html .= "	<td colspan=2 style='height:15.0pt; border-top:thin solid; border-bottom:thin solid;'>AMOUNT</td>";
			$html .= "	<td colspan=2 style='height:15.0pt; border-top:thin solid; border-bottom:thin solid;'>FEES TYPE</td>";
			$html .= "	<td colspan=2 style='height:15.0pt; border-top:thin solid; border-bottom:thin solid;'>AMOUNT</td>";
			$html .= "	<td colspan=2 style='height:15.0pt; border-top:thin solid; border-bottom:thin solid;'>FEES TYPE</td>";
			$html .= "	<td colspan=2 style='height:15.0pt; border-top:thin solid; border-bottom:thin solid;'>AMOUNT</td>";
			$html .= "</tr>";
			
			$html .= "<tr height=20 style='height:15.0pt'>";
			$html .= "	<td colspan=2 height=20 style='height:15.0pt'>APPLICATION FEES</td>";
			$html .= "	<td colspan=2>" . applicationFeesAmount() . "</td>";
			$html .= "	<td colspan=2>APPLICATION FEES</td>";
			$html .= "	<td colspan=2>" . applicationFeesAmount() . "</td>";
			$html .= "	<td colspan=2>APPLICATION FEES</td>";
			$html .= "	<td colspan=2>" . applicationFeesAmount() . "</td>";
			$html .= "</tr>";
			
			$html .= "<tr height=20 style='height:15.0pt'>";
			$html .= "	<td colspan=4 height=20 style='height:15.0pt'></td>";
			$html .= "	<td colspan=4></td>";
			$html .= "	<td colspan=4></td>";
			$html .= "</tr>";
			
			$html .= "<tr height=20 style='height:15.0pt; font-weight:bold;'>";
			$html .= "	<td colspan=2 height=20 style='height:15.0pt; border-top:thin solid; '>TOTAL</td>";
			$html .= "	<td colspan=2 style='border-top:thin solid; '>" . applicationFeesAmount() . "</td>";
			$html .= "	<td colspan=2 style='border-top:thin solid; '>TOTAL</td>";
			$html .= "	<td colspan=2 style='border-top:thin solid; '>" . applicationFeesAmount() . "</td>";
			$html .= "	<td colspan=2 style='border-top:thin solid; '>TOTAL</td>";
			$html .= "	<td colspan=2 style='border-top:thin solid; '>" . applicationFeesAmount() . "</td>";
			$html .= "</tr>";
			
			$html .= "<tr height=20 style='height:15.0pt'>";
			$html .= "	<td colspan=4 height=20 style='height:15.0pt'>(Rs/- ".getAmtInWords(applicationFeesAmount())." Only</td>";
			$html .= "	<td colspan=4>(Rs/- ".getAmtInWords(applicationFeesAmount())." Only)</td>";
			$html .= "	<td colspan=4>(Rs/-".getAmtInWords(applicationFeesAmount())." Only)</td>";
			$html .= "</tr>";
			
			$html .= "<tr height=20 style='height:15.0pt'>";
			$html .= "	<td colspan=4 height=20  style='height:15.0pt'></td>";
			$html .= "	<td colspan=4 ></td>";
			$html .= "	<td colspan=4 ></td>";
			$html .= "</tr>";
			
			$html .= "<tr height=39 style='mso-height-source:userset;height:29.25pt'>";
			$html .= "	<td colspan=4 height=39 style='height:29.25pt;width:270pt'>BANK CHARGE CR TO COMMISSION OTHERS<br>";
			$html .= "    	98353______________ ".challanChargesAmount()."/- SEPARATELY.</td>";
			$html .= "	<td colspan=4 style='width:270pt'>BANK CHARGE CR TO COMMISSION OTHERS<br>";
			$html .= "    	98353______________ ".challanChargesAmount()."/- SEPARATELY.</td>";
			$html .= "	<td colspan=4 style='width:270pt'>BANK CHARGE CR TO COMMISSION OTHERS<br>";
			$html .= "		98353______________ ".challanChargesAmount()."/- SEPARATELY.</td>";
			$html .= "</tr>";
			
			$html .= "<tr height=20 style='height:15.0pt'>";
			$html .= "	<td colspan=4 height=20  style='height:15.0pt'></td>";
			$html .= "	<td colspan=4 ></td>";
			$html .= "	<td colspan=4 ></td>";
			$html .= "</tr>";
			
			$html .= "<tr height=20 style='height:15.0pt'>";
			$html .= "	<td height=20 style='height:15.0pt'>TOTAL</td>";
			$html .= "	<td colspan=3  style='border-bottom:thin solid; '></td>";
			$html .= "	<td>TOTAL</td>";
			$html .= "	<td colspan=3 style='border-bottom:thin solid; '></td>";
			$html .= "	<td>TOTAL</td>";
			$html .= "	<td colspan=3 style='border-bottom:thin solid; '></td>";
			$html .= "</tr>";
			$html .= "<tr height=20 style='height:15.0pt'>";
			$html .= "	<td colspan=4 height=20  style='height:15.0pt'></td>";
			$html .= "	<td colspan=4 ></td>";
			$html .= "	<td colspan=4 ></td>";
			$html .= "</tr>";
			$html .= "<tr height=20 style='height:15.0pt'>";
			$html .= "	<td height=20 style='height:15.0pt'>DATE</td>";
			$html .= "	<td colspan=3 style='border-bottom:thin solid; '></td>";
			$html .= "	<td>DATE</td>";
			$html .= "	<td colspan=3 style='border-bottom:thin solid; '></td>";
			$html .= "	<td>DATE</td>";
			$html .= "	<td colspan=3 style='border-bottom:thin solid; '></td>";
			$html .= "</tr>";
			
			$html .= "<tr style='height:25.0pt'>";
			$html .= "	<td style='height:25.0pt'>BRANCH NAME</td>";
			$html .= "	<td colspan=3 style='border-bottom:thin solid; '></td>";
			$html .= "	<td>BRANCH NAME</td>";
			$html .= "	<td colspan=3 style='border-bottom:thin solid; '></td>";
			$html .= "	<td>BRANCH NAME</td>";
			$html .= "	<td colspan=3 style='border-bottom:thin solid; '></td>";
			$html .= "</tr>";
			
			$html .= "<tr style='height:25.0pt'>";
			$html .= "	<td style='height:25.0pt'>BRANCH CODE</td>";
			$html .= "	<td colspan=3 style='border-bottom:thin solid; '></td>";
			$html .= "	<td>BRANCH CODE</td>";
			$html .= "	<td colspan=3 style='border-bottom:thin solid; '></td>";
			$html .= "	<td>BRANCH CODE</td>";
			$html .= "	<td colspan=3 style='border-bottom:thin solid; '></td>";
			$html .= "</tr>";
			
			$html .= "<tr style='height:25.0pt'>";
			$html .= "	<td style='height:25.0pt'>JOURNAL NO</td>";
			$html .= "	<td colspan=3><div style='border:thin solid;width:120pt;height:20.0pt'>&nbsp;</div></td>";
			$html .= "	<td>JOURNAL NO</td>";
			$html .= "	<td colspan=3><div style='border:thin solid;width:120pt;height:20.0pt'>&nbsp;</div></td>";
			$html .= "	<td>JOURNAL NO</td>";
			$html .= "	<td colspan=3><div style='border:thin solid;width:120pt;height:20.0pt'>&nbsp;</div></td>";
			$html .= "</tr>";
			
			$html .= "<tr style='height:15.0pt'>";
			$html .= "	<td colspan=4 style='height:15.0pt'></td>";
			$html .= "	<td colspan=4></td>";
			$html .= "	<td colspan=4></td>";
			$html .= "</tr>";
			
			$html .= "<tr style='height:20.0pt'>";
			$html .= "	<td style='height:15.0pt' colspan=2>Signature of student</td>";
			$html .= "	<td colspan=2 style='border-bottom:thin solid;width:120pt;height:20.0pt'></td>";
			$html .= "	<td colspan=2>Signature of student</td>";
			$html .= "	<td colspan=2 style='border-bottom:thin solid;width:120pt;height:20.0pt'></td>";
			$html .= "	<td colspan=2>Signature of student</td>";
			$html .= "	<td colspan=2 style='border-bottom:thin solid;width:120pt;height:20.0pt'></td>";
			$html .= "</tr>";
		
			$html .= "<tr style='height:15.0pt'>";
			$html .= "	<td colspan=4 style='height:15.0pt'></td>";
			$html .= "	<td colspan=4></td>";
			$html .= "	<td colspan=4></td>";
			$html .= "</tr>";
			
			$html .= "<tr style='height:15.0pt'>";
			$html .= "	<td colspan=3 style='height:15.0pt'>Bank's authorized signature with seal</td>";
			$html .= "  	<td ></td>";
			$html .= "  	<td colspan=3>Bank's authorized signature with seal</td>";
			$html .= "  	<td ></td>";
			$html .= "  	<td colspan=3>Bank's authorized signature with seal</td>";
			$html .= "  	<td ></td>";
			$html .= "</tr>";
			$html .= "</table>";
	 	}
	 	//echo $html;
		$this->convertToPDF($html, $filename, true, 'A4', $orientation);
	}

	//RANK LIST
	function convert_html_meritlist_to_pdf($data, $filename ='', $public_flag, $stream = TRUE, $paper = 'A4', $orientation = 'landscape') {
		$s = "<style type='text/css'>
				body{
					font:8.5pt Helvetica, serif;
					margin-top: -3.0em;
            		margin-left: 0.2em;
				}
				p {margin:0.2em 0 0 0;padding:0;}
				
				.header {font-weight:700;font-size:10pt;border: 0pt;}
				
				table.collapse {
				  border-collapse: collapse;
				  border: 0.6pt solid black;  
				}
				
				table.collapse td {
				  border: 0.4pt solid black;
				  cellpadding: 0pt;
				  cellspacing: 0pt;
				}
				
				</style>";
		$s .= "<br/><br/>"; 
		
		$s .= "<table style='table-layout:fixed;width:530pt;margin-bottom:0pt; margin-top:-1pt;'>";
		$s .= "<tr>";
		$s .= "<td style='width:100pt;' align='left'> <img src='" . $data['univ_logo'] . "'></td>";
		$s .= "<td align='center'>";
		$s .= "<table style='table-layout:fixed; align=center'>";
		$s .= "<tr><td class='header' align='center' style='font-size:12pt;'>The University of Burdwan</td></tr>";
		$s .= "<tr><td class='header' align='center' style='font-size:9pt;'>" . $data['header']. "</td></tr>";
		$s .= "<tr><td class='header' align='center' style='font-size:10pt;'>" . $data['info']['description']. "</td></tr>";
		$s .= "</table>";
		$s .= "</td>";
		$s .= "<td style='width:170pt;'>";
		$s .= "<table style='table-layout:fixed;width:170pt; border: 0.8pt solid black'>";
		$s .= "<tr style='height:14.0pt'><td class='' align='left' style='font-size:8pt;'>RANK CATEGORY: </td><td style='font-size:8pt;'>" . $data['info']['seat_ctgry_name'] . "</td></tr>";
		$s .= "<tr style='height:14.0pt'><td class='' align='left' style='font-size:8pt;'>SUBJECT NAME: </td><td style='font-size:8pt;'>" . $data['info']['subject_name'] . "</td></tr>";
		$s .= "<tr style='height:14.0pt'><td class='' align='left' style='font-size:8pt;'>RESERVATION: </td><td style='font-size:8pt;'>" . $data['info']['resv_name'] . "</td></tr>";
		$s .= "</table>";
		$s .= "</td>";
		$s .= "</tr>";
		$s .= "</table>";
		
		
		$s .= "<table class='collapse' style='table-layout:fixed;width:530pt; margin-top:-5pt;'>";
		$s .= "<tr class='header'>";
		$s .= "<td align=center style='width:60pt; '>Application <br/>Code.</td>";
		if($public_flag == false){
			$s .= "<td align=center style='width:15pt; '>Ctgr.</td>";
			$s .= "<td align=center style='width:120pt; '>Applicant's Name.</td>";
		}
		$s .= "<td align=center style='width:130pt; '>UG Subject.</td>";
		$s .= "<td align=center style='width:30pt; '>Reservation.</td>";
		$s .= "<td align=center style='width:25pt; '>Rank.</td>";
		if($data['info']['seat_ctgry'] == '40PCT'){
			$s .= "<td align=center style='width:50pt; '>Written Marks.</td>";	
		}else{
			$s .= "<td align=center style='width:50pt; '>Graduation Marks.</td>";			
		}
		$s .= "</tr>";
		
		for($i=0; $i<sizeof($data['data']); $i++) {
			$s .= "<tr>";
			$s .= "<td align=center style='width:60pt; font-size:9pt;'>". $data['data'][$i]['pg_appl_code'] ."</td>";
			if($public_flag == false){
				$s .= "<td align=center style='width:20pt; font-size:9pt;'>". $data['data'][$i]['pg_appl_ctgr'] ."</td>";
				$s .= "<td align=left style='width:120pt; font-size:8pt;'> &nbsp;". $data['data'][$i]['pg_appl_name'] ."</td>";
			}
			$s .= "<td align=left style='width:130pt; font-size:8pt;'> &nbsp;". $data['data'][$i]['ug_subject_name'] ."</td>";
			$s .= "<td align=left style='width:35pt; font-size:9pt;'> &nbsp;". $data['data'][$i]['resv_name'] ."</td>";
			$s .= "<td align=center style='width:30pt; font-size:9pt;'>". $data['data'][$i]['resv_merit'] ."</td>";
			if($data['info']['seat_ctgry'] == '40PCT'){
				$s .= "<td align=center style='width:50pt; font-size:9pt;'>". $data['data'][$i]['pg_appl_written_score'] ."</td>";	
			}else{
				$s .= "<td align=center style='width:50pt; font-size:9pt;'>". $data['data'][$i]['pg_appl_grad_pct'] ."</td>";			
			}
			$s .= "</tr>";
		}
		$s .= "</table>";
		
		$s .= "<table style='table-layout:fixed;width:530pt; margin-top:2pt;'><tr>";
		$s .= "<td style='width:350pt; font-size:7pt;'>Page: " . $data['data'][0]['PAGENO']."</td>";
		$s .= "<td style='font-size:7pt; text-align:right;'>Download Date & Time : ". date("d-M-Y h:i:s", time()) ."</td>";
		$s .= "</tr></table>";
		
		
		//$s .= "Page: " . $data['data'][0]['PAGENO'] ;
		
		//echo $s; print_r($data); exit();
		
		$this->convertToPDF($s, $filename, true, 'A4', 'portrait');
	}

	//SEAT ARRANGEMENT
	function convert_html_seats_to_pdf($data, $filename ='', $stream = TRUE, $paper = 'A4', $orientation = 'landscape') {
		$s = "<style type='text/css'>
				body{
					font:8.5pt Helvetica, serif;
					margin-top: -3.0em;
            		margin-left: 0.2em;
				}
				p {margin:0.2em 0 0 0;padding:0;}
				
				.header {font-weight:700;font-size:10pt;border: 0pt;}
				
				table.collapse {
				  border-collapse: collapse;
				  border: 0.6pt solid black;  
				}
				
				table.collapse td {
				  border: 0.4pt solid black;
				  cellpadding: 0pt;
				  cellspacing: 0pt;
				}
				
				</style>";
		$s .= "<br/><br/>"; 
		
		
		$s .= "<table style='table-layout:fixed;width:780pt; height:100pt;margin-bottom:0pt; margin-top:0pt;'>";
		$s .= "<tr>";
		$s .= "<td style='width:240pt;'><br/><br/>";
		$s .= "<table style='text-align:left; width:230pt; margin-left: 0pt; border: 0.8pt solid black'>";
		for($i=0; $i<sizeof($data['subjects']); $i++) {
			$s .= "<tr><td class='header' style='font-size:9pt; text-align:left; width:190pt;'> &nbsp;".$data['subjects'][$i]['pg_appl_subj_name']."</td><td class='header' style='text-align:left; width:40pt;'>".$data['subjects'][$i]['count']."</td></tr>";	
		}
		$s .= "</table>";
		$s .= "</td>";
		$s .= "<td style='width:260pt; text-align:center'>";
		
		$s .= "<table style='text-align:center; width:260pt;'>";
		$s .= "<tr><td><img src='" . $data['univ_logo'] . "'></td></tr>";
		$s .= "<tr><td class='header' align='center' style='font-size:12pt;'>The University of Burdwan</td></tr>";
		$s .= "<tr><td class='header' align='center' style='font-size:9pt;'>Post Graduate Admission Test Of Session 2015-2017</td></tr>";
		$s .= "<tr><td class='header' align='center' style='font-size:10pt;'>Attendence Sheet</td></tr>";
		$s .= "</table>";
		
		$s .= "</td>";
		
		$s .= "<td style='width:260pt;'>";
		$s .= "<table style='text-align:center; width:260pt;'>";
		for($i=0; $i<sizeof($data['halls']); $i++) {
			$s .= "<tr><td  align='left' style='font-size:10pt; width:180pt;'>".$data['halls'][$i]['building']."</td> <td align='left' style='font-size:10pt;'>".$data['halls'][$i]['hall_name']." (".$data['halls'][$i]['count'] .")</td></tr>";
		}
		$s .= "<tr><td class='header' colspan=2 align='left' style='font-size:10pt;'>Date : ".getDateFormat($data['schedule'][0]['exam_date'])." &nbsp; &nbsp; Time : ".$data['schedule'][0]['exam_start_time']." - ".$data['schedule'][0]['exam_end_time']."</td></tr>";
		
		$s .= "</table>";
		$s .= "</td>";
		$s .= "</tr>";
		$s .= "</table>";
		/*
		$s .= "<tr class='header'>";
				$s .= "<td align=center style='width:25pt; '>Sl No.</td>";
				$s .= "<td align=center style='width:40pt; '>Photo.</td>";
				$s .= "<td align=center style='width:70pt; '>Appl. Code.</td>";
				$s .= "<td align=center style='width:100pt; '>Applicant's Name.</td>";
				$s .= "<td align=center style='width:70pt; '>Roll No.</td>";
				$s .= "<td align=center style='width:100pt; '>Subject.</td>";
				$s .= "<td align=center style='width:60pt; '>Hall No.</td>";
				$s .= "<td align=center style='width:80pt; '>Booklet No.</td>";
				$s .= "<td align=center style='width:80pt; '>OMR Sheet No.</td>";
				$s .= "<td align=center style='width:130pt; '>Signature.</td>";
				$s .= "</tr>";*/
		
		
		for($i=0, $j=0; $i<sizeof($data['seats']); $i++, $j++) {
			
			if($i < 13){
				if($j %13 == 0){
					$s .= "<table class='collapse' style='table-layout:fixed;width:780pt; margin-top:-5pt;margin-bottom:1pt;'>";
					$s .= "<tr class='header'>";
					$s .= "<td align=center style='width:25pt; '>Sl No.</td>";
					$s .= "<td align=center style='width:38pt; '>Photo.</td>";
					$s .= "<td align=center style='width:65pt; '>Appl. Code.</td>";
					$s .= "<td align=center style='width:107pt; '>Applicant's Name.</td>";
					$s .= "<td align=center style='width:70pt; '>Roll No.</td>";
					$s .= "<td align=center style='width:100pt; '>Subject.</td>";
					$s .= "<td align=center style='width:60pt; '>Hall No.</td>";
					$s .= "<td align=center style='width:80pt; '>Booklet No.</td>";
					$s .= "<td align=center style='width:80pt; '>OMR Sheet No.</td>";
					$s .= "<td align=center style='width:130pt; '>Signature.</td>";
					$s .= "</tr>";
				}
				
				$s .= "<tr>";
				$s .= "<td align=center style='width:25pt; font-size:10pt;'>".($i+1)."</td>";
				$s .= "<td align=center style='width:38pt; font-size:10pt;'><img  src='" . $data['seats'][$i]['pg_appl_profile_pic'] . "' style='height:27pt; padding:0pt;border:thin solid;border-color:#666;'></td>";
				$s .= "<td align=left style='width:65pt; font-size:9pt;'>".$data['seats'][$i]['pg_appl_code']."</td>";
				$s .= "<td align=left style='width:107pt; font-size:8pt;'>".$data['seats'][$i]['pg_appl_name']."</td>";
				$s .= "<td align=left style='width:70pt; font-size:9pt;'>".$data['seats'][$i]['roll_no']."</td>";
				$s .= "<td align=left style='width:100pt; font-size:8pt;'>".$data['seats'][$i]['pg_appl_subj_name']."</td>";
				$s .= "<td align=left style='width:60pt; font-size:9pt;'>".$data['seats'][$i]['hall_number']."</td>";
				$s .= "<td align=center style='width:80pt; font-size:10pt;'></td>";
				$s .= "<td align=center style='width:80pt; font-size:10pt;'></td>";
				$s .= "<td align=center style='width:130pt; font-size:10pt;'></td>";
				$s .= "</tr>";
				if($j %13 == 12 || $i == sizeof($data['seats']) -1){
					$s .= "</table>";
					$s .= "<p class='page-break'></p>";
					$s .= "<p class='page-break'></p>";
					$j = -1;
				}
			}
			  
			else{
							if($j %16 == 0){
								$s .= "<table class='collapse' style='table-layout:fixed;width:780pt; margin-top:20pt;'>";
									$s .= "<tr class='header'>";
									$s .= "<td align=center style='width:25pt; '>Sl No.</td>";
									$s .= "<td align=center style='width:38pt; '>Photo.</td>";
									$s .= "<td align=center style='width:65pt; '>Appl. Code.</td>";
									$s .= "<td align=center style='width:107pt; '>Applicant's Name.</td>";
									$s .= "<td align=center style='width:70pt; '>Roll No.</td>";
									$s .= "<td align=center style='width:100pt; '>Subject.</td>";
									$s .= "<td align=center style='width:60pt; '>Hall No.</td>";
									$s .= "<td align=center style='width:80pt; '>Booklet No.</td>";
									$s .= "<td align=center style='width:80pt; '>OMR Sheet No.</td>";
									$s .= "<td align=center style='width:130pt; '>Signature.</td>";
									$s .= "</tr>";
								}
								
								$s .= "<tr>";
								$s .= "<td align=center style='width:25pt; font-size:10pt;'>".($i+1)."</td>";
								$s .= "<td align=center style='width:38pt; font-size:10pt;'><img  src='" . $data['seats'][$i]['pg_appl_profile_pic'] . "' style='height:29pt; padding:0pt;border:thin solid;border-color:#666;'></td>";
								$s .= "<td align=left style='width:65pt; font-size:9pt;'>".$data['seats'][$i]['pg_appl_code']."</td>";
								$s .= "<td align=left style='width:107pt; font-size:8pt;'>".$data['seats'][$i]['pg_appl_name']."</td>";
								$s .= "<td align=left style='width:70pt; font-size:9pt;'>".$data['seats'][$i]['roll_no']."</td>";
								$s .= "<td align=left style='width:100pt; font-size:8pt;'>".$data['seats'][$i]['pg_appl_subj_name']."</td>";
								$s .= "<td align=left style='width:60pt; font-size:9pt;'>".$data['seats'][$i]['hall_number']."</td>";
								$s .= "<td align=center style='width:80pt; font-size:10pt;'></td>";
								$s .= "<td align=center style='width:80pt; font-size:10pt;'></td>";
								$s .= "<td align=center style='width:130pt; font-size:10pt;'></td>";
								$s .= "</tr>";
								if($j %16 == 15 || $i == sizeof($data['seats']) -1){
									$s .= "</table>";
								}
						}
		}
		
		
		//$s .= "Page: " . $data['data'][0]['PAGENO'] ;
		
		//echo $s; exit();
		
		$this->convertToPDF($s, $filename, true, 'A4', 'landscape');
	}
}