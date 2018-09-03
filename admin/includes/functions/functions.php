<?php

	function getPageTitle() {
		global $pageTitle;
		if (isset($pageTitle)) {
			echo $pageTitle;
		} else {
			echo 'Untitled';
		}

	}

	function printFormErrors($formErrors) {
		$msg = '<div class="card-body">';
		foreach($formErrors as $error) {
			$temp ='<p class="alert alert-danger mt-0 mb-1">' . $error . '</p>';
			$msg .= $temp;
		}
		$msg .= '</div>';
		redirectHome($msg, 'back');
	}
	
	function getUserFirstName() {
		return $_SESSION['username'];
	}

	function checkItemExist($field, $table, $value) {
		global $connection;
		$stmt = $connection->prepare("SELECT $field FROM $table WHERE $field = ?");
		$stmt->execute(array($value));
		return $stmt->rowCount();
	}

	function getItemById($field, $table, $id, $value) {
		global $connection;
		$stmt = $connection->prepare("SELECT $field FROM $table WHERE $id = ?");
		$stmt->execute(array($value));
		return $stmt->fetch();
	}

	function checkUsernameOrEmailExist($username, $email) {
		global $connection;
		$stmt = $connection->prepare('SELECT user_name, user_email FROM user WHERE user_name = ? || user_email = ?');
		$stmt->execute(array($username, $email));
		$formErrors = array();
		if ($stmt->rowCount() > 0) {
			$row = $stmt->fetch();
			if ($row['user_name'] == $username) {
				$formErrors[] = 'This Username is already exist!.';
			}
			if ($row['user_email'] == $email) {
				$formErrors[] = 'This Email is already exist!.';
			}
		}
		return $formErrors;
	}

	function getUserById($userid) {
		global $connection;
		$stmt = $connection->prepare('SELECT * FROM user WHERE user_id = ? LIMIT 1');
		$stmt->execute(array($userid));
		$row = $stmt->fetch();
		return $row;
	}


	function redirectHome($theMsg, $url = null, $seconds = 3) {
		if ($url === null) {
			$url = 'index.php';
			$link = 'Homepage';
		} else {
			if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {
				$url = $_SERVER['HTTP_REFERER'];
				$link = 'Previous Page';
			} else {
				$url = 'index.php';
				$link = 'Homepage';
			}
		}
		echo $theMsg;
		echo "<div class='alert alert-info'>You Will Be Redirected to $link After $seconds Seconds.</div>";
		header("refresh:$seconds;url=$url");
		exit();
	}

	function getFieldFromTableById($field, $table, $id, $value) {
		global $connection;
		$stmt = $connection->prepare("SELECT $field FROM $table WHERE $id = $value");
		$stmt->execute();
		$row = $stmt->fetch();
		return $row[$field];
	}

	function countItems($field, $table) {
		global $connection;
		$stmt = $connection->prepare("SELECT COUNT($field) FROM $table");
		$stmt->execute();
		return $stmt->fetchColumn();
	}

	function countPendingUsers() {
		global $connection;
		$stmt = $connection->prepare("SELECT COUNT(user_id) FROM user WHERE active = 0");
		$stmt->execute();
		return $stmt->fetchColumn();
	}

	function getLatest($field, $table, $order, $count = 5) {
		global $connection;
		$stmt = $connection->prepare("SELECT $field FROM $table ORDER BY $order DESC LIMIT $count");
		$stmt->execute();
		$rows = $stmt->fetchAll();
		return $rows;
	}

	function getLatestPosts($field, $table, $order, $count = 5) {
		global $connection;
		$stmt = $connection->prepare("SELECT $field FROM $table ORDER BY $order DESC LIMIT $count");
		$stmt->execute();
		$rows = $stmt->fetchAll();
		return $rows;
	}

	function getAllCategories($sort = 'ASC') {
		global $connection;
		$stmt = $connection->prepare("SELECT * FROM categories ORDER BY category_order $sort");
		$stmt->execute();
		$rows = $stmt->fetchAll();
		return $rows;
	}

	function getCategoryById($id) {
		global $connection;
		$stmt = $connection->prepare("SELECT * FROM categories WHERE category_id = $id");
		$stmt->execute();
		$row = $stmt->fetch();
		return $row;
	}

	function getPostById($postID) {
		global $connection;
		$stmt = $connection->prepare("SELECT post.*, user.user_full_name AS user_full_name FROM post INNER JOIN user ON post.post_user_id = user.user_id WHERE post_id = $postID ORDER BY post_id");
		$stmt->execute();
		$rows = $stmt->fetch();
		return $rows;
	}

	function getAllPostsForCategory($sort = 'ASC' , $categoryID) {
		global $connection;
		$stmt = $connection->prepare("SELECT post.*, user.user_full_name AS user_full_name  FROM post INNER JOIN user ON post.post_user_id = user.user_id WHERE post_category_id = $categoryID ORDER BY post_id $sort");
		$stmt->execute();
		$rows = $stmt->fetchAll();
		return $rows;
	}

	function getAllPosts($sort = 'ASC') {
		global $connection;
		$stmt = $connection->prepare("SELECT post.*, user.user_full_name AS post_user_full_name FROM post INNER JOIN user ON post.post_user_id = user.user_id ORDER BY post_id $sort");
		$stmt->execute();
		$rows = $stmt->fetchAll();
		return $rows;
	}

	function countAdmins() {
		global $connection;
		$stmt = $connection->prepare("SELECT COUNT(user_id) FROM user WHERE active = 1 AND role = 1");
		$stmt->execute();
		return $stmt->fetchColumn();
	}

	function getAdmins() {
		global $connection;
		$stmt = $connection->prepare("SELECT * FROM user WHERE active = 1 AND role = 1");
		$stmt->execute();
		return $stmt->fetchAll();
	}

	function getLatestComments($sort = 'ASC' , $limit = 0) {
		global $connection;
		$stmt = $connection->prepare("SELECT comments.*, user.user_full_name AS user_full_name, post.post_title AS post_title FROM comments INNER JOIN user ON comments.comment_user_id = user.user_id INNER JOIN post ON comments.comment_post_id = post.post_id ORDER BY post_id $sort LIMIT $limit");
		$stmt->execute();
		$rows = $stmt->fetchAll();
		return $rows;
	}

	function getAllComments($sort = 'ASC') {
		global $connection;
		$stmt = $connection->prepare("SELECT comments.*, user.user_full_name AS user_full_name, post.post_title AS post_title FROM comments INNER JOIN user ON comments.comment_user_id = user.user_id INNER JOIN post ON comments.comment_post_id = post.post_id ORDER BY post_id $sort");
		$stmt->execute();
		$rows = $stmt->fetchAll();
		return $rows;
	}

	function getAllCommentsForPost($sort , $postID) {
		global $connection;
		$stmt = $connection->prepare("SELECT comments.*, user.user_full_name AS user_full_name, post.post_title AS post_title FROM comments INNER JOIN user ON comments.comment_user_id = user.user_id INNER JOIN post ON comments.comment_post_id = post.post_id WHERE post_id = ? ORDER BY post_id $sort");
		$stmt->execute(array($postID));
		$rows = $stmt->fetchAll();
		return $rows;
	}

	function addComment($userID, $postID , $commentContent) {
		global $connection;
		$stmt = $connection->prepare("INSERT INTO comments(comment_user_id, comment_post_id, comment_content, comment_date, comment_time) VALUES(?, ?, ?, DATE(NOW()), TIME(NOW()))");
		$stmt->execute(array($userID, $postID , $commentContent));
		$count = $stmt->rowCount();
		return $count;
	}

	function updateComment($commentID , $commentContent) {
		global $connection;
		$stmt = $connection->prepare("UPDATE comments SET comment_content = ?, comment_date = DATE(NOW()), comment_time = TIME(NOW()) WHERE comment_id = ?");
		$stmt->execute(array($commentContent, $commentID));
		$count = $stmt->rowCount();
		return $count;
	}

	?>