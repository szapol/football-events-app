<?php

namespace App\MatchEvents;

abstract class AbstractMatchEvent
{
    public int $timestamp;
    public string $type;
    public string $match_id;
    public string $team_id;
    public int $minute;
    public int $second;
}