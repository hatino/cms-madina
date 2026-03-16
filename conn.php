<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$db="cms-madina";
	$conn = mysqli_connect($servername, $username, $password,$db);

	// function getConnection() {
    // 	static $conn; // hanya dibuat sekali per request
    
	// 	if ($conn === null) {
	// 		$conn = mysqli_connect($servername,$username,$password,$db);
	// 		if (!$conn) {
	// 			die("Connection failed: " . mysqli_connect_error());
	// 		}
	// 	}
	// 	return $conn;
	// }
?>