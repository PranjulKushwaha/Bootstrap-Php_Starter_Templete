<?php
// Start session 
session_start();

// Load and initialize user class 
include 'User.class.php';
include 'sendMail.php';


$user = new User();

$statusMsg = $valErr = '';
$status = 'error';
$redirectURL = 'views/index.php';

// $redirectURL = 'views/login.php';

if (isset($_POST['signupSubmit'])) {
	$redirectURL = 'views/registration.php';

	// Get user's input 
	$postData = $_POST;
	$first_name = trim($_POST['first_name']);
	$last_name = trim($_POST['last_name']);
	$email = trim($_POST['email']);
	$phone = trim($_POST['phone']);
	$password = trim($_POST['password']);
	$confirm_password = trim($_POST['confirm_password']);

	// Validate form fields 
	if (empty($first_name)) {
		$valErr .= 'Please enter your first name.<br/>';
	}
	if (empty($last_name)) {
		$valErr .= 'Please enter your last name.<br/>';
	}
	if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$valErr .= 'Please enter a valid email.<br/>';
	}
	if (empty($phone)) {
		$valErr .= 'Please enter your phone no.<br/>';
	}
	if (empty($password)) {
		$valErr .= 'Please enter login password.<br/>';
	}
	if (empty($confirm_password)) {
		$valErr .= 'Please confirm your password.<br/>';
	}
	if ($password !== $confirm_password) {
		$valErr .= 'Confirm password should be matched with the password.<br/>';
	}

	// Check whether user inputs are empty 
	if (empty($valErr)) {
		// Check whether the user already exists with the same email in the database 
		$prevCon['where'] = array(
			'email' => $_POST['email']
		);
		$prevCon['return_type'] = 'count';
		$prevUser = $user->getRows($prevCon);
		if ($prevUser > 0) {
			$statusMsg = 'Email already registered, please use another email.';
		} else {
			// Insert user data in the database 
			$password_hash = md5($password);
			$userData = array(
				'first_name' => $first_name,
				'last_name' => $last_name,
				'email' => $email,
				'password' => $password_hash,
				'phone' => $phone
			);

			$emailOtp = sendMail($email);


			if ($emailOtp['status']) {
				$status = 'otp_required';
				$statusMsg = $emailOtp['message'];
				$postData = '';
				$_SESSION['userData'] = $userData;

				$expiration_time = time() + 10;
				$verificationData['verification_validity'] = $expiration_time;
				$verificationData['verification_otp'] = $emailOtp['otp'];
				$_SESSION['verificationData'] = $verificationData;

				// $redirectURL = 'views/otpVerification.php';
			} else {
				$statusMsg = $emailOtp['message'];
			}
		}
	} else {
		$statusMsg = 'Please fill all the mandatory fields: ' . trim($valErr, '<br/>');
	}

	// Store registration status into the SESSION 
	$sessData['postData'] = $postData;
	$sessData['status']['type'] = $status;
	$sessData['status']['msg'] = $statusMsg;
	$_SESSION['sessData'] = $sessData;

	// Redirect to the home/registration page 
	header("Location: $redirectURL");

} elseif (isset($_POST['verifyOTPSubmit'])) {

	$redirectURL = 'views/registration.php';

	// Get user's input 
	$postData = $_POST;
	$otp = trim($_POST['otp']);
	$email = $_SESSION['userData']['email'];

	// Validate form fields 
	if (empty($email)) {
		$valErr .= 'Please Enter Email.<br/>';
	}
	if (empty($otp)) {
		$valErr .= 'Please Enter Code.<br/>';
	}
	if (empty($valErr)) {
		if ($_SESSION['verificationData']['verification_validity'] <= time()) {
			echo 'data unset';
			unset($_SESSION['verificationData']);
			header("Location: $redirectURL");

			// exit;
		}
		if ($otp == $_SESSION['verificationData']['verification_otp']) {
			$userData = $_SESSION['userData'];

			$insert = $user->insert($userData);
			if ($insert) {
				$status = 'registered';
				$statusMsg = 'User Registered successfully';
				$postData = '';

			} else {
				$statusMsg = 'Something went wrong. Please try again.';
			}
			unset($_SESSION['userData']);
			unset($_SESSION['verificationData']);
		} else {
			$status = 'otp_required';
			$statusMsg = 'Invalid Code , Please try again';
		}
	} else {
		$statusMsg = '<p>Please fill all the mandatory fields:</p>' . trim($valErr, '<br/>');
	}

	$sessData['postData'] = $postData;
	$sessData['status']['type'] = $status;
	$sessData['status']['msg'] = $statusMsg;
	$_SESSION['sessData'] = $sessData;
	header("Location: $redirectURL");


} elseif (isset($_POST['loginSubmit'])) {
	// Get user's input 
	$redirectURL = 'views/login.php';

	$postData = $_POST;
	$email = trim($_POST['email']);
	$password = trim($_POST['password']);

	// Validate form fields 
	if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$valErr .= 'Please enter a valid email.<br/>';
	}
	if (empty($password)) {
		$valErr .= 'Please enter your password.<br/>';
	}

	// Check whether user inputs are empty 
	if (empty($valErr)) {
		// Check whether the user account exists with active status in the database 
		$password_hash = md5($password);
		$conditions['where'] = array(
			'email' => $email,
			'password' => $password_hash,
			'status' => 1
		);
		$conditions['return_type'] = 'single';
		$userData = $user->getRows($conditions);

		if (!empty($userData)) {
			$status = 'success';
			$statusMsg = 'Welcome ' . $userData['first_name'] . '!';
			$postData = '';

			$sessData['userLoggedIn'] = TRUE;
			$sessData['userID'] = $userData['id'];
		} else {
			$statusMsg = 'Wrong email or password, please try again!';
		}
	} else {
		$statusMsg = '<p>Please fill all the mandatory fields:</p>' . trim($valErr, '<br/>');
	}

	// Store login status into the SESSION 
	$sessData['postData'] = $postData;
	$sessData['status']['type'] = $status;
	$sessData['status']['msg'] = $statusMsg;
	$_SESSION['sessData'] = $sessData;

	// Redirect to the home page 
	header("Location: $redirectURL");



} elseif (!empty($_REQUEST['logoutSubmit'])) {
	// Remove session data 
	unset($_SESSION['sessData']);
	session_destroy();

	// Store logout status into the SESSION 
	$sessData['status']['type'] = 'success';
	$sessData['status']['msg'] = 'You have logout successfully!';
	$_SESSION['sessData'] = $sessData;

	// Redirect to the home page 
	header("Location: $redirectURL");
} elseif (!empty($_REQUEST['resendOTP'])) {
	$redirectURL = 'views/registration.php';

	unset($_SESSION['verificationData']);

	if (isset($_SESSION['userData']['email'])) {

		$emailOtp = sendMail($_SESSION['userData']['email']);

		if ($emailOtp['status']) {
			$status = 'otp_required';
			$statusMsg = $emailOtp['message'];
			$postData = '';
			$expiration_time = time() + 9;
			$verificationData['verification_validity'] = $expiration_time;
			$verificationData['verification_otp'] = $emailOtp['otp'];
			$_SESSION['verificationData'] = $verificationData;

			$redirectURL = 'views/otpVerification.php';

		} else {
			$statusMsg = $emailOtp['message'];
		}
	} else {
		$statusMsg = 'Something went wrong. Please try again.';
	}
	// Store registration status into the SESSION 
	$sessData['postData'] = $postData;
	$sessData['status']['type'] = $status;
	$sessData['status']['msg'] = $statusMsg;
	$_SESSION['sessData'] = $sessData;
	// Redirect  
	header("Location: $redirectURL");

} elseif (isset($_POST['forgotPassword'])) {
	// Get user's input 
	$redirectURL = 'views/forgotPassword.php';

	$postData = $_POST;
	$email = trim($_POST['email']);

	// Validate form fields 
	if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$valErr .= 'Please enter a valid email.<br/>';
	}


	// Check whether user inputs are empty 
	if (empty($valErr)) {
		// Check whether the user account exists with active status in the database 
		$prevCon['where'] = array(
			'email' => $email
		);
		$prevCon['return_type'] = 'count';
		$prevUser = $user->getRows($prevCon);

		if ($prevUser > 0) {
			$emailOtp = sendMail($email);


			if ($emailOtp['status']) {
				$status = 'fogot_Password_Code_Required';
				$statusMsg = $emailOtp['message'];
				$postData = '';
				$_SESSION['userData']['email'] = $email;

				$expiration_time = time() + 9;
				$verificationData['verification_validity'] = $expiration_time;
				$verificationData['verification_otp'] = $emailOtp['otp'];
				$_SESSION['verificationData'] = $verificationData;

				$redirectURL = 'views/forgotPassword.php';
			} else {
				$statusMsg = $emailOtp['message'];
			}
		} else {
			$statusMsg = 'Email is not registered with Us';
		}
	} else {
		$statusMsg = '<p>Please fill all the mandatory fields:</p>' . trim($valErr, '<br/>');
	}

	// Store login status into the SESSION 
	$sessData['postData'] = $postData;
	$sessData['status']['type'] = $status;
	$sessData['status']['msg'] = $statusMsg;
	$_SESSION['sessData'] = $sessData;

	// Redirect to the home page 
	header("Location: $redirectURL");



} elseif (isset($_POST['forgotPasswordVerifyCode'])) {

	$redirectURL = 'views/forgotPassword.php';

	$postData = $_POST;
	$otp = trim($_POST['otp']);
	$password = trim($_POST['password']);
	$confirm_password = trim($_POST['confirm_password']);
	$email = $_SESSION['userData']['email'];

	if (empty($otp)) {
		$valErr .= 'Please Enter Code.<br/>';
	}
	if (empty($email)) {
		$valErr .= 'Please Enter Email.<br/>';
	}
	if (empty($password)) {
		$valErr .= 'Please enter login password.<br/>';
	}
	if (empty($confirm_password)) {
		$valErr .= 'Please confirm your password.<br/>';
	}
	if ($password !== $confirm_password) {
		$valErr .= 'Confirm password should be matched with the password.<br/>';

	}
	if (empty($valErr)) {

		if ($otp == $_SESSION['verificationData']['verification_otp']) {

			$password_hash = md5($password);
			$updateData = [
				'password' => $password,
				'last_name' => 'updated by script again',
			];
			$whereCondition = [
				'email' => $email
			];

			$updateStatus = $user->update($updateData, $whereCondition);

			if ($updateStatus) {
				$status = 'password_updated';
				$statusMsg = 'Password updated successfully,Proceed to login.';
				$postData = '';

			} else {
				$statusMsg = 'Something Went wrong, please try again!';
			}
		} else {
			$status = 'fogot_Password_Code_Required';
			$statusMsg = 'Invalid Code , Please try again';
		}
	} else {
		$statusMsg = '<p>Please fill all the mandatory fields:</p>' . trim($valErr, '<br/>');
	}
	// Store login status into the SESSION 
	$sessData['postData'] = $postData;
	$sessData['status']['type'] = $status;
	$sessData['status']['msg'] = $statusMsg;
	$_SESSION['sessData'] = $sessData;

	// Redirect to the home page 
	header("Location: $redirectURL");


} else {
	// Redirect to the home page 
	header("Location: $redirectURL");
}
?>