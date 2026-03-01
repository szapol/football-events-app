<?php

use App\Controllers\EventController;
use App\Controllers\StatisticsController;

$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

header('Content-Type: application/json');

if ($method === 'POST' && $path === '/event') {
    EventController::index();
} else if ($method === 'GET' && $path === '/statistics') {
    StatisticsController::index();
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Not found']);
}