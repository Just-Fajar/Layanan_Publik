# 📚 ARCHITECTURE QUICK START GUIDE

Quick reference for using the new Repository & Service architecture.

---

## 🏗️ ARCHITECTURE OVERVIEW

```
┌──────────────┐
│  Controller  │ ← HTTP handling only
└──────┬───────┘
       │
       ↓
┌──────────────┐
│   Service    │ ← Business logic
└──────┬───────┘
       │
       ↓
┌──────────────┐
│  Repository  │ ← Data access
└──────┬───────┘
       │
       ↓
┌──────────────┐
│    Model     │ ← Data representation
└──────────────┘
```

---

## 📋 AVAILABLE SERVICES

### Buku Tamu Module

**VisitorService** (`App\Services\BukuTamu\VisitorService`)
```php
createVisitor(array $data): Visitor
getVisitors(array $filters = [], ?int $perPage = null)
updateVisitor(Visitor $visitor, array $data): Visitor
deleteVisitor(Visitor $visitor): bool
getStatistics(): array
```

**GeolocationService** (`App\Services\BukuTamu\GeolocationService`)
```php
validateLocation(?float $latitude, ?float $longitude): void
isWithinRange(float $latitude, float $longitude): bool
calculateDistance(float $lat1, float $lon1, float $lat2, float $lon2): float
```

**ImageService** (`App\Services\BukuTamu\ImageService`)
```php
storeBase64Image(string $base64Data): string
storeWithDateStructure(string $base64Data, string $folder = 'visitor_photos'): string
deleteImage(?string $path): bool
```

### Esport Module

**TournamentService** (`App\Services\Esport\TournamentService`)
```php
createTournament(array $data): Tournament
updateTournament(Tournament $tournament, array $data): bool
deleteTournament(Tournament $tournament): bool
getTournaments(array $filters = [], int $perPage = null): LengthAwarePaginator
getUpcomingTournaments(int $limit = 5): Collection
getTournamentsByGame(string $game): Collection
```

**NewsService** (`App\Services\Esport\NewsService`)
```php
createNews(array $data): News
updateNews(News $news, array $data): bool
deleteNews(News $news): bool
getNews(array $filters = [], int $perPage = null): LengthAwarePaginator
getLatestNews(int $limit = 5): Collection
getNewsByCategory(string $category): Collection
```

### Calendar Event Module

**EventService** (`App\Services\CalendarEvent\EventService`)
```php
createEvent(array $data): Event
updateEvent(Event $event, array $data): bool
deleteEvent(Event $event): bool
getEvents(array $filters = [], int $perPage = null): LengthAwarePaginator
getPublishedEvents(int $perPage = null): Collection|LengthAwarePaginator
getUpcomingEvents(int $limit = 5): Collection
getEventsByCategory(string $category): Collection
getEventsByStatus(string $status): Collection
getEventsForCalendar(Carbon $startDate, Carbon $endDate): Collection
bulkUpdateStatus(array $eventIds, string $status): int
```

---

## 📋 AVAILABLE REPOSITORIES

### VisitorRepository (`App\Repositories\BukuTamu\VisitorRepository`)
```php
create(array $data): Visitor
find(int $id): ?Visitor
update(Visitor $visitor, array $data): bool
delete(Visitor $visitor): bool
getPaginated(array $filters = [], int $perPage = 10): LengthAwarePaginator
getByDateRange(Carbon $startDate, Carbon $endDate): Collection
getTotalCount(): int
getTodayCount(): int
getWeekCount(): int
getCountByPurpose(): Collection
```

### TournamentRepository (`App\Repositories\Esport\TournamentRepository`)
```php
create(array $data): Tournament
find(int $id): ?Tournament
update(Tournament $tournament, array $data): bool
delete(Tournament $tournament): bool
getPaginated(array $filters = [], int $perPage = 10): LengthAwarePaginator
getAll(): Collection
getByStatus(string $status): Collection
getByGame(string $game): Collection
getUpcoming(int $limit = null): Collection
```

### NewsRepository (`App\Repositories\Esport\NewsRepository`)
```php
create(array $data): News
find(int $id): ?News
update(News $news, array $data): bool
delete(News $news): bool
getPaginated(array $filters = [], int $perPage = 10): LengthAwarePaginator
getAll(): Collection
getByCategory(string $category): Collection
getLatest(int $limit = 5): Collection
```

### EventRepository (`App\Repositories\CalendarEvent\EventRepository`)
```php
create(array $data): Event
find(int $id): ?Event
update(Event $event, array $data): bool
delete(Event $event): bool
forceDelete(Event $event): bool
getPaginated(array $filters = [], int $perPage = 10): LengthAwarePaginator
getAll(): Collection
getPublished(int $perPage = null): Collection|LengthAwarePaginator
getUpcoming(int $limit = null): Collection
getByCategory(string $category): Collection
getByStatus(string $status): Collection
getByDateRange(Carbon $startDate, Carbon $endDate): Collection
bulkUpdateStatus(array $eventIds, string $status): int
```

