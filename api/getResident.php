<?php
include"../config/_dbconnect.php";
header('Content-Type: application/json');

$nric = strtoupper($_POST['nric']);
$nurse_nric = strtoupper($_POST['nurse_nric']);

if($nric==""){
	$nric = strtoupper($_GET['nric']);
	$nurse_nric = strtoupper($_SESSION['nric']);
	$method = $_GET['method'];
}

	$data = array();

	$sql=mysql_query("SELECT * FROM `residents` WHERE nric='$nric'") or die(mysql_error());
	while($rows=mysql_fetch_array($sql)){
		for ($i = 0; $i < mysql_num_fields($sql); $i++) {
		    $meta = mysql_fetch_field($sql, $i);
		    $data[$meta->name] = $rows[$meta->name];
		}
	}

	if(mysql_num_rows($sql)==1){
		if($method && $_SESSION['role']!='nurse'){
			if($data['status']=='Discharged' || $data['status']=='Checkout')
				$array = array('success' => 0, 'message' => $data['fullName'].' has been discharged or checkout.');
			else
				$array = array('success' => 1, 'data' => $data);
		}else{
			$sqlb=mysql_query("SELECT * FROM `residentbelongto` WHERE nurse='$nurse_nric' AND patient='$nric'") or die(mysql_error());

			if(mysql_num_rows($sqlb)==1){
				if($data['status']=='Discharged' || $data['status']=='Checkout')
					$array = array('success' => 0, 'message' => $data['fullName'].' has been discharged or checkout.');
				else
					$array = array('success' => 1, 'data' => $data);
			}else{
				$array = array('success' => 0, 'message' => 'This resident is not assign to you.');
			}
		}

	}else{
		$array = array('success' => 0, 'message' => 'This is not a valid resident.');
	}

echo json_encode( $array );
?>