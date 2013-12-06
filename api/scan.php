<?php
include"../config/_dbconnect.php";
header('Content-Type: application/json');

$nric = strtoupper($_POST['nric']);
$nurse_nric = strtoupper($_POST['nurse_nric']);
$datetime = $_POST['datetime'];
$type = $_POST['type'];
$data = $_POST['data'];

$types = array("Medication","Gym","Physio","Dusk to Dawn");
$typeText  = $types[$type];

	$sql=mysql_query("SELECT id FROM `residents` WHERE nric='$nric'") or die(mysql_error());

	if($type==0){
		$sqlb=mysql_query("SELECT * FROM `residentbelongto` WHERE nurse='$nurse_nric' AND patient='$nric'") or die(mysql_error());
		if(mysql_num_rows($sqlb)==1){
			$sqlc=mysql_query("SELECT * FROM `tblActivityLogs` WHERE nric='$nric' AND datetime='$datetime' AND type='$type'") or die(mysql_error());
			if(mysql_num_rows($sqlc)==0){
				mysql_query("INSERT INTO `tblActivityLogs` (nric, datetime, type, remarks) VALUES ('$nric','$datetime','$typeText','$data')") or die(mysql_error());
			}
			echo json_encode( array('success' => 1) );
		}else{
			echo array('success' => 0, 'message' => 'This resident is not assigned to you.');
		}
	}else{
		if(mysql_num_rows($sql)==1){
			mysql_query("INSERT INTO `tblActivityLogs` (nric, datetime, type, remarks) VALUES ('$nric','$datetime','$typeText','$data')") or die(mysql_error());
			echo json_encode( array('success' => 1) );
		}else{
			echo json_encode( array('success' => 0, 'message' => 'Resident does not exist.') );
		}
	}

?>