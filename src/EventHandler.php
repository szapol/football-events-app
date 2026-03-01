<?php

namespace App;

use App\Enums\EventType;

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

        if (!in_array($data['type'], array_column(EventType::cases(), 'value'))) {
            throw new \InvalidArgumentException('Invalid event type');
        }

        $event = [
            'timestamp' => time(),
            'data' => $data
        ];
        
        $this->storage->save($event);

        foreach (EventType::cases() as $eventType) {
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