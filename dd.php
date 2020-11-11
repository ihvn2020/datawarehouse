<?Php
// core configuration
include_once "config/core.php";

$cat_id=$_GET['uname'];
//$cat_id=2;
/// Preventing injection attack //// 
 //if(!is_numeric($cat_id)){
 //echo "Data Error";
 //exit;
 //}
/// end of checking injection attack ////
include_once 'config/database.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

$sql="Select f.id as id,f.surname as fname FROM user u 
LEFT JOIN user_facility uf ON u.id=uf.user_id
LEFT JOIN facilitys f ON f.id=uf.facility_id
where u.email='$cat_id' ORDER BY f.surname ASC ";
$row=$db->prepare($sql);
$row->execute();
$result=$row->fetchAll(PDO::FETCH_ASSOC);

$main = array('data'=>$result);
echo json_encode($main);
?>