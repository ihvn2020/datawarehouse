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
$statepage_id 	= $_SESSION['state_id'];

require '../config/database.php';  // Database connection
require_once('../protectpages.php');
include_once '../model/dao/facts_facility.php';
include_once '../model/dao/facts_quarters.php';
include_once '../model/dao/facts_years.php';
include_once '../model/dao/all_patients.php';
include_once '../model/dao/ltfu_patients.php';
include_once '../model/dao/txcurr_patients.php';
include_once '../model/dao/txnew_patients.php';
include_once '../model/dao/pbs_patients.php';
include_once '../model/dao/pvls_patients.php';
include_once '../model/dao/age_patients.php';
include_once '../model/dao/all_facilities.php';


$database = new Database();
$factdb = $database->getConnection();


// include classes

$fact_years = new PFacts_Years($factdb);
$fact_quarters = new Fact_Quarters($factdb);
$fact_facility = new Fact_Facility($factdb);
$totalPatients = new All_Patients($factdb);
$ltfu = new LTFU_Patients($factdb);
$txcurr = new TxCurr_Patients($factdb);
$txnew = new TxNew_Patients($factdb);
$ltfu = new LTFU_Patients($factdb);
$pbs = new PBS_Patients($factdb);
$pvls = new PVLS_Patients($factdb);
$age = new Age_Patients($factdb);
$facilities = new All_Facilities($factdb);

$year=date("Y")+1;
extract($fact_years->getQuarter((new DateTime())->modify('+3 Months')));
$quarter=$quart;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect value of input field
    $year = $_POST['year'];
	$quarter = $_POST['quarter'];
	$facilityid = $_POST['facility'];
    

}
	
		if(empty($facilityid)){
			$allfacility= COUNT($facilities->readState($statepage_id));
			//Get Patient count by Sex by State
			$male= $totalPatients->sumPatientsState('8',$year,$quarter,$statepage_id);
			$female= $totalPatients->sumPatientsState('9',$year,$quarter,$statepage_id);
			$allpatient = $male+$female;
				
			//Get Treatment Current by State
			$txcurrent= $txcurr->sumTxCurrState('2',$year,$quarter,$statepage_id);
			
			//Get Treatment New by State
			$txnewpat= $txnew->sumTxNewState('1',$year,$quarter,$statepage_id);
			
			//Get Treatment ML by State
			$ltfupatient= $ltfu->sumltfuState('5',$year,$quarter,$statepage_id);
			
			//Get PVLS per State
			$pvlsnumerator=$pvls->sumpvlsState('3',$year,$quarter,$statepage_id);
			$pvlsdenominator=$pvls->sumpvlsState('4',$year,$quarter,$statepage_id);
			$pvlspatient= round((($pvlsnumerator/$pvlsdenominator)*100),1).'%';
							
		}
		else{
			$allfacility= COUNT($facilities->readFacility($facilityid));
			//Get Patient count by Sex by State
			$male= $totalPatients->sumPatientsFacility('8',$year,$quarter,$facilityid);
			$female= $totalPatients->sumPatientsFacility('9',$year,$quarter,$facilityid);
			$allpatient = $male+$female;
				
			//Get Treatment Current by State
			$txcurrent= $txcurr->sumTxCurrFacility('2',$year,$quarter,$facilityid);
			
			//Get Treatment New by State
			$txnewpat= $txnew->sumTxNewFacility('1',$year,$quarter,$facilityid);
			
			//Get Treatment ML by State
			$ltfupatient= $ltfu->sumltfuFacility('5',$year,$quarter,$facilityid);
			
			//Get PVLS per State
			$pvlsnumerator=$pvls->sumpvlsFacility('3',$year,$quarter,$facilityid);
			$pvlsdenominator=$pvls->sumpvlsFacility('4',$year,$quarter,$facilityid);
			$pvlspatient= round((($pvlsnumerator/$pvlsdenominator)*100),1).'%';
		}
	







