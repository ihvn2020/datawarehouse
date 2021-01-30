<?php
class TxCurr_Patients{

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
						datim_id,  COUNT(patient_unique_id) AS `total_rows`
				FROM
						" . $this->table_name . "
				GROUP BY
						datim_id";
		$stmt = $this->conn->prepare( $query );
		$stmt->execute();


			
		return $stmt;
	}
	
	

public function getPatients($datim,$q,$y){

//echo "got here";
// query to count all data
$query= "SELECT 
							patient_unique_id
				FROM
						" . $this->table_name . "
				WHERE 
						current_art_status = 'active' AND datim_id = '$datim' AND financial_quarter = '$q' and financial_year='$y'
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

public function countAll($q,$y){

//echo "got here";
// query to count all data
$query= "SELECT 
						datim_id,  COUNT(patient_unique_id) AS `total_rows`
				FROM
						" . $this->table_name . "
				WHERE 
						current_art_status = 'active' AND financial_quarter = '$q' and financial_year='$y'
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
public function getPatientsListState($cohort_id,$fy,$q,$state){
//SET group_concat_max_len = 2000000;
//echo "got here";
// query to count all data

//$q="SET group_concat_max_len = 100000;";GROUP_CONCAT(json_object SEPARATOR ', ')  as list
$query= "SELECT 
						GROUP_CONCAT(json_object SEPARATOR ', ')  as list
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

$row = $stmt->fetchAll(PDO::FETCH_COLUMN);
//$datim_id = $row['total_rows'];
//$total_rows = $row['total_rows'];
//print_r($row);
return $row;
}
public function getPatientsListFacility($cohort_id,$fy,$q,$facility){
//SET group_concat_max_len = 2000000;
//echo "got here";
// query to count all data

//$q="SET group_concat_max_len = 100000;";GROUP_CONCAT(json_object SEPARATOR ', ')  as list
$query= "SELECT 
						GROUP_CONCAT(json_object SEPARATOR ', ')  as list
				FROM
						" . $this->table_name1 . " 
				
				WHERE
					datim_id='$facility'
				AND 
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
public function getPatientsList($cohort_id,$fy,$q){
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
public function sumTxCurr($cohort_id,$fy,$q){
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
public function sumTxCurrState($cohort_id,$fy,$q,$state){
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
public function sumTxCurrFacility($cohort_id,$fy,$q,$facilityid){
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

public function countLastQuarter($qtrend){

//echo "got here";
// query to count all data
//echo $qtrend;
$query= "SELECT 
						datim_id,  COUNT(radet_id) AS `total_rows`
				FROM
						" . $this->table_name . "
				WHERE 
						current_art_status = 'active'  AND art_start_date <= '$qtrend'
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
