<?php 

include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/uploads.php';
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();


$uploads = new Uploads($db);

    $chunkIndex = isset($_POST["chunkIndex"]) ? $_POST["chunkIndex"] : "";;
    $fileName = "";//Misc.generateHash(15);
    $uploadId = $_POST["uploadId"];
    $complete = $_POST["complete"];
    if($complete == "false")
    {
        
        $attachment = $_FILES["uploadchunkdata"];
        $name = $attachment["name"];
       
        $fileName = $chunkIndex.".".$uploadId;
        move_uploaded_file($attachment["tmp_name"], "../tmp/".$fileName);
        echo "hi";
    }
    else{
        echo "hello";
        $fileExtension = $_POST["fileExtension"];
        $title = $_POST["title"];
        $createdBy = $_POST["userId"];
        $fileName = "../uploads/".$_POST["title"];//uniqid()."_".$uploadId.".".$fileExtension;
        echo $fileName;
        //merge the files together
            /*parts = [];
            var allFiles = [];
            fs.readdir(constants.tmpPath, function(err, files){
                files = files.map(function (fileName) {
                  return {
                    name: fileName,
                    time: fs.statSync(constants.tmpPath + '/' + fileName).mtime.getTime()
                  };
                })
                .sort(function (a, b) {
                  return a.time - b.time; })
                
                .map(function (v) {
                  return v.name; });

                  files.filter(function(element){
                        var extName = path.extname(element);
                        return extName === '.'+uploadId; 
        
                  }).forEach(function(value) {
                      allFiles.push(value);
                      const data = fs.readFileSync(constants.tmpPath+value);
                      parts.push(data);
                  });
                       
                        fs.writeFile(constants.uploadPath+fileName, Buffer.concat(parts), function(err){
                            const mimeType = mime.lookup(constants.uploadPath+fileName); 
                            console.log(mimeType);
                            var processed = 0;
                            var type = "video";
                            if(mimeType.indexOf("audio") > -1)
                            {
                                processed = 1;
                                type = "audio";
                            }
                            else if(mimeType.indexOf("mp4") > -1 || mimeType.indexOf("webm") > -1 ){
                                processed = 1;
                            }
                
                            const userObj = new User();
                            userObj.saveMedia(title, fileName, 10, type, processed, createdBy).then(function(response){
                               
                                res.send("1");
                            }).catch(function(err){
                                console.log("error", err);
                                res.send("0");
                            })
                            for(const file of allFiles){
                                fs.unlink(constants.tmpPath+file, function(){
                
                                });
                            }
                            deleteOldTmpFiles();
                
                        });
                        // Invoke the next step here however you like
                    
                  });*/

                  $files = glob('../tmp/*.'.$uploadId);

                  usort($files, function($a, $b) {
                    $tmpFileNameA = getFileName($a);
                    $tmpFileNameB = getFileName($b);
                    //return filemtime($a) > filemtime($b);
                    return $tmpFileNameA > $tmpFileNameB;
                });
                    
                    //echo "mergin fiels";
                    mergeFiles2($files, $fileName);
                    deleteTmpFiles($files);
					$count=unzip($_POST["title"]);
					$uploads->setUploadDetails($_POST["title"], $count,$_SESSION['uid']);
        }
function unzip($filename){
	
	$p=realpath(__DIR__ . '/..');
	
	$path = $p."/uploads/";

	$zip = new ZipArchive;
	$res = $zip->open($path.$filename);
	$i = $zip->numFiles;
	return $i;

}    
    
function getFileName($file)
{
    $path_parts = pathinfo($file);
    return $path_parts["filename"];
    
}

function mergeFiles($arrayOfFiles, $outputPath) {

    $dest = fopen($outputPath,"a");

    foreach ($arrayOfFiles as $f) {

        $FH = fopen($f,"r");

        $line = fgets($FH);

        while ($line !== false) {

            fputs($dest,$line);

            $line = fgets($FH);

        }

        fclose($FH);

    }

    fclose($dest);

}

function mergeFiles2($arrayOfFiles, $outputPath)
{
    $chunkSize = 2048 * 1024; //~ bytes
    //$dest = fopen($outputPath,"a");
   // echo "mergin files";
    //var_dump($arrayOfFiles);
    foreach ($arrayOfFiles as $f) {
    
        $fh = fopen( $f, 'rb' );
        $buffer = fread( $fh, $chunkSize );
        //fclose( $fh );
        
        $total = fopen( $outputPath, 'ab' );
        $write = fwrite( $total, $buffer );
        fclose( $total );
        

    }
   // echo "done merging files";
    //}
}
function deleteTmpFiles($arrayOfFiles)
{
    foreach ($arrayOfFiles as $f) {
        echo $f;
        unlink($f);
    }
}



?>
