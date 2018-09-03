<?php
ob_start('ob_gzhandler');
session_Start();
if (isset($_SESSION['username']) && isset($_SESSION['role']) && $_SESSION['role'] == 1) {
    $pageTitle = isset($_GET['page']) && $_GET['page'] == 'Pending' ? 'Pending Members' : 'Members';
    $pageTitle = isset($_GET['page']) && $_GET['page'] == 'admins' ? 'Admins' : $pageTitle;
    include('init.php');
    $action = isset($_GET['action']) ? $_GET['action'] : 'Manage';
    if ($action == 'Manage') { 
        $page = isset($_GET['page']) && $_GET['page'] == 'Pending' ? 'Pending Members' : 'Members';
        $page = isset($_GET['page']) && $_GET['page'] == 'Admins' ? 'Admins' : $page;
        $query = isset($_GET['page']) && $_GET['page'] == 'Pending' ? 'role != 1 AND active = 0' : 'role != 1';
        $query = isset($_GET['page']) && $_GET['page'] == 'Admins' ? 'role = 1 AND active = 1' : $query;
        $stmt = $connection->prepare("SELECT * FROM user WHERE $query");
        $stmt->execute();
        $rows = $stmt->fetchAll(); ?>
        <div class="container">
            <h1 class="text-center text-primary font-weight-bold fa-2x mt-4 mb-4">Welcome to the managment page of the members.</h1>
            <div class="table-responsive">
                <table class="table table-bordered text-center main-table">
                    <thead class="font-weight-bold">
                        <tr>
                            <td>#ID</td>
                            <td>Username</td>
                            <td>Full Name</td>
                            <td>Email</td>
                            <td>Registered Date</td>
                            <td>Control</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($rows as $row) { ?>
                        <tr>
                            <td><?php echo $row['user_id'];?></td>
                            <td><?php echo $row['user_name'];?></td>
                            <td><?php echo $row['user_full_name'];?></td>
                            <td><?php echo $row['user_email'];?></td>
                            <td><?php echo $row['registered_date'];?></td>
                            <td>
                                <a href="?action=Edit&userid=<?php echo $row['user_id'];?>" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
                                <a href="?action=Delete&userid=<?php echo $row['user_id'];?>" class="btn btn-danger confirm"><i class="fa fa-close"></i> Delete</a>
                                <?php if ($row['active'] == 0) { ?>
                                    <a href="?action=Activate&userid=<?php echo $row['user_id'];?>" class="btn btn-primary"><i class="fa fa-lock"></i> Activate</a>
                                <?php } else { ?>
                                    <a href="?action=DeActivate&userid=<?php echo $row['user_id'];?>" class="btn btn-primary"><i class="fa fa-unlock"></i> De-Activate</a>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="mb-3 mt-3">
                <?php if ($page != 'admins') { ?>
                    <a href="?action=Add" class="btn btn-primary"><i class="fa fa-plus"></i> New Member</a>
                <?php } ?>
            </div>
        </div>
    <?php 
    } elseif ($action == 'Add') { ?>
        <div class="add-member">
            <h1 class="text-center text-primary mt-4 mb-4">Add Member Information</h1>
            <div class="container">
                <form class="form-horizontal" action="?action=Insert" method="POST">
                    <div class="row form-group form-group-lg">
                        <label class="col-sm-2 lead ">User Full Name:</label>
                        <div class="col-sm-10">
                            <input type="text" name="fullname" class="form-control" autocomplete="on" required/>
                        </div>
                    </div>
                    <div class="row form-group form-group-lg">
                        <label class="col-sm-2 lead ">Username:</label>
                        <div class="col-sm-10">
                            <input type="text" name="username" class="form-control" autocomplete="on" required/>
                        </div>
                    </div>
                    <div class="row form-group form-group-lg">
                        <label class="col-sm-2 lead ">Email:</label>
                        <div class="col-sm-10">
                            <input type="email" name="email" class="form-control" autocomplete="on" required/>
                        </div>
                    </div>
                    <div class="row form-group form-group-lg">
                        <label class="col-sm-2 lead ">Password:</label>
                        <div class="col-sm-10">
                            <input type="password" name="password1" class="form-control" autocomplete="off" placeholder="Password must be strong" required/>
                        </div>
                    </div>
                    <div class="row form-group form-group-lg">
                        <label class="col-sm-2 lead ">Re-enter Password:</label>
                        <div class="col-sm-10">
                            <input type="password" name="password2" class="form-control" autocomplete="off" placeholder="Confirm password" required/>
                        </div>
                    </div>
                    <div class="row form-group form-group-lg">
                        <label class="col-sm-2 lead ">Address:</label>
                        <div class="col-sm-10">
                            <input type="text" name="address" class="form-control" autocomplete="on" />
                        </div>
                    </div>
                    <div class="row form-group form-group-lg">
                        <label class="col-sm-2 lead ">Telephone:</label>
                        <div class="col-sm-10">
                            <input type="tel" name="telephone" class="form-control" autocomplete="on" />
                        </div>
                    </div>
                    <div class="row form-group form-group-lg">
                        <div class="col-sm-10 offset-sm-2">
                            <input type="submit" class="btn btn-primary btn-block" value="Add New Member" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php 
    } elseif ($action == 'Insert') {
        echo '<div class="container">';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // read member infromation from request post method
            echo '<div class="container">';
            echo '<h1 class="text-center text-primary mt-4 mb-4">Insert Member Information.</h1>';

            $newUsername = trim($_POST['username']);
            $newEmail = trim($_POST['email']);
            $newFullname = trim($_POST['fullname']);
            $newTelephone = trim($_POST['telephone']);
            $newAddress = trim($_POST['address']);
            $newPassword = trim($_POST['password1']);
            $newPassword2 = trim($_POST['password2']);

            $formErrors = array();

            if (empty($newUsername)) {
                $formErrors[] = 'Username can not be empty!.';
            }
            if (empty($newEmail)) {
                $formErrors[] = 'Email can not be empty!.';
            }
            if (empty($newFullname)) {
                $formErrors[] = 'Fullname can not be empty!.';
            }
            if (empty($newPassword)) {
                $formErrors[] = 'Password can not be empty!.';
            }
            if ($newPassword !== $newPassword2) {
                $formErrors[] = 'Passwords does not match!.';
            }
            if (strlen($newUsername) < 6 || strlen($newUsername) > 64) {
                $formErrors[] = 'Username length should be at least (6) and at most (64) characters!.';
            }
            if (!ctype_alnum($newUsername)) {
                $formErrors[] = 'Username should be only letters or digits!.';
            }
            if (!empty($newPassword) && (strlen($newPassword) < 8 || strlen($newPassword) > 64)) {
                $formErrors[] = 'Password length should be at least (8) and at most (64)!.';
            }
            if (!empty($formErrors)) {
                printFormErrors($formErrors);
            } else {
                $formErrors = checkUsernameOrEmailExist($newUsername, $newEmail);
                if (!empty($formErrors)) {
                    printFormErrors($formErrors);
                } else {
                    $newHashedPassword = sha1($newPassword);
                    $stmt = $connection->prepare('INSERT INTO user(user_name, user_email, user_full_name, user_password, user_telephone, address, active, registered_date) VALUES(?, ?, ?, ?, ?, ?, 1, DATE(NOW()))');
                    $stmt->execute(array($newUsername, $newEmail, $newFullname, $newHashedPassword, $newTelephone, $newAddress));
                    if ($stmt->rowCount() > 0) {
                        $msg = '<h1 class="alert alert-success text-success">Success: the data was successfully Inserted!.</h1>';
                        redirectHome($msg, 'back');
                    } else {
                        $msg = '<h1 class="alert alert-danger text-danger">Error: the data was failed to be Inserted!.</h1>';
                        redirectHome($msg, 'back');
                    }
                }
            }
        } else {
            $msg = '<div class="card-body">';
            $msg .= '<h1 class="alert alert-danger text-danger">Error: You can not acces this page directly!.</h1>';
            $msg .= '</div>';
            redirectHome($msg);
        }
        echo '</div>';
    } elseif ($action == 'Edit') {
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
        $role = isset($_SESSION['role']) ? intval($_SESSION['role']) : 0;
        if ($userid == intval($_SESSION['userid']) || $role == 1) {
            $stmt = $connection->prepare('SELECT * FROM user WHERE user_id = ? LIMIT 1');
            $stmt->execute(array($userid));
            $row = $stmt->fetch();
            $count = $stmt->rowCount();
            if ($count > 0) { ?>
                <div class="edit-member">
                    <h1 class="text-center text-primary mt-4 mb-4">Edit member information</h1>
                    <div class="container">
                        <form class="form-horizontal" action="?action=Update" method="POST">
                            <div class="row form-group form-group-lg">
                                <input type="hidden" name="userid" value="<?php echo $row['user_id'];?>">
                                <label class="col-sm-2 lead ">User Full Name:</label>
                                <div class="col-sm-10">
                                    <input type="text" name="fullname" value="<?php echo $row['user_full_name'];?>" class="form-control" autocomplete="on" required/>
                                </div>
                            </div>
                            <div class="row form-group form-group-lg">
                                <label class="col-sm-2 lead ">Username:</label>
                                <div class="col-sm-10">
                                    <input type="text" name="username" value="<?php echo $row['user_name'];?>" class="form-control" autocomplete="on" required/>
                                </div>
                            </div>
                            <div class="row form-group form-group-lg">
                                <label class="col-sm-2 lead ">Email:</label>
                                <div class="col-sm-10">
                                    <input type="email" name="email" value="<?php echo $row['user_email'];?>" class="form-control" autocomplete="on" required/>
                                </div>
                            </div>
                            <div class="row form-group form-group-lg">
                                <label class="col-sm-2 lead ">Password:</label>
                                <div class="col-sm-10">
                                    <input type="hidden" name="oldpassword" value="<?php echo $row['user_password'];?>"/>
                                    <input type="password" name="password1" class="form-control" autocomplete="off" placeholder="Enter new password or leave blanck"/>
                                </div>
                            </div>
                            <div class="row form-group form-group-lg">
                                <label class="col-sm-2 lead ">Re-enter Password:</label>
                                <div class="col-sm-10">
                                    <input type="password" name="password2" class="form-control" autocomplete="off" placeholder="Re-enter password again"/>
                                </div>
                            </div>
                            <div class="row form-group form-group-lg">
                                <label class="col-sm-2 lead ">Address:</label>
                                <div class="col-sm-10">
                                    <input type="text" name="address" value="<?php echo $row['address'];?>" class="form-control" autocomplete="on" />
                                </div>
                            </div>
                            <div class="row form-group form-group-lg">
                                <label class="col-sm-2 lead ">Telephone:</label>
                                <div class="col-sm-10">
                                    <input type="tel" name="telephone" value="<?php echo $row['user_telephone'];?>" class="form-control" autocomplete="on" />
                                </div>
                            </div>
                            <div class="row form-group form-group-lg">
                                <div class="col-sm-10 offset-sm-2">
                                    <input type="submit" class="btn btn-primary btn-block" value="Save" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <?php
            } else {
                $msg = '<h1 class="text-center text-danger">Error: Invalid User ID!.</h1>';
                redirectHome($msg, 'back');
            }
        } else {
            $msg = '<h1 class="text-center text-danger">Error: this is not your ID!.</h1>';
            redirectHome($msg, 'back');
        }
    } elseif ($action == 'Update') {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            echo '<div class="container">';
            echo '<h1 class="text-center text-primary mt-4 mb-4">Update member information</h1>';
            $id = $_POST['userid'];
            $newUsername = trim($_POST['username']);
            $newEmail = trim($_POST['email']);
            $newFullname = trim($_POST['fullname']);
            $newTelephone = trim($_POST['telephone']);
            $newAddress = trim($_POST['address']);
            $newPassword = trim($_POST['password1']);

            $formErrors = array();

            if (empty($newUsername)) {
                $formErrors[] = 'Username can not be empty!.';
            }
            if (empty($newEmail)) {
                $formErrors[] = 'Email can not be empty!.';
            }
            if (empty($newFullname)) {
                $formErrors[] = 'Fullname can not be empty!.';
            }
            if (strlen($newUsername) < 6 || strlen($newUsername) > 16) {
                $formErrors[] = 'Username length should be at least (6) and at most (16) characters!.';
            }
            if (!ctype_alnum($newUsername)) {
                $formErrors[] = 'Username should be only letters or digits!.';
            }
            if (!empty($newPassword) && (strlen($newPassword) < 8 || strlen($newPassword) > 64)) {
                $formErrors[] = 'Password length should be at least (8) and at most (64)!.';
            }
            if (!empty($formErrors)) {
                printFormErrors($formErrors);
            } else {
                $formErrors = checkUsernameOrEmailExist($newUsername, $newEmail);
                if (!empty($formErrors)) {
                    printFormErrors($formErrors);
                } else {
                    $newHashedPassword = empty($newPassword) ? $_POST['oldpassword'] : sha1($newPassword);
                    $stmt = $connection->prepare('UPDATE user SET user_name = ?, user_email = ?, user_full_name = ?, user_password = ?, user_telephone = ?, address = ? WHERE user_id = ?');
                    $stmt->execute(array($newUsername, $newEmail, $newFullname, $newHashedPassword, $newTelephone, $newAddress, $id));
                    if ($stmt->rowCount() > 0) {
                        $msg = '<h1 class="alert alert-success text-success">Success: The Member Info successfully Updated!.</h1>';
                        redirectHome($msg, 'back');
                    } else {
                        $msg = '<h1 class="alert alert-danger text-danger">Error: The Member Info failed to be Updated!.</h1>';
                        redirectHome($msg, 'back');
                    }
                }
            }
        } else {
            $msg = '<div class="card-body">';
            $msg .= '<h1 class="alert alert-danger text-danger">Error: You can not acces this page directly!.</h1>';
            $msg .= '</div>';
            redirectHome($msg);
        }
        echo '</div>';
    } elseif ($action == 'Delete') {
        echo '<div class="container">';
        echo '<h1 class="text-center text-primary mt-4 mb-4">Delete member from database</h1>';
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
        $role = isset($_SESSION['role']) ? intval($_SESSION['role']) : 0;
        if ($userid == intval($_SESSION['userid']) || $role == 1) {
            $count = checkItemExist('user_id', 'user', $userid);
            if ($count > 0) {
                $stmt = $connection->prepare('DELETE FROM user WHERE user_id = :zuser');
                $stmt->bindParam(':zuser', $userid);
                $stmt->execute();
                $count = $stmt->rowCount();
                if ($count > 0) {
                    $msg = '<h1 class="alert alert-success text-success">Success: the member was successfully deleted!.</h1>';
                    redirectHome($msg, 'back');
                } else {
                    $msg = '<h1 class="alert alert-danger text-danger">Error: Unable to delete the member!.</h1>';
                    redirectHome($msg, 'back');
                }
            } else {
                $msg = '<h1 class="alert alert-danger text-danger">Error: the member id not exist!.</h1>';
                redirectHome($msg, 'back');
            }
        }
        echo '</div>';
    } elseif ($action == 'Activate') {
        echo '<div class="container">';
        echo '<h1 class="text-center text-primary mt-4 mb-4">Activate Member.</h1>';
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
        $role = isset($_SESSION['role']) ? intval($_SESSION['role']) : 0;
        if ($userid == intval($_SESSION['userid']) || $role == 1) {
            $count = checkItemExist('user_id', 'user', $userid);
            if ($count > 0) {
                $stmt = $connection->prepare('UPDATE user SET active = 1 WHERE user_id = :zuser');
                $stmt->bindParam(':zuser', $userid);
                $stmt->execute();
                $count = $stmt->rowCount();
                if ($count > 0) {
                    $msg = '<h1 class="alert alert-success text-success">Success: the member was successfully activated!.</h1>';
                    redirectHome($msg, 'back');
                } else {
                    $msg = '<h1 class="alert alert-danger text-danger">Error: Unable to activate the member!.</h1>';
                    redirectHome($msg, 'back');
                }
            } else {
                $msg = '<h1 class="alert alert-danger text-danger">Error: the member id not exist!.</h1>';
                redirectHome($msg, 'back');
            }
        }
        echo '</div>';
    } elseif ($action == 'DeActivate') {
        echo '<div class="container">';
        echo '<h1 class="text-center text-primary mt-4 mb-4"> De Activate Member.</h1>';
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
        $role = isset($_SESSION['role']) ? intval($_SESSION['role']) : 0;
        if ($userid == intval($_SESSION['userid']) || $role == 1) {
            $count = checkItemExist('user_id', 'user', $userid);
            if ($count > 0) {
                $stmt = $connection->prepare('UPDATE user SET active = 0 WHERE user_id = :zuser');
                $stmt->bindParam(':zuser', $userid);
                $stmt->execute();
                $count = $stmt->rowCount();
                if ($count > 0) {
                    $msg = '<h1 class="alert alert-success text-success">Success: the member was successfully de-activated!.</h1>';
                    redirectHome($msg, 'back');
                } else {
                    $msg = '<h1 class="alert alert-danger text-danger">Error: Unable to activate the member!.</h1>';
                    redirectHome($msg, 'back');
                }
            } else {
                $msg = '<h1 class="alert alert-danger text-danger">Error: the member id not exist!.</h1>';
                redirectHome($msg, 'back');
            }
        }
        echo '</div>';
    } else {
        $msg = '<h1 class="alert alert-danger text-danger">Error: URL is not valide!.</h1>';
        redirectHome($msg, 'back');
    }
    include($templates . 'footer.php'); 
} else {
    header('Location: profile.php');
    exit();
}
ob_end_flush();
?>
