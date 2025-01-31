<?php

class Router {
    public function handleRequest($uri) {
        session_start();

        // Define the base path
        $basePath = BASE_PATH;
        if (strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }

        // Remove query strings
        if (strpos($uri, '?') !== false) {
            $uri = strtok($uri, '?');
        }

        $uri = trim($uri, '/');
        $segments = explode('/', $uri);

        // Determine controller and method
        $controllerName = !empty($segments[0]) ? ucfirst($segments[0]) : 'Dashboard';
        $methodName = isset($segments[1]) ? $segments[1] : 'index';
        $params = array_slice($segments, 2);

        // Protected controllers
        $protectedControllers = ['Dashboard', 'Event', 'Attendee', 'Search'];
        $allowedMethod = [
            "Attendee" => ["register","submit_registration"]
        ];

        // Ensure allowedMethod[$controllerName] is an array
        $allowedMethodsForController = isset($allowedMethod[$controllerName]) ? $allowedMethod[$controllerName] : [];

        if (in_array($controllerName, $protectedControllers) && !in_array($methodName, $allowedMethodsForController) && empty($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'auth/login');
            exit();
        }else if( strtolower($controllerName) === "auth" && strtolower($methodName) === "login"  && !empty($_SESSION['user_id']) ){
            header('Location: ' . BASE_URL . 'Dashboard/index');
            exit();
        }

        $controllerFile = "application/controllers/{$controllerName}.php";

        if (file_exists($controllerFile)) {
            require_once $controllerFile;

            if (class_exists($controllerName)) {

                $controller = new $controllerName();

                if (method_exists($controller, $methodName)) {
                    call_user_func_array([$controller, $methodName], $params);
                } else {
                    die("Error: Method '$methodName' not found.");
                }
            } else {
                die("Error: Controller class '$controllerName' not found.");
            }
        } else {
            die("Error: Controller '$controllerName' not found.");
        }
    }
}
