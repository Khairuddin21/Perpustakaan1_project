# Fitur Pustakawan - Sistem Perpustakaan

## Overview
Dokumentasi untuk fitur-fitur yang dapat diakses oleh role **Pustakawan** dalam sistem perpustakaan.

## Akses Fitur

### 1. Dashboard Pustakawan
**Route:** `/dashboard`  
**View:** `resources/views/dashboard/pustakawan.blade.php`  
**Component:** `resources/views/components/pustakawan-sidebar.blade.php`

**Fitur:**
- ✅ Statistik peminjaman (Total Dipinjam, Terlambat, Dikembalikan Hari Ini)
- ✅ Action cards untuk akses cepat
- ✅ Aktivitas terkini
- ✅ Navigasi ke fitur lain

---

### 2. Akses Peminjaman
**Route:** `/loan-requests`  
**View:** `resources/views/dashboard/loan-requests.blade.php`  
**Controller:** `LoanController::showLoanRequests()`

**Fitur:**
- ✅ Melihat semua permintaan peminjaman dari user
- ✅ Filter berdasarkan status (Pending, Approved, Rejected)
- ✅ Statistik ringkas permintaan
- ✅ Approve/Reject permintaan peminjaman
- ✅ Melihat detail peminjaman

**Role Access:** Admin & Pustakawan

**Cara Kerja:**
1. User mengajukan permintaan peminjaman melalui halaman Browse Books
2. Pustakawan melihat permintaan di halaman "Akses Peminjaman"
3. Pustakawan dapat:
   - ✅ **Approve** - Menyetujui peminjaman
   - ❌ **Reject** - Menolak peminjaman dengan alasan
4. Setelah disetujui, buku masuk ke status "borrowed"

---

### 3. Pengembalian Buku
**Route:** `/returns`  
**View:** `resources/views/dashboard/returns.blade.php`  
**Controller:** `ReturnController::index()`

**Fitur:**
- ✅ Melihat semua buku yang sedang dipinjam oleh user
- ✅ Informasi peminjam (Nama, Email, NIS)
- ✅ Status buku (Tanggal pinjam, Jatuh tempo, Sisa hari)
- ✅ Form pengembalian dengan kondisi buku
- ✅ Proses pengembalian langsung

**Role Access:** Admin, Pustakawan, & User

**Perbedaan Akses:**

#### Untuk Pustakawan/Admin:
- ✅ Melihat **semua buku** yang dipinjam oleh semua user
- ✅ Melihat informasi peminjam (Nama, Email, NIS)
- ✅ Dapat **langsung memproses** pengembalian tanpa perlu mengisi NIS/Nama
- ✅ Form lebih sederhana dengan fokus pada kondisi buku

#### Untuk User Biasa:
- ✅ Melihat **hanya buku** yang dipinjam oleh diri sendiri
- ✅ Harus mengisi NIS dan Nama Lengkap
- ✅ **Mengajukan permintaan** pengembalian
- ✅ Perlu datang ke perpustakaan untuk konfirmasi fisik

**Cara Kerja untuk Pustakawan:**
1. Pustakawan membuka halaman "Pengembalian Buku"
2. Melihat daftar semua buku yang sedang dipinjam
3. Setiap card menampilkan:
   - Judul & Penulis buku
   - Informasi Peminjam (Nama, Email, NIS)
   - Tanggal Pinjam & Jatuh Tempo
   - Status (Terlambat/Normal)
4. Pustakawan dapat langsung memproses pengembalian dengan:
   - Memilih kondisi buku (Baik, Rusak Ringan, Rusak Berat)
   - Menambahkan catatan (opsional)
   - Klik "Proses Pengembalian"
5. Sistem otomatis:
   - Update status loan menjadi "returned"
   - Mengembalikan stok buku
   - Menghitung denda jika terlambat

---

### 4. Laporan & Statistik
**Route:** `/reports`  
**View:** `resources/views/dashboard/reports.blade.php`  
**Controller:** `ReportController::index()`

**Fitur:**
- ✅ Laporan peminjaman
- ✅ Statistik buku
- ✅ Export PDF/Excel
- ✅ Filter berdasarkan tanggal

**Role Access:** Admin & Pustakawan

---

## Component Sidebar

### Pustakawan Sidebar
**File:** `resources/views/components/pustakawan-sidebar.blade.php`

**Menu:**
```
📚 Menu Utama
  - Dashboard

📋 Transaksi
  - Akses Peminjaman
  - Pengembalian Buku

📊 Laporan
  - Laporan & Statistik
```

**Usage:**
```blade
<x-pustakawan-sidebar />
```

---

## Routes

### Protected Routes (Auth + Role)
```php
// Untuk Admin & Pustakawan
Route::middleware(['role:admin,pustakawan'])->group(function () {
    Route::get('/loan-requests', [LoanController::class, 'showLoanRequests'])->name('loan-requests');
    Route::get('/reports', [ReportController::class, 'index'])->name('admin.reports');
});

// Untuk semua authenticated users (dengan logic berbeda di controller)
Route::middleware(['auth'])->group(function () {
    Route::get('/returns', [ReturnController::class, 'index'])->name('returns.index');
});
```

---

