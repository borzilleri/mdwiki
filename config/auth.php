<?php

$config['demo_user'] = 'demo';
$config['demo_pass'] = 'test';

$config['admin_user'] = 'adm1n';
$config['admin_pass'] = '0p3n^admin!';

$config['openid'] = array(
	'store' => APP_ROOT.'/oid_store',
	'attributes' => array(
		'email',
		'firstname',
		'lastname'
	),
);

?>
