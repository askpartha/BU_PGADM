<?php
function getFullname($firstname, $midname, $lastname)
{
	$fullname = $firstname . ' ' . ($midname == '' ? '' : $midname . ' ') . $lastname;
	return $fullname;	
}

function getDateFormat($date, $format = 'd-M-Y'){
	$userTimezone = new DateTimeZone('Asia/Kolkata');
	//$gmtTimezone = new DateTimeZone('GMT');
	$myDateTime = new DateTime($date, $userTimezone);
	//$offset = $userTimezone->getOffset($myDateTime);	
	$my_date_format = date($format, $myDateTime->format('U') );	
	return $my_date_format;	
}

function getDateFormatNoDateBlank($date, $format = 'd-M-Y'){
	if($date == "" || $date == null){
		return "";
	}
	$userTimezone = new DateTimeZone('Asia/Kolkata');
	//$gmtTimezone = new DateTimeZone('GMT');
	$myDateTime = new DateTime($date, $userTimezone);
	//$offset = $userTimezone->getOffset($myDateTime);	
	$my_date_format = date($format, $myDateTime->format('U') );	
	return $my_date_format;	
}

function convertToMySqlDate($date, $fromFormat='d-m-Y', $toFormat='Y-m-d') {
	$dt   = new DateTime();
	$datetime = $dt->createFromFormat($fromFormat, $date)->format($toFormat);
	return $datetime; 
}

function getYearMonth($date) {
	$date = explode('-', $date);
	$now = explode('-', date("Y-m-d"));
	$old = $now[0]*12+$now[1]-$date[0]*12-$date[1]-($date[2]>$now[2] ? 1 : 0);
	return floor($old / 12) .  " yrs " . ($old % 12) . " mths";
}

function getRelativeTime($timestamp){
	// Get time difference and setup arrays
	$difference = time() - $timestamp;
	$periods = array("second", "minute", "hour", "day", "week", "month", "years");
	$lengths = array("60","60","24","7","4.35","12");
 
	// Past or present
	if ($difference >= 0) {
		$ending = "ago";
	}
	else {
		$difference = -$difference;
		$ending = "to go";
	}
 
	// Figure out difference by looping while less than array length
	// and difference is larger than lengths.
	$arr_len = count($lengths);
	for($j = 0; $j < $arr_len && $difference >= $lengths[$j]; $j++) {
		$difference /= $lengths[$j];
	}
 
	// Round up		
	$difference = round($difference);
 
	// Make plural if needed
	if($difference != 1) {
		$periods[$j].= "s";
	}
 
	// Default format
	$text = "$difference $periods[$j] $ending";
 
	// over 24 hours
	if($j > 2) {
		// future date over a day formate with year
		if($ending == "to go") {
			if($j == 3 && $difference == 1) {
				$text = "Tomorrow at ". date("g:i a", $timestamp);
			}
			else {
				$text = date("F j, Y \a\\t g:i a", $timestamp);
			}
			return $text;
		}
 
		if($j == 3 && $difference == 1) { // Yesterday 
			$text = "Yesterday at ". date("g:i a", $timestamp);
		}
		else if($j == 3) { // Less than a week display -- Monday at 5:28pm
			$text = date("l \a\\t g:i a", $timestamp);
		}
		else if($j < 6 && !($j == 5 && $difference == 12)) { // Less than a year display -- June 25 at 5:23am
			$text = date("F j \a\\t g:i a", $timestamp);
		}
		else { // if over a year or the same month one year ago -- June 30, 2010 at 5:34pm
			$text = date("F j, Y \a\\t g:i a", $timestamp);
		}
	}
 
	return $text;
} 

function dateDiff($dateStart, $dateEnd) {
    $start = strtotime($dateStart);
    $end = strtotime($dateEnd);
    $days = ($end - $start) + 1;
    $days = ceil($days/86400);
    return $days;
}

