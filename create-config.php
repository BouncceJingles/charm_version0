<?php
$step = $_GET['step'];

if($step == 1){
	$dbname = $_POST['dbname'];
	$username = $_POST['username'];
	$pwd = $_POST['pwd'];
	$hostname = $_POST['hostname'];

	$my_file = '../webconfig.php';
	$handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);


	fwrite($handle, "<?php\n");
	fwrite($handle, "define('DB_DATABASE', '".$dbname."');\n");
	fwrite($handle, "define('DB_USERNAME', '".$username."');\n");
	fwrite($handle, "define('DB_PASSWORD', '".$pwd."');\n");
	fwrite($handle, "define('DB_SERVER', '".$hostname."');\n");
	fwrite($handle, "?>\n");
	fclose($handle);

	include"../webconfig.php";
	$connection = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die(mysql_error());
	$database = mysql_select_db(DB_DATABASE) or die(mysql_error());

	if($database)
		echo "Database configuration file has been created.";
}//end step 1
else if($step == 2){
	$tablename = $_POST['tablename'];

	/*
	$item1 = $_POST['item1'];
	$item2 = $_POST['item2'];
	$item3 = $_POST['item3'];
	$item4 = $_POST['item4'];
	*/
	$arrAttribute = $_POST['attribute'];
	$arrType = $_POST['type'];

	include"../webconfig.php";
	mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die(mysql_error());
	mysql_select_db(DB_DATABASE) or die(mysql_error());

	$strSQL = "CREATE TABLE IF NOT EXISTS `".$tablename."` (";
	$strSQL .= "`id` int(11) NOT NULL AUTO_INCREMENT,";

	foreach (array_combine($arrAttribute, $arrType) as $attribute => $type){
		$strSQL .= "`".$attribute."` ";
		$strSQL .= $type. ",";
	}
	

	$strSQL .= "PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";

	
	mysql_query($strSQL) or die(mysql_error());

	/*
	mysql_query("CREATE TABLE IF NOT EXISTS `".$tablename."` (".
  		"`id` int(11) NOT NULL AUTO_INCREMENT,".
  		"`".$item1."` ".$item2. ",".
  		"`".$item3."` ".$item4. ",".
  		"PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;") or die(mysql_error());
	*/
}

?>

<html>
	<body>

	<?php
	if(!($step == 1) || ($step == 2)){?>
	<form action="create-config.php?step=1" method="post">
	Database Name: <input type="text" name="dbname"><br>
	Username: <input type="text" name="username"><br>
	Password: <input type="text" name="pwd"><br>
	Host Name: <input type="text" name="hostname"><br>
	<input type="submit">
	</form>
	<?php
	}
	?>

	<?php 
	if($step == 1){?>
		<form action="create-config.php?step=2" method="post">
		Table Name: <input type="text" name="tablename"><br>
		Attribute: <input type="text" name="attribute[0]">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Type: <input type="text" name="type[0]"><br>
		Attribute: <input type="text" name="attribute[1]">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Type: <input type="text" name="type[1]"><br>
		Attribute: <input type="text" name="attribute[2]">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Type: <input type="text" name="type[2]"><br>
		Attribute: <input type="text" name="attribute[3]">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Type: <input type="text" name="type[3]"><br>		
		<input type="submit">
		</form>		
	<?php
	}
	?>
	</body>
</html>