
    document.querySelectorAll('.detail-btn').forEach(button => {
        button.addEventListener('click', function() {
            // Mengambil data dari atribut data-*
            const judul = this.getAttribute('data-judul');
            const penulis = this.getAttribute('data-penulis');
            const penerbit = this.getAttribute('data-penerbit');
            const tahun = this.getAttribute('data-tahun');
            const kategori = this.getAttribute('data-kategori');
            const halaman = this.getAttribute('data-halaman');
            const deskripsi = this.getAttribute('data-deskripsi');

            // Menampilkan detail buku
            document.getElementById('detail-judul').innerText = judul;
            document.getElementById('detail-penulis').innerText = penulis;
            document.getElementById('detail-penerbit').innerText = penerbit;
            document.getElementById('detail-tahun').innerText = tahun;
            document.getElementById('detail-kategori').innerText = kategori;
            document.getElementById('detail-halaman').innerText = halaman;
            document.getElementById('detail-deskripsi').innerText = deskripsi;

            // Sembunyikan container buku dan tampilkan container detail
            document.querySelector('.book-container').style.display = 'none';
            document.querySelector('.detail-container').style.display = 'block';
        });
    });

    document.getElementById('back-btn').addEventListener('click', function() {
        // Tampilkan container buku dan sembunyikan container detail
        document.querySelector('.book-container').style.display = 'flex';
        document.querySelector('.detail-container').style.display = 'none';
    });
