<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login/Register</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/../styles/index.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class = header>
        <h2 class="logo">Logo</h2>
        <nav class="navigation">
            <a href="/../pages/about.html">About</a>
            <a href="/../pages/faq.php">Faq</a>
        </nav>
    </div>

    <div class="naosei">
        <div class="form-box login">
            <h2>Login</h2>
            <form method="POST" action="/actions/login_query.php">
                <div class="inputbox">
                    <span class="icon"><ion-icon name="person"></ion-icon></span>
                    <input type="text" name="username" required placeholder="Username">
                </div>
                <div class="inputbox">
                    <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                    <input type="password" name="password" required placeholder="Password">
                </div>
                <button type="submit" name="login" class="btn">Login</button>
                <div class="loginregister">
                    <p>Don't have an account?<a href="#" class="registerlink"> Register</a></p>
                </div>
            </form>
        </div>

        <div class="form-box register">
            <h2>Registration</h2>
            <form method="POST" action="../actions/save_member.php">
                <div class="inputbox">
                    <span class="icon"><ion-icon name="person"></ion-icon></span>
                    <input type="text" name="username" required placeholder="Username">
                </div>
                <div class="inputbox">
                    <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                    <input type="text" name="name" required placeholder="Name">
                </div>
                <div class="inputbox">
                    <span class="icon"><ion-icon name="mail"></ion-icon></span>
                    <input type="text" name="email" required placeholder="Email">
                </div>
                <div class="inputbox">
                    <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                    <input type="password" name="password" required placeholder="Password">
                </div>
                <div class="inputbox">
                    <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                    <input type="password" name="password_confirmation" required placeholder="Repeat Password">
                </div>
                <div class="loginregister">
                    <p>Already have an account?<a href="#" class="loginlink">Login</a></p>
                </div>
                <button type="submit" name="register" class="btn">Register</button>
            </form>
        </div>
    </div>
    <script src="../javascript/script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>
</html>