//$data=0;
if(array_key_exists('patientlist',$_POST)){
	if(empty($state)) {
	$a= explode(",",implode($totalPatients->getPatientsList('2',$_POST['year'],$_POST['quarter']),","));
	exportLists($a);}
	else { 
	$a= explode(",",implode($totalPatients->getPatientsListState('2',$_POST['year'],$_POST['quarter'],$_POST['state']),","));
	exportLists($a);
	}
	
}	
if(array_key_exists('activelist',$_POST)){
	if(empty($state)) {
	$a= explode(",",implode($txcurr->getPatientsList('2',$_POST['year'],$_POST['quarter']),","));
	exportLists($a);}
	else { 
	$a= explode(",",implode($txcurr->getPatientsListState('2',$_POST['year'],$_POST['quarter'],$_POST['state']),","));
	exportLists($a);
	}
	
}	
if(array_key_exists('ltfulist',$_POST)){
	if(empty($state)) {
	$a= explode(",",implode($ltfu->getPatientsDash('5',$_POST['year'],$_POST['quarter']),","));
	exportLists($a);
	}
	else { 
	$a= explode(",",implode($ltfu->getPatientsDash('5',$_POST['year'],$_POST['quarter'],$_POST['state']),","));
	exportLists($a);
	}
	
}	
if(array_key_exists('newlist',$_POST)){
	if(empty($state)) {
	$a= explode(",",implode($txnew->getPatientsDash('1',$_POST['year'],$_POST['quarter']),","));
	exportLists($a);
	}
	else { 
	$a= explode(",",implode($txnew->getPatientsDash('1',$_POST['year'],$_POST['quarter'],$_POST['state']),","));
	exportLists($a);
	}
	
}	
if(array_key_exists('facilitylist',$_POST)){
				if(empty($state)) {
				exportList($facilities->read());}
				else {
				exportList($facilities->read($state));}
}	
function exportLists($a){
	
	$timestamp = time();
    $filename = 'export.csv' ;
	header('Content-Type: application/csv; charset=UTF-8');
		header('Content-Disposition: attachment;filename="'.$filename.'";');
	// clean output buffer
		ob_end_clean();

	$out = fopen("php://output", 'w');
	fputcsv($out, array('PatientID'));
	foreach ($a as $data)
	{
		//fputcsv($out, array('PatientID'));
		//fputcsv($out, implode($data,","),"\t");
		echo $data. "\n";
	}
	fclose($out);
	exit;
}
		   
function exportList($productResult) {
        $timestamp = time();
        $filename = 'Export_excel_' . $timestamp . '.xls';
        
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        
         $flag = false;
        foreach ($productResult as $row) {
            if(!$flag) {
      // display field/column names as first row
					echo "<pre>".implode("\t", array_keys($row))."</pre>";
					$flag = true;
			}
					echo "<pre>".implode("\t", array_values($row))."</pre>";
		}
        exit();
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="" crossorigin="anonymous">
    <link rel="stylesheet" id="main-stylesheet" data-version="1.1.0" href="../styles/shards-dashboards.1.1.0.min.css">
    <link rel="stylesheet" href="../styles/extras.1.1.0.min.css">
	
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
		
			<style type="text/css">
#totalseriescontainer {
	min-width: 310px;
	max-width: 800px;
	height: 400px;
	margin: 0 auto
}
		</style>
		
				<style type="text/css">
#containerave {
    height: 400px; 
}

