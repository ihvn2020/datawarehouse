<?php
/**ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);**/
session_start();
error_reporting(E_ERROR | E_PARSE);
//require_once('scheduled_trigger.php');
require '../config/config.php';  // Database connection
require_once('../protectpages.php');
$ipname 	= $_SESSION['unames'];

require '../config/database.php';  // Database connection
require_once('../protectpages.php');
include_once '../model/dao/facts_years.php';
include_once '../model/dao/facts_quarters.php';
include_once '../model/dao/reports.php';
include_once '../model/dao/facts_states.php';
include_once '../model/dao/all_facilities.php';
include_once '../model/dao/compare_indicator.php';
include_once '../model/dao/facts_facility.php';


$database = new Database();
$factdb = $database->getConnection();


// include classes

$fact_years = new PFacts_Years($factdb);
$fact_quarters = new Fact_Quarters($factdb);
$fact_facility = new Fact_Facility($factdb);
$fact_states = new Fact_States($factdb);
$repo = new Reports($factdb);
$facilities = new All_Facilities($factdb);
$indi = new Compare_Indicator($factdb);

$year=date("Y");
extract($fact_years->getQuarter((new DateTime())));
$quarter=$quart;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect value of input field
    $year = $_POST['year'];
	$quarter = $_POST['quarter'];
	$state = $_POST['state'];
	$facilitydatim = $_POST['subcat'];
	$facilityname = $_POST['test_text'];
    //$indicatorid = array();
	//$indicator = $_POST['basic'];
	$indicatorid = implode(",",$_POST['basic']);
	if($facilitydatim=="Select Facility"){
		
			if(empty($state)) 
				{
					$indivalue= $indi->getIndicatorValueAll($indicatorid,$year,$quarter);
					foreach($indivalue as $row) {
						$indiname[] = $row['cohort_short_name'];
						$indival[] = $row['value'];
					}
			}else
			{
				$indivalue= $indi->getIndicatorValue($indicatorid,$state,$year,$quarter);
				foreach($indivalue as $row) {
					$indiname[] = $row['cohort_short_name'];
					$indival[] = $row['value'];
				}
			}
	
	}
	else{
		$indivalue= $indi->getIndicatorValueFacility($indicatorid,$facilitydatim,$year,$quarter);
			foreach($indivalue as $row) {
				$indiname[] = $row['cohort_short_name'];
				$indival[] = $row['value'];
			}
		
	}
}
	
	
?>

<html>
<head>
<meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Data Warehouse Dashboard</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="shortcut icon" type="image/png" href="../images/login_icon.ico"/>
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="" crossorigin="anonymous">
    <link rel="stylesheet" id="main-stylesheet" data-version="1.1.0" href="../styles/shards-dashboards.1.1.0.min.css">
    <link rel="stylesheet" href="../styles/extras.1.1.0.min.css">
    <link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" />
    <link href="./jquery.multiselect.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="./jquery.multiselect.js"></script>
	<style>
		#loading {
		position: fixed;
		width: 100%;
		height: 100vh;
		background: transparent url('../images/loader.gif') no-repeat center center ;
		z-index: 9999;
		}
	</style>
	<style type="text/css">
.highcharts-figure, .highcharts-data-table table {
    min-width: 310px; 
    max-width: 800px;
    margin: 1em auto;
}

#tatcontainer {
    height: 400px;
}

.highcharts-data-table table {
	font-family: Verdana, sans-serif;
	border-collapse: collapse;
	border: 1px solid #EBEBEB;
	margin: 10px auto;
	text-align: center;
	width: 100%;
	max-width: 500px;
}
.highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
}
.highcharts-data-table th {
	font-weight: 600;
    padding: 0.5em;
}
.highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
    padding: 0.5em;
}
.highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
}
.highcharts-data-table tr:hover {
    background: #f1f7ff;
}

		</style>

		
				
	<script async defer src="https://buttons.github.io/buttons.js"></script>
	
			<script src="../code/highcharts.js"></script>
			<script src="../code/modules/exporting.js"></script>
			<script src="../code/modules/export-data.js"></script>
			<script src="../code/modules/data.js"></script>
			<script src="../code/modules/drilldown.js"></script>
			<script src="../code/modules/series-label.js"></script>
			<script src="../code/highcharts-more.js"></script>
			
			
			<script src="../code/highcharts-3d.js"></script>
			<script src="../code/modules/accessibility.js"></script>


