<?php
	session_start();
	require_once(__DIR__.'/../database/connec.php');

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$faqId = $_POST['faq_id'];

		$query = "DELETE FROM faq WHERE faq_id = :faqId";
		$statement = $conn->prepare($query);
		$statement->bindValue(':faqId', $faqId);
		$statement->execute();

		header("Location: ../pages/faq.php");
		exit();
	}
?>
