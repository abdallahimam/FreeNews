<?php
    /***
     * Template For Logs Page
     */
    ob_start('ob_gzhandler');
    session_start();
    $pageTitle = 'Statistics';
    if (isset($_SESSION['username']) && isset($_SESSION['role']) && $_SESSION['role'] == 1) {
        include('init.php');
        include($templates . 'footer.php');
    } else {
        header('Location: /');
    }
    ob_end_flush();
?>