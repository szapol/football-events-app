<?php

namespace App\Enums;

enum EventType: string
{
    case Foul = 'foul';
    case Goal = 'goal';

    public function getPlural(): string
    {
        return match ($this) {
            EventType::Foul => 'fouls',
            EventType::Goal => 'goals',
        };
    }
}
