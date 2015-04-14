<?php

	$db_host  = 'localhost';
	$db_user  = '';
	$db_pass  = '';
	$db_name  = '';
	$db_table = '';

	$number = 314;



	ini_set('display_errors', 'on');
	error_reporting(E_ALL);
	mb_internal_encoding('utf-8');

	$db = new mysqli($db_host, $db_user, $db_pass, $db_name);
	if ($db->connect_error) {
		die('Connect Error (' . $db->connect_errno . ') ' . $db->connect_error);
	}

	$res = $db->query(
		"select product_id, category_id from `$db_table` " .
		"where category_id = '$number'"
	) or die($db->error);
	while ($row = $res->fetch_assoc()) {
		$res2 = $db->query(
			"select count(*) as cnt from `$db_table` " .
			"where product_id = '{$row['product_id']}' and " .
			"category_id <> '$number'"
		) or die($db->error);
		$row2 = $res2->fetch_assoc();
		if (is_numeric($row2['cnt']) && $row2['cnt'] > 0) {
			$db->query(
				"delete from `$db_table` " .
				"where product_id = '{$row['product_id']}' and " .
				"category_id = '$number'"
			) or die($db->error);
		}
	}

	echo 'Complete';
