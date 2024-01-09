const naosei = document.querySelector('.naosei');
const loginLink = document.querySelector('.loginlink');
const registerLink = document.querySelector('.registerlink');
const btnPopup = document.querySelector('.loginbtn');
const closePopup = document.querySelector('.closeicon');

registerLink.addEventListener('click', ()=> {
    naosei.classList.add('active');
})

loginLink.addEventListener('click', ()=> {
    naosei.classList.remove('active');
})

btnPopup.addEventListener('click', ()=> {
    naosei.classList.add('active-popup');
})

closePopup.addEventListener('click', ()=> {
    naosei.classList.remove('active-popup');
})