.highcharts-figure, .highcharts-data-table table {
    min-width: 310px; 
    max-width: 500px;
    margin: 1em auto;
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
	
			<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>			
			<script src="../code/highcharts.js"></script>
			<script src="../code/modules/exporting.js"></script>
			<script src="../code/modules/export-data.js"></script>
			<script src="../code/modules/data.js"></script>
			<script src="../code/modules/drilldown.js"></script>
			<script src="../code/modules/series-label.js"></script>
			<script src="../code/highcharts-more.js"></script>
			
			
			<script src="../code/highcharts-3d.js"></script>
			<script src="../code/modules/accessibility.js"></script>

<script>
$(document).ready( function () {
   
   
   jQuery('#loading').fadeOut(1000);
  $("#cont").css("display","block");
  
});
</script>

	
		
  </head>
  <body  class="h-100">
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
                  <a class="nav-link text-nowrap px-3" data-toggle="" href="" role="button" aria-haspopup="true" aria-expanded="false">
                    <img class="user-avatar rounded-circle mr-2" src="../resources/images/login_icon.ico" alt="User Avatar">
                    <span class="d-none d-md-inline-block" style="color:#17c671";><button type="button" class="mb-2 btn btn-success mr-2"><strong>IHVN Dashboard</strong></button></span>
				   </a>
                  
                </li>
				 
					
			         
              <ul class="navbar-nav border-right flex-row ">
			
                
											
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
                	 <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                            <div class="form-row">
                              <div class="form-group col-md-2">
                               <label>Dashboard Filters: </label>
							 <div class="valid-feedback">Note: You can currently filter by fiscal year or Quarter</div>
							  </div>
							   
                            FY: <div  class="form-group col-md-2">
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
								  
							</div>Quarter: <div  class="form-group col-md-2">
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
											
								  			$stmts = $fact_facility->readf($statepage_id);												
				                           echo "<select name='facility' class='form-control is-valid'>";
											echo "<option value=''>Select Facility</option>";
												while ($row_facts = $stmts->fetch(PDO::FETCH_ASSOC)){
														extract($row_facts);
														if($datim_id==$facilityid){
															echo "<option value='$datim_id'   selected>";
																	//$q=$code;
														}else{
															echo "<option value='$datim_id'>";
																	//$quarter=$code;
														}
														echo "$facility_name</option>";
													}
											echo "</select>";
								?> 
								  
							</div>
							  <div class="form-group col-md-2">
                                 <button type="submit"  name="submit"class="mb-2 btn btn-sm btn-success mr-1">Search</button>
								 
                              </div>
							  
                            </div>
                            
                          </form>
					
               
			
              </div>
            </div>
			
                        
                        
            <!-- End Page Header -->
           <!-- Small Stats Blocks -->
            <div class="row">
			
			<div class="col-lg col-md-6 col-sm-6 mb-4">
			  
                <div class="stats-small stats-small--1 card card-small">
                  <div class="card-body p-0 d-flex">
                    <div class="d-flex flex-column m-auto">
                      <div class="stats-small__data text-center"><span class="d-none d-md-inline-block" style="color:#17c671";><form method="post">
    <input type="submit" name="facilitylist" id="facilitylist" value="Download List" class="mb-2 btn btn-success mr-2"/><br/><input type="hidden" value="<?php echo $quarter;?>" name="quarter" /><input type="hidden" value="<?php echo $state;?>" name="state" /><input type="hidden" value="<?php echo $year;?>" name="year" />
</form></span>
                        <span class="stats-small__label text-uppercase"style="color:black;font-weight:bold">No of Facilities</span>
						
                       <div id="rec"><h6 class='stats-small__value count my-3'>
					   <?php 
					   
					   
							if($allfacility !=NULL){echo $allfacility;} ELSE echo '0';
					   
					   
					   ?>
					   </h6></div>
						
                      </div>
                      <!--<div class="stats-small__data">
                        <span class="stats-small__percentage stats-small__percentage--increase"></span>
                      </div>-->
                    </div>
                    <!--<canvas height="120" class="blog-overview-stats-small-1"></canvas>-->
                  </div>
                </div>
              </div>
              <div class="col-lg col-md-6 col-sm-6 mb-4">
			  
                <div class="stats-small stats-small--1 card card-small">
                  <div class="card-body p-0 d-flex">
                    <div class="d-flex flex-column m-auto"><span class="d-none d-md-inline-block" style="color:#17c671";><form method="post">
    <input type="submit" name="patientlist" id="patientlist" value="Download List" class="mb-2 btn btn-success mr-2"/><br/><input type="hidden" value="<?php echo $quarter;?>" name="quarter" /><input type="hidden" value="<?php echo $state;?>" name="state" /><input type="hidden" value="<?php echo $year;?>" name="year" />
</form></span>
					<a href="#total" onClick="return false;" >
                      <div class="stats-small__data text-center" id="one">
                        <span class="stats-small__label text-uppercase"style="color:black;font-weight:bold">Total Patients</span>
						
                       <div id="rec"><h6 class='stats-small__value count my-3'><?php if($allpatient !=NULL){echo $allpatient;} ELSE echo '0';?></h6></div>
						
                      </div>
					  </a>
                      <!--<div class="stats-small__data">
                        <span class="stats-small__percentage stats-small__percentage--increase"></span>
                      </div>-->
                    </div>
                    <!--<canvas height="120" class="blog-overview-stats-small-1"></canvas>-->
                  </div>
                </div>
              </div>
			  <div class="col-lg col-md-6 col-sm-6 mb-4">
                <div class="stats-small stats-small--1 card card-small">
                  <div class="card-body p-0 d-flex">
                    <div class="d-flex flex-column m-auto"><span class="d-none d-md-inline-block" style="color:#17c671";><form method="post">
    <input type="submit" name="activelist" id="activelist" value="Download List" class="mb-2 btn btn-success mr-2"/><br/><input type="hidden" value="<?php echo $quarter;?>" name="quarter" /><input type="hidden" value="<?php echo $state;?>" name="state" /><input type="hidden" value="<?php echo $year;?>" name="year" />
</form></span>
					<a href="#txcurr" onClick="return false;" >
                      <div class="stats-small__data text-center" id="two">
                        <span class="stats-small__label text-uppercase"style="color:black;font-weight:bold">Tx Curr</span>
                        <div id="rej"><h6 class='stats-small__value count my-3'><?php if($txcurrent !=NULL){echo $txcurrent;} ELSE echo '0';//$txcurr; ?></h6></div>
                      </div>
					 </a>
                      
                    </div>
                    <!--<canvas height="120" class="blog-overview-stats-small-6"></canvas>-->
                  </div>
                </div>
              </div>   
              <div class="col-lg col-md-6 col-sm-6 mb-4">
                <div class="stats-small stats-small--1 card card-small">
                  <div class="card-body p-0 d-flex">
                    <div class="d-flex flex-column m-auto"><span class="d-none d-md-inline-block" style="color:#17c671";><form method="post">
    <input type="submit" name="newlist" id="newlist" value="Download List" class="mb-2 btn btn-success mr-2"/><br/><input type="hidden" value="<?php echo $quarter;?>" name="quarter" /><input type="hidden" value="<?php echo $state;?>" name="state" /><input type="hidden" value="<?php echo $year;?>" name="year" />
</form></span>
					<a href="#newpatients" onClick="return false;" >
                      <div class="stats-small__data text-center" id="three">
                        <span class="stats-small__label text-uppercase"style="color:black;font-weight:bold">Tx New</span>
                          <div id="rej"><h6 class='stats-small__value count my-3'><?php if($txnewpat !=NULL){echo $txnewpat;} ELSE echo '0';?></h6></div>
                      </div>
					  </a>
                      
                    </div>
                    <!--<canvas height="120" class="blog-overview-stats-small-2"></canvas>-->
                  </div>
                </div>
              </div>
			 <div class="col-lg col-md-4 col-sm-6 mb-4">
                <div class="stats-small stats-small--1 card card-small">
                  <div class="card-body p-0 d-flex">
                    <div class="d-flex flex-column m-auto"><span class="d-none d-md-inline-block" style="color:#17c671";><form method="post">
    <input type="submit" name="ltfulist" id="ltfulist" value="Download List" class="mb-2 btn btn-success mr-2"/><br/><input type="hidden" value="<?php echo $quarter;?>" name="quarter" /><input type="hidden" value="<?php echo $state;?>" name="state" /><input type="hidden" value="<?php echo $year;?>" name="year" />
</form></span>
					<a href="#dispatched" onClick="return false;" >
                      <div class="stats-small__data text-center" id="five">
                        <span class="stats-small__label text-uppercase"style="color:black;font-weight:bold">Tx ML</span>
                       <div id="disp"><h6 class='stats-small__value count my-3'><?php if($ltfupatient !=NULL){echo $ltfupatient;} ELSE echo '0';?></h6></div>
                      </div>
					  </a>
                      </div>
                    
                    <!--<canvas height="120" class="blog-overview-stats-small-4"></canvas>-->
                  </div>
                </div>
              </div>
              <div class="col-lg col-md-4 col-sm-6 mb-4">
                <div class="stats-small stats-small--1 card card-small">
                  <div class="card-body p-0 d-flex">
                    <div class="d-flex flex-column m-auto">
					<a href="#suppressed" onClick="return false;" >
                      <div class="stats-small__data text-center" id="four">
                        <span class="stats-small__label text-uppercase"style="color:black;font-weight:bold">Tx PVLS</span>
                       <div id="sup"><h6 class='stats-small__value count my-3'><?php if($pvlspatient !=NULL){echo $pvlspatient;} ELSE echo '0';?></h6></div>
                      </div>
					  </a>
                      
                    </div>
                    <!--<canvas height="120" class="blog-overview-stats-small-3"></canvas>-->
                  </div>
                </div>
              </div>
			  
			  <div class="col-lg col-md-4 col-sm-6 mb-4">
                <div class="stats-small stats-small--1 card card-small">
                  <div class="card-body p-0 d-flex">
                    <div class="d-flex flex-column m-auto">
					<a href="#suppressed" onClick="return false;" >
                      <div class="stats-small__data text-center" id="seven">
                        <span class="stats-small__label text-uppercase"style="color:black;font-weight:bold">Tx RTT</span>
                       <div id="sup"><h6 class='stats-small__value count my-3'><?php echo '0'; ?></h6></div>
                      </div>
					  </a>
                      
                    </div>
                    <!--<canvas height="120" class="blog-overview-stats-small-3"></canvas>-->
                  </div>
                </div>
              </div>
              
			  
			  <div class="col-lg col-md-4 col-sm-6 mb-4">
                <div class="stats-small stats-small--1 card card-small">
                  <div class="card-body p-0 d-flex">
                    <div class="d-flex flex-column m-auto">
					<a href="#tat1" onClick="return false;" >
                      <div class="stats-small__data text-center" id="six">
                        <span class="stats-small__label text-uppercase"style="color:black;font-weight:bold">PBS</span>
                       <div id="disp"><h6 class='stats-small__value count my-3'><?php $stmt= $pbs->sumpbs('32',$year,$quarter);if($stmt !=NULL){echo $stmt;} ELSE echo '0';?></h6></div>
					   </div>
					   </div>
					  </a>
                     
                    </div>
                    <!--<canvas height="120" class="blog-overview-stats-small-4"></canvas>-->
                  </div>
                </div>
              </div>
			  
            
            <!-- End Small Stats Blocks -->
            <div class="row">
			
			<!-- Samples txcurr -->
              <div class="col-lg-6 col-md-12 col-sm-12 mb-4" id="total" style="display:block">
                <div class="card card-small">
                  <div class="card-header border-bottom">
                    <h6 class="m-0">Total Patients By Sex for Q<?php echo $quarter;?>-FY<?php echo $year;?></h6>
                  </div>
                  <div id="rejcontainer" style="min-width: 95%;max-width: 95%; height: 270px; margin: 0 auto"></div>
				  <div class="col-12 col-sm-6 d-flex mb-2 mb-sm-0">
                       <br>
                      </div>
                </div>
              </div>
			  
			  <div class="col-lg-6 col-md-12 col-sm-12 mb-4" id="rejreasonsperyr" style="display:block">
                <div class="card card-small">
                  <div class="card-header border-bottom">
                    <h6 class="m-0">Total Patients By Age for Q<?php echo $quarter;?>-FY<?php echo $year;?></h6>
                  </div>
                  <div id="rejreasonsperyear" style="min-width: 95%;max-width: 95%; height: 270px; margin: 0 auto"></div>
				  <div class="col-12 col-sm-6 d-flex mb-2 mb-sm-0">
                       <br>
                      </div>
                </div>
              </div>
              <!-- Samples txcurr -->
			
			<div class="col-lg-12 col-md-12 col-sm-12 mb-4" id="txcurr" style="display:none" >
			  <!-- Samples total -->
                <div class="card card-small" >
                  <div class="card-header border-bottom">
                    <h6 class="m-0">TxCURR by State for Q<?php echo $quarter;?>-FY<?php echo $year;?></h6>
					</div>
                    
                    <div id="container" style="min-width: 95%;max-width: 95%; height: 270px; margin: 0 auto">
					</div>
					<div class="col-12 col-sm-6 d-flex mb-2 mb-sm-0">
                       <br>
                      </div>
                  </div>
                </div>
				<!-- Samples total -->
            
			  
			  <div class="col-lg-12 col-md-12 col-sm-12 mb-4" id="receivedser" style="display:none" >
			  <!-- Samples total -->
                <div class="card card-small" >
                  <div class="card-header border-bottom">
                    <h6 class="m-0">Samples Received Per Year  </h6>
					</div>
                                      
                    <div id="receivedseriescontainer" style="min-width: 95%;max-width: 95%; height: 270px; margin: 0 auto">
					</div>
					<div class="col-12 col-sm-6 d-flex mb-2 mb-sm-0">
                       <br>
                      </div>
                </div>
				<!-- Samples Received -->
              </div>
              
			  
			  
			  
			  
			  
			  <div class="col-lg-12 col-md-12 col-sm-12 mb-4" id="tabb" style="display:none" >
                <div class="card card-small">
				
                  <div class="card-header border-bottom">
                    <h6 class="m-0">TxNew by State for Q<?php echo $quarter;?>-FY<?php echo $year;?></h6>
                  </div>
                  
                    <div id="tabb" style="min-width: 95%;max-width: 95%; height: 270px; margin: 0 auto">
					</div>
					<div class="col-12 col-sm-6 d-flex mb-2 mb-sm-0">
                       <br>
                      </div>
                 
                  
                </div>
              </div>
			 
			  
              <!-- Turn Around Time -->
			  
			   
			  
             
              <!-- Top Referrals Component -->
              
              <!-- End Top Referrals Component -->
			   
            </div>
              <!-- End Top Referrals Component -->
			   
            </div>
          </div>
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
        </main>
      </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    <script src="https://unpkg.com/shards-ui@latest/dist/js/shards.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sharrre/2.0.1/jquery.sharrre.min.js"></script>
    <script src="../scripts/extras.1.1.0.min.js"></script>
    <script src="../scripts/shards-dashboards.1.1.0.min.js"></script>
    <script src="../scripts/app/app-blog-overview.1.1.0.js"></script>
	
	
			
	<script type="text/javascript">
Highcharts.chart('newpatients', {
	chart: {
        type: 'column'
    },
    title: {
        text: ''
    },

    subtitle: {
        text: ''
    },

    yAxis: {
        title: {
            text: 'No of Patients'
        }
    },
	xAxis: {
        categories: ['FCT','KATSINA','NASARAWA','RIVERS']
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
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
        data: [<?php $stmt= $age->sumage('10',$year,$quarter); if($stmt !=NULL) echo $stmt; else echo '0';?>, <?php $stmt= $age->sumage('11',$year,$quarter); if($stmt !=NULL) echo $stmt; else echo '0';?>, <?php $stmt= $age->sumage('12',$year,$quarter); if($stmt !=NULL) echo $stmt; else echo '0';?>, <?php $stmt= $age->sumage('13',$year,$quarter); if($stmt !=NULL) echo $stmt; else echo '0';?>, ]
    }],


    
});
		</script>	
	<!-- Sample Recieved Charts -->
	<script type="text/javascript">

	Highcharts.chart('rejcontainer', {
    chart: {
        type: 'column'
    },
    title: {
        text: ''
    },
    xAxis: {
        categories: ['Male','Female']
    },
    yAxis: {
        min: 0,
        title: {
            text: 'No of Patients by Sex'
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
        data: [<?php if(empty($facilityid)){echo $totalPatients->sumPatientsState('8',$year,$quarter,$statepage_id);}else{echo $totalPatients->sumPatientsState('8',$year,$quarter,$statepage_id);}?>,<?php if(empty($facilityid)){echo $totalPatients->sumPatientsState('9',$year,$quarter,$statepage_id);}else{echo $totalPatients->sumPatientsState('9',$year,$quarter,$statepage_id);}?>]
    }]
});
		</script>
		
