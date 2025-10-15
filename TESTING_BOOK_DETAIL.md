# Quick Start - Testing Book Detail Page

## Prerequisites
- XAMPP dengan Apache dan MySQL aktif
- Database sudah ter-migrate
- Sudah ada data buku (dari BookSeeder)
- User sudah terdaftar

## Step-by-Step Testing

### 1. Pastikan Database Sudah Ready
```bash
cd c:\xampp\htdocs\PERPUSTAKAAN
php artisan migrate:fresh --seed
```

### 2. Generate Sample Data untuk Detail Buku
```bash
php artisan db:seed --class=BookDetailsSeeder
```

### 3. Start Development Server (jika belum)
```bash
php artisan serve
```
Server akan berjalan di: `http://127.0.0.1:8000`

### 4. Login
- Buka browser: `http://127.0.0.1:8000/login`
- Login dengan credentials yang ada

### 5. Akses Book Detail
Ada 2 cara:

**Cara 1: Dari Browse Page**
1. Pergi ke `/browse` atau klik menu "Jelajahi Buku"
2. Klik tombol "Detail" pada kartu buku mana saja
3. Akan redirect ke halaman detail

**Cara 2: Direct URL**
- Langsung akses: `http://127.0.0.1:8000/books/1`
- Ganti angka 1 dengan ID buku yang ada

## Testing Checklist

### Visual/UI Testing
- [ ] Cover buku tampil dengan baik
- [ ] Judul dan author terlihat jelas
- [ ] Rating stars tampil dengan benar
- [ ] Availability badge (tersedia/tidak tersedia) sesuai
- [ ] Tombol wishlist ada dan visible
- [ ] Tombol ajukan peminjaman berfungsi
- [ ] Tabs (About & Reviews) bisa di-switch
- [ ] Layout responsive di mobile

### Functional Testing

#### Rating System
- [ ] Klik bintang 1-5, rating tersimpan
- [ ] Rating rata-rata ter-update
- [ ] User hanya bisa memberi 1 rating per buku
- [ ] Jika sudah rating, bintang menunjukkan rating user
- [ ] Notification muncul saat berhasil rating

#### Wishlist
- [ ] Klik "Tambah ke Wishlist" → tombol berubah active
- [ ] Klik lagi → tombol kembali normal
- [ ] Notification muncul saat toggle
- [ ] Status wishlist persist setelah refresh

#### Comments
- [ ] Ketik komentar di form
- [ ] Klik "Kirim Komentar" → komentar muncul di list
- [ ] Avatar user tampil (huruf pertama nama)
- [ ] Timestamp relatif (e.g., "2 minutes ago")
- [ ] Komentar diurutkan terbaru di atas
- [ ] Notification muncul saat berhasil kirim

#### Tabs
- [ ] Klik tab "About" → tampil info buku
- [ ] Klik tab "Reviews" → tampil form & list komentar
- [ ] Active tab memiliki indicator bawah
- [ ] Smooth transition saat switch tab

#### Integration
- [ ] Tombol "Ajukan Peminjaman" redirect ke browse dengan modal
- [ ] Tombol "Kembali" kembali ke halaman sebelumnya
- [ ] Semua API call berhasil (check console)
- [ ] No JavaScript errors (F12 → Console)

## Common Issues & Solutions

### Issue 1: Cover gambar tidak muncul
**Solution**: 
```bash
php artisan storage:link
```

### Issue 2: 404 Not Found
**Solution**: Pastikan route sudah clear cache
```bash
php artisan route:clear
php artisan cache:clear
```

### Issue 3: Rating tidak tersimpan
**Solution**: Check CSRF token dan login status
```javascript
// Di console browser
console.log(document.querySelector('meta[name="csrf-token"]').content);
```

### Issue 4: No data found
**Solution**: Run seeder lagi
```bash
php artisan db:seed --class=BookDetailsSeeder
```

## Browser DevTools Testing

### Network Tab
- Check API calls: `/api/books/{id}/rate`, `/api/books/{id}/wishlist`, `/api/books/{id}/comments`
- Semua response harus status 200
- Response format JSON valid

### Console Tab
- No errors (merah)
- Warnings (kuning) boleh diabaikan jika minor

### Application Tab
- Check localStorage (jika ada)
- Check cookies (session aktif)

## Performance Testing

### Metrics to Check
- Page load time < 3 detik
- Smooth scrolling
- No lag saat switch tabs
- Instant feedback saat klik rating
- Quick notification display

## Mobile Testing

### Responsive Breakpoints
1. Desktop: 1920x1080
2. Laptop: 1366x768
3. Tablet: 768x1024
4. Mobile: 375x667

Test di semua ukuran dengan Chrome DevTools (F12 → Toggle device toolbar)

## Sample Test Data

### Sample Books (if using BookSeeder)
- Book ID 1: "Pemrograman Web dengan Laravel"
- Book ID 2: "Sejarah Indonesia"
- Book ID 3: etc.

### Sample Users
- Admin: admin@perpus.com / password
- Pustakawan: pustakawan@perpus.com / password
- Member: member@perpus.com / password

## Screenshot Locations (Optional)
Untuk dokumentasi, ambil screenshot:
1. Book detail page - full view
2. Rating section - hover state
3. Comments section - with comments
4. Wishlist button - active state
5. Mobile view - responsive layout

## Next Steps After Testing
1. Report bugs di issue tracker
2. Request features baru
3. Optimize performance jika perlu
4. Add more sample data
5. Test dengan data real

## Support
Jika menemukan bug atau butuh bantuan:
1. Check error log: `storage/logs/laravel.log`
2. Check browser console
3. Verify database structure: `php artisan migrate:status`
4. Clear all caches: `php artisan optimize:clear`

Happy Testing! 🚀
