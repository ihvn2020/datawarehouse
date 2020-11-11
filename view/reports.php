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
include_once '../model/dao/reports.php';
include_once '../model/dao/facts_states.php';
include_once '../model/dao/all_facilities.php';


$database = new Database();
$factdb = $database->getConnection();


// include classes

$fact_years = new PFacts_Years($factdb);
$repo = new Reports($factdb);
$fact_states = new Fact_States($factdb);
$facilities = new All_Facilities($factdb);

$year=date("Y")+1;
extract($fact_years->getQuarter((new DateTime())->modify('+3 Months')));
$quarter=$quart;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect value of input field
    $year = $_POST['year'];
	$quarter = $_POST['quarter'];
	$state = $_POST['state'];
    

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
                	 <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                            <div class="form-row">
                              <div class="form-group col-md-2">
                               <label>Dashboard Filters: </label>
							 <div class="valid-feedback">Note: You can currently filter by fiscal year or Quarter</div>
							  </div>
							   Report type: <div  class="form-group col-md-2">
                              	  <?php
											
								  			$stmts = $repo->read();												
				                           echo "<select name='report' class='form-control is-valid'>";
											echo "<option>Select Report</option>";
												while ($row_facts = $stmts->fetch(PDO::FETCH_ASSOC)){
														extract($row_facts);
														
														if($quarter==$code){
															echo "<option value='$id' selected>";
																	//$q=$code;
														}else{
															echo "<option value='$id'>";
																	//$quarter=$code;
														}
														echo "$name</option>";
													}
											echo "</select>";
								?> 
								  
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
								  
							</div>
							State: <div  class="form-group col-md-2">
                              	  <?php
											
								  			$stmts = $fact_states->read();												
				                           echo "<select name='state' class='form-control is-valid'>";
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
							  <div class="form-group col-md-2">
                                 <button type="submit"  name="submit"class="mb-2 btn btn-sm btn-success mr-1">Generate</button>
								 
                              </div>
							  
                            </div>
                            
                          </form>
					
               
			
              </div>
            </div>
			<?php
// display the table if the number of users retrieved was greater than zero
if($state>0){

    echo "<table class='table table-hover table-responsive table-bordered'>";

		// table headers
        echo "<tr>";
			echo "<th>Datim ID</th>";
			echo "<th>Patient ID</th>";
            echo "<th>Last Pickup Date</th>";
            echo "<th>Days of ARV refill</th>";
            echo "<th>Pregnancy Status</th>";
			echo "<th>Current Viral Load</th>";
            echo "<th>Viral load Sample collection Date</th>";
            echo "<th>Viral load result Date</th>";
            echo "<th>Viral Load Indicatin</th>";
			echo "<th>Current ART Status</th>";
        echo "</tr>";

		// loop through the user records
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);

			// display user details
            echo "<tr>";
				echo "<td>{$firstname}</td>";
                echo "<td>{$lastname}</td>";
                echo "<td>{$email}</td>";
				echo "<td>{$contact_number}</td>";
				echo "<td>{$access_level}</td>";
				echo "<td>{$firstname}</td>";
                echo "<td>{$lastname}</td>";
                echo "<td>{$email}</td>";
				echo "<td>{$contact_number}</td>";
				echo "<td>{$access_level}</td>";

                echo "<td>";

					// edit button
					echo "<a href='update_user.php?id={$id}' class='btn btn-info' style='margin:0 1em 0 0;'>";
						echo "<span class='glyphicon glyphicon-edit'></span> Edit";
					echo "</a>";

					// change password
					echo "<a href='change_password.php?id={$id}' class='btn btn-primary' style='margin:0 1em 0 0;'>";
						echo "<span class='glyphicon glyphicon-edit'></span> Change Password";
					echo "</a>";

					// delete button, user with id # 1 cannot be deleted because it is the first admin
					if($id!=1){
						echo "<a delete-id='{$id}' delete-file='delete_user.php' class='btn btn-danger delete-object margin-left-1em'>";
							echo "<span class='glyphicon glyphicon-remove'></span> Delete";
						echo "</a>";
					}
                echo "</td>";
		echo "</tr>";
        }

echo "</table>";}?>
			<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                        
                        
           
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
	
	
	
		
  </body>
</html>