function firstNwords($text, $length = 200, $dots = true) {
    $text = trim(preg_replace('#[\s\n\r\t]{2,}#', ' ', $text));
    $text_temp = $text;
    while (substr($text, $length, 1) != " ") { $length++; if ($length > strlen($text)) { break; } }
    $text = substr($text, 0, $length);
    return $text . ( ( $dots == true && $text != '' && strlen($text_temp) > $length ) ? '...' : ''); 
}

function getFormatedAmount($val) {
	return number_format($val, 2, '.', ',');
}

function getAmtInWords($no) {
    $words = array('0'=> '' ,'1'=> 'One' ,'2'=> 'Two' ,'3' => 'Three','4' => 'Four','5' => 'Five','6' => 'Six',
    				'7' => 'Seven','8' => 'Eight','9' => 'Nine','10' => 'Ten','11' => 'Eleven',
    				'12' => 'Twelve','13' => 'Thirteen','14' => 'Fouteen','15' => 'Fifteen','16' => 'Sixteen',
    				'17' => 'Seventeen','18' => 'Eighteen','19' => 'Nineteen','20' => 'Twenty',
    				'30' => 'Thirty','40' => 'Fourty','50' => 'Fifty','60' => 'Sixty','70' => 'Seventy',
    				'80' => 'Eighty','90' => 'Ninty','100' => 'Hundred','1000' => 'Thousand','100000' => 'Lakh','10000000' => 'Crore');
    if($no == 0)
    	return ' ';
    else {
	    $novalue='';
	    $highno=$no;
	    $remainno=0;
	    $value=100;
	    $value1=1000;
	    while($no>=100) {
    		if(($value <= $no) &&($no < $value1)) {
			    $novalue=$words["$value"];
			    $highno = (int)($no/$value);
			    $remainno = $no % $value;
			    break;
    		}
		    $value= $value1;
		    $value1 = $value * 100;
    	}
	    if(array_key_exists("$highno",$words))
	    	return $words["$highno"]." ".$novalue." ".getAmtInWords($remainno);
	    else {
		    $unit=$highno%10;
		    $ten =(int)($highno/10)*10;
	    	return $words["$ten"]." ".$words["$unit"]." ".$novalue." ".getAmtInWords($remainno);
	    }
	}
}	

function _getApplicationStatus($val) {
	$msg ="";
	switch ($val) {
		case "1":
			$msg = "<span class='label label-info'>Application Submitted</span>";
			break;
		case "2":
			$msg = "<span class='label label-primary'>Payment Confirmed</span>";
			break;
		case "4":
			$msg = "<span class='label label-success'>Application Confirmed</span>";
			break;	
		case "5":
			$msg = "<span class='label label-success'>Admission Confirmed</span>";
			break;	
		case "9":
			$msg = "<span class='label label-danger'>Application Cancelled</span>";			
	}
	return $msg;
}

function _getFileStatus($val) {
	$msg ="";
	switch ($val) {
		case "0":
			$msg = "File Uploaded";
			break;
		case "1":
			$msg = "File Processed";
			break;
		case "2":
			$msg = "Payment Processed";
			break;	
	}
	return $msg;
}

function _getUniversityCtgr($val) {
	$msg ="";
	switch ($val) {
		case "OU":
			$msg = "Other University";
			break;
		case "BU":
			$msg = "Burdwan University";
			break;
	}
	return $msg;
}

function _getReservation($val) {
	$msg ="";
	switch (strtoupper($val)) {
		case "SC":
			$msg = "SC";
			break;
		case "ST":
			$msg = "ST";
			break;
		case "OBCA":
			$msg = "OBC-A";
			break;
		case "OBCB":
			$msg = "OBC-B";
			break;
	}
	return $msg;
}


function _getApplicationFees(){
	$appl_fees = 300;
	return $appl_fees;
}

function _getAdmissionFees(){
	$msg ="1000";
	switch (strtoupper($val)) {
		
	}
	return $msg;
}

function _getExamination(){
	$msg = "POST GRADUATE ONLINE ADMISSION";
	return $msg; 
}

function _getAccountNo(){
	$msg = '32868998865';
	return $msg;
}