<script type="text/javascript">
function AjaxFunction()
{
	 //var cat_id=document.getElementById('state').value;
	 //alert(cat_id);

var httpxml;
try
  {
  // Firefox, Opera 8.0+, Safari
  httpxml=new XMLHttpRequest();
  }
catch (e)
  {
  // Internet Explorer
		  try
   			 		{
   				 httpxml=new ActiveXObject("Msxml2.XMLHTTP");
    				}
  			catch (e)
    				{
    			try
      		{
      		httpxml=new ActiveXObject("Microsoft.XMLHTTP");
     		 }
    			catch (e)
      		{
      		alert("Your browser does not support AJAX!");
      		return false;
      		}
    		}
  }
function stateck() 
    {
		if(httpxml.readyState==4)
		  {
			//alert(httpxml.responseText);
			var myarray = JSON.parse(httpxml.responseText);
			// Remove the options from 2nd dropdown list 
			for(j=document.testform.subcat.options.length-1;j>=0;j--)
			{
				document.testform.subcat.remove(j);
				
			}
			var sel = document.getElementById('subcat');
			var optn = document.createElement("option");
			optn.text = "Select Facility";
			document.testform.subcat.options.add(optn);
			for (i=0;i<myarray.data.length;i++)
			{
				//alert(myarray.data.length);
				var optn = document.createElement("option");
				optn.text = myarray.data[i].facility_name;
				optn.value = myarray.data[i].datim_id;  // You can change this to subcategory 
				document.testform.subcat.options.add(optn);
			} 
		}
	} // end of function stateck
			var url="dd.php";
		var cat_id=document.getElementById('state').value;
		url=url+"?cat_id="+cat_id;
		url=url+"&sid="+Math.random();
		httpxml.onload=stateck;
		//alert(url);
		httpxml.open("GET",url,true);
		httpxml.send(null);
}
</script>
</head>
<body>
<script>
$(document).ready(function(){
    AjaxFunction();
});</script>
<script>
$(document).ready( function () {
   
   
   jQuery('#loading').fadeOut(1000);
  $("#cont").css("display","block");
  
});
</script>
    <script>
    $(function () {
        $('select[multiple].active.3col').multiselect({
            columns: 2,
            placeholder: 'Select Indicators',
            search: true,
            searchOptions: {
                'default': 'Search Indicators'
            },
            selectAll: true
        });

    });
</script>
  <div id="loading"></div>
