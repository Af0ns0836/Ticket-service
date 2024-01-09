document.addEventListener('DOMContentLoaded', function() {
    const forms = document.getElementsByClassName('tag-form');
  
    for (const i = 0; i < forms.length; i++) {
      forms[i].addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission
  
        const form = event.target; // Get the form element
        const formData = new FormData(form); // Create a new FormData object
  
        const xhr = new XMLHttpRequest();
        xhr.open(form.method, form.action);
        xhr.onload = function() {
          if (xhr.status === 200) {
            // Reload the ticket list after adding the hashtag
            location.reload();
          } else {
            console.error(xhr.status);
          }
        };
        xhr.onerror = function() {
          console.error('Request failed');
        };
        xhr.send(formData);
      });
    }
  });