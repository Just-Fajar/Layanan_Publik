# 📋 ACTION PLAN: PERBAIKAN PROJECT LAYANAN PUBLIK

## 🎯 Executive Summary

Dokumen ini berisi rencana aksi konkret untuk meningkatkan kualitas project dari **Score 3/5** menjadi **Score 4.5/5** dalam waktu 2-4 minggu.

---

## 🚨 CRITICAL PRIORITY (Week 1)

### 1. Security Fixes - URGENT ⚠️

**Status:** CRITICAL  
**Effort:** 2-3 days  
**Impact:** HIGH

#### A. Ganti Custom Token Authentication

**Problem:**
```php
// ❌ INSECURE
$token = base64_encode($admin->id . ':' . time());
```

**Solution:**
```bash
# Install Sanctum
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate

# Update AuthController untuk menggunakan Sanctum
# Update middleware di routes/api.php
```

**Files to Update:**
- `app/Http/Controllers/Api/AuthController.php`
- `config/sanctum.php`
- `routes/api.php`

#### B. Add Rate Limiting

**Implementation:**
```php
// routes/api.php
Route::middleware(['throttle:60,1'])->group(function () {
    // API routes
});

// routes/web.php - Login routes
Route::post('/login', [...])->middleware('throttle:5,1');
```

#### C. File Upload Security

**Files to Update:**
- `app/Http/Controllers/VisitorController.php`
- `app/Http/Controllers/Api/VisitorController.php`

**Add Validation:**
```php
'photo' => 'required|string|max:5242880', // 5MB base64
// Add mime type validation
// Add dimension validation
```

---

### 2. Request Validation Classes

**Status:** HIGH PRIORITY  
**Effort:** 1 day  
**Impact:** MEDIUM-HIGH

**Create Missing Form Requests:**
```bash
php artisan make:request BukuTamu/StoreVisitorRequest
php artisan make:request BukuTamu/UpdateVisitorRequest
php artisan make:request Esport/StoreTournamentRequest
php artisan make:request Esport/UpdateTournamentRequest
php artisan make:request Esport/StoreNewsRequest
php artisan make:request Esport/UpdateNewsRequest
```

**Implement in Controllers:**
- Replace inline `$request->validate()` dengan Form Requests
- Add custom error messages dalam Bahasa Indonesia

---

### 3. Error Handling

**Status:** HIGH PRIORITY  
**Effort:** 1 day  
**Impact:** MEDIUM

**Update Exception Handler:**

```php
// app/Exceptions/Handler.php

public function register()
{
    $this->renderable(function (NotFoundHttpException $e, $request) {
        if ($request->is('api/*')) {
            return response()->json(['message' => 'Resource not found'], 404);
        }
    });

    $this->renderable(function (ValidationException $e, $request) {
        if ($request->is('api/*')) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        }
    });
}
```

**Set Production Mode:**
```env
APP_DEBUG=false
APP_ENV=production
```

---

## 📊 HIGH PRIORITY (Week 2)

### 4. Architecture Improvement

**Status:** HIGH PRIORITY  
**Effort:** 3-4 days  
**Impact:** HIGH

#### A. Create Service Layer

**Structure:**
```
app/
└── Services/
    ├── BukuTamu/
    │   ├── VisitorService.php
    │   ├── GeolocationService.php
    │   └── ImageProcessingService.php
    ├── Esport/
    │   ├── TournamentService.php
    │   └── NewsService.php
    └── CalendarEvent/
        └── EventService.php
```

**Example: VisitorService.php**
```php
<?php

namespace App\Services\BukuTamu;

use App\Models\Visitor;
use App\Services\ImageProcessingService;
use App\Services\GeolocationService;

class VisitorService
{
    public function __construct(
        private ImageProcessingService $imageService,
        private GeolocationService $geoService
    ) {}

    public function createVisitor(array $data): Visitor
    {
        // Validate geolocation
        if (!$this->geoService->isWithinRange($data['latitude'], $data['longitude'])) {
            throw new \Exception('Location out of range');
        }

        // Process image
        $photoPath = $this->imageService->processAndStore($data['photo'], 'visitors');

        // Create visitor
        return Visitor::create([
            ...$data,
            'photo_path' => $photoPath,
            'visit_date' => now()
        ]);
    }
}
```

#### B. Create Repository Pattern

**Create Repositories:**
```bash
mkdir app/Repositories
# Create VisitorRepository, TournamentRepository, etc.
```

---

### 5. Restructure Buku Tamu Module

