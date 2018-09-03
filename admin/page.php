<?php
    /***
     * Template for any page
     */
    ob_start('ob_gzhandler');
    session_start();
    if (isset($_SESSION['username'])) {
        $pageTitle = 'Members';
        include('init.php');
        $action = isset($_GET['action']) ? $_GET['action'] : 'Manage';
        if ($action == 'Manage') {
            echo "You are in page Mange";
        } elseif ($action == 'Add') {
            echo "You are in page Add";
        } elseif ($action == 'Insert') {
            echo "You are in page Insert";
        } elseif ($action == 'Edit') {
            echo "You are in page Edit";
        } elseif ($action == 'Update') {
            echo "You are in page Update";
        } elseif ($action == 'Delete') {
            echo "You are in page Delete";
        } else {
            echo "Error: URL is not valide";
        }
        include($templates . 'footer.php');
    } else {
        header('Location: FreeNews/admin');
        exit();
    }
    ob_end_flush();
?>