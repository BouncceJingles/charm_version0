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
    
    <title>Log In</title>
    
    <!-- CSS -->
    <link href="./css/bootstrap.css" rel="stylesheet">
    <link href="./css/non-responsive.css" rel="stylesheet">
    <style>
      body {
        background-color: #9CC4E4;
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
      .error, .div-pwd {
        display: none;
      }
      .row-pwd {
        padding: 0px 15px;
      }
    </style>
    
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="./js/html5shiv.js"></script>
      <script src="./js/respond.min.js"></script>
    <![endif]-->
    
  </head>
  <body>
    <div  class="navbar navbar-default navbar-fixed-top" role="navigation">
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
              <li><a href="/viewactivities/" name="residentActivitiesBar" id="residentActivitiesBar">Resident Activities</a></li>
              <li><a href="/getresident/" name="residentParticularsBar" id="residentParticularsBar">Resident Particulars</a></li>
            <?php if($_SESSION['role']=='admin'){ ?>
              <li><a href="/newresident/">New Resident</a></li>
            <?php } ?>
              <li><a href="/api/logout.php">Logout</a></li>            
            <?php } ?>
              
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
        
<?php if($_SESSION['login']){ ?>

            <?php 
            if($_SESSION['role']!='family'){ ?>
              <h2>Welcome <br/><?php echo ucfirst($_SESSION['role']).' '.ucwords($_SESSION['name']);?></h2>
            <?php }else{ ?>
              <h2>Welcome <br/><?php echo ucwords($_SESSION['name']);?></h2>
            <?php } ?>
        
<?php }else{ ?>
        <h2>Log In</h2>
        <div class="div-nric">
          <input type="text" class="form-control" placeholder="Enter nric" name="txtNric" id="txtNric" autofocus autocomplete='off'>
          <button class="btn btn-lg btn-primary btn-block" value="Submit NRIC" id="submit">Submit</button>
        </div>
        <div class="div-pwd">
          <input type="password" class="form-control" placeholder="Enter password" name="txtPW" id="txtPW" autofocus>
          <div class="row-pwd row">
            <button class="btn btn-lg btn-primary col-md-3" value="Back" id="back">Back</button>
            <button class="btn btn-lg btn-primary col-md-offset-1 col-md-8" value="Submit PW" id="submitpw">Submit</button>
          </div>
        </div>
        <div class="error login-locked alert alert-danger">Login locked! Please contact the admin to reset your account.</div>
        <div class="error no-nric alert alert-danger">Please enter NRIC!</div>
        <div class="error cannot-find alert alert-warning">NRIC not found!</div>
        <div class="error no-pw alert alert-danger">Please enter password!</div>
        <div class="error wrong-pw alert alert-warning">password not correct!</div>
        <div class="error loading"><span class="normal"><img src="images/loading.gif"></span></div>
<?php }?>

      </div>
    </div> <!-- /container -->
    
    <!-- Javascript put end of body -->
    <script type="text/javascript" src="./js/jquery.min.js"></script>
    <script type="text/javascript" src="./js/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="./js/bootstrap.min.js"></script>
    <script type="text/javascript" src="./js/bootbox.min.js"></script>
    <script type="text/javascript" src="/js/inputmask.js"></script>
    <script>
    var loginFailCount = 0;
    var txtnric="";
      $(document).ready(function(){
      
        <?php if($_SESSION['loginLocked'] == '1'){ ?>
        $(".div-nric").hide();
            $(".login-locked").fadeIn('slow');
        <?php } ?>

        $("#submit").click(function(){
        
          if(loginFailCount==2){
            $(".div-nric").hide();
            $(".cannot-find").hide();
            $(".login-locked").fadeIn('slow');
            $(".loading").hide();
          }

          $(".error").hide();
          $(".loading").fadeTo('slow','0.99');
          if($("#txtNric").val()==""){
            $(".loading").hide();
            $(".no-nric").fadeIn('slow');
            return false;
          }
          else{
            $.getJSON("api/login.php",{nric:$("#txtNric").val(),method:4},function(json){
              console.log(json);
              if(json.success == 1){
                $(".loading").hide();
                $(".div-nric").hide();
                $(".div-pwd").fadeIn('slow');
                txtnric=$("#txtNric").val();
              }
              else if(json.success == 2){
                $(".div-nric").hide();
                $(".loading").hide();
                $(".div-pwd").hide();
                $(".login-locked").fadeIn('slow');
              }
              else{
                console.log(json);
                $(".loading").hide();
                $(".cannot-find").fadeIn('slow');
                loginFailCount++;
              }
            });
            return false;
          }
        });
        $("#back").click(function(){
          $(".div-pwd").hide();
          $("#txtPW").val("");
          $(".div-nric").fadeIn('slow');          
        });
        $("#submitpw").click(function(){
          $(".error").hide();
          $(".loading").fadeTo('slow','0.99');
          if($("#txtPW").val()==""){
            $(".loading").hide();
            $(".no-pw").fadeIn('slow');
            return false;
          }
          else{
            $.getJSON("api/login.php",{nric:txtnric,password:$("#txtPW").val(),method:3},function(json){
              console.log(json);
              if(json.success == 1){
                $(".loading").hide();
                $(".div-pwd").hide();
                window.location.href="index.php";
              }
              else if(json.success == 2){
                $(".div-nric").hide();
                $(".loading").hide();
                $(".div-pwd").hide();
                $(".wrong-pw").hide('slow');
                $(".login-locked").fadeIn('slow');
              }
              else{
                $(".loading").hide();
                $(".wrong-pw").fadeIn('slow');
              }
            });
            return false;
          }
        });
      });
    </script>
  </body>
</html>
