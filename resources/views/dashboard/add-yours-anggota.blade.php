<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku Anda - SisPerpus</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
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

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #1e293b 0%, #334155 100%);
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }

        .sidebar.collapsed {
            transform: translateX(-100%);
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.2);
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 0.5rem;
        }

        .logo-container i {
            font-size: 2rem;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 0 10px rgba(102, 126, 234, 0.5));
        }

        .sidebar-title {
            font-size: 1.75rem;
            font-weight: 800;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea, #f093fb);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .sidebar-subtitle {
            font-size: 0.875rem;
            color: #94a3b8;
            font-weight: 400;
        }

        .sidebar-nav {
            padding: 1.5rem 0;
            flex: 1;
        }

        .nav-section {
            margin-bottom: 2rem;
        }

        .nav-section-title {
            font-size: 0.75rem;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            padding: 0 1.5rem;
            margin-bottom: 0.75rem;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.875rem 1.5rem;
            color: #e2e8f0;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .nav-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 0;
            height: 100%;
            background: linear-gradient(90deg, rgba(102, 126, 234, 0.2), transparent);
            transition: width 0.3s ease;
        }

        .nav-item:hover {
            background: rgba(102, 126, 234, 0.1);
            border-left-color: var(--primary);
        }

        .nav-item:hover::before {
            width: 100%;
        }

        .nav-item.active {
            background: linear-gradient(90deg, rgba(102, 126, 234, 0.2), transparent);
            border-left-color: var(--accent);
            color: white;
            font-weight: 600;
        }

        .nav-item i {
            font-size: 1.1rem;
            width: 24px;
            text-align: center;
        }

        .notification-badge {
            margin-left: auto;
            background: var(--danger);
            color: white;
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 10px;
            font-weight: 600;
        }

        .sidebar-footer {
            padding: 1.5rem;
            background: rgba(0, 0, 0, 0.3);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: auto;
        }

        .user-card {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            margin-bottom: 1rem;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.25rem;
            color: white;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .user-details {
            flex: 1;
        }

        .user-details strong {
            display: block;
            font-size: 0.95rem;
            margin-bottom: 0.25rem;
        }

        .user-details small {
            font-size: 0.8rem;
            color: #94a3b8;
        }

        .logout-btn {
            width: 100%;
            padding: 0.75rem;
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .logout-btn:hover {
            background: var(--danger);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-x: hidden;
        }

        .main-content.expanded {
            margin-left: 0;
        }

        /* ===== HEADER ===== */
        .header {
            background: white;
            height: var(--header-height);
            display: flex;
            align-items: center;
            padding: 0 2rem;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid var(--border);
        }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--dark);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 0.5rem;
            transition: background 0.3s ease;
            margin-right: 1rem;
        }

        .menu-toggle:hover {
            background: var(--light);
        }

        .header-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--dark);
            font-family: 'Poppins', sans-serif;
        }

        /* ===== CONTENT AREA ===== */
        .content-area {
            padding: 2rem;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 50%, #f1f5f9 100%);
            min-height: calc(100vh - var(--header-height));
        }

        /* ===== ADD YOURS FORM ===== */
        .add-yours-container {
            max-width: 900px;
            margin: 0 auto;
        }

        .page-header {
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
            border-left: 4px solid var(--primary);
        }

        .page-header h2 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .page-header p {
            color: var(--text-secondary);
            font-size: 1rem;
        }

        .form-card {
            background: white;
            padding: 2.5rem;
            border-radius: 1rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .form-section {
            margin-bottom: 2rem;
        }

        .form-section-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid var(--border);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-section-title i {
            color: var(--primary);
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .form-label .required {
            color: var(--danger);
            margin-left: 0.25rem;
        }

        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid var(--border);
            border-radius: 0.5rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(102,126,234,0.1);
        }

        .form-textarea {
            resize: vertical;
            min-height: 120px;
        }

        .file-upload-wrapper {
            position: relative;
        }

        .file-upload-input {
            display: none;
        }

        .file-upload-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            border: 2px dashed var(--border);
            border-radius: 0.75rem;
            cursor: pointer;
            transition: all 0.3s ease;
            background: var(--light);
        }

        .file-upload-label:hover {
            border-color: var(--primary);
            background: rgba(102,126,234,0.05);
        }

        .file-upload-icon {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .file-upload-text {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.25rem;
        }

        .file-upload-hint {
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        .file-preview {
            margin-top: 1rem;
            padding: 1rem;
            background: var(--light);
            border-radius: 0.5rem;
            display: none;
        }

        .file-preview.show {
            display: block;
        }

        .file-preview-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .file-preview-icon {
            width: 40px;
            height: 40px;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.5rem;
            font-size: 1.25rem;
        }

        .file-preview-info {
            flex: 1;
        }

        .file-preview-name {
            font-weight: 600;
            color: var(--dark);
            font-size: 0.9rem;
        }

        .file-preview-size {
            font-size: 0.8rem;
            color: var(--text-secondary);
        }

        .file-preview-remove {
            background: var(--danger);
            color: white;
            border: none;
            padding: 0.5rem 0.75rem;
            border-radius: 0.375rem;
            cursor: pointer;
            font-size: 0.875rem;
            transition: all 0.3s ease;
        }

        .file-preview-remove:hover {
            background: #dc2626;
        }

        .image-preview {
            margin-top: 1rem;
            display: none;
        }

        .image-preview.show {
            display: block;
        }

        .image-preview img {
            max-width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 2px solid var(--border);
        }

        .btn {
            padding: 1rem 2rem;
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            justify-content: center;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            flex: 1;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102,126,234,0.4);
        }

        .btn-secondary {
            background: white;
            color: var(--text-primary);
            border: 2px solid var(--border);
        }

        .btn-secondary:hover {
            background: var(--light);
            border-color: var(--primary);
            color: var(--primary);
        }

        .alert {
            padding: 1rem 1.5rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-success {
            background: rgba(16,185,129,0.1);
            color: var(--success);
            border: 1px solid var(--success);
        }

        .alert-error {
            background: rgba(239,68,68,0.1);
            color: var(--danger);
            border: 1px solid var(--danger);
        }

        .alert i {
            font-size: 1.25rem;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .menu-toggle {
                display: block;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .content-area {
                padding: 1rem;
            }

            .form-card {
                padding: 1.5rem;
            }

            .page-header {
                padding: 1.5rem;
            }

            .header {
                padding: 0 1rem;
            }

            .header-title {
                font-size: 1.25rem;
            }
        }

        @media (max-width: 480px) {
            .content-area {
                padding: 0.75rem;
            }

            .form-card {
                padding: 1rem;
            }

            .page-header h2 {
                font-size: 1.25rem;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-wrapper">
        <!-- Sidebar -->
        @include('components.sidebar')
        
        <!-- Main Content -->
        <div class="main-content" id="mainContent">
            <!-- Header -->
            <header class="header">
                <button class="menu-toggle" id="menuToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="header-title">
                    <i class="fas fa-plus-circle"></i> Tambah Buku Anda
                </h1>
            </header>
            
            <!-- Content Area -->
            <div class="content-area">
                <div class="add-yours-container">
                    <!-- Page Header -->
                    <div class="page-header">
                        <h2><i class="fas fa-book-medical"></i> Kontribusi Buku Anda</h2>
                        <p>Bagikan pengetahuan Anda dengan menambahkan buku ke dalam koleksi perpustakaan digital kami.</p>
                    </div>

                    <!-- Success Message -->
                    @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    @endif

                    <!-- Error Messages -->
                    @if($errors->any())
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <div>
                            <strong>Terjadi kesalahan:</strong>
                            <ul style="margin: 0.5rem 0 0 1.5rem;">
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

                    <!-- Form Card -->
                    <div class="form-card">
                        <form action="{{ route('books.store-user-book') }}" method="POST" enctype="multipart/form-data" id="addBookForm">
                            @csrf
                            
                            <!-- Book Information Section -->
                            <div class="form-section">
                                <h3 class="form-section-title">
                                    <i class="fas fa-info-circle"></i>
                                    Informasi Buku
                                </h3>
                                
                                <div class="form-grid">
                                    <div class="form-group">
                                        <label class="form-label">
                                            Judul Buku <span class="required">*</span>
                                        </label>
                                        <input type="text" name="title" class="form-input" placeholder="Masukkan judul buku" value="{{ old('title') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">
                                            Penulis <span class="required">*</span>
                                        </label>
                                        <input type="text" name="author" class="form-input" placeholder="Nama penulis" value="{{ old('author') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">
                                            ISBN <span class="required">*</span>
                                        </label>
                                        <input type="text" name="isbn" class="form-input" placeholder="ISBN-13 atau ISBN-10" value="{{ old('isbn') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">
                                            Kategori <span class="required">*</span>
                                        </label>
                                        <select name="category_id" class="form-select" required>
                                            <option value="">Pilih Kategori</option>
                                            @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">
                                            Penerbit <span class="required">*</span>
                                        </label>
                                        <input type="text" name="publisher" class="form-input" placeholder="Nama penerbit" value="{{ old('publisher') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">
                                            Tahun Terbit <span class="required">*</span>
                                        </label>
                                        <input type="number" name="published_year" class="form-input" placeholder="2024" min="1900" max="{{ date('Y') + 1 }}" value="{{ old('published_year') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">
                                            Jumlah Stock <span class="required">*</span>
                                        </label>
                                        <input type="number" name="stock" class="form-input" placeholder="Jumlah buku" min="1" value="{{ old('stock', 1) }}" required>
                                    </div>

                                    <div class="form-group full-width">
                                        <label class="form-label">
                                            Deskripsi
                                        </label>
                                        <textarea name="description" class="form-textarea" placeholder="Deskripsi singkat tentang buku ini...">{{ old('description') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- File Upload Section -->
                            <div class="form-section">
                                <h3 class="form-section-title">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    Upload File
                                </h3>
                                
                                <div class="form-grid">
                                    <!-- Cover Image Upload -->
                                    <div class="form-group">
                                        <label class="form-label">
                                            Cover Buku <span class="required">*</span>
                                        </label>
                                        <div class="file-upload-wrapper">
                                            <input type="file" name="cover_image" id="coverImage" class="file-upload-input" accept="image/jpeg,image/png,image/jpg,image/gif" required>
                                            <label for="coverImage" class="file-upload-label">
                                                <i class="fas fa-image file-upload-icon"></i>
                                                <span class="file-upload-text">Upload Cover Buku</span>
                                                <span class="file-upload-hint">JPG, PNG, GIF (Max 2MB)</span>
                                            </label>
                                            <div class="image-preview" id="coverPreview">
                                                <img id="coverPreviewImg" src="" alt="Preview">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- PDF Upload -->
                                    <div class="form-group">
                                        <label class="form-label">
                                            File PDF Buku <span class="required">*</span>
                                        </label>
                                        <div class="file-upload-wrapper">
                                            <input type="file" name="pdf_file" id="pdfFile" class="file-upload-input" accept="application/pdf" required>
                                            <label for="pdfFile" class="file-upload-label">
                                                <i class="fas fa-file-pdf file-upload-icon"></i>
                                                <span class="file-upload-text">Upload File PDF</span>
                                                <span class="file-upload-hint">PDF (Max 10MB)</span>
                                            </label>
                                            <div class="file-preview" id="pdfPreview">
                                                <div class="file-preview-item">
                                                    <div class="file-preview-icon">
                                                        <i class="fas fa-file-pdf"></i>
                                                    </div>
                                                    <div class="file-preview-info">
                                                        <div class="file-preview-name" id="pdfName"></div>
                                                        <div class="file-preview-size" id="pdfSize"></div>
                                                    </div>
                                                    <button type="button" class="file-preview-remove" onclick="removePdf()">
                                                        <i class="fas fa-times"></i> Hapus
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="form-actions">
                                <button type="button" class="btn btn-secondary" onclick="window.location='{{ route('dashboard') }}'">
                                    <i class="fas fa-times"></i>
                                    Batal
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-check"></i>
                                    Tambahkan Buku
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle sidebar
        document.getElementById('menuToggle')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('sidebar').classList.toggle('collapsed');
            document.getElementById('mainContent').classList.toggle('expanded');
        });

        // Cover Image Preview
        const coverImageInput = document.getElementById('coverImage');
        const coverPreview = document.getElementById('coverPreview');
        const coverPreviewImg = document.getElementById('coverPreviewImg');

        coverImageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    coverPreviewImg.src = e.target.result;
                    coverPreview.classList.add('show');
                }
                reader.readAsDataURL(file);
            }
        });

        // PDF Preview
        const pdfFileInput = document.getElementById('pdfFile');
        const pdfPreview = document.getElementById('pdfPreview');
        const pdfName = document.getElementById('pdfName');
        const pdfSize = document.getElementById('pdfSize');

        pdfFileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                pdfName.textContent = file.name;
                pdfSize.textContent = formatFileSize(file.size);
                pdfPreview.classList.add('show');
            }
        });

        function removePdf() {
            pdfFileInput.value = '';
            pdfPreview.classList.remove('show');
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
        }

        // Form Validation
        const form = document.getElementById('addBookForm');
        form.addEventListener('submit', function(e) {
            const coverImage = document.getElementById('coverImage').files[0];
            const pdfFile = document.getElementById('pdfFile').files[0];

            // Validate cover image size
            if (coverImage && coverImage.size > 2 * 1024 * 1024) {
                e.preventDefault();
                alert('Ukuran cover image tidak boleh lebih dari 2MB');
                return false;
            }

            // Validate PDF size
            if (pdfFile && pdfFile.size > 10 * 1024 * 1024) {
                e.preventDefault();
                alert('Ukuran file PDF tidak boleh lebih dari 10MB');
                return false;
            }
        });
    </script>
</body>
</html>
