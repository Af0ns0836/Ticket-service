<?php
	require_once(__DIR__.'/../database/connec.php');
	if(empty($_POST["username"])){
		die("Username is required");
	}
	if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
		die("Valid email is required");
	}
	if( strlen($_POST["password"]) < 8){
		die("Password must be at least 8 characters");
	}
	if(!preg_match("/[0-9]/",$_POST["password"])){
		die("Password must contain at least one number");
	}
	if($_POST["password"] !== $_POST["password_confirmation"]){
		die("Passwords must match");
	}
	$password_hash = password_hash($_POST["password"],PASSWORD_DEFAULT);
	if(ISSET($_POST['register'])){
		$username = preg_replace("/[^a-zA-Z0-9\s]/", '', $_POST['username']);
		$email = preg_replace("/[^a-zA-Z0-9.@\s]/", '', $_POST['email']);
		$name = preg_replace("/[^a-zA-Z\s]/", '', $_POST['name']);
		$type = "user";
		$query = "INSERT INTO `users` (username, password,name, email, type) VALUES(:username, :password, :name, :email, :type)";
		$stmt = $conn->prepare($query);
		$stmt->bindParam(':username', $username);
		$stmt->bindParam(':password', $password_hash);
		$stmt->bindParam(':name', $name);
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':type', $type);
		
		if($stmt->execute()){
			session_start();
			$_SESSION["type"] = $type;
			$_SESSION["user"] = $username;
			$query = sprintf("SELECT * FROM users 
				WHERE username = '%s'", $username);
  			$stmt = $conn->prepare($query);
  			$stmt->execute();
  			$user = $stmt->fetch();
			$_SESSION["id"] = $user['userid'];
			header('location:../pages/account.php');
		}
	}
