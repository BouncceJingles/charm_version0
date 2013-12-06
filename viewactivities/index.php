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
    <link rel="shortcut icon" href="./ico/favicon.png">
    
    <title>View Resident Activities</title>
    
    <!-- CSS -->
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/non-responsive.css" rel="stylesheet">
    <link href="styles/kendo.common.min.css" rel="stylesheet" />
    <link href="styles/kendo.default.min.css" rel="stylesheet" />
    <style>
      body {
        background-color: #9CC4E4;
      }
      .container {
        width: 100%;
        min-width: 450px;
      }
      .get-record input {
        max-width: 100px;
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
      .navbar-collapse {
        display: none;
      }
      .loading {
        position: absolute;
        left: 50%;
        top: 50%;
        margin-left:-63px;
        z-index: 50;
        display: none;
      }
      .bootbox-close-button.close {
        margin-top: 0px !important;
        padding: 15px;
      }
    </style>
    
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="../js/html5shiv.js"></script>
    <script src="../js/respond.min.js"></script>
    <![endif]-->
  </head>
  <body style>
    <div  class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">CHARM</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <?php if($_SESSION['login']){ ?>
              <li class="active"><a href="/viewactivities/">Resident Activities</a></li>
              <li><a href="/getresident/">Resident Particulars</a></li>
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
        <h2>View Resident Activities</h2>
        <?php if($_SESSION['role']!='family'){ ?>
        <input type="text" class="form-control" placeholder="Enter nric" name="txtNric" id="txtNric" autocomplete='off' autofocus>
        <button class="btn btn-lg btn-primary btn-block" value="Get Record" id="submit">Get Record</button>
        <?php } ?>
      </div>
      <center>
      
      <div id="example" class="k-content" style="width:800px;">
          <h1>At a glance...</h1>
          <p><div id='someinfo'></div></p>
          
          <table width="640" border="0">
            <tr>
              <td width="480"><canvas id="canvas" height="450" width="450"></canvas></td>
              <td width="150">
                <img src='../images/color-physio.png' width="15"/> Physio<br/>
                <img src='../images/color-gym.png' width="15"/> Gym<br/>
                <img src='../images/color-dusktodawn.png' width="15"/> Dusk to Dawn<br/></td>
            </tr>
          </table>
          

          <!--<div id="piechart_3d" style="width: 600px; height: 300px;"></div>-->
        <div id="grid"></div>
      </div>

      </center>
      <div class="error loading"><span class="normal"><img src="/images/ajax-loader.gif"></span></div>
      
    </div> <!-- /container -->
      
    <!-- JAVASCRIPT -->
    <script src="../js/jquery.min.js"></script>
    <script src="js/jquery-2.0.3.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/bootbox.min.js"></script>
    <script src="js/kendo.web.min.js"></script>
    <script src="shared/js/console.js"></script>
    <script src="../js/Chart.min.js"></script>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      function drawChart(gym,physio,dd) {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day (on average)'],
          ['Gym',     gym],
          ['Physio',      physio],
          ['Dusk to Dawn',  dd]
        ]);

        var options = {
          title: 'My Daily Activities',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }




      //chart.js
      var options = {
        //Boolean - Whether we should show a stroke on each segment
        segmentShowStroke : true,
        
        //String - The colour of each segment stroke
        segmentStrokeColor : "#fff",
        
        //Number - The width of each segment stroke
        segmentStrokeWidth : 2,
        
        //Boolean - Whether we should animate the chart 
        animation : true,
        
        //Number - Amount of animation steps
        animationSteps : 100,
        
        //String - Animation easing effect
        animationEasing : "easeOutBounce",
        
        //Boolean - Whether we animate the rotation of the Pie
        animateRotate : true,

        //Boolean - Whether we animate scaling the Pie from the centre
        animateScale : false,
        
        //Function - Will fire on animation completion.
        onAnimationComplete : null
      }
    </script>

    <script>
      $(document).ready(function(){
        var isResident = false;
        var residentNric = "1";
        <?php if($_SESSION['role'] == 'family'){ ?>
        isResident = true;
        <?php echo "residentNric = '".$_SESSION['resident']."';"; ?>
        getActivitiesWithNric(residentNric);
        <?php } ?>
        $("#example").hide();

        function submitnric() {
          $(".loading").fadeTo('slow','0.99');
          if($("#txtNric").val()=="")
          {
            bootbox.alert('<div class="alert alert-danger">Please enter NRIC!</div>');
          }
          else
          {
            getActivities(); 
          }
          $(".loading").hide();
        };
        
        $("#submit").click(function(){submitnric();});
        
        function getActivitiesRepeat(nricNumber){
          $.getJSON("../api/getactivities.php",{nric:nricNumber},function(json)
          {
              if(json.success == 1)
              {
                  setGrid(json.data);
                  $("#example").fadeIn('slow');
                  $("#someinfo").html(JSON.stringify(json.analysis) );

                  drawChart(json.analysisData[0],json.analysisData[1],json.analysisData[2]);
              }
              else
              {
                  bootbox.alert("No records found.");
              }
          });
        };

        function getActivities(){
          $.getJSON("../api/getactivities.php",{nric:$("#txtNric").val()},function(json)
          {
            console.log(json);
            var nric = $("#txtNric").val();
              if(json.success == 1)
              {
                  setGrid(json.data);
                  $("#example").fadeIn('slow');
                  $("#someinfo").html(JSON.stringify(json.analysis) );

                  //drawChart(json.analysisData[0],json.analysisData[1],json.analysisData[2]);
                  //self.setInterval(function(){getActivitiesRepeat(nric)},1000);

                  var a = json.analysisData[0];
                  var b = json.analysisData[1];
                  var c = json.analysisData[2];
                  var abc = a+b+c;

                  a = (a/abc)*100
                  b = (b/abc)*100
                  c = (c/abc)*100
                  
                  var pieData = [
                    {
                      value: a,
                      color : "#69D2E7"
                    },
                    {
                      value : b,
                      color:"#F38630"
                    },
                    {
                      value : c,
                      color : "#E0E4CC"
                    }
                  
                  ];
                  var myPie = new Chart(document.getElementById("canvas").getContext("2d")).Pie(pieData,options);
              }
              else
              {
                  bootbox.alert("No records found.");
              }
          });
        };

        function getActivitiesWithNric(nricNumber){
          $.getJSON("../api/getactivities.php",{nric:nricNumber},function(json)
          {
            console.log(nricNumber);
            console.log(json);
              if(json.success == 1)
              {
                  setGrid(json.data);
                  $("#example").fadeIn('slow');
                  $("#someinfo").html(JSON.stringify(json.analysis) );

                  //drawChart(json.analysisData[0],json.analysisData[1],json.analysisData[2]);

                  var a = json.analysisData[0];
                  var b = json.analysisData[1];
                  var c = json.analysisData[2];
                  var abc = a+b+c;

                  a = (a/abc)*100
                  b = (b/abc)*100
                  c = (c/abc)*100
                  
                  var pieData = [
                    {
                      value: a,
                      color : "#69D2E7"
                    },
                    {
                      value : b,
                      color:"#F38630"
                    },
                    {
                      value : c,
                      color : "#E0E4CC"
                    }
                  
                  ];
                  var myPie = new Chart(document.getElementById("canvas").getContext("2d")).Pie(pieData,options);
              }
              else
              {
                  bootbox.alert("No records found.");
              }
          });
        };
        
        function setGrid(activitiesData){
          $("#grid").kendoGrid({
              dataSource: {
                  data: activitiesData,
                  schema: {
                      model: {
                          fields: {
                              datetime: { type: "string" },
                              type: { type: "string" },
                              remarks: { type: "string" }
                          }
                      }
                  },
                  pageSize: 10
              },
              height: 400,
              scrollable: true,
              sortable: true,
              filterable: true,
              pageable: {
                  input: true,
                  numeric: false
              },
              columns: [
                  { field: "datetime", title: "Date and Time", width: "130px" },
                  { field: "type", title: "Type", width: "130px" },
                  { field: "remarks", title: "Remarks", width: "130px" }                 
              ]
          });
          if($(".check-nric").length > 0){
            if(!isResident)
              $(".navbar-collapse").append('<div class="navbar-form navbar-right get-record"><input type="text" class="form-control input-sm" placeholder="Enter nric" name="txtNric" id="txtNric" autocomplete="off" autofocus><button class="btn btn-default btn-sm" type="submit" value="Get Record" id="submit">Get Record</button></div>'); 
            $(".check-nric").remove();
            $(".navbar-collapse").fadeIn('slow');
            $("#submit").click(function(){submitnric();});
          }
        };
      });


    </script>
  </body>
</html>
