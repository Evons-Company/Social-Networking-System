<?php
/*

	File: king-include/king-ajax-click-pm.php
	Description: Server-side response to Ajax single clicks on private messages


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

	require_once QA_INCLUDE_DIR.'king-app/messages.php';
	require_once QA_INCLUDE_DIR.'king-app/users.php';
	require_once QA_INCLUDE_DIR.'king-app/cookies.php';
	require_once QA_INCLUDE_DIR.'king-db/selects.php';


	$lid = qa_get_logged_in_userid();
	$loginUserHandle = qa_get_logged_in_handle();

	$fromhandle = qa_post_text('handle');
	$start = (int) qa_post_text('start');
	$ouid = (int) qa_post_text('uid');
	$box = qa_post_text('box');
	$pagesize = qa_opt('page_size_pms');

	if ( !isset($lid) || $loginUserHandle !== $fromhandle || !in_array($box, array('inbox', 'outbox')) ) {
		echo "QA_AJAX_RESPONSE\n0\n";
		return;
	}



	qa_pm_delete($box, $lid, $ouid);
	
	echo "QA_AJAX_RESPONSE\n1\n";
	
