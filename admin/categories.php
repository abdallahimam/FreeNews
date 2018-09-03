<?php
    /***
     * Template For Categories Page
     */
    ob_start('ob_gzhandler');
    session_start();
    $pageTitle = 'Categories';
    if (isset($_SESSION['username']) && isset($_SESSION['role']) && $_SESSION['role'] == 1) {
        include('init.php');
        $action = isset($_GET['action']) ? $_GET['action'] : 'Manage';
        if ($action == 'Manage') {
            $sort = 'ASC';
            $sortArray = array('ASC', 'DESC');
            if (isset($_GET['sort']) && in_array($sort, $sortArray)) {
                $sort = $_GET['sort'];
            }
            $allCategories = getAllCategories($sort); ?>
            <div class="main-category mb-3 mt-0">
                <div class="container">
                    <h1 class="text-center text-primary mb-4 mt-3" >Manage Categories</h1>
                    <div class="row">
                        <div class="col-lg-8 col-md-12">
                            <div class="card main-card">
                                <div class="card-header">
                                    <span class="font-weight-bold header"><i class="fa fa-edit"></i> Manage Categories</span>
                                    <span class="total">total: <?php echo count($allCategories);?></span>
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
                                <?php foreach($allCategories as $cat) {?>
                                    <div class="card-body border-bottom edit-card pb-0 pt-3">
                                        <div class="hidden-bottons">
                                            <a href="categories.php?action=Edit&categoryid=<?php echo $cat['category_id'];?>" class="btn btn-sm btn-success "><i class="fa fa-edit"></i> Edit</a>
                                            <a href="categories.php?action=Delete&categoryid=<?php echo $cat['category_id'];?>" class="btn btn-sm btn-danger confirm"><i class="fa fa-close"></i> Delete</a>
                                        </div>
                                        <h5 class="card-title mt-0 mb-3"><?php echo $cat['category_name'];?></h5>
                                        <div class="full-view">
                                            <?php if ($cat['category_description'] == '') { ?>
                                                <p class="card-text mt-1"><?php echo 'This categori has no description.';?></p>
                                            <?php } else { ?>
                                                <p class="card-text mt-1"><?php echo $cat['category_description'];?></p>
                                            <?php } ?>
                                            <?php 
                                                if ($cat['category_visibility'] == 1){
                                                    echo '<span class="btn bg-success mb-2 mr-2 visible"><i class="fa fa-eye"></i> Visible</span>';
                                                } else {
                                                    echo '<span class="btn bg-danger mb-2 mr-2 hidden" ><i class="fa fa-eye-slash"></i> Hidden</span>';
                                                }
                                                if ($cat['category_allow_comments'] == 1){
                                                    echo '<span class="btn bg-primary mb-2 mr-2 com-enabled"><i class="fa fa-comments"></i> Comments Enabled</span>';
                                                } else {
                                                    echo '<span class="btn bg-secondary mb-2 mr-2 com-disenabled"><i class="fa fa-close"></i> Comments Disenabled</span>';
                                                }
                                                if ($cat['category_allow_ads'] == 1){
                                                    echo '<span class="btn bg-warning mb-2 ads-enabled"><i class="fa fa-check"></i> Ads Enabled</span>';
                                                } else {
                                                    echo '<span class="btn bg-warning mb-2 ads-disenabled"><i class="fa fa-close"></i> Ads Disenabled</span>';
                                                }
                                            ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <a href="categories.php?action=Add" class="btn btn-primary mt-3 mb-3 btn-lg"><i class="fa fa-plus"></i> New Category</a>
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
        } elseif ($action == 'Add') { ?>
            <div class="add-category">
                <h1 class="text-center text-primary mt-4 mb-4">Add New Category</h1>
                <div class="container">
                    <form class="form-horizontal" action="?action=Insert" method="POST">
                        <div class="row form-group form-group-lg">
                            <label class="col-sm-2 lead ">Name:</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" autocomplete="on" required/>
                            </div>
                        </div>
                        <div class="row form-group form-group-lg">
                            <label class="col-sm-2 lead ">Description:</label>
                            <div class="col-sm-10">
                                <textarea name="description" class="form-control" autocomplete="on" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="row form-group form-group-lg">
                            <label class="col-sm-2 lead ">Ordering:</label>
                            <div class="col-sm-10">
                                <input type="number" name="ordering" class="form-control" autocomplete="on" />
                            </div>
                        </div>
                        <div class="row form-group form-group-lg">
                            <label class="col-sm-2 lead ">Visible:</label>
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
                            <label class="col-sm-2 lead ">Allow Ads:</label>
                            <div class="col-sm-10">
                                <div>
                                    <input id="ads-yes" type="radio" name="ads" value="1" checked />
                                    <label for="ads-yes">Yes</label>
                                </div>
                                <div>
                                    <input id="ads-no" type="radio" name="ads" value="0" />
                                    <label for="ads-no">No</label>
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
        <?php
        } elseif ($action == 'Insert') {
            echo '<div class="container">';
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // read member infromation from request post method
                echo '<div class="container">';
                echo '<h1 class="text-center text-primary mt-4 mb-4">Insert Category Information.</h1>';

                $categoryName = trim($_POST['name']);
                $categoryDesc = trim($_POST['description']);
                $categoryOrdering = intval(trim($_POST['ordering']));
                $categoryVisible = intval(trim($_POST['visibility']));
                $categoryComments = intval(trim($_POST['comments']));
                $categoryAds = intval(trim($_POST['ads']));

                $formErrors = array();

                if (empty($categoryName)) {
                    $formErrors[] = 'Category name can not be empty!.';
                }
                if (!empty($formErrors)) {
                    printFormErrors($formErrors);
                } else {
                    $count = checkItemExist('category_name', 'categories', $categoryName);
                    if ($count > 0) {
                        $formErrors[] = 'Category Name is already exist!.';
                        printFormErrors($formErrors);
                    } else {
                        $stmt = $connection->prepare('INSERT INTO categories(category_name, category_description, category_order, category_visibility, category_allow_comments, category_allow_ads) VALUES(?, ?, ?, ?, ?, ?)');
                        $stmt->execute(array($categoryName, $categoryDesc, $categoryOrdering, $categoryVisible, $categoryComments, $categoryAds));
                        if ($stmt->rowCount() > 0) {
                            $msg = '<h1 class="alert alert-success text-success">Success: The Category was successfully Inserted!.</h1>';
                            redirectHome($msg, 'back');
                        } else {
                            $msg = '<h1 class="alert alert-danger text-danger">Error: The Category was failed to be Inserted!.</h1>';
                            redirectHome($msg, 'back');
                        }
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
            $categoryid = isset($_GET['categoryid']) && is_numeric($_GET['categoryid']) ? intval($_GET['categoryid']) : 0;
            $role = isset($_SESSION['role']) ? intval($_SESSION['role']) : 0;
            if ($role == 1) {
                $stmt = $connection->prepare('SELECT * FROM categories WHERE category_id = ? LIMIT 1');
                $stmt->execute(array($categoryid));
                $row = $stmt->fetch();
                $count = $stmt->rowCount();
                if ($count > 0) { ?>
                    <div class="edit-category">
                        <h1 class="text-center text-primary mt-4 mb-4">Edit Category</h1>
                        <div class="container">
                            <form class="form-horizontal" action="?action=Update" method="POST">
                                <div class="row form-group form-group-lg">
                                    <label class="col-sm-2 lead ">Name:</label>
                                    <div class="col-sm-10">
                                        <input type="hidden" name="categoryid" value="<?php echo $row['category_id'];?>"/>
                                        <input type="text" name="name" class="form-control" value="<?php echo $row['category_name'];?>" autocomplete="on" required/>
                                    </div>
                                </div>
                                <div class="row form-group form-group-lg">
                                    <label class="col-sm-2 lead ">Description:</label>
                                    <div class="col-sm-10">
                                        <textarea name="description" class="form-control" autocomplete="on" rows="3"><?php echo $row['category_description'];?></textarea>
                                    </div>
                                </div>
                                <div class="row form-group form-group-lg">
                                    <label class="col-sm-2 lead ">Ordering:</label>
                                    <div class="col-sm-10">
                                        <input type="number" name="ordering" class="form-control" value="<?php echo $row['category_order'];?>" autocomplete="on" />
                                    </div>
                                </div>
                                <div class="row form-group form-group-lg">
                                    <label class="col-sm-2 lead ">Visible:</label>
                                    <div class="col-sm-10">
                                        <div>
                                            <input id="visibility-yes" type="radio" name="visibility" value="1" <?php if ($row['category_visibility'] == 1) { echo 'checked'; } ?> />
                                            <label for="visibility-yes">Yes</label>
                                        </div>
                                        <div>
                                            <input id="visibility-no" type="radio" name="visibility" value="0" <?php if ($row['category_visibility'] == 0) { echo 'checked'; } ?> />
                                            <label for="visibility-no">No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group form-group-lg">
                                    <label class="col-sm-2 lead ">Allow Comments:</label>
                                    <div class="col-sm-10">
                                        <div>
                                            <input id="comments-yes" type="radio" name="comments" value="1" <?php if ($row['category_allow_comments'] == 1) { echo 'checked'; } ?> />
                                            <label for="comments-yes">Yes</label>
                                        </div>
                                        <div>
                                            <input id="comments-no" type="radio" name="comments" value="0" <?php if ($row['category_allow_comments'] == 0) { echo 'checked'; } ?> />
                                            <label for="comments-no">No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group form-group-lg">
                                    <label class="col-sm-2 lead ">Allow Ads:</label>
                                    <div class="col-sm-10">
                                        <div>
                                            <input id="ads-yes" type="radio" name="ads" value="1" <?php if ($row['category_allow_ads'] == 1) { echo 'checked'; } ?> />
                                            <label for="ads-yes">Yes</label>
                                        </div>
                                        <div>
                                            <input id="ads-no" type="radio" name="ads" value="0" <?php if ($row['category_allow_ads'] == 0) { echo 'checked'; } ?> />
                                            <label for="ads-no">No</label>
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
                <?php
                } else {
                    $msg = '<h1 class="text-center text-danger">Error: Invalid Category ID!.</h1>';
                    redirectHome($msg, 'back');
                }
            } else {
                $msg = '<h1 class="text-center text-danger">Error: this is not your ID!.</h1>';
                redirectHome($msg, 'back');
            }
        } elseif ($action == 'Update') {
            echo '<div class="container">';
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // read member infromation from request post method
                echo '<div class="container">';
                echo '<h1 class="text-center text-primary mt-4 mb-4">Update Category Information.</h1>';

                $categoryID = $_POST['categoryid'];
                $categoryName = trim($_POST['name']);
                $categoryDesc = trim($_POST['description']);
                $categoryOrdering = intval(trim($_POST['ordering']));
                $categoryVisible = intval(trim($_POST['visibility']));
                $categoryComments = intval(trim($_POST['comments']));
                $categoryAds = intval(trim($_POST['ads']));

                $formErrors = array();

                if (empty($categoryName)) {
                    $formErrors[] = 'Category name can not be empty!.';
                }
                if (!empty($formErrors)) {
                    printFormErrors($formErrors);
                } else {
                    $count = checkItemExist('category_id', 'categories', $categoryID);
                    if ($count > 0) {
                        $stmt = $connection->prepare("SELECT * FROM categories WHERE category_id = $categoryID");
                        $stmt->execute();
                        $oldData = $stmt->fetch();
                        if ($oldData['category_name'] != $categoryName) {
                            $count = checkItemExist('category_name', 'categories', $categoryName);
                            if ($count > 0) {
                                $formErrors[] = 'Category Name is already exist!.';
                                printFormErrors($formErrors);
                            }
                        }
                        $stmt = $connection->prepare('UPDATE categories SET category_name = ?, category_description = ?, category_order = ?, category_visibility =?, category_allow_comments = ?, category_allow_ads = ? WHERE category_id = ?');
                        $stmt->execute(array($categoryName, $categoryDesc, $categoryOrdering, $categoryVisible, $categoryComments, $categoryAds, $categoryID));
                        if ($stmt->rowCount() > 0) {
                            $msg = '<h1 class="alert alert-success text-success">Success: The Category was successfully Updated!.</h1>';
                            redirectHome($msg, 'back');
                        } else {
                            $msg = '<h1 class="alert alert-danger text-danger">Error: The Category was failed to be Updated!.</h1>';
                            redirectHome($msg, 'back');
                        }
                    } else {
                        $msg = '<h1 class="alert alert-danger text-danger">Error: The Category ID not found!.</h1>';
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
        } elseif ($action == 'Delete') {
            echo '<div class="container">';
            echo '<h1 class="text-center text-primary mt-4 mb-4">Delete Category.</h1>';
            $categoryid = isset($_GET['categoryid']) && is_numeric($_GET['categoryid']) ? intval($_GET['categoryid']) : 0;
            $formErrors = array();
            if ($categoryid == 0) {
                $formErrors[] = 'Category Id must be number!.';
                printFormErrors($formErrors);
            }
            $count = checkItemExist('category_id', 'categories', $categoryid);
            if ($count > 0) {
                $stmt = $connection->prepare('DELETE FROM categories WHERE category_id = ?');
                $stmt->execute(array($categoryid));
                if ($stmt->rowCount() > 0) {
                    $msg = '<h1 class="alert alert-success text-success">Success: The Category was successfully Deleted!.</h1>';
                    redirectHome($msg, 'back');
                } else {
                    $msg = '<h1 class="alert alert-danger text-danger">Error: The Category was failed to be Deleted!.</h1>';
                    redirectHome($msg, 'back');
                }
            
            } else {
                $msg = '<h1 class="alert alert-danger text-danger">Error: The Category ID not found!.</h1>';
                redirectHome($msg, 'back');
            }
            echo '</div>';
        } else {
            echo "Error: URL is not valide";
        }
        include($templates . 'footer.php');
    } else {
        header('Location: /');
    }
    ob_end_flush();
?>