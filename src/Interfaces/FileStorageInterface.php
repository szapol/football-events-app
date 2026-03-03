<?php

namespace App\Interfaces;

interface FileStorageInterface
{
    public function addLine(object $data): void;
    public function saveFromArray(array $data): void;
    public function getAll(): array;
    public function getRaw(): array;
}