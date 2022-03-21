<?php 
// Start session
session_start();

// Include database
include('dbconfig.php');

// Check if LOG IN button was clicked
if(isset($_POST['login_btn'])) {
    
    // Call input field data
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Try to find the data
    try {
        $user = $auth->getUserByEmail("$email");
        try {
            // Get result from user sign-in
            $result = $auth->signInWithEmailAndPassword($email, $password);
            // Get access token from result
            $idTokenString = $result->idToken();
            try {
                // Check if the token is verified
                $verifiedIdToken = $auth->verifyIdToken($idTokenString);
                // Get ID from result
                $uid = $result->firebaseUserId();

                // Retrieve a user's current custom claims
                $claims = $auth->getUser($uid)->customClaims;
                // Check user's role
                if(isset($claims['admin']) == true) {
                    $_SESSION['verified_admin'] = true;
                    // Store ID and token into session
                    $_SESSION['verified_user_id'] = $uid;
                    $_SESSION['idTokenString'] = $idTokenString;
                } elseif(isset($claims['super_admin']) == true) {
                    $_SESSION['verified_super_admin'] = true;
                    // Store ID and token into session
                    $_SESSION['verified_user_id'] = $uid;
                    $_SESSION['idTokenString'] = $idTokenString;
                } elseif($claims == null) {
                    // Store ID and token into session
                    $_SESSION['verified_user_id'] = $uid;
                    $_SESSION['idTokenString'] = $idTokenString;
                }

                // Inform the user of the results
                $_SESSION['status'] = "Logged in successfully!";

                // Go home!
                header('Location: home.php');
                exit();
            } catch (Firebase\Auth\Token\Exception\ExpiredToken $e) {
                // Report if token is not verified, expired, or of some other related issue
                echo 'The token is invalid: '.$e->getMessage();
            }
        } catch(Exception $e) {
            // Incorrect password was given
            $_SESSION['status'] = "Incorrect password. Please try again!";
            header('Location: login.php');
            exit();
        }
    } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
        // Email address is incorrect
        $_SESSION['status'] = "Invalid email address. Please try again!";
        header('Location: login.php');
        exit();
    }

} else {
    // If nothing else, log-in completely failed!
    $_SESSION['status'] = "Log In failed. Please try again!";
    header('Location: login.php');
    exit();
}
?>