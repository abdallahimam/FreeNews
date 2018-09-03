<?php

ini_set('DISPLAY_ERRORS', 'ON');
error_reporting(E_ALL);

include('admin/connect.php');

$username = '';
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
}

///   Routes for include
$templates = 'includes/templates/';
$lang = 'includes/languages/';
$functions = 'includes/functions/';

///   Routes layout
$css = 'layout/css/';
$js = 'layout/js/';
$images = 'layout/images/';

include($lang . 'english.php');
include($functions . 'functions.php');
include($templates . 'header.php');
if (!isset($no_navbar)) {
    include($templates . 'navbar.php');
}

