<?php

  /**
  * Create application admin and/or common user (visitor)
  * Run from command line: php adduser.php --visitor_email=test@test.com --visitor_password=pass --admin_name="Karel Zavadil" --admin_login=karel --admin_email=admin@test.com --admin_password=pass
  */

	require_once __DIR__ . '/../../zEngine/src/zengine.php';
	$z = new zEngine(__DIR__ . '/../app/');

	$options = getopt('v:p:n:l:e:w:', ['visitor_email::', 'visitor_password::', 'admin_name::', 'admin_login::', 'admin_email::', 'admin_password::']);

	if (isset($options['visitor_email'])) {
		$z->auth->createActiveUser("Auto-created test user", $options['visitor_email'], $options['visitor_email'], $options['visitor_password']);
	}

	if (isset($options['admin_email'])) {
		$admin_email = $options['admin_email'];
		$admin_login = $options['admin_login'] ?? $admin_email;
		$admin_name = $options['admin_name'] ?? $admin_login;
		$z->admin->createActiveAdminAccount($admin_name, $admin_login, $admin_email, $options['admin_password']);
	}
