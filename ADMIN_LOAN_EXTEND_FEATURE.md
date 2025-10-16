# Fitur Extend Durasi Peminjaman - Admin

## Deskripsi
Fitur ini memungkinkan admin untuk menentukan dan mengubah durasi peminjaman buku saat menyetujui request peminjaman dari anggota. Admin dapat memperpanjang atau menyesuaikan waktu peminjaman sesuai kebutuhan (1-30 hari).

## Update yang Dilakukan

### 1. **Flow Persetujuan dengan Durasi Custom**
Ketika admin menyetujui peminjaman, akan ada 2 langkah:

**Langkah 1: Pilih Durasi Peminjaman**
- Modal dialog dengan range slider
- Range: 1-30 hari
- Default: 7 hari
- Visual display yang menunjukkan jumlah hari secara real-time
- Slider yang smooth dan responsive

**Langkah 2: Konfirmasi Final**
- Menampilkan informasi peminjam dan buku
- Menampilkan durasi yang dipilih dengan jelas
- Menampilkan tanggal jatuh tempo yang dihitung otomatis
- Konfirmasi terakhir sebelum approve

### 2. **Fitur yang Diimplementasikan**

#### A. Range Slider untuk Durasi
```javascript
input: 'range',
inputAttributes: {
    min: '1',
    max: '30',
    step: '1'
},
inputValue: 7  // Default 7 hari
```

#### B. Dynamic Display Nilai
- Menampilkan nilai durasi secara real-time saat slider bergerak
- Design menarik dengan gradient background
- Font besar dan mudah dibaca

#### C. Perhitungan Tanggal Jatuh Tempo
```javascript
function calculateDueDate(days) {
    const date = new Date();
    date.setDate(date.getDate() + parseInt(days));
    return date.toLocaleDateString('id-ID', {
        day: '2-digit',
        month: 'long',
        year: 'numeric'
    });
}
```

#### D. API Integration
- Mengirim `loan_duration` ke backend
- Backend sudah support parameter ini di `LoanController@approveLoan`
- Validasi: min 1 hari, max 30 hari

### 3. **UI/UX Improvements**

#### Visual Design
- **Step 1 (Pilih Durasi)**:
  - Range slider dengan gradient color (indigo to purple)
  - Large number display untuk nilai hari
  - Info box dengan icon
  - Smooth animations

- **Step 2 (Konfirmasi)**:
  - Green gradient box untuk highlight durasi
  - Large font (2.5rem) untuk angka hari
  - Tanggal jatuh tempo di bawah durasi
  - Informasi lengkap peminjam dan buku

#### Interactive Elements
- Range slider dengan custom styling:
  - Track dengan gradient background
  - Thumb (bulatan) dengan border
  - Hover effect dengan scale transform
  - Smooth transitions

- Real-time value update:
  - Display berubah seketika saat slider digerakkan
  - No lag atau delay

### 4. **Backend Support**

Controller `LoanController.php` sudah support:
```php
public function approveLoan(Request $request, $id)
{
    $request->validate([
        'loan_duration' => 'nullable|integer|min:1|max:30'
    ]);
    
    $duration = $request->loan_duration ?? 7; // Default 7 days
    
    // Calculate due date based on duration
    $loanDate = Carbon::now();
    $dueDate = $loanDate->copy()->addDays($duration);
    
    $loan->update([
        'status' => 'borrowed',
        'loan_date' => $loanDate,
        'due_date' => $dueDate,
        // ...
    ]);
}
```

### 5. **Styling Custom untuk Range Input**

CSS yang ditambahkan:
```css
.swal2-range {
    width: 100% !important;
    height: 8px !important;
    border-radius: 5px !important;
    background: linear-gradient(to right, #6366f1, #8b5cf6) !important;
}

.swal2-range::-webkit-slider-thumb {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: white;
    border: 3px solid #6366f1;
    box-shadow: 0 2px 8px rgba(99, 102, 241, 0.4);
}

.swal2-range::-webkit-slider-thumb:hover {
    transform: scale(1.2);
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.6);
}
```

## Cara Penggunaan

### Untuk Admin:

1. **Akses Halaman Loan Requests**
   - Login sebagai admin
   - Klik menu "Akses Peminjaman" di sidebar
   - Atau akses: `http://127.0.0.1:8000/loan-requests`

2. **Lihat Request Pending**
   - Tab "Pending" menampilkan semua request yang menunggu persetujuan
   - Informasi lengkap peminjam, buku, dan detail lainnya

3. **Approve dengan Custom Durasi**
   - Klik tombol "ACC" pada request yang ingin disetujui
   
   **Step 1: Pilih Durasi**
   - Modal akan muncul dengan range slider
   - Geser slider untuk memilih durasi (1-30 hari)
   - Lihat preview angka hari yang berubah real-time
   - Klik "Lanjutkan"
   
   **Step 2: Konfirmasi**
   - Review informasi peminjam dan buku
   - Lihat durasi yang dipilih (tampilan besar dan jelas)
   - Lihat tanggal jatuh tempo otomatis
   - Klik "Ya, Setujui Peminjaman"
   
   **Step 3: Success**
   - Notifikasi sukses akan muncul
   - Menampilkan durasi dan tanggal jatuh tempo
   - Data akan ter-refresh otomatis

## Use Cases

### Skenario 1: Peminjaman Standar
- Anggota request buku untuk tugas sekolah
- Admin approve dengan durasi default 7 hari
- Cukup dengan menggeser slider atau langsung klik lanjutkan

