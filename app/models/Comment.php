<?php

class Comment {

	private $db;

	public function __construct() {
		$this->db = new Database();
	}

	public function addComment($comment, $user_id, $montage_id) {
		$this->db->query('INSERT INTO comments(comment, user_id, montage_id) VALUES (:comment, :user_id, :montage_id)');
		$this->db->bind(':comment', $comment);
		$this->db->bind(':user_id', $user_id);
		$this->db->bind(':montage_id', $montage_id);
		if ($this->db->execute()) {
			return true;
		}
		else {
			return false;
		}

	}

	public function getCommentsFromMontage($montage_id) {
		$this->db->query('SELECT * FROM comments WHERE montage_id = :montage_id');
		$this->db->bind(':montage_id', $montage_id);
		$rows = $this->db->resultSet();
		return $rows;
	}
}