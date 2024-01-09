document.addEventListener('DOMContentLoaded', function() {
    // Function to remove hashtags
    function removeHashtag(ticketId, hashtagId) {
      const xhr = new XMLHttpRequest();
      xhr.open('POST', '/../actions/remove_tags.php');
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.onload = function() {
        if (xhr.status === 200) {
          // Remove the hashtag from the DOM
          const hashtagElement = document.querySelector(
            'a.hashtag-link[data-ticket-id="' + ticketId + '"][data-hashtag-id="' + hashtagId + '"]'
          );
          hashtagElement.previousElementSibling.remove(); // Remove the preceding span element
          hashtagElement.nextElementSibling.remove(); // Remove the following line break element
          hashtagElement.remove(); // Remove the anchor tag itself
        } else {
          console.error(xhr.statusText);
        }
      };
      xhr.onerror = function() {
        console.error('Request failed');
      };
      const data = 'ticket_id=' + encodeURIComponent(ticketId) + '&hashtag_id=' + encodeURIComponent(hashtagId);
      xhr.send(data);
    }
  
    // Attach click event handler to each hashtag link
    document.addEventListener('click', function(e) {
      const target = e.target;
      if (target.matches('.hashtag-link')) {
        e.preventDefault();
        const ticketId = target.dataset.ticketId;
        const hashtagId = target.dataset.hashtagId;
        removeHashtag(ticketId, hashtagId);
      }
    });
  });
  