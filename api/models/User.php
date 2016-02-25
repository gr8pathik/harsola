<?php

/**
 * This is an example of User Class using PDO
 *
 */

namespace models;
use lib\Core;
use PDO;

class User {

	protected $core;

	function __construct() {
		$this->core = Core::getInstance();
		//$this->core->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	
	// Get all users
	public function getUsers() {
		$r = array();		

		$sql = "SELECT * FROM users";
		$stmt = $this->core->dbh->prepare($sql);
		//$stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

		if ($stmt->execute()) {
			$r = $stmt->fetchAll(PDO::FETCH_ASSOC);		   	
		} else {
			$r = 0;
		}		
		return $r;
	}

	// Get user by the Id
	public function getUserById($id) {
		$r = array();		
		
		$sql = "SELECT nombre * evnt_usuario WHERE id=$id";
		$stmt = $this->core->dbh->prepare($sql);
		//$stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

		if ($stmt->execute()) {
			$r = $stmt->fetchAll(PDO::FETCH_ASSOC);		   	
		} else {
			$r = 0;
		}		
		return $r;
	}

	// Get user by the Id
	public function checkUniqueUser($email, $phoneNumber) {
		$r = array();		
		
		$sql = "SELECT id from users WHERE email=:email AND phoneNumber=:phoneNumber";
		$stmt = $this->core->dbh->prepare($sql);
		//$stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
		$stmt->bindParam(':email', $email, PDO::PARAM_STR);
		$stmt->bindParam(':phoneNumber', $phoneNumber, PDO::PARAM_STR);

		if ($stmt->execute()) {
			$r = $stmt->fetchAll(PDO::FETCH_ASSOC);		   	
		} else {
			$r = 0;
		}		
		return $r;
	}

	// Get user by the Login
	public function getUserByLogin($email, $pass) {
		$r = array();		
		
		$sql = "SELECT * FROM user WHERE email=:email AND password=:pass";		
		$stmt = $this->core->dbh->prepare($sql);
		$stmt->bindParam(':email', $email, PDO::PARAM_STR);
		$stmt->bindParam(':pass', $pass, PDO::PARAM_STR);

		if ($stmt->execute()) {
			$r = $stmt->fetchAll(PDO::FETCH_ASSOC);		   	
		} else {
			$r = 0;
		}		
		return $r;
	}

	// Insert a new user
	public function insertUser($data) {
		try {
			$sql = "INSERT INTO users (email, phoneNumber, firstName, middleName, lastName, image, information, bloodGroup, age, hobbies, occupation, maritalStatus, dateOfBirth, anniversaryDate, fathersName) 
					VALUES (:email, :phoneNumber, :firstName, :middleName, :lastName, :image, :information, :bloodGroup, :age, :hobbies, :occupation, :maritalStatus, :dateOfBirth, :anniversaryDate, :fathersName)";
			$stmt = $this->core->dbh->prepare($sql);
			if ($stmt->execute($data)) {
				return $this->core->dbh->lastInsertId();;
			} else {
				return '0';
			}
		} catch(PDOException $e) {
        	return $e->getMessage();
    	}
		
	}

	// Update the data of an user
	public function updateUser($data) {
		
	}

	// Delete user
	public function deleteUser($id) {
		
	}

}