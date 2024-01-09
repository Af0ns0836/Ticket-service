<?php
session_start();
require('../actions/functions.php');
require_once(__DIR__.'/../database/connec.php');
if(isUserLoggedIn()){
    if(isUser()){
        header('Location: ../pages/account.php');
    }
    $username = $_SESSION['user'];
    $stmt = $conn->query('SELECT * FROM ticket');
    $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
}   else {   
    header('Location: /../pages/index.php');
    exit;
}  
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ticket List</title>
    <script src="/../javascript/add_tags.js"></script>
    <script src="/../javascript/remove_tags.js"></script>
    <link rel="stylesheet" href="/../styles/account.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="container2">
    <header>
        <nav>
            <ul>
                <li><a href="/../pages/account.php">Go Back</a></li>
            </ul>
        </nav>
        <h1>Your Tickets</h1>
    </header>
    <div id="ticket-table">
        <table>
            <tr>
                <th>Title</th>
                <th>Remove tags</th>
                <th>Add tags</th>
                <th>Published</th>
                <th>Subject</th>
                <th>Status</th>
                <th>Priority</th>
                <th>Assigned Agent</th>
                <th>Department</th>
            </tr>
            <?php foreach ($tickets as $row => $ticket): ?>
            <tr>
                <td><a href="ticket.php?id=<?php echo $ticket['id']; ?>"><?php echo $ticket['title']; ?></a></td>
                <td>
                    <?php include 'display_hashtags.php'; ?>
                </td>
                <td>
                    <form class="tag-form" action="/../actions/add_tags.php" method="post">
                        <input type="hidden" name="ticket_id" value="<?php echo $ticket['id']; ?>">
                        <input type="text" name="hashtag" placeholder="Enter hashtags">
                        <button type="submit" class="btn btn-primary">Add Hashtag</button>
                    </form>
                </td>
                <td><?php echo date($ticket['published']); ?></td>
                <td><?php echo $ticket['subject']; ?></td>
                <td>
                    <form action="/../actions/change_ticket_status.php" method="post">
                        <input type="hidden" name="ticket_id" value="<?php echo $ticket['id']; ?>">
                        <select name="status" onchange="this.form.submit()">
                            <option value="Open" <?php if ($ticket['status'] === 'Open') echo 'selected'; ?>>Open</option>
                            <option value="Closed" <?php if ($ticket['status'] === 'Closed') echo 'selected'; ?>>Closed</option>
                        </select>
                    </form>
                </td>
                <td>
                    <form action="/../actions/change_ticket_priority.php" method="post">
                        <input type="hidden" name="ticket_id" value="<?php echo $ticket['id']; ?>">
                        <select name="priority" onchange="this.form.submit()">
                            <option value="High" <?php if ($ticket['priority'] === 'High') echo 'selected'; ?>>High</option>
                            <option value="Medium" <?php if ($ticket['priority'] === 'Medium') echo 'selected'; ?>>Medium</option>
                            <option value="Low" <?php if ($ticket['priority'] === 'Low') echo 'selected'; ?>>Low</option>
                        </select>
                    </form>
                </td>
                <td>
                    <form action="/../actions/change_ticket_agent.php" method="post">
                        <input type="hidden" name="ticket_id" value="<?php echo $ticket['id']; ?>">
                        <select name="agent" onchange="this.form.submit()">
                            <?php
                            // Fetch the agents from the database
                            $stmt = $conn->query('SELECT username FROM agents');
                            $agents = $stmt->fetchAll(PDO::FETCH_COLUMN);

                            // Generate the options for the select dropdown
                            foreach ($agents as $agent) {
                                $selected = ($ticket['agent'] === $agent) ? 'selected' : '';
                                echo '<option value="' . $agent . '" ' . $selected . '>' . $agent . '</option>';
                            }
                            ?>
                        </select>
                    </form>
                </td>
                <td>
                    <form action="/../actions/change_ticket_department.php" method="post">
                        <input type="hidden" name="ticket_id" value="<?php echo $ticket['id']; ?>">
                        <select name="department" onchange="this.form.submit()">
                            <?php
                            // Fetch the departments from the database
                            $stmt = $conn->query('SELECT name FROM departments');
                            $departments = $stmt->fetchAll(PDO::FETCH_COLUMN);

                            // Generate the options for the select dropdown
                            foreach ($departments as $department) {
                                $selected = ($ticket['department'] === $department) ? 'selected' : '';
                                echo '<option value="' . $department . '" ' . $selected . '>' . $department . '</option>';
                            }
                            ?>
                        </select>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <footer class="footer">
        <p>&copy; 2023 Your Company</p>
    </footer>
</body>
</html>
