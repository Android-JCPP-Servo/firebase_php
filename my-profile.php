<?php include('authentication.php'); include('includes/header.php'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php
            if(isset($_SESSION['status'])) {
                echo "<h5 class='alert alert-success'>".$_SESSION['status']."</h5>";
                unset($_SESSION['status']);
            }
            ?>
            <div class="card">
                <div class="card-header">
                    <h4>My Profile</h4>
                </div>
                <div class="card-body">
                    <?php
                    if(isset($_SESSION['verified_user_id'])) {
                        $uid = $_SESSION['verified_user_id'];
                        $user = $auth->getUser($uid);
                        ?>
                        <form action="code.php" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-8 border-end">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="display_name">Display Name</label>
                                                <input type="text" name="display_name" value="<?=$user->displayName;?>" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="display_name">Phone Number (+1 XXX XXX XXXX)</label>
                                                <input type="text" name="phone" value="<?=$user->phoneNumber;?>" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="email">Email Address</label>
                                                <input type="text" name="email" value="<?=$user->email;?>" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="role_as">Your Role</label>
                                                <div class="form-control">
                                                <?php 
                                                $claims = $auth->getUser($user->uid)->customClaims;
                                                if(isset($claims['admin']) == true) {
                                                    echo 'Admin';
                                                } elseif(isset($claims['super_admin']) == true) {
                                                    echo 'Super Admin';
                                                } elseif($claims == null) {
                                                    echo 'No Role';
                                                }
                                                ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="acc_status">Account Status</label>
                                                <div class="form-control">
                                                <?php 
                                                if($user->disabled) {
                                                    echo 'Disabled';
                                                } else {
                                                    echo 'Enabled';
                                                }
                                                ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group border mb-3">
                                        <?php
                                        if($user->photoUrl != null) {
                                            ?>
                                            <img src="<?=$user->photoUrl?>" alt="User Profile" class="w-100">
                                            <?php
                                        } else {
                                            echo "Update Profile Photo";
                                        }
                                        ?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="profile">Upload Profile Image</label>
                                        <input type="file" name="profile" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <hr>
                                    <div class="form-group mb-3">
                                        <button type="submit" name="update_user_profile" class="btn btn-primary float-end">Update Profile</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>