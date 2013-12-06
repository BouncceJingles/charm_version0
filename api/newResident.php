<?php
include"../config/_dbconnect.php";
include"nric.php";

$nric = strtoupper($_GET['nric']);
$fullName = $_GET['fullName'];
$checkInDate = $_GET['checkInDate'];
$feedingMethod = $_GET['feedingMethod'];
$gender = $_GET['gender'];
$dob = $_GET['dob'];
$emergencyContactNumber = $_GET['emergencyContactNumber'];

$badDateFormat=0;

$checkInDate = strtotime($checkInDate);
if ($checkInDate !== false){
	$checkInDate = date('F j, Y', $checkInDate );
	$yearforchecks = date('Y', $checkInDate );
}
else{
	$badDateFormat=1;
}


$dob = strtotime($dob);
if ($dob !== false){
	$dob = date('F j, Y', $dob );
	$yearforchecks = date('Y', $checkInDate );
}
else{
	$badDateFormat=1;
}

if($badDateFormat){
	echo json_encode( array('success' => 0, 'message'=>"Bad date format!") );
}else{
	if(isNricValid($nric) || isFinValid($nric)){
		mysql_query("INSERT INTO `residents` (nric,fullName,checkInDate,feedingMethod,gender,dob,emergencyContactNumber) VALUES ('$nric','$fullName','$checkInDate','$feedingMethod','$gender','$dob','$emergencyContactNumber')") or die(mysql_error());

		echo json_encode( array('success' => 1) );
	}else{
		echo json_encode( array('success' => 0, 'message'=>"Invalid NRIC or FIN!") );
	}
}

?>