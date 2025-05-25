<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creative Art Design</title>
    <link rel="stylesheet" href="../css/detail_course.css">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header class="header">~ Creative Art Design ~</header>
    <div class="container">
        <div class="card" data-lesson="class_art-design/kelas1.html"><div><h2>1. Pengantar Art Design</h2><p>Memahami dasar-dasar desain seni visual dan estetik.</p></div></div>
        <div class="card" data-lesson="class_art-design/kelas2.html"><div><h2>2. Teori Warna</h2><p>Mempelajari harmoni dan psikologi warna dalam desain.</p></div></div>
        <div class="card" data-lesson="class_art-design/kelas3.html"><div><h2>3. Komposisi Visual</h2><p>Prinsip penataan elemen dalam karya seni.</p></div></div>
        <div class="card" data-lesson="class_art-design/kelas4.html"><div><h2>4. Tipografi</h2><p>Teknik memilih dan mengatur font dalam desain.</p></div></div>
        <div class="card" data-lesson="class_art-design/kelas5.html"><div><h2>5. Alat dan Media Desain</h2><p>Penggunaan software dan media fisik dalam karya seni.</p></div></div>
        <div class="card" data-lesson="class_art-design/kelas6.html"><div><h2>6. Desain untuk Media Digital</h2><p>Membuat desain untuk web, aplikasi, dan media sosial.</p></div></div>
        <div class="card" data-lesson="class_art-design/kelas7.html"><div><h2>7. Branding dan Identitas Visual</h2><p>Mendesain logo dan elemen merek yang kuat.</p></div></div>
        <div class="card" data-lesson="class_art-design/kelas8.html"><div><h2>8. Desain UI/UX Dasar</h2><p>Dasar pengalaman pengguna dan antarmuka visual.</p></div></div>
        <div class="card" data-lesson="class_art-design/kelas9.html"><div><h2>9. Proyek Ilustrasi Digital</h2><p>Teknik ilustrasi menggunakan perangkat digital.</p></div></div>
        <div class="card" data-lesson="class_art-design/kelas10.html"><div><h2>10. Portofolio dan Presentasi</h2><p>Membuat portofolio desain dan cara menyajikannya secara profesional.</p></div></div>
    </div>

    <div class="subscription-section" id="subscription">
        <div class="plan-card">
          <h3>Perbulan</h3>
          <p class="price">Rp250.000 <span>/bulan</span></p>
          <p class="sub-price">Belajar tanpa batas dengan berlangganan selama sebulan</p>
          <p><strong>banyak keuntungan yang didapat</strong></p>
      
          <ul class="benefits">
            <li>- Akses materi tanpa batas</li>
            <li>- Materi Berkualitas</li>
            <li>- Diskusi dengan tutor</li>
            <li>- Sertifikat</li>
          </ul>
      
          <div class="button-group">
            <button class="buy">Berlangganan</button>
          </div>
        </div>
      
        <div class="plan-card">
          <h3>Pertahun</h3>
          <p class="price">Rp900.000 <span>/tahun</span></p>
          <p class="sub-price">Belajar tanpa batas selama 1 tahun</p>
          <p><strong>banyak keuntungan yang didapat</strong></p>
      
          <ul class="benefits">
            <li>- Harga lebih murah</li>
            <li>- Materi berkualitas</li>
            <li>- Akses materi tampa batas</li>
            <li>- Diskusi dengan tutor</li>
            <li>- Sertifikat</li>
          </ul>
      
          <div class="button-group">
            <button class="buy">Berlangganan</button>
          </div>
        </div>      
      
      <div id="paymentModal" class="modal">
        <div class="modal-content">
          <form id="paymentForm">
            <h3>Form Pembayaran</h3>
      
            <div class="form-group">
              <label for="nama">Nama Lengkap:</label>
              <input type="text" id="nama" required />
            </div>
      
            <div class="form-group">
              <label for="email">Email:</label>
              <input type="email" id="email" required />
            </div>
      
            <div class="form-group">
              <label for="hp">Nomor HP :</label>
              <input type="text" id="hp" required />
            </div>
      
            <div class="form-group">
              <label for="nominal">Nominal Dibayarkan:</label>
              <input type="text" id="nominal" readonly />
            </div>
      
            <div class="form-group">
              <label for="metode">Metode Pembayaran:</label>
              <select id="metode" required>
                <option value="">Pilih Pembayaran</option>
                <option value="transfer">Transfer Bank</option>
                <option value="ewallet">Gopay</option>
                <option value="ewallet">Shopee Pay</option>
                <option value="ewallet">Paypal</option>
              </select>
            </div>
      
            <div class="form-group">
              <label for="voucher">Voucher Diskon:</label>
              <input type="text" id="voucher" />
            </div>
      
            <div class="form-group checkbox">
              <input type="checkbox" id="confirm">
               Saya mengisi data dengan benar
            </div>
      
            <div class="form-actions">
              <button type="submit" id="bayarBtn" disabled>Bayar Sekarang</button>
              <button type="button" id="closeModal">Tutup</button>
            </div>
          </form>
        </div>
      </div>
      
    <a href="course.html" class="back-button">Kembali</a>
    
    <div class="modal" id="enrollModal">
      <div class="modal-content fade">
        <h3>Anda harus mendaftar dulu</h3>
        <p>Untuk mengakses materi ini, silakan daftar terlebih dahulu.</p>
        <div class="modal-actions">
          <button onclick="document.getElementById('subscription').scrollIntoView({ behavior: 'smooth' }); document.getElementById('enrollModal').style.display = 'none';">Daftar Sekarang</button>
          <button onclick="document.getElementById('enrollModal').style.display = 'none'">Nanti Saja</button>
        </div>
      </div>
    </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const cards = document.querySelectorAll('.card');
            
        cards.forEach(card => {
          card.addEventListener('click', function() {
            const lessonPath = (this.getAttribute('data-lesson'));
              const lessonNumber = parseInt(lessonPath.match(/\d+/)); // ekstrak nomor dari path

              // cek lessonNumber >= 3
              if (lessonNumber >= 3) {
                // cek udah daftar belum
                const isEnroll = checkUserEnroll();
                      
                if (!isEnroll) {
                  //kalo belum daftar
                  document.getElementById('enrollModal').style.display = 'flex';
                    return;
                  }
                }
                  
                // kalau sudah terdaftar atau lesson < 3, langsung masuk ke page yang di klik
                window.location.href = lessonPath;
            });
        });
          
      // cek status daftar user
        function checkUserEnroll() {                
          // false = belum daftar
            return false;
        }
      });

      //pembayaran
      const buyButtons = document.querySelectorAll('.buy');
      const modal = document.getElementById('paymentModal');
      const form = document.getElementById('paymentForm');
      const nominalInput = document.getElementById('nominal');
      const bayarBtn = document.getElementById('bayarBtn');
      const confirmCheckbox = document.getElementById('confirm');
      const closeModal = document.getElementById('closeModal');
      
      const prices = [
        "Rp250.000", // perbulan
        "Rp900.000", // pertahun
      ];
    
      buyButtons.forEach((btn, i) => {
        btn.addEventListener('click', () => {
          modal.style.display = 'flex';
          nominalInput.value = prices[i];
        });
      });
      
      confirmCheckbox.addEventListener('change', () => {
        bayarBtn.disabled = !confirmCheckbox.checked;
      });
    
      closeModal.addEventListener('click', () => {
        modal.style.display = 'none';
        form.reset();
        bayarBtn.disabled = true;
      });
    
      form.addEventListener('submit', (e) => {
        e.preventDefault();
        alert('Terima kasih! Data Anda berhasil dikirim.');
        modal.style.display = 'none';
        form.reset();
        bayarBtn.disabled = true;
      });
    
      // Tutup modal saat klik di luar form
      window.addEventListener('click', (e) => {
        if (e.target === modal) {
          modal.style.display = 'none';
          form.reset();
          bayarBtn.disabled = true;
        }
      });
    </script>
      

</body>
</html>