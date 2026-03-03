<?php

namespace App;

use App\Enums\MatchEventType;
use App\Factories\MatchEventFactory;

class EventHandler
{
    private TextFileStorage $storage;
    private StatisticsManager $statisticsManager;

    const string EVENTS_FILE_PATH = __DIR__ . '/../storage/events.txt';

    public function __construct(string $eventsFile = self::EVENTS_FILE_PATH, ?StatisticsManager $statisticsManager = null)
    {
        $this->storage = new TextFileStorage($eventsFile);
        $this->statisticsManager = $statisticsManager ?? new StatisticsManager();
    }
    
    public function handleEvent(array $data): array
    {
        if (!isset($data['type'])) {
            throw new \InvalidArgumentException('Event type is required');
        }

        if (!in_array($data['type'], array_column(MatchEventType::cases(), 'value'))) {
            throw new \InvalidArgumentException('Invalid event type');
        }

        if (!isset($data['match_id']) || !isset($data['team_id'])) {
            throw new \InvalidArgumentException('match_id and team_id are required');
        }

        $event = MatchEventFactory::fromData($data);

        $this->storage->addLine($event);

        foreach (MatchEventType::cases() as $eventType) {
            if ($data['type'] === $eventType->value) {
                $this->statisticsManager->updateTeamStatistics(
                    $event,
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

    public function listEvents(): array
    {
        return $this->storage->getAll();
    }
}