<?php
    /***
     * Template For Logs Page
     */
    ob_start('ob_gzhandler');
    session_start();
    $pageTitle = 'Profile';
    if (isset($_SESSION['username'])) {
        include('init.php');
        include($templates . 'footer.php');
    } else {
        header('Location: /');
    }
    ob_end_flush();
?>