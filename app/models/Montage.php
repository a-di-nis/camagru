<?php

class Montage {

	private $db;

	public function __construct() {
		$this->db = new Database();
	}

	public function getMontage($id) {
		// Get one montage with the id $id with the associated user infos
		$this->db->query('SELECT montages.id as montageId,
						montages.user_id as montageUserId,
						montages.filename as montageFilename,
						montages.created_at as montageCreatedAt,
						users.id as userId,
						users.name as userName,
						users.email as userEmail
						FROM montages
						INNER JOIN users
						ON montages.user_id = users.id
						WHERE montages.id = :id');
		$this->db->bind(':id', $id);
		$row = $this->db->single();
		if ($this->db->rowCount() > 0) {
			return $row;
		}
		else {
			return null;
		}
	}
	
	public function getMontages() {
		$this->db->query('SELECT
						montages.id as montageId,
						montages.created_at as montageCreatedAt,
						montages.filename as montageFilename,
						users.id as userId,
						users.name as userName
						FROM montages
						INNER JOIN users 
						ON montages.user_id = users.id
						ORDER BY montages.created_at DESC
						');
		$results = $this->db->resultSet();
		return $results;
	}

	public function getMontagesWithUser($userId) {
		$this->db->query('SELECT
						montages.id as montageId,
						montages.created_at as montageCreatedAt,
						montages.filename as montageFilename,
						users.id as userId,
						users.name as userName
						FROM montages
						INNER JOIN users
						ON montages.user_id = users.id
						WHERE users.id = :userId
						ORDER BY montages.created_at DESC
						');
		$this->db->bind(':userId', $userId);
		$results = $this->db->resultSet();
		return $results;

	}

	public function addMontage($target_name) {
		$this->db->query('INSERT INTO montages(user_id, filename) VALUES (:user_id, :filename)');
		$this->db->bind(':user_id', $_SESSION['user_id']);
		$this->db->bind(':filename', $target_name);
		if ($this->db->execute()) {
			return true;
		}
		else {
			return false;
		}// do I check if it's true or false?
	}

	public function deleteMontage($id) {
		$this->db->query('DELETE FROM montages WHERE id = :id');
		$this->db->bind(':id', $id);
		if ($this->db->execute()) {
        	return true;
      	}
     	 else {
        	return false;
		}
	}
}