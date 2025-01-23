<?php

use App\Core\Router;
use App\Core\Request;
use App\Controllers\IndexController;
use App\Controllers\EmployeeController;
use App\Controllers\TreeController;
use App\Controllers\SeederController;
use App\Services\EmployeeService;
use App\Repositories\Employee\EmployeeRepository;
use App\Seeders\EmployeeSeeder;
use App\Services\EmployeeTreeBuilderService;

// Создаем сервисы и репозитории с внедрением зависимостей
$db = new PDO('mysql:host=localhost;dbname=your_db', 'user', 'password');
$employeeRepository = new EmployeeRepository($db);
$employeeService = new EmployeeService($employeeRepository);

// Создаем маршрутизатор и добавляем маршруты
$router = new Router();

$router->addRoute('GET', '/', function() {
    $controller = new IndexController();
    $controller->Index();
});

$router->addRoute('GET', '/employees', function($queryParams) use ($employeeService) {
    $controller = new EmployeeController($employeeService);
    $controller->handleGet($queryParams);
});

$router->addRoute('POST', '/employees', function($data) use ($employeeService) {
    $controller = new EmployeeController($employeeService);
    $controller->handlePost($data);
});

$router->addRoute('DELETE', '/employees', function($queryParams) use ($employeeService) {
    $controller = new EmployeeController($employeeService);
    $controller->handleDelete($queryParams);
});

$router->addRoute('GET', '/tree', function() use ($employeeRepository) {
    $employeeTreeBuilderService = new EmployeeTreeBuilderService($employeeRepository);
    $controller = new TreeController($employeeTreeBuilderService);
    $controller->handleRequest();
});

$router->addRoute('POST', '/seeder', function() use ($employeeRepository) {
    $employeeSeeder = new EmployeeSeeder($employeeRepository);
    $controller = new SeederController($employeeSeeder);
    $controller->runSeeder();
});

// Запуск маршрутизации
$request = new Request();
$router->dispatch($request);