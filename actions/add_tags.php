<?php
session_start();
require_once(__DIR__.'/../database/connec.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the submitted ticket ID and hashtag
    $ticketId = $_POST['ticket_id'];
    $hashtag = $_POST['hashtag'];

    // Insert the new hashtag into the database
    $stmt = $conn->prepare('INSERT INTO hashtag (text) VALUES (:text)');
    $stmt->bindParam(':text', $hashtag);
    $stmt->execute();
    $hashtagId = $conn->lastInsertId();

    // Associate the hashtag with the ticket
    $stmt = $conn->prepare('INSERT INTO ticket_hashtag (ticket_id, hashtag_id) VALUES (:ticket_id, :hashtag_id)');
    $stmt->bindParam(':ticket_id', $ticketId);
    $stmt->bindParam(':hashtag_id', $hashtagId);
    $stmt->execute();

    // Redirect back to the ticket list page
    header('Location: /../pages/manage_tickets.php');
    exit();
}
?>
