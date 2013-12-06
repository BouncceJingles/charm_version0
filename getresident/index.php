<?php session_start();
if($_SESSION['login'] != '1'){
	header('Location: /index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="CHARM - Centralized Health & Activity Record Manager">
    <meta name="author" content="CHARM Dev Team">
    <link rel="shortcut icon" href="/ico/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/ico/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="./ico/favicon.png">
    
    <title>View Resident Particulars</title>
    
    <!-- CSS -->
    <link href="../../css/bootstrap.css" rel="stylesheet">
    <link href="../../css/non-responsive.css" rel="stylesheet">
    <style>
      body {
        background-color: #9CC4E4;
      }
      .get-record input {
        max-width: 100px;
      }
      .container {
        width: 100%;
        min-width: 450px;
      }
      .check-nric {
        max-width: 530px;
        margin: 0 auto;
        padding: 60px;
        border-radius: 6px;
        background-color: #E9F2F9;
      }
      .check-nric h2 {
        margin-bottom: 10px;
        text-align: center;
      }
      .check-nric input {
        position: relative;
        font-size: 16px;
        height: auto;
        padding: 10px;
        -webkit-box-sizing: border-box;
           -moz-box-sizing: border-box;
                box-sizing: border-box;
        margin-bottom: 10px;
      }
      .check-nric input:focus {
        z-index: 2;
      }
      .check-nric button {
        margin-bottom: 10px;
      }
      .display {
        margin-left: auto ;
        margin-right: auto ;
        text-align: center;
      }
      .no-nric, .cannot-find  {
        display: none;
      }
      .display {
        background-color: #FFFFFF;
      }
	  .table {
		width:410px;
	  }
	  .table td {
		width:205px;
	  }
	  .left {
		text-align: right;
		font-weight: bold;
	  }
    </style>
    
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="./js/html5shiv.js"></script>
      <script src="./js/respond.min.js"></script>
    <![endif]-->
    
  </head>
  <body>
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">
            <img class="img-rounded" src="/images/logo.png" width="32px" height="32px" />
            CHARM
          </a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <?php if($_SESSION['login']){ ?>
              <li><a href="/viewactivities/">Resident Activities</a></li>
              <li class="active"><a href="/getresident/">Resident Particulars</a></li>
            <?php } ?>
            <?php if($_SESSION['role']=='admin'){ ?>
              <li><a href="/newresident/">New Resident</a></li>
            <?php } ?>
              <li><a href="/api/logout.php">Logout</a></li>
          </ul>
          <?php if($_SESSION['login']){ ?>
          <div class="navbar-form navbar-right get-record">
            <?php 
            if($_SESSION['role']!='family'){
              echo ucfirst($_SESSION['role']).' '.ucwords($_SESSION['name']);
            }else{
              echo ucfirst($_SESSION['name']);
            }
            ?>
            <img src="/images/icon_<?php echo $_SESSION['role'];?>_avatar.png" width="30"/>            
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="check-nric">
        <h2>View Resident Particulars</h2>
        <?php if($_SESSION['role'] != 'family'){ ?>
        <input type="text" class="form-control" placeholder="Enter nric" name="txtNric" id="txtNric" autocomplete='off' autofocus>
        <button class="btn btn-lg btn-primary btn-block" value="Get Record" id="submit">Get Record</button>
        <?php } ?>
        <div class="error no-nric alert alert-danger">Please enter NRIC!</div>
        <div class="error cannot-find alert alert-warning">No result found!</div>
        <div class="display"></div>
		<div class="table" id="tbl"></div>
      </div>
    </div> <!-- /container -->
    
    <!-- Javascript put end of body -->
    <script type="text/javascript" src="../../js/jquery.min.js"></script>
    <script type="text/javascript" src="../../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../js/bootbox.min.js"></script>
    <script type="text/javascript" src="/js/inputmask.js"></script>
    <script>
      var nricNum;
      $(document).ready(function(){
        
        var isResident = false;
        var residentNric = "1";
        <?php if($_SESSION['role'] == 'family'){ ?>
        isResident = true;
        <?php echo "residentNric = '".$_SESSION['resident']."';"; ?>
        getResidentDetail(residentNric);
        <?php } ?>

        $("#submit").click(function(){
          $(".error").hide();
          $("#tbl").hide();
          $(".display").hide()
          if($("#txtNric").val()==""){
            $(".no-nric").fadeIn('slow');
            return false;
          }
          else{
            nricNum = $("#txtNric").val();
            $(".display").html('<span class="normal"><img src="/images/loading.gif"><\/span>');
            $(".display").fadeTo('slow','0.99');
            $.getJSON("../api/getResident.php",{nric:nricNum,method:1},function(json){
              console.log(json);
              if(json.success == 1){
                setTable(json.data);
				        $(".display").hide();
                $("#tbl").fadeIn('slow');
              }
              else{
                $(".display").hide();
                $(".cannot-find").html(JSON.stringify(json.message) );
                $(".cannot-find").fadeIn('slow');
              }
            });
            return false;
          }
        });
      });

    function checkout(){
      bootbox.confirm("Are you sure you want to checkout this resident?", function(result) {
        if(result){
          $(".display").html('<span class="normal"><img src="/images/loading.gif"><\/span>');
          $(".display").fadeTo('slow','0.99');
          $.getJSON("../api/changeResidentStatus.php",{nric:nricNum,status:'Checkout'},function(json){
            console.log(json);
            if(json.success == 1){
              setTable(json.data);
              $(".display").hide();
            }
            else{
              $(".display").hide();
              $(".cannot-find").fadeIn('slow');
            }
          });
        };
      });
    }

    function discharge(){
      bootbox.confirm("Are you sure you want to discharge this resident?", function(result) {
        if(result){
          $(".display").html('<span class="normal"><img src="/images/loading.gif"><\/span>');
          $(".display").fadeTo('slow','0.99');
          $.getJSON("../api/changeResidentStatus.php",{nric:nricNum,status:'Discharge'},function(json){
            console.log(json);
            if(json.success == 1){
              setTable(json.data);
              $(".display").hide();
            }
            else{
              $(".display").hide();
              $(".cannot-find").fadeIn('slow');
            }
          });
         };
      });
    }

    function getResidentDetail(nricNum){
      $.getJSON("../api/getResident.php",{nric:nricNum,method:1},function(json){
        console.log(json);
        if(json.success == 1){
          setTable(json.data);
          $(".display").hide();
          $("#tbl").fadeIn('slow');
        }
        else{
          $(".display").hide();
          $(".cannot-find").html(JSON.stringify(json.message) );
          $(".cannot-find").fadeIn('slow');
        }
      });
    }

	  function setTable(json){
  		document.getElementById("tbl").innerHTML = "<table border = '0' width='100%'>" +
  		"<tr>" +
  		"<td class='left'>Full Name:</td>" +
  		"<td id='fullName'>" + json.fullName + "</td>" +
  		"</tr>" +
  		"<tr>" +
  		"<td class='left'>NRIC:</td>" +
  		"<td id='nric'>" + json.nric + "</td>" +
  		"</tr>" +
  		"<tr>" +
  		"<td class='left'>Gender:</td>" +
  		"<td id='gender'>" + json.gender + "</td>" +
  		"</tr>" +
  		"<tr>" +
  		"<td class='left'>Date of Birth:</td>" +
  		"<td id='dob'>" + json.dob + "</td>" +
  		"</tr>" +
  		"<tr>" +
  		"<td class='left'>Check in Date:</td>" +
  		"<td id='checkInDate'>" + json.checkInDate + "</td>" +
  		"</tr>" +
  		"<tr>" +
  		"<td class='left'>Feeding Method:</td>" +
  		"<td id='feedingMethod'>" + json.feedingMethod + "</td>" +
  		"</tr>" +
  		"<tr>" +
  		"<td class='left'>Emergency<br/>Contact Number:</td>" +
  		"<td id='emergencyContactNumber'>" + json.emergencyContactNumber + "</td>" +
  		"</tr>" +
      "<tr>" +
      "<td class='left'>Status:</td>" +
      "<td id='status'>" + json.status + "</td>" +
      "</tr>" +
      <?php if($_SESSION['role']=='admin'){ ?>
      "<tr>" +
      "<td class='left'><button class='btn btn-lg btn-primary btn-block' value='Checkout' id='submitcheckout' onclick='javascript:checkout()'>Checkout</button></td>" +
      "<td><button class='btn btn-lg btn-primary btn-block' value='Discharge' id='submitdischarge' onclick='javascript:discharge()'>Discharge</button></td>" +
      "</tr>" +
      <?php } ?>
  		"<table>";
    } 
    </script>
  </body>
</html>
