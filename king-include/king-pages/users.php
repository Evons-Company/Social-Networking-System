<?php
/*

	File: king-include/king-page-users.php
	Description: Controller for top scoring users page


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

	require_once QA_INCLUDE_DIR.'king-db/users.php';
	require_once QA_INCLUDE_DIR.'king-db/selects.php';
	require_once QA_INCLUDE_DIR.'king-app/format.php';


//	Get list of all users

	$start = qa_get_start();
	$users = qa_db_select_with_pending(qa_db_top_users_selectspec($start, qa_opt_if_loaded('page_size_users')));

	$usercount = qa_opt('cache_userpointscount');
	$pagesize = qa_opt('page_size_users');
	$users = array_slice($users, 0, $pagesize);
	$usershtml = qa_userids_handles_html($users);


//	Prepare content for theme

	$qa_content = qa_content_prepare();

	$qa_content['title'] = qa_lang_html('main/highest_users');


	$html = '<div class="king-users-page">';
	if (count($users)) {
		foreach ($users as $userid => $user) {

			$html .= get_user_html($user, '400');

		}
	}
	else {
		$qa_content['title'] = qa_lang_html('main/no_active_users');
	}
	$html .= '</div>';

	$qa_content['custom'] = $html;

	$qa_content['page_links'] = qa_html_page_links(qa_request(), $start, $pagesize, $usercount, qa_opt('pages_prev_next'));

	$qa_content['navigation']['sub'] = qa_users_sub_navigation();

	$qa_content['class']=' full-page';
	$qa_content['header']= qa_lang_html('main/highest_users');
	return $qa_content;


/*
	Omit PHP closing tag to help avoid accidental output
*/