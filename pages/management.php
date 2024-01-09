<?php
require('../actions/functions.php');
// Check if the user is logged in as an admin
session_start();
if(isUserLoggedIn()){
    if (isUser()) {
        header('Location: index.php');
        exit();
    }

    require_once(__DIR__.'/../database/connec.php');

    // Get all users except the admin
    $statement = $conn->query('SELECT userid, username, type FROM users WHERE type != "admin"');
    $users = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Check if the form has been submitted
    if (isset($_POST['promote_admin'])) {
        // Get the user id to promote
        $userid = $_POST['userid'];
        
        // Update the user's type to admin
        $stmt = $conn->prepare('UPDATE users SET type = "admin" WHERE userid = :userid');
        $stmt->bindValue(':userid', $userid, PDO::PARAM_INT);
        $stmt->execute();
        
        // Redirect to the same page to prevent form resubmission
        header('Location: management.php');
        exit();
    }
    else if (isset($_POST['promote_agent'])) {
        // Get the user id to promote
        $userid = $_POST['userid'];
        
        // Update the user's type to agent
        $stmt = $conn->prepare('UPDATE users SET type = "agent" WHERE userid = :userid');
        $stmt->bindValue(':userid', $userid, PDO::PARAM_INT);
        $stmt->execute();
        
        // Redirect to the same page to prevent form resubmission
        header('Location: management.php');
        exit();
    } else if (isset($_POST['demote_user'])) {
        // Get the user id to demote
        $userid = $_POST['userid'];
        
        // Update the user's type to user
        $stmt = $conn->prepare('UPDATE users SET type = "user" WHERE userid = :userid');
        $stmt->bindValue(':userid', $userid, PDO::PARAM_INT);
        $stmt->execute();
        
        // Redirect to the same page to prevent form resubmission
        header('Location: management.php');
        exit();
    }
}    else {   
    header('Location: /../pages/index.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <link rel="stylesheet" href="/../styles/management.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class>
    <header>
        <nav>
            <ul>
              <li><a href="/../pages/account.php">Go back</a></li>
            </ul>
        </nav>
		<h1>Manage Users</h1>
	</header>
    <form method="post">
        <label>Select a user to promote/demote:</label>
        <select name="userid">
            <?php foreach ($users as $user): ?>
            <option value="<?php echo $user['userid']; ?>"><?php echo $user['username'] . ' (' . ucfirst($user['type']) . ')'; ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" name="promote_admin">Promote to Admin</button>
        <button type="submit" name="promote_agent">Promote to Agent</button>
        <button type="submit" name="demote_user">Demote to User</button>
    </form>
    <footer class="footer">
		<p>&copy; 2023 Your Company</p>
	</footer>
</body>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</html>