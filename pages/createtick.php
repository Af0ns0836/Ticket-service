<?php
  session_start();
  require('../actions/functions.php');
  if(isUserLoggedIn()){
    session_start();
    require_once(__DIR__.'/../database/connec.php');
  }
  else {   
    header('Location: /../pages/index.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Trouble Tickets</title>
    <link rel="stylesheet" href="/../styles/createtick.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
    <header>
      <h1>Trouble Tickets</h1>
    </header>
    <div class="grid">
      <form id="ticket-form" method="POST" action="/../actions/save_ticket.php">
        <div class="form-group">
          <label for="title">Title:</label>
          <input type="text" id="title" name="title">
        </div>
        <div class="form-group">
          <label for="department">Department:</label>
          <select id="department" name="department" >
        
            <?php
                // Fetch the departments from the database
                $stmt = $conn->query('SELECT name FROM departments');
                $departments = $stmt->fetchAll(PDO::FETCH_COLUMN);
                        
                // Generate the options for the select dropdown
                foreach ($departments as $department) {
                  echo '<option value="' . $department . '">' . $department . '</option>';
                }
            ?>
          </select>
        </div>
        <div class="form-group">
          <label for="subject">Subject:</label>
          <input type="text" id="subject" name="subject" >
        </div>
        <div class="form-group">
          <label for="description">Description:</label>
          <textarea id="description" name="description" rows="15"></textarea>
        </div>
        <button type="submit" name="save_ticket">Submit Ticket</button>
      </form>
      <div id="ticket-list"></div>
    </div>
  </body>
</html>
