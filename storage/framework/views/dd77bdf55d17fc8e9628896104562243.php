<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($book->title); ?> - SisPerpus</title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/@zxing/library@latest"></script>
    
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
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 50%, #f1f5f9 100%);
            min-height: 100vh;
            color: var(--text-dark);
        }

        /* Header */
        .header {
            background: white;
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .back-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: var(--light);
            border: none;
            border-radius: 10px;
            color: var(--text-dark);
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
        }

        .back-btn:hover {
            background: var(--primary);
            color: white;
            transform: translateX(-5px);
        }

        .header-title {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Main Container */
        .container {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        /* Book Detail Grid */
        .book-detail-grid {
            display: grid;
            grid-template-columns: 400px 1fr;
            gap: 3rem;
            margin-bottom: 3rem;
        }

        /* Book Cover Section */
        .book-cover-section {
            background: white;
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            position: sticky;
            top: 100px;
            height: fit-content;
        }

        .book-cover {
            width: 100%;
            aspect-ratio: 2/3;
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 1.5rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
            position: relative;
        }

        .book-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .book-cover i {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            font-size: 6rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
        }

        .availability-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.25rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 1rem;
        }

        .availability-badge.available {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .availability-badge.unavailable {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
        }

        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .btn {
            padding: 1rem;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: white;
            border: 2px solid var(--border);
            color: var(--text-dark);
        }

        .btn-secondary:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .btn-wishlist {
            background: white;
            border: 2px solid var(--border);
            color: var(--text-dark);
        }

        .btn-wishlist:hover {
            border-color: var(--danger);
            color: var(--danger);
        }

        .btn-wishlist.active {
            background: var(--danger);
            border-color: var(--danger);
            color: white;
        }

        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Book Info Section */
        .book-info-section {
            background: white;
            padding: 2.5rem;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        }

        .book-header {
            margin-bottom: 2rem;
        }

        .book-category {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
            color: var(--primary);
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .book-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            line-height: 1.2;
        }

        .book-author {
            font-size: 1.25rem;
            color: var(--text-light);
            margin-bottom: 1.5rem;
        }

        /* Rating Section */
        .rating-section {
            display: flex;
            align-items: center;
            gap: 2rem;
            padding: 1.5rem;
            background: linear-gradient(135deg, #fff5e6 0%, #ffe6f0 100%);
            border-radius: 15px;
            margin-bottom: 2rem;
        }

        .rating-score {
            text-align: center;
        }

        .rating-number {
            font-size: 3rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--warning), var(--danger));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1;
        }

        .rating-stars {
            display: flex;
            gap: 0.25rem;
            margin: 0.5rem 0;
        }

        .rating-stars i {
            color: var(--warning);
            font-size: 1.25rem;
        }

        .rating-count {
            font-size: 0.9rem;
            color: var(--text-light);
        }

        .rating-interactive {
            flex: 1;
        }

        .rating-interactive h4 {
            margin-bottom: 0.75rem;
            color: var(--text-dark);
        }

        .star-rating {
            display: flex;
            gap: 0.5rem;
        }

        .star-rating i {
            font-size: 2rem;
            color: #ddd;
            cursor: pointer;
            transition: all 0.2s;
        }

        .star-rating i:hover,
        .star-rating i.active {
            color: var(--warning);
            transform: scale(1.1);
        }

        /* Tabs */
        .tabs {
            display: flex;
            gap: 1rem;
            border-bottom: 2px solid var(--border);
            margin-bottom: 2rem;
        }

        .tab {
            padding: 1rem 2rem;
            background: none;
            border: none;
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-light);
            cursor: pointer;
            position: relative;
            transition: all 0.3s;
        }

        .tab.active {
            color: var(--primary);
        }

        .tab.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            border-radius: 3px 3px 0 0;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
            animation: fadeIn 0.3s;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* About Tab */
        .book-meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .meta-item {
            padding: 1.5rem;
            background: var(--light);
            border-radius: 12px;
            border-left: 4px solid var(--primary);
        }

        .meta-label {
            font-size: 0.85rem;
            color: var(--text-light);
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            font-weight: 600;
        }

        .meta-value {
            font-size: 1.1rem;
            color: var(--text-dark);
            font-weight: 600;
        }

        .description {
            line-height: 1.8;
            color: var(--text-dark);
            font-size: 1.05rem;
        }

        .description h3 {
            margin-top: 2rem;
            margin-bottom: 1rem;
            color: var(--text-dark);
        }

        /* Reviews Tab */
        .reviews-container {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .comment-form {
            background: var(--light);
            padding: 2rem;
            border-radius: 15px;
        }

        .comment-form h3 {
            margin-bottom: 1rem;
            color: var(--text-dark);
        }

        .comment-textarea {
            width: 100%;
            min-height: 120px;
            padding: 1rem;
            border: 2px solid var(--border);
            border-radius: 12px;
            font-family: inherit;
            font-size: 1rem;
            resize: vertical;
            transition: border-color 0.3s;
        }

        .comment-textarea:focus {
            outline: none;
            border-color: var(--primary);
        }

        .comment-form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 1rem;
        }

        .comments-list {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .comment-item {
            background: white;
            padding: 1.5rem;
            border-radius: 15px;
            border: 1px solid var(--border);
            transition: all 0.3s;
        }

        .comment-item:hover {
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            transform: translateY(-2px);
        }

        .comment-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .comment-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.25rem;
        }

        .comment-info {
            flex: 1;
        }

        .comment-author {
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.25rem;
        }

        .comment-date {
            font-size: 0.85rem;
            color: var(--text-light);
        }

        .comment-text {
            color: var(--text-dark);
            line-height: 1.6;
        }

        .no-comments {
            text-align: center;
            padding: 3rem;
            color: var(--text-light);
        }

        .no-comments i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.3;
        }

        /* Notification */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 1rem 1.5rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            gap: 1rem;
            z-index: 1000;
            animation: slideIn 0.3s;
            min-width: 300px;
        }

        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .notification.success {
            border-left: 4px solid var(--success);
        }

        .notification.error {
            border-left: 4px solid var(--danger);
        }

        .notification.warning {
            border-left: 4px solid var(--warning);
        }

        .notification i {
            font-size: 1.5rem;
        }

        .notification.success i {
            color: var(--success);
        }

        .notification.error i {
            color: var(--danger);
        }

        .notification.warning i {
            color: var(--warning);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .book-detail-grid {
                grid-template-columns: 1fr;
            }

            .book-cover-section {
                position: static;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 1rem;
            }

            .book-title {
                font-size: 1.75rem;
            }

            .rating-section {
                flex-direction: column;
                align-items: flex-start;
            }

            .tabs {
                overflow-x: auto;
            }

            .book-meta {
                grid-template-columns: 1fr;
            }
        }

        /* ===== LOAN MODAL STYLES ===== */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 10000;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-container {
            background: white;
            border-radius: 20px;
            width: 90%;
            max-width: 1000px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.5rem 2rem;
            border-bottom: 2px solid var(--border);
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
        }

        .modal-header h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .modal-close {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: none;
            background: var(--light);
            color: var(--text-dark);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .modal-close:hover {
            background: var(--danger);
            color: white;
        }

        .modal-content {
            padding: 2rem;
        }

        .request-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .book-preview {
            display: flex;
            gap: 1.5rem;
            padding: 1.5rem;
            background: var(--light);
            border-radius: 15px;
            border: 2px solid var(--border);
        }

        .preview-cover {
            width: 120px;
            height: 160px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            flex-shrink: 0;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
        }

        .preview-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .preview-info {
            flex: 1;
        }

        .preview-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .preview-author {
            color: var(--text-light);
            margin-bottom: 1rem;
        }

        .preview-details {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .preview-detail {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: white;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.9rem;
        }

        .tab-navigation {
            display: flex;
            gap: 1rem;
            border-bottom: 2px solid var(--border);
        }

        .tab-btn {
            padding: 1rem 1.5rem;
            background: none;
            border: none;
            border-bottom: 3px solid transparent;
            color: var(--text-light);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .tab-btn.active {
            color: var(--primary);
            border-bottom-color: var(--primary);
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .camera-section, .identity-section, .photo-section, .loan-details {
            padding: 1.5rem;
            background: var(--light);
            border-radius: 15px;
            border: 1px solid var(--border);
        }

        .camera-section h4, .identity-section h4, .photo-section h4, .loan-details h4 {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .camera-container {
            position: relative;
            width: 100%;
            max-width: 640px;
            aspect-ratio: 4/3;
            background: #000;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 1rem;
        }

        #qrVideo, #photoVideo {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .camera-controls {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .scan-result {
            margin-top: 1rem;
            padding: 1rem;
            background: white;
            border-radius: 10px;
            border: 1px solid var(--border);
        }

        .scan-result label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            display: block;
        }

        .scan-result textarea {
            width: 100%;
            min-height: 80px;
            padding: 0.75rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            resize: vertical;
            font-family: 'Courier New', monospace;
        }

        .section-description {
            color: var(--text-light);
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .verification-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .verification-item label {
            font-size: 0.85rem;
            color: var(--text-light);
            margin-bottom: 0.5rem;
            display: block;
            font-weight: 600;
        }

        .readonly-value {
            padding: 0.75rem;
            background: white;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .form-group label {
            font-weight: 600;
            color: var(--text-dark);
            font-size: 0.9rem;
        }

        .form-group input, .form-group textarea {
            padding: 0.75rem;
            border: 2px solid var(--border);
            border-radius: 10px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .form-group input:focus, .form-group textarea:focus {
            outline: none;
            border-color: var(--primary);
        }

        .photo-capture {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        .photo-preview {
            width: 150px;
            height: 150px;
            border: 2px dashed var(--border);
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: var(--text-light);
            background: white;
            overflow: hidden;
        }

        .photo-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .photo-preview i {
            font-size: 3rem;
            margin-bottom: 0.5rem;
        }

        .photo-controls {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .photo-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 10001;
        }

        .photo-modal-content {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            width: 90%;
            max-width: 800px;
        }

        .photo-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .photo-header h3 {
            font-size: 1.25rem;
            font-weight: 700;
        }

        .photo-header button {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--text-light);
        }

        .photo-camera {
            width: 100%;
            aspect-ratio: 4/3;
            background: #000;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        .photo-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
        }

        .duration-selector {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .duration-btn {
            padding: 0.75rem 1.25rem;
            border: 2px solid var(--border);
            background: white;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            color: var(--text-dark);
            transition: all 0.3s;
        }

        .duration-btn:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .duration-btn.active {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            padding-top: 1rem;
            border-top: 2px solid var(--border);
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="header-content">
            <a href="<?php echo e(route('books.browse')); ?>" class="back-btn">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
            <h1 class="header-title">Detail Buku</h1>
        </div>
    </div>

    <!-- Main Container -->
    <div class="container">
        <div class="book-detail-grid">
            <!-- Book Cover Section -->
            <div class="book-cover-section">
                <div class="book-cover">
                    <?php if($book->cover_image): ?>
                        <img src="<?php echo e($book->cover_image && str_starts_with($book->cover_image, 'http') ? $book->cover_image : '/' . $book->cover_image); ?>" alt="<?php echo e($book->title); ?>">
                    <?php else: ?>
                        <i class="fas fa-book"></i>
                    <?php endif; ?>
                </div>

                <div class="availability-badge <?php echo e($book->isAvailable() ? 'available' : 'unavailable'); ?>">
                    <i class="fas <?php echo e($book->isAvailable() ? 'fa-check-circle' : 'fa-times-circle'); ?>"></i>
                    <?php echo e($book->isAvailable() ? $book->available . ' tersedia' : 'Tidak tersedia'); ?>

                </div>

                <div class="action-buttons">
                    <?php if($book->isAvailable()): ?>
                        <button class="btn btn-primary" onclick="requestLoan()">
                            <i class="fas fa-hand-holding"></i>
                            Ajukan Peminjaman
                        </button>
                    <?php else: ?>
                        <button class="btn btn-primary" disabled>
                            <i class="fas fa-times-circle"></i>
                            Stok Habis
                        </button>
                    <?php endif; ?>

                    <?php if($book->pdf_file): ?>
                        <a href="<?php echo e(asset($book->pdf_file)); ?>" target="_blank" class="btn btn-success">
                            <i class="fas fa-file-pdf"></i>
                            Lihat PDF
                        </a>
                    <?php endif; ?>

                    <button class="btn btn-wishlist <?php echo e($isWishlisted ? 'active' : ''); ?>" onclick="toggleWishlist()">
                        <i class="fas fa-heart"></i>
                        <span id="wishlistText"><?php echo e($isWishlisted ? 'Hapus dari Wishlist' : 'Tambah ke Wishlist'); ?></span>
                    </button>
                </div>
            </div>

            <!-- Book Info Section -->
            <div class="book-info-section">
                <div class="book-header">
                    <div class="book-category">
                        <i class="fas fa-tag"></i> <?php echo e($book->category->name ?? 'Umum'); ?>

                    </div>
                    <h1 class="book-title"><?php echo e($book->title); ?></h1>
                    <p class="book-author">oleh <?php echo e($book->author); ?></p>

                    <!-- Rating Section -->
                    <div class="rating-section">
                        <div class="rating-score">
                            <div class="rating-number"><?php echo e(number_format($averageRating, 1)); ?></div>
                            <div class="rating-stars">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <i class="<?php echo e($i <= round($averageRating) ? 'fas fa-star' : 'far fa-star'); ?>"></i>
                                <?php endfor; ?>
                            </div>
                            <div class="rating-count"><?php echo e($ratingsCount); ?> penilaian</div>
                        </div>

                        <div class="rating-interactive">
                            <h4>Beri Penilaian</h4>
                            <div class="star-rating" id="userRating">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <i data-rating="<?php echo e($i); ?>" onclick="rateBook(<?php echo e($i); ?>)" class="<?php echo e(($userRating && $i <= $userRating->rating) ? 'fas fa-star active' : 'far fa-star'); ?>"></i>
                                <?php endfor; ?>
                            </div>
                            <?php if($userRating): ?>
                                <p style="margin-top: 0.5rem; font-size: 0.9rem; color: var(--text-light);">
                                    Anda memberi rating: <?php echo e($userRating->rating); ?>/5
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Tabs -->
                <div class="tabs">
                    <button class="tab active" onclick="switchTab('about')">
                        <i class="fas fa-info-circle"></i> About
                    </button>
                    <button class="tab" onclick="switchTab('reviews')">
                        <i class="fas fa-comments"></i> Reviews (<?php echo e($commentsCount); ?>)
                    </button>
                </div>

                <!-- About Tab -->
                <div id="about-tab" class="tab-content active">
                    <div class="book-meta">
                        <div class="meta-item">
                            <div class="meta-label">ISBN</div>
                            <div class="meta-value"><?php echo e($book->isbn ?? '-'); ?></div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Penerbit</div>
                            <div class="meta-value"><?php echo e($book->publisher ?? '-'); ?></div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Tahun Terbit</div>
                            <div class="meta-value"><?php echo e($book->published_year ?? '-'); ?></div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Stok</div>
                            <div class="meta-value"><?php echo e($book->stock); ?> buku</div>
                        </div>
                    </div>

                    <div class="description">
                        <h3>Deskripsi</h3>
                        <p><?php echo e($book->description ?? 'Tidak ada deskripsi tersedia untuk buku ini.'); ?></p>
                    </div>
                </div>

                <!-- Reviews Tab -->
                <div id="reviews-tab" class="tab-content">
                    <div class="reviews-container">
                        <!-- Comment Form -->
                        <div class="comment-form">
                            <h3><i class="fas fa-pen"></i> Tulis Komentar</h3>
                            <form id="commentForm" onsubmit="submitComment(event)">
                                <textarea 
                                    class="comment-textarea" 
                                    id="commentText" 
                                    placeholder="Bagikan pendapat Anda tentang buku ini..."
                                    required
                                ></textarea>
                                <div class="comment-form-actions">
                                    <button type="button" class="btn btn-secondary" onclick="document.getElementById('commentText').value = ''">
                                        Batal
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane"></i>
                                        Kirim Komentar
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Comments List -->
                        <div class="comments-list" id="commentsList">
                            <?php $__empty_1 = true; $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="comment-item">
                                    <div class="comment-header">
                                        <div class="comment-avatar">
                                            <?php echo e(strtoupper(substr($comment->user->name, 0, 1))); ?>

                                        </div>
                                        <div class="comment-info">
                                            <div class="comment-author"><?php echo e($comment->user->name); ?></div>
                                            <div class="comment-date"><?php echo e($comment->created_at->diffForHumans()); ?></div>
                                        </div>
                                    </div>
                                    <div class="comment-text"><?php echo e($comment->comment); ?></div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="no-comments">
                                    <i class="fas fa-comments"></i>
                                    <h3>Belum Ada Komentar</h3>
                                    <p>Jadilah yang pertama memberikan komentar untuk buku ini!</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Request Loan Modal -->
    <div class="modal-overlay" id="requestLoanModal">
        <div class="modal-container">
            <div class="modal-header">
                <h2><i class="fas fa-hand-holding"></i> Ajukan Peminjaman Buku</h2>
                <button class="modal-close" onclick="closeRequestLoanModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-content">
                <div class="request-form">
                    <div class="book-preview" id="bookPreview">
                        <!-- Book details will be loaded here -->
                    </div>
                    
                    <!-- Tab Navigation -->
                    <div class="tab-navigation">
                        <button class="tab-btn active" onclick="switchLoanTab('qr-scan')" id="qr-tab-btn">
                            <i class="fas fa-qrcode"></i>
                            Scan QR Code
                        </button>
                        <button class="tab-btn" onclick="switchLoanTab('manual-input')" id="manual-tab-btn">
                            <i class="fas fa-edit"></i>
                            Input Manual
                        </button>
                    </div>

                    <form id="loanRequestForm">
                        <!-- QR Scan Tab -->
                        <div id="qr-scan-tab" class="tab-content active">
                            <div class="camera-section">
                                <h4><i class="fas fa-camera"></i> Scan QR Code Identitas</h4>
                                <div class="camera-container">
                                    <video id="qrVideo" autoplay playsinline></video>
                                    <canvas id="qrCanvas" style="display: none;"></canvas>
                                </div>
                                <div class="camera-controls">
                                    <button type="button" class="btn btn-primary" onclick="startQRScanner()">
                                        <i class="fas fa-camera"></i> Mulai Scan
                                    </button>
                                    <button type="button" class="btn btn-secondary" onclick="stopQRScanner()">
                                        <i class="fas fa-stop"></i> Stop
                                    </button>
                                </div>
                                <div id="qrResult" class="scan-result" style="display: none;">
                                    <label>Data yang terdeteksi:</label>
                                    <textarea id="qrData" readonly></textarea>
                                </div>
                            </div>
                            
                            <!-- Verification Section for QR Tab -->
                            <div class="identity-section" style="margin-top: 1rem;">
                                <h4><i class="fas fa-shield-check"></i> Verifikasi Data dari QR</h4>
                                <p class="section-description">Setelah QR terbaca, data dari QR akan tampil di bawah untuk diverifikasi.</p>
                                <div class="verification-grid">
                                    <div class="verification-item">
                                        <label>Nama Lengkap</label>
                                        <div class="readonly-value" id="qrVerifyFullName">—</div>
                                    </div>
                                    <div class="verification-item">
                                        <label>Kelas</label>
                                        <div class="readonly-value" id="qrVerifyStudentClass">—</div>
                                    </div>
                                    <div class="verification-item">
                                        <label>Jurusan</label>
                                        <div class="readonly-value" id="qrVerifyMajor">—</div>
                                    </div>
                                    <div class="verification-item">
                                        <label>NISN</label>
                                        <div class="readonly-value" id="qrVerifyNisn">—</div>
                                    </div>
                                    <div class="verification-item">
                                        <label>NIS</label>
                                        <div class="readonly-value" id="qrVerifyNis">—</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Manual Input Tab -->
                        <div id="manual-input-tab" class="tab-content">
                            <div class="identity-section">
                                <h4><i class="fas fa-id-card"></i> Data Identitas</h4>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="nisn">NISN (Nomor Induk Siswa Nasional)</label>
                                        <input type="text" id="nisn" name="nisn" placeholder="Masukkan NISN" maxlength="20">
                                    </div>
                                    <div class="form-group">
                                        <label for="nis">NIS (Nomor Induk Siswa)</label>
                                        <input type="text" id="nis" name="nis" placeholder="Masukkan NIS" maxlength="20">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group" style="grid-column: 1 / -1;">
                                        <label for="fullName">Nama Lengkap</label>
                                        <input type="text" id="fullName" name="full_name" placeholder="Masukkan nama lengkap" maxlength="100" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="studentClass">Kelas</label>
                                        <input type="text" id="studentClass" name="student_class" placeholder="Contoh: XII IPA 1" maxlength="20" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="major">Jurusan</label>
                                        <input type="text" id="major" name="major" placeholder="Contoh: IPA, IPS, Bahasa" maxlength="50" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Photo Capture Section (Common for both tabs) -->
                        <div class="photo-section">
                            <h4><i class="fas fa-camera-retro"></i> Foto Peminjam</h4>
                            <div class="photo-capture">
                                <div class="photo-preview" id="photoPreview">
                                    <i class="fas fa-user-circle"></i>
                                    <p>Belum ada foto</p>
                                </div>
                                <div class="photo-controls">
                                    <button type="button" class="btn btn-primary" onclick="startPhotoCapture()">
                                        <i class="fas fa-camera"></i> Ambil Foto
                                    </button>
                                    <button type="button" class="btn btn-secondary" onclick="retakePhoto()" id="retakeBtn" style="display: none;">
                                        <i class="fas fa-redo"></i> Foto Ulang
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Camera Modal for Photo -->
                        <div id="photoModal" class="photo-modal" style="display: none;">
                            <div class="photo-modal-content">
                                <div class="photo-header">
                                    <h3>Ambil Foto Peminjam</h3>
                                    <button type="button" onclick="closePhotoModal()">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <div class="photo-camera">
                                    <video id="photoVideo" autoplay playsinline></video>
                                    <canvas id="photoCanvas" style="display: none;"></canvas>
                                </div>
                                <div class="photo-actions">
                                    <button type="button" class="btn btn-primary" onclick="capturePhoto()">
                                        <i class="fas fa-camera"></i> Ambil Foto
                                    </button>
                                    <button type="button" class="btn btn-secondary" onclick="closePhotoModal()">
                                        Batal
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Loan Details -->
                        <div class="loan-details">
                            <h4><i class="fas fa-calendar-alt"></i> Detail Peminjaman</h4>
                            <div class="form-row">
                                <div class="form-group" style="grid-column: 1 / -1;">
                                    <label for="loanDuration">Durasi Peminjaman</label>
                                    <div class="duration-selector">
                                        <button type="button" class="duration-btn" data-days="1">1 Hari</button>
                                        <button type="button" class="duration-btn" data-days="2">2 Hari</button>
                                        <button type="button" class="duration-btn" data-days="3">3 Hari</button>
                                        <button type="button" class="duration-btn" data-days="4">4 Hari</button>
                                        <button type="button" class="duration-btn" data-days="5">5 Hari</button>
                                        <button type="button" class="duration-btn" data-days="6">6 Hari</button>
                                        <button type="button" class="duration-btn active" data-days="7">7 Hari</button>
                                    </div>
                                    <input type="hidden" id="loanDuration" name="loan_duration" value="7" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="loanNotes">Catatan (Opsional)</label>
                                <textarea id="loanNotes" name="notes" placeholder="Tambahkan catatan jika diperlukan..." rows="3"></textarea>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="btn btn-secondary" onclick="closeRequestLoanModal()">Batal</button>
                            <button type="submit" class="btn btn-primary" id="submitLoanBtn">
                                <i class="fas fa-paper-plane"></i>
                                Ajukan Peminjaman
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const bookId = <?php echo e($book->id); ?>;
        let isWishlisted = <?php echo e($isWishlisted ? 'true' : 'false'); ?>;
        let currentUserRating = <?php echo e($userRating ? $userRating->rating : 'null'); ?>;

        // Ensure stars reflect last user rating on initial load
        document.addEventListener('DOMContentLoaded', function() {
            if (currentUserRating !== null) {
                const stars = document.querySelectorAll('#userRating i');
                stars.forEach((star, index) => {
                    if (index < Number(currentUserRating)) {
                        star.className = 'fas fa-star active';
                    } else {
                        star.className = 'far fa-star';
                    }
                });
            }
        });

        // Switch Tabs
        function switchTab(tabName) {
            // Remove active from all tabs and contents
            document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));

            // Add active to selected
            event.target.classList.add('active');
            document.getElementById(tabName + '-tab').classList.add('active');
        }

        // Show Notification
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'times-circle' : 'exclamation-circle'}"></i>
                <span>${message}</span>
            `;
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        // Rate Book
        function rateBook(rating) {
            // Jika user sudah pernah rating, tampilkan konfirmasi
            if (currentUserRating !== null) {
                Swal.fire({
                    title: 'Ubah Rating?',
                    html: `Anda sudah memberi rating <strong>${currentUserRating}</strong> bintang.<br>Apakah Anda ingin mengubahnya menjadi <strong>${rating}</strong> bintang?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#667eea',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Ubah!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        submitRating(rating);
                    }
                });
            } else {
                // First time rating, langsung submit
                submitRating(rating);
            }
        }

        // Submit rating to server
        function submitRating(rating) {
            fetch('/api/books/' + bookId + '/rate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ rating: rating })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update current rating
                    currentUserRating = rating;
                    
                    // Update stars - tetap terisi
                    document.querySelectorAll('#userRating i').forEach((star, index) => {
                        if (index < rating) {
                            star.className = 'fas fa-star active';
                        } else {
                            star.className = 'far fa-star';
                        }
                    });

                    // Show success with SweetAlert
                    Swal.fire({
                        title: 'Berhasil!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonColor: '#667eea',
                        timer: 2000,
                        showConfirmButton: false
                    });

                    // Reload after delay to update average
                    setTimeout(() => location.reload(), 2000);
                } else {
                    Swal.fire({
                        title: 'Gagal!',
                        text: data.message,
                        icon: 'error',
                        confirmButtonColor: '#ef4444'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat menyimpan rating',
                    icon: 'error',
                    confirmButtonColor: '#ef4444'
                });
            });
        }

        // Toggle Wishlist
        function toggleWishlist() {
            fetch('/api/books/' + bookId + '/wishlist', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    isWishlisted = data.wishlisted;
                    const btn = document.querySelector('.btn-wishlist');
                    const text = document.getElementById('wishlistText');
                    
                    if (isWishlisted) {
                        btn.classList.add('active');
                        text.textContent = 'Hapus dari Wishlist';
                    } else {
                        btn.classList.remove('active');
                        text.textContent = 'Tambah ke Wishlist';
                    }
                    
                    showNotification(data.message, 'success');
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                showNotification('Terjadi kesalahan', 'error');
            });
        }

        // Submit Comment
        function submitComment(event) {
            event.preventDefault();
            
            const commentText = document.getElementById('commentText').value;
            
            fetch('/api/books/' + bookId + '/comments', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ comment: commentText })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    document.getElementById('commentText').value = '';
                    
                    // Reload to show new comment
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                showNotification('Terjadi kesalahan', 'error');
            });
        }

        // Request Loan - Open modal on same page
        function requestLoan() {
            openLoanModal();
        }

        // ===== LOAN MODAL FUNCTIONS =====
        let qrCodeReader = null;
        let qrVideoStream = null;
        let qrDecodeControls = null;
        let photoVideoStream = null;
        let currentCapturedPhoto = null;
        let lastQrParsed = { fullName: null, studentClass: null, major: null, nisn: null, nis: null };

        // Initialize QR Code Reader
        function initializeQRReader() {
            if (typeof ZXing !== 'undefined') {
                qrCodeReader = new ZXing.BrowserQRCodeReader();
            }
        }

        // Open loan modal and load book details
        function openLoanModal() {
            fetch(`/api/books/${bookId}`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const book = data.book;
                    const bookPreview = document.getElementById('bookPreview');
                    
                    bookPreview.innerHTML = `
                        <div class="preview-cover">
                            ${book.cover_image ? 
                                `<img src="${book.cover_image.startsWith('http') ? book.cover_image : '/' + book.cover_image}" alt="${book.title}">` : 
                                '<i class="fas fa-book"></i>'
                            }
                        </div>
                        <div class="preview-info">
                            <h3 class="preview-title">${book.title}</h3>
                            <p class="preview-author">oleh ${book.author}</p>
                            <div class="preview-details">
                                <div class="preview-detail">
                                    <i class="fas fa-tag"></i>
                                    <span>${book.category?.name || 'Umum'}</span>
                                </div>
                                <div class="preview-detail">
                                    <i class="fas fa-calendar"></i>
                                    <span>${book.publication_year || 'N/A'}</span>
                                </div>
                                <div class="preview-detail">
                                    <i class="fas fa-copy"></i>
                                    <span>${book.available} tersedia</span>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    document.getElementById('loanRequestForm').dataset.bookId = bookId;
                    document.getElementById('requestLoanModal').classList.add('active');
                } else {
                    showNotification('Gagal memuat detail buku', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Gagal memuat detail buku', 'error');
            });
        }

        // Switch between QR and Manual tabs
        function switchLoanTab(tabName) {
            document.querySelectorAll('.tab-navigation .tab-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
            
            if (tabName === 'qr-scan') {
                document.getElementById('qr-tab-btn').classList.add('active');
                document.getElementById('qr-scan-tab').classList.add('active');
            } else {
                document.getElementById('manual-tab-btn').classList.add('active');
                document.getElementById('manual-input-tab').classList.add('active');
            }
            
            stopQRScanner();
        }

        // QR Scanner Functions
        async function startQRScanner() {
            stopQRScanner();
            
            try {
                const video = document.getElementById('qrVideo');
                
                if (!qrCodeReader) {
                    initializeQRReader();
                }
                
                if (!qrCodeReader) {
                    throw new Error('QR Code reader tidak tersedia');
                }

                const constraints = {
                    video: { facingMode: 'environment' }
                };
                
                qrVideoStream = await navigator.mediaDevices.getUserMedia(constraints);
                video.srcObject = qrVideoStream;
                
                qrDecodeControls = qrCodeReader.decodeFromVideoDevice(undefined, video, (result, error) => {
                    if (result) {
                        handleQRScanResult(result.text);
                    }
                    if (error && !(error instanceof ZXing.NotFoundException)) {
                        console.error('QR Scan Error:', error);
                    }
                });
            } catch (error) {
                console.error('Error starting QR scanner:', error);
                showNotification('Tidak bisa mengakses kamera', 'error');
            }
        }

        function stopQRScanner() {
            if (qrVideoStream) {
                qrVideoStream.getTracks().forEach(track => track.stop());
                qrVideoStream = null;
            }
            
            if (qrCodeReader) {
                try { qrCodeReader.reset(); } catch (e) { }
            }
            
            if (qrDecodeControls && typeof qrDecodeControls.stop === 'function') {
                try { qrDecodeControls.stop(); } catch (e) { }
                qrDecodeControls = null;
            }
            
            const video = document.getElementById('qrVideo');
            if (video) video.srcObject = null;
        }

        function handleQRScanResult(data) {
            document.getElementById('qrData').value = data;
            document.getElementById('qrResult').style.display = 'block';
            
            try {
                const parsed = JSON.parse(data);
                lastQrParsed.fullName = parsed.fullName || parsed.nama || parsed.name || null;
                lastQrParsed.studentClass = parsed.studentClass || parsed.kelas || null;
                lastQrParsed.major = parsed.major || parsed.jurusan || null;
                lastQrParsed.nisn = parsed.nisn || null;
                lastQrParsed.nis = parsed.nis || null;
                
                const setText = (id, val) => {
                    const el = document.getElementById(id);
                    if (el) el.textContent = val || '—';
                };
                
                setText('qrVerifyFullName', lastQrParsed.fullName);
                setText('qrVerifyStudentClass', lastQrParsed.studentClass);
                setText('qrVerifyMajor', lastQrParsed.major);
                setText('qrVerifyNisn', lastQrParsed.nisn);
                setText('qrVerifyNis', lastQrParsed.nis);
                
                showNotification('Data QR berhasil dipindai', 'success');
            } catch (e) {
                showNotification('Data QR berhasil dipindai', 'success');
            }
            
            stopQRScanner();
        }

        // Photo Capture Functions
        async function startPhotoCapture() {
            closePhotoModal();
            
            try {
                const video = document.getElementById('photoVideo');
                const constraints = {
                    video: { width: { ideal: 1280 }, height: { ideal: 720 } }
                };
                
                photoVideoStream = await navigator.mediaDevices.getUserMedia(constraints);
                video.srcObject = photoVideoStream;
                document.getElementById('photoModal').style.display = 'flex';
            } catch (error) {
                console.error('Error starting photo capture:', error);
                showNotification('Tidak bisa mengakses kamera', 'error');
            }
        }

        function capturePhoto() {
            const video = document.getElementById('photoVideo');
            const canvas = document.getElementById('photoCanvas');
            
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            
            const ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            
            currentCapturedPhoto = canvas.toDataURL('image/jpeg', 0.8);
            
            const preview = document.getElementById('photoPreview');
            preview.innerHTML = `<img src="${currentCapturedPhoto}" alt="Captured Photo">`;
            
            document.getElementById('retakeBtn').style.display = 'inline-flex';
            
            closePhotoModal();
        }

        function retakePhoto() {
            currentCapturedPhoto = null;
            document.getElementById('photoPreview').innerHTML = `
                <i class="fas fa-user-circle"></i>
                <p>Belum ada foto</p>
            `;
            document.getElementById('retakeBtn').style.display = 'none';
            startPhotoCapture();
        }

        function closePhotoModal() {
            if (photoVideoStream) {
                photoVideoStream.getTracks().forEach(track => track.stop());
                photoVideoStream = null;
            }
            
            const video = document.getElementById('photoVideo');
            if (video) video.srcObject = null;
            
            document.getElementById('photoModal').style.display = 'none';
        }

        // Duration button handlers
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('duration-btn')) {
                document.querySelectorAll('.duration-btn').forEach(btn => btn.classList.remove('active'));
                e.target.classList.add('active');
                document.getElementById('loanDuration').value = e.target.dataset.days;
            }
        });

        // Form submission
        const loanForm = document.getElementById('loanRequestForm');
        if (loanForm) {
            loanForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const bookId = this.dataset.bookId;
                const loanDuration = document.getElementById('loanDuration').value;
                const notes = document.getElementById('loanNotes').value;
                
                let identificationMethod = 'manual_input';
                const activeBtn = document.querySelector('.tab-btn.active');
                if (activeBtn) {
                    identificationMethod = activeBtn.id === 'qr-tab-btn' ? 'qr_scan' : 'manual_input';
                }
                
                let nisn = null, nis = null, fullName = null, studentClass = null, major = null, qrData = null;
                
                if (identificationMethod === 'qr_scan') {
                    qrData = document.getElementById('qrData').value;
                    fullName = lastQrParsed.fullName;
                    studentClass = lastQrParsed.studentClass;
                    major = lastQrParsed.major;
                    nisn = lastQrParsed.nisn;
                    nis = lastQrParsed.nis;
                } else {
                    fullName = document.getElementById('fullName').value || null;
                    studentClass = document.getElementById('studentClass').value || null;
                    major = document.getElementById('major').value || null;
                    nisn = document.getElementById('nisn').value || null;
                    nis = document.getElementById('nis').value || null;
                }
                
                if (identificationMethod === 'qr_scan' && !qrData) {
                    showNotification('Silakan scan QR code terlebih dahulu', 'warning');
                    return;
                }
                if (!fullName) {
                    showNotification('Nama lengkap harus diisi', 'warning');
                    return;
                }
                if (!studentClass) {
                    showNotification('Kelas harus diisi', 'warning');
                    return;
                }
                if (!major) {
                    showNotification('Jurusan harus diisi', 'warning');
                    return;
                }
                if (!currentCapturedPhoto) {
                    showNotification('Silakan ambil foto peminjam terlebih dahulu', 'warning');
                    return;
                }
                
                const formData = {
                    book_id: bookId,
                    loan_duration: loanDuration,
                    notes: notes,
                    full_name: fullName,
                    student_class: studentClass,
                    major: major,
                    nisn: nisn,
                    nis: nis,
                    borrower_photo: currentCapturedPhoto,
                    qr_data: qrData,
                    identification_method: identificationMethod
                };
                
                const submitBtn = document.getElementById('submitLoanBtn');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
                submitBtn.disabled = true;
                
                fetch('/api/request-loan', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification(data.message, 'success');
                        closeRequestLoanModal();
                        this.reset();
                        resetLoanForm();
                    } else {
                        showNotification(data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Terjadi kesalahan. Silakan coba lagi.', 'error');
                })
                .finally(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                });
            });
        }

        // Reset loan form
        function resetLoanForm() {
            currentCapturedPhoto = null;
            document.getElementById('photoPreview').innerHTML = `
                <i class="fas fa-user-circle"></i>
                <p>Belum ada foto</p>
            `;
            document.getElementById('retakeBtn').style.display = 'none';
            
            document.getElementById('qrResult').style.display = 'none';
            document.getElementById('qrData').value = '';
            lastQrParsed = { fullName: null, studentClass: null, major: null, nisn: null, nis: null };
            
            ['qrVerifyFullName','qrVerifyStudentClass','qrVerifyMajor','qrVerifyNisn','qrVerifyNis']
                .forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.textContent = '—';
                });
            
            document.getElementById('fullName').value = '';
            document.getElementById('studentClass').value = '';
            document.getElementById('major').value = '';
            document.getElementById('nisn').value = '';
            document.getElementById('nis').value = '';
            
            document.querySelectorAll('.duration-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelector('.duration-btn[data-days="7"]').classList.add('active');
            document.getElementById('loanDuration').value = '7';
            
            document.getElementById('loanNotes').value = '';
            
            switchLoanTab('qr-scan');
            stopQRScanner();
            closePhotoModal();
        }

        // Close modal
        function closeRequestLoanModal() {
            document.getElementById('requestLoanModal').classList.remove('active');
            resetLoanForm();
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal-overlay')) {
                e.target.classList.remove('active');
                resetLoanForm();
            }
        });

        // Initialize QR reader on page load
        document.addEventListener('DOMContentLoaded', function() {
            initializeQRReader();
        });
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\Perpustakaan1_project\resources\views/dashboard/book-detail.blade.php ENDPATH**/ ?>