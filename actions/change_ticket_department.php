<?php

session_start();
require_once(__DIR__.'/../database/connec.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the ticket ID and new department from the form data
    $ticketId = $_POST['ticket_id'];
    $newDepartment = $_POST['department'];

    // Function to update the department of a ticket
    function changeTicketDepartment($ticketId, $newDepartment) {
        global $conn; // Your database connection object

        // Prepare the SQL statement
        $stmt = $conn->prepare("UPDATE ticket SET department = ? WHERE id = ?");
        $stmt->bindValue(1, $newDepartment, PDO::PARAM_STR);
        $stmt->bindValue(2, $ticketId, PDO::PARAM_INT);

        // Execute the statement
        $stmt->execute();

        // Check if the update was successful
        if ($stmt->rowCount() > 0) {
            echo "Ticket department updated successfully.";
            header('Location: /../pages/manage_tickets.php');
        } else {
            echo "Failed to update ticket department.";
            header('Location: /../pages/manage_tickets.php');
        }
    }

    // Call the function to update the department
    changeTicketDepartment($ticketId, $newDepartment);
} else {
    echo "Invalid request.";
}
