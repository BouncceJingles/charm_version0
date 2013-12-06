<?php
session_start();
include"../config/_dbconnect.php";
header('Content-Type: application/json');

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

	$nric = strtoupper($_POST['nric']);
	$password = md5($_POST['password']);
	$method = $_POST['method'];

	if($nric==""){
		$nric = strtoupper($_GET['nric']);
		$password = md5($_GET['password']);
		$method = $_GET['method'];
	}

	if($_SESSION['loginFailCount']>'3'){
		$_SESSION['loginLocked']=1;
	}

if( ($_SESSION['loginLocked']==1 || $_SESSION['loginFailCount'] > '3') ){//&&  $_SESSION['emailResetSent']!=1
	
	$newPw = md5(generateRandomString(10));
	$email = $_SESSION['email'];
	$_SESSION['emailResetSent'] = 1;

/*
	mysql_query("UPDATE `logins` SET password='$newPw',locked='1' WHERE nric='$nric' AND email='$email'") or die(mysql_error());

	$to = $email;
	$subject = "CHARM: Locked Account";
	$mainHeader = "Your account has been locked";	
	$content = "Your account at CHARM has been accessed and failed to login multiple times. Your password has been reset and you are required to click this link to reactivate your account.<br/>";
	$content.="<a href='http://localhost:8888/resetpassword/?nric=".$nric."&code=".$newPw."'>Reset password here</a>";
	$content.="<br/><br/><small>This is a generated email, do not reply to this email.</small>";
	include "emailSendAPI.php";
	*/

	$array = array('success' => 2,'message' => 'Login Locked: '.$email);
}
else {//if(isNricValid($nric) || isFinValid($nric)){

	$data = array();

	if($method==1){
		$sql=mysql_query("SELECT name,role FROM `logins` WHERE nric='$nric' AND role='nurse'") or die(mysql_error());
	}
	if($method==2 || $method==3){
		$sql=mysql_query("SELECT * FROM `logins` WHERE nric='$nric' AND password='$password'") or die(mysql_error());
	}
	if($method==4){
		$sql=mysql_query("SELECT * FROM `logins` WHERE nric='$nric'") or die(mysql_error());
		
	}

	if(mysql_num_rows($sql)==1 && ($method==1  || $method==4)){
		
		while($rows=mysql_fetch_array($sql)){
			for ($i = 0; $i < mysql_num_fields($sql); $i++) {
			    $meta = mysql_fetch_field($sql, $i);
			    $data[$meta->name] = $rows[$meta->name];
			}
		}
		$_SESSION['email'] = $data['email'];
		$_SESSION['loginFailCount']=1;
		$array = array('success' => 1, 'data' => $data);
	}
	else if(mysql_num_rows($sql)==1  && ($method==2 || $method==3)){
		while($rows=mysql_fetch_array($sql)){
			for ($i = 0; $i < mysql_num_fields($sql); $i++) {
			    $meta = mysql_fetch_field($sql, $i);
			    $data[$meta->name] = $rows[$meta->name];
			}
		}
		if($method==3){
			$_SESSION['login'] = '1';
			$_SESSION['name'] = $data['name'];
			$_SESSION['role'] = $data['role'];
			$_SESSION['nric'] = $data['nric'];
			$_SESSION['resident'] = $data['resident'];
			$array = array('success' => 1, 'data' => $data);
		}else{
			if($data['role']=="nurse"){
				$array = array('success' => 1);
			}else{
				$array = array('success' => 0,'message' => 'Nurse access only');
			}
		}
	}
	else{
		if($method==1){
			$array = array('success' => 0,'message' => 'Invalid NRIC or not a nurse');
		}
		else if($method==2 || $method==3  || $method==4){
			if(!isset($_SESSION['loginFailCount'])){
				$_SESSION['loginFailCount']=1;
			}
			$_SESSION['loginFailCount']=$_SESSION['loginFailCount']+1;
			$array = array('success' => 0,'message' => 'Invalid Password'.$_SESSION['loginFailCount']);
		}
		else{
			$array = array('success' => 0,'message' => 'Invalid Login Function, use method 1 or 2 or 3; nric: '.$nric.' password: '.$password.' method: '.$method);
		}
	}
	
}
/*else{
	$array = array('success' => 0,'message' => 'Invalid NRIC or FIN number.');
}*/

echo json_encode( $array );
?>