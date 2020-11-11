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



// set page title
$page_title="Upload New XML";
// include login checker
$require_login=true;



?>

<html>
    <head>
        <title>IHVN Data Warehouse</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <link href="bootstrap.min.css" rel="stylesheet"/>
    <!-- Favicon icon -->
    <link rel="icon" href="assets/images/login_icon.ico" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="bower_components/bootstrap/css/bootstrap.min.css">    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <!--color css-->

    
    </head>
 
<style type="text/css">
	label
	{
		display:block !important;
		font-size: 15px;
	}
</style>
<!-- Style of VideoJS -->
<body>
 <!-- Main content -->
     <section class="content"> 
		<div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">
				<nav class="navbar header-navbar pcoded-header" header-theme="theme4">
                <div class="navbar-wrapper">
				
                    <div class="navbar-logo">
                        <a class="mobile-menu" id="mobile-collapse" href="">
                            <i class="ti-menu"></i>
                        </a>
                        
                        <a href="home.php"><br/>
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
                                    <div class="sidebar_toggle"><a href="home.php"><br/><br/>Home</a></div>
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
                </div>
                    </div>
                            <div class="main-body">						
                                <div class="page-wrapper"> 
							<div class="page-header">
										&emsp;&emsp;<div class="page-header-title">  
												<h2> Upload Zipped File From NMRS</h2>
												<span>Exported File from NMRS can be uploaded here in Zipped Format</span>
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
										
						    
				<!-- Left column start -->
                    <div class="col-lg-12 col-xl-12">
                        <!-- Flying Word card start -->
						<!--<form method="post" enctype="multipart/form-data">--><br/>
						<div class='box-body pad'>
						<form action="" method="POST">
                        <div class="card">                           
                            <div class="card-block">
                               
                                
                                    <div class="form-group row">
                                        <div class="col-sm-9">
                                            <label >Select File To Upload</label>
                                             <div class="col-md-9 col-sm-9">
                                                    <input type="file" name="mediaFile" id="mediaFile" class="form-control">
                                             </div>
											 <br/>
											 <br/><br/>
											 <br/>
											 <div class="row">
                                            <div class="col-sm-11">
                                                <div class="progress">
                                                    <div class="progress-bar" id="progressBar" role="progressbar" style="width:0%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" ></div>
                                                    <span id="progressPercent" style="font-size: 15px; font-weight: bold;">0%</span>
                                                </div>
                                            </div>
                                        </div>
                                        <br/>
                                        
                                        <div class="alert alert-success alert-dismissable hidden" id="successMessage" >
                                        <i class="fa fa-check"></i>
                                            File has been successfully uploaded.
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                 <a href="javascript:void(0);" id="uploadResource" class="btn btn-primary" disabled="disabled" >Upload File</a>
                                            </div>
                                        </div>
										
											
                                        </div>
									
                                        
                                    </div>
									
                                   
								
                              
                               
                            </div>                            
							
                        </div>
						 </form>
                        <!-- Flying Word card end -->						
                    </div>
                                </div>
                </section><!-- /.content -->



<!-- Load VideoJS Record Extension -->
  <script type="text/javascript" src="jquery.min.js"></script>
  <script type="text/javascript" src="bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js" type="text/javascript"></script> 
<script type="text/javascript">

function setProgressBar(value)
{
    $("#progressBar").css("width", value+"%");
    $("#progressPercent").html(value+"%");
}

var counter = 1;



var audioData;

