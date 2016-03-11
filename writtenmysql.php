<?php 
$con=mysqli_connect("localhost","root","","bupgadm");
// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
/*
	$sql = "select * from written";
	$result = mysqli_query($con, $sql);
	while($row = mysqli_fetch_array($result)) {
		
		$applcode = trim($row['application_code']);
		$marks    = $row['marks'] ;

		$sqlupdate = "UPDATE exam_seat_info set exam_score = " . $marks." WHERE pg_appl_code = '" . $applcode ."'";
		
		mysqli_query($con, $sqlupdate);
		
		echo $sqlupdate . ' <br/>';
	}
*/
	$sql = "select * from exam_seat_info";
	$result = mysqli_query($con, $sql);
	while($row = mysqli_fetch_array($result)) {
		
		$applcode = trim($row['pg_appl_code']);
		$marks    = $row['exam_score'] ;

		$sqlupdate = "UPDATE pg_appl_candidates set pg_appl_written_score = " . $marks." WHERE pg_appl_code = '" . $applcode ."'";
		
		mysqli_query($con, $sqlupdate);
		
		echo $sqlupdate . ' <br/>';
	}

?> 