---

## 🎯 USAGE IN CONTROLLERS

### Example 1: Basic CRUD with Service

```php
<?php

namespace App\Http\Controllers\Esport\Admin;

use App\Http\Controllers\Controller;
use App\Services\Esport\TournamentService;
use App\Models\Tournament;
use Illuminate\Http\Request;

class TournamentController extends Controller
{
    public function __construct(
        private TournamentService $tournamentService
    ) {}

    public function index(Request $request)
    {
        $filters = $request->only(['game', 'status', 'q']);
        $tournaments = $this->tournamentService->getTournaments($filters);
        
        return view('esport.admin.tournaments.index', compact('tournaments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'game' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
            'status' => 'required|string',
        ]);

        $tournament = $this->tournamentService->createTournament($validated);

        return redirect()->route('esport.admin.tournaments.index')
            ->with('success', 'Tournament created successfully!');
    }

    public function update(Request $request, Tournament $tournament)
    {
        $validated = $request->validate([/* validation rules */]);
        
        $this->tournamentService->updateTournament($tournament, $validated);

        return redirect()->route('esport.admin.tournaments.index')
            ->with('success', 'Tournament updated successfully!');
    }

    public function destroy(Tournament $tournament)
    {
        $this->tournamentService->deleteTournament($tournament);

        return redirect()->route('esport.admin.tournaments.index')
            ->with('success', 'Tournament deleted successfully!');
    }
}
```

### Example 2: API Controller with Service

```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\BukuTamu\VisitorService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class VisitorController extends Controller
{
    public function __construct(
        private VisitorService $visitorService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['date', 'month', 'year', 'purpose', 'name']);
        $perPage = $request->input('per_page', config('pagination.api.default'));
        
        $visitors = $this->visitorService->getVisitors($filters, $perPage);

        return response()->json([
            'success' => true,
            'data' => $visitors->items(),
            'meta' => [
                'current_page' => $visitors->currentPage(),
                'total' => $visitors->total(),
                'per_page' => $visitors->perPage(),
            ],
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([/* validation rules */]);
            
            $visitor = $this->visitorService->createVisitor($validated);

            return response()->json([
                'success' => true,
                'message' => 'Visitor created successfully',
                'data' => $visitor,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function statistics(): JsonResponse
    {
        $stats = $this->visitorService->getStatistics();

        return response()->json([
            'success' => true,
            'data' => $stats,
        ]);
    }
}
```

### Example 3: Using Multiple Services

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\BukuTamu\VisitorService;
use App\Services\Esport\TournamentService;
use App\Services\CalendarEvent\EventService;

class DashboardController extends Controller
{
    public function __construct(
        private VisitorService $visitorService,
        private TournamentService $tournamentService,
        private EventService $eventService
    ) {}

    public function index()
    {
        $visitorStats = $this->visitorService->getStatistics();
        $upcomingTournaments = $this->tournamentService->getUpcomingTournaments(5);
        $upcomingEvents = $this->eventService->getUpcomingEvents(5);

        return view('admin.dashboard', compact(
            'visitorStats',
            'upcomingTournaments',
            'upcomingEvents'
        ));
    }
}
```

---

## ⚙️ USING CONFIG VALUES

### Access Configuration

```php
// Buku Tamu
$purposeOptions = config('buku_tamu.purpose_options');
$maxDistance = config('buku_tamu.geolocation.max_distance_km');
$targetLat = config('buku_tamu.geolocation.target_latitude');
$uploadSettings = config('buku_tamu.upload');

// Esport
$tournamentStatuses = config('esport.tournament.statuses');
$games = config('esport.tournament.games');
$newsCategories = config('esport.news.categories');
$uploadPath = config('esport.upload.tournament_image.storage_path');

// Calendar Event
$eventCategories = config('calendar_event.categories');
$eventStatuses = config('calendar_event.statuses');
$statusBadges = config('calendar_event.status_badges');
$maxParticipants = config('calendar_event.defaults.max_participants');

// Pagination
$webPagination = config('pagination.web.default');
$adminPagination = config('pagination.admin.default');
$apiPagination = config('pagination.api.default');
```

### Use in Blade Views

```blade
{{-- Buku Tamu purpose options --}}
<select name="purpose" required>
    @foreach(config('buku_tamu.purpose_options') as $key => $label)
        <option value="{{ $key }}">{{ $label }}</option>
    @endforeach
</select>

{{-- Event categories --}}
<select name="category">
    @foreach(config('calendar_event.categories') as $key => $label)
        <option value="{{ $key }}">{{ $label }}</option>
    @endforeach
</select>

{{-- Tournament games --}}
<select name="game">
    @foreach(config('esport.tournament.games') as $key => $label)
        <option value="{{ $key }}">{{ $label }}</option>
    @endforeach