<script type="text/javascript">
Highcharts.chart('rejreasonsperyear', {
	chart: {
        type: 'column'
    },
    title: {
        text: ''
    },

    subtitle: {
        text: ''
    },

    yAxis: {
        title: {
            text: 'No of Patients'
        }
    },
	xAxis: {
        categories: ['<1','1-4','5-9','10-14','15-19','20-24','25-29','30-34','35-39','40-44','45-49','50&above']
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
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
        data: [<?php $stmt= $age->sumage('10',$year,$quarter); if($stmt !=NULL) echo $stmt; else echo '0';?>, <?php $stmt= $age->sumage('11',$year,$quarter); if($stmt !=NULL) echo $stmt; else echo '0';?>, <?php $stmt= $age->sumage('12',$year,$quarter); if($stmt !=NULL) echo $stmt; else echo '0';?>, <?php $stmt= $age->sumage('13',$year,$quarter); if($stmt !=NULL) echo $stmt; else echo '0';?>, <?php $stmt= $age->sumage('14',$year,$quarter); if($stmt !=NULL) echo $stmt; else echo '0';?>,<?php $stmt= $age->sumage('15',$year,$quarter); if($stmt !=NULL) echo $stmt; else echo '0';?>,<?php $stmt= $age->sumage('16',$year,$quarter); if($stmt !=NULL) echo $stmt; else echo '0';?>,<?php $stmt= $age->sumage('17',$year,$quarter); if($stmt !=NULL) echo $stmt; else echo '0';?>,<?php $stmt= $age->sumage('18',$year,$quarter); if($stmt !=NULL) echo $stmt; else echo '0';?>,<?php $stmt= $age->sumage('19',$year,$quarter); if($stmt !=NULL) echo $stmt; else echo '0';?>,<?php $stmt= $age->sumage('20',$year,$quarter); if($stmt !=NULL) echo $stmt; else echo '0';?>,<?php $stmt= $age->sumage('21',$year,$quarter); if($stmt !=NULL) echo $stmt; else echo '0';?>]
    }],

    
});
		</script>
		<script type="text/javascript">
