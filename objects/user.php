<?php
// 'user' object
class User{

    // database connection and table name
    private $conn;
    private $table_name = "users";

    // object properties
	public $ID;
	public $surname;
	public $oname;
	public $email;
	public $contact_number;
	public $ipid;
	public $password;
	public $group_id;
	public $account;
	public $flag;
	public $created;
    public $lastaccess;

	// constructor
    public function __construct($db){
        $this->conn = $db;
    }

    // used in change password feature
    // user is already logged in
    function changePassword(){

		// update query
		$query = "UPDATE
					" . $this->table_name . "
				SET
					password = :password
				WHERE
					id = :id";

		// prepare the query
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->password=htmlspecialchars(strip_tags($this->password));

		// bind the values from the form
		$password_hash = password_hash($this->password, PASSWORD_BCRYPT);
		$stmt->bindParam(':password', $password_hash);
		$stmt->bindParam(':id', $this->id);

		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	// used in forgot password feature
	function updatePassword(){

		// update query
		$query = "UPDATE
					" . $this->table_name . "
				SET
					password = :password
				WHERE
					access_code = :access_code";

		// prepare the query
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->password=htmlspecialchars(strip_tags($this->password));
		$this->access_code=htmlspecialchars(strip_tags($this->access_code));

		// bind the values from the form
		$password_hash = password_hash($this->password, PASSWORD_BCRYPT);
		$stmt->bindParam(':password', $password_hash);
		$stmt->bindParam(':access_code', $this->access_code);

		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	
	// check if given email exist in the database
	function emailExists($email){

		// query to check if email exists
		$query = "SELECT id, surname, oname,email, group_id, password
				FROM " . $this->table_name . "
				WHERE email = '$email'
				LIMIT 0,1";

		// prepare the query
		$stmt = $this->conn->prepare( $query );

		// execute the query
		$stmt->execute();

		// get number of rows
		$num = $stmt->rowCount();

		// if email exists, assign values to object properties for easy access and use for php sessions
		if($num>0){
			// return true because email exists in the database
			return true;
		}

		// return false if email does not exist in the database
		return false;
	}

    // create new user record
    function create(){

        // to get time stamp for 'created' field
        $this->datecreated=date('Y-m-d H:i:s');

        // insert query
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
					surname = :surname,
					oname = :oname,
					username = :email,
					email = :email,
					telephone = :telephone,
					password = :password,
					group_id = :group_id,
					datecreated = :datecreated";

		// prepare the query
        $stmt = $this->conn->prepare($query);

		// sanitize
		$this->surname=htmlspecialchars(strip_tags($this->surname));
		$this->oname=htmlspecialchars(strip_tags($this->oname));
		$this->email=htmlspecialchars(strip_tags($this->email));
		$this->telephone=htmlspecialchars(strip_tags($this->telephone));
		$this->password=htmlspecialchars(strip_tags($this->password));
		$this->group_id=htmlspecialchars(strip_tags($this->group_id));
		$this->status=htmlspecialchars(strip_tags($this->status));

		// bind the values
        $stmt->bindParam(':surname', $this->surname);
        $stmt->bindParam(':oname', $this->oname);
        $stmt->bindParam(':username', $this->email);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':telephone', $this->telephone);

		// hash the password before saving to database
		$password_hash = password_hash($this->password, PASSWORD_BCRYPT);
		$stmt->bindParam(':password', $password_hash);

		$stmt->bindParam(':group_id', $this->group_id);
		$stmt->bindParam(':datecreated', $this->datecreated);

		// execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }else{
			$this->showError($stmt);
            return false;
        }

    }

	// used for paging user search results
	public function countAll_BySearch($search_term){

		// query to search user
		$query = "SELECT id FROM " . $this->table_name . " WHERE email LIKE ?";

		// prepare the query
		$stmt = $this->conn->prepare( $query );

		// sanitize
		$search_term = "%{$search_term}%";
		$search_term=htmlspecialchars(strip_tags($search_term));

		// bind the values, $search_term is from the user search box
		$stmt->bindParam(1, $search_term);

		// execute the query
		$stmt->execute();

		// get number of rows
		$num = $stmt->rowCount();

		// return row count
		return $num;
	}

	// used for searching users
	function search($search_term, $from_record_num, $records_per_page){

		// query to search user
		$query = "SELECT id, firstname, lastname, email, contact_number, access_level, created
				FROM " . $this->table_name . "
				WHERE email LIKE ?
				ORDER BY email ASC
				LIMIT ?, ?";

		// prepare the query statement
		$stmt = $this->conn->prepare( $query );

		// sanitize
		$search_term = "%{$search_term}%";
		$search_term=htmlspecialchars(strip_tags($search_term));

		// bind the values, $search_term is from the user search box
		$stmt->bindParam(1, $search_term);
		$stmt->bindParam(2, $from_record_num, PDO::PARAM_INT);
		$stmt->bindParam(3, $records_per_page, PDO::PARAM_INT);

		// execute the query
		$stmt->execute();

		// return the retrieved rows
		return $stmt;
	}

