<?php
	error_reporting(0);
	ini_set('display_errors', 0);

	$host = "localhost";
	$user = "root";
	$pass = "";
	$db = "unpam_web";

	$conn = @mysqli_connect($host, $user, $pass, $db);
	if (!$conn) {
		die("Koneksi database gagal. Silakan coba lagi nanti.");
	}