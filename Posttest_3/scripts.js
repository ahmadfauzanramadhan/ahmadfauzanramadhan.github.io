function toggleMenu() {
    const navbar = document.getElementById('navbar');
    navbar.classList.toggle('open');
}

function toggleDarkMode() {
    const body = document.body;
    if (body.classList.contains('light-mode')) {
        body.classList.remove('light-mode');
        body.classList.add('dark-mode');
        document.querySelector('.dark-mode-toggle').textContent = "Ubah ke Light Mode";
    } else {
        body.classList.remove('dark-mode');
        body.classList.add('light-mode');
        document.querySelector('.dark-mode-toggle').textContent = "Ubah ke Dark Mode";
    }
}

function showPopup() {
    document.getElementById('popup-box').style.display = 'flex';
}

function closePopup() {
    document.getElementById('popup-box').style.display = 'none';
}
