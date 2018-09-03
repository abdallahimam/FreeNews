<?php

include('connect.php');


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

