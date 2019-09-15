<?php

require_once (APPROOT . "/helpers/url_helper.php");

class Users extends Controller {
	public function __construct() {
		$this->userModel = $this->model('User');

		if (isset($_SESSION['user_id'])) {
			if ($this->userModel->searchById($_SESSION['user_id']) == null) {
				unset($_SESSION['user_id']);
			}
		}
	}

	public function register() {
      	// Check for POST
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        	// Process form

        	// Sanitize POST data
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        	// Init data
			$data = [
				'name' => htmlentities(trim($_POST['name'])),
				'email' => trim($_POST['email']),
				'password' => trim($_POST['password']),
				'confirm_password' => trim($_POST['confirm_password']),
				'token' => bin2hex(openssl_random_pseudo_bytes(32)),
				'verified' => false,
				'name_err' => '',
				'email_err' => '',
				'password_err' => '',
				'confirm_password_err' => '',
				'token_err' => ''
			];


       		// Validate Email
			if (empty($data['email'])) {
				$data['email_err'] = 'Please enter email';
			}
			else {
          		// Check email
				if ($this->userModel->searchByEmail($data['email']) !== null) {
					$data['email_err'] = 'Email is already taken';
				}
			}

			if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
 				 $data['email_err'] = "Invalid email format"; 
			}

        	// Validate name
			if (empty($data['name'])) {
				$data['name_err'] = 'Please enter name';
			}
			else {
				if ($this->userModel->searchByUsername($data['name']) !== null) {
					$data['name_err'] = 'Username is already taken';
				}
			}

			if (strlen($data['name']) < 3) {
				$data['name_err'] = 'Username must be at least 3 characters long';
			}

        	// Validate Password
			if (empty($data['password'])) {
				$data['password_err'] = 'Please enter password';
			}
			elseif (strlen($data['password']) < 6) {
				$data['password_err'] = 'Password must be at least 6 characters long';
			}
			elseif (!preg_match('/[A-Z]/', $data['password']) || !preg_match('/[a-z]/', $data['password']) || !preg_match('/[0-9]/', $data['password'])) {

				$data['password_err'] = 'Password must include at least 1 uppercase, 1 lowercase and 1 digit';
			}

        	// Validate Confirm Password
			if (empty($data['confirm_password'])) {
				$data['confirm_password_err'] = 'Please confirm password';
			}
			else {
				if ($data['password'] != $data['confirm_password']) {
					$data['confirm_password_err'] = 'Passwords do not match';
				}
			}

