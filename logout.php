<?php 
session_start(); 
unset($_SESSION['verified_user_id'], $_SESSION['verified_user_id']);

if(isset($_SESSION['verified_admin'])) {
    // Remove these roles if role has changed
    unset($_SESSION['verified_admin']);
    $_SESSION['status'] = "Logged out successfully!";
} elseif(isset($_SESSION['verified_super_admin'])) {
    // Remove these roles if role has changed
    unset($_SESSION['verified_super_admin']);
    $_SESSION['status'] = "Logged out successfully!";
}

if(isset($_SESSION['expired_status'])) {
    $_SESSION['status'] = 'Session expired. Please login again.';
} else {
    $_SESSION['status'] = 'Logged out successfully!';
}

header('Location: login.php');
exit();
?>