<?php
$GLOBALS['config'] = array(
  'mysql' => array(
    'host' => 'localhost',
    'user' => 'username',
    'pass' => 'pass',
    'dbname' => 'dbname',
    'charset' => 'UTF8'
  ),
	'site' => array(
		'baseurl' => $_SERVER['DOCUMENT_ROOT'],
		'httpurl' => $_SERVER['HTTP_HOST'],
		'selfurl' => $_SERVER['REQUEST_URI'],
		'http' => 'http://',
        'DS' => DIRECTORY_SEPARATOR,
        'root' => dirname(dirname(__FILE__)),
    'datetime' => 'm/d/Y H:i:s',
    'assets' => '/assets',
		'resources' => array(
			'img' => '/img',
			'css' => '/css',
			'js' => '/js'
		)
	),
  'remember' => array(
    'cookie_name' => 'hash',
    'cookie_expiry' => 604800
  ),
  'session' => array(
    'user_session' => 'user',
    'token_name' => 'csrf_token'
  ),
	'security' => array(
		'salt' => 'TO(.[_jpEa+%iPz8l_wS;c|+b~%JAkpBo>+1Y-@j;B7CrG?)7|mU4&!c26I<XJ~S'
	),
  'steam' => array(
    'apikey' => 'BF121E30B7C899E9C1786DEEE4AAFBB9',
    'redirecturl' => 'localhost:8080/user/profile'
  )
);
