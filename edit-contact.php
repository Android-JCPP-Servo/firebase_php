<?php include('includes/header.php'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>
                        Update Contacts
                        <a href="index.php" class="btn btn-danger float-end">Back</a>
                    </h4>
                </div>
                <div class="card-body">
                    <?php
                    // Establish connection
                    include('dbconfig.php');
                    // Check if ID is set
                    if(isset($_GET['id'])) {
                        // Get URL key
                        $key = $_GET['id'];
                        // Initialize reference
                        $ref_table = 'contacts';
                        // Get Reference Data
                        $reference = $database->getReference($ref_table)->getChild($key)->getValue();
                        // Check if reference exists
                        if($reference > 0) {
                            ?>
                            <form action="code.php" method="POST">
                                <div class="form-group mb-3">
                                    <label for="first_name">First Name</label>
                                    <input type="text" name="first_name" value="<?=$reference['fname']?>" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" name="last_name" value="<?=$reference['lname']?>" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="email">Email Address</label>
                                    <input type="email" name="email" value="<?=$reference['email']?>" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="phone">Phone Number</label>
                                    <input type="number" name="phone" value="<?=$reference['phone']?>" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <button type="submit" name="update_contact" class="btn btn-primary">Update Contact</button>
                                    <input type="hidden" name="key" value="<?=$key;?>">
                                </div>
                            </form>
                            <?php
                        } else {
                            $_SESSION['status'] = 'Record not found! Invalid ID.';
                            header('Location: index.php');
                            exit();
                        }
                    } else {
                        $_SESSION['status'] = 'Contact not found!';
                        header('Location: index.php');
                        exit();
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>