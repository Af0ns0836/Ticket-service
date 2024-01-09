<?php
	session_start();
	require_once(__DIR__.'/../database/connec.php');

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$question = $_POST['question'];
		$answer = $_POST['answer'];

		$query = "INSERT INTO faq (question, answer) VALUES (:question, :answer)";
		$statement = $conn->prepare($query);
		$statement->bindValue(':question', $question);
		$statement->bindValue(':answer', $answer);
		$statement->execute();

		header("Location: ../pages/faq.php");
		exit();
	}
?>
