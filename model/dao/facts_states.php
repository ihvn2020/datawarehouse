<?php
class Fact_States{

	// database connection and table name
	private $conn;
	private $table_name = "states";
	private $table_name1 = "cohort_dm";

	// object properties
	public $state_id;
	public $name;
	

	public function __construct($db){
		$this->conn = $db;
	}

	// used by select drop-down list 
	public function read(){
		//select all data
		$query = "SELECT
					state_id, name
				FROM
					" . $this->table_name . "
				ORDER BY
					name ASC";

		$stmt = $this->conn->prepare( $query );
		$stmt->execute();

		return $stmt;
	}
public function readIndicator(){
		//select all data
		$query = "SELECT
					id, cohort_short_name
				FROM
					" . $this->table_name1 . "
				";

		$stmt = $this->conn->prepare( $query );
		$stmt->execute();

		return $stmt;
	}
	public function readFacil($state){
		//select all data
		$query = "SELECT
					f.datim_id, f.facility_name,f.state_id
				FROM
					facility_dm f
				LEFT JOIN states on
						states.state_id = f.state_id
where f.state_id='$state' ORDER BY f.facility_name ASC 
				";

		$stmt = $this->conn->prepare( $query );
		$stmt->execute();

		return $stmt;
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
