<?php

namespace App\Controllers;

use App\EventHandler;
use Exception;

class EventController
{
    public static function index(): void
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON']);
            exit;
        }

        $handler = new EventHandler(__DIR__ . '/../../storage/events.txt');

        try {
            $result = $handler->handleEvent($data);
            http_response_code(201);
            echo json_encode($result);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}