<?php
    /***
     * Template For Comments Page
     */
    ob_start('ob_gzhandler');
    session_start();
    $pageTitle = 'Post';
    if (isset($_SESSION['username'])) {
        include('init.php');
        $action = isset($_GET['action']) ? $_GET['action'] : 'GetAll';
        $allComments = array();
        $allCategories = getAllCategories();
        $post = array();
        if ($action == 'GetAll') {
            $sort = 'ASC';
            $sortArray = array('ASC', 'DESC');
            if (isset($_GET['sort']) && in_array($sort, $sortArray)) {
                $sort = $_GET['sort'];
            }
            $postID = isset($_GET['postid']) ? $_GET['postid'] : 'No';
            if ($postID != 'No') {
                $post = getPostById($postID);
                $allComments = getAllCommentsForPost($sort , $postID); ?>
                <div class="post">
                    <div class="container">
                        <div class="row">
                            <!-- Post Content Column -->
                            <div class="col-lg-8 col-md-12">
                                <h1 class="mt-4"><?php echo $post['post_title'];?></h1>
                                <p class="lead">by <a href="profile.php?id=<?php echo $post['comment_post_id'];?>"><?php echo $post['user_full_name'];?></a></p>
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
                                <?php foreach($allComments as $comment) { ?>
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
                                                if ($comment['comment_user_id'] == $_SESSION['userid']) {
                                                    echo '<input type="button" class="btn btn-sm btn-secondary bg-secondary pull-right mr-3 edit-comment" value="Edit">';
                                                }
                                            ?>
                                        </form>
                                    </div>
                                </div>
                                <?php } ?>
                                <!-- Comment with nested comments -->
                                <!--
                                <div class="media mb-4">
                                    <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
                                    <div class="media-body">
                                        <h5 class="mt-0">Commenter Name</h5>
                                        Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.

                                        <div class="media mt-4">
                                            <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
                                            <div class="media-body">
                                                <h5 class="mt-0">Commenter Name</h5>
                                                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                                            </div>
                                        </div>

                                        <div class="media mt-4">
                                            <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
                                            <div class="media-body">
                                                <h5 class="mt-0">Commenter Name</h5>
                                                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                -->
                            </div>
                            <!-- Sidebar Widgets Column -->
                            <div class="col-lg-4 col-md-12">
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
        <?php
            } else {
                exit();
            }
         } else if ($action == 'AddComment') {
             if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $postID = isset($_GET['postid']) ? $_GET['postid'] : 'No';
                $commentContent = trim($_POST['comment']);
                if ($postID != 'No') {
                    $formErrors = array();
                    if (empty($commentContent)) {
                        $formErrors[] = 'Empty Content Not Allowed';
                    }
                    if (!empty($formErrors)) {
                        printFormErrors($formErrors);
                        exit();
                    }
                    $count = checkItemExist('post_id', 'post', $postID);
                    if ($count > 0) {
                        $post = getPostById($postID);
                        $userID = $_SESSION['userid'];
                        $count = addComment($userID, $postID , $commentContent);
                        if ($count == 0) {
                            $msg = '<h1 class="alert alert-danger text-danger">Error: The Comment was Failed to Inserted!.</h1>';
                            redirectHome($msg, 'back');
                            exit();
                        } else {
                            $msg = '<h1 class="alert alert-success text-success">Success: The Comment was successfully Inserted!.</h1>';
                            redirectHome($msg, 'back');
                            exit();
                        }
                    } else {
                        $formErrors[] = 'Post ID Not Exist.';
                        printFormErrors($formErrors);
                        exit();
                    }
                } else {
                    // Invalid ID
                    exit();
                }
            } else {
                // You can't access page directly.
                exit();
            }
         } else if ($action == 'UpdateComment') {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $commentID = intval($_POST['commentid']);
                $commentContent = $_POST['comment'];
                if (empty($commentContent)) {
                    $formErrors[] = 'Empty Content Not Allowed';
                }
                $oldCommentContent = getFieldFromTableById('comment_content', 'comments', 'comment_id', $commentID);
                if ($commentContent == $oldCommentContent) {
                    $formErrors[] = 'No Update occured';
                }
                if (!empty($formErrors)) {
                    printFormErrors($formErrors);
                }
                $count = updateComment($commentID, $commentContent);
                if ($count == 0) {
                    $msg = '<h1 class="alert alert-danger text-danger">Error: The Comment was Failed to Updated!.</h1>';
                    redirectHome($msg, 'back');
                } else {
                    $msg = '<h1 class="alert alert-success text-success">Succes: The Comment was successfully Updated!.</h1>';
                    redirectHome($msg, 'back');
                }
            } else {
                $msg = '<div class="card-body">';
                $msg .= '<h1 class="alert alert-danger text-danger">Error: You can not acces this page directly!.</h1>';
                $msg .= '</div>';
                redirectHome($msg);
            }
         } else {
            $msg = '<div class="card-body">';
            $msg .= '<h1 class="alert alert-danger text-danger">Error: Invalid URL!.</h1>';
            $msg .= '</div>';
            redirectHome($msg);
         }
    } else {
        header('Location: /');
    }
    include($templates . 'footer.php');
    ob_end_flush();
?>