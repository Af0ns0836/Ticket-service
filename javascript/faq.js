document.addEventListener("DOMContentLoaded", function() {
    const buttons = document.getElementsByClassName("use-answer-button");
    for (let i = 0; i < buttons.length; i++) {
        buttons[i].addEventListener("click", function() {
            const answerElement = this.previousElementSibling;
            const answer = answerElement.textContent;
            const url = '../pages/ticket.php?id=' + document.getElementById('ticket-id').value;

            navigator.clipboard.writeText(answer).then(function() {
                alert("Answer copied to clipboard!");
                window.location.href = url;
            }, function() {
                alert("Failed to copy answer to clipboard.");
                window.location.href = url;
            });
        });
    }
});
