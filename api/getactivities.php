<?php
include"../config/_dbconnect.php";
header('Content-Type: application/json');

$output = array();
$data = array();

$nric = strtoupper($_POST['nric']);
$method = $_POST['method'];

if($nric==""){
	$nric = strtoupper($_GET['nric']);
	$method = $_GET['method'];
}

if($method==1){
	$sql=mysql_query("SELECT * FROM `tblActivityLogs` WHERE nric='$nric' AND type<>'Medication' ORDER BY datetime DESC") or die(mysql_error());
}else if($method==2){
	$sql=mysql_query("SELECT * FROM `tblActivityLogs` WHERE nric='$nric' AND type='Medication' ORDER BY datetime DESC") or die(mysql_error());
}else{
	$sql=mysql_query("SELECT * FROM `tblActivityLogs` WHERE nric='$nric' ORDER BY datetime DESC") or die(mysql_error());
}

if(mysql_num_rows($sql)==0){
	$array = array('success' => 0);
}else{

	while($rows=mysql_fetch_array($sql)){
		for ($i = 0; $i < mysql_num_fields($sql); $i++) {
		    $meta = mysql_fetch_field($sql, $i);
		    $data[$meta->name] = $rows[$meta->name];
		}
		$output[] = $data;
	}

	$analysis = '';
	$types = array("Gym","Physio","Dusk to Dawn");
	$data = [];

	$sql=mysql_query("SELECT COUNT(*) AS counter FROM `tblActivityLogs` WHERE nric='$nric' AND type='Gym' ") or die(mysql_error());
	while($rows=mysql_fetch_array($sql)){
		array_push($data, $rows['counter']);
	}
	$sql=mysql_query("SELECT COUNT(*) AS counter FROM `tblActivityLogs` WHERE nric='$nric' AND type='Physio' ") or die(mysql_error());
	while($rows=mysql_fetch_array($sql)){
		array_push($data, $rows['counter']);
	}
	$sql=mysql_query("SELECT COUNT(*) AS counter FROM `tblActivityLogs` WHERE nric='$nric' AND type='Dusk to Dawn' ") or die(mysql_error());
	while($rows=mysql_fetch_array($sql)){
		array_push($data, $rows['counter']);
	}

	$maxActivty = array_keys($data, max($data));
	$minActivty = array_keys($data, min($data));

	if(max($data) > (min($data)*10) ){
		$analysis .= 'I did a lot of '.$types[$maxActivty[0]];
		$analysis .= ', but dislike doing '.$types[$minActivty[0]].'.';
	}
	else if(max($data) > (min($data)*5) ){
		$analysis .= 'I did a lot of '.$types[$maxActivty[0]];
		$analysis .= ', but need to improve on my '.$types[$minActivty[0]].' activities.';
	}else{
		$analysis .= 'I am well taken care of and did every activities on a regular basis.';
	}

	$array = array('success' => 1, 'data' => $output, 'analysis' => $analysis, 'analysisData' => $data, 'nric'=>$nric, 'method'=>$method);
}
echo json_encode( $array );
?>