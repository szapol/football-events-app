<?php

namespace App;

use App\Interfaces\MatchEventInterface;

class StatisticsManager
{
    private TextFileStorage $storage;

    const string STATISTICS_FILE_PATH = __DIR__ . '/../storage/statistics.txt';

    public function __construct(string $statisticsFilePath = self::STATISTICS_FILE_PATH)
    {
        $this->storage = new TextFileStorage($statisticsFilePath);
    }
    
    public function updateTeamStatistics(MatchEventInterface $event, string $statType, int $value = 1): void
    {
        $stats = $this->getStatistics();

        if (!isset($stats[$event->match_id])) {
            $stats[$event->match_id] = [];
        }
        
        if (!isset($stats[$event->match_id][$event->team_id])) {
            $stats[$event->match_id][$event->team_id] = [];
        }
        
        if (!isset($stats[$event->match_id][$event->team_id][$statType])) {
            $stats[$event->match_id][$event->team_id][$statType] = 0;
        }
        
        $stats[$event->match_id][$event->team_id][$statType] += $value;
        
        $this->saveStatistics($stats);
    }
    
    public function getTeamStatistics(string $matchId, string $teamId): array
    {
        $stats = $this->getStatistics();
        return $stats[$matchId][$teamId] ?? [];
    }
    
    public function getMatchStatistics(string $matchId): array
    {
        $stats = $this->getStatistics();
        return $stats[$matchId] ?? [];
    }
    
    private function getStatistics(): array
    {
        return $this->storage->getRaw();
    }
    
    private function saveStatistics(array $stats): void
    {
        $this->storage->saveFromArray($stats);
    }
}
