<?php

class User {

	private $db;

	public function __construct() {
		$this->db = new Database();
	}

	public function register($data){
		$this->db->query('INSERT INTO users(name, email, password, token) VALUES (:name, :email, :password, :token)');
		$this->db->bind(':name', $data['name']);
		$this->db->bind(':email', $data['email']);
		$this->db->bind(':password', $data['password']);
		$this->db->bind(':token', $data['token']);
		if ($this->db->execute()) {
			return true;
		}
		else {
			return false;
		}
	}

	public function searchById($id) {
		$this->db->query('SELECT * FROM users WHERE id = :id');
		$this->db->bind(':id', $id);
		$row = $this->db->single();
		if ($this->db->rowCount() > 0) {
			return $row;
		}
		else {
			return null;
		}
	}

	public function searchByEmail($email) {
		$this->db->query('SELECT * FROM users WHERE email = :email');
		$this->db->bind(':email', $email);
		$row = $this->db->single();
		if ($this->db->rowCount() > 0) {
			return $row;
		}
		else {
			return null;
		}
	}

	public function searchByUsername($username) {
		$this->db->query('SELECT * FROM users WHERE name = :name');
		$this->db->bind(':name', $username);
		$row = $this->db->single();
		if ($this->db->rowCount() > 0) {
			return $row;
		}
		else {
			return null;
		}
	}


	public function searchByToken($token) {
		$this->db->query('SELECT * FROM users WHERE token = :token');
		$this->db->bind(':token', $token);
		$row = $this->db->single();
		if ($this->db->rowCount() > 0) {
			return $row;
		}
		else {
			return null;
		}
	}

	public function addTokenTwo($token_two, $id) {
		$this->db->query('UPDATE users SET token_two = :token_two WHERE id = :id');
		$this->db->bind(':token_two', $token_two);
		$this->db->bind(':id', $id);
		if ($this->db->execute()) {
			return true;
		}
		else {
			return false;
		}
	}

	public function searchByTokenTwo($token_two) {
		$this->db->query('SELECT * FROM users WHERE token_two = :token_two');
		$this->db->bind(':token_two', $token_two);
		$row = $this->db->single();
		if ($this->db->rowCount() > 0)
		{
			return $row;
		}
		else
		{
			return null;
		}
	}

	public function validateUser($id) {
		$this->db->query('UPDATE users SET verified = 1 WHERE id = :id');
		$this->db->bind(':id', $id);
		$this->db->execute();
	}

	public function newPassword($token_two, $password) {
		$this->db->query('UPDATE users SET password = :password WHERE token_two = :token_two');
		$this->db->bind(':token_two', $token_two);
		$this->db->bind(':password', $password);
		if ($this->db->execute()) {
			return true;
		}
		else {
			return false;
		}
	}

	public function modifyPassword($password, $id) {
		$this->db->query('UPDATE users SET password = :password WHERE id = :id');
		$this->db->bind(':id', $id);
		$this->db->bind(':password', $password);
		if ($this->db->execute()) {
			return true;
		}
		else {
			return false;
		}
	}

	public function modifyUsername($username, $id) {
		$this->db->query('UPDATE users SET name = :name WHERE id = :id');
		$this->db->bind(':id', $id);
		$this->db->bind(':name', $username);
		if ($this->db->execute()) {
			return true;
		}
		else {
			return false;
		}
	}

	public function modifyEmail($email, $id) {
		$this->db->query('UPDATE users SET email = :email WHERE id = :id');
		$this->db->bind(':id', $id);
		$this->db->bind(':email', $email);
		if ($this->db->execute()) {
			return true;
		}
		else {
			return false;
		}
	}

	public function modifyAcceptNotification($notifications, $id) {
		// $notValue = ($notifications) ? 1 : 0;
		$this->db->query('UPDATE users SET accept_notifications = :notifications WHERE id = :id');
		$this->db->bind(':id', $id);
		$this->db->bind(':notifications', $notifications);
		if ($this->db->execute()) {
			return true;
		}
		else {
			return false;
		}	
	}

	public function login($email, $password) {

		$this->db->query('SELECT * FROM users WHERE email = :email');
		$this->db->bind(':email', $email);
		$row = $this->db->single();
		$hashed_pass = $row->password;
		if (password_verify($password, $hashed_pass)) {
			return $row;
		}
		else {
			return false; 
		}
	}

	public function loginId($id, $password) {

		$this->db->query('SELECT * FROM users WHERE id = :id');
		$this->db->bind(':id', $id);
		$row = $this->db->single();
		$hashed_pass = $row->password;
		if (password_verify($password, $hashed_pass)) {
			return $row;
		}
		else {
			return false;
		}
	}
}