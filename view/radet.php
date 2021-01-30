<!DOCTYPE html>
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
include_once '../model/dao/facts_states.php';
include_once '../model/dao/radet_report.php';
include_once '../model/dao/all_facilities.php';


$database = new Database();
$factdb = $database->getConnection();


// include classes

$fact_years = new PFacts_Years($factdb);
$fact_quarters = new Fact_Quarters($factdb);
$fact_states = new Fact_States($factdb);
$radetObj = new Radet_Object($factdb);
$facilities = new All_Facilities($factdb);

$year=date("Y");
extract($fact_years->getQuarter((new DateTime())));
$quarter=$quart;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect value of input field
    $year = $_POST['year'];
	$quarter = $_POST['quarter'];
	$state = $_POST['state'];
    
	$facilityid = $_POST['subcat'];
	$facilitynameee = $_POST['test_text'];
    
	$rade=$radetObj->getRadet($facilityid,$year,$quarter);
	//echo ($rade->patient_unique_id);
	
	}

	
?>

<html class="no-js h-100" lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Data Warehouse Dashboard</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="shortcut icon" type="image/png" href="../images/login_icon.ico"/>
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.css" />
    <link rel="stylesheet" id="main-stylesheet" data-version="1.1.0" href="../styles/shards-dashboards.1.1.0.min.css">
    <link rel="stylesheet" href="../styles/extras.1.1.0.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/css/dataTables.bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.bootstrap.min.css" type="text/css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.1/css/buttons.bootstrap.min.css" type="text/css" />
	
    <script async defer src="https://buttons.github.io/buttons.js"></script>	
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>	
		<style>
.nobr { white-space: nowrap }
</style>	
	<style>
	
	nav {
  position:absolute;
  left: 0px;
  height: 50px;
  background-color: #ffffff;
  width: 100%;
  margin: 0;
}
ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: #ffffff00;
}

li {
  float: left;
}

li a {
  display: block;
  color: white;
  text-align: right;
  padding: 16px;
  text-decoration: none;
}

li a:hover {
  background-color: #ffffff00;
}
</style>
	
  
	<style>
		#loading {
		position: fixed;
		width: 100%;
		height: 100vh;
		background: transparent url('../images/loader.gif') no-repeat center center ;
		z-index: 9999;
		}
	</style>
	<style>
  .datatable tfoot {
  display: table-header-group;
}

.datatable tfoot .filter-column {
  width: 100% !important;
}

</style>
	<script>
$(document).ready( function () {
   
   
   jQuery('#loading').fadeOut(1000);
  $("#cont").css("display","block");
  
});
</script>
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
  <body  class="h-100">
  <script>
