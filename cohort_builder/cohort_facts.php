<?php 


class Facts{

	// database connection and table name
	private $conn;
	private $table_name = "cohort_fact";
	
	// object properties
	public $cohort_id;  
	public $fy;   
	public $q;  
	public $datim_id; 
	public $cohort_value;
	public $json_object;
	public $date_created;
	
	public function __construct($db){
		$this->conn = $db;
	}
	
	public function insertStateFact($cohort_id,$fy,$q,$datim_id,$cohort_value,$json_object){
		
		$id = $this->checkIfValueExists($cohort_id,$fy,$q,$datim_id,$cohort_value);
		//echo $id;
		//echo $exists."<br>";
		if ($id == 0) {
    
	try {
		$this->getTimestamp();

		//write query
		$query = "INSERT INTO " . $this->table_name . "
		SET cohort_id = ?, fy = ?, q = ?, datim_id = ?, cohort_value = ?, json_object = ?";
        
		$stmt = $this->conn->prepare($query);
        
		
		$stmt->bindParam(1, $cohort_id);
		$stmt->bindParam(2, $fy);
		$stmt->bindParam(3, $q);
		$stmt->bindParam(4, $datim_id);
		$stmt->bindParam(5, $cohort_value);
		$stmt->bindParam(6, implode(',',$json_object));
		//$stmt->bindParam(8, $this->timestamp);
    }
    catch(PDOException $e)
    {
		echo "Got here";
    echo "Error: " . $e->getMessage();
	
    }
	$stmt->execute() or die(print_r($stmt->errorInfo(), true));
	
	}else {
		
		$this->updateFacts($id,$cohort_value,implode(',',$json_object));
	}
		

	}
	
	// used for the 'created' field when creating a product
	public function getTimestamp(){
		date_default_timezone_set('Africa/Lagos');
		$this->timestamp = date('Y-m-d H:i:s');
	}
	
	// update the product
	public function updateFacts($id,$cohort_value,$json_object){
		//echo $id."<br>";
		
		//echo $cohort_value."<br>";
		
		$query = "UPDATE cohort_fact
				SET cohort_value ='$cohort_value'
				WHERE
					id=?";

		$stmt = $this->conn->prepare($query);
		
		$stmt->bindParam(1, $id);
		
		// execute the query
		if($stmt->execute()){
			//echo "Record Updated"."<br>";
			//print_r($stmt->errorInfo());
			return true;
		}else{
			return false;
			//echo "false";
		}
		
	}
	
	
	
	public function checkIfValueExists($cohort_id,$fy,$q,$datim_id,$cohort_value){
		// query to count all data
		$query = "SELECT id FROM cohort_fact WHERE cohort_id='$cohort_id' AND fy='$fy' AND q='$q' AND datim_id='$datim_id'";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$total_rows = $row['id'];

		return $total_rows;
	}
}
	
	
?>