</select>
```

### Use in Models

```php
// Get options via static method
$purposeOptions = Visitor::getPurposeOptions();
$eventCategories = Event::getCategories();
$eventStatuses = Event::getStatuses();

// In validation rules
$rules = [
    'purpose' => ['required', Rule::in(array_keys(Visitor::getPurposeOptions()))],
    'category' => ['required', Rule::in(array_keys(Event::getCategories()))],
];
```

---

## 🧪 TESTING EXAMPLES

### Testing Services

```php
<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\Esport\TournamentService;
use App\Repositories\Esport\TournamentRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TournamentServiceTest extends TestCase
{
    use RefreshDatabase;

    private TournamentService $service;
    private TournamentRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new TournamentRepository();
        $this->service = new TournamentService($this->repository);
    }

    public function test_can_create_tournament()
    {
        $data = [
            'title' => 'Test Tournament',
            'game' => 'mobile_legends',
            'date' => now()->addDays(7),
            'location' => 'Online',
            'status' => 'upcoming',
        ];

        $tournament = $this->service->createTournament($data);

        $this->assertDatabaseHas('tournaments', [
            'title' => 'Test Tournament',
            'game' => 'mobile_legends',
        ]);
    }
}
```

### Testing Repositories

```php
<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use App\Repositories\BukuTamu\VisitorRepository;
use App\Models\Visitor;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VisitorRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private VisitorRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new VisitorRepository();
    }

    public function test_can_get_paginated_visitors()
    {
        Visitor::factory()->count(15)->create();

        $result = $this->repository->getPaginated([], 10);

        $this->assertEquals(10, $result->count());
        $this->assertEquals(15, $result->total());
    }

    public function test_can_filter_by_purpose()
    {
        Visitor::factory()->create(['purpose' => 'sekretariat']);
        Visitor::factory()->create(['purpose' => 'aplikasi_informatika']);

        $result = $this->repository->getPaginated(['purpose' => 'sekretariat']);

        $this->assertEquals(1, $result->total());
    }
}
```

---

## 📚 BEST PRACTICES

### 1. Dependency Injection
Always inject services via constructor:
```php
public function __construct(
    private TournamentService $tournamentService
) {}
```

### 2. Type Hints
Use return type hints for better IDE support:
```php
public function getTournaments(array $filters = []): LengthAwarePaginator
{
    return $this->repository->getPaginated($filters);
}
```

### 3. Service Methods
Keep service methods focused and single-purpose:
```php
// ✅ Good
public function createTournament(array $data): Tournament
public function updateTournament(Tournament $tournament, array $data): bool
public function deleteTournament(Tournament $tournament): bool

// ❌ Bad
public function manageTournament(string $action, array $data)
```

### 4. Repository Methods
Use descriptive method names:
```php
// ✅ Good
getUpcoming(int $limit = null): Collection
getByStatus(string $status): Collection
getPaginated(array $filters = []): LengthAwarePaginator

// ❌ Bad
get($type, $params)
```

### 5. Error Handling
Let exceptions bubble up from services:
```php
// In Service
public function createVisitor(array $data): Visitor
{
    $this->geolocationService->validateLocation(...); // May throw exception
    return $this->repository->create($data);
}

// In Controller
try {
    $visitor = $this->visitorService->createVisitor($validated);
    return response()->json(['success' => true, 'data' => $visitor]);
} catch (\Exception $e) {
    return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
}
```

---

## 🎓 LEARNING RESOURCES

- **Repository Pattern:** [Martin Fowler's Patterns](https://martinfowler.com/eaaCatalog/repository.html)
- **Service Layer:** [Domain-Driven Design](https://en.wikipedia.org/wiki/Domain-driven_design)
- **Dependency Injection:** [Laravel Documentation](https://laravel.com/docs/10.x/container)
- **PSR-12:** [PHP Standards](https://www.php-fig.org/psr/psr-12/)

---

## 🆘 TROUBLESHOOTING

### Issue: Service not found
**Solution:** Make sure you're using the correct namespace and the class is autoloaded.

### Issue: Repository returning null
**Solution:** Check if the data exists in database and the query is correct.

### Issue: Config values not loaded
**Solution:** Run `php artisan config:clear` to clear config cache.

### Issue: Dependency injection not working
**Solution:** Make sure the service is registered in Laravel's container or use constructor injection.

---

## ✅ CHECKLIST FOR NEW FEATURES

When adding new features, follow this checklist:

- [ ] Create Repository class (if new model)
- [ ] Create Service class for business logic
- [ ] Create Config file for constants
- [ ] Update Model to use config
- [ ] Create Controller (use service)
- [ ] Create Form Request for validation
- [ ] Write unit tests for Repository
- [ ] Write unit tests for Service
- [ ] Write feature tests for Controller
- [ ] Format code with Laravel Pint
- [ ] Update documentation

---

**Quick Reference Version:** 1.0  
**Last Updated:** December 18, 2025
