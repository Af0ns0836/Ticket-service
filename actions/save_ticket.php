<?php
	session_start();
	require_once(__DIR__.'/../database/connec.php');
 
	if(ISSET($_POST['save_ticket'])){
	
		$title = $_POST['title'];
		$subject = $_POST['subject'];
		$department = $_POST['department'];
		$description = $_POST['description'];
		$username = $_SESSION['user'];
		$status = "Open";
		$timezone = 'Europe/Lisbon';
		$date = new DateTime('now', new DateTimeZone($timezone));
		$currentDate = $date->format('Y-m-d H:i:s');
		
		$query = "INSERT INTO `ticket` (title, subject, department, user,fulltext, published, status) VALUES(:title, :subject, :department, :user, :description, :data, :status)";
		$stmt = $conn->prepare($query);
		$stmt->bindParam(':title', $title);
		$stmt->bindParam(':subject', $subject);
		$stmt->bindParam(':department', $department);
		$stmt->bindParam(':user', $username);
		$stmt->bindParam(':description', $description);
		$stmt->bindParam(':data', $currentDate);
		$stmt->bindParam(':status', $status);
 
		if($stmt->execute()){
		
			$_SESSION['success'] = "Successfully created an ticket";
	
			header('Location: /../pages/account.php');
		}
	}
