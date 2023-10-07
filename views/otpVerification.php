<?php
// Start session 
session_start();

// // Get data from session 
// $sessData = !empty($_SESSION['sessData']) ? $_SESSION['sessData'] : '';

// // Get status from session 
// if (!empty($sessData['status']['msg'])) {
//     $statusMsg = $sessData['status']['msg'];
//     $status = $sessData['status']['type'];
//     unset($_SESSION['sessData']['status']);
// }

// $postData = array();
// if (!empty($sessData['postData'])) {
//     $postData = $sessData['postData'];
//     unset($_SESSION['postData']);
// }


// ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Quizlets | Online Flash cards & Quizzes</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="../assets/img/logo.png" rel="icon">
    <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!--  Main CSS File -->
    <link href="../assets/css/style.css" rel="stylesheet">

</head>

<body>


    <!-- ======= Header ======= -->
    <header id="header" class="d-flex align-items-center">
        <div class="container d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center ">

                <a href="index.html" class="logo"><img src="../assets/img/logo.png" alt=""></a>
                <h1 class="logo ms-2"><a href="index.html">Quiz<span>Lets</span></a></h1>
            </div>
            <!-- Uncomment below if you prefer to use an image logo -->

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto active" href="./index.php">Home</a></li>
                    <li><a class="nav-link scrollto " href="#portfolio">Quizzes</a></li>
                    <li><a class="nav-link scrollto" href="#services">Flash cards</a></li>
                    <li><a class="nav-link scrollto" href="#about">About</a></li>
                    <li><a class="nav-link scrollto" href="#team">Team</a></li>

                    <li><a class="nav-link scrollto" href="./login.php">Log in</a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

        </div>
    </header>
    <section class="main ">
        <div class=" container shadow p-4 col-8 rounded ">
            <div class="container">
                <h4 class="text-center mb-4">Verify Email</h4>
                <p class="text-center fw-semibold "> OTP sent on <span class="text-success">
                        <?php echo $_SESSION['userData']['email'] ?>
                    </span>
                </p>

                <?php if (isset($otpError)) {
                    echo '<p>' . $otpError . '</p>';

                } ?>
                <!-- Status message -->

                <?php if (!empty($statusMsg)) { ?>
                    <div class="status-msg mb-3 <?php echo $status; ?>">
                        <?php echo $statusMsg; ?>
                    </div>
                <?php } ?>
            </div>
            <form method="post" action="../userAccount.php" class="container d-flex justify-content-center gap-2 mx-auto">
                <div class="col-auto">
                    <label for="OTP" class="visually-hidden">OTP</label>
                    <input type="text" class="form-control" id="OTP" placeholder="OTP" name="otp" required>
                </div>
                <div class="col-auto">
                    <button type="submit" name="verifyOTPSubmit" class="btn btn-primary mb-3">Verify OTP</button>
                </div>
            </form>
            <a class=" mt-5 small d-flex align-items-center " href="../userAccount.php?resendOTP=1">
                <i class=' mx-3 text-dark fs-5 bx bx-log-out'></i>
                <p class="mb-1 text-center">Resend OTp</p>
            </a>
            
        </div>


    </section>

    <!-- ======= Footer ======= -->
    <footer id="footer">

        <div class="footer-newsletter">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <h4>Join Our Newsletter</h4>
                        <p>Get updated with our latest content and news</p>
                        <form action="" method="post">
                            <input type="email" name="email"><input type="submit" value="Subscribe">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-top">
            <div class="container">
                <div class="row">

                    <div class="col-lg-3 col-md-6 footer-contact">
                        <h3>Quiz<span>Lets</span></h3>
                        <p>
                            A108 Adam Street <br>
                            New York, NY 535022<br>
                            United States <br><br>
                            <strong>Phone:</strong> +1 5589 55488 55<br>
                            <strong>Email:</strong> info@example.com<br>
                        </p>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Useful Links</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">About us</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Terms of service</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy policy</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Start Learning</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Flash Cards</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Quizzes</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Marketing</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Our Social Networks</h4>
                        <p>Cras fermentum odio eu feugiat lide par naso tierra videa magna derita valies</p>
                        <div class="social-links mt-3">
                            <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                            <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                            <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                            <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                            <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="container py-4">
            <div class="copyright">
                &copy; Copyright <strong><span>QuizLets</span></strong>. All Rights Reserved
            </div>
        </div>
    </footer><!-- End Footer -->

    <div id="preloader"></div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="../assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="../assets/vendor/aos/aos.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="../assets/vendor/waypoints/noframework.waypoints.js"></script>
    <script src="../assets/vendor/php-email-form/validate.js"></script>

    <!--  Main JS File -->
    <script src="../assets/js/main.js"></script>

</body>

</html>