**Status:** MEDIUM-HIGH  
**Effort:** 2 days  
**Impact:** MEDIUM

**New Structure:**
```
app/
└── Http/
    └── Controllers/
        └── BukuTamu/
            ├── Web/
            │   ├── VisitorController.php
            │   └── DashboardController.php
            └── Admin/
                ├── VisitorController.php
                └── DashboardController.php
```

**Refactor Routes:**
```php
// Consolidate admin routes
Route::prefix('admin')->middleware('admin.auth')->group(function() {
    Route::get('/dashboard', ...);
    Route::resource('buku-tamu', ...);
    Route::resource('esport/tournaments', ...);
    Route::resource('calendar/events', ...);
});
```

---

### 6. API Versioning & Resources

**Status:** MEDIUM  
**Effort:** 2 days  
**Impact:** MEDIUM

**Create API Resources:**
```bash
php artisan make:resource VisitorResource
php artisan make:resource TournamentResource
php artisan make:resource NewsResource
php artisan make:resource EventResource
```

**Restructure API Routes:**
```php
// routes/api.php
Route::prefix('v1')->group(function () {
    Route::post('/auth/login', [AuthController::class, 'login']);
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('visitors', VisitorController::class);
        Route::apiResource('tournaments', TournamentController::class);
        Route::apiResource('events', EventController::class);
    });
});
```

---

## ⚙️ MEDIUM PRIORITY (Week 3)

### 7. Testing Implementation

**Status:** CRITICAL for QUALITY  
**Effort:** 4-5 days  
**Impact:** HIGH

**Test Coverage Target: 70%**

**Create Tests:**
```bash
# Feature Tests
php artisan make:test BukuTamu/VisitorTest
php artisan make:test BukuTamu/Admin/DashboardTest
php artisan make:test Esport/TournamentTest
php artisan make:test Esport/NewsTest
php artisan make:test CalendarEvent/EventTest

# Unit Tests
php artisan make:test Services/GeolocationServiceTest --unit
php artisan make:test Services/ImageProcessingServiceTest --unit
```

**Example Test:**
```php
<?php

namespace Tests\Feature\BukuTamu;

use Tests\TestCase;
use App\Models\Visitor;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VisitorTest extends TestCase
{
    use RefreshDatabase;

    public function test_visitor_can_register_within_range()
    {
        $response = $this->postJson('/api/visitors', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'latitude' => -7.632269,
            'longitude' => 111.530132,
            // ... other fields
        ]);

        $response->assertStatus(201)
                 ->assertJson(['success' => true]);
    }

    public function test_visitor_cannot_register_outside_range()
    {
        $response = $this->postJson('/api/visitors', [
            'latitude' => -6.0,
            'longitude' => 110.0,
            // ...
        ]);

        $response->assertStatus(403);
    }
}
```

**Setup CI/CD:**
```yaml
# .github/workflows/tests.yml
name: Tests

on: [push, pull_request]

jobs:
  tests:
    runs-on: ubuntu-latest
    
    steps:
    - uses: actions/checkout@v2
    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: 8.2
    - name: Install Dependencies
      run: composer install
    - name: Run Tests
      run: php artisan test
```

---

### 8. Performance Optimization

**Status:** MEDIUM  
**Effort:** 2-3 days  
**Impact:** MEDIUM-HIGH

#### A. Database Optimization

**Add Missing Indexes:**
```php
// Create migration: 2025_12_17_add_indexes_to_tables

Schema::table('visitors', function (Blueprint $table) {
    $table->index('visit_date');
    $table->index('purpose');
    $table->index(['visit_date', 'purpose']);
});

Schema::table('tournaments', function (Blueprint $table) {
    $table->index('date');
    $table->index('status');
    $table->index('game');
});

Schema::table('news', function (Blueprint $table) {
    $table->index('category');
    $table->index('created_at');
});
```

#### B. Query Optimization

**Add Select Specific Columns:**
```php
// Instead of:
$visitors = Visitor::all();

// Use:
$visitors = Visitor::select('id', 'name', 'visit_date', 'purpose')
    ->orderBy('visit_date', 'desc')
    ->paginate(10);
```

#### C. Implement Caching

**Setup Redis:**
```bash
composer require predis/predis
```

