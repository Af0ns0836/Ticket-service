document.addEventListener('DOMContentLoaded',function(){
    document.getElementById('search-btn').addEventListener('click', function() {
        const agent = document.getElementById('agent').value;
        const status = document.getElementById('status').value;
        const priority = document.getElementById('priority').value;
        const hashtag = document.getElementById('hashtag').value;
        if (!agent && !status && !priority && !hashtag) {
            // Reload the page to display all tickets
            location.reload();
            return;
        }

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/../actions/filter_tickets.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.responseType = 'json';

        xhr.onload = function() {
            if(xhr.status === 200){
                const data = xhr.response;
                console.log(data);
                let table = '<table><tr><th>Title</th><th>Tags</th><th>Published</th><th>Subject</th><th>Status</th><th>Priority</th><th>Department</th><th>Agent</th></tr>';
                for(let i = 0; i < data[0].length; i++){
                    const ticket = data[0][i];
                    const tags = data[1][i];
                    table += '<tr><td><a href="ticket.php?id=' + ticket.id + '">' + ticket.title + '</a></td><td>' +  tags + '</td><td>' + ticket.published + '</td><td>' + ticket.subject + '</td><td>' + ticket.status + '</td><td>' + ticket.priority + '</td><td>' + ticket.department + '</td><td>' + ticket.agent + '</td></tr>';
                }
                table += '</table>';
                document.getElementById('ticket-table').innerHTML = table;
                }
            };
            xhr.onerror = function() {
                alert('Error: ' + xhr.statusText);
            };
          
            const data = 'agent=' + encodeURIComponent(agent) + '&status=' + encodeURIComponent(status) + '&priority=' + encodeURIComponent(priority) + '&hashtag=' + encodeURIComponent(hashtag);
            xhr.send(data);          
    
    });  
});