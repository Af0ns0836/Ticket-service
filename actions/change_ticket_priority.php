<?php

session_start();
require_once(__DIR__.'/../database/connec.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the ticket ID and new status from the form data
    $ticketId = $_POST['ticket_id'];
    $newPriority = $_POST['priority'];

    // Function to update the status of a ticket
    function changeTicketStatus($ticketId, $newPriority) {
        global $conn; // Your database connection object

        // Prepare the SQL statement
        $stmt = $conn->prepare("UPDATE ticket SET priority = ? WHERE id = ?");
        $stmt->bindValue(1, $newPriority, PDO::PARAM_STR);
        $stmt->bindValue(2, $ticketId, PDO::PARAM_INT);

        // Execute the statement
        $stmt->execute();

        // Check if the update was successful
        if ($stmt->rowCount() > 0) {
            echo "Ticket priority updated successfully.";
            header('Location: /../pages/manage_tickets.php');
        } else {
            echo "Failed to update ticket priority.";
            header('Location: /../pages/manage_tickets.php');
        }
    }
    // Call the function to update the department
    changeTicketStatus($ticketId, $newPriority);
} else {
    echo "Invalid request.";
}