<?php
class Compare_Indicator{

	// database connection and table name
	private $conn;
	private $table_name = "cohort_fact";

	// object properties
	public $patient_uuid;
	public $datim_id;
	

	public function __construct($db){
		$this->conn = $db;
	}

	// used by select drop-down list 
public function getIndicatorValueFacility($cohort_id,$facility,$fy,$q){
//echo "got here";
// query to count all data
$query= "SELECT 
						cohort_short_name,SUM(cohort_value) as 'value'
				FROM
						cohort_fact c

                LEFT JOIN cohort_dm ON
                	cohort_dm.id = c.cohort_id
					
				WHERE
					datim_id='$facility'
				AND 
						fy='$fy' AND q='$q' AND cohort_id IN ($cohort_id) 
						
				GROUP BY
						cohort_id
		";

// prepare query statement
$stmt = $this->conn->prepare( $query );

$stmt->execute();

$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
//$datim_id = $row['total_rows'];
//$total_rows = $row['value'];
return $row;
}	
public function getIndicatorValueAll($cohort_id,$fy,$q){
//echo "got here";
// query to count all data
$query= "SELECT 
						cohort_short_name,SUM(cohort_value) as 'value'
				FROM
						cohort_fact c

                LEFT JOIN cohort_dm ON
                	cohort_dm.id = c.cohort_id
					
				WHERE fy='$fy' AND q='$q' AND cohort_id IN ($cohort_id) 
						
				GROUP BY
						cohort_id
		";

// prepare query statement
$stmt = $this->conn->prepare( $query );

$stmt->execute();

$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
//$datim_id = $row['total_rows'];
//$total_rows = $row['value'];
return $row;
}	
public function getIndicatorValue($cohort_id,$state,$fy,$q){
//echo "got here";
// query to count all data
$query= "SELECT 
						cohort_short_name,SUM(cohort_value) as 'value'
				FROM
						cohort_fact c
						
				LEFT JOIN facility_dm ON
					facility_dm.datim_id = c.datim_id
                LEFT JOIN cohort_dm ON
                	cohort_dm.id = c.cohort_id
				WHERE
					facility_dm.state_id='$state'
				AND 
						fy='$fy' AND q='$q' AND cohort_id IN ($cohort_id) 
						
				GROUP BY
						cohort_id
		";

// prepare query statement
$stmt = $this->conn->prepare( $query );

$stmt->execute();

$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
//$datim_id = $row['total_rows'];
//$total_rows = $row['value'];
return $row;
}
public function getIndicatorValueNew($cohort_id,$state,$fy,$q){
//echo "got here";
// query to count all data
$query= "SELECT 
						cohort_short_name,SUM(cohort_value) as 'value'
				FROM
						cohort_fact c
						
				LEFT JOIN facility_dm ON
					facility_dm.datim_id = c.datim_id
                LEFT JOIN cohort_dm ON
                	cohort_dm.id = c.cohort_id
				WHERE
					facility_dm.state_id='$state'
				AND 
						fy='$fy' AND q='$q' AND cohort_id IN ($cohort_id) 
						
				GROUP BY
						cohort_id
		";

// prepare query statement
$stmt = $this->conn->prepare( $query );

$stmt->execute();

$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
//$datim_id = $row['total_rows'];
//$total_rows = $row['value'];
return $row;
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
