<?php
session_start();

function flash_message()
{
	if (!empty($_SESSION['flash'])) {
		echo '<div class="alert alert-info">' . $_SESSION['flash'] . '</div>';
		unset($_SESSION['flash']);
	}
}

function flash_store($message)
{
	$_SESSION['flash'] = $message;
}

function isLoggedIn() {
	if(isset($_SESSION['user_id'])) {
		return true;
	}
	else {
		return false;
	}
}