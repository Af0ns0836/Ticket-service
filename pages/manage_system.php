<?php
 require('../actions/functions.php');
    if(isUserLoggedIn()){
            session_start();
            require_once(__DIR__.'/../database/connec.php');
            $departmentId = filter_input(INPUT_GET, 'remove', FILTER_SANITIZE_STRING);
            //$departmentId = $_GET['remove'];
             // Delete the department from the 'departments' table
            $sql = "DELETE FROM departments WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $departmentId);
            $stmt->execute();
        // Retrieve the departments from the 'departments' table
        $sql = "SELECT * FROM departments";
        $result = $conn->query($sql);

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $agentId = filter_input(INPUT_POST, 'agent', FILTER_SANITIZE_STRING);
    
        $departmentId = filter_input(INPUT_POST, 'department', FILTER_SANITIZE_STRING);

        // Update the agent's department in the 'agents' table
        $updateSql = "UPDATE agents SET department = :departmentId WHERE id = :agentId";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bindParam(':departmentId', $departmentId);
        $updateStmt->bindParam(':agentId', $agentId);
        $updateStmt->execute();
        // Perform the update
    }
    // Check if the department form is submitted
    if (isset($_POST['department_name'])) {
        // Retrieve department data from form
        $departmentName = $_POST["department_name"];

            // Insert new department into the 'departments' table
            $sql = "INSERT INTO departments (name) VALUES (:name)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $departmentName);
            $stmt->execute();
    }

    // Retrieve the agents from the 'agents' table
    $agentSql = "SELECT * FROM agents";
    $agentResult = $conn->query($agentSql);

    $departments = "SELECT * FROM departments";
    $departmentRes = $conn->query($departments);

    // Close the database connection
    $conn = null;
}
else {   
    header('Location: /../pages/index.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Department</title>
    <link rel="stylesheet" href="/../styles/account.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="/../pages/account.php">Go back</a></li>
        </ul>
    </nav>
    <h1>System management</h1>
</header>
<div class="container3">
    <div class="box">
        <h2>Add Department</h2>
        <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <label for="department_name">Department Name:</label>
            <input type="text" id="department_name" name="department_name" required><br><br>

            <input type="submit" value="Add Department" class = "greenbutton">
        </form>
    </div>
    <div class="box">
        <h2>Departments List</h2>
        <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
            <div>
                <span><?php echo $row['name']; ?></span>
                <a href="?remove=<?php echo $row['id']; ?>">Remove</a>
            </div>
        <?php endwhile; ?>
    </div>
    <div class="box">
        <h2>Assign Department to Agent</h2>
        <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <label for="agent">Agent:</label>
            <select name="agent" id="agent" required>
                <?php while ($agentRow = $agentResult->fetch(PDO::FETCH_ASSOC)): ?>
                    <option value="<?php echo $agentRow['id']; ?>"><?php echo $agentRow['username']; ?></option>
                <?php endwhile; ?>
            </select><br><br>

            <label for="department">Department:</label>
            <select name="department" id="department" required>
                <?php while ($departmentRow = $departmentRes->fetch(PDO::FETCH_ASSOC)): ?>
                    <option value="<?php echo $departmentRow['id']; ?>"><?php echo $departmentRow['name']; ?></option>
                <?php endwhile; ?>
            </select><br><br>

            <input type="submit" value="Assign Department" class = "greenbutton">
        </form>
    </div>
</div>
<footer class="footer">
    <p>&copy;2023 Your Company</p>
</footer>
</body>
</html>