$(document).ready(function(){
    AjaxFunction();
});</script>
  

    <div class="container-fluid" id="cont" style="display:none">
      <div class="row">
        <main class="main-content col-lg-12 col-md-12 col-sm-12 p-0 offset-lg-12 offset-md-12">
		<div class="main-navbar">
            
          </div>
         
         
          <div class="main-navbar sticky-top bg-light">
            <!-- Main Navbar -->
			
            <nav class="navbar align-items-stretch navbar-light flex-md-nowrap p-0 " >
			 <li class="navbar-nav">
                  <a class="nav-link text-nowrap px-3" data-toggle="" href="" role="button" aria-haspopup="true" aria-expanded="false">
                    <img class="user-avatar rounded-circle mr-2" src="../resources/images/login_icon.ico" height=35" alt="User Avatar">
                    <span class="d-none d-md-inline-block" style="color:#17c671";><button type="button" class="mb-2 btn btn-success mr-2"><strong>IHVN Dashboard</strong></button></span>
				   </a>
                  
                </li>
				 
					
			  
              <ul class="navbar-nav border-right flex-row ">&ensp;   &ensp; &ensp; &ensp; &ensp; &ensp; &ensp; &ensp;   &ensp; &ensp; &ensp; &ensp; &ensp; &ensp; &ensp;   &ensp; &ensp; &ensp; &ensp; &ensp; &ensp; &ensp;   &ensp; &ensp; &ensp; &ensp; &ensp; &ensp; &ensp;   &ensp; &ensp; &ensp; &ensp; &ensp; &ensp; &ensp;   &ensp; &ensp; &ensp; &ensp; &ensp; &ensp; &ensp;   &ensp; &ensp; &ensp; &ensp; &ensp; &ensp; &ensp;   &ensp; &ensp; &ensp; &ensp; &ensp; &ensp; &ensp;   &ensp; &ensp;&ensp;&ensp; 
				<li><a class="dropdown-item text-danger" href="compareind.php">
                     <i class="material-icons text-danger">&#xE879;</i> <b>Compare Indicators</b></a></li>
                <li><a class="dropdown-item text-danger" href="radet.php">
                     <i class="material-icons text-danger">&#xE879;</i> <b>Generate Radet</b></a></li>
											
				<li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle text-nowrap px-3" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <img class="user-avatar rounded-circle mr-2" src="../resources/images/logimg.png" height=30" alt="User Avatar">
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
              </div>		  
            </nav>
          </div>
          <!-- / .main-navbar -->
		  
			
          <div class="main-content-container container-fluid px-4">
            <!-- Page Header -->
            <div class="page-header row no-gutters py-4">
             
			  <div class="col-sm-12 col-md-12" align='left'>
                	 <form name="testform" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                            <div class="form-row">
                               
                             <div  class="form-group col-md-1">
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
							</div><div  class="form-group col-md-1">
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
							<div  class="form-group col-md-2">
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
							<div  class="form-group col-md-2">
										<select name="subcat" id="subcat" class="form-control is-valid" onchange="document.getElementById('text_content').value=this.options[this.selectedIndex].text">
                              	 
											<option value=''>Select Facility</option>
										</select>
										<input type="hidden" name="test_text" id="text_content" value="" />
								  
							</div>
							  <div class="form-group col-md-2">
                                 <button type="submit"  name="submit"class="mb-2 btn btn-sm btn-success mr-1">Generate</button>
								 
                              </div>
							  
                            </div>
                            
                          </form>
					
               
			
              </div>
            </div>
			
			<table class='datatable table table-hover table-bordered'>
        <thead style="font-size: 12px;">
            <th>Patient_Unique_Id</th>
			<th>Patient Hospital ID</th>
            <th>Sex</th>
            <th>Age at ART Start(Yrs)</th>
            <th>Age at ART Start(Months)</th>
            <th>ART Start Date</th>
            <th>Last Pickup Date</th>
            <th>Days of ARV Refill</th>
            <th>Initial Regimen Line</th>
            <th>Initial First line Regimen</th>
            <th>Current Regimen Line</th>
            <th>Current First Line Regimen</th>
            <th>Current First Line Regimen Date</th>
			<th>Current Second Line Regimen</th>
            <th>Current Second Line Regimen Date</th>
            <th>Pregnancy Status</th>
			<th>Current Viral Load</th>
            <th>Viral load Sample collection Date</th>
            <th>Viral Load Indication</th>
            <th>Current ART Status</th>
            <th>Current Age (Yrs)</th>
            <th>Current Age (Months)</th>
			<th>D.O.B</th>
        </thead>
        <tbody>
            <?php if ($_SERVER["REQUEST_METHOD"] == "POST") { while ($row = $rade->fetch(PDO::FETCH_ASSOC)){
			extract($row); ?>
                <?php?>
                    <tr style="font-size: 12px;">
                        <td><?php echo $patient_unique_id; ?></td>
						<td><?php echo $patient_hospital_id; ?></td>
						<td><?php echo $sex; ?></td>
						<td><?php echo $age_at_art_start_yrs; ?></td>
						<td><?php echo $age_at_art_start_months; ?></td>
						<td><?php echo $art_start_date; ?></td>
						<td><?php echo $last_pickup_date; ?></td>
						<td><?php echo $days_of_arv_refil; ?></td>
						<td><?php echo $initial_regimen_line; ?></td>
						<td><?php echo $initial_first_line_regimen; ?></td>
						<td><?php echo $current_regimen_line; ?></td>
						<td><?php echo $current_first_line_regimen; ?></td>
						<td><?php echo $current_first_line_regimen_date; ?></td>
						<td><?php echo $current_second_line_regimen; ?></td>
						<td><?php echo $current_second_line_regimen_date; ?></td>
						<td><?php echo $pregnancy_status; ?></td>
						<td><?php echo $current_viral_load; ?></td>
						<td><?php echo $viral_load_sample_collection_date; ?></td>
						<td><?php echo $viral_load_indication; ?></td>
						<td><?php echo $current_art_status; ?></td>
						<td><?php echo $current_age_yrs; ?></td>
						<td><?php echo $current_age_months; ?></td>
						<td><?php echo $date_of_birth; ?></td>
                    </tr>
                
            <?php } }?>
        </tbody>
    </table>


 </div>
  
  <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
  <!-- Responsive extension -->
  <script src="//cdn.datatables.net/responsive/2.1.0/js/responsive.bootstrap.min.js"></script>
  <!-- Buttons extension -->
  <script src="//cdn.datatables.net/buttons/1.2.1/js/dataTables.buttons.min.js"></script>
  <script src="//cdn.datatables.net/buttons/1.2.1/js/buttons.bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
  <script src="//cdn.datatables.net/buttons/1.2.1/js/buttons.html5.min.js"></script>
  
  <script src="script.js"></script>
			
			
            
            </div>
          </div>
		  
          <footer class="main-footer d-flex p-2 px-3 bg-white border-top">
            
                <a class="nav-link" href="#">Home</a>
              
			<div style="text-align: right;">
            <span class="copyright ml-auto my-auto mr-2" >Copyright © 2020
              <a href="" rel="nofollow">IHVN Dashboard</a></div>
            </span>
          </footer>
        </main>
      </div>
    
    
    
	
	
	
		
  </body>
</html>