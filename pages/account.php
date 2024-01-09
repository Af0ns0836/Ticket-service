<?php
    session_start();
    require('../actions/functions.php');
    if(isUserLoggedIn()){
        require_once(__DIR__.'/../database/connec.php');
        $statement = $conn->query("SELECT name, username, email FROM users WHERE userid = :userid");
        $statement->bindParam(":userid", $_SESSION['id']);
        $statement->execute();
        $user = $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    else {   
        header('Location: /../pages/index.php');
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Create Ticket and Profile management</title>
        <link rel="stylesheet" href="/../styles/account.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body class = "container">  
        <nav class="nav">
            <ul class="nav-list">

                <a href="/../pages/faq.php" class="nav-link">
                    <ion-icon name="help-outline"></ion-icon>
                    <span class="nav-name">FAQ</span>
                </a>

                <a href="ticketlist.php" class="nav-link">
                    <ion-icon name="list-outline"></ion-icon>
                    <span class="nav-name">Display tickets</span>
                </a>
                <?php
                if (isAdmin()) {

                    echo '<a href="management.php" class="nav-link">
                            <ion-icon name="people-outline"></ion-icon>
                            <span class="nav-name">Manage Users</span>
                        </a>';
    
                    echo '<a href="manage_system.php" class="nav-link">
                            <ion-icon name="construct-outline"></ion-icon>
                            <span class="nav-name">Manage System</span>
                        </a>';
                }
                if (!isUser()){
                    echo '<a href="manage_tickets.php" class="nav-link">
                            <ion-icon name="cog-outline"></ion-icon>
                            <span class="nav-name">Manage Tickets</span>
                        </a>';
                }
                ?>
                <a href="/../actions/logout.php" class="nav-link">
                    <ion-icon name="log-out-outline"></ion-icon>
                    <span class="nav-name">Logout</span>
                </a>

            </ul>

            <div class="nav-circle1"></div>
            <div class="nav-circle2"></div>

            <div class="nav-square1"></div>
            <div class="nav-square2"></div>
        </nav>
        <po class = "item-a">Create a ticket so that we can help you solve your problems!</po>
        <main class = "item-b">
            <a href="createtick.php"><button type="create" class="block" >Create Ticket</button></a>
        </main>
        <div id="profile" class = "item-c">
            <?php

                foreach($user as $user){
                    
                    echo '<img id="profile-image" src="../images/default.jpg" alt="Profile Picture">';                                      
                    echo "<h1>" . $user['name'] ."</h1>";
                    echo "<ul>";
                    echo "<li><label>Username:</label>". $user['username'] . "</li>";
                    echo "<li><label>Email:</label>". $user['email'] . "</li>";
                    echo "</ul>";
                }
            ?>
            <nav>
                <ul>
                    <li><a href="/../pages/edit_profile.php">Edit Profile</a></li>
                </ul>
            </nav>
           
        </div>
        <footer class="footer">
		    <p>&copy; 2023 Your Company</p>
	    </footer>
        <script src="/../javascript/main.js"></script>
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    </body>
</html>
