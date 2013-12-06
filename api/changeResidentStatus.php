<?php
include"../config/_dbconnect.php";

$nric = strtoupper($_GET['nric']);
$status = $_GET['status'];

mysql_query("UPDATE `residents` SET status='$status' WHERE nric='$nric'") or die(mysql_error());

	$sql=mysql_query("SELECT * FROM `residents` WHERE nric='$nric'") or die(mysql_error());
	while($rows=mysql_fetch_array($sql)){
		for ($i = 0; $i < mysql_num_fields($sql); $i++) {
		    $meta = mysql_fetch_field($sql, $i);
		    $data[$meta->name] = $rows[$meta->name];
		}
	}

	$array = array('success' => 1, 'data' => $data);

echo json_encode( $array );
?>