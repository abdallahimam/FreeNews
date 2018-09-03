<?php
    /***
     * Template For Comments Page
     */
    ob_start('ob_gzhandler');
    session_start();
    $pageTitle = 'Category';
    if (isset($_SESSION['username'])) {
        include('init.php');
        $action = isset($_GET['action']) ? $_GET['action'] : 'GetAll';
        $allCategories = array();
        $allPosts = array();
        if ($action == 'ShowCategory') {
            $sort = 'ASC';
            $categoryID = isset($_GET['categoryid']) ? $_GET['categoryid'] : 'No';
            if ($categoryID != 'No') {
                $category = getCategoryById($categoryID);
                $allCategories = getAllCategories();
                $allPosts = getAllPostsForCategory($sort , intval($categoryID));?>
                </div class="category">
                    <div class="container">
                        <div class="row">
                            <!-- Post Content Column -->
                            <div class="col-lg-8 col-md-12">
                                <h1 class="mt-4"><?php echo $category['category_name'];?></h1>
                                <hr>
                                <p class="lead"><?php echo empty($category['category_description']) ? 'This Category does not contain description.': $category['category_description'];?><p>
                                <hr>
                                <a href="posts.php?action=Add&cat=<?php echo $category['category_name'];?>" class="btn btn-primary">Make your Post</a>
                                <hr>
                                <!-- Single Comment -->
                                <?php if (!empty($allPosts)) { foreach($allPosts as $post) { ?>
                                <div class="media mb-4 single">
                                    <a href="<?php echo $post['user_full_name'];?>"><img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt=""/></a>
                                    <div class="media-body">
                                        <h5 class="mt-0"><?php echo $post['post_title'];?></h5>
                                        <div>
                                            <p class="lead">
                                                <?php echo $post['post_content'];?>
                                            </p>
                                            <a href="post.php?action=GetAll&postid=<?php echo $post['post_id'] ;?>"></a>
                                        </div>
                                    </div>
                                </div>
                                <?php } } ?>
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
                $msg = '<div class="card-body">';
                $msg .= '<h1 class="alert alert-danger text-danger">Error: Invalid Category ID!.</h1>';
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
        exit();
    }
    include($templates . 'footer.php');
    ob_end_flush();
?>