<?php
// Start the session
session_start();

// Establish database connection
require_once(__DIR__.'/../database/connec.php');

// Get the ticket ID from the AJAX request
$requestData = json_decode(file_get_contents('php://input'), true);
$ticketId = $requestData['ticketId'];

// Update the ticket status to "Closed" in the database
$sql = "UPDATE ticket SET status = 'Closed' WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$ticketId]);

// Store the closed state in a session variable
$_SESSION['closed_ticket_'.$ticketId] = true;

// Return a response indicating the success of the operation
$response = ['success' => true];
echo json_encode($response);

?>