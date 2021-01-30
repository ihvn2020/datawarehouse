<?php
class Radet_Object{

	// database connection and table name
	private $conn;
	private $table_name = "radet_fact";

	// object properties
	public $id;
	public $name;
	

	public function __construct($db){
		$this->conn = $db;
	}

	// used by select drop-down list 
	public function getRadet($datim_id,$fy,$q){
		//select all data
		$query = "SELECT
					r.patient_unique_id,p.patient_hospital_id,p.sex,p.age_at_art_start_yrs,p.age_at_art_start_months,r.art_start_date,r.last_pickup_date, r.days_of_arv_refil, r.initial_regimen_line,r.initial_first_line_regimen, r.current_regimen_line, r.current_first_line_regimen, r.current_first_line_regimen_date, r.current_second_line_regimen, r.current_second_line_regimen_date, r.pregnancy_status, r.current_viral_load, r.viral_load_sample_collection_date,r.viral_load_indication, r.current_art_status, p.current_age_yrs, p.current_age_months, p.date_of_birth
				FROM
					radet_fact r
				LEFT JOIN patient_dm p
					ON r.patient_unique_id= p.patient_unique_id
				WHERE r.datim_id='$datim_id' AND r.financial_year='$fy' AND r.financial_quarter='$q'
				ORDER BY
					patient_unique_id ASC";

		// prepare query statement
$stmt = $this->conn->prepare( $query );

$stmt->execute();

//$row = $stmt->fetchAll(PDO::FETCH_COLUMN);
//$datim_id = $row['total_rows'];
//$total_rows = $row['total_rows'];
//print_r($row);
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
