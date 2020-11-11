<!DOCTYPE html>
<?php 
// include database and object files
include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/facilities.php';
include_once '../objects/uploads.php';
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

$facilities = new Facilities($db);

$uploads = new Uploads($db);


// set page title
$page_title="View Previous Uploads";
$group_id = $_SESSION['group_id'];


?>
<html lang="en">

<head>
    <title>IHVN Data Warehouse</title>
    <!-- HTML5 Shim and Respond.js IE9 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
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
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="assets/icon/themify-icons/themify-icons.css">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="assets/icon/icofont/css/icofont.css">
    <!-- flag icon framework css -->
    <link rel="stylesheet" type="text/css" href="assets/pages/flag-icon/flag-icon.min.css">
    <!-- Menu-Search css -->
    <link rel="stylesheet" type="text/css" href="assets/pages/menu-search/css/component.css">
    <!-- Horizontal-Timeline css -->
    <link rel="stylesheet" type="text/css" href="assets/pages/dashboard/horizontal-timeline/css/style.css">
	 <link rel="stylesheet" type="text/css" href="bower_components/switchery/css/switchery.min.css">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <!--color css-->

    <link rel="stylesheet" type="text/css" href="assets/css/linearicons.css" >
<link rel="stylesheet" type="text/css" href="assets/css/simple-line-icons.css">
<link rel="stylesheet" type="text/css" href="assets/css/ionicons.css">
<link rel="stylesheet" type="text/css" href="assets/css/jquery.mCustomScrollbar.css">
<script type = "text/javascript">
	 
         <!--
            function Warn() {
				
               
               document.write (dropdown);
            }
         //-->
      </script> 
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
                        <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
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
												<h5> View Uploaded XML Files</h5>
												<span>All previously uploaded Files can be viewed here</span>
										</div>
										<div class="page-header-breadcrumb">
											<ul class="breadcrumb-title">
												<li class="breadcrumb-item">
													<a href="home.php">
														<i class="icofont icofont-home"></i>
														<b><?php //echo $facility_name ?></b>
													</a>
												</li>
												<li class="breadcrumb-item"><a href="#!">Data Upload</a>
												</li>
												
											</ul>
										</div>
										
						    </div>						
            <!-- Page header end -->
            <!-- Page body start -->
            <div class="page-body">
															
										<?php 
										  $stmt=$uploads->view_uploads($_SESSION['uid']);
										 $num = $stmt->rowCount();
										  if($num>0){
										?>
							<div class="row">
								<!-- Left column start -->
								<div class="col-lg-12 col-xl-12">
									<!-- Flying Word card start -->
									<div class="card">                         
									   <div class="card-header">
                                                                                                           
                                                    </div>
                                                    <div class="card-block">
                                                        <div class="dt-responsive table-responsive">
                                                            <table id="simpletable" class="table table-striped table-bordered nowrap">
                                                                <thead>
                                                                    <tr>
																	
																	    <th>File Name</th>
																		<th>Date Uploaded</th>
                                                                        <th>No of Files</th>
                                                                        <th>Uploaded by</th>
                                                                        <th>Status</th>
                                                                                                             
                                                                    </tr>
                                                                </thead>
                                                                <tbody>                                                           
                                                                   
												<?php    
													 
													while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
													extract($row);
													
													echo "<tr>";
													
														echo "<td>{$filename}</td>";
													echo "<td>{$date_uploaded}</td>";
														echo "<td>{$filecount}</td>";
														echo "<td>{$uploaded_by}</td>";
														if($status==0){
														echo "<td>Uploaded</td>";
														}
														else {
														echo "<td>Processed</td>";
														}
														//echo "<td>{$status}</td>";
														
													echo "</tr>";
													
												} ?> 
																
														
                                                                                                                                  
                                                                </tbody>                                                              
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                    </div>
                    <!-- Right column end -->
                </div>
										  <?php } ?>
            </div>
            <!-- Page body end -->
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
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
    <!-- modernizr js -->
    <script type="text/javascript" src="bower_components/modernizr/js/modernizr.js"></script>
    <script type="text/javascript" src="bower_components/modernizr/js/css-scrollbars.js"></script>
    <!-- classie js -->
    <script type="text/javascript" src="bower_components/classie/js/classie.js"></script>
	 <!-- data-table js -->
    <script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="assets/pages/data-table/js/jszip.min.js"></script>
    <script src="assets/pages/data-table/js/pdfmake.min.js"></script>
    <script src="assets/pages/data-table/js/vfs_fonts.js"></script>
    <script src="bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    <!-- Morris Chart js -->
    <script src="bower_components/raphael/js/raphael.min.js"></script>
    <script src="bower_components/morris.js/js/morris.js"></script>
    <!-- Todo js -->
	<!-- Switch component js -->
    <script type="text/javascript" src="bower_components/switchery/js/switchery.min.js"></script>
    <script type="text/javascript" src="assets/pages/todo/todo.js"></script>
    <!-- Horizontal-Timeline js -->
    <script type="text/javascript" src="assets/pages/dashboard/horizontal-timeline/js/main.js"></script>
    <!-- i18next.min.js -->
    <script type="text/javascript" src="bower_components/i18next/js/i18next.min.js"></script>
    <script type="text/javascript" src="bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
    <script type="text/javascript" src="bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js"></script>
    <script type="text/javascript" src="bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>
    <!-- Custom js -->
    <script type="text/javascript" src="assets/pages/dashboard/project-dashboard.js"></script>
    <script type="text/javascript" src="assets/js/script.js"></script>
	 <script type="text/javascript" src="assets/pages/advance-elements/swithces.js"></script>
    <script src="assets/js/pcoded.min.js"></script>
<script src="assets/js/demo-12.js"></script>
<script src="assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="assets/js/jquery.mousewheel.min.js"></script>
 <!-- Custom js -->
    <script src="assets/pages/data-table/js/data-table-custom.js"></script>
	
	<SCRIPT language="javascript">
$(function(){
 
    // add multiple select / deselect functionality
    $("#select_all").click(function () {
          $('.case').attr('checked', this.checked);
    });
 
    // if all checkbox are selected, check the selectall checkbox
    // and viceversa
    $(".case").click(function(){
 
        if($(".case").length == $(".case:checked").length) {
            $("#select_all").attr("checked", "checked");
        } else {
            $("#select_all").removeAttr("checked");
        }
 
    });
});
</SCRIPT>

</body>

</html>
