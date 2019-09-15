<?php
function sendEmail($to, $subject, $body) {
	$headers = "From: adi-nis@42.fr";
	$headers = "MIME-Version: 1.0";
    $headers = "Content-type: text/html; charset=UTF-8";
	if (!mail($to, $subject, $body, $headers)) {
		error_log("Failed to send the email");
		return (false);
	}
	else {
		return (true);
	}
}
?>