<div class="container-fluid" id="cont" style="display:none">
      <div class="row">
        <main class="main-content col-lg-12 col-md-12 col-sm-12 p-0 offset-lg-12 offset-md-12">
		<div class="main-navbar">
            
          </div>
         
         
          <div class="main-navbar sticky-top bg-light">
            <!-- Main Navbar -->
			
            <nav class="navbar align-items-stretch navbar-light flex-md-nowrap p-0">
			 <li class="nav-item dropdown">
                  <a class="nav-link text-nowrap px-3" data-toggle="" href="home.php" role="button" aria-haspopup="true" aria-expanded="false">
                    <img class="user-avatar rounded-circle mr-2" src="../resources/images/login_icon.ico" alt="User Avatar">
                    <span class="d-none d-md-inline-block" style="color:#17c671";><button type="button" class="mb-2 btn btn-success mr-2"><strong>IHVN Dashboard</strong></button></span>
				   </a>
                  
                </li>
				 
					
			         
              <ul class="navbar-nav border-right flex-row ">
			
				<li><a class="dropdown-item text-danger" href="compareind.php">
                     <i class="material-icons text-danger">&#xE879;</i> <b>Compare Indicators</b></a></li>
                <li><a class="dropdown-item text-danger" href="reports.php">
                     <i class="material-icons text-danger">&#xE879;</i> <b>Generate Reports</b></a></li>
											
				<li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle text-nowrap px-3" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <img class="user-avatar rounded-circle mr-2" src="../resources/images/logimg.png" alt="User Avatar">
                    <span class="d-none d-md-inline-block"><?php echo $ipname; ?></span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-small">
                    <!--<a class="dropdown-item" href="">
                      <i class="material-icons">&#xE7FD;</i> <b>Facility Access</b></a> -->
                   <a class="dropdown-item" href="../logout.php">
                      <i class="material-icons">&nbsp;</i> <b>Log Out</b></a>
					   
                   
                   
                    <!--<a class="dropdown-item text-danger" href="#">
                      <i class="material-icons text-danger">&#xE879;</i><b> Logout</b> </a>
					   <div class="dropdown-divider"></div>-->
                  </div>
                </li>
				
				
				
              </ul>
              		  
            </nav>
          </div>
          <!-- / .main-navbar -->
		  
			
          <div class="main-content-container container-fluid px-4">
            <!-- Page Header -->
            <div class="page-header row no-gutters py-4">
             
			  <div class="col-sm-12 col-md-12" align='left'>
                	 <form name="testform" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                            <div class="form-row">
                              <div class="form-group col-md-1">
                               Indicator Filter:
							  </div>
							   FY: <div  class="form-group col-md-1">
                              	  <?php
								  
								  			$stmt = $fact_years->read();												
				                           echo "<select name='year' class='form-control is-valid'>";
											echo "<option>Select Year</option>";
												while ($row_facts = $stmt->fetch(PDO::FETCH_ASSOC)){
														extract($row_facts);
														
														if($year==$code){
															echo "<option value='$code' selected>";
																	//$fy=$code;
														}else{
															echo "<option value='$code'>";
																	//$fy=$code;
														}
														echo "$code</option>";
													}
											echo "</select>";
											
								?> 
								  
							</div>Quarter: <div  class="form-group col-md-1">
                              	  <?php
											
								  			$stmts = $fact_quarters->read();												
				                           echo "<select name='quarter' class='form-control is-valid'>";
											echo "<option>Select Quarter</option>";
												while ($row_facts = $stmts->fetch(PDO::FETCH_ASSOC)){
														extract($row_facts);
														
														if($quarter==$code){
															echo "<option value='$code' selected>";
																	//$q=$code;
														}else{
															echo "<option value='$code'>";
																	//$quarter=$code;
														}
														echo "$name</option>";
													}
											echo "</select>";
								?> 
								  
							</div>
							State: <div  class="form-group col-md-2">
                              	  <?php
											
								  			$stmts = $fact_states->read();												
				                           echo "<select name='state' id='state' class='form-control is-valid' autofocus onblur='AjaxFunction()'>";
											echo "<option value=''>Select State</option>";
												while ($row_facts = $stmts->fetch(PDO::FETCH_ASSOC)){
														extract($row_facts);
														
														if($state==$state_id){
															echo "<option value='$state_id' selected>";
																	//$q=$code;
														}else{
															echo "<option value='$state_id'>";
																	//$quarter=$code;
														}
														echo "$name</option>";
													}
											echo "</select>";
								?> 
								  
							</div>
							Facility: <div  class="form-group col-md-2">
										<select name="subcat" id="subcat" class="form-control is-valid" onchange="document.getElementById('text_content').value=this.options[this.selectedIndex].text">
                              	 
											<option value=''>Select Facility</option>
										</select>
										<input type="hidden" name="test_text" id="text_content" value="" />
								  
							</div>
							Indicator: <div  class="form-group col-md-2">
                              	  <?php
											
								  			$stmts = $fact_states->readIndicator();												
				                           echo "<select name='basic[]' multiple='multiple' class='3col active'>";
												while ($row_facts = $stmts->fetch(PDO::FETCH_ASSOC)){
														extract($row_facts);
														if(isset($_POST['basic']) && in_array($id,$_POST['basic'])){
															echo "<option value='$id' selected>";
														}			
														else{
															echo "<option value='$id'>";
														}
														echo "$cohort_short_name</option>";
													}
											echo "</select>";
								?> 
								  
							</div>
							<div class="form-group col-md-1">
                                 <button id="b" type="submit"  name="submit"class="mb-2 btn btn-sm btn-success mr-1" >Filter</button>
								 
                              </div>
	<br><br><br>
	
	<div class="col-lg-12 col-md-12 col-sm-12 mb-4" id="total" style="display:block" >
			  <!-- Samples Received -->
                <div class="card card-small" >
                  <div class="card-header border-bottom">
                    <h6 class="m-0">Indicator Comparison for  - Q<?php echo $quarter;?> FY <?php echo $year;?> for <?php if($state=='')echo $facilityname;else echo $state;?> &ensp; </h6>
					</div>
                  <div class="card-body pt-0">
                    
                    <div id="rejcontainer" style="min-width: 95%;max-width: 95%; height: 400px; margin: 0 auto">
					</div>
					<div class="col-12 col-sm-6 d-flex mb-2 mb-sm-0">
                       <br>
                      </div>
                  </div>
                </div>
				<!-- Samples Received --><br>
				<footer class="main-footer d-flex p-2 px-3 bg-white border-top">
            <ul class="nav">
              <li class="nav-item">
                <a class="nav-link" href="#">Home</a>
              </li>
              
            </ul>
            <span class="copyright ml-auto my-auto mr-2">Copyright © 2020
              <a href="" rel="nofollow">IHVN Dashboard</a>
            </span>
          </footer>
              </div>	
			  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    <script src="https://unpkg.com/shards-ui@latest/dist/js/shards.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sharrre/2.0.1/jquery.sharrre.min.js"></script>
    <script src="../scripts/extras.1.1.0.min.js"></script>
    <script src="../scripts/shards-dashboards.1.1.0.min.js"></script>
	

		<script type="text/javascript">
