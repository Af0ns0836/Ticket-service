<?php
	require('../actions/functions.php');
	if(!isUserLoggedIn()){   
        header('Location: /../pages/index.php');
        exit;
    };
?>
<!DOCTYPE html>
<html>
<head>
	<title>Ticket Details</title>
	<link rel="stylesheet" type="text/css" href="/../styles/chat.css">
	<script src="/../javascript/chat.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class = "container">
	<?php 
	// Establish database connection
	require_once(__DIR__.'/../database/connec.php');

	// Get ticket id from query string
	$ticket_id = $_GET['id'];
	$_SESSION['ticket_id'] = $ticket_id;

	// Retrieve ticket information from database
	$sql = "SELECT * FROM ticket WHERE id= ?";
	$result = $conn->prepare($sql);
	$result->execute([$ticket_id]);
	$ticket = $result->fetch(PDO::FETCH_ASSOC);

	// Retrieve user information from database
	$username = $ticket['user'];
	$sql = "SELECT * FROM users WHERE username='$username'";
	$result = $conn->query($sql);
	$user = $result->fetch(PDO::FETCH_ASSOC);

	// Retrieve hashtag information from database
	$hashtags = array();
	$sql = "SELECT * FROM hashtag WHERE id='$ticket_id'";
	$result = $conn->query($sql);
	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
		$hashtags[] = $row['text'];
	}

	?>
	<div class = "grid">
		<h1><?php echo $ticket['title']; ?></h1>
		<p>Published: <?php echo $ticket['published']; ?></p>
		<p>Subject: <?php echo $ticket['subject']; ?></p>
		<p>Status: <?php echo $ticket['status']; ?></p>
		<p>Department: <?php echo $ticket['department']; ?></p>
		<p>Tags: <?php echo implode(", ", $hashtags); ?></p>
		<p><?php echo $ticket['fulltext']; ?></p>
	</div>
	<div class = "grid2">
		<h2>Comments</h2>
		<div id="comments">
		<?php 
		
		// Retrieve comments for the ticket from database
		$sql = "SELECT * FROM comments WHERE ticket_id='$ticket_id'";
		$result = $conn->query($sql);
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			//Retrieve user information for the comment from database
			$username = $row['username'];
			$sql = "SELECT * FROM users WHERE username=:username";
			$user_result = $conn->query($sql);
			$user_result->bindParam(":username",$username);
			$user_result->execute();
			$user = $user_result->fetch(PDO::FETCH_ASSOC);
			echo "<div class='comment'>";
			
			if ($user['type'] == 'user'){
				echo "<p><strong style='color: #00FF00;'>{$user['name']}</strong> commented on " . $row['published'] . "</p>";
			}
			
			elseif ($user['type'] == 'agent'){
				echo "<p><strong style='color: #ADD8E6;'>{$user['name']}</strong> commented on " . $row['published'] . "</p>";
			}
			
			else {
				echo "<p><strong style='color: red';>{$user['name']}</strong> commented on " . $row['published'] . "</p>";
			}
			echo "<p>{$row['text']}</p>";
			echo "</div>";
		}
		?>
		</div>
		<?php
		if(isset($_SESSION["closed_ticket_".$ticket_id]))echo '<style>#add-comment{display:none;}</style>';
		?>
		<div id="add-comment">
			<h3 >Add Comment</h3>
			<form id="comment-form" class="comment-form">
				<div class="comment-input-container">
					<textarea id="comment-text" name="comment"></textarea>
					<input type="submit" value="Add Comment" class="add-comment-button">
				</div>
				<input type="hidden" id="ticket-id" value="<?php echo $ticket_id; ?>">
			</form>
			<div class="buttons-container">
				<button id="close-ticket-button" class="close-ticket-button">Close ticket</button></div>
		</div>
		<nav class="back-link">
		<?php
			if(!isUser()) {
				echo '<ul>
					<li><a href="/../pages/faq.php">FAQ</a></li>
				</ul>';
			}
			?>
			<ul>
				<li><a href="/../pages/ticketlist.php">Back</a></li>
			</ul>
			
		</nav>
	</div>
	<footer class="footer">
		<p>&copy; 2023 Your Company</p>
	</footer>
</body>
</html>