<?php

namespace App;

use App\Enums\MatchEventType;
use App\Factories\MatchEventFactory;

class EventHandler
{
    private FileStorage $storage;
    private StatisticsManager $statisticsManager;
    
    public function __construct(string $storagePath, ?StatisticsManager $statisticsManager = null)
    {
        $this->storage = new FileStorage($storagePath);
        $this->statisticsManager = $statisticsManager ?? new StatisticsManager(__DIR__ . '/../storage/statistics.txt');
    }
    
    public function handleEvent(array $data): array
    {
        if (!isset($data['type'])) {
            throw new \InvalidArgumentException('Event type is required');
        }

        if (!in_array($data['type'], array_column(MatchEventType::cases(), 'value'))) {
            throw new \InvalidArgumentException('Invalid event type');
        }

        $event = MatchEventFactory::fromData($data);
        
        $this->storage->save($event);

        foreach (MatchEventType::cases() as $eventType) {
            if ($data['type'] === $eventType->value) {
                if (!isset($data['match_id']) || !isset($data['team_id'])) {
                    throw new \InvalidArgumentException('match_id and team_id are required for foul events');
                }

                $this->statisticsManager->updateTeamStatistics(
                    $data['match_id'],
                    $data['team_id'],
                    $eventType->getPlural()
                );
            }
        }
        
        return [
            'status' => 'success',
            'message' => 'Event saved successfully',
            'event' => $event
        ];
    }
}