var videoBlob ;
var userId = 1;
 var title = "";
 var data = null;
 var type = "";
 var offset = 0;
 var chunk_size = 2*1024*1024; // 2Mbyte Chunk 
 var retry  = 0;
 var uploadId = new Date()+userId;
 var file_extension = "";

 	$(document).ready(function(e) {
       


        $("#uploadResource").click(function(e){
          
            //title = $("#title").val();
			fake_path=document.getElementById('mediaFile').value
			fake_path.split("\\").pop()
			title= fake_path.split("\\").pop()
            type = "custom";
            if(title == "")
            {
                alert("Fill out media title");
            }
            else{
                
                //data = $('#mediaFile')[0].files[0];
                data = document.getElementById("mediaFile").files[0];
                type = "custom";
                //uploadFile();
                
                
                uploadId = new Date().getTime()+"_"+userId;//reset the upload id
                //uploadToServer(title, type, data);
                $("#uploadResource").attr("disabled", "disabled");
                uploadForm(e)

            }
            
        });


        $("#mediaFile").change(function(e) {
            var allowedExt = allowedExtensions["zippedFile"]//use it to get the allowed extensions from the object
            if(!validate_fileupload($("#mediaFile").val(), allowedExt))
            {
                alert("File is not a valid zipped file. Please upload a zipped");
            }
            else{
                $("#uploadResource").removeAttr("disabled");
            }
        });
    });
          
    var allowedExtensions = {"zippedFile":["zip" ] };
                        
    function validate_fileupload(fileName, allowedTypes)
	{
		//var allowed_extensions = new Array("jpg","png","gif");
		var allowed_extensions = allowedTypes
		file_extension = fileName.split('.').pop(); // split function will split the filename by dot(.), and pop function will pop the last element from the array which will give you the extension as well. If there will be no extension then it will return the filename.

		for(var i = 0; i <= allowed_extensions.length; i++)
		{
			if(allowed_extensions[i]==file_extension)
			{
				return true; // valid file extension
			}
		}

		return false;
    }
    




    //function uploadChunk(evt)
    function uploadChunk(chunkedfile)
    {
        
        
         var form = document.getElementById("upload_form");
         var formData = new FormData();
         formData.append('title', title);
        formData.append('type', type);
        formData.append("userId", userId);
        //formData.append('', title);
        console.log(chunkedfile);
        //var baseIp = $("#baseIp").val();
        //var basePort = $("#basePort").val();
        formData.append("chunking", 'true');
         formData.append("uploadfilename",  title);
         formData.append("uploadId",  uploadId );
         formData.append("fileExtension", file_extension);
         if(chunkedfile == null)
         {
            formData.append("complete",  "true" );
            offset = 0;
         }
         else{
            var upload_size = chunkedfile.size;
            formData.append("complete",  "false" );
            formData.append("offset",  offset );
            formData.append("chunkIndex",  offset);
            formData.append("totalChunksCount",  data.size / chunk_size);
            formData.append("uploadchunkdata",  chunkedfile);
         }
        
         $.ajax({
                type: 'post',
                  data: formData,    
                  processData: false, 
                  contentType: false,
                  url:"upload_to_server.php",
                success: function(success){
                    if(chunkedfile == null)
                    {
                        $("#successMessage").removeClass("hidden");
                    }else{
                        offset += chunkedfile.size;
                    readSlice(null);
                    }
                    retry = 1;
                    
                },
                error: function(error, xhr, status){
                    console.log(error)
                    console.log(xhr)
                    console.log(status)
                    if( ++retry >= 20 ) {
                            setProgressBar("Upload failed")
                    }
                    else {
                        
                        console.log(error)
                        readSlice(null);//try to upload
                        console.log("retry")
                            //retry = 0;
                            //uploadChunk(evt);
                    }
                }
            });
    }

   function readCallback(evt) 
   {
        if (evt.target.error == null) {
                uploadChunk(evt);
        } else {
            setProgressBar("File read error on disk: " + evt.target.error);
            return;
        }
    }
    
    function readSlice(e)
    {
        //var files = document.getElementById("file_input");
        var file = data;//files.files[0];
        
          var reader = new FileReader();
          if( offset < file.size )
          {
            setProgressBar((100*offset/file.size).toFixed(0)  );
            var blob = file.slice( offset, offset + chunk_size );
            uploadChunk(blob);
           //reader.onload = readCallback;
           //reader.readAsDataURL(blob);

           
        }
        else
        {
            uploadChunk(null)
            setProgressBar(100);
            //progress_label.html("Upload complete"); 
        }
    } 

    function uploadForm(e){
        e.preventDefault();
        offset = 0; 
        readSlice(e);
        //progress_label.html("Starting...");
             
    }    
    
</script>
</body>
</html>