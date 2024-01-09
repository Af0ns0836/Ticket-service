<?php
	require('../actions/functions.php');
	session_start();
	require_once(__DIR__.'/../database/connec.php');
	$statement = $conn->query("SELECT * FROM faq");
	$faqs = $statement->fetchAll(PDO::FETCH_ASSOC);
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>FAQ Page</title>
	<link rel="stylesheet" type="text/css" href="/../styles/faq.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<header>
        <nav>
			<?php
				if(isUserLoggedIn()){
					echo '<a href="account.php">Go back</a>';
				}
				else{
					echo '<a href="index.php">Go back</a>';
				}
            ?>
        </nav>
		<h1>FAQ Page</h1>
	</header>
	<div class="container">
		<div class = "bg-text">
			<?php
				foreach($faqs as $row => $faqs){
					echo "<h2>" .  $faqs['question'] . "</h2>";
					echo "<p>" .  $faqs['answer'] . "</p>";
					if (!isUser()) {
						echo '<button class="use-answer-button" onclick="copyToClipboard(this)">Use Answer</button>';
						echo '<form method="post" action="../actions/remove_faq.php">';
						echo '<input type="hidden" name="faq_id" value="' . $faqs['faq_id'] . '">';
						echo '<input type="submit" value="Remove" class = "redbutton">';
						echo '</form>';
					}
				}
			?>
			<input type="hidden" id="ticket-id" value="<?php echo $_SESSION['ticket_id']; ?>">
		</div>
		<form method="post" action="../actions/add_faq.php">
			<div class="input-box">
				<label for="question">Question:</label>
				<input type="text" id="question" name="question" required>
			</div>

			<div class="input-box">
				<label for="answer">Answer:</label>
				<textarea id="answer" name="answer" required></textarea>
			</div>

			<input type="submit" value="Add Question" class = "greenbutton">
		</form>
		</div>
	<footer class="footer">
		<p>&copy; 2023 Your Company</p>
	</footer>

	<script src="/../javascript/faq.js"></script>
</body>
</html>