function _getScheduleName($val) {
	$msg ="";
	switch (strtoupper($val)) {
		case "ASD":
			$msg = "Application Start Date";
			break;
		case "ALD":
			$msg = "Application Last Date";
			break;
		case "PED":
			$msg = "Payment Submission Last Date";
			break;
		case "ED":
			$msg = "Examination Date";
			break;
		case "AD":
			$msg = "Admitcard Distribution Date";
			break;
		case "60RD":
			$msg = "60% Rank List Publication Date";
			break;
		case "64RD":
			$msg = "40% Rank List Publication Date";
			break;
		case "60AD":
			$msg = "60% Admission Date";
			break;
		case "40AD":
			$msg = "40% Admission Date";
			break;
	}
	return $msg;
}

function _getOrgCtgr($val) {
	$msg ="";
	switch (strtoupper($val)) {
		case "1":
			$msg = "Secondary Board";
			break;
		case "2":
			$msg = "Higher Secondary Board";
			break;
		case "3":
			$msg = "University";
			break;
	}
	return $msg;
}

function _getNoticeCtgr($val) {
	$msg ="";
	switch (strtoupper($val)) {
		case "General":
			$msg = "General";
			break;
		case "Application":
			$msg = "Application";
			break;
		case "Admit":
			$msg = "Admit";
			break;
		case "Examination":
			$msg = "Examination";
			break;
		case "Rankcard":
			$msg = "Rank Card";
			break;
		case "Admission":
			$msg = "Admission";
			break;
	}
	return $msg;
}

function _getGender($val) {
	$msg ="";
	switch (strtoupper($val)) {
		case "M":
			$msg = "MALE";
			break;
		case "F":
			$msg = "FEMALE";
			break;
		case "T":
			$msg = "TRANSGENDER";
			break;
	}
	return $msg;
}

function calculateScore($data){
	$score = 0;
	if(trim($data['pg_appl_grad_pct']) != '' && trim($data['pg_appl_hs_pct']) != '' && trim($data['pg_appl_mp_pct']) != '' ){
		$score += ((trim($data['pg_appl_grad_pct']) * 100000) + (trim($data['pg_appl_hs_pct']) * 1000) + trim($data['pg_appl_mp_pct']));
	}else{
		$score = -1;
	}
	return $score;
}
 
function getMarksCriteria($data){
	$criteria_marks = 50;
	if(strtolower($data['pg_appl_reservation']) == 'sc' || strtolower($data['pg_appl_reservation']) == 'st'){
		$criteria_marks = 45;
	}
	if($data['pg_appl_subj'] == 'MEDX' || $data['pg_appl_subj'] == 'BIOT'){
		$criteria_marks = 55;
	}
	return $criteria_marks;
}

function _getMeritCategory($val){
	$msg = "";
	switch($val){
		case "40PCT":
			$msg = "Written";
			break;
		case "60PCT":
			$msg = "Merit";
			break;
	}
	return $msg;
}

function _getAuthoritySignature($val){
	$msg = "";
	switch($val){
		case "MA":
			$msg = "signature-arts.png";
			break;
		case "MCOM":
			$msg = "signature-arts.png";
			break;
		case "MSC":
			$msg = "signature-science.png";
			break;
	}
	return $msg;
}

function _getAuthorityDesignation($val){
	$msg = "";
	switch($val){
		case "MA":
			$msg = "Secretary <br/> Faculty Council (Arts, Commerce & etc.)";
			break;
		case "MCOM":
			$msg = "Secretary <br/> Faculty Council (Arts, Commerce & etc.)";
			break;
		case "MSC":
			$msg = "Secretary <br/> Faculty Council (Science)";
			break;
	}
	return $msg;
}

	
//================================================================ SMS API : START =====================================================================
function sendUserPassword($data){
	$user_name 		= $data['user_name'];
	$ph_nos 		= $data['user_phone'];
	$password 		= $data['user_password'];
	
	
	//SEND TO MOBILE
	$sms_msg    = 'USERNAME: '.$user_name. ' PASSWORD: '.$password;
	$sms_msg	=	str_replace(" ", "+", $sms_msg);
		
	$url		=	'http://sms99.co.in/pushsms.php';
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url . "?username=trburdwan&password=O1go69&sender=ADMNBU&message=" . $sms_msg . "&numbers=" . $ph_nos);
		$output = curl_exec($curl);
		curl_close ($curl);
	
	return TRUE;
}

