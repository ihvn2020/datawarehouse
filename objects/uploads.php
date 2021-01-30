<?php
class Uploads{

	// database connection and table name
	private $conn;
	private $table_name = "user_uploads";
	private $table_namea = "status";

	// object properties
	public $id='';
	public $filename;
	public $filecount;
	public $date_uploaded;
	public $uploaded_by;
	public $status=0;
	public $facilityid;

	public function __construct($db){
		$this->conn = $db;
	}

	public function setUploadDetails($filename,$filecount,$user_id){
		// create the category
		// insert query
		
		$facid = substr($filename, 5, 11);
		$query = "INSERT INTO user_uploads
				SET id = ?, filename = ?, filecount = ?, datim_id=?, date_uploaded = ?, uploaded_by = ?, status = ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->filename=htmlspecialchars(strip_tags($filename));
		$this->filecount=htmlspecialchars(strip_tags($filecount));
		$this->datim_id=htmlspecialchars(strip_tags($facid));
		$this->date_uploaded=htmlspecialchars(strip_tags(date("Y-m-d")));
		$this->user_id=htmlspecialchars(strip_tags($user_id));
		$this->status=htmlspecialchars(strip_tags($this->status));
		// bind values
		
			//echo "got here";
				$stmt->bindParam(1, $this->id);
				$stmt->bindParam(2, $this->filename);
				$stmt->bindParam(3, $this->filecount);
				$stmt->bindParam(4, $this->datim_id);
				$stmt->bindParam(5, $this->date_uploaded);
				$stmt->bindParam(6, $this->user_id);
				$stmt->bindParam(7, $this->status);
			
				$stmt->execute();
			
	}
	public function view_uploads($facility_id){
		// read all categories from the database
		$query = "SELECT filename,filecount,date_uploaded,uploaded_by,status
				FROM " . $this->table_name . "	WHERE uploaded_by = ? ORDER BY date_uploaded DESC";

		// prepare query statement
		$stmt = $this->conn->prepare( $query );
		// bind values
		$stmt->bindParam(1,$facility_id, PDO::PARAM_INT);
		// execute query
		$stmt->execute();

		return $stmt;
	}
	public function searchAll($search_term, $from_record_num, $records_per_page){
		// search category based on search term
		// search query
		$query = "SELECT id, name, description
				FROM " . $this->table_name . "
				WHERE name LIKE ? OR description LIKE ?
				ORDER BY name ASC
				LIMIT ?, ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// bind  variables
		$query_search_term = "%{$search_term}%";

		$stmt->bindParam(1, $query_search_term);
		$stmt->bindParam(2, $query_search_term);
		$stmt->bindParam(3, $from_record_num, PDO::PARAM_INT);
		$stmt->bindParam(4, $records_per_page, PDO::PARAM_INT);

		// execute query
		$stmt->execute();

		return $stmt;
	}

	// count all categories
	public function countAll(){
		// query to count all data
		$query = "SELECT COUNT(*) as total_rows FROM categories";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$total_rows = $row['total_rows'];

		return $total_rows;
	}

	// count all categories with search term
	public function countAll_WithSearch($search_term){
		// search query
		$query = "SELECT COUNT(*) as total_rows FROM categories WHERE name LIKE ? OR description LIKE ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// bind search term
		$search_term = "%{$search_term}%";
		$stmt->bindParam(1, $search_term);
		$stmt->bindParam(2, $search_term);

		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$total_rows = $row['total_rows'];

		return $total_rows;
	}

	// read all with paging
	public function readAll_WithPaging($from_record_num, $records_per_page){
		// read all categories from the database
		$query = "SELECT id, name, description
				FROM " . $this->table_name . "
				ORDER BY id DESC
				LIMIT ?, ?";

		// prepare query statement
		$stmt = $this->conn->prepare( $query );

		// bind values
		$stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);

		// execute query
		$stmt->execute();

		return $stmt;
	}

	// used by select drop-down list
	public function read(){
		//select all data
		$query = "SELECT
					ID, name
				FROM
					" . $this->table_name . "
				WHERE name!='' ORDER BY
					name";

		$stmt = $this->conn->prepare( $query );
		$stmt->execute();

		return $stmt;
	}
	
	function readFacilityCode($sfacilityfrom){

		$query = "SELECT initials FROM " . $this->table_name . " WHERE ID = ? limit 0,1";

		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $sfacilityfrom);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$initials = $row['initials'];
		return $initials;
	}
	
	function readDistrictID($facilityid){

		$query = "SELECT district FROM " . $this->table_name . " WHERE ID = ? limit 0,1";

		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $facilityid);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$district = $row['district'];
		return $district;
	}

	// used to read category name by its ID
	function readNameById(){

		$query = "SELECT facility_name FROM " . $this->table_name . " WHERE id = ? limit 0,1";

		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $this->id);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $this->name = $row['facility_name'];
	}
	
	function getFacilityNameById($facility_id){

		$query = "SELECT name FROM " . $this->table_name . " WHERE id = ? limit 0,1";

		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $facility_id);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$name = $row['name'];
		return $name;
	}
}
?>
