<?php
class Age_Patients{

	// database connection and table name
	private $conn;
	private $table_name = "patient_dm";
	private $table_name1 = "cohort_fact";

	// object properties
	public $patient_uuid;
	public $datim_id;
	

	public function __construct($db){
		$this->conn = $db;
	}
public function countless1(){

// query to count all data
$query = "SELECT
					datim_id,  COUNT(patient_uuid) AS `total_rows`
				FROM
					" . $this->table_name . "
					WHERE current_age_yrs < '1'
					GROUP BY
						datim_id
			";

// prepare query statement
$stmt = $this->conn->prepare( $query );

$stmt->execute();

$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
return $row;
}
public function count1to4(){

// query to count all data
$query = "SELECT
					datim_id,  COUNT(patient_uuid) AS `total_rows`
				FROM
					" . $this->table_name . "
					WHERE current_age_yrs BETWEEN 1 AND 4
					GROUP BY
						datim_id
			";

// prepare query statement
$stmt = $this->conn->prepare( $query );

$stmt->execute();

$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
return $row;
}
public function count5to9(){

// query to count all data
$query = "SELECT
					datim_id,  COUNT(patient_uuid) AS `total_rows`
				FROM
					" . $this->table_name . "
					WHERE current_age_yrs BETWEEN 5 AND 9
					GROUP BY
						datim_id
			";

// prepare query statement
$stmt = $this->conn->prepare( $query );

$stmt->execute();

$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
return $row;
}
public function count10to14(){

// query to count all data
$query = "SELECT
					datim_id,  COUNT(patient_uuid) AS `total_rows`
				FROM
					" . $this->table_name . "
					WHERE current_age_yrs BETWEEN 10 AND 14
					GROUP BY
						datim_id
			";

// prepare query statement
$stmt = $this->conn->prepare( $query );

$stmt->execute();

$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
return $row;
}
public function count15to19(){

// query to count all data
$query = "SELECT
					datim_id,  COUNT(patient_uuid) AS `total_rows`
				FROM
					" . $this->table_name . "
					WHERE current_age_yrs BETWEEN 15 AND 19
					GROUP BY
						datim_id
			";

// prepare query statement
$stmt = $this->conn->prepare( $query );

$stmt->execute();

$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
return $row;
}
public function count20to24(){

// query to count all data
$query = "SELECT
					datim_id,  COUNT(patient_uuid) AS `total_rows`
				FROM
					" . $this->table_name . "
					WHERE current_age_yrs BETWEEN 20 AND 24
					GROUP BY
						datim_id
			";

// prepare query statement
$stmt = $this->conn->prepare( $query );

$stmt->execute();

$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
return $row;
}
public function count25to29(){

// query to count all data
$query = "SELECT
					datim_id,  COUNT(patient_uuid) AS `total_rows`
				FROM
					" . $this->table_name . "
					WHERE current_age_yrs BETWEEN 25 AND 29
					GROUP BY
						datim_id
			";

// prepare query statement
$stmt = $this->conn->prepare( $query );

$stmt->execute();

$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
return $row;
}
public function count30to34(){

// query to count all data
$query = "SELECT
					datim_id,  COUNT(patient_uuid) AS `total_rows`
				FROM
					" . $this->table_name . "
					WHERE current_age_yrs BETWEEN 30 AND 34
					GROUP BY
						datim_id
			";

// prepare query statement
$stmt = $this->conn->prepare( $query );

$stmt->execute();

$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
return $row;
}
public function count35to39(){

// query to count all data
$query = "SELECT
					datim_id,  COUNT(patient_uuid) AS `total_rows`
				FROM
					" . $this->table_name . "
					WHERE current_age_yrs BETWEEN 35 AND 39
					GROUP BY
						datim_id
			";

// prepare query statement
$stmt = $this->conn->prepare( $query );

$stmt->execute();

$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
return $row;
}
public function count40to44(){

// query to count all data
$query = "SELECT
					datim_id,  COUNT(patient_uuid) AS `total_rows`
				FROM
					" . $this->table_name . "
					WHERE current_age_yrs BETWEEN 40 AND 44
					GROUP BY
						datim_id
			";

// prepare query statement
$stmt = $this->conn->prepare( $query );

$stmt->execute();

$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
return $row;
}
public function count45to49(){

// query to count all data
$query = "SELECT
					datim_id,  COUNT(patient_uuid) AS `total_rows`
				FROM
					" . $this->table_name . "
					WHERE current_age_yrs BETWEEN 45 AND 49
					GROUP BY
						datim_id
			";

// prepare query statement
$stmt = $this->conn->prepare( $query );

$stmt->execute();

$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
return $row;
}
public function countplus50(){

// query to count all data
$query = "SELECT
					datim_id,  COUNT(patient_uuid) AS `total_rows`
				FROM
					" . $this->table_name . "
					WHERE current_age_yrs >='50'
					GROUP BY
						datim_id
			";

// prepare query statement
$stmt = $this->conn->prepare( $query );

$stmt->execute();

$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
return $row;
}

public function sumage($cohort_id,$fy,$q){
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
	
	// used for the 'created' field when creating an object
	public function getTimestamp(){
		date_default_timezone_set('Africa/Lagos');
		$this->timestamp = date('Y-m-d H:i:s');
	}
}
?>
