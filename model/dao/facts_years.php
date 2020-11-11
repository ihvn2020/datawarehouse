<?php
class PFacts_Years{

	// database connection and table name
	private $conn;
	private $table_name = "fact_years";

	// object properties
	public $id;
	public $code;
	public $name;
	

	public function __construct($db){
		$this->conn = $db;
	}

	// used by select drop-down list
	public function read(){
		//select all data
		$query = "SELECT
					code, name
				FROM
					" . $this->table_name . "
				ORDER BY
					name DESC";

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
	
	function getQuarter(\DateTime $DateTime) {
		$y = $DateTime->format('Y');
		$m = $DateTime->format('m');
		$year;
		switch($m) {
			case $m >= 1 && $m <= 3:
				$start = '01/01/'.$y;
				$end = (new DateTime('03/1/'.$y))->modify('Last day of this month')->format('Y/m/d');
				$quart = '1';
				$year = $y;
				break;
			case $m >= 4 && $m <= 6:
				$start = '04/01/'.$y;
				$end = (new DateTime('06/1/'.$y))->modify('Last day of this month')->format('Y/m/d');
				$quart = '2';
				$year = $y;
				break;
			case $m >= 7 && $m <= 9:
				$start = '07/01/'.$y;
				$end = (new DateTime('09/1/'.$y))->modify('Last day of this month')->format('Y/m/d');
				$quart = '3';
				$year = $y;
				break;
			case $m >= 10 && $m <= 12:
				$start = '10/01/'.$y;
				$end = (new DateTime('12/1/'.$y))->modify('Last day of this month')->format('Y/m/d');
				$quart = '4';
				$year = date('Y', strtotime('+1 year'));
				break;
		}
		return array(
				'start' => $start,
				'end' => $end,
				'quart' => $quart,
				'fy'=>$year,
		);
	}
}
?>
