<?php
// Enable all error reporting
error_reporting(0);
ini_set('display_errors', 0);
date_default_timezone_set('Asia/Dhaka');
// Load Configurations
require_once 'system/config/config.php';

// Load Core Classes
require_once 'system/core/Router.php';
require_once 'system/core/Controller.php';
require_once 'system/core/Model.php';
require_once 'system/core/Loader.php';
require_once 'system/helpers/functions.php';

// Autoloader for Controllers and Models
spl_autoload_register(function ($className) {
    $filePath = "application/" . str_replace('\\', '/', $className) . ".php";
    if (file_exists($filePath)) {
        require_once $filePath;
    }
});

// Initialize Router
$router = new Router();
$router->handleRequest($_SERVER['REQUEST_URI']);
