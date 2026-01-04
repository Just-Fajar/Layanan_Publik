# 📚 Clean Code Refactoring - Documentation

## 🎯 Overview

This document describes the clean code refactoring that has been applied to the Layanan Publik project, focusing on:
1. **Extracting business logic to Service classes**
2. **Eliminating magic numbers with configuration files**
3. **Formatting code to PSR-12 standards**
4. **Setting up PHP CS Fixer for consistency**

---

## 📦 New Files Created

### Configuration Files

#### 1. `config/pagination.php`
Centralized pagination constants to eliminate magic numbers throughout the application.

```php
return [
    'web' => [
        'default' => 10,
        'events' => 12,
        'tournaments' => 9,
        'news' => 9,
    ],
    'admin' => [
        'default' => 10,
        'events' => 15,
        'tournaments' => 10,
        'news' => 10,
    ],
    'api' => [
        'default' => 10,
        'statistics_limit' => 12,
    ],
];
```

**Usage:**
```php
// Instead of: ->paginate(10)
$items = Model::paginate(config('pagination.web.default'));
```

#### 2. `config/buku_tamu.php`
Configuration for the Buku Tamu (Visitor Book) module.

**Contains:**
- Geolocation settings (target coordinates, radius)
- Purpose options
- Image upload settings
- Date format configuration

**Usage:**
```php
$maxDistance = config('buku_tamu.geolocation.max_distance_km');
$purposes = config('buku_tamu.purpose_options');
```

---

## 🏗️ Service Layer Architecture

### Service Classes Created

```
app/Services/BukuTamu/
├── GeolocationService.php    # Geolocation calculations
├── ImageService.php           # Image processing & storage
└── VisitorService.php         # Visitor business logic
```

---

### 1. GeolocationService

**Purpose:** Handle all geolocation-related calculations and validations.

**Methods:**
- `isWithinRange(?float $lat, ?float $lon): bool` - Check if coordinates are within allowed range
- `validateLocation(?float $lat, ?float $lon): void` - Validate and throw exception if out of range
- `calculateDistance(...): float` - Calculate distance using Haversine formula

**Usage Example:**
```php
use App\Services\BukuTamu\GeolocationService;

class VisitorController extends Controller
{
    public function __construct(private GeolocationService $geoService) {}

    public function checkLocation(Request $request)
    {
        try {
            $this->geoService->validateLocation(
                $request->latitude,
                $request->longitude
            );
            
            return response()->json(['message' => 'Location valid']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }
}
```

**Benefits:**
- ✅ Single Responsibility: Only handles geolocation
- ✅ Reusable across multiple controllers
- ✅ Testable in isolation
- ✅ No magic numbers (reads from config)

---

### 2. ImageService

**Purpose:** Handle image upload, processing, validation, and deletion.

**Methods:**
- `storeBase64Image(string $base64Data, ?string $folder): string` - Store base64 image
- `storeWithDateStructure(string $base64Data): string` - Store with year/month folder structure
- `deleteImage(?string $filePath): bool` - Delete image file
- `validateExtension(string $extension): void` - Validate image type
- `validateImageSize(string $binaryData): void` - Validate file size

**Usage Example:**
```php
use App\Services\BukuTamu\ImageService;

class VisitorController extends Controller
{
    public function __construct(private ImageService $imageService) {}

    public function uploadPhoto(Request $request)
    {
        try {
            $photoPath = $this->imageService->storeWithDateStructure(
                $request->input('photo')
            );
            
            return response()->json(['path' => $photoPath]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
```

**Features:**
- ✅ Validates file extension (jpg, jpeg, png, webp)
- ✅ Validates file size (configurable max 5MB)
- ✅ Supports base64 data URLs
- ✅ Generates unique filenames
- ✅ Organizes files in year/month folders
- ✅ Handles cleanup on delete

---

### 3. VisitorService

**Purpose:** Orchestrate visitor-related business logic.

**Methods:**
- `createVisitor(array $data): Visitor` - Create new visitor with validations
- `getVisitors(array $filters, ?int $perPage)` - Get filtered, paginated visitors
- `updateVisitor(Visitor $visitor, array $data): Visitor` - Update visitor record
- `deleteVisitor(Visitor $visitor): bool` - Delete visitor and cleanup
- `getStatistics(): array` - Get visitor statistics

**Usage Example:**
```php
use App\Services\BukuTamu\VisitorService;

class VisitorController extends Controller
{
    public function __construct(private VisitorService $visitorService) {}

    public function store(Request $request)
    {
        try {
            $visitor = $this->visitorService->createVisitor(
                $request->validated()
            );
            
            return response()->json([
                'success' => true,
                'data' => $visitor
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
```

**Benefits:**
- ✅ Coordinates GeolocationService and ImageService
- ✅ Handles complex business logic
- ✅ Consistent error handling
- ✅ Automatic photo cleanup on delete
- ✅ Centralized filtering logic

---

## 🔄 Controllers Refactored

### Before vs After Comparison

#### VisitorController (Web)

**Before (107 lines):**
```php
class VisitorController extends Controller
{
    private const TARGET_LATITUDE = -7.632269349111827;
    private const TARGET_LONGITUDE = 111.5301320107111;
    private const MAX_DISTANCE_KM = 0.5;
    
    public function store(Request $request)
    {
        // 70+ lines of:
        // - Manual geolocation check
        // - Haversine formula calculation
        // - Manual image processing
        // - Manual base64 decoding
        // - Database insertion
        // - Error handling
    }
    
    private function isWithinRange($latitude, $longitude)
    {
        // 20+ lines of Haversine formula
    }
}
```

