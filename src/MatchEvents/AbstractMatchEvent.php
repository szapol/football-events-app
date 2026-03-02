<?php

namespace App\MatchEvents;

abstract class AbstractMatchEvent
{
    public int $timestamp;
    public string $match_id;
    public int $minute;
    public int $second;
}