	// update a user record
	public function update(){

		// if no posted password, do not update the password
		if(empty($this->password)){

			// update query
			$query = "UPDATE
						" . $this->table_name . "
					SET
						surname = :surname,
					oname = :oname,
					username = :email,
					email = :email,
					telephone = :telephone,
					group_id = :group_id
					WHERE
						id = :id";

			// prepare the query
			$stmt = $this->conn->prepare($query);

			// sanitize
		$this->surname=htmlspecialchars(strip_tags($this->surname));
		$this->oname=htmlspecialchars(strip_tags($this->oname));
		$this->username=htmlspecialchars(strip_tags($this->email));
		$this->email=htmlspecialchars(strip_tags($this->email));
		$this->telephone=htmlspecialchars(strip_tags($this->telephone));
		$this->group_id=htmlspecialchars(strip_tags($this->group_id));

			// bind the values
        $stmt->bindParam(':surname', $this->surname);
        $stmt->bindParam(':oname', $this->oname);
        $stmt->bindParam(':username', $this->email);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':telephone', $this->telephone);
			$stmt->bindParam(':group_id', $this->group_id);

			

		}

		// if password was posted, update the password
		else{
			$query = "UPDATE
						" . $this->table_name . "
					SET
						surname = :surname,
					oname = :oname,
					username = :email,
					email = :email,
					telephone = :telephone,
					password = :password,
					group_id = :group_id
					WHERE
						id = :id";

			// prepare the query
			$stmt = $this->conn->prepare($query);

			// sanitize
			$this->surname=htmlspecialchars(strip_tags($this->surname));
		$this->oname=htmlspecialchars(strip_tags($this->oname));
		$this->username=htmlspecialchars(strip_tags($this->email));
		$this->email=htmlspecialchars(strip_tags($this->email));
		$this->telephone=htmlspecialchars(strip_tags($this->telephone));
		$this->group_id=htmlspecialchars(strip_tags($this->group_id));
			$this->password=htmlspecialchars(strip_tags($this->password));

			$stmt->bindParam(':surname', $this->surname);
        $stmt->bindParam(':oname', $this->oname);
        $stmt->bindParam(':username', $this->email);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':telephone', $this->telephone);
			$stmt->bindParam(':group_id', $this->group_id);

			// hash the password before saving to database
			$password_hash = password_hash($this->password, PASSWORD_BCRYPT);
			$stmt->bindParam(':password', $password_hash);


		}

		// unique ID of record to be edited
		$stmt->bindParam(':id', $this->id);

		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	// read details of a single user based on given ID
	function readOne(){

		// query to read single record
		$query = "SELECT surname, oname, email, telephone, group_id, password
				FROM " . $this->table_name . "
				WHERE id = ?
				LIMIT 0,1";

		// prepare query
		$stmt = $this->conn->prepare( $query );

		// sanitize
		$this->id=htmlspecialchars(strip_tags($this->id));

		// bind id value
		$stmt->bindParam(1, $this->id);

		// execute query
		$stmt->execute();

		// get retrieved row
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		// assign the values to object properties, for easy access
		$this->firstname = $row['surname'];
		$this->lastname = $row['oname'];
		$this->email = $row['email'];
		$this->contact_number = $row['telephone'];
		$this->group_id = $row['group_id'];
		$this->password = $row['password'];
	}

	// read all user rows from the database
	function readAll_NoPaging(){

		// query to read all users
		$query = "SELECT id, firstname, lastname, email, contact_number, access_level, created
				FROM " . $this->table_name . "
				ORDER BY created DESC";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// execute query
		$stmt->execute();

		// return values
		return $stmt;
	}

	// read all user records
	function readAll($from_record_num, $records_per_page){

		// query to read all user records, with limit clause for pagination
		$query = "SELECT
					id,
					surname,
					oname,
					email,
					telephone,
					group_id
				FROM
					" . $this->table_name . "
				ORDER BY
					id DESC
				LIMIT
					?, ?";

		// prepare query statement
		$stmt = $this->conn->prepare( $query );

		// bind limit clause variables
		$stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);

		// execute query
		$stmt->execute();

		// return values
		return $stmt;
	}

	// used for paging products
	public function countAll(){

		// query to select all user records
		$query = "SELECT id FROM " . $this->table_name . "";

		// prepare query statement
		$stmt = $this->conn->prepare( $query );

		// execute query
		$stmt->execute();

		// get number of rows
		$num = $stmt->rowCount();

		// return row count
		return $num;
	}

	// delete the user record
	function delete(){

		// delete user query
		$query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->id=htmlspecialchars(strip_tags($this->id));

		// bind user id to delete
		$stmt->bindParam(1, $this->id);

		// execute the query
		if($result = $stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	public function showError($stmt){
		echo "<pre>";
			print_r($stmt->errorInfo());
		echo "</pre>";
	}

}
?>