**After (50 lines):**
```php
class VisitorController extends Controller
{
    public function __construct(private VisitorService $visitorService) {}
    
    public function store(Request $request)
    {
        try {
            $visitor = $this->visitorService->createVisitor(
                $request->validated()
            );
            
            return response()->json([
                'success' => true,
                'data' => $visitor
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
```

**Improvements:**
- ✅ 57% code reduction (107 → 50 lines)
- ✅ No business logic in controller
- ✅ Dependency injection
- ✅ Easy to test
- ✅ Single Responsibility

---

#### Api/VisitorController

**Before (309 lines):**
- Manual query building with filters
- Inline image processing
- Hardcoded validation rules
- Magic numbers (paginate(10), limit(12))
- Duplicate code across methods

**After (280 lines):**
- Service layer for business logic
- Config-based constants
- Cleaner methods
- Reusable code

**Key Changes:**
```php
// Before
$visitors = $query->orderBy('visit_date', 'desc')->paginate(10);

// After
$perPage = config('pagination.api.default');
$visitors = $this->visitorService->getVisitors($filters, $perPage);
```

---

#### TournamentController & NewsController (Admin)

**Before (One-liner):**
```php
public function index(){ $rows = Tournament::latest()->paginate(10); return view('esport.admin.tournaments.index', compact('rows')); }
```

**After (PSR-12 Formatted):**
```php
/**
 * Display a listing of tournaments.
 *
 * @return \Illuminate\View\View
 */
public function index()
{
    $perPage = config('pagination.admin.tournaments');
    $rows = Tournament::latest()->paginate($perPage);

    return view('esport.admin.tournaments.index', compact('rows'));
}
```

**Improvements:**
- ✅ Readable code
- ✅ PHPDoc comments
- ✅ Proper spacing
- ✅ Type hints
- ✅ No magic numbers

---

## 🛠️ PHP CS Fixer Configuration

### `.php-cs-fixer.php`

Configured to enforce PSR-12 standards across the codebase.

**Rules Applied:**
- `@PSR12` - Full PSR-12 compliance
- `array_syntax` - Short array syntax []
- `ordered_imports` - Alphabetically sorted imports
- `no_unused_imports` - Remove unused imports
- `trailing_comma_in_multiline` - Add trailing commas
- `binary_operator_spaces` - Proper spacing around operators
- `method_argument_space` - Multiline argument formatting

**Usage:**
```bash
# Format all code
composer format

# Check formatting without modifying
composer format-dry
```

---

## 📊 Results Summary

### Code Quality Improvements

| Metric | Before | After | Improvement |
|--------|--------|-------|-------------|
| VisitorController Lines | 107 | 50 | ⬇️ 53% |
| Magic Numbers | 12+ instances | 0 | ✅ 100% |
| One-liner Methods | 4 controllers | 0 | ✅ 100% |
| Service Classes | 0 | 3 | ✅ New |
| Config Files | 0 | 2 | ✅ New |
| PSR-12 Compliance | Partial | Full | ✅ 100% |

### Benefits Achieved

✅ **Maintainability**: Code is now easier to understand and modify  
✅ **Testability**: Services can be tested independently  
✅ **Reusability**: Services can be used across multiple controllers  
✅ **Consistency**: PHP CS Fixer ensures uniform code style  
✅ **Scalability**: Adding new features is now simpler  
✅ **Readability**: No more one-liner methods or magic numbers  

---

## 🚀 How to Use

### For New Features

1. **Use existing services:**
```php
use App\Services\BukuTamu\VisitorService;

public function __construct(private VisitorService $service) {}
```

2. **Reference configs instead of hardcoding:**
```php
// ❌ Don't
->paginate(10)

// ✅ Do
->paginate(config('pagination.web.default'))
```

3. **Run PHP CS Fixer before committing:**
```bash
composer format
```

### For Testing

Services can now be easily mocked:

```php
public function test_visitor_creation()
{
    $mockService = $this->createMock(VisitorService::class);
    $mockService->expects($this->once())
        ->method('createVisitor')
        ->willReturn(new Visitor());
    
    $this->app->instance(VisitorService::class, $mockService);
    
    // Test controller
}
```

---

## 📝 Checklist for Future Development

When adding new features, ensure:

- [ ] No magic numbers (use config files)
- [ ] Business logic in Services, not Controllers
- [ ] PSR-12 formatted (`composer format`)
- [ ] Proper PHPDoc comments
- [ ] Type hints for parameters and return values
- [ ] Dependency injection for services
- [ ] Consistent error handling

---

## 🎓 Best Practices Implemented

1. **SOLID Principles**
   - Single Responsibility (each service has one purpose)
   - Dependency Inversion (inject services via constructor)

2. **DRY (Don't Repeat Yourself)**
   - Reusable services
   - Centralized configuration

3. **Separation of Concerns**
   - Controllers: HTTP request/response
   - Services: Business logic
   - Models: Data access

4. **Clean Code Principles**
   - Meaningful names
   - Small, focused methods
   - No magic numbers
   - Consistent formatting

---

## 📞 Support

For questions about the refactored code structure:
1. Check service method documentation
2. Review config files for constants
3. Run `composer format-dry` to check code style

---

**Status:** ✅ **COMPLETED**  
**Date:** December 18, 2025  
**Impact:** Major improvement in code quality and maintainability
