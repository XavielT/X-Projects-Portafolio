/* Js que maneja cual pagina esta activa, para resaltarla en el nav */

const currentPath = window.location.pathname.split('/').pop();

const navLinks = document.querySelectorAll('nav a');

navLinks.forEach(link => {
    if (link.getAttribute('href') === currentPath) {
        link.classList.add('active');
    }
});