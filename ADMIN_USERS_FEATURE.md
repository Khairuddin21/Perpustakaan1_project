# Fitur Kelola Anggota - Admin

## Deskripsi
Fitur ini memungkinkan administrator untuk mengelola seluruh data pengguna sistem perpustakaan, termasuk kemampuan untuk mengubah role anggota.

## Fitur yang Diimplementasikan

### 1. **Tampilan Kelola Anggota**
   - Tabel daftar semua pengguna (Admin, Pustakawan, Anggota)
   - Informasi lengkap: Nama, Email, Role, Telepon, Status (Aktif/Nonaktif)
   - Badge visual untuk role dan status
   - Pencarian real-time
   - Indikator khusus untuk akun sendiri

### 2. **Tambah Anggota Baru**
   - Form modal yang responsive dan modern
   - Field yang tersedia:
     * Nama Lengkap (required)
     * Email (required, unique)
     * Password (required, minimal 8 karakter)
     * Role (required): Admin, Pustakawan, atau Anggota
     * Nomor Telepon (optional)
     * Alamat (optional)
   - Validasi form di backend dan frontend
   - Status default: Aktif

### 3. **Edit Data Anggota**
   - Mengubah semua informasi anggota
   - Password optional saat edit (kosongkan jika tidak ingin mengubah)
   - Mengubah role anggota (Admin dapat mengubah role siapa saja)
   - Validasi email unique (kecuali email sendiri)

### 4. **Toggle Status Aktif/Nonaktif**
   - Mengaktifkan atau menonaktifkan akun pengguna
   - Perlindungan: Admin tidak dapat menonaktifkan akun sendiri
   - Konfirmasi sebelum mengubah status

### 5. **Hapus Anggota**
   - Menghapus data pengguna dari sistem
   - Perlindungan: Admin tidak dapat menghapus akun sendiri
   - Konfirmasi double dengan peringatan data tidak dapat dikembalikan
   - Soft delete atau hard delete (tergantung kebutuhan)

### 6. **Keamanan Sidebar Admin**
   - Sidebar admin diamankan dengan middleware `role:admin`
   - Hanya admin yang dapat mengakses menu Kelola Anggota
   - Route protection di level backend
   - Redirect otomatis jika non-admin mencoba akses

## File yang Dibuat/Dimodifikasi

### 1. **Controller Baru**
   - `app/Http/Controllers/UserController.php`
     * `index()` - Tampilkan daftar pengguna
     * `store()` - Tambah pengguna baru
     * `edit()` - Ambil data pengguna untuk edit
     * `update()` - Update data pengguna
     * `destroy()` - Hapus pengguna
     * `toggleStatus()` - Toggle status aktif/nonaktif

### 2. **Routes**
   - `routes/web.php`
     * Ditambahkan route group untuk Users Management
     * Semua route dilindungi middleware `role:admin`
     * Routes:
       - GET `/admin/users` - Halaman kelola anggota
       - POST `/admin/users` - Tambah anggota
       - GET `/admin/users/{id}/edit` - Get data anggota
       - POST `/admin/users/{id}` - Update anggota
       - DELETE `/admin/users/{id}` - Hapus anggota
       - POST `/admin/users/{id}/toggle-status` - Toggle status

### 3. **View Baru**
   - `resources/views/dashboard/admin-users.blade.php`
     * Design modern dan responsive
     * Tabel data dengan styling menarik
     * Modal form untuk tambah/edit
     * Integrasi SweetAlert2 untuk notifikasi
     * Search functionality
     * Action buttons (Edit, Toggle, Hapus)

### 4. **Sidebar Admin**
   - `resources/views/components/admin-sidebar.blade.php`
     * Ditambahkan link ke `route('admin.users.index')`
     * Active state handling untuk menu Kelola Anggota
     * Route sudah menggunakan named route yang benar

## Keamanan yang Diterapkan

1. **Middleware Protection**
   - Semua route Kelola Anggota dilindungi `middleware(['role:admin'])`
   - Hanya user dengan role 'admin' yang bisa akses

2. **Self-Protection**
   - Admin tidak dapat menghapus akun sendiri
   - Admin tidak dapat menonaktifkan akun sendiri
   - Validasi di backend mencegah aksi tersebut

3. **CSRF Protection**
   - Semua form menggunakan CSRF token
   - Validasi token di setiap request POST/DELETE

4. **Input Validation**
   - Email harus unique
   - Password minimal 8 karakter
   - Role harus valid (admin, pustakawan, anggota)
   - Sanitasi input untuk mencegah XSS

