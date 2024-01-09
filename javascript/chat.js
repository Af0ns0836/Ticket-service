document.addEventListener('DOMContentLoaded', function() {

    // Get the comment form
    const commentForm = document.getElementById('comment-form');
    
    // Add event listener to the form submission
    commentForm.addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent form submission
    
        // Get the comment text and ticket ID
        const commentText = document.getElementById('comment-text').value;
        const ticketId = document.getElementById('ticket-id').value;
    
        // Create an object to hold the comment data
        const commentData = {
            comment: commentText,
            ticketId: ticketId
        };
    
        // Send the comment data to the server using AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../actions/add_comment.php', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
    
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                // Comment successfully added, update the comments section
                const newComment = JSON.parse(xhr.responseText);
                addCommentToPage(newComment);
            }
        };
    
        xhr.send(JSON.stringify(commentData));
    
        // Clear the comment input field
        document.getElementById('comment-text').value = '';
    });
    
    // Function to add a new comment to the page
    function addCommentToPage(comment) {
        const commentsDiv = document.getElementById('comments');
    
        // Create a new comment element
        const commentDiv = document.createElement('div');
        commentDiv.classList.add('comment');
    
        // Create a paragraph for the comment details
        const commentParagraph = document.createElement('p');
    
        // Set the content of the paragraph
        commentParagraph.innerHTML = '<strong>' + comment.user + '</strong> commented on ' + comment.time;
    
        // Create a paragraph for the comment text
        const textParagraph = document.createElement('p');
        textParagraph.textContent = comment.text;
    
        // Append the paragraphs to the comment div
        commentDiv.appendChild(commentParagraph);
        commentDiv.appendChild(textParagraph);
    
        // Append the comment div to the comments section
        commentsDiv.appendChild(commentDiv);
    }
       // Get the close ticket button
       const closeTicketButton = document.getElementById('close-ticket-button');
    
       // Add event listener to the close ticket button
       closeTicketButton.addEventListener('click', function(e) {
           e.preventDefault();
    
           // Confirm if the user wants to close the ticket
           if (confirm('Are you sure you want to close this ticket?')) {
               // Get the ticket ID
               const ticketId = document.getElementById('ticket-id').value;
    
               // Send an AJAX request to update the ticket status to "Closed"
               const xhr = new XMLHttpRequest();
               xhr.open('POST', '../actions/close_ticket.php', true);
               xhr.setRequestHeader('Content-Type', 'application/json');
    
               xhr.onreadystatechange = function() {
                   if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                       // Ticket closed successfully
                       // Hide the comment input and add comment button
                       const addCommentDiv = document.getElementById('add-comment');
                       addCommentDiv.style.display = 'none';
                   }
               };
    
               xhr.send(JSON.stringify({ ticketId: ticketId }));
           }
       });
    });