```env
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

**Cache Implementation:**
```php
// In DashboardController
public function statistics()
{
    return Cache::remember('dashboard.statistics', 3600, function () {
        return [
            'total_visitors' => Visitor::count(),
            'visitors_today' => Visitor::whereDate('visit_date', today())->count(),
            'upcoming_events' => Event::upcoming()->count(),
        ];
    });
}
```

#### D. Image Optimization

**Install Intervention Image:**
```bash
composer require intervention/image
```

**Create ImageService:**
```php
namespace App\Services;

use Intervention\Image\Facades\Image;

class ImageProcessingService
{
    public function processAndStore(string $base64Data, string $folder): string
    {
        $image = Image::make($base64Data);
        
        // Resize if too large
        if ($image->width() > 1920) {
            $image->resize(1920, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        }
        
        // Compress
        $image->encode('jpg', 80);
        
        // Store
        $filename = uniqid() . '.jpg';
        $path = "{$folder}/{$filename}";
        Storage::disk('public')->put($path, $image->stream());
        
        // Create thumbnail
        $thumb = $image->fit(300, 300);
        Storage::disk('public')->put("{$folder}/thumbs/{$filename}", $thumb->stream());
        
        return $path;
    }
}
```

---

### 9. UI/UX Improvements

**Status:** MEDIUM  
**Effort:** 2-3 days  
**Impact:** MEDIUM

#### A. Create Blade Components

**Create Reusable Components:**
```bash
php artisan make:component Alert
php artisan make:component Card
php artisan make:component Button
php artisan make:component Badge
```

**Example: Alert Component**
```blade
{{-- resources/views/components/alert.blade.php --}}
@props(['type' => 'info'])

<div {{ $attributes->merge(['class' => "alert alert-{$type} alert-dismissible fade show"]) }} role="alert">
    {{ $slot }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
```

**Usage:**
```blade
<x-alert type="success">
    Data berhasil disimpan!
</x-alert>
```

#### B. Loading States

**Add Skeleton Loaders:**
```html
<div class="skeleton-loader">
    <div class="skeleton skeleton-text"></div>
    <div class="skeleton skeleton-text"></div>
    <div class="skeleton skeleton-box"></div>
</div>
```

#### C. Standardize pada Font Awesome

**Remove unused icon libraries**

---

## 🔄 LOW PRIORITY (Week 4)

### 10. Documentation

**Create:**
- API Documentation (Swagger/OpenAPI)
- User Manual
- Developer Guide
- Deployment Guide

### 11. Additional Features

**Optional Enhancements:**
- Dark Mode Toggle
- Multi-language Support (i18n)
- Export to Excel/PDF
- Advanced Search & Filters
- Activity Logs (Audit Trail)
- Email Notifications
- SMS Integration

---

## 📈 METRICS & SUCCESS CRITERIA

### Code Quality Metrics
- [ ] Code Coverage: >= 70%
- [ ] PHPStan Level: 6+
- [ ] No Critical Security Issues
- [ ] Response Time: < 200ms (average)

### Architecture Metrics
- [ ] Service Layer Implemented
- [ ] Repository Pattern Implemented
- [ ] All Validations in Form Requests
- [ ] API Resources Implemented

### Security Metrics
- [ ] Sanctum Authentication
- [ ] Rate Limiting Active
- [ ] File Upload Validated
- [ ] HTTPS Enforced
- [ ] CORS Configured

---

## 🎯 FINAL CHECKLIST

### Week 1
- [ ] Replace custom token with Sanctum
- [ ] Add rate limiting
- [ ] Create Form Request classes
- [ ] Improve error handling
- [ ] Add file upload security

### Week 2
- [ ] Create Service Layer
- [ ] Implement Repository Pattern
- [ ] Restructure Buku Tamu module
- [ ] Add API versioning
- [ ] Create API Resources

### Week 3
- [ ] Write Feature Tests (70% coverage)
- [ ] Write Unit Tests
- [ ] Setup CI/CD
- [ ] Add database indexes
- [ ] Implement caching
- [ ] Optimize images

### Week 4
- [ ] Create Blade components
- [ ] Add loading states
- [ ] Write documentation
- [ ] Final testing
- [ ] Deploy to production

---

## 📞 SUPPORT & RESOURCES

### Laravel Documentation
- https://laravel.com/docs/10.x
- https://laravel.com/docs/10.x/sanctum
- https://laravel.com/docs/10.x/testing

### Best Practices
- SOLID Principles
- DRY (Don't Repeat Yourself)
- KISS (Keep It Simple, Stupid)
- Repository Pattern
- Service Layer Pattern

---

**Document Version:** 1.0  
**Last Updated:** December 17, 2025  
**Status:** 🚀 **READY TO IMPLEMENT**
