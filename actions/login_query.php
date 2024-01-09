<?php
	require_once(__DIR__.'/../database/connec.php');

	if(ISSET($_POST['login'])){
		$username = preg_replace("/[^a-zA-Z0-9\s]/",'',$_POST["username"]);
 		$query = ("SELECT * FROM users WHERE username = :username");
		$stmt = $conn->prepare($query);
		$stmt->bindParam(":username",$username);
		$stmt->execute();
		$user = $stmt->fetch();
		
		if($user){
			if(password_verify($_POST["password"],$user["password"])){
				session_start();
				$_SESSION["type"] = $user["type"];
				$_SESSION["user"] = $user["username"];
				$_SESSION["id"] = $user["userid"];
				header('Location: /../pages/account.php');
			}
			else{
				header('Location: /../pages/index.php');	
				exit;
			}
		}
		else{
			header('Location: /../pages/index.php');	
			exit;
		}

	}
