<?php include('admin-auth.php'); include('dbconfig.php'); include('includes/header.php'); ?>
<div class="container">
    <?php
    if(isset($_SESSION['status'])) {
        echo "<h5 class='alert alert-success'>".$_SESSION['status']."</h5>";
        unset($_SESSION['status']);
    }
    ?>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>
                        Update User Data
                        <a href="user-list.php" class="btn btn-danger float-end">Back</a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="code.php" method="POST">
                        <?php
                        include('dbconfig.php');
                        if(isset($_GET['id'])) {
                            $uid = $_GET['id'];
                            try {
                                $user = $auth->getUser($uid);
                                ?>
                                <div class="form-group mb-3">
                                    <label for="display_name">Display Name</label>
                                    <input type="text" value="<?=$user->displayName;?>" name="display_name" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="phone">Phone Number</label>
                                    <input type="text" value="<?=$user->phoneNumber;?>" name="phone" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <button type="submit" name="update_user_btn" class="btn btn-primary">Update User</button>
                                    <input type="hidden" name="uid" value="<?=$user->uid;?>">
                                </div>
                                <?php
                            } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
                                echo $e->getMessage();
                            }
                        } else {

                        }
                        ?>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Enable/Disable User Account</h4>
                </div>
                <div class="card-body">
                    <form action="code.php" method="POST">
                        <?php 
                        if(isset($_GET['id'])) {
                            $uid = $_GET['id'];
                            try {
                                $user = $auth->getUser($uid);
                                ?>
                                <input type="hidden" name="ena_dis_user_id" value="<?=$uid;?>">
                                <div class="input-group mb-3">
                                    <select name="select_enable_disable" class="form-control" required>
                                        <option value="">Select</option>
                                        <option value="disable">Disable</option>
                                        <option value="enable">Enable</option>
                                    </select>
                                    <button type="submit" name="enable_disable" class="btn btn-primary">Submit</button>
                                </div>
                        <?php
                            } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
                                echo $e->getMessage();
                            }
                        } else {
                            echo 'No user ID found';
                        }
                        ?>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <hr>
        </div>
        <div class="col-md-6">
            <div class="card mt-4">
                <div class="card-header">
                    <h4>Change Password</h4>
                </div>
                <div class="card-body">
                    <form action="code.php" method="post">
                        <?php 
                        if(isset($_GET['id'])) {
                            $uid = $_GET['id'];
                            try {
                                $user = $auth->getUser($uid);
                                ?>
                                <div class="form-group mb-3">
                                    <label for="new_password">New Password</label>
                                    <input type="password" name="new_password" class="form-control" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="retype_password">Re-type Password</label>
                                    <input type="password" name="retype_password" class="form-control" required>
                                </div>
                                <div class="form-group mb-3">
                                    <button type="submit" name="change_password" class="btn btn-primary">Submit</button>
                                </div>
                                <input type="hidden" name="change_pwd_usr_id" value="<?=$uid;?>">
                                <?php
                            } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
                                echo $e->getMessage();
                            }
                        } else {
                            echo 'No ID found!';
                        }
                        ?>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mt-4">
                <div class="card-header">
                    <h4>Custom User Claims</h4>
                </div>
                <div class="card-body">
                    <form action="code.php" method="POST">
                        <?php 
                        if(isset($_GET['id'])) {
                            $uid = $_GET['id'];
                            ?>
                            <input type="hidden" name="claims_user_id" value="<?=$uid;?>">
                            <div class="form-group mb-3">
                                <select name="role_as" class="form-control" required>
                                    <option value="">Select Roles</option>
                                    <option value="admin">Admin</option>
                                    <option value="super_admin">Super Admin</option>
                                    <option value="no_role">Remove Roles</option>
                                </select>
                            </div>
                            <label for="">User Role:</label>
                            <h4 class="border bg-warning p-2">
                                <?php 
                                $claims = $auth->getUser($uid)->customClaims;
                                if(isset($claims['admin']) == true) {
                                    echo 'Admin';
                                } elseif(isset($claims['super_admin']) == true) {
                                    echo 'Super Admin';
                                } elseif($claims == null) {
                                    echo 'No Role';
                                }
                                ?>
                            </h4>
                            <div class="form-group mb-3">
                                <button type="submit" name="user_claims_btn" class="btn btn-primary">Submit</button>
                            </div>
                        <?php
                        }
                        ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>