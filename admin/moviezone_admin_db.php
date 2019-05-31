<?php
/*dbAdapter: this module acts as the database abstraction layer for the application
@Modified by: Ethan Humphries
@Date: 19/04/2019
*/

/*Connection paramaters
*/
require_once('moviezone_admin_config.php'); 

/* DBAdpater class performs all required CRUD functions for the application
*/
class DBAdaper {
	/*local variables
	*/	
	private $dbConnectionString;
	private $dbUser;
	private $dbPassword;
	private $dbConn; //holds connection object
	private $dbError; //holds last error message
	
	/* The class constructor
	*/	
	public function __construct($dbConnectionString, $dbUser, $dbPassword) {
		$this->dbConnectionString = $dbConnectionString;
		$this->dbUser = $dbUser;
		$this->dbPassword = $dbPassword;
	}	
	/*Opens connection to the database
	*/
	public function dbOpen() {
		try {
			$this->dbConn = new PDO($this->dbConnectionString, $this->dbUser, $this->dbPassword);
			// set the PDO error mode to exception
			$this->dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->dbError = null;
		}
		catch(PDOException $e) {
			$this->dbError = $e->getMessage();
			$this->dbConn = null;
		}
	}
	/*Closes connection to the database
	*/
	public function dbClose() {
		//in PDO assigning null to the connection object closes the connection
		$this->dbConn = null;
	}
	/*Return last database error
	*/
	public function lastError() {
		return $this->dbError;
	}
	/*Creates required tables in the database if not already created
	  @return: TRUE if successful and FALSE otherwise
	*/
	public function dbCreate() {

	}
	
	/*------------------------------------------------------------------------------------------- 
                              DATABASE MANIPULATION FUNCTIONS
	-------------------------------------------------------------------------------------------*/

	/*Helper function:
	Build SQL AND conditional clause from the array of condition paramaters
	*/

