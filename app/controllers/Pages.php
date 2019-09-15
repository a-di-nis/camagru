<?php

class Pages extends Controller {

	public function __construct() {
		$this->userModel = $this->model('User');

		if (isset($_SESSION['user_id'])) {
			if ($this->userModel->searchById($_SESSION['user_id']) == null) {
				unset($_SESSION['user_id']);
			}
		}
	}

	public function index() {

		$data = [
			'title' => 'Camagru',
			'description' => 'Have fun adding stickers to your photos!'
		];

		$this->view('pages/index', $data);
	}
}