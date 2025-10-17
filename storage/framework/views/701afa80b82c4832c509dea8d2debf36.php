<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koleksi Pribadi - SisPerpus</title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #667eea;
            --primary-dark: #5568d3;
            --secondary: #764ba2;
            --accent: #f093fb;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
            --dark: #1e293b;
            --light: #f8fafc;
            --border: #e2e8f0;
            --text-dark: #1e293b;
            --text-light: #64748b;
            --sidebar-width: 280px;
            --header-height: 70px;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 50%, #f1f5f9 100%);
            min-height: 100vh;
            color: var(--text-dark);
        }

        .dashboard-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            transition: margin-left 0.3s ease;
        }

        .main-content.expanded {
            margin-left: 0;
        }

        /* Header */
        .header {
            background: white;
            height: var(--header-height);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .toggle-sidebar {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--text-dark);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .toggle-sidebar:hover {
            background: var(--light);
            color: var(--primary);
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .page-title i {
            color: var(--primary);
        }

        /* Content Container */
        .content-container {
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Page Header */
        .page-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            color: white;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }

        .page-header h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .page-header p {
            opacity: 0.9;
            font-size: 1rem;
        }

        /* Add Book Button */
        .add-book-btn {
            background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
            margin-bottom: 2rem;
        }

        .add-book-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }

        /* Books Grid */
        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .book-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            position: relative;
        }

        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        }

        .book-cover {
            width: 100%;
            height: 280px;
            object-fit: cover;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
        }

        .book-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .book-info {
            padding: 1.5rem;
        }

        .book-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .book-author {
            color: var(--text-light);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .book-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .meta-tag {
            background: var(--light);
            padding: 0.25rem 0.75rem;
            border-radius: 6px;
            font-size: 0.75rem;
            color: var(--text-light);
        }

        .book-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border);
        }

        .btn-action {
            flex: 1;
            padding: 0.75rem;
            border: none;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-view {
            background: linear-gradient(135deg, var(--info) 0%, #2563eb 100%);
            color: white;
        }

        .btn-view:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        .btn-delete {
            background: linear-gradient(135deg, var(--danger) 0%, #dc2626 100%);
            color: white;
        }

        .btn-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .empty-state i {
            font-size: 5rem;
            color: var(--border);
            margin-bottom: 1rem;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: var(--text-light);
            margin-bottom: 2rem;
        }

        /* Modal Styles */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            z-index: 2000;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 16px;
            width: 100%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            padding: 2rem;
            position: relative;
            animation: modalSlideIn 0.3s ease;
        }

        @keyframes modalSlideIn {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--text-light);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .close-modal:hover {
            background: var(--light);
            color: var(--danger);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .form-group label .required {
            color: var(--danger);
        }

        .form-control {
            width: 100%;
            padding: 0.875rem;
            border: 2px solid var(--border);
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }

        .file-input-label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 1rem;
            border: 2px dashed var(--border);
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: var(--light);
        }

        .file-input-label:hover {
            border-color: var(--primary);
            background: rgba(102, 126, 234, 0.05);
        }

        .file-input-label i {
            font-size: 1.5rem;
            color: var(--primary);
        }

        input[type="file"] {
            position: absolute;
            left: -9999px;
        }

        .file-name {
            margin-top: 0.5rem;
            font-size: 0.875rem;
            color: var(--text-light);
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border);
        }

        .btn-submit {
            flex: 1;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border: none;
            padding: 1rem;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .btn-cancel {
            flex: 1;
            background: var(--light);
            color: var(--text-dark);
            border: none;
            padding: 1rem;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-cancel:hover {
            background: var(--border);
        }

        /* Alert Messages */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #10b981;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #ef4444;
        }

        .alert i {
            font-size: 1.5rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
            }

            .content-container {
                padding: 1rem;
            }

            .books-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .page-header h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-wrapper">
        <?php echo $__env->make('components.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        
        <div class="main-content" id="mainContent">
            <!-- Header -->
            <div class="header">
                <div class="header-left">
                    <button class="toggle-sidebar" id="toggleSidebar">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="page-title">
                        <i class="fas fa-book-medical"></i>
                        Koleksi Pribadi
                    </h1>
                </div>
            </div>

            <!-- Content -->
            <div class="content-container">
                <!-- Page Header -->
                <div class="page-header">
                    <h1>📚 Koleksi Pribadi Saya</h1>
                    <p>Kelola dan bagikan buku atau karya pribadi Anda dalam format PDF</p>
                </div>

                <!-- Add Book Button -->
                <button class="add-book-btn" onclick="openAddBookModal()">
                    <i class="fas fa-plus"></i>
                    Tambah Buku Baru
                </button>

                <!-- Books Display -->
                <?php if($personalBooks->count() > 0): ?>
                    <div class="books-grid">
                        <?php $__currentLoopData = $personalBooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="book-card">
                                <div class="book-cover">
                                    <?php if($book->cover_image): ?>
                                        <img src="<?php echo e(asset('storage/' . $book->cover_image)); ?>" alt="<?php echo e($book->title); ?>">
                                    <?php else: ?>
                                        <i class="fas fa-book"></i>
                                    <?php endif; ?>
                                </div>
                                <div class="book-info">
                                    <h3 class="book-title"><?php echo e($book->title); ?></h3>
                                    <p class="book-author">oleh <?php echo e($book->author); ?></p>
                                    
                                    <?php if($book->description): ?>
                                        <p style="color: var(--text-light); font-size: 0.875rem; margin-top: 0.5rem; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                            <?php echo e($book->description); ?>

                                        </p>
                                    <?php endif; ?>
                                    
                                    <div class="book-meta">
                                        <?php if($book->published_year): ?>
                                            <span class="meta-tag"><i class="fas fa-calendar"></i> <?php echo e($book->published_year); ?></span>
                                        <?php endif; ?>
                                        <?php if($book->publisher): ?>
                                            <span class="meta-tag"><i class="fas fa-building"></i> <?php echo e($book->publisher); ?></span>
                                        <?php endif; ?>
                                        <?php if($book->isbn): ?>
                                            <span class="meta-tag"><i class="fas fa-barcode"></i> <?php echo e($book->isbn); ?></span>
                                        <?php endif; ?>
                                    </div>

                                    <div class="book-actions">
                                        <button class="btn-action btn-view" onclick="viewPDF(<?php echo e($book->id); ?>)">
                                            <i class="fas fa-eye"></i>
                                            Lihat PDF
                                        </button>
                                        <button class="btn-action btn-delete" onclick="deleteBook(<?php echo e($book->id); ?>, '<?php echo e($book->title); ?>')">
                                            <i class="fas fa-trash"></i>
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-book-open"></i>
                        <h3>Belum Ada Buku Pribadi</h3>
                        <p>Mulai tambahkan buku atau karya pribadi Anda untuk dibagikan</p>
                        <button class="add-book-btn" onclick="openAddBookModal()">
                            <i class="fas fa-plus"></i>
                            Tambah Buku Pertama
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Add Book Modal -->
    <div class="modal-overlay" id="addBookModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Tambah Buku Baru</h2>
                <button class="close-modal" onclick="closeAddBookModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div id="alertContainer"></div>

            <form id="addBookForm" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                
                <div class="form-group">
                    <label>Judul Buku <span class="required">*</span></label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Penulis <span class="required">*</span></label>
                    <input type="text" name="author" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="description" class="form-control" placeholder="Berikan deskripsi singkat tentang buku ini..."></textarea>
                </div>

                <div class="form-group">
                    <label>File PDF <span class="required">*</span></label>
                    <div class="file-input-wrapper">
                        <label class="file-input-label" for="pdfFile">
                            <i class="fas fa-file-pdf"></i>
                            <span>Pilih File PDF (Maks 10MB)</span>
                        </label>
                        <input type="file" id="pdfFile" name="pdf_file" accept=".pdf" required onchange="updateFileName(this, 'pdfFileName')">
                        <div class="file-name" id="pdfFileName"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Cover Buku (Opsional)</label>
                    <div class="file-input-wrapper">
                        <label class="file-input-label" for="coverImage">
                            <i class="fas fa-image"></i>
                            <span>Pilih Gambar Cover (Maks 2MB)</span>
                        </label>
                        <input type="file" id="coverImage" name="cover_image" accept="image/*" onchange="updateFileName(this, 'coverFileName')">
                        <div class="file-name" id="coverFileName"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Penerbit</label>
                    <input type="text" name="publisher" class="form-control">
                </div>

                <div class="form-group">
                    <label>Tahun Terbit</label>
                    <input type="text" name="published_year" class="form-control" placeholder="2024" maxlength="4">
                </div>

                <div class="form-group">
                    <label>ISBN</label>
                    <input type="text" name="isbn" class="form-control" placeholder="978-0-123456-78-9">
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-cancel" onclick="closeAddBookModal()">
                        Batal
                    </button>
                    <button type="submit" class="btn-submit" id="submitBtn">
                        <i class="fas fa-save"></i>
                        Simpan Buku
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Sidebar Toggle
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const toggleBtn = document.getElementById('toggleSidebar');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        });

        // Modal Functions
        function openAddBookModal() {
            document.getElementById('addBookModal').classList.add('active');
            document.getElementById('addBookForm').reset();
            document.getElementById('pdfFileName').textContent = '';
            document.getElementById('coverFileName').textContent = '';
            document.getElementById('alertContainer').innerHTML = '';
        }

        function closeAddBookModal() {
            document.getElementById('addBookModal').classList.remove('active');
        }

        // Close modal when clicking outside
        document.getElementById('addBookModal').addEventListener('click', (e) => {
            if (e.target.id === 'addBookModal') {
                closeAddBookModal();
            }
        });

        // Update file name display
        function updateFileName(input, targetId) {
            const target = document.getElementById(targetId);
            if (input.files.length > 0) {
                const file = input.files[0];
                const size = (file.size / 1024 / 1024).toFixed(2);
                target.textContent = `${file.name} (${size} MB)`;
            } else {
                target.textContent = '';
            }
        }

        // Form Submission
        document.getElementById('addBookForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const submitBtn = document.getElementById('submitBtn');
            const formData = new FormData(e.target);
            
            // Disable submit button
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
            
            try {
                const response = await fetch('<?php echo e(route("personal-books.store")); ?>', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showAlert('success', data.message);
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    showAlert('error', data.message || 'Terjadi kesalahan saat menyimpan buku');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-save"></i> Simpan Buku';
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('error', 'Terjadi kesalahan saat menyimpan buku');
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-save"></i> Simpan Buku';
            }
        });

        // View PDF
        function viewPDF(bookId) {
            window.open(`/personal-books/${bookId}`, '_blank');
        }

        // Delete Book
        async function deleteBook(bookId, bookTitle) {
            if (!confirm(`Apakah Anda yakin ingin menghapus buku "${bookTitle}"?\n\nFile PDF dan cover akan dihapus permanen.`)) {
                return;
            }
            
            try {
                const response = await fetch(`/personal-books/${bookId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    alert(data.message);
                    window.location.reload();
                } else {
                    alert(data.message || 'Terjadi kesalahan saat menghapus buku');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menghapus buku');
            }
        }

        // Show Alert
        function showAlert(type, message) {
            const alertContainer = document.getElementById('alertContainer');
            const icon = type === 'success' ? 'check-circle' : 'exclamation-circle';
            const alertClass = type === 'success' ? 'alert-success' : 'alert-error';
            
            alertContainer.innerHTML = `
                <div class="alert ${alertClass}">
                    <i class="fas fa-${icon}"></i>
                    <span>${message}</span>
                </div>
            `;
            
            // Auto-hide after 5 seconds
            setTimeout(() => {
                alertContainer.innerHTML = '';
            }, 5000);
        }
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\PERPUSTAKAAN\resources\views/dashboard/personal-books.blade.php ENDPATH**/ ?>