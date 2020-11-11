<?php 


class Facts{

	// database connection and table name
	private $conn;
	private $table_name = "facts";
	
	// object properties
	public $indicator_id;  
	public $period;   
	public $pmonth;  
	public $pyear; 
	public $location_id; 	
	public $location_level_id;
	public $data_value;
	public $date_created;
	
	public function __construct($db){
		$this->conn = $db;
	}
	
	// used for the 'created' field when creating a product
	public function getTimestamp(){
		date_default_timezone_set('Africa/Lagos');
		$this->timestamp = date('Y-m-d H:i:s');
	}
	
	
	
	public function factsPerYear($indicator_id,$year){
		// query to count all data
		$query = "SELECT data_value as dvalue FROM facts WHERE indicator_id='$indicator_id' AND pyear='$year' AND pmonth=0";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$total_rows = $row['dvalue'];

		return $total_rows;
	}
	
	public function factsPerYearMonth($indicator_id,$year,$month){
		// query to count all data
	$query = "SELECT data_value as dvalue FROM facts WHERE indicator_id='$indicator_id' AND pyear='$year' AND pmonth='$month'";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$total_rows = $row['dvalue'];

		return $total_rows;
	}
	
	
}
	
	
?>