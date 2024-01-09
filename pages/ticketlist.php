<?php
// Connect to the database
require('../actions/functions.php');
session_start();
if(isUserLoggedIn()){
     require_once(__DIR__.'/../database/connec.php');
     
    if (isUser()) {
        // Retrieve tickets created by the current client
        $stmt = $conn->prepare('SELECT * FROM ticket WHERE user = :username');
        $stmt->bindParam(":username", $_SESSION['user']);
        $stmt->execute();

    } elseif (isAgent()) {
        // Retrieve the department ID of the agent
        $stmt = $conn->prepare('SELECT department FROM agents WHERE id = :agent_id');
        $stmt->bindParam(":agent_id", $_SESSION['id']);
        $stmt->execute();
        $departmentId = $stmt->fetchColumn();

        $stmt = $conn->prepare('SELECT name FROM departments WHERE id = :department_id');
        $stmt->bindParam(":department_id", $departmentId);
        $stmt->execute();
        $department = $stmt->fetchColumn();

        // Retrieve tickets from the agent's department
        $stmt = $conn->prepare('SELECT * FROM ticket WHERE department = :department');
        $stmt->bindParam(":department", $department);
        $stmt->execute();

    } else {
        // Retrieve all tickets for other user types
        $stmt = $conn->query('SELECT * FROM ticket');
    }

    $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {   
    header('Location: /../pages/index.php');
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Ticket List</title>
    <link rel="stylesheet" href="/../styles/agenttick.css">
    <script src="/../javascript/filter.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <header>
        <nav>
            <ul>
              <li><a href="/../pages/account.php">Go back</a></li>
            </ul>
        </nav>
		<h1>Your Tickets</h1>
	</header>
    <input type="text" id="agent" placeholder="Assigned Agent">
    <input type="text" id="status" placeholder="Status">
    <?php
        if(!isUser())
            echo '<input type="text" id="priority" placeholder="Priority">';
	    echo '<input type="text" id="hashtag" placeholder="Hashtag">';
    ?>
    <button id="search-btn">Search</button>

    <div id="ticket-table">
    <table>
        <tr>
            <th>Title</th>
            <?php if(!isUser())
                echo '<th>Tags</th>'; ?>
            <th>Published</th>
            <th>Subject</th>
            <th>Status</th>
            <?php if(!isUser())
                echo '<th>Priority</th>';?>
            <th>Department</th>
            <th>Agent</th>
        </tr>
        <?php foreach ($tickets as $row => $ticket): ?>
        <tr>
            <td><a href="ticket.php?id=<?php echo $ticket['id']; ?>"><?php echo $ticket['title']; ?></a></td>
  
                <?php
                    // Retrieve the hashtags associated with the ticket
                    $stmt = $conn->prepare('SELECT h.text FROM hashtag h
                                            INNER JOIN ticket_hashtag th ON h.id = th.hashtag_id
                                            WHERE th.ticket_id = :ticket_id');
                    $stmt->bindParam(":ticket_id", $ticket['id']);
                    $stmt->execute();
                    $hashtags = $stmt->fetchAll(PDO::FETCH_COLUMN);

                    // Display the hashtags
                    if(!isUser()){
                        echo '<td>' .implode(', ', $hashtags). '</td>';
                    }
                ?>
       
            <td><?php echo $ticket['published']; ?></td>
            <td><?php echo $ticket['subject']; ?></td>
            <td><?php echo $ticket['status']; ?></td>
            <?php if(!isUser()) echo '<td>' . $ticket['priority'] . '</td>'; ?>
            <td><?php echo $ticket['department']; ?></td>
            <td><?php echo $ticket['agent']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    </div>
    <footer class="footer">
		<p>&copy; 2023 Your Company</p>
	</footer>
</body>
</html>
