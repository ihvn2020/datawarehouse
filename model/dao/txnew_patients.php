<?php
class TxNew_Patients{

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
		
		$query= "SELECT 
						datim_id,  COUNT(*) AS `total_rows`
				FROM
						" . $this->table_name . "
				GROUP BY
						datim_id";
		$stmt = $this->conn->prepare( $query );
		$stmt->execute();


			
		return $stmt;
	}
	
	
public function sumTxNew($cohort_id,$fy,$q){
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
public function sumTxNewState($cohort_id,$fy,$q,$state){
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
public function sumTxNewFacility($cohort_id,$fy,$q,$facilityid){
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
public function getPatients($qtrstart,$datim){

//echo "got here";
// query to count all data
$query= "SELECT 
						patient_uuid
				FROM
						" . $this->table_name . "
				WHERE 
						art_start_date > '$qtrstart' AND datim_id = '$datim'
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
public function countAll($qtrstart){

//echo "got here";
// query to count all data
$query= "SELECT 
						datim_id,  COUNT(radet_id) AS `total_rows`
				FROM
						" . $this->table_name . "
				WHERE 
						art_start_date > '$qtrstart'
				GROUP BY
						datim_id";

// prepare query statement
$stmt = $this->conn->prepare( $query );

$stmt->execute();

$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
//$datim_id = $row['total_rows'];
//$total_rows = $row['total_rows'];
//print_r($row);
return $row;
}

public function countLastQuarter($qtrstart,$qtrend){

//echo "got here";
// query to count all data
//echo $qtrend;
$query= "SELECT 
						datim_id,  COUNT(radet_id) AS `total_rows`
				FROM
						" . $this->table_name . "
				WHERE 
						current_art_status = 'active'  AND art_start_date >= '$qtrstart' AND art_start_date <= '$qtrend'
				GROUP BY
						datim_id";

// prepare query statement
$stmt = $this->conn->prepare( $query );

$stmt->execute();

$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
//$datim_id = $row['total_rows'];
//$total_rows = $row['total_rows'];
return $row;
}
	

	// used for the 'created' field when creating an object
	public function getTimestamp(){
		date_default_timezone_set('Africa/Lagos');
		$this->timestamp = date('Y-m-d H:i:s');
	}
	
}
?>
