<?php

namespace App\MatchEvents;

use App\Interfaces\MatchEventInterface;

class FoulEvent extends AbstractMatchEvent implements MatchEventInterface
{
    public string $player;
    public string $affectedPlayer;

    public static function fromData(array $data): FoulEvent
    {
        $event = new static();

        $event->timestamp = time();
        $event->type = $data['type'];
        $event->team_id = $data['team_id'];
        $event->match_id = $data['match_id'];

        $event->player = $data['player'] ?? '';
        $event->affectedPlayer = $data['affectedPlayer'] ?? '';

        $event->minute = $data['minute'] ?? null;
        $event->second = $data['second'] ?? null;

        return $event;
    }
}