<?php
    /***
     * Template For Comments Page
     */
    ob_start('ob_gzhandler');
    session_start();
    $pageTitle = 'Comments';
    if (isset($_SESSION['username']) && isset($_SESSION['role']) && $_SESSION['role'] == 1) {
        include('init.php');
        $action = isset($_GET['action']) ? $_GET['action'] : 'Manage';
        if ($action == 'Manage') {
            $sort = 'ASC';
            $sortArray = array('ASC', 'DESC');
            if (isset($_GET['sort']) && in_array($sort, $sortArray)) {
                $sort = $_GET['sort'];
            }
            $allCategories = getAllCategories();
            $allComments = getAllComments($sort); ?>
            <div class="mb-3 mt-0">
                <div class="container">
                    <h1 class="text-center text-primary mb-4 mt-3" >Manage Comments</h1>
                    <div class="row">
                        <div class="col-lg-8 col-md-12">
                            <?php foreach($allComments as $comment) {?>
                                <div class="media mb-4 single">
                                    <a href="profile.php?userid=<?php echo $comment['comment_user_id'] ;?>" ><img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt=""></a>
                                    <div class="media-body">
                                        <h5 class="mt-0 <?php echo $comment['comment_user_id'] == $post['post_user_id'] && isset($_SESSION['userid']) && $_SESSION['userid'] == $post['post_user_id'] ? 'my-comment' : '' ;?>"><?php echo $comment['user_full_name'];?></h5>
                                        <form action="comments.php?action=Delete" method="POST">
                                            <div class="form-group">
                                                <input type="hidden" name="commentid" value="<?php echo $comment['comment_id'];?>"/>
                                                <textarea name="comment" class="form-control textarea-g" rows="3" readonly><?php echo $comment['comment_content'];?></textarea>
                                            </div>
                                            <div class="btn-group-sm ">
                                                <input type="submit" class="btn btn-danger btn-sm pull-right confirm mr-1" value="Delete"/>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
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
        } elseif ($action == 'Delete') {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                echo '<div class="container">';
                echo '<h1 class="text-center text-primary mt-4 mb-4">Delete Comment.</h1>';
                $commentID = isset($_POST['commentid']) && is_numeric($_POST['commentid']) ? intval($_POST['commentid']) : 0;
                $formErrors = array();
                if ($commentID == 0) {
                    $formErrors[] = 'Comment Id must be number!.';
                    printFormErrors($formErrors);
                }
                $count = checkItemExist('comment_id', 'comments', $commentID);
                if ($count > 0) {
                    $stmt = $connection->prepare('DELETE FROM comments WHERE comment_id = ?');
                    $stmt->execute(array($commentID));
                    if ($stmt->rowCount() > 0) {
                        $msg = '<h1 class="alert alert-success text-success">Success: The Comment was successfully Deleted!.</h1>';
                        redirectHome($msg, 'back');
                    } else {
                        $msg = '<h1 class="alert alert-danger text-danger">Error: The Comment was failed to be Deleted!.</h1>';
                        redirectHome($msg, 'back');
                    }
                } else {
                    $msg = '<h1 class="alert alert-danger text-danger">Error: The Comment ID not found!.</h1>';
                    redirectHome($msg, 'back');
                }
                echo '</div>';
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