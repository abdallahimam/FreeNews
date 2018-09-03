<?php

	function lang($phrase) {

		static $lang = array(

			// Navbar Links

			'HOME_ADMIN' 	=> 'Home',
			'CATEGORIES' 	=> 'Categories',
			'ITEMS' 		=> 'Items',
			'MEMBERS' 		=> 'Members',
			'COMMENTS'		=> 'Comments',
			'STATISTICS' 	=> 'Statistics',
			'LOGS' 			=> 'Logs',
			'POSTS' 			=> 'Posts',			
			'HOME' 			=> 'Home',
			'ABOUT' 		=> 'About',
			'CONTACT' 		=> 'Contact Us',
			'LOGIN' 		=> 'Login',
			'LOGOUT' 		=> 'Logout'
		);

		return $lang[$phrase];

	}
