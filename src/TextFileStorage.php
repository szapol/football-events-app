<?php

namespace App;

use App\Interfaces\FileStorageInterface;

class TextFileStorage implements FileStorageInterface
{
    private string $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;

        $directory = dirname($this->filePath);

        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }
    }
    
    public function addLine(object $data): void
    {
        $line = json_encode($data) . PHP_EOL;
        file_put_contents($this->filePath, $line, FILE_APPEND | LOCK_EX);
    }

    public function saveFromArray(array $data): void
    {
        file_put_contents($this->filePath, json_encode($data, JSON_PRETTY_PRINT), LOCK_EX);
    }

    public function getAll(): array
    {
        if (!file_exists($this->filePath)) {
            return [];
        }
        
        $content = file_get_contents($this->filePath);
        $lines = explode(PHP_EOL, trim($content));
        
        return array_map(function($line) {
            return json_decode($line, true);
        }, array_filter($lines));
    }

    public function getRaw(): array
    {
        if (!file_exists($this->filePath)) {
            return [];
        }

        $content = file_get_contents($this->filePath);
        return json_decode($content, true) ?? [];
    }
}