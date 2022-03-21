<?php 
session_start();
include('dbconfig.php');

if(isset($_SESSION['verified_user_id'])) {
    if(isset($_SESSION['verified_admin'])) {
        $uid = $_SESSION['verified_user_id'];
        $token = $_SESSION['idTokenString'];
        $idTokenString = $token;
    
        try {
            $verifiedIdToken = $auth->verifyIdToken($idTokenString);
            // Retrieve a user's current custom claims
            $claims = $auth->getUser($uid)->customClaims;
            // Check user's role
            if(isset($claims['admin']) == true) {
                // echo "Working!"
            } else {
                header("Location: logout.php");
                exit(0);
            }
        } catch (FailedToVerifyToken $e) {
            $_SESSION['expired_status'] = 'The token is invalid: '.$e->getMessage().'. Please login again.';
            header('Location: logout.php');
        }
    } else {
        $_SESSION['status'] = 'Access denied.';
        header("Location: {$_SERVER["HTTP_REFERER"]}");
        exit();
    }
} else {
    $_SESSION['status'] = 'Please log in to access this page.';
    header('Location: login.php');
    exit();
}
?>