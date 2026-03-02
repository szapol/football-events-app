<?php

namespace App\Enums;

enum MatchEventType: string
{
    case Foul = 'foul';
    case Goal = 'goal';

    public function getPlural(): string
    {
        return match ($this) {
            MatchEventType::Foul => 'fouls',
            MatchEventType::Goal => 'goals',

            default => $this->value . 's',
        };
    }
}
