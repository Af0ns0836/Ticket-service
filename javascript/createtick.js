const form = document.querySelector('#ticket-form');
const ticketList = document.querySelector('#ticket-list');

form.addEventListener('submit', (event) => {
  event.preventDefault();

  const title = form.elements['title'].value;
  const department = form.elements['department'].value;
  const subject = form.elements['subject'].value;
  const description = form.elements['description'].value;

  const ticket = document.createElement('div');
  ticket.classList.add('ticket');
  ticket.innerHTML = `
    <h3>${subject}</h3>
    <p><strong>Name:</strong> ${title}</p>
    <p><strong>Department:</strong> ${department}</p>
    <p><strong>Description:</strong> ${description}</p>
  `;
  ticketList.appendChild(ticket);

  form.reset();
});
