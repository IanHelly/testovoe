<?php

require_once __DIR__ . '/../controllers/IndexController.php';
require_once __DIR__ . '/../controllers/EmployeeController.php';
require_once __DIR__ . '/../controllers/TreeController.php';
require_once __DIR__ . '/../controllers/SeederController.php';

$method = $_SERVER['REQUEST_METHOD'];

$indexController = new IndexController();
$employeeController = new EmployeeController();
$treeController = new TreeController();
$seederController = new SeederController();

$requestUri = $_SERVER['REQUEST_URI'];

$parsedUrl = parse_url($requestUri);
parse_str($parsedUrl['query'] ?? '', $queryParams);

switch ($parsedUrl['path']) {
    case '/':
        $indexController->Index();
        break;

    case '/employees':
        $employeeController->handleRequest($method, $_POST, $queryParams);
        break;

    case '/tree':
        if ($method === 'GET') {
            $treeController->handleRequest();
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed for this endpoint']);
        }
        break;

    case '/seeder':
        $seederController = new SeederController();
        if ($method === 'POST') {
            $seederController->runSeeder();
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed for this endpoint']);
        }
        break;


    default:
        http_response_code(404);
        echo json_encode(['error' => 'Endpoint not found']);
        break;
}

