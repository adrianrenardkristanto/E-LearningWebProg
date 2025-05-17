<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Learning Platform</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: ");
        }

        if (isset($_SESSION['user_id'])) {
            header("Location: learner/course.php");
        }
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

            <button class="login-btn" onclick="window.location.href='login.php'">Login</button>
        </div>
    </header>

    <main>
        <section id="courses" class="courses">
            <h2 class="section-title">Popular Courses</h2>
            <div class="course-list">
                <div class="course-card blue">
                    <div class="course-content">
                        <span class="badge badge-popular">Popular</span>
                        <h3>Digital Design Thinking</h3>
                        <p class="course-author">Created by ....</p>
                        <p class="course-description">Learn innovative approaches to solve complex problems with design thinking methodology applied in the digital world.</p>
                        <div class="course-info">
                            <span><span class="icon icon-file"></span> 17 Files</span> <!--untuk kasi liat banyak materinya -->
                            <span><span class="icon icon-time"></span> 40 min</span> <!--untuk durasi belajarnya -->
                            <span><span class="icon icon-users"></span> 1.2k</span> <!-- jumlah muridnya -->
                        </div>
                        <button class="enroll-btn">Enroll Now</button>
                    </div>
                </div>
                
                <div class="course-card orange">
                    <div class="course-content">
                        <h3>Web Development</h3>
                        <p class="course-author">Created by ....</p>
                        <p class="course-description">Web development courses typically cover the basics of front-end development such as HTML, CSS, and JavaScript, as well as an introduction to back-end and database technologies.</p>
                        <div class="course-info">
                            <span><span class="icon icon-file"></span> 20 Files</span>
                            <span><span class="icon icon-time"></span> 2 hours</span>
                            <span><span class="icon icon-users"></span> 2.5k</span>
                        </div>
                        <button class="enroll-btn">Enroll Now</button>
                    </div>
                </div>
                
                <div class="course-card green">
                    <div class="course-content">
                        <span class="badge badge-new">New</span>
                        <h3>Creative Art Design</h3>
                        <p class="course-author">Created by Art School</p>
                        <p class="course-description">Explore your creativity through various digital and traditional art techniques to create stunning visual works.</p>
                        <div class="course-info">
                            <span><span class="icon icon-file"></span> 15 Files</span>
                            <span><span class="icon icon-time"></span> 30 min</span>
                            <span><span class="icon icon-users"></span> 850</span>
                        </div>
                        <button class="enroll-btn">Enroll Now</button>
                    </div>
                </div>
                
                <div class="course-card purple">
                    <div class="course-content">
                        <h3>Data Science Fundamentals</h3>
                        <p class="course-author">Created by Data Analytics </p>
                        <p class="course-description">Comprehensive introduction to the world of data science including Python, data analysis, visualization, and basic machine learning.</p>
                        <div class="course-info">
                            <span><span class="icon icon-file"></span> 25 Files</span>
                            <span><span class="icon icon-time"></span> 3 hours</span>
                            <span><span class="icon icon-users"></span> 3.1k</span>
                        </div>
                        <button class="enroll-btn">Enroll Now</button>
                    </div>
                </div>
                
                <div class="course-card red">
                    <div class="course-content">
                        <h3>Mobile App Development</h3>
                        <p class="course-author">Created by .....</p>
                        <p class="course-description">Learn to build cross-platform mobile applications using Flutter and React Native from basic to advanced level.</p>
                        <div class="course-info">
                            <span><span class="icon icon-file"></span> 18 Files</span>
                            <span><span class="icon icon-time"></span> 2.5 hours</span>
                            <span><span class="icon icon-users"></span> 1.8k</span>
                        </div>
                        <button class="enroll-btn">Enroll Now</button>
                    </div>
                </div>
            </section>
                            
            
            <!-- Newest Courses -->
            <section>
            <h2 class="section-title">Newest Courses</h2>
            <div class="course-list">
                <div class="course-card green">
                    <div class="course-content">
                        <span class="badge badge-new">New</span>
                        <h3>UX/UI Design Principles</h3>
                        <p class="course-author">Created by .....</p>
                        <p class="course-description">Master the fundamentals of user experience and interface design to create intuitive and engaging digital products.</p>
                        <div class="course-info">
                            <span><span class="icon icon-file"></span> 14 Files</span>
                            <span><span class="icon icon-time"></span> 1.5 hours</span>
                            <span><span class="icon icon-users"></span> 650</span>
                        </div>
                        <button class="enroll-btn">Enroll Now</button>
                    </div>
                </div>
                
                <div class="course-card purple">
                    <div class="course-content">
                        <span class="badge badge-new">New</span>
                        <h3>Cloud Computing</h3>
                        <p class="course-author">Created by .....</p>
                        <p class="course-description">Learn about cloud services, deployment models, and how to leverage cloud platforms for your applications.</p>
                        <div class="course-info">
                            <span><span class="icon icon-file"></span> 18 Files</span>
                            <span><span class="icon icon-time"></span> 2 hours</span>
                            <span><span class="icon icon-users"></span> 890</span>
                        </div>
                        <button class="enroll-btn">Enroll Now</button>
                    </div>
                </div>
                
                <div class="course-card teal">
                    <div class="course-content">
                        <span class="badge badge-new">New</span>
                        <h3>Blockchain Fundamentals</h3>
                        <p class="course-author">Created by Crypto Academy</p>
                        <p class="course-description">Understand the core concepts of blockchain technology, cryptocurrencies, and smart contracts.</p>
                        <div class="course-info">
                            <span><span class="icon icon-file"></span> 12 Files</span>
                            <span><span class="icon icon-time"></span> 1 hour</span>
                            <span><span class="icon icon-users"></span> 1.2k</span>
                        </div>
                        <button class="enroll-btn">Enroll Now</button>
                    </div>
                </div>
            </div>
        </section>

        <!-- about -->
        <section>
            <div id="about" class="about-section">
                <div class="course-card orange">
                    <h2 class="section-title">About Our Platform</h2>
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
                            <a href="#"><img src="img/57bc6698-ea98-41a6-a709-9e1e7b1b0dcd.jpg"><i class="fab fa-instagram fa-2x"></i></a>
                            <a href="#"><img src="img/c1591799-131d-45da-bec4-7f9fce0baa92.jpg"><i class="fab fa-instagram fa-2x"></i></a>
                            <a href="#"><img src="img/d4a10452-7b05-4aa8-a2ab-a372b5dc3369.jpg"><i class="fab fa-instagram fa-2x"></i></a>
                            <a href="#"><img src="img/¡nstagram @uyrresss.jpg"><i class="fab fa-instagram fa-2x"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>

         <!-- Footer -->
         
        </main>
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
        // langsung masuk ke login
        document.querySelectorAll('.enroll-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const isLoggedIn = confirm('You need to login to enroll in courses. Go to login page?');
                if (isLoggedIn) {
                    window.location.href = 'login.php';
                }
            });
        });
    </script>
</body>
</html>