<?php
// Start session 
session_start();

// Get data from session 
$sessData = !empty($_SESSION['sessData']) ? $_SESSION['sessData'] : '';

// Get status from session 
$statusMsg = $status = "";
if (!empty($sessData['status']['msg'])) {
    $statusMsg = $sessData['status']['msg'];
    $status = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}

$postData = array();
if (!empty($sessData['postData'])) {
    $postData = $sessData['postData'];
    unset($_SESSION['postData']);
}


?>

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


    <section class="container-fluid" style="background-color:#efefef ;">
        <div class="container py-5 col col-xl-10">
            <div class="card" style="border-radius: 1rem;">
                <div class="row g-0">
                    <div class="col-md-6 col-lg-5 d-none d-md-block">
                        <img src="../assets/img/b.jpg" alt="login form" class="img-fluid h-100 object-fit-cover"
                            style="border-radius: 1rem 0 0 1rem;" />
                    </div>
                    <div class="col-md-6 col-lg-7 h-100">
                        <div class="card-body p-4 p-lg-5 h-100  text-black">
                            <div class="d-flex align-items-center mb-5 mt-lg-3 mt-lg-2">
                                <img src="../assets/img/logo.png" alt="logo" height="50px">

                                <h3 class="ms-3 mb-0"> Quiz<span>Lets</span></h3>
                            </div>

                            <h5 class="fw-semibold mb-4 pb-2 text-center mt-3" style="letter-spacing: 1px;">Forgot Password</h5>


                            <!-- Status message -->
                            <?php if (!empty($statusMsg)) { ?>
                                <div class="status-msg mb-3 <?php echo $status; ?>">
                                    <?php echo $statusMsg; ?>
                                </div>
                            <?php } ?>


                            <?php
                            if (!empty($status) and $status == "fogot_Password_Code_Required") { ?>
                                <form class="d-flex flex-column  justify-content-end h-100" action="../userAccount.php" method="post">
                                    <p class="text-center fw-semibold my-3 "> Code sent on <span class="text-success">
                                            <?php echo $_SESSION['userData']['email'] ?>
                                        </span>
                                    </p>
                                    <!-- Email code input -->
                                    <div class="form-floating mb-3">
                                        <input id="emailCode" type="text" class="form-control" placeholder="OTP" name="otp" required>
                                        <label class="form-label" for="emailCode">Code</label>
                                    </div>
                                    <!-- Password input -->
                                    <div class="form-floating mb-3">
                                        <input id="password" class="form-control" value="12345" placeholder="Password" type="password" name="password"
                                            required="" />
                                        <label class="form-label" for="password">Password</label>
                                    </div>
                                    <!-- Password input -->
                                    <div class="form-floating mb-3">
                                        <input id="confirmPassword" class="form-control" value="12345" placeholder="Confirm Password" type="password"
                                            name="confirm_password" required="" />
                                        <label class="form-label" for="confirmPassword">Confirm Password</label>
                                    </div>

                                    <button type="submit" name="forgotPasswordVerifyCode" value="FORGOT PASSWORD"
                                        class="btn btn-dark rounded-1 btn-block mb-4">
                                        Send Code
                                    </button>
                                </form>
                                <div class="container p-3">
                                    <a class="small   text-center" href="../userAccount.php?resendOTP=1">
                                        <p class="mb-1 ">Resend Code</p>
                                    </a>

                                </div>
                                <?php
                            } else if (!empty($status) and $status == "password_updated") { ?>
                                    <div class="container p-3">
                                        <a class=" mt-5 small d-flex align-items-center " href="login.php">
                                            <i class=' mx-3 text-dark fs-5 bx bx-log-in'></i>
                                            <p class="mb-1">Log in</p>
                                        </a>
                                    </div>
                                <?php
                            } else { ?>

                                    <form class="d-flex flex-column  justify-content-end h-100" action="../userAccount.php" method="post">

                                        <!-- Email input -->
                                        <div class="form-floating mb-3">
                                            <input id="email" class="form-control" type="email" name="email" placeholder="EMAIL"
                                                value="<?php echo !empty($userData['email']) ? $userData['email'] : ''; ?>" required="" />
                                            <label class="form-label" for="email">Email address</label>
                                        </div>

                                        <!-- Submit button -->
                                        <button type="submit" name="forgotPassword" value="FORGOT PASSWORD" class="btn btn-dark rounded-1 btn-block mb-4">
                                            Send Code
                                        </button>
                                    </form>
                                <?php
                            }
                            ?>


                        </div>
                    </div>

                </div>
            </div>
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