<?php

session_start();
require_once(__DIR__.'/../database/connec.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the ticket ID and new status from the form data
    $ticketId = $_POST['ticket_id'];
    $newStatus = $_POST['status'];

    // Function to update the status of a ticket
    function changeTicketStatus($ticketId, $newStatus) {
        global $conn; // Your database connection object

        // Prepare the SQL statement
        $stmt = $conn->prepare("UPDATE ticket SET status = ? WHERE id = ?");
        $stmt->bindValue(1, $newStatus, PDO::PARAM_STR);
        $stmt->bindValue(2, $ticketId, PDO::PARAM_INT);

        // Execute the statement
        $stmt->execute();

        // Check if the update was successful
        if ($stmt->rowCount() > 0) {
            echo "Ticket status updated successfully.";
            header('Location: /../pages/manage_tickets.php');
        } else {
            echo "Failed to update ticket status.";
            header('Location: /../pages/manage_tickets.php');
        }
    }
    // Call the function to update the department
    changeTicketStatus($ticketId, $newStatus);
} else {
    echo "Invalid request.";
}