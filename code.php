<?php 

// ALWAYS start the session
session_start();

// Include DB connection
include('dbconfig.php');

// Check if SAVE button was clicked
if(isset($_POST['save_contact'])) {

    // Call input field data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Save data
    $postData = [
        'fname'=>$first_name,
        'lname'=>$last_name,
        'email'=>$email,
        'phone'=>$phone
    ];

    // Reference table
    $ref_table = "contacts";
    $result = $database->getReference($ref_table)->push($postData);

    // Check if data was successfully inserted
    if ($result) {
        $_SESSION['status'] = "Contact added successfully!";
        header("Location: index.php");
    } else {
        $_SESSION['status'] = "Contact not added. Please try again.";
        header("Location: index.php");
    }

}

// Check if UPDATE button was clicked
if(isset($_POST['update_contact'])) {

    // Call input field data
    $key = $_POST['key'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Save data
    $updateData = [
        'fname'=>$first_name,
        'lname'=>$last_name,
        'email'=>$email,
        'phone'=>$phone
    ];

    // Update reference
    $ref_table = 'contacts/'.$key;
    $result = $database->getReference($ref_table)->update($updateData);

    // Check if data was successfully updated
    if ($result) {
        $_SESSION['status'] = "Contact updated successfully!";
        header("Location: index.php");
    } else {
        $_SESSION['status'] = "Contact not updated. Please try again.";
        header("Location: index.php");
    }
}

// Check if DELETE button was clicked
if(isset($_POST['delete_btn'])) {
    
    // Get the ID
    $del_id = $_POST['delete_btn'];
    
    // Reference table and child for deletion
    $ref_table = 'contacts/'.$del_id;
    $result = $database->getReference($ref_table)->remove();

    // Check if data was successfully deleted
    if ($result) {
        $_SESSION['status'] = "Contact deleted successfully!";
        header("Location: index.php");
    } else {
        $_SESSION['status'] = "Contact not deleted. Please try again.";
        header("Location: index.php");
    }
}

// Check if REGISTER button was clicked
if(isset($_POST['register_btn'])) {

    // Call input field data
    $fullName = $_POST['full_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Save data
    $userProperties = [
        'email' => $email,
        'emailVerified' => false,
        'phoneNumber' => '+1'.$phone,
        'password' => $password,
        'displayName' => $fullName
    ];

    // var_dump($userProperties);
    
    // Create user in Firebase
    $createdUser = $auth->createUser($userProperties);
    // var_dump($createdUser);

    // Check if user was created successfully
    if($createdUser) {
        $_SESSION['status'] = 'Account created successfully!';
        header('Location: login.php');
        exit();
    } else {
        $_SESSION['status'] = 'Account not created successfully. Please try again!';
        header('Location: register.php');
        exit();
    }

}

// Check if the UPDATE USER button was clicked
if(isset($_POST['update_user_btn'])) {

    // Call input field data
    $uid = $_POST['uid'];
    $displayName = $_POST['display_name'];
    $phone = $_POST['phone'];

    // Save new properties
    $properties = [
        'displayName' => $displayName,
        'phoneNumber' => $phone
    ];

    // Update user if Firebase
    $updatedUser = $auth->updateUser($uid, $properties);

    // Check if user was updated
    if($updatedUser) {
        $_SESSION['status'] = 'Account updated successfully!';
        header('Location: user-list.php');
        exit();
    } else {
        $_SESSION['status'] = 'Account not updated successfully. Please try again!';
        header('Location: user-list.php');
        exit();
    }

}

// Check if the UPDATE USER button was clicked
if(isset($_POST['reg_user_delete_btn'])) {

    // Call input field data
    $uid = $_POST['reg_user_delete_btn'];

    try {
        $auth->deleteUser($uid);
        $_SESSION['status'] = 'Account deleted successfully!';
        header('Location: user-list.php');
        exit();
    } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
        // echo $e->getMessage();
        $_SESSION['status'] = 'User not found. Please try again!';
        header('Location: user-list.php');
        exit();
    } catch (\Kreait\Firebase\Exception\AuthException $e) {
        // echo 'Deleting';
        $_SESSION['status'] = 'Deleting...';
        header('Location: user-list.php');
        exit();
    }

}

// Check if ENABLE/DISABLE button was clicked
if(isset($_POST['enable_disable'])) {

    // Get Select POST data
    $uid = $_POST['ena_dis_user_id'];
    $enable_disable = $_POST['select_enable_disable'];

    // Check if ENABLED or DISABLED
    if($enable_disable == 'disable') {
        $updatedUser = $auth->disableUser($uid);
        $message = 'Account Disabled.';
    } else {
        $updatedUser = $auth->enableUser($uid);
        $message = 'Account Enabled.';
    }

    // Check if user was enabled/disabled
    if($updatedUser) {
        $_SESSION['status'] = $message;
        header('Location: user-list.php');
        exit();
    } else {
        $_SESSION['status'] = 'Something went wrong. Please try again!';
        header('Location: user-list.php');
        exit();
    }

}

// Check if CHANGE PASSWORD button was clicked
if(isset($_POST['change_password'])) {

    // Get POST data
    $uid = $_POST['change_pwd_usr_id'];
    $new_password = $_POST['new_password'];
    $retype_password = $_POST['retype_password'];

    // Check if passwords match
    if($new_password == $retype_password) {
        // Change user's password;
        $updatedUser = $auth->changeUserPassword($uid, $new_password);
        // Display success/error message
        if($updatedUser) {
            $_SESSION['status'] = 'Password successfully changed!';
            header('Location: user-list.php');
            exit();
        } else {
            $_SESSION['status'] = 'Something went wrong. Please try again!';
            header('Location: user-list.php');
            exit();
        }
    } else {
        // Report error
        $_SESSION['status'] = 'Passwords do not match. Please try again!';
        header("Location: user-edit.php?id=$uid");
        exit();
    }

}

// Check if USER CLAIMS button was clicked
if(isset($_POST['user_claims_btn'])) {

    // Get POST data
    $uid = $_POST['claims_user_id'];
    $roles = $_POST['role_as'];

    // Set User Claims
    if($roles == 'admin') {
        // Set ADMIN claims
        $auth->setCustomUserClaims($uid, ['admin' => true, 'key1' => 'value1']);
        $message = "User Role: Admin";
    } elseif($roles == 'super_admin') {
        // Set ADMIN claims
        $auth->setCustomUserClaims($uid, ['super_admin' => true, 'key1' => 'value1']);
        $message = "User Role: Super-Admin";
    } elseif($roles == 'no_role') {
        // Remove custom claims
        $auth->setCustomUserClaims($uid, null);
        $message = "User Role: No Role";
    }

    // Set status response
    if($message) {
        $_SESSION['status'] = $message;
        header("Location: user-edit.php?id=$uid");
        exit();
    } else {
        $_SESSION['status'] = 'Something went wrong. Please try again!';
        header("Location: user-edit.php?id=$uid");
        exit();
    }

}

// Check if UPDATE USER PROFILE button was clicked
if(isset($_POST['update_user_profile'])) {

    // Get POST data
    $displayName = $_POST['display_name'];
    $phone = $_POST['phone'];
    $profile = $_FILES['profile']['name'];
    $random_no = rand(1111,9999);

    // Check user ID
    $uid = $_SESSION['verified_user_id'];
    $user = $auth->getUser($uid);

    // Set up new image variable
    $new_image = $random_no.$profile;
    $old_image = $user->photoUrl;

    // Check if the profile exists
    if($profile != NULL) {
        // Add new profile image
        $filename = 'uploads/'.$new_image;
    } else {
        // Keep old photo if no change occurred
        $filename = $old_image;
    }

    // Update query
    $properties = [
        'displayName' => $displayName,
        'phoneNumber' => $phone,
        'photoUrl' => $filename
    ];
    $updatedUser = $auth->updateUser($uid, $properties);

    // Check if update was successful
    if($updatedUser) {
        if($profile != NULL) {
            move_uploaded_file($_FILES['profile']['tmp_name'], 'uploads/'.$new_image);
            // If old image exists, remove it...
            if($old_image != NULL) {
                unlink($old_image);
            }
        }
        $_SESSION['status'] = 'Profile Updated Successfully!';
        header('Location: my-profile.php');
        exit(0);
    } else {
        $_SESSION['status'] = 'Profile Not Updated Successfully!';
        header('Location: my-profile.php');
        exit(0);
    }

}

?>