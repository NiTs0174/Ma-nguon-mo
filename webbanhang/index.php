<?php
//3 Khởi tạo SEESION
session_start();

// Định tuyến (ROUTING)
require_once 'app/models/ProductModel.php';
require_once 'app/models/CategoryModel.php';
//4 XÁC THỰC 
require_once 'app/helpers/SessionHelper.php';
//5 RESTful API
require_once 'app/controllers/ProductApiController.php';
require_once 'app/controllers/CategoryApiController.php';

$url = $_GET['url'] ?? '';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// Kiểm tra phần đầu tiên của URL để xác định controller
$controllerName = isset($url[0]) && $url[0] != '' ? ucfirst($url[0]) . 'Controller' : 'DefaultController';
// Kiểm tra phần thứ hai của URL để xác định action
$action = isset($url[1]) && $url[1] != '' ? $url[1] : 'index';

//5 Định tuyến các yêu cầu API
if ($controllerName === 'ApiController' && isset($url[1])) {
    if (isset($url[0]) && strtolower($url[0]) === 'api' && isset($url[1])) {
        $apiControllerName = ucfirst($url[1]) . 'ApiController';

        if (file_exists('app/controllers/' . $apiControllerName . '.php')) {
            require_once 'app/controllers/' . $apiControllerName . '.php';
            $controller = new $apiControllerName();    
            $method = $_SERVER['REQUEST_METHOD'];
            $id = $url[2] ?? null;
    
            switch ($method) {
                case 'GET':
                    if ($id) {
                        $action = 'show';
                    } else {
                        $action = 'index';
                    }
                    break;
                case 'POST':
                    $action = 'store';
                    break;
                case 'PUT':
                    if ($id) {
                        $action = 'update';
                    }
                    break;
                case 'DELETE':
                    if ($id) {
                        $action = 'destroy';
                    }
                    break;
                default:
                    http_response_code(405);
                    echo json_encode(['message' => 'Method Not Allowed']);
                    exit;
            }
    
            if (method_exists($controller, $action)) {
                if ($id) {
                    call_user_func_array([$controller, $action], [$id]);
                } else {
                    call_user_func_array([$controller, $action], []);
                }
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Action not found']);
            }
            exit;
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Controller not found']);
            exit;
        }
    }
}

//die ("controller=$controllerName - action=$action");

// Kiểm tra xem controller và action có tồn tại không
if (!file_exists('app/controllers/' . $controllerName . '.php')) {
    // Xử lý không tìm thấy controller
    die('Controller not found');
}
//5 Tạo đối tượng controller tương ứng cho các yêu cầu không phải API
// if (!file_exists('app/controllers/' . $controllerName . '.php')) {
//     require_once 'app/controllers/' . $controllerName . '.php';
//     $controller = new $controllerName();
// } else {
//     die('Controller not found');
// }

require_once 'app/controllers/' . $controllerName . '.php';
$controller = new $controllerName();

// Kiểm tra và gọi action
if (!method_exists($controller, $action)) {    
    // Xử lý không tìm thấy action
    die('Action not found');
}
//5 Kiểm tra và gọi action API
// if (!method_exists($controller, $action)) {
//     call_user_func_array([$controller, $action], array_slice($url, 2));
// } else {
//     die('Action not found');
// }

// Gọi action với các tham số còn lại (nếu có)
call_user_func_array([$controller, $action], array_slice($url, 2));