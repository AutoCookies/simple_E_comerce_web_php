<?php
// public/index.php (Routing)
session_start();
require_once 'app/helpers/AuthHelper.php';

// Lấy base path của project (ví dụ '/project1')
$basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');

// Lấy URI và loại bỏ query string
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// xoá basePath khỏi URI
if ($basePath !== '' && strpos($requestUri, $basePath) === 0) {
    $requestUri = substr($requestUri, strlen($basePath));
}

// trim slashes
$url = trim($requestUri, '/'); // Ví dụ 'account/login' hoặc 'product/index'
$parts = explode('/', $url);

// Xác định route công khai (không cần login)
$publicRoutes = [
    'account/login',
    'account/register',
    'account/checklogin',
    'account/save',
    'product/index',
];

// current route key
define('CURRENT_ROUTE', strtolower(($parts[0] ?? '') . '/' . ($parts[1] ?? '')));

// Redirect đến login nếu chưa đăng nhập và không thuộc public routes
auth_start:
if (!AuthHelper::isLoggedIn() && !in_array(CURRENT_ROUTE, $publicRoutes)) {
    header('Location: ' . $basePath . '/account/login');
    exit;
}

// Xác định controller và action
$segment = strtolower($parts[0] ?? 'default');
$action  = $parts[1] ?? 'index';
$params  = array_slice($parts, 2);

switch ($segment) {
    case 'account':
        // Luôn dùng AccountController cho tất cả
        $controllerName = 'AccountController';
        break;

    default:
        // Lấy tên base controller, ví dụ 'product' → 'Product'
        $base = ucfirst($segment);

        if (AuthHelper::isAdmin()) {
            // Admin dùng XxxController
            $controllerName = $base . 'Controller';
        } else {
            // User dùng XxxControllerUser
            $controllerName = $base . 'ControllerUser';
        }
        break;
}

// Đường dẫn file controller
$controllerFile = __DIR__ . '/app/controllers/' . $controllerName . '.php';
if (!file_exists($controllerFile)) {
    http_response_code(404);
    die("Controller $controllerName không tồn tại");
}
require_once $controllerFile;

$controller = new $controllerName();
if (!method_exists($controller, $action)) {
    http_response_code(404);
    die("Action $action không tồn tại trong controller $controllerName");
}

// Gọi action
call_user_func_array([$controller, $action], $params);