function sendStudentPassword($data){
	$user_name 		= $data['user_name'];
	$ph_nos 		= $data['user_phone'];
	$password 		= $data['user_password'];
	
	//SEND TO MOBILE
	$sms_msg    = 'APPL CODE: '.$user_name. ' PASSWORD: '.$password;
	$sms_msg	=	str_replace(" ", "+", $sms_msg);
		
	$url		=	'http://sms99.co.in/pushsms.php';
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url . "?username=trburdwan&password=O1go69&sender=ADMNBU&message=" . $sms_msg . "&numbers=" . $ph_nos);
		$output = curl_exec($curl);
		curl_close ($curl);
	
	return TRUE;
}


function sendApplicationCode($data){
	$ph_nos 		= $data['appl_mobile'];
	//$password 		= $data['appl_passwd'];
	$appl_code 		= $data['appl_code'];
	$appl_message 		= $data['appl_message'];
	
	//SEND TO MOBILE
	$sms_msg    = $appl_code . " : " . $appl_message;
	$sms_msg	= str_replace(" ", "+", $sms_msg);
		
	$url		=	'http://sms99.co.in/pushsms.php';
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url . "?username=trburdwan&password=O1go69&sender=ADMNBU&message=" . $sms_msg . "&numbers=" . $ph_nos);
	$output = curl_exec($curl);
	curl_close ($curl);
	
	//echo $curl;exit();
	
	return TRUE;
}

function sendGenericMessage($data){
	$ph_nos 	= $data['phones'];
	$sms_msg 	= $data['messages'];
	$sms_msg	= str_replace(" ", "+", $sms_msg);
		
	$url		=	'http://sms99.co.in/pushsms.php';
	
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url . "?username=trburdwan&password=O1go69&sender=ADMNBU&message=" . $sms_msg . "&numbers=" . $ph_nos);
	$output = curl_exec($curl);
	curl_close ($curl);
	
	//echo $url;exit();
	
	//echo $curl;exit();
	
	return TRUE;
}

//================================================================ SMS API : END =====================================================================

function applicationFeesAmount(){
	$application_fees = 200;
	return $application_fees;
}

function challanChargesAmount(){
	$application_fees = 50;
	return $application_fees;
}

function getCurrentSession() {
	return '2015-2017';
}

function admissionName(){
	$adm_name = 'Post Graduate Admission ';
	return $adm_name;
}

function PowerJyotiAccountNo(){
	$act_no = '32868998865';
	return $act_no;
}

function getRecordFromCSV($csv_file){
	$csvFile = file($csv_file);
	$data = array();
	foreach ($csvFile as $line) {
		$data[] = str_getcsv($line);
	}
	return $data;
}

function getPaymentCSVHeader(){
	$header = array('Application Code', 'Application Name', 'Payment Code', 'Payment Date');
	return $header;
}

function getRecordsPerPage($val){
		$msg = "";
		switch($val){
			case "records_per_page_small":
				$msg = 20;
				break;
			case "records_per_page_medium":
				$msg = 25;
				break;
			case "records_per_page_40":
				$msg = 40;
				break;
			case "records_per_page_large":
				$msg = 50;
				break;
		}
	return $msg;
}

function startingExamRollNumber($subj_id){
	$startNo = 15;
	if($subj_id < 10){
		$startNo .= "0".$subj_id;
	}else{
		$startNo .= $subj_id;
	}
	$startNo .= "00000001";
	
	return $startNo;
}

//===========================================================================
function getOnlinePaymentURL(){
	$str = "https://www.onlinesbi.com/prelogin/icollecthome.htm";
	return $str;
}

?>