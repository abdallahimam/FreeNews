<?php 

ob_start();
session_Start();

//$no_navbar = '';
$pageTitle = 'Home Page';
include('init.php');

$allPosts = getAllPosts('DESC');
$allComments = getAllComments('DESC');
$allCategories = getAllCategories();
$post = getLatestPosts('*', 'post', 'post_date', $count = 1);
$allCommentsForPost = getAllCommentsForPost('ASC' , $post[0]['post_id']);

if (isset($_SESSION['username'])) {
    /**
     * header('Location: profile.php');
     * exit();
     */
} else { ?>

    <div class="home">
        <div class="container-fluid">
            <div class="row mt-3">
                <div class="col-lg-3">
                    <div class="left-bar">
                        <div class="left-bar-latest">
                            <h5 class="text-secondary text-center mb-2">Posts Activities.</h5>
                            <div class="most-visited pre-scrollable">
                                <?php foreach($allPosts as $post) { ?>
                                    <div class="media mb-0 single">
                                        <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
                                        <div class="media-body">
                                            <h5 class="mt-0"><a href="profile.php?userid=<?php echo $post['post_user_id'];?>"><?php echo $post['post_user_full_name'];?></a> <span class="small">writes a</span></h5>
                                            <p class="text-secondary ml-2"><?php echo $post['post_title'];?></p>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <a href="posts.php" class="btn btn-sm btn-block btn-primary mb-3">See All</a>
                        </div>
                        <div class="left-bar-latest">
                            <h5 class="text-secondary text-center mb-2">Comments Activities.</h5>
                            <div class="most-visited pre-scrollable">
                                <?php foreach($allComments as $comment) { ?>
                                    <div class="media mb-0 single">
                                        <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
                                        <div class="media-body">
                                            <h5 class="mt-0"><a href="profile.php?userid=<?php echo $comment['comment_user_id'];?>"><?php echo $comment['user_full_name'];?></a> <span class="small">comments on</span></h5>
                                            <p class="text-secondary ml-2"><?php echo $comment['post_title'];?></p>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="middle">
                        <h1 class="mt-4"><?php echo $post['post_title'];?></h1>
                        <p class="lead">by <a href="profile.php?id=<?php echo $post['comment_post_id'];?>"><?php echo $post['post_user_full_name'];?></a></p>
                        <hr>
                        <p>
                            <span>Posted on</span>
                            <span>
                                <?php
                                    $date = date('d, F, Y', strtotime($post['post_date']));
                                    echo $date;
                                ?>
                            </span>
                            <span>at</span>
                            <span>
                                <?php
                                    $time = date('h:i a', strtotime($post['post_time']));
                                    echo $time;
                                ?>
                            </span>
                        </p>
                        <hr>
                        <img class="img-fluid rounded" src="http://placehold.it/900x300" alt="image for post">
                        <hr>
                        <p class="lead"><?php echo $post['post_content'];?><p>
                        <hr>
                        <div class="card my-4">
                            <h5 class="card-header">Leave a Comment:</h5>
                            <div class="card-body">
                                <form action="post.php?action=AddComment&postid=<?php echo $post['post_id'];?>" method="POST">
                                    <div class="form-group">
                                        <textarea name="comment" class="form-control" rows="3"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </div>
                        </div>
                        <!-- Single Comment -->
                        <?php foreach($allCommentsForPost as $comment) { ?>
                        <div class="media mb-4 single">
                            <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
                            <div class="media-body">
                                <h5 class="mt-0 <?php echo $comment['comment_user_id'] == $post['post_user_id'] && isset($_SESSION['userid']) && $_SESSION['userid'] == $post['post_user_id'] ? 'my-comment' : '' ;?>"><?php echo $comment['user_full_name'];?></h5>
                                <form action="post.php?action=UpdateComment" method="POST">
                                    <div class="form-group">
                                        <input type="hidden" name="commentid" value="<?php echo $comment['comment_id'];?>"/>
                                        <textarea name="comment" class="form-control textarea-g" rows="3" readonly><?php echo $comment['comment_content'];?></textarea>
                                    </div>
                                    <?php
                                        if (isset($_SESSION['userid']) && $comment['comment_user_id'] == $_SESSION['userid']) {
                                            echo '<input type="button" class="btn btn-sm btn-secondary bg-secondary pull-right mr-3 edit-comment" value="Edit">';
                                        }
                                    ?>
                                </form>
                            </div>
                        </div>
                    <?php } ?>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="right-bar">
                        <!-- Search Widget -->
                        <div class="card my-4">
                            <h5 class="card-header">Search</h5>
                            <div class="card-body">
                                <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search for...">
                                <span class="input-group-btn">
                                    <button class="btn btn-secondary" type="button">Go!</button>
                                </span>
                                </div>
                            </div>
                        </div>
                        <!-- Categories Widget -->
                        <div class="card my-4">
                            <h5 class="card-header">Categories</h5>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <ul class="list-unstyled mb-0">
                                            <?php for($i = 0; $i < intval((count($allCategories) + 1) / 2); $i++) { ?>
                                                <li>
                                                    <a href="category.php?action=ShowCategory&categoryid=<?php echo $allCategories[$i]['category_id'];?>"><?php echo $allCategories[$i]['category_name'];?></a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                    <div class="col-lg-6">
                                        <ul class="list-unstyled mb-0">
                                            <?php for($i = intval((count($allCategories) + 1) / 2); $i < count($allCategories); $i++) { ?>
                                                <li>
                                                    <a href="category.php?action=ShowCategory&categoryid=<?php echo $allCategories[$i]['category_id'];?>"><?php echo $allCategories[$i]['category_name'];?></a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Side Widget -->
                        <div class="card my-4">
                            <h5 class="card-header">Top Users</h5>
                            <div class="card-body">
                                You can put anything you want inside of these side widgets. They are easy to use, and feature the new Bootstrap 4 card containers!
                            </div>
                        </div>
                        <div class="card my-4">
                            <h5 class="card-header">Top Posts</h5>
                            <div class="card-body">
                                You can put anything you want inside of these side widgets. They are easy to use, and feature the new Bootstrap 4 card containers!
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php } ?>


<?php
include($templates . 'footer.php');
ob_end_flush();
?>