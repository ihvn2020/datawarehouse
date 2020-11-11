<?php
class All_Facilities{

	// database connection and table name
	private $conn;
	private $table_name = "radet_fact";
	private $table_name1 = "cohort_fact";

	// object properties
	public $patient_uuid;
	public $datim_id;
	

	public function __construct($db){
		$this->conn = $db;
	}

	// used by select drop-down list 
	public function read(){
		
		
		//select all data
		$query = "SELECT
					DISTINCT r.datim_id
				FROM
					" . $this->table_name . " r
					
					LEFT JOIN facility_dm ON
					facility_dm.datim_id = r.datim_id
			";

		$stmt = $this->conn->prepare( $query );
		$stmt->execute();
		
		$row = $stmt->fetchAll(PDO::FETCH_COLUMN);
		return $row;
}
public function readState($state){
		
		
			$query = "SELECT
					DISTINCT r.datim_id
				FROM
					" . $this->table_name . " r
					
					LEFT JOIN facility_dm ON
					facility_dm.datim_id = r.datim_id
				WHERE
					facility_dm.state_id='$state'
			";

		$stmt = $this->conn->prepare( $query );
		$stmt->execute();
		$row = $stmt->fetchAll(PDO::FETCH_COLUMN);
		return $row;
		
	
}
public function readFacility($facilityid){
		
		
			$query = "SELECT
					DISTINCT r.datim_id
				FROM
					" . $this->table_name . " r
					
					LEFT JOIN facility_dm ON
					facility_dm.datim_id = r.datim_id
				WHERE
					facility_dm.datim_id='$facilityid'
			";

		$stmt = $this->conn->prepare( $query );
		$stmt->execute();
		$row = $stmt->fetchAll(PDO::FETCH_COLUMN);
		return $row;
		
	
}
		
	
	


public function countAll(){

// query to count all data
$query = "SELECT
					DISTINCT(radet_fact.datim_id), facility_state
				FROM
					" . $this->table_name . " 
					
					LEFT JOIN facility_dm ON
					facility_dm.datim_id = radet_fact.datim_id
					
			";

// prepare query statement
$stmt = $this->conn->prepare( $query );

$stmt->execute();

$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
return $row;
}
public function sumpatients($cohort_id,$fy,$q){
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
