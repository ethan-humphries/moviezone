<?php
/*-------------------------------------------------------------------------------------------------
@Modified by: Ethan Humphries
@Date: 19/04/2019
--------------------------------------------------------------------------------------------------*/
require_once('moviezone_admin_config.php'); 

class MoviesModel {
	private $error;
	private $dbAdapter;
	
	public function __construct() {
		$this->dbAdapter = new DBAdaper(DB_CONNECTION_STRING, DB_USER, DB_PASS);
		$this->dbAdapter->dbOpen();
		$this->dbAdapter->dbCreate();
		$this->dbAdapter->dbClose();
		
	}
	
	public function __destruct() {
		$this->dbAdapter->dbClose();
	}
	
	public function getError() {
		return $this->error;
	}

	/* Authenticates the admin user.	   
	*/
	public function adminLogin($user) {
		//for now we simply accept anyone with webdev2 password
		if ($user['password'] == 'webdev2') {
			$this->error = 'ERR_SUCCESS';			
			return true;
		} else {
			$this->error = 'ERR_AUTHENTICATION';
			return false;
		}
	}

	public function editMember($condition) {
		$this->dbAdapter->dbOpen();
		$result = $this->dbAdapter->editMember($condition);
		$this->dbAdapter->dbClose();
		$this->error = $this->dbAdapter->lastError();
		
		return $result;
	}

	public function editMovie($condition) {
		$this->dbAdapter->dbOpen();
		$result = $this->dbAdapter->editMovie($condition);
		$this->dbAdapter->dbClose();
		$this->error = $this->dbAdapter->lastError();
		
		return $result;
	}

	public function deleteById($condition) {
		$this->error = null; //reset the error first
		$this->dbAdapter->dbOpen();
		$result = $this->dbAdapter->deleteById($condition);
		$this->dbAdapter->dbClose();
		if ($result == false)
			$this->error = $this->dbAdapter->lastError();
		return $result;
	}	
	
	public function selectActors() {
		$this->dbAdapter->dbOpen();
		$result = $this->dbAdapter->selectActors();
		$this->dbAdapter->dbClose();
		$this->error = $this->dbAdapter->lastError();
		
		return $result;
	}	

	public function getStockReport(){
		$this->dbAdapter->dbOpen();
		$result = $this->dbAdapter->getStockReport();
		$this->dbAdapter->dbClose();
		$this->error = $this->dbAdapter->lastError();
		
		return $result;
	}
	
	public function selectAllMovies() {
		$this->dbAdapter->dbOpen();
		$result = $this->dbAdapter->moviesSelectAll();
		$this->dbAdapter->dbClose();
		$this->error = $this->dbAdapter->lastError();
		
		return $result;
	}

	public function selectAllMembers() {
		$this->dbAdapter->dbOpen();
		$result = $this->dbAdapter->selectMembers();
		$this->dbAdapter->dbClose();
		$this->error = $this->dbAdapter->lastError();
		
		return $result;
	}

	public function selectMovies() {
		$this->dbAdapter->dbOpen();
		$result = $this->dbAdapter->selectMovies();
		$this->dbAdapter->dbClose();
		$this->error = $this->dbAdapter->lastError();
		
		return $result;
	}

	public function getMemberById($condition) {
		$this->error = null; //reset the error first
		$this->dbAdapter->dbOpen();
		$result = $this->dbAdapter->getMemberById($condition);
		$this->dbAdapter->dbClose();
		if ($result == null)
			$this->error = $this->dbAdapter->lastError();
		
		return $result;
	}	

	public function getMovieById($condition) {
		$this->error = null; //reset the error first
		$this->dbAdapter->dbOpen();
		$result = $this->dbAdapter->getMovieById($condition);
		$this->dbAdapter->dbClose();
		if ($result == null)
			$this->error = $this->dbAdapter->lastError();
		
		return $result;
	}	
}
?>