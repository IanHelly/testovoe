<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Controllers\IndexController;
use App\Controllers\EmployeeController;
use App\Controllers\TreeController;
use App\Controllers\SeederController;

$method = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];

$parsedUrl = parse_url($requestUri);
parse_str($parsedUrl['query'] ?? '', $queryParams);

switch ($parsedUrl['path']) {
    case '/':
        $indexController = new IndexController();
        $indexController->Index();
        break;

    case '/employees':
        $employeeController = new EmployeeController();
        $employeeController->handleRequest($method, $_POST, $queryParams);
        break;

    case '/tree':
        if ($method === 'GET') {
            $treeController = new TreeController();
            $treeController->handleRequest();
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed for this endpoint']);
        }
        break;

    case '/seeder':
        $seederController = new SeederController();
        $seederController->runSeeder();
        break;


    default:
        http_response_code(404);
        echo json_encode(['error' => 'Endpoint not found']);
        break;
}