	public function editMember($condition) {
		$member_id = $condition['member_id'];
		$surname = $condition['surname'];
		$other_name = $condition['other_name'];
		$password = $condition['password'];
		$occupation = $condition['occupation'];
		$contact_method = $condition['contact_method'];
		$email = $condition['email'];
		$mobile = $condition['mobile'];
		$landline = $condition['landline'];

		$result = null;
		$this->dbError = null; //reset the error message before any execution
		if ($this->dbConn != null) {		
			try {
				//Make a prepared query so that we can use data binding and avoid SQL injections. 
				//(modify suit the A2 member table)
				$smt = $this->dbConn->prepare(
					"UPDATE member SET 
					surname = '$surname',
					other_name = '$other_name',
					password  = '$password',
					occupation = '$occupation',
					contact_method = '$contact_method',
					email = '$email',
					mobile = '$mobile',
					landline = '$landline'
					WHERE member_id = '$member_id' ");							  				
				//Execute the query
				$smt->execute();
				$result = $smt->fetchAll(PDO::FETCH_ASSOC);	
				//use PDO::FETCH_BOTH to have both column name and column index
				//$result = $sql->fetchAll(PDO::FETCH_BOTH);
			}catch (PDOException $e) {
				//Return the error message to the caller
				$this->dbError = $e->getMessage();
				$result = null;
			}
		} else {
			$this->dbError = MSG_ERR_CONNECTION;
		}
		return $result;		
	}

	public function editMovie($condition) {
		$movie_id =	$condition['movie_id'];
		$DVD_rental_price =	$condition['DVD_rental_price'];
		$DVD_purchase_price =	$condition['DVD_purchase_price'];
		$numDVD =	$condition['numDVD'];
		$BluRay_rental_price =	$condition['BluRay_rental_price'];
		$BluRay_purchase_price =	$condition['BluRay_purchase_price'];
		$numBluRay =	$condition['numBluRay'];

		$result = null;
		$this->dbError = null; //reset the error message before any execution
		if ($this->dbConn != null) {		
			try {
				//Make a prepared query so that we can use data binding and avoid SQL injections. 
				//(modify suit the A2 member table)
				$smt = $this->dbConn->prepare(
					"UPDATE movie SET DVD_rental_price = '$DVD_rental_price', DVD_purchase_price = '$DVD_purchase_price',
					numDVD = '$numDVD', BluRay_rental_price = '$BluRay_rental_price',
					BluRay_purchase_price = '$BluRay_purchase_price', numBluRay = '$numBluRay'
					WHERE movie_id = '$movie_id';");							  				
				//Execute the query
				$smt->execute();
				$result = $smt->fetchAll(PDO::FETCH_ASSOC);	
				//use PDO::FETCH_BOTH to have both column name and column index
				//$result = $sql->fetchAll(PDO::FETCH_BOTH);
			}catch (PDOException $e) {
				//Return the error message to the caller
				$this->dbError = $e->getMessage();
				$result = null;
			}
		} else {
			$this->dbError = MSG_ERR_CONNECTION;
		}
		return $result;		
	}


	protected function sqlBuildConditionalClause($params, $condition) {
		$clause = "";
		$and = false; //so we know when to add AND in the sql statement	
		if ($params != null) {
			foreach ($params as $key => $value) {
				$op = '='; //comparison operator
				if (!empty($value)) {
					if ($and){
						$clause = $clause." $condition $key $op '$value'";
					} else {
						//the first AND condition
						$clause = "WHERE $key $op '$value'";
						$and = true;
					}			
				}
			}
		}
		
		return $clause;
	}

	public function selectActors() {
		$result = null;
		$this->dbError = null; //reset the error message before any execution
		if ($this->dbConn != null) {		
			try {
				//Make a prepared query so that we can use data binding and avoid SQL injections. 
				//(modify suit the A2 member table)
				$smt = $this->dbConn->prepare(
					'SELECT Distinct actor_name FROM movie_actor_view');							  				
				//Execute the query
				$smt->execute();
				$result = $smt->fetchAll(PDO::FETCH_ASSOC);	
				//use PDO::FETCH_BOTH to have both column name and column index
				//$result = $sql->fetchAll(PDO::FETCH_BOTH);
			}catch (PDOException $e) {
				//Return the error message to the caller
				$this->dbError = $e->getMessage();
				$result = null;
			}
		} else {
			$this->dbError = MSG_ERR_CONNECTION;
		}
		return $result;			
	}
	
	public function moviesSelectAll() {
		$result = null;
		$this->dbError = null; //reset the error message before any execution
		if ($this->dbConn != null) {		
			try {
				//Make a prepared query so that we can use data binding and avoid SQL injections. 
				//(modify suit the A2 member table)
				$smt = $this->dbConn->prepare(
					'SELECT * FROM movie_detail_view');							  				
				//Execute the query
				$smt->execute();
				$result = $smt->fetchAll(PDO::FETCH_ASSOC);	
				//use PDO::FETCH_BOTH to have both column name and column index
				//$result = $sql->fetchAll(PDO::FETCH_BOTH);
			}catch (PDOException $e) {
				//Return the error message to the caller
				$this->dbError = $e->getMessage();
				$result = null;
			}
		} else {
			$this->dbError = MSG_ERR_CONNECTION;
		}
	
		return $result;			
	}


	public function getMemberById($condition) {
		$result = null;
		$this->dbError = null; //reset the error message before any execution
		if ($this->dbConn != null) {		
			try {
				//Make a prepared query so that we can use data binding and avoid SQL injections. 
				//(modify suit the A2 member table)
				// $sql = 'SELECT * FROM member'
				// .$this->sqlBuildConditionalClause($condition, 'and');
				// $smt = $this->dbConn->prepare($sql);
				$smt = $this->dbConn->prepare(
					"SELECT * FROM member WHERE member_id = ".$condition['member_id']."");	
												  
				//Execute the query
				$smt->execute();
				$result = $smt->fetchAll(PDO::FETCH_ASSOC);	
				//use PDO::FETCH_BOTH to have both column name and column index
				//$result = $sql->fetchAll(PDO::FETCH_BOTH);
			}catch (PDOException $e) {
				//Return the error message to the caller
				$this->dbError = $e->getMessage();
				$result = null;
			}
		} else {
			$this->dbError = MSG_ERR_CONNECTION;
		}
	
		return $result;		
	}	

	public function getMovieById($condition) {
		$result = null;
		$this->dbError = null; //reset the error message before any execution
		if ($this->dbConn != null) {		
			try {
				//Make a prepared query so that we can use data binding and avoid SQL injections. 
				//(modify suit the A2 member table)
				// $sql = 'SELECT * FROM member'
				// .$this->sqlBuildConditionalClause($condition, 'and');
				// $smt = $this->dbConn->prepare($sql);
				$smt = $this->dbConn->prepare(
					"SELECT * FROM movie WHERE movie_id = ".$condition['movie_id']."");	
												  
				//Execute the query
				$smt->execute();
				$result = $smt->fetchAll(PDO::FETCH_ASSOC);	
				//use PDO::FETCH_BOTH to have both column name and column index
				//$result = $sql->fetchAll(PDO::FETCH_BOTH);
			}catch (PDOException $e) {
				//Return the error message to the caller
				$this->dbError = $e->getMessage();
				$result = null;
			}
		} else {
			$this->dbError = MSG_ERR_CONNECTION;
		}
	
		return $result;		
	}	

	public function selectDirectors() {
		$result = null;
		$this->dbError = null; //reset the error message before any execution
		if ($this->dbConn != null) {		
			try {
				//Make a prepared query so that we can use data binding and avoid SQL injections. 
				//(modify suit the A2 member table)
				$smt = $this->dbConn->prepare(
					'SELECT Distinct director FROM movie_detail_view');							  				
				//Execute the query
				$smt->execute();
				$result = $smt->fetchAll(PDO::FETCH_ASSOC);	
				//use PDO::FETCH_BOTH to have both column name and column index
				//$result = $sql->fetchAll(PDO::FETCH_BOTH);
			}catch (PDOException $e) {
				//Return the error message to the caller
				$this->dbError = $e->getMessage();
				$result = null;
			}
		} else {
			$this->dbError = MSG_ERR_CONNECTION;
		}
		return $result;			
	}

	public function selectMovies() {
		$result = null;
		$this->dbError = null; //reset the error message before any execution
		if ($this->dbConn != null) {		
			try {
				//Make a prepared query so that we can use data binding and avoid SQL injections. 
				//(modify suit the A2 member table)
				$smt = $this->dbConn->prepare(
					'SELECT * FROM movie');							  				
				//Execute the query
				$smt->execute();
				$result = $smt->fetchAll(PDO::FETCH_ASSOC);	
				//use PDO::FETCH_BOTH to have both column name and column index
				//$result = $sql->fetchAll(PDO::FETCH_BOTH);
			}catch (PDOException $e) {
				//Return the error message to the caller
				$this->dbError = $e->getMessage();
				$result = null;
			}
		} else {
			$this->dbError = MSG_ERR_CONNECTION;
		}
		return $result;			
	}

	public function selectMembers() {
		$result = null;
		$this->dbError = null; //reset the error message before any execution
		if ($this->dbConn != null) {		
			try {
				//Make a prepared query so that we can use data binding and avoid SQL injections. 
				//(modify suit the A2 member table)
				$smt = $this->dbConn->prepare(
					'SELECT * FROM member');							  				
				//Execute the query
				$smt->execute();
				$result = $smt->fetchAll(PDO::FETCH_ASSOC);	
				//use PDO::FETCH_BOTH to have both column name and column index
				//$result = $sql->fetchAll(PDO::FETCH_BOTH);
			}catch (PDOException $e) {
				//Return the error message to the caller
				$this->dbError = $e->getMessage();
				$result = null;
			}
		} else {
			$this->dbError = MSG_ERR_CONNECTION;
		}
		return $result;		
	}

	public function getStockReport() {
		$result = null;
		$this->dbError = null; //reset the error message before any execution
		if ($this->dbConn != null) {		
			try {
				//Make a prepared query so that we can use data binding and avoid SQL injections. 
				//(modify suit the A2 member table)
				$smt = $this->dbConn->prepare(
					'SELECT * FROM movie_stock_view');							  				
				//Execute the query
				$smt->execute();
				$result = $smt->fetchAll(PDO::FETCH_ASSOC);	
				//use PDO::FETCH_BOTH to have both column name and column index
				//$result = $sql->fetchAll(PDO::FETCH_BOTH);
			}catch (PDOException $e) {
				//Return the error message to the caller
				$this->dbError = $e->getMessage();
				$result = null;
			}
		} else {
			$this->dbError = MSG_ERR_CONNECTION;
		}
		return $result;		
	}

	public function deleteById($condition) {
		$table_name = '';
		$delete_id = '';
		$column_name = '';

		if(!empty($condition['member_id'])) {
			$delete_id  = $condition['member_id'];
			$table_name = 'member';
			$column_name = 'member_id';
		} else if (!empty($condition['movie_id'])) {
			$delete_id  = $condition['movie_id'];
			$table_name = 'movie';
			$column_name = 'movie_id';
		}

		$result = null;
		$this->dbError = null; //reset the error message before any execution
		if ($this->dbConn != null) {		
			try {
				//Make a prepared query so that we can use data binding and avoid SQL injections. 
				//(modify suit the A2 member table)
				// $sql = 'SELECT * FROM member'
				// .$this->sqlBuildConditionalClause($condition, 'and');
				// $smt = $this->dbConn->prepare($sql);
				$smt = $this->dbConn->prepare(
					"DELETE FROM $table_name WHERE $column_name = $delete_id ");							  
				//Execute the query
				$smt->execute();
				$result = $smt->fetchAll(PDO::FETCH_ASSOC);	
				//use PDO::FETCH_BOTH to have both column name and column index
				//$result = $sql->fetchAll(PDO::FETCH_BOTH);
			}catch (PDOException $e) {
				//Return the error message to the caller
				$this->dbError = $e->getMessage();
				$result = null;
			}
		} else {
			$this->dbError = MSG_ERR_CONNECTION;
		}
		return $result;		
	}	


	public function logIn($username, $password) {
		$result = null;
		$this->dbError = null; //reset the error message before any execution
		if ($this->dbConn != null) {		
			try {
				//Make a prepared query so that we can use data binding and avoid SQL injections. 
				//(modify suit the A2 member table)
				$smt = $this->dbConn->prepare(
					"SELECT username, password From member where username = '$username' and password = '$password'");							  				
				//Execute the query
				$smt->execute();
				$result = $smt->fetchAll(PDO::FETCH_ASSOC);	
				//use PDO::FETCH_BOTH to have both column name and column index
				//$result = $sql->fetchAll(PDO::FETCH_BOTH);
			}catch (PDOException $e) {
				//Return the error message to the caller
				$this->dbError = $e->getMessage();
				$result = null;
			}
		} else {
			$this->dbError = MSG_ERR_CONNECTION;
		}
		return $result;		
	}

}
/*---------------------------------------------------------------------------------------------- 
                                         TEST FUNCTIONS
 ----------------------------------------------------------------------------------------------*/
//Tests database functions

    function testDBA() {

    }
    //testDBA();
?>