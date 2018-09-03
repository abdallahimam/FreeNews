<?php
if (isset($_SESSION['username']) && isset($_SESSION['role']) && $_SESSION['role'] == 1) {
?>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="admin/dashboard.php">Free News</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li class="nav-item active">
                            <a class="nav-link" href="admin/dashboard.php"><?php echo lang('HOME_ADMIN');?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin/members.php?action=Manage"><?php echo lang('MEMBERS');?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin/posts.php"><?php echo lang('POSTS');?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin/categories.php"><?php echo lang('CATEGORIES');?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin/comments.php"><?php echo lang('COMMENTS');?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin/stats.php"><?php echo lang('STATISTICS');?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin/logs.php"><?php echo lang('LOGS');?></a>
                        </li>
                    </ul>
                    <div class="navbar-nav dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo getUsername();?>
                        </a>
                        <div class="dropdown-menu bg-dark" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item text-primary" href="profile.php">Edit Profile</a>
                            <a class="dropdown-item text-primary" href="settings.php">Settings</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-primary" href="logout.php">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
<?php } elseif (isset($_SESSION['username']) && isset($_SESSION['role']) && $_SESSION['role'] == 0) { ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="dashboard.php">Free News</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="home.php"><?php echo lang('HOME');?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="about.php"><?php echo lang('ABOUT');?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.php"><?php echo lang('CONTACT');?></a>
                        </li>
                    </ul>
                    <div class="navbar-nav dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo getUsername();?>
                        </a>
                        <div class="dropdown-menu bg-dark" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item text-primary" href="profile.php">Edit Profile</a>
                            <a class="dropdown-item text-primary" href="#">Settings</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-primary" href="logout.php">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
<?php } else { ?>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="index.php">Free News</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="home.php"><?php echo lang('HOME');?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="about.php"><?php echo lang('ABOUT');?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.php"><?php echo lang('CONTACT');?></a>
                        </li>
                        <li class="nav-item pull-right">
                            <a class="nav-link" href="login.php"><?php echo lang('LOGIN');?></a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
<?php } ?>
