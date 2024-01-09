const navlink = document.querySelectorAll('.nav-link')

function linkcolor() {
    navlink.forEach(link => link.classList.remove('active'))
    this.classList.add('active')
}
navlink.forEach(link => link.addEventListener('click', linkcolor))