5. **Authorization Check**
   - Middleware CheckRole sudah diterapkan
   - Route protection di web.php
   - Backend validation untuk semua aksi

## Cara Penggunaan

### Menambah Anggota Baru:
1. Login sebagai admin
2. Klik menu "Kelola Anggota" di sidebar
3. Klik tombol "Tambah Anggota"
4. Isi form dengan data lengkap
5. Pilih role yang sesuai
6. Klik "Simpan"

### Mengubah Role Anggota:
1. Di halaman Kelola Anggota
2. Klik tombol "Edit" pada anggota yang ingin diubah
3. Ubah role di dropdown
4. Klik "Simpan"

### Toggle Status:
1. Klik tombol "Toggle" pada anggota
2. Konfirmasi perubahan status
3. Status akan berubah antara Aktif/Nonaktif

### Menghapus Anggota:
1. Klik tombol "Hapus" pada anggota
2. Konfirmasi penghapusan (data tidak dapat dikembalikan)
3. Data akan terhapus dari sistem

## Fitur UI/UX

1. **Design Modern**
   - Gradient backgrounds
   - Shadow effects
   - Smooth transitions
   - Responsive layout

2. **User Feedback**
   - Loading states
   - Success/Error notifications (SweetAlert2)
   - Confirmation dialogs
   - Form validation feedback

3. **Badge System**
   - Role badges dengan warna berbeda:
     * Admin: Merah (crown icon)
     * Pustakawan: Biru (user-tie icon)
     * Anggota: Hijau (user icon)
   - Status badges:
     * Aktif: Hijau
     * Nonaktif: Merah

4. **Search & Filter**
   - Real-time search
   - Filter berdasarkan role (optional untuk future)
   - Responsive table

## Testing Checklist

- [ ] Admin dapat melihat halaman Kelola Anggota
- [ ] Pustakawan tidak dapat mengakses halaman Kelola Anggota
- [ ] Anggota tidak dapat mengakses halaman Kelola Anggota
- [ ] Admin dapat menambah anggota baru
- [ ] Admin dapat mengubah role anggota
- [ ] Admin dapat mengedit data anggota
- [ ] Admin dapat toggle status anggota
- [ ] Admin dapat menghapus anggota
- [ ] Admin tidak dapat menghapus akun sendiri
- [ ] Admin tidak dapat menonaktifkan akun sendiri
- [ ] Search berfungsi dengan baik
- [ ] Form validation berfungsi
- [ ] CSRF protection aktif
- [ ] Email validation unique
- [ ] Password hashing berfungsi

## Role System

Sistem role yang tersedia:
1. **Admin** - Full access ke semua fitur termasuk kelola anggota
2. **Pustakawan** - Akses ke fitur peminjaman dan pengembalian
3. **Anggota** - Akses terbatas hanya untuk pinjam buku

Admin dapat mengubah role siapa saja melalui fitur Kelola Anggota.

## Dependencies

- Laravel Framework
- SweetAlert2 (untuk notifikasi)
- Font Awesome (untuk icons)
- Inter Font (untuk typography)

## Notes

- Pastikan middleware `CheckRole` sudah registered di `app/Http/Kernel.php`
- Model User sudah memiliki method `isAdmin()`, `isPustakawan()`, `isAnggota()`
- Field `is_active` di table users untuk status aktif/nonaktif
- Password di-hash menggunakan `Hash::make()`
- Gunakan soft delete jika ingin data dapat dipulihkan

## Future Enhancements

1. Filter berdasarkan role di UI
2. Export data anggota (Excel/PDF)
3. Bulk actions (activate/deactivate multiple users)
4. Advanced search (by role, status, registration date)
5. User activity log
6. Email notification saat account dibuat/diubah
7. Password reset functionality dari admin
8. Soft delete dengan restore capability

## Troubleshooting

**Problem**: Tidak bisa akses halaman Kelola Anggota
**Solution**: Pastikan user sudah login sebagai admin

**Problem**: Error 403 Forbidden
**Solution**: Check middleware `role:admin` di routes dan pastikan user memiliki role admin

**Problem**: Error saat hapus pengguna
**Solution**: Check foreign key constraints di database (loans, dll)

**Problem**: Password tidak berubah saat edit
**Solution**: Password memang optional saat edit, kosongkan jika tidak ingin mengubah

## Kontak

Jika ada pertanyaan atau issue, silakan hubungi tim development.

---

**Created**: 2025-01-16
**Last Updated**: 2025-01-16
**Version**: 1.0.0
