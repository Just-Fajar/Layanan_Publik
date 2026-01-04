# UI Components Documentation

Komponen-komponen UI yang dapat digunakan kembali untuk mempercepat development dan konsistensi UI.

## Alert Component

**Usage:**
```blade
<x-ui.alert type="success" dismissible icon>
    Operasi berhasil!
</x-ui.alert>

<x-ui.alert type="danger">
    Terjadi kesalahan!
</x-ui.alert>
```

**Props:**
- `type`: info, success, warning, danger (default: info)
- `dismissible`: boolean (default: false) - menambahkan tombol close
- `icon`: boolean (default: true) - menampilkan icon Font Awesome

---

## Button Component

**Usage:**
```blade
<x-ui.button variant="primary" icon="fa-save">
    Simpan
</x-ui.button>

<x-ui.button variant="danger" outline size="sm" loading>
    Hapus
</x-ui.button>
```

**Props:**
- `variant`: primary, secondary, success, danger, warning, info (default: primary)
- `size`: sm, md, lg (default: md)
- `type`: button, submit, reset (default: button)
- `icon`: Font Awesome icon class
- `loading`: boolean (default: false) - menampilkan spinner
- `outline`: boolean (default: false) - outline style

---

## Card Component

**Usage:**
```blade
<x-ui.card 
    title="Judul Card" 
    image="{{ asset('storage/image.jpg') }}" 
    imageAlt="Description"
>
    <p>Konten card disini</p>
    
    <x-slot:footer>
        <x-ui.button variant="primary">Action</x-ui.button>
    </x-slot:footer>
</x-ui.card>
```

**Props:**
- `title`: string - judul card (optional)
- `image`: URL image (optional)
- `imageAlt`: alt text untuk image
- `footer`: slot untuk footer (optional)

---

## Badge Component

**Usage:**
```blade
<x-ui.badge color="success">Active</x-ui.badge>
<x-ui.badge color="danger" pill>Inactive</x-ui.badge>
```

**Props:**
- `color`: primary, secondary, success, danger, warning, info, light, dark (default: primary)
- `pill`: boolean (default: false) - rounded pill style

---

## Modal Component

**Usage:**
```blade
<x-ui.modal id="myModal" title="Konfirmasi" size="lg" centered>
    <p>Apakah Anda yakin?</p>
    
    <x-slot:footer>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <x-ui.button variant="danger">Hapus</x-ui.button>
    </x-slot:footer>
</x-ui.modal>

<!-- Trigger -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
    Buka Modal
</button>
```

**Props:**
- `title`: string - judul modal
- `size`: sm, md, lg, xl (default: md)
- `centered`: boolean (default: false)
- `scrollable`: boolean (default: false)

---

## Progress Component

**Usage:**
```blade
<x-ui.progress :value="75" :max="100" variant="success" />
<x-ui.progress :value="50" :max="100" striped animated />
```

**Props:**
- `value`: numeric - current value
- `max`: numeric - maximum value (default: 100)
- `variant`: primary, success, info, warning, danger (default: primary)
- `striped`: boolean (default: false)
- `animated`: boolean (default: false)
- `label`: boolean (default: true) - menampilkan persentase

---

## Skeleton Loader Component

**Usage:**
```blade
<!-- Card skeleton -->
<x-ui.skeleton type="card" :count="3" />

<!-- List skeleton -->
<x-ui.skeleton type="list" :count="5" />

<!-- Table skeleton -->
<x-ui.skeleton type="table" :count="10" />
```

**Props:**
- `type`: card, list, table (default: card)
- `count`: number - jumlah skeleton items (default: 3)

---

## Loading Overlay Component

**Usage:**

1. Include di layout utama:
```blade
<!-- Di layout app.blade.php atau guest.blade.php -->
<x-ui.loading-overlay />
```

2. Gunakan di form/link dengan data attribute:
```blade
<!-- Form dengan loading otomatis -->
<form data-loading data-loading-message="Menyimpan data...">
    <!-- form fields -->
</form>

<!-- Link dengan loading otomatis -->
<a href="/page" data-loading data-loading-message="Memuat halaman...">Link</a>
```

3. Atau gunakan manual dengan JavaScript:
```javascript
// Show loading
showLoading('Memproses...');

// Hide loading
hideLoading();
```

---

## Migration Notes

Untuk menggunakan komponen-komponen ini, ganti kode yang sudah ada secara bertahap:

### Sebelum:
```blade
<div class="alert alert-success">
    Berhasil!
</div>
```

### Sesudah:
```blade
<x-ui.alert type="success">
    Berhasil!
</x-ui.alert>
```

**CATATAN PENTING**: Migrasi ke komponen ini bersifat opsional dan tidak wajib. Komponen dibuat untuk mempermudah development ke depannya tanpa merusak UI yang sudah ada.
