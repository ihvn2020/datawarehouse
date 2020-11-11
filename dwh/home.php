<!DOCTYPE html>
<?php
// core configuration
include_once "../config/core.php";
include_once '../config/database.php';
include_once '../objects/facilities.php';
include_once "../login_checker.php";
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

$facilities = new Facilities($db);
$group_id = $_SESSION['group_id'];

//$facilities->id=$group_id ;

//$facilities->readNameById();
//$facility_name=$facilities->getFacilityNameById($group_id);


// include login checker
$require_login=true;


?>
<html lang="en">

<head>
    <title>IHVN Data Warehouse</title>
   
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Phoenixcoded">
    <meta name="keywords" content="flat ui, admin , Flat ui, Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
    <meta name="author" content="Phoenixcoded">
    <!-- Favicon icon -->
    <link rel="icon" href="assets/images/login_icon.ico" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="bower_components/bootstrap/css/bootstrap.min.css">
    <!-- Horizontal-Timeline css -->
    <link rel="stylesheet" type="text/css" href="assets/pages/dashboard/horizontal-timeline/css/style.css">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <!--color css-->

</head>

<body>
    <!-- Pre-loader start -->
    <div class="theme-loader">
        <div class="ball-scale">
            <div></div>
        </div>
    </div>
    <!-- Pre-loader end -->

    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">

            <nav class="navbar header-navbar pcoded-header" header-theme="theme4">
                <div class="navbar-wrapper">
                    <div class="navbar-logo">
                        <a class="mobile-menu" id="mobile-collapse" href="">
                            <i class="ti-menu"></i>
                        </a>
                        
                        <a href="home.php">
							<img src="assets/images/login-icon.png" alt="User-Profile-Image" width="60px" height="50px">
                         <b>Data Warehouse</b>
                        </a>
                        <a class="mobile-options">
                            <i class="ti-more"></i>
                        </a>
                    </div>
                    <div class="navbar-container container-fluid">
                        <div>
                            <ul class="nav-left">
                                <li>
                                    <div class="sidebar_toggle"><a href="home.php">Home</a></div>
                                </li>                               
                                <li>
                                    <a href="#!" onclick="javascript:toggleFullScreen()">
                                        <i class="ti-fullscreen"></i>
                                    </a>
                                </li> 
								
															
                            </ul>
                            <ul class="nav-right">
							<li class="user-profile header-notification">								
                                    <a href="new-upload.php">									
                                      Upload XML
                                    </a>
                             </li>
							 <li class="user-profile header-notification">								
                                    <a href="view-uploads.php">									
                                     Previous Uploads
                                    </a>
                             </li>
							<li class="user-profile header-notification">								
                                    <a href="reports.php">									
                                      Reports
                                    </a>
                             </li> 							
							
                                <li class="user-profile header-notification">								
                                    <a href="#!">									
                                        <span><?php echo "Welcome ".$_SESSION['unames'] ?></span>
                                        <i class="ti-angle-down"></i>
                                    </a>
                                    <ul class="show-notification profile-notification">
                                        
                                        <li>
                                            <a href="logout.php">
                                                <i class="ti-layout-sidebar-left"></i> Logout
                                            </a>
                                        </li>
                                    </ul>
                                </li>
							
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
			
            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                      <nav class="pcoded-navbar" pcoded-header-position="relative">
                        <div class="sidebar_toggle"><a href="home.php"><i class="icon-close icons"></i></a></div>
                        <div class="pcoded-inner-navbar main-menu">
                            <div class="">
                            </div>
							
                           
                            
                            
                        </div>
                    </nav>
                    <div class="pcoded-content">
                        <div class="pcoded-inner-content">

                            <div class="main-body">
                                <div class="page-wrapper"> 
								<div class="page-header">
										<div class="page-header-title">  
												<h5> Data Uploads </h5>
										</div>
										<div class="page-header-breadcrumb">
											<ul class="breadcrumb-title">
												
												<li class="breadcrumb-item">
													<a href="home.php">
														<i class="icofont icofont-hospital"></i>
														 <b><?php //echo $facility_name ?></b>
													</a>
												</li>
												
												
											</ul>
										</div>
									</div>								
                                    <div class="page-body">
                                          <div class="row">
                                            <div class="col-md-12">
                                                <!-- round card start -->                                            
                                                    
                                                    <div class="card-block">
                                                        <div class="row users-card">
                                                           
                                                            
															
															<div class="col-lg-6 col-xl-2 col-md-12">
                                                                <div class="card rounded-card user-card">
																<a href="new-upload.php" >
                                                                    <div class="card-block">
                                                                        <div class="img-hover">
                                                                            <img class="img-fluid img-circle" src="assets/images/upload.png" alt="round-img">
                                                                            <div class="img-overlay">
                                                            
                                                                            </div>
                                                                        </div>
                                                                        <div class="user-content">
                                                                            <h4 class="" style="color:#2E8B57">Upload Zipped XML</h4>
                                                                         
                                                                        </div>
                                                                       
                                                                    </div></a>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-lg-6 col-xl-2 col-md-12">
                                                                <div class="card rounded-card user-card">
																<a href="view-uploads.php">
                                                                    <div class="card-block">
                                                                        <div class="img-hover">
                                                                            <img class="img-fluid img-circle" src="assets/images/user-card/dispatch.jpg" alt="round-img">
                                                                            <div class="img-overlay">
                                                                        
                                                                            </div>
                                                                        </div>
                                                                        <div class="user-content">
                                                                            <h4 class="" style="color:#2E8B57">View Previous Uploads</h4>
                                                                        
                                                                        </div>
                                                                    </div></a>
                                                                </div>
                                                            </div>
															
															
															
															
                                                              <div class="col-lg-4 col-xl-2 col-md-12">
                                                                <div class="card rounded-card user-card">
																<a href="reports.php">
                                                                    <div class="card-block">
                                                                        <div class="img-hover">
                                                                            <img class="img-fluid img-circle" src="assets/images/user-card/register.jpg" alt="round-img">
                                                                            <div class="img-overlay">
                                                            
                                                                            </div>
                                                                        </div>
                                                                        <div class="user-content">
                                                                            <h4 class="" style="color:#2E8B57">Reports <br><br></h4>
                                                                        
                                                                        </div>
                                                                    </div>
																	</a>
                                                                </div>
                                                            </div>
													                                                              
                                                                </tbody>                                                                
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                        </div>
                                                    </div>
                                               
                                                <!-- Round card end -->
                                            </div>
											<div class="col-md-3">
                                     
                    </div>
					
					
                                        </div>
                                    </div>
                                </div>
                            </div>
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Warning Section Ends -->
    <!-- Required Jquery -->
    <script type="text/javascript" src="bower_components/jquery/js/jquery.min.js"></script>
    <script type="text/javascript" src="bower_components/jquery-ui/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="bower_components/popper.js/js/popper.min.js"></script>
    <script type="text/javascript" src="bower_components/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/pages/dashboard/project-dashboard.js"></script>
    <script type="text/javascript" src="assets/js/script.js"></script>
	 <script type="text/javascript" src="assets/pages/advance-elements/swithces.js"></script>
    <script src="assets/js/pcoded.min.js"></script>

</body>

</html>
