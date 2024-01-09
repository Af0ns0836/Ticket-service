<?php
// Connect to the database
require_once(__DIR__.'/../database/connec.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the ticket ID and hashtag ID from the AJAX request
    $ticketId = $_POST['ticket_id'];
    $hashtagId = $_POST['hashtag_id'];

    // Delete the hashtag from the ticket_hashtag table
    $stmt = $conn->prepare('DELETE FROM ticket_hashtag WHERE ticket_id = :ticket_id AND hashtag_id = :hashtag_id');
    $stmt->bindParam(":ticket_id", $ticketId);
    $stmt->bindParam(":hashtag_id", $hashtagId);
    $stmt->execute();

    // Check if the delete operation was successful
    if ($stmt->rowCount() > 0) {
        echo "Hashtag removed successfully.";
    } else {
        echo "Failed to remove hashtag.";
    }
}
?>
