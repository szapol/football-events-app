<?php

namespace App\MatchEvents;

use App\Interfaces\MatchEventInterface;

class GoalEvent extends AbstractMatchEvent implements MatchEventInterface
{
    public string $team_id;
    public string $scorer;
    public string $assistingPlayer;

    public static function fromData(array $data): GoalEvent
    {
        $event = new static();

        $event->timestamp = time();
        $event->scorer = $data['scorer'] ?? '';
        $event->assistingPlayer = $data['assistingPlayer'] ?? '';
        $event->team_id = $data['team_id'] ?? '';
        $event->match_id = $data['match_id'] ?? '';
        $event->minute = $data['minute'] ?? null;
        $event->second = $data['second'] ?? null;

        return $event;
    }
}