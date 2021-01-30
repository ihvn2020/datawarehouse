<?Php
// core configuration
include_once "../config/core.php";

$cat_id=$_GET['cat_id'];
//$cat_id=2;
/// Preventing injection attack //// 
 //if(!is_numeric($cat_id)){
 //echo "Data Error";
 //exit;
 //}
/// end of checking injection attack ////
include_once '../config/database.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

$sql="SELECT
					f.datim_id, f.facility_name,f.state_id
				FROM
					facility_dm f
				LEFT JOIN states on
						states.state_id = f.state_id
where f.state_id='$cat_id' ORDER BY f.facility_name ASC ";
$row=$db->prepare($sql);
$row->execute();
$result=$row->fetchAll(PDO::FETCH_ASSOC);

$main = array('data'=>$result);
echo json_encode($main);
?>