## Controller Logic

### ReturnController::index()
```php
public function index()
{
    $user = Auth::user();
    
    // Jika admin atau pustakawan, tampilkan semua buku yang dipinjam
    if (in_array($user->role, ['admin', 'pustakawan'])) {
        $borrowedBooks = Loan::with(['book', 'user'])
            ->whereIn('status', ['borrowed', 'overdue'])
            ->where('return_hidden', false)
            ->orderBy('due_date', 'asc')
            ->get();
    } else {
        // Jika user biasa, tampilkan hanya buku miliknya
        $borrowedBooks = Loan::with(['book'])
            ->where('user_id', $user->id)
            ->whereIn('status', ['borrowed', 'overdue'])
            ->where('return_hidden', false)
            ->orderBy('due_date', 'asc')
            ->get();
    }

    return view('dashboard.returns', compact('borrowedBooks'));
}
```

---

## View Logic

### Conditional Display
File: `resources/views/dashboard/returns.blade.php`

**1. Sidebar Component**
```blade
@if(auth()->user()->role === 'admin')
    <x-admin-sidebar />
@elseif(auth()->user()->role === 'pustakawan')
    <x-pustakawan-sidebar />
@else
    <x-sidebar />
@endif
```

**2. Page Header**
```blade
@if(in_array(auth()->user()->role, ['admin', 'pustakawan']))
    <p>Kelola permintaan pengembalian buku dari anggota perpustakaan.</p>
@else
    <p>Ajukan pengembalian untuk buku yang sedang Anda pinjam.</p>
@endif
```

**3. Informasi Peminjam (Hanya untuk Staff)**
```blade
@if(in_array(auth()->user()->role, ['admin', 'pustakawan']))
    <div class="book-info-row">
        <i class="fas fa-user"></i>
        <span class="label">Peminjam:</span>
        <span class="value">{{ $loan->user->name }}</span>
    </div>
@endif
```

**4. Form Pengembalian**
```blade
@if(!in_array(auth()->user()->role, ['admin', 'pustakawan']))
    <!-- Field NIS & Nama untuk user biasa -->
@else
    <!-- Hidden fields untuk staff -->
    <input type="hidden" name="return_nis" value="{{ $loan->nis ?? 'STAFF' }}">
    <input type="hidden" name="return_borrower_name" value="{{ $loan->user->name }}">
@endif
```

**5. Button Text**
```blade
@if(in_array(auth()->user()->role, ['admin', 'pustakawan']))
    <i class="fas fa-check"></i> Proses Pengembalian
@else
    <i class="fas fa-paper-plane"></i> Ajukan Pengembalian
@endif
```

---

## JavaScript Logic

### Dynamic Confirmation Message
```javascript
const userRole = '{{ auth()->user()->role }}';
const isStaff = ['admin', 'pustakawan'].includes(userRole);

const confirmTitle = isStaff ? 
    'Konfirmasi Proses Pengembalian' : 
    'Konfirmasi Pengembalian';

const confirmText = isStaff ? 
    'Apakah Anda yakin ingin memproses pengembalian buku ini?' : 
    'Apakah Anda yakin ingin mengajukan pengembalian dengan data berikut?';
```

---

## Testing

### Test Akses Pustakawan

1. **Login sebagai Pustakawan**
2. **Test Dashboard:**
   - Akses `/dashboard`
   - Verifikasi statistik muncul
   - Verifikasi sidebar menampilkan menu Pustakawan
3. **Test Akses Peminjaman:**
   - Klik "Akses Peminjaman" di sidebar
   - Verifikasi dapat melihat semua permintaan
   - Test approve/reject permintaan
4. **Test Pengembalian:**
   - Klik "Pengembalian Buku" di sidebar
   - Verifikasi dapat melihat semua buku yang dipinjam
   - Verifikasi informasi peminjam muncul
   - Test proses pengembalian
5. **Test Laporan:**
   - Klik "Laporan & Statistik"
   - Verifikasi dapat melihat laporan

---

## Security

### Middleware Protection
```php
Route::middleware(['role:admin,pustakawan'])->group(function () {
    // Routes hanya bisa diakses oleh admin & pustakawan
});
```

### Controller-Level Check
```php
if (in_array($user->role, ['admin', 'pustakawan'])) {
    // Logic khusus untuk staff
}
```

---

## Future Improvements

- [ ] Notifikasi real-time untuk pustakawan
- [ ] Scan barcode untuk proses pengembalian
- [ ] Laporan denda otomatis
- [ ] Export data peminjaman
- [ ] Dashboard analytics yang lebih detail
- [ ] Fitur cari & filter di halaman pengembalian
- [ ] Bulk processing untuk multiple returns

---

## Troubleshooting

### Pustakawan tidak bisa akses halaman
**Solusi:** Pastikan di database field `role` = `'pustakawan'`

### Sidebar tidak muncul
**Solusi:** Clear cache views
```bash
php artisan view:clear
```

### Informasi peminjam tidak muncul
**Solusi:** Pastikan eager loading `->with(['book', 'user'])`

---

## Contact
Untuk pertanyaan atau bug report, hubungi tim development.

---

**Last Updated:** 16 Oktober 2025
