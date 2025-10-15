# Fitur Pengembalian Buku

## Overview
Fitur pengembalian buku memungkinkan pengguna untuk mengajukan permintaan pengembalian buku yang sedang dipinjam melalui halaman khusus. Setelah mengisi formulir, pengguna harus datang ke perpustakaan untuk mengembalikan buku secara fisik.

## Komponen yang Dibuat

### 1. Database Migration
**File**: `database/migrations/2025_10_15_132559_add_return_fields_to_loans_table.php`

Menambahkan kolom-kolom baru ke tabel `loans`:
- `return_nis` - NIS peminjam
- `return_borrower_name` - Nama lengkap peminjam
- `return_notes` - Catatan tambahan (opsional)
- `return_request_date` - Tanggal pengajuan pengembalian
- `return_condition` - Kondisi buku (baik, rusak_ringan, rusak_berat)

### 2. Controller Methods
**File**: `app/Http/Controllers/ReturnController.php`

Dua method baru ditambahkan:
- `userReturns()` - Menampilkan halaman pengembalian dengan daftar buku yang dipinjam
- `submitReturn(Request $request)` - Memproses pengajuan pengembalian via API

### 3. View
**File**: `resources/views/dashboard/returns.blade.php`

Halaman pengembalian yang menampilkan:
- Daftar buku yang sedang dipinjam dalam grid card
- Informasi detail setiap pinjaman (tanggal pinjam, jatuh tempo, status)
- Formulir pengembalian untuk setiap buku dengan field:
  - NIS (required)
  - Nama Lengkap (required, auto-filled dengan nama user)
  - Kondisi Buku (required, dropdown)
  - Catatan Tambahan (optional)
- Konfirmasi SweetAlert2 sebelum submit
- Status "Permintaan sudah diajukan" jika sudah submit

### 4. Routes
**File**: `routes/web.php`

Routes baru:
- `GET /my-returns` → `user.returns` - Halaman pengembalian user
- `POST /api/returns/submit` → `api.returns.submit` - API untuk submit return request

### 5. Sidebar Update
**File**: `resources/views/components/sidebar.blade.php`

Menambahkan menu "Pengembalian Buku" di section "Peminjaman Saya" dengan icon undo-alt.

### 6. Model Update
**File**: `app/Models/Loan.php`

Menambahkan field baru ke `$fillable` array:
- return_nis
- return_borrower_name
- return_notes
- return_request_date
- return_condition

## Cara Menggunakan

### Untuk User:
1. Login ke sistem
2. Klik menu **"Pengembalian Buku"** di sidebar (section Peminjaman Saya)
3. Lihat daftar buku yang sedang dipinjam
4. Isi formulir pengembalian:
   - Masukkan NIS
   - Nama otomatis terisi (bisa diedit)
   - Pilih kondisi buku
   - Tambahkan catatan jika buku rusak atau ada masalah
5. Klik **"Ajukan Pengembalian"**
6. Konfirmasi data pada dialog SweetAlert2
7. Setelah berhasil, datang ke perpustakaan untuk mengembalikan buku fisik

### Status Buku:
- **X hari lagi** - Buku masih bisa dipinjam
- **Jatuh tempo hari ini** - Harus dikembalikan hari ini
- **Terlambat X hari** - Sudah melewati jatuh tempo

### Kondisi Buku:
- **Baik** - Tidak ada kerusakan
- **Rusak Ringan** - Lecet atau sobek kecil
- **Rusak Berat** - Halaman hilang atau rusak parah

## Teknologi yang Digunakan

- **Backend**: Laravel 12
- **Frontend**: Blade templating dengan CSS custom
- **Icons**: Font Awesome 6
- **Alerts**: SweetAlert2
- **AJAX**: Fetch API untuk async requests
- **Database**: MySQL (via migrations)

## API Endpoint

### Submit Return Request
**Endpoint**: `POST /api/returns/submit`

**Headers**:
```
Content-Type: application/json
X-CSRF-TOKEN: {csrf_token}
```

**Request Body**:
```json
{
  "loan_id": 1,
  "return_nis": "123456",
  "return_borrower_name": "John Doe",
  "return_condition": "baik",
  "return_notes": "Buku dalam kondisi baik"
}
```

**Success Response** (200):
```json
{
  "success": true,
  "message": "Permintaan pengembalian berhasil diajukan. Silakan datang ke perpustakaan untuk mengembalikan buku."
}
```

**Error Response** (500):
```json
{
  "success": false,
  "message": "Gagal mengajukan pengembalian: {error_message}"
}
```

## Validasi

### Frontend Validation:
- Semua field required (NIS, nama, kondisi) harus diisi
- SweetAlert2 confirmation sebelum submit

### Backend Validation:
- loan_id harus exists di tabel loans
- return_nis maksimal 50 karakter
- return_borrower_name maksimal 255 karakter
- return_notes maksimal 500 karakter
- return_condition harus salah satu dari: baik, rusak_ringan, rusak_berat
- Hanya user yang memiliki loan tersebut yang bisa submit
- Hanya loan dengan status 'borrowed' atau 'overdue' yang bisa diajukan

## Database Schema Changes

```sql
ALTER TABLE loans ADD COLUMN return_nis VARCHAR(255) NULL AFTER identification_method;
ALTER TABLE loans ADD COLUMN return_borrower_name VARCHAR(255) NULL AFTER return_nis;
ALTER TABLE loans ADD COLUMN return_notes TEXT NULL AFTER return_borrower_name;
ALTER TABLE loans ADD COLUMN return_request_date TIMESTAMP NULL AFTER return_notes;
ALTER TABLE loans ADD COLUMN return_condition ENUM('baik','rusak_ringan','rusak_berat') NULL AFTER return_request_date;
```

## Testing Checklist

- ✅ Migration berhasil dijalankan
- ✅ Route terdaftar dengan benar
- ✅ Sidebar menampilkan menu baru
- ✅ Halaman dapat diakses via URL `/my-returns`
- ✅ Form validation bekerja (frontend & backend)
- ✅ SweetAlert2 confirmation muncul
- ✅ API endpoint submit return bekerja
- ✅ Data tersimpan ke database
- ✅ Status "Permintaan sudah diajukan" muncul setelah submit

## Next Steps (Optional)

Untuk admin/pustakawan, bisa ditambahkan fitur:
1. Notifikasi saat ada return request baru
2. Dashboard untuk approve/reject return requests
3. Update status loan dari 'borrowed' ke 'returned' setelah buku diterima
4. Log history pengembalian dengan timestamp
5. Email notification ke user setelah buku dikembalikan

## Screenshots Location

Halaman dapat diakses di: `http://127.0.0.1:8000/my-returns`

---
**Created**: 15 Oktober 2025
**Laravel Version**: 12.x
**Status**: ✅ Complete and Ready for Testing
