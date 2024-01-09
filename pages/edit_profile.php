<?php
    require('../actions/functions.php');
    if(isUserLoggedIn()){
        session_start();
        require_once(__DIR__.'/../database/connec.php');
    }  else {   
        header('Location: /../pages/index.php');
        exit;
    }
?>    
<!DOCTYPE html>
<html>
    <head>
        <title>Edit Profile</title>
        <link rel="stylesheet" href="/../styles/account.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div class="container1">
            <div class = "grid1">
                <h1>Edit Profile</h1>
                <form method="Post" action="/actions/Update_user.php">
                    <label for="name">Name:</label>
                    <input type="text" name="name"><br>  

                    <label for="username">Username:</label>
                    <input type="text" name="username"><br>

                    <label for="email">Email:</label>
                    <input type="email" name="email"><br>

                    <label for="password">New Password:</label>
                    <input type="password" name="password"><br>


                    <button name ='edit' id="upload-btn">Save Changes</button>
                </form>
                <nav>
                    <ul>
                        <li><a href="/../pages/account.php">Go Back</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </body>
</html>

