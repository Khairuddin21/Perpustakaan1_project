# 📖 Panduan Cepat: Kelola Buku Admin

## 🎯 Cara Mengakses

1. Login sebagai **Admin**
2. Klik menu **"Kelola Buku"** di sidebar
3. Atau akses langsung: `http://localhost/admin/books`

## ⚡ Fitur Cepat

### ➕ Tambah Buku Baru
```
1. Klik tombol "Tambah Buku Baru" (pojok kanan atas)
2. Isi semua field yang required (*)
3. Upload cover buku (opsional)
4. Klik "Simpan Buku"
✅ Buku berhasil ditambahkan!
```

### ✏️ Edit Buku
```
1. Cari buku yang ingin diedit
2. Klik tombol "Edit" (biru)
3. Ubah data yang diperlukan
4. Klik "Simpan Buku"
✅ Buku berhasil diupdate!
```

### 🗑️ Hapus Buku
```
1. Cari buku yang ingin dihapus
2. Klik tombol "Hapus" (merah)
3. Konfirmasi dialog
✅ Buku berhasil dihapus!
```

### 🔍 Cari & Filter
```
- Ketik keyword di search bar
- Pilih kategori
- Pilih status ketersediaan
- Pilih urutan tampilan
- Klik "Filter"
```

## 📊 Info yang Ditampilkan

Setiap card buku menampilkan:
- ✅ Cover buku
- 🏷️ Kategori
- 📖 Judul
- ✍️ Penulis
- 🏢 Penerbit
- 📅 Tahun Terbit
- 🔢 ISBN
- 📦 Stok (Total / Tersedia)
- 🎨 Status Badge (Tersedia/Habis)

## ⚠️ Catatan Penting

1. **ISBN harus unik** - Tidak boleh duplikat
2. **Buku yang sedang dipinjam tidak bisa dihapus**
3. **Cover maksimal 2MB** (PNG, JPG, GIF)
4. **Stok otomatis dihitung** - Available akan update otomatis

## 🎨 Tips Desain

- Tampilan grid modern dengan hover effect
- Responsive di semua device
- Modal form yang user-friendly
- Live preview untuk upload gambar

## 🚀 Shortcut Keyboard

- **ESC** - Tutup modal
- **Enter** - Submit form (di dalam modal)

## 🔧 Troubleshooting

**Modal tidak muncul?**
- Refresh halaman
- Clear cache browser

**Gambar tidak terupload?**
- Pastikan ukuran < 2MB
- Format harus jpeg/png/jpg/gif
- Folder `public/Gambar` harus writable

**Tidak bisa hapus buku?**
- Cek apakah buku sedang dipinjam
- Hanya admin yang bisa hapus

---

Selamat mengelola koleksi buku! 📚✨
