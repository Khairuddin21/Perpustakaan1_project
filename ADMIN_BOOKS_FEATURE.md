# Fitur Kelola Buku Admin - Documentation

## 📚 Overview
Halaman Kelola Buku adalah fitur manajemen lengkap untuk admin dalam mengelola koleksi buku perpustakaan dengan tampilan galeri yang modern dan interaktif.

## ✨ Fitur Utama

### 1. **Tampilan Galeri Modern**
   - Layout grid responsif dengan card design
   - Cover buku dengan efek hover zoom
   - Badge status ketersediaan (Tersedia/Habis)
   - Informasi lengkap: Kategori, Penulis, Penerbit, Tahun Terbit, ISBN, Stok

### 2. **Statistik Dashboard**
   - Total Buku
   - Buku Tersedia
   - Total Stok
   - Jumlah Kategori

### 3. **Filter & Pencarian**
   - Search bar (Judul, Penulis, ISBN, Penerbit)
   - Filter berdasarkan Kategori
   - Filter Ketersediaan (Tersedia/Tidak Tersedia)
   - Sorting (Terbaru, Judul, Penulis, Tahun Terbit)

### 4. **CRUD Operations**

#### **Tambah Buku**
   - Modal form dengan desain modern
   - Fields:
     * Judul Buku (required)
     * Penulis (required)
     * ISBN (required, unique)
     * Kategori (required)
     * Stok (required, min: 0)
     * Penerbit (required)
     * Tahun Terbit (required, 1900 - sekarang)
     * Deskripsi (optional)
     * Cover Buku (optional, max 2MB, format: jpeg, png, jpg, gif)
   - Upload gambar dengan preview
   - Validasi form lengkap

#### **Edit Buku**
   - Load data buku existing ke modal
   - Semua field bisa diupdate
   - Ganti cover image dengan preview
   - ISBN unique kecuali untuk buku yang sedang diedit
   - Automatic calculation untuk available stock

#### **Hapus Buku**
   - SweetAlert confirmation dialog
   - Validasi: Tidak bisa hapus buku yang sedang dipinjam
   - Auto delete cover image dari server

### 5. **Image Upload**
   - Drag & drop interface
   - Live preview sebelum upload
   - Auto resize dan optimize
   - Fallback ke default-book.jpg jika tidak ada cover

### 6. **Pagination**
   - 12 buku per halaman
   - Navigate between pages
   - Maintain filter state

## 🎨 Desain UI/UX

### Color Scheme
- Primary Gradient: `#667eea` → `#764ba2` (Purple)
- Success: `#48bb78` (Green)
- Info: `#4299e1` (Blue)
- Warning: `#ed8936` (Orange)
- Danger: `#f56565` (Red)

### Typography
- Font Family: Inter
- Headers: 700-800 weight
- Body: 400-600 weight

### Interactive Elements
- Hover effects dengan transform translateY
- Shadow transitions
- Modal animations
- Image zoom effects

## 🔒 Security & Validation

### Backend Validation
```php
- title: required|string|max:255
- author: required|string|max:255
- isbn: required|string|max:20|unique:books
- category_id: required|exists:categories,id
- publisher: required|string|max:255
- published_year: required|integer|min:1900|max:(current_year + 1)
- stock: required|integer|min:0
- description: nullable|string
- cover_image: nullable|image|mimes:jpeg,png,jpg,gif|max:2048
```

### Access Control
- Middleware: `role:admin`
- CSRF Protection
- XSS Protection

## 🛣️ Routes

```php
GET    /admin/books              -> index    (List semua buku)
POST   /admin/books              -> store    (Tambah buku baru)
GET    /admin/books/{id}/edit    -> edit     (Get data untuk edit)
POST   /admin/books/{id}         -> update   (Update buku)
DELETE /admin/books/{id}         -> destroy  (Hapus buku)
```

## 📱 Responsive Design

### Desktop (> 1024px)
- Grid 4-5 kolom
- Full filter layout

### Tablet (768px - 1024px)
- Grid 2-3 kolom
- Filter 2 kolom

### Mobile (< 768px)
- Grid 1 kolom
- Stacked filter
- Optimized touch targets

## 🚀 Cara Menggunakan

### Menambah Buku Baru
1. Klik tombol "Tambah Buku Baru"
2. Isi form dengan data lengkap
3. Upload cover (optional)
4. Klik "Simpan Buku"

### Mengedit Buku
1. Klik tombol "Edit" pada card buku
2. Modal akan muncul dengan data existing
3. Update field yang diperlukan
4. Ganti cover jika perlu
5. Klik "Simpan Buku"

### Menghapus Buku
1. Klik tombol "Hapus" pada card buku
2. Konfirmasi di dialog SweetAlert
3. Buku akan dihapus beserta cover image

### Mencari & Filter Buku
1. Gunakan search bar untuk cari by keyword
2. Pilih kategori dari dropdown
3. Filter ketersediaan
4. Pilih sorting
5. Klik "Filter"

## 🔧 Technical Stack

### Backend
- Laravel 12.x
- PHP 8.x
- MySQL Database

### Frontend
- Blade Templates
- Vanilla JavaScript (ES6+)
- CSS3 (Grid, Flexbox, Animations)
- Font Awesome Icons
- SweetAlert2

### Dependencies
- Inter Font (Google Fonts)
- SweetAlert2 CDN
- Font Awesome 6.4.0 CDN

## 📊 Database Schema

### Books Table
```
- id: bigint (primary key)
- title: varchar(255)
- author: varchar(255)
- isbn: varchar(20) unique
- category_id: bigint (foreign key)
- publisher: varchar(255)
- published_year: int
- stock: int
- available: int
- description: text nullable
- cover_image: varchar(255) nullable
- created_at: timestamp
- updated_at: timestamp
```

## 🎯 Future Enhancements

1. Bulk import buku (Excel/CSV)
2. Advanced search with multiple filters
3. Book analytics (most borrowed, ratings, etc)
4. Barcode scanner integration
5. QR code generation untuk setiap buku
6. Export data buku ke Excel/PDF
7. Image optimization & compression
8. Multi-image upload (gallery)
9. Book preview (sample pages)
10. Integration dengan API buku (Google Books, etc)

## 📝 Notes

- Pastikan folder `public/Gambar` writable
- Default image `default-book.jpg` harus tersedia
- Tested pada browser modern (Chrome, Firefox, Edge)
- Mobile-friendly & touch-optimized

---

**Created:** October 2025  
**Version:** 1.0.0  
**Author:** Admin System
