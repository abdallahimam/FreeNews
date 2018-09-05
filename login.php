<?php

ob_start();
session_start();
//$no_navbar = '';
$pageTitle = 'Login';

if (isset($_SESSION['username'])) {
    header('Location: /FreeNews');
    exit();
}

include('init.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_GET['op'] == 'login') {
        $username = $_POST['username'];
        $password = $_POST['password'];
    
        $hashed_password = sha1($password);
    
        $stmt = $connection->prepare('SELECT user_id, user_name, user_email, user_password, role FROM user WHERE user_name = ? OR user_email = ? AND user_password = ? LIMIT 1');
        $stmt->execute(array($username, $username, $hashed_password));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
        if ($count > 0) {
            $_SESSION['username'] = $row['user_name'];
            $_SESSION['userid'] = $row['user_id'];
            $_SESSION['role'] = $row['role'];
            header('Location: /FreeNews');
            exit();
        } else {
            header('Location /FreeNews');
        }
    } else if ($_GET['op'] == 'signup') {
        // read data from post request
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password1'];
        $password2 = $_POST['password2'];
        $fullname = $_POST['fullname'];
        $address = $_POST['address'];
        $telephone = $_POST['telephone'];

        $errors = validate_form($username, $email, $fullname, $password, $password2);

        if (empty($errors)) {
            $hashed_password = sha1($password);
            $stmt = $connection->prepare('SELECT user_name, user_email, user_password FROM user WHERE user_name = ? OR user_email = ?');
            $stmt->execute(array($username, $email));
            $count = $stmt->rowCount();
        
            if ($count > 0) {
                $_SESSION['error'] = 'Error: please check you information again!.';
                echo 'Error 1';
                /*header('Location: /FreeNews');
                exit();*/
            } else {
                $stmt = $connection->prepare('INSERT INTO user(user_name, user_email, user_password, user_full_name, user_telephone, address) VALUES(?, ?, ?, ?, ?, ?)');
                $status = $stmt->execute(array($username, $email, $hashed_password, $fullname, $address, $telephone));
                if ($status == TRUE) {
                    $row = $stmt->fetch();
                    $_SESSION['username'] = $username;
                    $_SESSION['userid'] = $row['user_id'];
                    $_SESSION['role'] = $row['role'];
                    header('Location: /FreeNews');
                    exit();
                } else {
                    $_SESSION['error'] = 'Error: please check you information again!.';
                    echo 'Error 2';
                    /*header('Location: /FreeNews');
                    exit();*/
                }
            }
        } else {
            echo 'Error 3';
        }
        
    } else {
        echo    '<div class="card-body">
                    <h5 class="card-title">Error</h5>
                    <p class="card-text">Invalid page.</p>
                </div>';
    }

} else { ?>
    <div class="login-page">
        <div class="container">
            <h1 class="text-center">
                <span class="selected" data-class="login">Login</span> | <span data-class="signup">Signup</span>
            </h1>
            <!-- Start Login Form -->
            <form class="login" action="<?php echo $_SERVER['PHP_SELF']; ?>?op=login" method="POST">
                <div class="input-container">
                    <input class="form-control" type="text" name="username" autocomplete="on" placeholder="Type your username or email" required />
                </div>
                <div class="input-container">
                    <input class="form-control" type="password" name="password" autocomplete="new-password" placeholder="Type your password" required />
                </div>
                <input class="btn btn-primary btn-block" name="login" type="submit" value="Login" />
            </form>
            <!-- End Login Form -->
            <!-- Start Signup Form -->
            <form class="signup" action="<?php echo $_SERVER['PHP_SELF'] ?>?op=signup" method="POST">
                <div class="input-container">
                    <input type="text" name="fullname" class="form-control" placeholder="Full name" autocomplete="on" required />
                </div>
                <div class="input-container">
                    <input pattern=".{4,}"title="Username Must Be Between 4 Chars"class="form-control" type="text" name="username" autocomplete="off"placeholder="Type your username" required />
                </div>
                <div class="input-container">
                    <input minlength="4"class="form-control" type="password" name="password1" autocomplete="new-password"placeholder="Type a Complex password" required />
                </div>
                <div class="input-container">
                    <input minlength="4"class="form-control" type="password" name="password2" autocomplete="new-password"placeholder="Type a password again" required />
                </div>
                <div class="input-container">
                    <input class="form-control" type="email" name="email" placeholder="Type a Valid email" autocomplete="on" required />
                </div>
                <div class="input-container">            
                    <input type="text" name="address" class="form-control" placeholder="Address" autocomplete="on" />
                </div>
                <div class="input-container">                
                    <input type="tel" name="telephone" class="form-control" placeholder="Telephone" autocomplete="on" />
                </div>
                <input class="btn btn-success btn-block" name="signup" type="submit" value="Signup" />
            </form>
            <!-- End Signup Form -->
            <div class="the-errors text-center">
                <?php 
                    if (!empty($formErrors)) {
                        foreach ($formErrors as $error) {
                            echo '<div class="msg error">' . $error . '</div>';
                        }
                    }
                    if (isset($succesMsg)) {
                        echo '<div class="msg success">' . $succesMsg . '</div>';
                    }
                ?>
            </div>
        </div>
    </div>
    

<?php  }

include($templates . 'footer.php');
ob_end_flush();
?>
<?php?>
<?php?>
