function toggleMenu() {
    const menuList = document.getElementById('menu-list');
    menuList.classList.toggle('open');
}

function toggleDarkMode() {
    const body = document.body;
    const button = document.querySelector('.dark-mode-toggle');
    
    if (body.classList.contains('light-mode')) {
        body.classList.remove('light-mode');
        body.classList.add('dark-mode');
        button.textContent = "Ubah ke Light Mode";
    } else {
        body.classList.remove('dark-mode');
        body.classList.add('light-mode');
        button.textContent = "Ubah ke Dark Mode";
    }
}

function showPopup() {
    document.getElementById('popup-box').style.display = 'flex';
}

function closePopup() {
    document.getElementById('popup-box').style.display = 'none';
}

document.getElementById('order-form').addEventListener('submit', function(event) {
    event.preventDefault();
    const email = document.getElementById('email').value;
    
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        alert('Silakan masukkan email yang valid.');
        return;
    }

    const nama = document.getElementById('nama').value;
    const produk = document.getElementById('produk').value;
    const jumlah = document.getElementById('jumlah').value;
    
    // const resultDiv = document.getElementById('order-result');
    // resultDiv.innerHTML = `<p>Terima kasih, ${nama}! Anda telah memesan ${jumlah} ${produk}. Kami akan mengirimkan konfirmasi ke ${email}.</p>`;
    
    this.reset();
});