        	// Make sure errors are empty
			if (empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err']) && empty($data['token_err'])) {
		        // Validated
        		// Hash Password
				$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

				// Before adding the account to the database
				$message = '
				<html xmlns="http://www.w3.org/1999/xhtml">
					<head>
						<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
						<title>Demystifying Email Design</title>
						<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
					</head>
					<body>
						Thanks for signing up, ' . $data['name']. '!<br/>
						Your account has been created, please click on the link below to activate your it.
						<br/><br/>
						<a href="http://localhost:8080/users/validate/' . $data['token'] . '">Validation link</a> 
					</body>
				</html>';
				if (!sendEmail($data['email'], "Camagru - Verify you account", $message)) {
					// Deal with failure to send email, cancel account creato
					flash_store('Something went wrong');
					redirect('users/register');
				}
				else {
					// Register User
					if ($this->userModel->register($data)) {
						//newVerification($data);
						flash_store('A verification link has been sent to your email. Click on the link to login');
						redirect('users/login');
					} 
					else {
						flash_store('Something went wrong');
						redirect('users/register');
					}
				}
			}
			else {
          // Load view with errors
				$this->view('users/register', $data);
			}

		}
		else {
        //Init data
			$data = [
				'name' => '',
				'email' => '',
				'password' => '',
				'confirm_password' => '',
				'token_two' => '',
				'name_err' => '',
				'email_err' => '',
				'password_err' => '',
				'confirm_password_err' => '',
				'token_two_err' => ''
			];

        // Load view
			$this->view('users/register', $data);
		}
	}

	public function login() {
      // Check for POST
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        	// Process form
        	// Sanitize POST data
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        	// Init data
        	$error = 0;
			$data = [
				'email' => trim($_POST['email']),
				'password' => trim($_POST['password']),
				'email_err' => '',
				'password_err' => '',     
			];

        	// Validate Email
			if (empty($data['email'])) {
				$data['email_err'] = 'Please enter email';
				$error = 1;
			}

        	// Validate Password
			if (empty($data['password'])) {
				$data['password_err'] = 'Please enter password';
				$error = 1;
			}

			//Check for User/Email
			$user = $this->userModel->searchByEmail($data['email']);
			if ($user === null) {
				$data['email_err'] = 'No email found';
				$error = 1;
			}

			//Check for verification value
			if ($user !== null && $user->verified == 0) {
				$error = 1;
				flash_store('This user is not verified. Please click on the link sent to you by email');
			}

        	// Make sure errors are empty
			if ($error == 0) {
          		// Validated
				$loggedIn = $this->userModel->login($data['email'], $data['password']);

				if ($loggedIn) {
					$this->createUserSession($loggedIn);
				}
				else {
					$data['password_err'] = 'Wrong password';
					$this->view('users/login', $data);
				}
			} else {
          // Load view with errors
				$this->view('users/login', $data);
			}


		}
		else {
        // Init data
			$data = [    
				'email' => '',
				'password' => '',
				'email_err' => '',
				'password_err' => '',        
			];

        // Load view
			$this->view('users/login', $data);
		}
	}

	public function createUserSession($user) {
	 	$_SESSION['user_id'] = $user->id;
	 	$_SESSION['user_email'] = $user->email;
	 	$_SESSION['user_name'] = $user->name;
	 	redirect('montages');

	}

	public function logout() {
	 	unset($_SESSION['user_id']);
	 	unset($_SESSION['user_email']);
	 	unset($_SESSION['user_password']);
	 	session_destroy();
	 	redirect('users/login');
	}

	public function validate($token) {
		if (isset($token)) {
			$user = $this->userModel->searchByToken($token);
			if ($user !== null) {
				$this->userModel->validateUser($user->id);
				redirect('users/login');
			}
			else {
				redirect('');
			}

		}
		else {
			redirect('');
		}
	}

	public function newPassword($token_two) {

		// Check if user is logged in
		// if (!isset($_SESSION['user_id'])) {
		// 	flash_store("You must be logged in change the password.");
		// 	redirect('users/login');
		// }
		if (isset($token_two))
		{
			$user = $this->userModel->searchByTokenTwo($token_two);
			if ($user === null) {
				redirect('');
			}
			else
			{
				if ($_SERVER['REQUEST_METHOD'] == 'POST')
				{
					$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
					$data = [
						'password' => trim($_POST['password']),
						'token_two' => $token_two,
						'password_err' => '',
						'token_two_err' => ''
					];

					if (empty($data['password'])) {
						$data['password_err'] = 'Please enter password';
					}
					elseif (strlen($data['password']) < 6) {
						$data['password_err'] = 'Password must be at least 6 characters long';
					}
					elseif (!preg_match('/[A-Z]/', $data['password']) || !preg_match('/[a-z]/', $data['password']) || !preg_match('/[0-9]/', $data['password'])) {

						$data['password_err'] = 'Password must include at least 1 uppercase, 1 lowercase and 1 digit';
					}
					if (empty($data['password_err']) && empty($data['token_two_err'])) {
          				// Hash Password
						$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

						if ($this->userModel->newPassword($token_two, $data['password'])) {
							flash_store('Password modified');
							redirect('users/login');
						}
						else {
							flash_store('Something went wrong');
							redirect('users/newPassword');
						}
					}
					else {
						// Load view with errors
						$this->view('users/newPassword', $data);
					}
				}
				else
				{
					$data = [
						'token_two' => $token_two,
						'password_err' => ''
					];
					$this->view('users/newPassword', $data);
				}
			}
		}
		else
		{
			redirect('');
		}
	}

	public function passwordLink() {

		// Check for POST
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			// Check if user is logged in
				// if (!isset($_SESSION['user_id'])) {
				// 	flash_store("You must be logged in to send a password reset email.");
				// 	redirect('users/login');
				// }
	        // Process form

	        // Sanitize POST data
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        	// Init data
			$data = [
				'email' => trim($_POST['email']),
				'token_two' => bin2hex(openssl_random_pseudo_bytes(32)),
				'email_err' => '',
				'token_two_err' => ''
			];

        	// Validate Email
			if (empty($data['email'])) {
				$data['email_err'] = 'Please enter email';
			}
			else {
         	 // Check email
				$user = $this->userModel->searchByEmail($data['email']);
				if ($user === null) {
					$data['email_err'] = 'Email does not exist';
				}
			}

			if (empty($data['email_err']) && empty($data['token_two_err'])) {
				// Put token in database
				$this->userModel->addTokenTwo($data['token_two'], $user->id);

		      	// Send email with token
		      	$message = '
				<html xmlns="http://www.w3.org/1999/xhtml">
					<head>
						<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
						<title>Demystifying Email Design</title>
						<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
					</head>
					<body>
						Hello, ' . $_SESSION['user_id'] . '!<br/>
						You can reset your password by clicking on the url below.
						<br/><br/>
						<a href="http://localhost:8080/users/newPassword/' . $data['token_two'] . '">Reset Password</a> 
					</body>
				</html>';
				if (!sendEmail($data['email'], "Camagru - Reset your password", $message)) {
					// Deal with failure to send email, cancel account creato
					flash_store('Something went wrong');
					redirect('users/passwordLink');
				}
				else {
					flash_store('A password reset link has been sent to your email.');
					redirect('');
				}
			}
			else {
          		// Load view with errors
				$this->view('users/passwordLink', $data);
			}

		}
		else {
        	//Init data
			$data = [
				'email' => '',
				'email_err' => '',
				'token_two' => '',
				'token_two_err' => ''
			];

        	// Load view
			$this->view('users/passwordLink', $data);
		}	
	}

	public function modify() {

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			// Check if user is logged in
			if (!isset($_SESSION['user_id'])) {
				flash_store("You must be logged in to send a comment.");
				redirect('users/login');
			}
        	// Process form

        	// Sanitize POST data
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$data = [
				'old_password' => trim($_POST['old_password']),
				'new_username' => htmlentities(trim($_POST['username'])),
				'new_email' => trim($_POST['email']),
				'new_password' => trim($_POST['password']),
				'old_password_err' => '',
				'new_username_err' => '',
				'new_email_err' => '',
				'new_password_err' => '',
				'notifications' => array_key_exists('notifications', $_POST)
			];

			if (empty($data['old_password'])) {
				$data['old_password_err'] = 'Please enter old password';
			}
			else {

				// if (empty($data['new_username']) && empty($data['new_email']) && empty($data['new_password'])) {
				// 	// $data['alert'] = 'Please modify at least one field';
				// 	flash_store('Please modify at least one field.');
				// }

				if (!empty($data['new_username']) && ($this->userModel->searchByUsername($data['new_username']) !== null)) {
					$data['new_username_err'] = 'Username is already taken';
				}

				if (!empty($data['new_email']) && ($this->userModel->searchByEmail($data['new_email']) !== null)) {
					$data['new_email_err'] = 'Email is already taken';
				}

				if (!empty($data['new_email']) && !filter_var($data['new_email'], FILTER_VALIDATE_EMAIL)) {
 				 	$data['new_email_err'] = "Invalid email format"; 
				}

				if (!empty($data['new_password']) && strlen($data['new_password']) < 6) {
					$data['new_password_err'] = 'Password must be at least 6 characters';
				}

				$loggedIn = $this->userModel->loginId($_SESSION['user_id'], $data['old_password']);

				if ($loggedIn) {

					if (!empty($data['new_username'])) {

						if ($this->userModel->modifyUsername($data['new_username'], $_SESSION['user_id'])) {
							flash_store('Modifications saved');
							// $this->logout();
							// redirect('users/login');
						}
						else {
							flash_store('Something went wrong');
							redirect('users/modify');
						}
					}

					if (!empty($data['new_email'])) {

						if ($this->userModel->modifyEmail($data['new_email'], $_SESSION['user_id'])) {
							flash_store('Modifications saved');
							// $this->logout();
							// redirect('users/login');
						}
						else {
							flash_store('Something went wrong');
							redirect('users/modify');
						}
					}

					if (!empty($data['new_password'])) {
						$data['new_password'] = password_hash($data['new_password'], PASSWORD_DEFAULT);

						if ($this->userModel->modifyPassword($data['new_password'], $_SESSION['user_id'])) {
							flash_store('Modifications saved');
							// $this->logout();
							// redirect('users/login');
						}
						else {
							flash_store('Something went wrong');
							redirect('users/modify');
						}
					}

					if ($this->userModel->modifyAcceptNotification($data['notifications'], $_SESSION['user_id'])) {
						flash_store('Modifications saved');
					}
				}
				else {
					$data['old_password_err'] = 'Wrong password';
				}
			}

			$this->view('users/modify', $data);
		}

		else {
			$user = $this->userModel->searchById($_SESSION['user_id']);

        	//Init data
			$data = [
				'old_password' => '',
				'new_username' => '',
				'new_email' => '',
				'new_password' => '',
				'old_password_err' => '',
				'new_username_err' => '',
				'new_email_err' => '',
				'new_password_err' => '',
				'notifications' => (bool)$user->accept_notifications
			];

        	// Load view
			$this->view('users/modify', $data);
		}	
	}
}