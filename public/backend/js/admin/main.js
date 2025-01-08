const menuToggle = document.querySelector('.menu-toggle');
const sidebar = document.getElementById('sidebar');
const content = document.getElementById('content');

menuToggle.addEventListener('click', () => {
    const isOpen = sidebar.classList.toggle('open');
    content.classList.toggle('nav-open');
    menuToggle.classList.toggle('open');
    menuToggle.innerHTML = isOpen ? '&#10007;' : '&#9776;';
});

function toggleDropdown(event) {
    event.preventDefault();
    const parent = event.target.parentElement;
    parent.classList.toggle('open');
}