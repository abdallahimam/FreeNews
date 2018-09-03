<?php
    /***
     * Template For Categories Page
     */
    ob_start('ob_gzhandler');
    session_start();
    $pageTitle = 'Posts';
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
            $allPosts = getAllPosts($sort); ?>
            <div class="main-category mb-3 mt-0">
                <div class="container">
                    <h1 class="text-center text-primary mb-4 mt-3" >Manage Posts</h1>
                    <div class="row">
                        <div class="col-lg-8 col-md-12">
                            <div class="card main-card">
                                <div class="card-header">
                                    <span class="font-weight-bold header"><i class="fa fa-edit"></i> Manage Posts</span>
                                    <span class="total"> total: <?php echo count($allPosts);?></span>
                                    <div class="option pull-right">
                                        <span class="ordering"><i class="fa fa-sort"></i> Ordering:
                                            <a href="?sort=ASC" class="btn btn-sm btn-light <?php if ($sort == 'ASC') { echo 'active'; } ?>">Asc</a>
                                            <span>|</span>
                                            <a href="?sort=DESC" class="btn btn-sm btn-light <?php if ($sort == 'DESC') { echo 'active'; } ?>">Desc</a>
                                        </span> 
                                        <span class="view"><i class="fa fa-eye"></i> View:
                                            <span class="btn btn-sm btn-light active" data-view="full">Full</span>
                                            <span>|</span>
                                            <span class="btn btn-sm btn-light" data-view="classic">Classic</span>
                                        </span>
                                    </div>
                                </div>
                                <?php foreach($allPosts as $post) {?>
                                    <div class="card-body border-bottom edit-card pb-0 pt-3">
                                        <div class="hidden-bottons hidden-bottons-post">
                                            <a href="posts.php?action=Edit&postid=<?php echo $post['post_id'];?>" class="btn btn-sm btn-success "><i class="fa fa-edit"></i> Edit</a>
                                            <a href="posts.php?action=Delete&postid=<?php echo $post['post_id'];?>" class="btn btn-sm btn-danger confirm"><i class="fa fa-close"></i> Delete</a>
                                            <?php if ($post['post_allow_comments'] == 1 && $post['post_status'] == 1) { ?>
                                                <a href="post.php?action=GetAll&postid=<?php echo $post['post_id'];?>" class="btn btn-sm btn-primary"><i class="fa fa-commenting"></i> Comment</a>
                                            <?php } ?>
                                        </div>
                                        <div class="head-section">
                                            <h3 class="card-title mt-0 mb-3"><?php echo $post['post_title'];?></h3>
                                            <p class="posted-by border-bottom pb-2">
                                                <span class="span-posted-by">By: </span>
                                                <a href="user.php?userid=<?php echo $post['post_user_id'];?>" class="text-primary posted-by-username"><?php echo $post['post_user_full_name'];?></a>
                                            </p>
                                            <p class="posted-on border-bottom pb-2">
                                                <span class="span-posted-on text-secondary">
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
                                                </span> 
                                            </p>
                                        </div>
                                        <div class="full-view">
                                            <?php if ($post['post_content'] == '') { ?>
                                                <p class="card-text mt-1 mb-2"><?php echo 'This Post has no content.';?></p>
                                            <?php } else { ?>
                                                <p class="card-text mt-1 mb-2"><?php echo $post['post_content'];?></p>
                                            <?php } ?>
                                            <?php
                                                if ($post['post_allow_comments'] == 1){
                                                    echo '<span class="btn bg-primary mb-2 mr-2 com-enabled"><i class="fa fa-comments"></i> Comments Enabled</span>';
                                                } else {
                                                    echo '<span class="btn bg-secondary mb-2 mr-2 com-disenabled"><i class="fa fa-close"></i> Comments Disenabled</span>';
                                                }
                                                if ($post['post_status'] == 1){
                                                    echo '<span class="btn bg-success mb-2 mr-2 com-enabled"><i class="fa fa-comments"></i> Post Published</span>';
                                                } else {
                                                    echo '<span class="btn bg-danger mb-2 mr-2 com-disenabled"><i class="fa fa-close"></i> Post Not Published</span>';
                                                }
                                            ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <a href="posts.php?action=Add" class="btn btn-primary mt-3 mb-3 btn-lg"><i class="fa fa-plus"></i> New Post</a>
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
        } elseif ($action == 'Add') { 
            $allCategories = getAllCategories();
            if (!empty($allCategories)) { ?>
                <div class="add-post">
                    <h1 class="text-center text-primary mt-4 mb-4">Add New Post</h1>
                    <div class="container">
                        <form class="form-horizontal" action="?action=Insert" method="POST">
                            <div class="row form-group form-group-lg">
                                <label class="col-sm-2 lead ">Title:</label>
                                <div class="col-sm-10">
                                    <input type="hidden" name="userid" value="<?php echo $_SESSION['userid'];?>"/>
                                    <input type="text" name="title" class="form-control" autocomplete="on" placeholder="Title is required" required/>
                                </div>
                            </div>
                            <div class="row form-group form-group-lg">
                                <label class="col-sm-2 lead ">Content:</label>
                                <div class="col-sm-10">
                                    <textarea name="content" class="form-control" autocomplete="on" rows="5" placeholder="Content is required" required></textarea>
                                </div>
                            </div>
                            <div class="row form-group form-group-lg">
                                <label class="col-sm-2 lead ">Category:</label>
                                <div class="col-sm-10">
                                    <select name="category" class="custom-select custom-select-sm" required>
                                        <?php if (isset($_GET['cat']) && checkItemExist('category_name', 'categories', $_GET['cat']) > 0) {
                                            echo '<option value="no-category" selected>Select Category</option>';
                                        } else {
                                            echo '<option value="no-category">Select Category</option>';
                                        } ?>
                                        <?php foreach($allCategories as $cat) { ?>
                                            <option value="<?php echo $cat['category_id'] ;?>" <?php echo $_GET['cat'] == $cat['category_name'] ? 'selected' : '' ;?> >
                                            <?php echo $cat['category_name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group form-group-lg">
                                <label class="col-sm-2 lead ">Publishing:</label>
                                <div class="col-sm-10">
                                    <div>
                                        <input id="visibility-yes" type="radio" name="visibility" value="1" checked />
                                        <label for="visibility-yes">Yes</label>
                                    </div>
                                    <div>
                                        <input id="visibility-no" type="radio" name="visibility" value="0" />
                                        <label for="visibility-no">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group form-group-lg">
                                <label class="col-sm-2 lead ">Allow Comments:</label>
                                <div class="col-sm-10">
                                    <div>
                                        <input id="comments-yes" type="radio" name="comments" value="1" checked />
                                        <label for="comments-yes">Yes</label>
                                    </div>
                                    <div>
                                        <input id="comments-no" type="radio" name="comments" value="0" />
                                        <label for="comments-no">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group form-group-lg">
                                <div class="col-sm-10 offset-sm-2">
                                    <input type="submit" class="btn btn-primary btn-block" value="Add Category" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <?php } else {
                $msg = '<div class="card-body">';
                $msg .= '<h1 class="alert alert-danger text-danger">Error: There is no category to post on it.</h1>';
                $msg .= '<p class="text-primary">Go to <a href="categories.php?action=Add">Categories</a> Page to add new category.</p>';
                $msg .= '</div>';
            } ?>
        <?php
        } elseif ($action == 'Insert') {
            echo '<div class="container">';
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // read member infromation from request post method
                echo '<div class="container">';
                echo '<h1 class="text-center text-primary mt-4 mb-4">Insert Post Information.</h1>';

                $postTitle = trim($_POST['title']);
                $postContent = trim($_POST['content']);
                $postVisible = intval(trim($_POST['visibility']));
                $postComments = intval(trim($_POST['comments']));
                $postCategory = intval($_POST['category']);
                $userID = intval($_POST['userid']);
                $formErrors = array();

                if (empty($postTitle)) {
                    $formErrors[] = 'Post title can not be empty!.';
                }
                if (empty($postContent)) {
                    $formErrors[] = 'Post content can not be empty!.';
                }
                if ($postCategory == 'no-category') {
                    $formErrors[] = 'Post should belong to category!.';
                }
                if (!empty($formErrors)) {
                    printFormErrors($formErrors);
                } else {
                    $stmt = $connection->prepare('INSERT INTO post(post_title, post_content, post_user_id, post_category_id, post_status, post_allow_comments, post_date, post_time) VALUES(?, ?, ?, ?, ?, ?, DATE(NOW())), TIME(NOW())');
                    $stmt->execute(array($postTitle, $postContent, $userID, $postCategory, $postVisible, $postComments));
                    if ($stmt->rowCount() > 0) {
                        $msg = '<h1 class="alert alert-success text-success">Success: The Post was successfully Inserted!.</h1>';
                        redirectHome($msg, 'back');
                    } else {
                        $msg = '<h1 class="alert alert-danger text-danger">Error: The Post was failed to be Inserted!.</h1>';
                        redirectHome($msg, 'back');
                    }
                }
            } else {
                $msg = '<div class="card-body">';
                $msg .= '<h1 class="alert alert-danger text-danger">Error: You can not acces this page directly!.</h1>';
                $msg .= '</div>';
                redirectHome($msg);
            }
            echo '</div>';
        } elseif ($action == 'Edit') {
            $postID = isset($_GET['postid']) && is_numeric($_GET['postid']) ? intval($_GET['postid']) : 0;
            $stmt = $connection->prepare('SELECT * FROM post WHERE post_id = ? LIMIT 1');
            $stmt->execute(array($postID));
            $post = $stmt->fetch();
            $count = $stmt->rowCount();
            if ($count > 0) { 
                $allCategories = getAllCategories(); ?>
                <div class="add-post">
                    <h1 class="text-center text-primary mt-4 mb-4">Edit Post</h1>
                    <div class="container">
                        <form class="form-horizontal" action="?action=Update" method="POST">
                            <div class="row form-group form-group-lg">
                                <label class="col-sm-2 lead ">Title:</label>
                                <div class="col-sm-10">
                                    <input type="hidden" name="userid" value="<?php echo $post['post_user_id'];?>"/>
                                    <input type="hidden" name="postid" value="<?php echo $post['post_id'];?>"/>
                                    <input type="text" name="title" class="form-control" autocomplete="on" placeholder="Title is required" value="<?php echo $post['post_title'];?>"  required/>
                                </div>
                            </div>
                            <div class="row form-group form-group-lg">
                                <label class="col-sm-2 lead ">Content:</label>
                                <div class="col-sm-10">
                                    <textarea name="content" class="form-control" autocomplete="on" rows="5" placeholder="Content is required" required><?php echo $post['post_content'];?></textarea>
                                </div>
                            </div>
                            <div class="row form-group form-group-lg">
                                <label class="col-sm-2 lead ">Category:</label>
                                <div class="col-sm-10">
                                    <select name="category" class="custom-select custom-select-sm" required>
                                        <option value="no-category">Select Category</option>
                                        <?php foreach($allCategories as $cat) { ?>
                                            <option value="<?php echo $cat['category_id']?>" <?php if ($cat['category_id'] == $post['post_category_id']) {echo 'selected';} ?>>
                                                <?php echo $cat['category_name'];?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group form-group-lg">
                                <label class="col-sm-2 lead ">Publishing:</label>
                                <div class="col-sm-10">
                                    <div>
                                        <input id="visibility-yes" type="radio" name="visibility" value="1" <?php if ($post['post_status'] == 1) {echo 'checked';} ?> />
                                        <label for="visibility-yes">Yes</label>
                                    </div>
                                    <div>
                                        <input id="visibility-no" type="radio" name="visibility" value="0" <?php if ($post['post_status'] == 0) {echo 'checked';} ?> />
                                        <label for="visibility-no">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group form-group-lg">
                                <label class="col-sm-2 lead ">Allow Comments:</label>
                                <div class="col-sm-10">
                                    <div>
                                        <input id="comments-yes" type="radio" name="comments" value="1" <?php if ($post['post_allow_comments'] == 1) {echo 'checked';} ?> />
                                        <label for="comments-yes">Yes</label>
                                    </div>
                                    <div>
                                        <input id="comments-no" type="radio" name="comments" value="0" <?php if ($post['post_allow_comments'] == 0) {echo 'checked';} ?> />
                                        <label for="comments-no">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group form-group-lg">
                                <div class="col-sm-10 offset-sm-2">
                                    <input type="submit" class="btn btn-primary btn-block" value="Update Category" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
        <?php } ?>
        <?php
        } elseif ($action == 'Update') {
            echo '<div class="container">';
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                echo '<h1 class="text-center text-primary mt-4 mb-4">Update Category Information.</h1>';
                $postID = intval(($_POST['postid']));
                $postTitle = trim($_POST['title']);
                $postContent = trim($_POST['content']);
                $postVisible = intval(trim($_POST['visibility']));
                $postComments = intval(trim($_POST['comments']));
                $postCategory = intval($_POST['category']);
                $userID = intval($_POST['userid']);
                $formErrors = array();

                if (empty($postTitle)) {
                    $formErrors[] = 'Post title can not be empty!.';
                }
                if (empty($postContent)) {
                    $formErrors[] = 'Post content can not be empty!.';
                }
                if ($postCategory == 'no-category') {
                    $formErrors[] = 'Post should belong to category!.';
                }
                if (!empty($formErrors)) {
                    printFormErrors($formErrors);
                } else {
                    $stmt = $connection->prepare('UPDATE post SET post_title = ?, post_content = ?, post_category_id = ?, post_status = ?, post_allow_comments = ?, post_date = DATE(NOW()), post_time = TIME(NOW()) WHERE post_id = ?');
                    $stmt->execute(array($postTitle, $postContent, $postCategory, $postVisible, $postComments, $postID));
                    if ($stmt->rowCount() > 0) {
                        $msg = '<h1 class="alert alert-success text-success">Success: The Post was successfully Updated!.</h1>';
                        redirectHome($msg, 'back');
                    } else {
                        $msg = '<h1 class="alert alert-danger text-danger">Error: The Post was failed to be Updated!.</h1>';
                        redirectHome($msg, 'back');
                    }
                }
            } else {
                $msg = '<div class="card-body">';
                $msg .= '<h1 class="alert alert-danger text-danger">Error: You can not access this page directly.</h1>';
                $msg .= '</div>';
            }
            echo '</div>';
        } elseif ($action == 'Delete') {
            echo '<div class="container">';
            echo '<h1 class="text-center text-primary mt-4 mb-4">Delete Post.</h1>';
            $postID = isset($_GET['postid']) && is_numeric($_GET['postid']) ? intval($_GET['postid']) : 0;
            $formErrors = array();
            if ($postID == 0) {
                $formErrors[] = 'Post Id must be number!.';
                printFormErrors($formErrors);
                exit();
            }
            $count = checkItemExist('post_id', 'post', $postID);
            if ($count > 0) {
                $stmt = $connection->prepare('DELETE FROM post WHERE post_id = ?');
                $stmt->execute(array($postID));
                if ($stmt->rowCount() > 0) {
                    $msg = '<h1 class="alert alert-success text-success">Success: The Post was successfully Deleted!.</h1>';
                    redirectHome($msg, 'back');
                } else {
                    $msg = '<h1 class="alert alert-danger text-danger">Error: The Post was failed to be Deleted!.</h1>';
                    redirectHome($msg, 'back');
                }
            
            } else {
                $msg = '<h1 class="alert alert-danger text-danger">Error: The Post ID not found!.</h1>';
                redirectHome($msg, 'back');
            }
            echo '</div>';
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