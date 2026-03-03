<?php

namespace App\Interfaces;

interface MatchEventInterface
{
    public string $type { get; set; }
    public string $match_id { get; set; }
    public string $team_id { get; set; }

    public static function fromData(array $data);
}