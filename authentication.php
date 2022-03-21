<?php 
session_start();
include('dbconfig.php');

if(isset($_SESSION['verified_user_id'])) {
    $uid = $_SESSION['verified_user_id'];
    $token = $_SESSION['idTokenString'];
    $idTokenString = $token;

    try {
        $verifiedIdToken = $auth->verifyIdToken($idTokenString);
        // echo "Working!";
    } catch (Firebase\Auth\Token\Exception\ExpiredToken $e) {
        $_SESSION['expired_status'] = 'The token is invalid: '.$e->getMessage().'. Please login again.';
        header('Location: logout.php');
    }

} else {
    $_SESSION['status'] = 'Please log in to access this page.';
    header('Location: login.php');
    exit();
}
?>