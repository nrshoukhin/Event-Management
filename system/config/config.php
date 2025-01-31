<?php
$host = 'localhost';
$dbname = 'your_database_name';

define('DSN', "mysql:host=$host;dbname=$dbname;charset=utf8");
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');

// Determine protocol (http or https)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';

// Dynamically configure BASE_URL and BASE_PATH
$baseUrl = $protocol . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']);
$basePath = trim(parse_url($baseUrl, PHP_URL_PATH), '/');

define('BASE_URL', rtrim($baseUrl, '/') . '/');
define('BASE_PATH', $basePath !== '' ? '/' . $basePath . '/' : '/');


