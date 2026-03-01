<?php

namespace App\Controllers;

use App\StatisticsManager;
use Exception;

class StatisticsController
{
    public static function index(): void
    {
        $statsManager = new StatisticsManager(__DIR__ . '/../storage/statistics.txt');

        $matchId = $_GET['match_id'] ?? null;
        $teamId = $_GET['team_id'] ?? null;

        try {
            if ($matchId && $teamId) {
                // Get team statistics for specific match
                $stats = $statsManager->getTeamStatistics($matchId, $teamId);
                echo json_encode([
                    'match_id' => $matchId,
                    'team_id' => $teamId,
                    'statistics' => $stats
                ]);
            } elseif ($matchId) {
                // Get all team statistics for specific match
                $stats = $statsManager->getMatchStatistics($matchId);
                echo json_encode([
                    'match_id' => $matchId,
                    'statistics' => $stats
                ]);
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'match_id is required']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}