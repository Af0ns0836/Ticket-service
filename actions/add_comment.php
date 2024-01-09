<?php
// Establish database connection
require_once(__DIR__.'/../database/connec.php');
session_start();

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the comment data from the request
    $requestData = json_decode(file_get_contents('php://input'), true);

    // Verify that the required data is present
    if (isset($requestData['comment']) && isset($requestData['ticketId'])) {
        $commentText = $requestData['comment'];
        $ticketId = $requestData['ticketId'];

        // Save the comment to the database
        $sql = "INSERT INTO comments (ticket_id, username, published, text) VALUES (:ticketId, :username, :published, :commentText)";
        $stmt = $conn->prepare($sql);

        // Set the current timestamp as the published time
        $timezone = 'Europe/Lisbon';
        $date = new DateTime('now', new DateTimeZone($timezone));
		$publishedTime = $date->format('Y-m-d H:i:s');
        // Retrieve the logged-in user's username
        $username = $_SESSION['user'];

        // Bind the parameters and execute the statement
        $stmt->bindParam(':ticketId', $ticketId);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':published', $publishedTime);
        $stmt->bindParam(':commentText', $commentText);

        if ($stmt->execute()) {
            // Comment saved successfully, retrieve the comment information
            $comment = [
                'user' => $username,
                'time' => $publishedTime,
                'text' => $commentText
            ];

            // Return the comment information as a JSON response
            echo json_encode($comment);
        } else {
            // Error occurred while saving the comment
            echo json_encode(['error' => 'Failed to save comment']);
        }
    } else {
        // Required data is missing
        echo json_encode(['error' => 'Missing comment data']);
    }
} else {
    // Handle the case when the request method is not POST
    echo json_encode(['error' => 'Invalid request']);
}
