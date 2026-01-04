# 📚 PANDUAN IMPLEMENTASI MODUL CALENDAR EVENT

## 🎯 Overview
Modul Calendar Event telah dibuat dengan struktur yang clean, modular, dan mengikuti best practices Laravel.

## 📁 Struktur File yang Dibuat

```
app/
├── Models/
│   └── Event.php ✅
├── Http/
│   ├── Controllers/
│   │   └── CalendarEvent/
│   │       ├── EventController.php ✅
│   │       └── Admin/
│   │           └── EventController.php ✅
│   └── Requests/
│       └── CalendarEvent/
│           ├── StoreEventRequest.php ✅
│           └── UpdateEventRequest.php ✅
database/
├── migrations/
│   └── 2025_12_17_000000_create_events_table.php ✅
└── seeders/
    └── EventSeeder.php ✅
resources/
└── views/
    └── calendar_event/
        ├── index.blade.php ✅
        └── admin/
            └── index.blade.php ✅
routes/
└── web.php (Updated) ✅
```

## 🚀 Langkah Instalasi

### 1. Jalankan Migration
```bash
php artisan migrate
```

### 2. (Opsional) Jalankan Seeder untuk Data Sampel
```bash
php artisan db:seed --class=EventSeeder
```

### 3. Buat Storage Link (jika belum)
```bash
php artisan storage:link
```

### 4. Update Navigation di Homepage
Edit file `resources/views/homepage/homepage.blade.php` atau layout yang sesuai, tambahkan link menu:

```html
<li class="nav-item">
    <a class="nav-link" href="{{ route('calendar.index') }}">
        <i class="fas fa-calendar-alt"></i> Calendar Event
    </a>
</li>
```

## 📍 Routes yang Tersedia

### Public Routes
- `GET /calendar` - List semua event (published)
- `GET /calendar/view` - Tampilan kalender
- `GET /calendar/events/{event}` - Detail event

### Admin Routes (Protected dengan admin.auth middleware)
- `GET /buku-tamu/admin/calendar/events` - List events (all)
- `GET /buku-tamu/admin/calendar/events/create` - Form create
- `POST /buku-tamu/admin/calendar/events` - Store event
- `GET /buku-tamu/admin/calendar/events/{event}/edit` - Form edit
- `PUT /buku-tamu/admin/calendar/events/{event}` - Update event
- `DELETE /buku-tamu/admin/calendar/events/{event}` - Delete event
- `POST /buku-tamu/admin/calendar/events/bulk-action` - Bulk actions

## 🎨 Views yang Perlu Dibuat

View dasar sudah dibuat (`index.blade.php` dan `admin/index.blade.php`).

**View tambahan yang perlu dibuat:**

1. **calendar_event/show.blade.php** - Detail event untuk public
2. **calendar_event/calendar.blade.php** - View kalender
3. **calendar_event/admin/create.blade.php** - Form tambah event
4. **calendar_event/admin/edit.blade.php** - Form edit event
5. **calendar_event/admin/show.blade.php** - Detail event di admin

## ✨ Fitur yang Tersedia

### Model Features
- ✅ Soft Deletes
- ✅ Date Casting (Carbon)
- ✅ Image URL Accessor
- ✅ Status Badge Accessor
- ✅ Query Scopes (published, upcoming, filter)
- ✅ Category Constants

### Validation
- ✅ Form Request Classes dengan custom messages (Bahasa Indonesia)
- ✅ Image upload validation
- ✅ Date logic validation
- ✅ Enum validation

### Controller Features
- ✅ CRUD operations
- ✅ File upload handling
- ✅ Filter & search
- ✅ Pagination
- ✅ Bulk actions (publish, draft, delete)

### Security
- ✅ Admin authentication middleware
- ✅ CSRF protection
- ✅ File validation
- ✅ Soft deletes

### Performance
- ✅ Database indexes (start_date, status, category)
- ✅ Pagination
- ✅ Query optimization dengan scopes

## 🔒 Authorization (TODO)

Untuk menambahkan authorization policy:

```bash
php artisan make:policy EventPolicy --model=Event
```

Kemudian register di `AuthServiceProvider`:

```php
protected $policies = [
    Event::class => EventPolicy::class,
];
```

## 🧪 Testing (Recommended)

Buat test untuk modul:

```bash
php artisan make:test CalendarEvent/EventTest
php artisan make:test CalendarEvent/AdminEventTest
```

## 📊 Dashboard Integration

Untuk menampilkan statistik di admin dashboard:

```php
// Di DashboardController
$upcomingEvents = Event::upcoming()->count();
$totalEvents = Event::count();
```

## 🎯 Rekomendasi Pengembangan Lanjutan

1. **API Endpoints** - Buat API untuk mobile apps
2. **Event Registration** - Sistem pendaftaran peserta
3. **Email Notifications** - Reminder sebelum event
4. **iCalendar Export** - Export ke Google Calendar
5. **Event Categories Management** - Dynamic categories
6. **Event Gallery** - Multiple images per event
7. **Event Feedback** - Rating & review setelah event
8. **QR Code Check-in** - Presensi peserta dengan QR

## 🔄 Integration dengan Modul Lain

### Buku Tamu
- Visitor bisa melihat event upcoming
- Link event dari dashboard admin

### Esport
- Tournament bisa linked ke event
- News bisa mention event

## ⚠️ Notes

1. Pastikan middleware `admin.auth` sudah terdaftar di `Kernel.php`
2. Storage symlink harus dibuat untuk upload images
3. Sesuaikan layout `layouts.app` untuk admin views
4. Tambahkan FullCalendar.js untuk calendar view yang interaktif

## 📞 Support

Jika ada pertanyaan atau issue, silakan dokumentasikan di project README atau issue tracker.

---

**Status:** ✅ **READY TO USE**

**Last Updated:** December 17, 2025
