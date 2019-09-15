<?php

class Like {

	private $db;

	public function __construct() {
		$this->db = new Database();
	}

	public function addLike($user_id, $montage_id) {
		$this->db->query('INSERT INTO likes(user_id, montage_id) VALUES (:user_id, :montage_id)');
		$this->db->bind(':user_id', $user_id);
		$this->db->bind(':montage_id', $montage_id);
		if ($this->db->execute()) {
			return true;
		}
		else {
			return false;
		}
	}

	public function alreadyLiked($user_id, $montage_id) {
		$this->db->query('SELECT * FROM likes WHERE user_id = :user_id AND montage_id = :montage_id');
		$this->db->bind(':user_id', $user_id);
		$this->db->bind(':montage_id', $montage_id);
		$row = $this->db->resultSet();
		if ($this->db->rowCount() > 0) {
			return true;
		}
		else {
			return false;
		}
	}

	public function countLikes($montage_id) {
		$this->db->query('SELECT * FROM likes WHERE montage_id = :montage_id');
		$this->db->bind(':montage_id', $montage_id);
		$row = $this->db->resultSet();
		$count = $this->db->rowCount();
		return $count;
	}

	public function unlike($user_id, $montage_id) {
		$this->db->query('DELETE FROM likes WHERE montage_id = :montage_id AND user_id = :user_id');
		$this->db->bind(':user_id', $user_id);
		$this->db->bind(':montage_id', $montage_id);
		if ($this->db->execute()) {
			return true;
		}
		else {
			return false;
		}
	}
}