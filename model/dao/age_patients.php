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
	public function getPatientsless1($datim,$q,$y){

//echo "got here";
// query to count all data
$query= "SELECT 
							 patient_unique_id
				FROM
						" . $this->table_name . "
				WHERE  current_age_yrs < '1' AND datim_id = '$datim' AND financial_quarter = '$q' and financial_year='$y'
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
public function countless1($q,$y){

// query to count all data
$query = "SELECT
					datim_id,  COUNT(patient_unique_id) AS `total_rows`
				FROM
					" . $this->table_name . "
					WHERE current_age_yrs < '1' AND financial_quarter = '$q' and financial_year='$y'
					GROUP BY
						datim_id
			";

// prepare query statement
$stmt = $this->conn->prepare( $query );

$stmt->execute();

$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
return $row;
}public function getPatients1to4($datim,$q,$y){

//echo "got here";
// query to count all data
$query= "SELECT 
							 patient_unique_id
				FROM
						" . $this->table_name . "
				WHERE  current_age_yrs BETWEEN 1 AND 4 AND datim_id = '$datim' AND financial_quarter = '$q' and financial_year='$y'
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
public function count1to4($q,$y){

// query to count all data
$query = "SELECT
					datim_id,  COUNT(patient_unique_id) AS `total_rows`
				FROM
					" . $this->table_name . "
					WHERE current_age_yrs BETWEEN 1 AND 4 AND financial_quarter = '$q' and financial_year='$y'
					GROUP BY
						datim_id
			";

// prepare query statement
$stmt = $this->conn->prepare( $query );

$stmt->execute();

$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
return $row;
}public function getPatients5to9($datim,$q,$y){

//echo "got here";
// query to count all data
$query= "SELECT 
							 patient_unique_id
				FROM
						" . $this->table_name . "
				WHERE  current_age_yrs BETWEEN 5 AND 9 AND datim_id = '$datim' AND financial_quarter = '$q' and financial_year='$y'
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
public function count5to9($q,$y){

// query to count all data
$query = "SELECT
					datim_id,  COUNT(patient_unique_id) AS `total_rows`
				FROM
					" . $this->table_name . "
					WHERE current_age_yrs BETWEEN 5 AND 9 AND financial_quarter = '$q' and financial_year='$y'
					GROUP BY
						datim_id
			";

// prepare query statement
$stmt = $this->conn->prepare( $query );

$stmt->execute();

$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
return $row;
}public function getPatients10to14($datim,$q,$y){

//echo "got here";
// query to count all data
$query= "SELECT 
							 patient_unique_id
				FROM
						" . $this->table_name . "
				WHERE  current_age_yrs BETWEEN 10 AND 14 AND datim_id = '$datim' AND financial_quarter = '$q' and financial_year='$y'
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
public function count10to14($q,$y){

// query to count all data
$query = "SELECT
					datim_id,  COUNT(patient_unique_id) AS `total_rows`
				FROM
					" . $this->table_name . "
					WHERE current_age_yrs BETWEEN 10 AND 14 AND financial_quarter = '$q' and financial_year='$y'
					GROUP BY
						datim_id
			";

// prepare query statement
$stmt = $this->conn->prepare( $query );

$stmt->execute();

$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
return $row;
}public function getPatients15to19($datim,$q,$y){

//echo "got here";
// query to count all data
$query= "SELECT 
							 patient_unique_id
				FROM
						" . $this->table_name . "
				WHERE  current_age_yrs BETWEEN 15 AND 19 AND datim_id = '$datim' AND financial_quarter = '$q' and financial_year='$y'
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
public function count15to19($q,$y){

// query to count all data
$query = "SELECT
					datim_id,  COUNT(patient_unique_id) AS `total_rows`
				FROM
					" . $this->table_name . "
					WHERE current_age_yrs BETWEEN 15 AND 19 AND financial_quarter = '$q' and financial_year='$y'
					GROUP BY
						datim_id
			";

// prepare query statement
$stmt = $this->conn->prepare( $query );

$stmt->execute();

$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
return $row;
}public function getPatients20to24($datim,$q,$y){

//echo "got here";
// query to count all data
$query= "SELECT 
							 patient_unique_id
				FROM
						" . $this->table_name . "
				WHERE  current_age_yrs BETWEEN 20 AND 24 AND datim_id = '$datim' AND financial_quarter = '$q' and financial_year='$y'
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
public function count20to24($q,$y){

// query to count all data
$query = "SELECT
					datim_id,  COUNT(patient_unique_id) AS `total_rows`
				FROM
					" . $this->table_name . "
					WHERE current_age_yrs BETWEEN 20 AND 24 AND financial_quarter = '$q' and financial_year='$y'
					GROUP BY
						datim_id
			";

// prepare query statement
$stmt = $this->conn->prepare( $query );

$stmt->execute();

$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
return $row;
}public function getPatients25to29($datim,$q,$y){

//echo "got here";
// query to count all data
$query= "SELECT 
							 patient_unique_id
				FROM
						" . $this->table_name . "
				WHERE  current_age_yrs BETWEEN 25 AND 29 AND datim_id = '$datim' AND financial_quarter = '$q' and financial_year='$y'
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
public function count25to29($q,$y){

// query to count all data
$query = "SELECT
					datim_id,  COUNT(patient_unique_id) AS `total_rows`
				FROM
					" . $this->table_name . "
					WHERE current_age_yrs BETWEEN 25 AND 29 AND financial_quarter = '$q' and financial_year='$y'
					GROUP BY
						datim_id
			";

// prepare query statement
$stmt = $this->conn->prepare( $query );

$stmt->execute();

$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
return $row;
}public function getPatients30to34($datim,$q,$y){

//echo "got here";
// query to count all data
$query= "SELECT 
							 patient_unique_id
				FROM
						" . $this->table_name . "
				WHERE  current_age_yrs BETWEEN 30 AND 34 AND datim_id = '$datim' AND financial_quarter = '$q' and financial_year='$y'
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
public function count30to34($q,$y){

// query to count all data
$query = "SELECT
					datim_id,  COUNT(patient_unique_id) AS `total_rows`
				FROM
					" . $this->table_name . "
					WHERE current_age_yrs BETWEEN 30 AND 34 AND financial_quarter = '$q' and financial_year='$y'
					GROUP BY
						datim_id
			";

// prepare query statement
$stmt = $this->conn->prepare( $query );

$stmt->execute();

$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
return $row;
}public function getPatients35to39($datim,$q,$y){

//echo "got here";
// query to count all data
$query= "SELECT 
							 patient_unique_id
				FROM
						" . $this->table_name . "
				WHERE  current_age_yrs BETWEEN 35 AND 39 AND datim_id = '$datim' AND financial_quarter = '$q' and financial_year='$y'
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
public function count35to39($q,$y){

// query to count all data
$query = "SELECT
					datim_id,  COUNT(patient_unique_id) AS `total_rows`
				FROM
					" . $this->table_name . "
					WHERE current_age_yrs BETWEEN 35 AND 39 AND financial_quarter = '$q' and financial_year='$y'
					GROUP BY
						datim_id
			";

// prepare query statement
$stmt = $this->conn->prepare( $query );

$stmt->execute();

$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
return $row;
}public function getPatients40to44($datim,$q,$y){

//echo "got here";
// query to count all data
$query= "SELECT 
							 patient_unique_id
				FROM
						" . $this->table_name . "
				WHERE  current_age_yrs BETWEEN 40 AND 44 AND datim_id = '$datim' AND financial_quarter = '$q' and financial_year='$y'
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
public function count40to44($q,$y){

// query to count all data
$query = "SELECT
					datim_id,  COUNT(patient_unique_id) AS `total_rows`
				FROM
					" . $this->table_name . "
					WHERE current_age_yrs BETWEEN 40 AND 44 AND financial_quarter = '$q' and financial_year='$y'
					GROUP BY
						datim_id
			";

// prepare query statement
$stmt = $this->conn->prepare( $query );

$stmt->execute();

$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
return $row;
}public function getPatients45to49($datim,$q,$y){

//echo "got here";
// query to count all data
$query= "SELECT 
							 patient_unique_id
				FROM
						" . $this->table_name . "
				WHERE  current_age_yrs BETWEEN 45 AND 49 AND datim_id = '$datim' AND financial_quarter = '$q' and financial_year='$y'
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
public function count45to49($q,$y){

// query to count all data
$query = "SELECT
					datim_id,  COUNT(patient_unique_id) AS `total_rows`
				FROM
					" . $this->table_name . "
					WHERE current_age_yrs BETWEEN 45 AND 49 AND financial_quarter = '$q' and financial_year='$y'
					GROUP BY
						datim_id
			";

// prepare query statement
$stmt = $this->conn->prepare( $query );

$stmt->execute();

$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
return $row;
}public function getPatientsplus50($datim,$q,$y){

//echo "got here";
// query to count all data
$query= "SELECT 
							 patient_unique_id
				FROM
						" . $this->table_name . "
				WHERE  current_age_yrs >='50' AND datim_id = '$datim' AND financial_quarter = '$q' and financial_year='$y'
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
public function countplus50($q,$y){

// query to count all data
$query = "SELECT
					datim_id,  COUNT(patient_unique_id) AS `total_rows`
				FROM
					" . $this->table_name . "
					WHERE current_age_yrs >='50' AND financial_quarter = '$q' and financial_year='$y'
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
public function sumageFacility($cohort_id,$fy,$q,$fac_id){
//echo "got here";
// query to count all data
$query= "SELECT 
						cohort_value as 'value'
				FROM
						" . $this->table_name1 . "
				
				WHERE
					datim_id='$fac_id'
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
public function sumageState($cohort_id,$fy,$q,$state_id){
//echo "got here";
// query to count all data
$query= "SELECT 
						SUM(cohort_value) as 'value'
				FROM
						" . $this->table_name1 . " c
				LEFT JOIN facility_dm ON
					facility_dm.datim_id = c.datim_id
				WHERE
					facility_dm.state_id='$state_id'
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
	
	// used for the 'created' field when creating an object
	public function getTimestamp(){
		date_default_timezone_set('Africa/Lagos');
		$this->timestamp = date('Y-m-d H:i:s');
	}
}
?>