var arr = <?php echo json_encode($indiname);?>;
var arr1 = <?php echo json_encode($indival);?>;
//var tempArray = <?php echo json_encode($_POST['basic']); ?>;

   //You will be able to access the properties as 
    //alert(tempArray[0].Key);
	Highcharts.chart('rejcontainer', {
    chart: {
        type: 'column'
    },
    title: {
        text: ''
    },
    xAxis: {
		
        categories: arr
		
    },
	
    yAxis: {
        min: 0,
        title: {
            text: 'Indicator Comparison'
        },
        stackLabels: {
            enabled: false,
            style: {
                fontWeight: 'bold',
                color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
            }
        }
    },
    legend: {
        align: 'center',
        x: 0,
        verticalAlign: 'bottom',
        y: 25,
        floating: true,
        backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
        borderColor: '#CCC',
        borderWidth: 0,
		fontWeight: 'bold',
        shadow: false
    },
    
    plotOptions: {
        column: {
            stacking: 'normal',
            dataLabels: {
                enabled: true,
                color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
            }
        }
    },
    series: [{
        name: '',
        data: [<?php echo join($indival, ',') ?>]
    }]
});
 
		</script>	
<script type="text/javascript"> 
        document.getElementById("one").onclick = function() {   
            document.getElementById("total").style.display = "block";
			document.getElementById("receivedser").style.display = "none";
			document.getElementById("tabb").style.display = "none"; 
			document.getElementById("alertt").style.display = "none"; 
			document.getElementById("txcurr").style.display = "none";
			document.getElementById("rejreasonsperyr").style.display = "none";
			document.getElementById("tested").style.display = "none";
			document.getElementById("suppressed").style.display = "none";
			document.getElementById("dispatched").style.display = "none";
		}  
		
		</script>		
</body>
</html>
