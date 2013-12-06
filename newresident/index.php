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
    
    <title>Add New Resident</title>
    
    <!-- CSS -->
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/non-responsive.css" rel="stylesheet">
    <link href="../css/datepicker.css" rel="stylesheet">
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
            <?php if($_SESSION['login']){ ?>
              <li><a href="/viewactivities/">Resident Activities</a></li>
              <li><a href="/getresident/">Resident Particulars</a></li>
              <?php if($_SESSION['role']=='admin'){ ?>
                <li class="active"><a href="/newresident/">New Resident</a></li>
              <?php } ?>
            <?php } ?>
              <li><a href="/api/logout.php">Logout</a></li>
          </ul>
          <?php if($_SESSION['login']){ ?>
          <div class="navbar-form navbar-right get-record">
            <?php echo ucfirst($_SESSION['role']).' '.ucwords($_SESSION['name']);?>
            <img src="/images/icon_<?php echo $_SESSION['role'];?>_avatar.png" width="30"/>            
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="check-nric">
        <h2>Add New Resident</h2>
        <input type="text" class="form-control" placeholder="NRIC" name="txtNric" id="txtNric" autocomplete='off' autofocus>
        <input type="text" class="form-control" placeholder="Full Name" name="fullName" id="fullName" autocomplete='off'>
        <div class="radio-inline"><label><input type="radio" name="gender" class="gender" id="gender" value='Male'>Male</label></div>
        <div class="radio-inline"><label><input type="radio" name="gender" class="gender" id="gender" value='Female'>Female</label></div>
        <input type="text" class="form-control" placeholder="Date of Birth" name="dob" id="dob">
        <!--<input type="text" class="span2" data-date-format="YYYY-MM-DD" name="dob" id="dob">-->
        <input type="text" class="form-control" placeholder="Check In Date" name="checkInDate" id="checkInDate">
        <div class="radio-inline"><label><input type="radio" name="feedingMethod" class="feedingMethod" id="feedingMethod" value='Tube Feeding'>Tube Feeding</label></div>
        <div class="radio-inline"><label><input type="radio" name="feedingMethod" class="feedingMethod" id="feedingMethod" value='Soft Food'>Soft Food</label></div>
        <input type="text" class="form-control" placeholder="Emergency Contact Number" name="emergencyContactNumber" id="emergencyContactNumber" autocomplete='off'>
        <button class="btn btn-lg btn-primary btn-block" value="Get Record" id="submit">Submit</button>
        <div class="error no-nric alert alert-danger">Please enter NRIC!</div>
        <div class="error no-name alert alert-danger">Please enter Full Name!</div>
        <div class="error no-gender alert alert-danger">Please enter Gender!</div>
        <div class="error no-feeding alert alert-danger">Please enter Feeding Method!</div>
        <div class="error cannot-find alert alert-warning">No result found!</div>
        <div class="error valid-phone alert alert-warning">Enter a valid phone number!</div>
        <div class="error return-msg alert alert-warning"></div>
        <div class="loading"><img src="/images/loading.gif"></div>
      </div>
    </div> <!-- /container -->
    
    <!-- Javascript put end of body -->
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../js/bootbox.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="/js/inputmask.js"></script>
    <script>
      $(document).ready(function(){
        $(".error").hide();
          $(".return-msg").hide();

          $('#dob').datepicker({
              startDate: "01/01/1900",
              endDate: "12/31/2012"
          });

          $('#checkInDate').datepicker({
              startDate: "01/01/2000",
              endDate: "12/31/2013",
              todayBtn: true,
              todayHighlight: true
          });

        $("#submit").click(function(){submitdata();});

        function submitdata(){
          $(".error").hide();

           var phoneNumber = document.getElementById("emergencyContactNumber").value;
           var phonePattern = "^[68-9][0-9]{7}$";
           
          if($("#txtNric").val()=="")
          {
            $(".no-nric").fadeIn('fast');
          }
          else if ($("#fullName").val()=="") {
            $(".no-name").fadeIn('fast');
          }
		  else if ( $.trim( $('#fullName').val() ) == '' )
          {
            $("#fullName").val('');
            $(".no-name").fadeIn('fast');
          }
          else if ($(".gender:checked").length==0) {
            $(".no-gender").fadeIn('fast');
          }
          else if ($(".feedingMethod:checked").length==0) {
            $(".no-feeding").fadeIn('fast');
          }
          else if (!phoneNumber.match(phonePattern) ) {
            $(".valid-phone").fadeIn('fast');
          }
          
          else
          {
            $(".loading").html('<span class="normal"><img src="/images/loading.gif"></span>');
            $(".loading").fadeIn('fast');
              $.getJSON("../api/newResident.php",{nric:$("#txtNric").val(),fullName:$("#fullName").val(),checkInDate:$("#checkInDate").val(),feedingMethod:$(".feedingMethod:checked").val(),gender:$(".gender:checked").val(),dob:$("#dob").val(),emergencyContactNumber:$("#emergencyContactNumber").val()},function(json)
              {
                if(json.success == 1)
                {
                  $(".return-msg").html( "Success adding new resident." );
                  $(".return-msg").fadeIn('fast');
				  $(":input").attr("disabled", true);
				  setTimeout(function(){window.location.reload();}, 1000);		  
                }
                else
                {
                  $(".return-msg").html(JSON.stringify(json.message) );
                  $(".return-msg").fadeIn('fast');
                  //data = "<span id='error'>Fail to add resident: "+json.message+"</span>";
                }
                $(".loading").hide();
                  //$(".loading").fadeTo('slow','0.99');
                  //$(".loading").fadeIn('slow',function(){$(".loading").html("<span id='msg'>"+data+"</span>");});
              });
            return false;
          }
          $(".loading").hide();
        };
      });
    </script>
  </body>
</html>
