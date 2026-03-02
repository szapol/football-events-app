<?php

namespace App\Factories;

use App\MatchEvents\FoulEvent;
use App\MatchEvents\GoalEvent;
use App\Interfaces\MatchEventInterface;

class MatchEventFactory
{
    public static function fromData(array $data): MatchEventInterface
    {
        return match ($data['type']) {
            'goal' => GoalEvent::fromData($data),
            'foul' => FoulEvent::fromData($data),
        };
    }
}