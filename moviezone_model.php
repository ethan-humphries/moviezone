<?php
/*-------------------------------------------------------------------------------------------------
@Modified by: Ethan Humphries
@Date: 19/04/2019
--------------------------------------------------------------------------------------------------*/
require_once('moviezone_config.php'); 

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
	
	public function selectAllMovies() {
		$this->dbAdapter->dbOpen();
		$result = $this->dbAdapter->moviesSelectAll();
		$this->dbAdapter->dbClose();
		$this->error = $this->dbAdapter->lastError();
		
		return $result;
	}

	public function selectNewReleaseMovies() {
		$this->dbAdapter->dbOpen();
		$result = $this->dbAdapter->moviesSelectNewRelease();
		$this->dbAdapter->dbClose();
		$this->error = $this->dbAdapter->lastError();
		return $result;
	}
	
	public function filterMovies($condition) {
		$this->dbAdapter->dbOpen();
		$result = $this->dbAdapter->movieFilter($condition);
		$this->dbAdapter->dbClose();
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
	
	public function selectDirectors() {
		$this->dbAdapter->dbOpen();
		$result = $this->dbAdapter->selectDirectors();
		$this->dbAdapter->dbClose();
		$this->error = $this->dbAdapter->lastError();
		
		return $result;
	}

	public function selectGenres() {
		$this->dbAdapter->dbOpen();
		$result = $this->dbAdapter->selectGenres();
		$this->dbAdapter->dbClose();
		$this->error = $this->dbAdapter->lastError();
		
		return $result;
	}

	public function selectClassifications() {
		$this->dbAdapter->dbOpen();
		$result = $this->dbAdapter->selectClassifications();
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

	public function logIn($username, $password) {
		$this->dbAdapter->dbOpen();
		$result = $this->dbAdapter->logIn($username, $password);
		$this->dbAdapter->dbClose();
		$this->error = $this->dbAdapter->lastError();
		
		return $result;
	}
}
?>