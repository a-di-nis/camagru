<?php

function redirect($page, $param = null) {
	$parameter = '';
	if ($param !== null) {
		$parameter = '/' . $param;
	}
	header('location: /' . $page . $parameter);
	exit();
}