Highcharts.chart('container', {
	chart: {
        type: 'column'
    },
    title: {
        text: ''
    },

    subtitle: {
        text: ''
    },

    yAxis: {
        title: {
            text: 'No of Patients'
        }
    },
	xAxis: {
        categories: ['FCT','KATSINA','NASARAWA','RIVERS']
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
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
        data: [<?php $stmt= $txcurr->sumTxCurrState('2',$year,$quarter,'15'); if($stmt !=NULL) echo $stmt; else echo '0';?>, <?php $stmt= $txcurr->sumTxCurrState('2',$year,$quarter,'21'); if($stmt !=NULL) echo $stmt; else echo '0';?>, <?php $stmt= $txcurr->sumTxCurrState('2',$year,$quarter,'26'); if($stmt !=NULL) echo $stmt; else echo '0';?>, <?php $stmt= $txcurr->sumTxCurrState('2',$year,$quarter,'33'); if($stmt !=NULL) echo $stmt; else echo '0';?>, ]
    }],


    
});
		</script>
		
		<script type="text/javascript">
Highcharts.chart('tabb', {
	chart: {
        type: 'column'
    },
    title: {
        text: ''
    },

    subtitle: {
        text: ''
    },

    yAxis: {
        title: {
            text: 'No of Patients'
        }
    },
	xAxis: {
        categories: ['FCT','KATSINA','NASARAWA','RIVERS']
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
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
        data: [<?php $stmt= $age->sumage('10',$year,$quarter); if($stmt !=NULL) echo $stmt; else echo '0';?>, <?php $stmt= $age->sumage('11',$year,$quarter); if($stmt !=NULL) echo $stmt; else echo '0';?>, <?php $stmt= $age->sumage('12',$year,$quarter); if($stmt !=NULL) echo $stmt; else echo '0';?>, <?php $stmt= $age->sumage('13',$year,$quarter); if($stmt !=NULL) echo $stmt; else echo '0';?>, ]
    }],


    
});
		</script>
