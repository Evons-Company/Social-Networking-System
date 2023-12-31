<?php
/*

	File: king-include/king-page-user.php
	Description: Controller for user profile page


	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	More about this license: LICENCE.html
*/

	if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
		header('Location: ../');
		exit;
	}


//	Determine the identify of the user

	$handle = qa_request_part(1);

	if (!strlen($handle)) {
		$handle = qa_get_logged_in_handle();
		qa_redirect(!empty($handle) ? 'user/'.$handle : 'users');
	}


//	Get the HTML to display for the handle, and if we're using external users, determine the userid

	if (QA_FINAL_EXTERNAL_USERS) {
		$userid = qa_handle_to_userid($handle);
		if (!isset($userid))
			return include QA_INCLUDE_DIR.'king-page-not-found.php';

		$usershtml = qa_get_users_html(array($userid), false, qa_path_to_root(), true);
		$userhtml = @$usershtml[$userid];

	} else {
		$userhtml = qa_html($handle);
	}


//	Display the appropriate page based on the request

	switch (qa_request_part(2)) {
		case 'wall':
			qa_set_template('user-wall');
			$qa_content = include QA_INCLUDE_DIR.'king-pages/user-wall.php';
			break;
			
		case 'follower':
			qa_set_template('user-follower');
			$qa_content = include QA_INCLUDE_DIR.'king-pages/user-follower.php';
			break;
		case 'following':
			qa_set_template('user-following');
			$qa_content = include QA_INCLUDE_DIR.'king-pages/user-following.php';
			break;	
			
		case 'activity':
			qa_set_template('user-activity');
			$qa_content = include QA_INCLUDE_DIR.'king-pages/user-activity.php';
			break;

		case 'answers':
			qa_set_template('user-answers');
			$qa_content = include QA_INCLUDE_DIR.'king-pages/user-answers.php';
			break;

		case 'profile':
			$qa_content = include QA_INCLUDE_DIR.'king-pages/user-profile.php';
			break;
		case 'favorites':
			$qa_content = include QA_INCLUDE_DIR.'king-pages/favorites.php';
			break;
		case null:
			qa_set_template('user-questions');
			$qa_content = include QA_INCLUDE_DIR.'king-pages/user-questions.php';
			break;
		default:
			$qa_content = include QA_INCLUDE_DIR.'king-page-not-found.php';
			break;
	}

	$qa_content['profile'] = true;
	return $qa_content;

/*
	Omit PHP closing tag to help avoid accidental output
*/