<?php
// Retrieve the hashtags associated with the ticket
$stmt = $conn->prepare('SELECT h.id, h.text FROM hashtag h
                        INNER JOIN ticket_hashtag th ON h.id = th.hashtag_id
                        WHERE th.ticket_id = :ticket_id');
$stmt->bindParam(":ticket_id", $ticket['id']);
$stmt->execute();
$hashtags = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Display the hashtags
foreach ($hashtags as $hashtag) {
    echo '<span>' . $hashtag['text'] . '</span> ';
    echo '<a href="#" class="hashtag-link" data-ticket-id="' . $ticket['id'] . '" data-hashtag-id="' . $hashtag['id'] . '">[x]</a>';
    echo '<br>';
}
?>