### Skenario 2: Peminjaman Diperpanjang
- Anggota request buku untuk proyek jangka panjang
- Admin dapat extend durasi sampai 30 hari
- Geser slider ke kanan untuk menambah hari
- Sistem otomatis menghitung jatuh tempo

### Skenario 3: Peminjaman Singkat
- Anggota hanya butuh buku untuk referensi cepat
- Admin dapat kurangi durasi jadi 1-3 hari
- Geser slider ke kiri untuk mengurangi hari

### Skenario 4: Perpustakaan Libur
- Ada libur panjang atau cuti
- Admin bisa extend durasi lebih lama (misal 14-21 hari)
- Fleksibel sesuai kebutuhan

## Keunggulan Fitur

1. **Fleksibilitas**
   - Admin bisa menyesuaikan durasi per request
   - Tidak terpaku pada durasi tetap 7 hari
   - Range 1-30 hari sangat fleksibel

2. **User-Friendly**
   - Range slider mudah digunakan
   - Visual feedback yang jelas
   - Perhitungan otomatis tanggal jatuh tempo

3. **Informasi Lengkap**
   - Semua detail peminjaman ditampilkan
   - Tanggal jatuh tempo dihitung otomatis
   - Konfirmasi bertahap mencegah kesalahan

4. **Modern Design**
   - Gradient colors yang menarik
   - Smooth animations
   - Responsive dan mobile-friendly

5. **Security**
   - Validasi di frontend dan backend
   - CSRF protection
   - Admin-only access

## Technical Details

### Frontend
- **Library**: SweetAlert2 untuk modal
- **JavaScript**: Vanilla JS, async/await
- **CSS**: Custom styling untuk range input
- **Animation**: Smooth transitions dan transforms

### Backend
- **Controller**: `LoanController@approveLoan`
- **Validation**: min:1, max:30 days
- **Default**: 7 days jika tidak diisi
- **Database**: Update `due_date` berdasarkan durasi

### API Endpoint
```
POST /api/admin/loans/{id}/approve
Content-Type: application/json

Body:
{
    "loan_duration": 14  // 1-30 days
}

Response:
{
    "success": true,
    "message": "Permintaan peminjaman berhasil disetujui.",
    "loan": { ... }
}
```

## Browser Compatibility

Range input didukung oleh:
- ✅ Chrome/Edge (Chromium)
- ✅ Firefox
- ✅ Safari
- ✅ Opera
- ✅ Mobile browsers (iOS Safari, Chrome Mobile)

Custom styling:
- ✅ Webkit browsers (Chrome, Safari, Edge)
- ✅ Firefox (dengan vendor prefix)

## Testing Checklist

- [ ] Range slider berfungsi dengan smooth
- [ ] Nilai hari update secara real-time
- [ ] Dapat memilih 1 hari (minimum)
- [ ] Dapat memilih 30 hari (maximum)
- [ ] Default value 7 hari
- [ ] Tanggal jatuh tempo dihitung dengan benar
- [ ] API mengirim loan_duration dengan benar
- [ ] Backend memproses durasi dengan benar
- [ ] Success notification menampilkan durasi yang benar
- [ ] Data ter-refresh setelah approve
- [ ] Cancel berfungsi di kedua step
- [ ] Kembali dari step 2 ke step 1
- [ ] Responsive di mobile
- [ ] Range slider styling bagus di semua browser

## Future Enhancements

1. **Preset Durations**
   - Quick buttons: 3 hari, 7 hari, 14 hari, 30 hari
   - One-click untuk durasi umum

2. **Smart Suggestions**
   - Rekomendasi durasi berdasarkan jenis buku
   - Buku tebal = durasi lebih lama

3. **Holiday Adjustment**
   - Deteksi libur/weekend
   - Auto-extend jatuh tempo jika jatuh di hari libur

4. **Member History**
   - Tampilkan riwayat durasi peminjaman member
   - Saran durasi berdasarkan history

5. **Bulk Approval**
   - Approve multiple requests sekaligus
   - Set durasi uniform atau individual

6. **Email Notification**
   - Kirim email ke member dengan detail durasi
   - Reminder sebelum jatuh tempo

7. **Analytics**
   - Laporan rata-rata durasi peminjaman
   - Tren penggunaan durasi extend

## Notes

- Durasi peminjaman disimpan di database sebagai tanggal jatuh tempo (`due_date`)
- Sistem menghitung dari `loan_date` + durasi
- Tidak ada field khusus untuk menyimpan durasi (karena bisa dihitung dari selisih tanggal)
- Validasi backend mencegah durasi di luar range 1-30 hari

## Troubleshooting

**Problem**: Range slider tidak bergerak
**Solution**: Check browser compatibility, pastikan JavaScript enabled

**Problem**: Tanggal jatuh tempo salah
**Solution**: Check timezone server dan browser, pastikan konsisten

**Problem**: Error saat approve dengan custom duration
**Solution**: Check validasi backend, pastikan loan_duration terkirim sebagai integer

**Problem**: Styling range input tidak muncul
**Solution**: Check browser support untuk custom range styling, fallback ke default jika perlu

## Contact

Jika ada pertanyaan atau issue, silakan hubungi tim development.

---

**Created**: 2025-01-16
**Feature**: Admin Extend Loan Duration
**Version**: 1.0.0
**Status**: ✅ Active