<!-- Sample txcurr Charts -->
		
		
		
		
	<!-- Samples Tested -->
	
		
		<!-- Turn Around Time -->
		
		<script type="text/javascript"> 
        document.getElementById("one").onclick = function() {   
            document.getElementById("total").style.display = "block";
			document.getElementById("receivedser").style.display = "none";
			document.getElementById("tabb").style.display = "none"; 
			document.getElementById("alertt").style.display = "none"; 
			document.getElementById("txcurr").style.display = "none";
			document.getElementById("rejreasonsperyr").style.display = "block";
			document.getElementById("tested").style.display = "none";
			document.getElementById("suppressed").style.display = "none";
			document.getElementById("dispatched").style.display = "none";
		} 
		
		document.getElementById("two").onclick = function() { 
  
            document.getElementById("total").style.display = "none";
			document.getElementById("receivedser").style.display = "none";
			document.getElementById("tabb").style.display = "none"; 
			document.getElementById("alertt").style.display = "none"; 
			document.getElementById("txcurr").style.display = "block";
			document.getElementById("rejreasonsperyr").style.display = "none";
			document.getElementById("tested").style.display = "none";
			document.getElementById("suppressed").style.display = "none";
			document.getElementById("dispatched").style.display = "none";
  
        } 
  
        document.getElementById("three").onclick = function() { 
  
            document.getElementById("total").style.display = "none";
			document.getElementById("receivedser").style.display = "none";
			document.getElementById("tabb").style.display = "block"; 
			document.getElementById("alertt").style.display = "none"; 
			 document.getElementById("txcurr").style.display = "none";
			 document.getElementById("rejreasonsperyr").style.display = "none";
			 document.getElementById("tested").style.display = "none";
			document.getElementById("suppressed").style.display = "none";
		} 
		
		</script>
		
  </body>
</html>