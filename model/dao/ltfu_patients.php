<?php
class LTFU_Patients{

	// database connection and table name
	private $conn;
	private $table_name = "radet_fact";
	private $table_name1 = "cohort_fact";

	// object properties
	public $patient_uuid;
	public $current_art_status;
	

	public function __construct($db){
		$this->conn = $db;
	}

	// used by select drop-down list 
	public function read(){
		//select all data
		$query = "SELECT
					patient_uuid,
				FROM
					" . $this->table_name . "
			";

		$stmt = $this->conn->prepare( $query );
		$stmt->execute();


			
		return $stmt;
	}
	
	


public function countAll(){

// query to count all data
$query = "SELECT
					datim_id,  COUNT(radet_id) AS `total_rows`
				FROM
					" . $this->table_name . " 
				WHERE current_art_status = 'LTFU'
				
				GROUP BY
						datim_id
			";

// prepare query statement
$stmt = $this->conn->prepare( $query );

$stmt->execute();

$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
//$datim_id = $row['total_rows'];
//$total_rows = $row['total_rows'];
//print_r($row);
return $row;
}
public function getPatients($datim){

//echo "got here";
// query to count all data
$query= "SELECT 
						patient_uuid
				FROM
						" . $this->table_name . "
				WHERE 
						current_art_status = 'LTFU' AND datim_id = '$datim'
				";

// prepare query statement
$stmt = $this->conn->prepare( $query );

$stmt->execute();

$row = $stmt->fetchAll(PDO::FETCH_COLUMN);
//$datim_id = $row['total_rows'];
//$total_rows = $row['total_rows'];
//print_r($row);
return $row;
}
public function getPatientsDash($cohort_id,$fy,$q){
//SET group_concat_max_len = 2000000;
//echo "got here";
// query to count all data

//$q="SET group_concat_max_len = 100000;";GROUP_CONCAT(json_object SEPARATOR ', ')  as list
$query= "SELECT 
						GROUP_CONCAT(json_object SEPARATOR ', ')  as list
				FROM
						" . $this->table_name1 . "
				WHERE 
						fy='$fy' AND q='$q' AND cohort_id='$cohort_id'
				";

// prepare query statement
$stmt = $this->conn->prepare( $query );

$stmt->execute();

$row = $stmt->fetchAll(PDO::FETCH_COLUMN);
//$datim_id = $row['total_rows'];
//$total_rows = $row['total_rows'];
//print_r($row);
return $row;
}
public function sumltfu($cohort_id,$fy,$q){
//echo "got here";
// query to count all data
$query= "SELECT 
						SUM(cohort_value) as 'value'
				FROM
						" . $this->table_name1 . "
				WHERE 
						fy='$fy' AND q='$q' AND cohort_id='$cohort_id'
		";

// prepare query statement
$stmt = $this->conn->prepare( $query );

$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);
//$datim_id = $row['total_rows'];
$total_rows = $row['value'];
//print_r($row);
return $total_rows;
}
public function sumltfuState($cohort_id,$fy,$q,$state){
//echo "got here";
// query to count all data
$query= "SELECT 
						SUM(cohort_value) as 'value' 
				FROM
						" . $this->table_name1 . " c
				LEFT JOIN facility_dm ON
					facility_dm.datim_id = c.datim_id
				WHERE
					facility_dm.state_id='$state'
				AND 
						fy='$fy' AND q='$q' AND cohort_id='$cohort_id'
		";

// prepare query statement
$stmt = $this->conn->prepare( $query );

$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);
//$datim_id = $row['total_rows'];
$total_rows = $row['value'];
//print_r($row);
return $total_rows;
}
public function sumltfuFacility($cohort_id,$fy,$q,$facilityid){
//echo "got here";
// query to count all data
$query= "SELECT 
						SUM(cohort_value) as 'value' 
				FROM
						" . $this->table_name1 . " 
				WHERE
					datim_id='$facilityid'
				AND 
						fy='$fy' AND q='$q' AND cohort_id='$cohort_id'
		";

// prepare query statement
$stmt = $this->conn->prepare( $query );

$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);
//$datim_id = $row['total_rows'];
$total_rows = $row['value'];
//print_r($row);
return $total_rows;
}
	// delete the gender
	public function delete(){

		$query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->id=htmlspecialchars(strip_tags($this->id));

		$stmt->bindParam(1, $this->id);

		if($result = $stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	// delete selected gender
	public function deleteSelected($ids){

		$in_ids = str_repeat('?,', count($ids) - 1) . '?';

		// query to delete multiple records
		$query = "DELETE FROM " . $this->table_name . " WHERE id IN ({$in_ids})";

		$stmt = $this->conn->prepare($query);

		if($stmt->execute($ids)){
			return true;
		}else{
			return false;
		}
	}

	// used for the 'created' field when creating an object
	public function getTimestamp(){
		date_default_timezone_set('Africa/Lagos');
		$this->timestamp = date('Y-m-d H:i:s');
	}
}
?>
