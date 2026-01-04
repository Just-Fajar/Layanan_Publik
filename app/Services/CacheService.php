<?php

namespace App\Services;

use App\Repositories\BukuTamu\VisitorRepository;
use App\Repositories\CalendarEvent\EventRepository;
use App\Repositories\Esport\NewsRepository;
use App\Repositories\Esport\TournamentRepository;
use Illuminate\Support\Facades\Cache;

class CacheService
{
    public function __construct(
        private VisitorRepository $visitorRepository,
        private TournamentRepository $tournamentRepository,
        private NewsRepository $newsRepository,
        private EventRepository $eventRepository
    ) {}

    /**
     * Get cached visitor statistics (5 minutes TTL).
     */
    public function getVisitorStatistics(): array
    {
        return Cache::remember('statistics.visitors', 300, function () {
            return [
                'total' => $this->visitorRepository->getTotalCount(),
                'today' => $this->visitorRepository->getTodayCount(),
                'this_week' => $this->visitorRepository->getWeekCount(),
                'by_purpose' => $this->visitorRepository->getCountByPurpose()->toArray(),
            ];
        });
    }

    /**
     * Get cached dashboard statistics (5 minutes TTL).
     */
    public function getDashboardStatistics(): array
    {
        return Cache::remember('statistics.dashboard', 300, function () {
            return [
                'visitors' => [
                    'total' => $this->visitorRepository->getTotalCount(),
                    'today' => $this->visitorRepository->getTodayCount(),
                    'this_week' => $this->visitorRepository->getWeekCount(),
                ],
                'tournaments' => [
                    'total' => $this->tournamentRepository->getAll()->count(),
                    'upcoming' => $this->tournamentRepository->getUpcoming(5)->count(),
                ],
                'news' => [
                    'total' => $this->newsRepository->getAll()->count(),
                    'latest' => $this->newsRepository->getLatest(5)->count(),
                ],
                'events' => [
                    'total' => $this->eventRepository->getAll()->count(),
                    'upcoming' => $this->eventRepository->getUpcoming(5)->count(),
                    'published' => $this->eventRepository->getPublished()->count(),
                ],
            ];
        });
    }

    /**
     * Get cached upcoming tournaments (10 minutes TTL).
     */
    public function getUpcomingTournaments(int $limit = 5)
    {
        $cacheKey = "tournaments.upcoming.{$limit}";

        return Cache::remember($cacheKey, 600, function () use ($limit) {
            return $this->tournamentRepository->getUpcoming($limit);
        });
    }

    /**
     * Get cached latest news (10 minutes TTL).
     */
    public function getLatestNews(int $limit = 5)
    {
        $cacheKey = "news.latest.{$limit}";

        return Cache::remember($cacheKey, 600, function () use ($limit) {
            return $this->newsRepository->getLatest($limit);
        });
    }

    /**
     * Get cached upcoming events (10 minutes TTL).
     */
    public function getUpcomingEvents(int $limit = 5)
    {
        $cacheKey = "events.upcoming.{$limit}";

        return Cache::remember($cacheKey, 600, function () use ($limit) {
            return $this->eventRepository->getUpcoming($limit);
        });
    }

    /**
     * Clear all statistics cache.
     */
    public function clearStatisticsCache(): void
    {
        Cache::forget('statistics.visitors');
        Cache::forget('statistics.dashboard');
    }

    /**
     * Clear specific module cache.
     */
    public function clearModuleCache(string $module): void
    {
        match ($module) {
            'visitors' => Cache::forget('statistics.visitors'),
            'tournaments' => Cache::tags(['tournaments'])->flush(),
            'news' => Cache::tags(['news'])->flush(),
            'events' => Cache::tags(['events'])->flush(),
            default => null,
        };
    }

    /**
     * Clear all cache.
     */
    public function clearAllCache(): void
    {
        Cache::flush();
    }
}
