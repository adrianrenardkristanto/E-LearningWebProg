<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Learning Platform</title>
    <link rel="stylesheet" href="../css/course.css">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php
      session_start();
      if (!isset($_SESSION['user_id'])) {
          header("Location: ");
      }
      // echo '<pre>';
      // print_r($_SESSION);
      // echo '</pre>';
    ?>

    <header>
        <div class="header-container">
            <div class="logo">E-Learning</div>
            <nav class="navbar">
              <div>
                  <a href="#courses">Courses</a>
                  <a href="#about">About</a>
                  <a href="#contact">Contact</a>
              </div>
          </nav>
          <button class="login-btn" onclick="window.location.href='../logout.php'">Logout</button>
        </div> 
    </header>

    <main>
        <section class="hero" id="courses" >
            <h1>mari belajar di E-Learning</h1>
            <p>Silahkan daftar untuk memperluas jangkauan anda</p>
        </section>

        <section class="course-grid">
            <!-- Card 1 -->
            <a href="detail_desain-thinking.html" class="course-card blue" style="text-decoration: none; color: inherit;">
              <div class="course-img">
                <img src="../img/UI UX Design Illustration.jpg" alt="Digital Design Thinking">
              </div>
              <div class="course-content">
                <h3>Digital Design Thinking</h3>
                <p>Learn innovative approaches to solve complex problems with design thinking methodology applied in the digital world.</p>
                <div style="display: flex; gap: 1rem; margin: 1rem 0;">
                  <span>📁 10 Modul</span>
                  <span>⏱ 40 min</span>
                  <span>👥 1.2k</span>
                </div>
                <div style="font-size: 1.2rem; font-weight: bold; color: var(--primary); margin-top: 1rem;">
                  Rp 120.000
                </div>
              </div>
            </a>
          
            <!-- Card 2 -->
            <a href="detail_web-dev.html" class="course-card orange" style="text-decoration: none; color: inherit;">
              <div class="course-img">
                <img src="../img/Free Vector _ Space icons.jpg" alt="Web Development">
              </div>
              <div class="course-content">
                <h3>Web Development</h3>
                <p>Web development courses typically cover the basics of front-end development such as HTML, CSS, and JavaScript, as well as an introduction to back-end and database technologies.</p>
                <div style="display: flex; gap: 1rem; margin: 1rem 0;">
                  <span>📁 10 Modul</span>
                  <span>⏱ 2 hours</span>
                  <span>👥 2.5k</span>
                </div>
                <div style="font-size: 1.2rem; font-weight: bold; color: var(--danger); margin-top: 1rem;">
                  Rp 150.000
                </div>
              </div>
            </a>
          
            <!-- Card 3 -->
            <a href="detail_art-design.html" class="course-card" style="border-top: 4px solid var(--success); text-decoration: none; color: inherit;">
              <div class="course-img">
                <img src="../img/RIVERPARK_TR.jpg" alt="Creative Art Design">
              </div>
              <div class="course-content">
                <h3>Creative Art Design</h3>
                <p>Created by Art School</p>
                <p>Explore your creativity through various digital and traditional art techniques to create stunning visual works.</p>
                <div style="display: flex; gap: 1rem; margin: 1rem 0;">
                  <span>📁 10 Modul</span>
                  <span>⏱ 30 min</span>
                  <span>👥 850</span>
                </div>
                <div style="font-size: 1.2rem; font-weight: bold; color: var(--success); margin-top: 1rem;">
                  Rp 100.000
                </div>
              </div>
            </a>
          </section>
    
    <!-- about -->
    <section>
      <div id="about" class="about-section">
          <div class="course-card purple">
              <h2 class="section-title">About Us</h2>
              <p>
                Website E-Learning adalah sebuah platform pembelajaran online yang dirancang untuk mempermudah proses belajar-mengajar secara digital. Melalui website ini, anda dapat mengakses materi pelajaran, berdiskusi bersama tutor, exam, dan berbagai fitur edukatif lainnya secara fleksibel—kapan saja dan di mana saja. E-Learning hadir sebagai solusi modern untuk mendukung pendidikan yang lebih praktis, terutama di era digital seperti sekarang.
              </p>
          </div>
      </div>


    <!-- contact -->
        <div id="contact" class="contact-section">
        <div class="course-card teal">
            <h2 class="section-title">Contact Us</h2>
            <div class="sosmed">
                <div>
                    <h3>Email</h3>
                    <p>support@E-Learning.com</p>
                </div>
                <div>
                  <h3>Social Media</h3>
                  <div>
                    <a href="#"><img src="../img/57bc6698-ea98-41a6-a709-9e1e7b1b0dcd.jpg"><i class="fab fa-instagram fa-2x"></i></a>
                    <a href="#"><img src="../img/c1591799-131d-45da-bec4-7f9fce0baa92.jpg"><i class="fab fa-instagram fa-2x"></i></a>
                    <a href="#"><img src="../img/d4a10452-7b05-4aa8-a2ab-a372b5dc3369.jpg"><i class="fab fa-instagram fa-2x"></i></a>
                    <a href="#"><img src="../img/¡nstagram @uyrresss.jpg"><i class="fab fa-instagram fa-2x"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </main>
          
    <!-- Footer -->
    <footer>
      <div class="container">
        <div class="footer-content">
          <div class="footer-column">
            <h3>E-Learning</h3>
            <p>Your gateway to professional development and lifelong learning.</p>
          </div>
          <div class="footer-column">
            <h3>Quick Links</h3>
            <ul>
              <li><a href="index.html">Home</a></li>
              <li><a href="#courses">Courses</a></li>
              <li><a href="#about">About</a></li>
              <li><a href="#contact">Contact</a></li>
            </ul>
          </div>
          <div class="footer-column">
            <h3>Connect</h3>
            <div class="social-links">
              <a href="#">@Facebook <i class="fab fa-facebook-f"></i></a><br>
              <a href="#">@Twitter <i class="fab fa-twitter"></i></a><br>
              <a href="#">@Instagram <i class="fab fa-instagram"></i></a><br>
              <a href="#">@LinkedIn <i class="fab fa-linkedin-in"></i></a>
            </div>
          </div>
        </div>
        <div class="copyright">
          <p>&copy; 2025 E-Learning.</p>
        </div>
      </div>
    </footer>

    <script>
        // simulasi database
        let registeredUsers = [];
        let enrolledCourses = [];
        
        // DOM Elements
        const EnrollModal = document.getElementById('EnrollModal');
        const showRegistrationBtn = document.getElementById('show-registration');
        const closeModalBtn = document.querySelector('.close-modal');
        const enrollForm = document.getElementById('enrollForm');
        const courseCheckboxes = document.querySelectorAll('.course-checkbox');
        const totalPriceElement = document.getElementById('totalPrice');
        
        // munculin form pendaftaran
        showRegistrationBtn.addEventListener('click', function() {
            EnrollModal.style.display = 'flex';
        });
        
        // tutup form
        closeModalBtn.addEventListener('click', function() {
            EnrollModal.style.display = 'none';
        });
        
        // Close form kalau click outside
        window.addEventListener('click', function(e) {
            if (e.target === EnrollModal) {
                EnrollModal.style.display = 'none';
            }
        });
        
        // menghitung jumlah yg harus di bayar pas checkbox di klik
        courseCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', calculateTotal);
        });
        
        function calculateTotal() {
            let total = 0;
            courseCheckboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    total += parseInt(checkbox.dataset.price);
                }
            });
            
            totalPriceElement.textContent = `Total: Rp ${total.toLocaleString('id-ID')}`;
        }
        
        // Form submission
        enrollForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const fullname = document.getElementById('fullname').value;
            const email = document.getElementById('email').value;
            const paymentMethod = document.querySelector('input[name="payment"]:checked').value;
            
            // Get selected courses
            const selectedCourses = [];
            courseCheckboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    selectedCourses.push({
                        id: checkbox.dataset.course,
                        price: parseInt(checkbox.dataset.price)
                    });
                }
            });
            
            if (selectedCourses.length === 0) {
                alert('Pilih minimal satu kursus');
                return;
            }
            
            // Calculate total
            const total = selectedCourses.reduce((sum, course) => sum + course.price, 0);
            
            //(contoh) penyimpatan ke database
            const newUser = {
                id: Date.now(),
                name: fullname,
                email: email,
                courses: selectedCourses,
                paymentMethod: paymentMethod,
                totalPayment: total,
                registrationDate: new Date().toISOString(),
                isPremium: true
            };
            
            registeredUsers.push(newUser);
            enrolledCourses = [...selectedCourses];
            
            // In a real app, you would send this data to your backend //kata gpt:)
            console.log('New registration:', newUser); 
            
            // pesan berhasil
            alert(`Pendaftaran berhasil! Total pembayaran: Rp ${total.toLocaleString('id-ID')}\nAnda akan diarahkan ke premium.`);
            
            // langsung ke page premium
            sessionStorage.setItem('currentUser', JSON.stringify(newUser));
            window.location.href = '#.html';
        });
    </script>
</body>
</html>