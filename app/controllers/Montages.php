<?php

class Montages extends Controller {

	public function __construct() {
		$this->montageModel = $this->model('Montage');
		$this->userModel = $this->model('User');
		$this->commentModel = $this->model('Comment');
		$this->likeModel = $this->model('Like');

		if (isset($_SESSION['user_id'])) {
			if ($this->userModel->searchById($_SESSION['user_id']) == null) {
				unset($_SESSION['user_id']);
			}
		}
	}

	public function index($montage_id = NULL) {
		// Specific montage
		if ($montage_id !== NULL) {

			$montage = $this->montageModel->getMontage($montage_id); // Get montage from the id
			if ($montage === NULL) {
				redirect('montages/index');
			}

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				// ADD COMMENT

				// Check if user is logged in
				if (!isset($_SESSION['user_id'])) {
					flash_store("You must be logged in to send a comment.");
					redirect('users/login');
				}

				$comment = htmlentities($_POST['comment']);
				if ($this->commentModel->addComment($comment, $_SESSION['user_id'], $montage_id)) {
					// Comment added successfuly

					// Notification to owner of montage
					$owner = $this->userModel->searchById($montage->userId);
					if ($owner->accept_notifications == 1) {
						$currentUser = $this->userModel->searchById($_SESSION['user_id']);
						sendEmail($montage->userEmail, "New comment on your montage", $currentUser->name . " left a comment on your montage!<br/><br/>" . $comment . "<br/><br/>Reply at http://localhost:8080/montages/" . $montage_id);	
					}

					// Redirect to the montage
					flash_store('Comment added');
					redirect('montages', $montage_id);
				}
				else {
					flash_store('Something went wrong');
					redirect('montages', $montage_id);
				}
			}
			else {
				// DISPLAY PAGE
				$comments = $this->commentModel->getCommentsFromMontage($montage_id);

				$alreadyLiked = false;
				if (array_key_exists('user_id', $_SESSION)) {
					$alreadyLiked = $this->likeModel->alreadyLiked($_SESSION['user_id'], $montage->montageId);
				}
				$data = [
					'montage' => $montage,
					'comments' => $comments,
					'alreadyLiked' => $alreadyLiked
				];
				$this->view('montages/montage', $data);
			}
		}
		// Gallery
		else {
			$montages = $this->montageModel->getMontages();   
			$data = [
				'montages' => []
			];

			$page = 1;
			$i = 0;
			$count = 0;

			while ($i < sizeof($montages)) {
				$data['montages'][$page][$i] = $montages[$i];
				$count++;
				if ($count == 5) {
					$count = 0;
					$page++;
				}
				$i++;
			}
			$this->view('montages/index', $data);
		}
	}

	public function montagesUpload() {
		if (!isset($_SESSION['user_id'])) {
			flash_store("Sorry, but you have to login to access this page.");
			redirect('users/login');
		}
		
		$montageList = $this->montageModel->getMontagesWithUser($_SESSION['user_id']);
		//creating the data to see thumbnails of the photos on the side
		$data = [
			'montages' => $montageList
		];

		$this->view('montages/capture', $data);
	}

	public function delete($id) {
		if (!isset($_SESSION['user_id'])) {
			flash_store('You have to login to access this page.');
			redirect('users/login');
		}

		if ($montage = $this->montageModel->getMontage($id)) {

		// check if motnage is found

			if ($montage->userId != $_SESSION['user_id']) {
				flash_store("You don't have the rights to delete this montage.");
				echo $montage->userId . " - " . $_SESSION['user_id'];
				redirect('montages', $id);
			}
			else {
				if ($this->montageModel->deleteMontage($id)) {
					flash_store('Montage deleted');
					redirect('montages', $id);
				}
				else {
					flash_store('Error when deleting the montage');
					redirect('montages', $id);
				}
			}
		}
		else {
			flash_store("Montage doesn't exist");
			redirect('montages');
		}
	}

	public function upload() {
		if (!isset($_SESSION['user_id'])) {
			flash_store("Sorry, but you have to login to upload.");
			redirect('users/login');
		}
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$image = $_POST['image'];
			$stickers = json_decode($_POST['sticker']);

			list($type, $image) = explode(';', $image);
			list(, $type) = explode('/', $type);

			if ($type !== 'jpeg' && $type !== 'png') {
				flash_store('The uploaded image is not a jpeg or png');
				redirect('montages/montagesUpload');
			}

			list(, $image) = explode(',', $image);
			$image = base64_decode($image);

			$target_name = md5(openssl_random_pseudo_bytes(16)) . '.' . $type;
			$backImageUrl = 'photos/' . $target_name;

			file_put_contents($backImageUrl, $image);

			// Merge photo and sticker together
			list($width, $height) = getimagesize($backImageUrl);
			if ($type == 'jpeg') {
				$originalImage = imagecreatefromjpeg($backImageUrl);
			} else {
				$originalImage = imagecreatefrompng($backImageUrl);
			}
			$resizedImage = imagecreatetruecolor(1333, 1000);
			imagesavealpha($resizedImage, true);
			$color = imagecolorallocatealpha($resizedImage, 0, 0, 0, 127);
			imagefill($resizedImage, 0, 0, $color);
			imagecopyresized($resizedImage, $originalImage, 0, 0, 0, 0, 1333, 1000, $width, $height);
			imagepng($resizedImage, $backImageUrl);

			foreach ($stickers as $sticker) {
				$frontImage = imagecreatefrompng($sticker);
				$backImage = imagecreatefrompng($backImageUrl);
	
				if ($frontImage === false || $backImage === false
					|| imagecopy($backImage, $frontImage, 0, 0, 0, 0, 1333, 1000) === false
					|| imagepng($backImage, 'photos/' . $target_name) === false)
				{
					flash_store("Error when saving your montage.");
					redirect('montages/montagesUpload');
				}
			}

			$this->montageModel->addMontage($target_name);

			redirect('montages/montagesUpload');
		}

		redirect('montages/montagesUpload');
	}

	public function like($id) {
		if (!isset($_SESSION['user_id'])) {
			flash_store("Sorry, but you have to login to like a photo.");
			redirect('users/login');
		}
		if ($montage = $this->montageModel->getMontage($id)) {
			if ($this->likeModel->alreadyLiked($_SESSION['user_id'], $montage->montageId) === false) {
				if ($this->likeModel->addLike($_SESSION['user_id'], $montage->montageId)) {
					flash_store("Like added");
					redirect('montages', $id);
				}
				else {
					flash_store("Sorry, some error occured");
					redirect('montages', $id);
				}
			}
			else {
				flash_store("You've already likes this montage!");
				redirect('montages', $id);
			}
		}
		else {
			flash_store("Montage doesn't exist");
			redirect('montages');
		}
	}

	public function unlike($id) {
		if (!isset($_SESSION['user_id'])) {
			flash_store("Sorry, but you have to login to like a photo.");
			redirect('users/login');
		}
		if ($montage = $this->montageModel->getMontage($id)) {
			if ($this->likeModel->alreadyLiked($_SESSION['user_id'], $montage->montageId)) {
				if ($this->likeModel->unlike($_SESSION['user_id'], $montage->montageId)) {
					flash_store("Photo disliked");
					redirect('montages', $id);
				}
				else {
					flash_store("Sorry, some error occured");
					redirect('montages', $id);
				}
			}
			else {
				flash_store("You still didn't like the montage");
				redirect('montages', $id);
			}
		}
		else {
			flash_store("Montage doesn't exist");
			redirect('montages');
		}

	}
}