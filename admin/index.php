<?php 

session_Start();

if (isset($_SESSION['username']) && isset($_SESSION['role']) && $_SESSION['username'] == 1) {
    header('Location: dashboard.php');
} else {
    header('Location: /FreeNews');
}

?>
