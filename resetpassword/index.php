<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="CHARM - Centralized Health & Activity Record Manager">
    <meta name="author" content="CHARM Dev Team">
    <link rel="shortcut icon" href="/ico/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/ico/favicon.ico" type="image/x-icon">
    
    <title>Reset Password</title>
    
    <!-- CSS -->
    <link href="/css/bootstrap.css" rel="stylesheet">
    <link href="/css/non-responsive.css" rel="stylesheet">

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
	  .loading{
		text-align: center;
		display:none;
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
            
        </div>
      </div>
    </div>
    <div class="container">
      <div class="check-nric">
        <h2>Reset Password</h2>
        <?php
          include"../config/_dbconnect.php";
          $nric = $_GET['nric'];
          $codeVar = $_GET['code'];
          $sql=mysql_query("SELECT * FROM `logins` WHERE nric='$nric' AND password='$codeVar'") or die(mysql_error());
          if(mysql_num_rows($sql)==1){
        ?>
        <input type="password" class="form-control" placeholder="Enter new password" name="password1" id="password1"  autofocus>
        <input type="password" class="form-control" placeholder="Confirm password" name="password2" id="password2">
        <button class="btn btn-lg btn-primary btn-block" value="Get Record" id="submit">Submit</button>
        <?php }else{
          echo '<div class="error invalid alert alert-warning">Change password token as expired.</div>';
        } ?>
        <div class="error no-pw alert alert-warning">Please enter Password!</div>
        <div class="error not-match alert alert-danger">Password is not match!</div>
        <div class="loading"><img src="/images/loading.gif"></div>
      </div>
    </div> <!-- /container -->
    
    <!-- Javascript put end of body -->
    <script type="text/javascript" src="../../js/jquery.min.js"></script>
    <script type="text/javascript" src="../../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../js/bootbox.min.js"></script>
    <script type="text/javascript" src="/js/inputmask.js"></script>
    <script>
      $(document).ready(function(){
        $(".no-pw").hide();
        $(".not-match").hide();
        $("#submit").click(function(){submitdata();});

        <?php echo "var nricNumber = '".$_GET['nric']."';"; ?>
        <?php echo "var codeVar = '".$_GET['code']."';"; ?>

        function submitdata(){  
          $(".no-pw").hide();
          $(".not-match").hide();

          if($("#password1").val()=="")
          {
            $(".no-pw").fadeIn('slow');
            return false;
          }
          else if($("#password1").val()!=$("#password2").val())
          {
            $(".not-match").fadeIn('slow');
            return false;
          } 
          else
          {
            $(".loading").fadeIn('fast');
              $.getJSON("../api/resetpassword.php",{nric:nricNumber,code:codeVar,newpw:$("#password1").val()},function(json)
              {
                if(json.success == 1)
                {
                  $("#password1").hide();
                  $("#password2").hide();
                  $(".btn-lg").hide();
                  data = "<span id='msg'>Your password has been successfully changed!</span>";
                  $(".valid-phone").hide();
                }
                else
                {
                  data = "<span id='error'>Fail to add resident.</span>";
                }
                  $(".loading").fadeTo('slow','0.99');
                  $(".loading").fadeIn('slow',function(){$(".loading").html("<span id='msg'>"+data+"</span>");});
              });
            return false;
          }
          $(".loading").hide();
        };
      });
    </script>
  </body>
</html>
