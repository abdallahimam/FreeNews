<?php
ob_start('ob_gzhandler');
session_Start();
if (isset($_SESSION['username']) && isset($_SESSION['role']) && $_SESSION['role'] == 1) {
    $pageTitle = 'Dashboard';
    include('init.php');

    $latestUsersSize = 5;
    $latestUsers = getLatest('*', 'user', 'user_id', $latestUsersSize);

    $latestPostsSize = 5;
    $latestPosts = getLatest('*', 'post', 'post_id', $latestPostsSize);

    $latestCommentsSize = 5;
    $latestComments = getLatestComments($sort = 'DESC' , $limit = $latestCommentsSize);
?>
    <div class="home-stats">
        <h1 class="card-header text-center text-muted bg-light">Dashboard</h1>
        <div class="container text-center mt-3">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="stat members p-4 mb-3">
                        <i class="fa fa-users fa-5x"></i>
                        <div class="info">
                            <span class="span-header">Members.</span>
                            <span class="span-number"><a href="members.php"><?php echo countItems('user_id', 'user');?></a></span>
                        </div>                        
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="stat pending p-4 mb-3">
                        <i class="fa fa-user-plus fa-5x"></i>
                        <div class="info">
                            <span class="span-header">Pending Members.</span>
                            <span class="span-number"><a href="members.php?action=Manage&page=Pending"><?php echo countPendingUsers();?></a></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="stat posts p-4 mb-3">
                        <i class="fa fa-tags fa-5x"></i>
                        <div class="info">
                            <span class="span-header">Posts.</span>
                            <span class="span-number"><a href="posts.php"><?php echo countItems('post_id', 'post');?></a></span>
                        </div> 
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="stat members p-4 mb-3">
                        <i class="fa fa-users fa-5x"></i>
                        <div class="info">
                            <span class="span-header">Categories.</span>
                            <span class="span-number"><a href="categories.php"><?php echo countItems('category_id', 'categories');?></a></span>
                        </div>                        
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="stat posts p-4 mb-3">
                        <i class="fa fa-tags fa-5x"></i>
                        <div class="info">
                            <span class="span-header">Admins.</span>
                            <span class="span-number">
                                <a href="members.php?action=Manage&page=Admins">
                                    <?php echo countAdmins('post_id', 'post');?>
                                </a>
                            </span>
                        </div> 
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="stat comments p-4 mb-3">
                        <i class="fa fa-comments fa-5x"></i>
                        <div class="info">
                            <span class="span-header">Comments.</span>
                            <span class="span-number"><a href="comments.php"><?php echo countItems('comment_id', 'comments');?></a></span>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="the-latest mt-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-users"></i> Latest <?php echo empty($latestUsers) ? '' : count($latestUsers) . ' ';?>Registered Users.
                        </div>
                        <div class="card-body">
                            <?php
                                if (!empty($latestUsers)) {
                                    echo '<ul class="list-unstyled latest latest-users">';
                                    foreach($latestUsers as $user) {
                                        echo '<li>';
                                        echo    '<div class="row">';   
                                        echo        '<div class="col-md-6 col-sm-6">';
                                        echo            '<a href="profile.php?action=Show&userid='. $user['user_id'] . '">';
                                        echo            $user['user_full_name'];
                                        echo            '</a>';                                        
                                        echo        '</div>';
                                        echo        '<div class="col-md-6 col-sm-6">';
                                        echo            '<a href="members.php?action=Edit&userid='. $user['user_id'] . '" class="btn btn-success pull-right pt-0 pb-0">';
                                        echo                '<i class="fa fa-edit"></i> Edit';
                                        echo            '</a>';
                                        if ($user['active'] == 0) {
                                            echo        '<a href="members.php?action=Activate&userid='. $user['user_id'] . '" class="btn btn-primary pull-right pt-0 pb-0 mr-1">';
                                            echo            '<i class="fa fa-lock"></i> Activate';
                                            echo        '</a>';
                                        } else {
                                            echo        '<a href="members.php?action=DeActivate&userid='. $user['user_id'] . '" class="btn btn-primary pull-right pt-0 pb-0 mr-1">';
                                            echo            '<i class="fa fa-unlock"></i> De-Activate';
                                            echo        '</a>';
                                        }
                                        echo        '</div>';
                                        echo    '</div>';                                        
                                        echo '</li>';
                                    }
                                    echo '</ul>';
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-paper-plane"></i> Latest <?php echo empty($latestPosts) ? '' : count($latestPosts) . ' ';?>Posts.
                        </div>
                        <div class="card-body">
                            <?php
                                if (!empty($latestPosts)) {
                                    echo '<ul class="list-unstyled latest latest-posts">';
                                    foreach($latestPosts as $post) {
                                        echo '<li>';
                                        echo    '<div class="row">';   
                                        echo        '<div class="col-md-6 col-sm-6">';
                                        echo            '<a href="post.php?action=GetAll&postid='. $post['post_id'] . '">' . $post['post_title'] . '</a>';
                                        echo        '</div>';
                                        echo        '<div class="col-md-6 col-sm-6">';                                        
                                        echo            '<a href="posts.php?action=Edit&postid='.$post['post_id'].'" class="btn btn-success pull-right pt-0 pb-0 mr-1"><i class="fa fa-edit"></i> Edit</a>';
                                        echo        '</div>';  
                                        echo    '</div>';                                                                                                                      
                                        echo '</li>';
                                    }
                                    echo '</ul>';
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-paper-plane"></i> Latest <?php echo empty($latestComments) ? '' : count($latestComments) . ' ';?>Comments.
                        </div>
                        <div class="card-body">
                            <?php
                                if (!empty($latestComments)) {
                                    echo '<ul class="list-unstyled latest latest-posts">';
                                    foreach($latestComments as $comment) {
                                        echo '<li>'; ?>
                                                <div class="media mb-4 single">
                                                    <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
                                                    <div class="media-body">
                                                        <a href="profile.php?action=Show&userid=<?php echo $comment['comment_user_id'];?>"><h5 class="mt-0"><?php echo $comment['user_full_name'];?></h5></a>
                                                        <form action="post.php?action=UpdateComment" method="POST">
                                                            <div class="form-group">
                                                                <input type="hidden" name="commentid" value="<?php echo $comment['comment_id'];?>"/>
                                                                <textarea name="comment" class="form-control textarea-g" rows="3" readonly><?php echo $comment['comment_content'];?></textarea>
                                                            </div>
                                                            <?php
                                                                if ($comment['comment_user_id'] == $_SESSION['userid']) {
                                                                    echo '<input type="button" class="btn btn-sm btn-secondary bg-secondary pull-right mr-3 edit-comment" value="Edit">';
                                                                }
                                                            ?>
                                                        </form>
                                                    </div>
                                                </div>
                                    <?php
                                        echo '</li>';
                                    }
                                    echo '</ul>';
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




<?php

    include($templates . 'footer.php'); 
} else {
    header('Location: FreeNews/admin');
    exit();
}
ob_end_flush();
?>
