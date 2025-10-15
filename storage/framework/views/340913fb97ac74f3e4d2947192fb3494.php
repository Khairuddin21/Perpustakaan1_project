<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Kelola Buku - <?php echo e(config('app.name', 'Sistem Perpustakaan')); ?></title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Custom Styles -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/dashboard.css', 'resources/js/dashboard.js']); ?>
    
    <style>
        .books-management-container {
            padding: 2rem;
        }
        
        .btn-logout {
            background: none;
            border: none;
            color: #64748b;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-family: 'Inter', sans-serif;
            font-weight: 500;
        }
        
        .btn-logout:hover {
            background: #fee2e2;
            color: #ef4444;
        }
        
        /* Header Section */
        .page-header {
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1.5rem;
            border: 2px solid #e2e8f0;
        }
        
        .header-left h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .header-left h1 i {
            color: #6366f1;
        }
        
        .header-left p {
            color: #64748b;
            font-size: 1rem;
            margin: 0;
        }
        
        .header-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        
        .btn-add {
            padding: 0.875rem 1.5rem;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            border: none;
            border-radius: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
            text-decoration: none;
            font-size: 0.95rem;
        }
        
        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
        }
        
        .btn-add i {
            font-size: 1.1rem;
        }
        
        /* Statistics Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            border: 2px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-color: #6366f1;
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }
        
        .stat-icon.purple {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
        }
        
        .stat-icon.green {
            background: linear-gradient(135deg, #10b981, #059669);
        }
        
        .stat-icon.blue {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
        }
        
        .stat-icon.orange {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }
        
        .stat-content h3 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 0.25rem;
        }
        
        .stat-content p {
            color: #64748b;
            font-size: 0.95rem;
            margin: 0;
        }
        
        /* Filter Section */
        .filter-section {
            background: white;
            padding: 1.5rem;
            border-radius: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            border: 2px solid #e2e8f0;
            margin-bottom: 2rem;
        }
        
        .filter-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr auto;
            gap: 1rem;
            align-items: end;
        }
        
        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .filter-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: #475569;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .filter-input, .filter-select {
            padding: 0.875rem 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 0.75rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: white;
            font-family: 'Inter', sans-serif;
        }
        
        .filter-input:focus, .filter-select:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }
        
        .btn-filter, .btn-reset {
            padding: 0.875rem 1.5rem;
            border: none;
            border-radius: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-family: 'Inter', sans-serif;
        }
        
        .btn-filter {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            box-shadow: 0 2px 8px rgba(99, 102, 241, 0.3);
        }
        
        .btn-filter:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4);
        }
        
        .btn-reset {
            background: #f1f5f9;
            color: #475569;
        }
        
        .btn-reset:hover {
            background: #e2e8f0;
        }
        
        /* Books Gallery Grid */
        .books-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 1.25rem;
            margin-bottom: 2rem;
        }
        
        .book-card {
            background: white;
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            border: 2px solid #e2e8f0;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }
        
        .book-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            border-color: #6366f1;
        }
        
        .book-cover {
            position: relative;
            height: 240px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            overflow: hidden;
        }
        
        .book-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .book-card:hover .book-cover img {
            transform: scale(1.05);
        }
        
        .book-status {
            position: absolute;
            top: 0.75rem;
            right: 0.75rem;
            padding: 0.375rem 0.75rem;
            border-radius: 2rem;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .book-status.available {
            background: #10b981;
            color: white;
        }
        
        .book-status.unavailable {
            background: #ef4444;
            color: white;
        }
        
        .book-content {
            padding: 1rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        
        .book-category {
            display: inline-block;
            padding: 0.25rem 0.625rem;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            border-radius: 2rem;
            font-size: 0.7rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            width: fit-content;
        }
        
        .book-title {
            font-size: 1rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 0.375rem;
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .book-author {
            color: #64748b;
            font-size: 0.8rem;
            margin: 0 0 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }
        
        .book-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem;
            margin: 0.75rem 0;
            padding-top: 0.75rem;
            border-top: 2px solid #f1f5f9;
        }
        
        .book-info-item {
            display: flex;
            flex-direction: column;
            gap: 0.125rem;
        }
        
        .book-info-label {
            font-size: 0.65rem;
            color: #64748b;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .book-info-value {
            font-size: 0.875rem;
            font-weight: 700;
            color: #1e293b;
        }
        
        .book-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem;
            margin-top: auto;
        }
        
        .btn-edit, .btn-delete {
            padding: 0.625rem;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.375rem;
            font-size: 0.8rem;
        }
        
        .btn-edit {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
        }
        
        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }
        
        .btn-delete {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }
        
        .btn-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
        }
        
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(8px);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            overflow-y: auto;
        }
        
        .modal.active {
            display: flex;
        }
        
        .modal-content {
            background: white;
            border-radius: 1rem;
            max-width: 700px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: modalSlideIn 0.3s ease;
        }
        
        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .modal-header {
            padding: 2rem;
            border-bottom: 2px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .modal-header h2 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .modal-header h2 i {
            color: #6366f1;
        }
        
        .btn-close {
            width: 40px;
            height: 40px;
            border: none;
            background: #f1f5f9;
            border-radius: 0.75rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            font-size: 1.25rem;
            color: #475569;
        }
        
        .btn-close:hover {
            background: #e2e8f0;
            transform: rotate(90deg);
        }
        
        .modal-body {
            padding: 2rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #475569;
            margin-bottom: 0.5rem;
        }
        
        .form-label.required::after {
            content: " *";
            color: #f56565;
        }
        
        .form-input, .form-textarea, .form-select {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 0.75rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
        }
        
        .form-input:focus, .form-textarea:focus, .form-select:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }
        
        .form-textarea {
            resize: vertical;
            min-height: 120px;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        
        .file-upload {
            position: relative;
            border: 2px dashed #e2e8f0;
            border-radius: 0.75rem;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .file-upload:hover {
            border-color: #6366f1;
            background: rgba(99, 102, 241, 0.05);
        }
        
        .file-upload input {
            display: none;
        }
        
        .file-upload-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.75rem;
        }
        
        .file-upload-icon {
            font-size: 2.5rem;
            color: #6366f1;
        }
        
        .file-upload-text {
            color: #64748b;
            font-size: 0.95rem;
        }
        
        .file-upload-text strong {
            color: #6366f1;
        }
        
        .upload-tabs {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1rem;
            border-bottom: 2px solid #e2e8f0;
        }
        
        .upload-tab {
            padding: 0.75rem 1.5rem;
            background: none;
            border: none;
            color: #64748b;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border-bottom: 2px solid transparent;
            margin-bottom: -2px;
        }
        
        .upload-tab.active {
            color: #6366f1;
            border-bottom-color: #6366f1;
        }
        
        .upload-tab:hover {
            color: #6366f1;
        }
        
        .upload-option {
            display: none;
        }
        
        .upload-option.active {
            display: block;
        }
        
        .url-input-group {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }
        
        .url-input {
            flex: 1;
            padding: 0.75rem 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 0.5rem;
            font-size: 0.9rem;
        }
        
        .url-input:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }
        
        .btn-load-image {
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-load-image:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4);
        }
        
        .image-preview {
            margin-top: 1rem;
            display: none;
        }
        
        .image-preview.active {
            display: block;
        }
        
        .image-preview img {
            max-width: 100%;
            max-height: 200px;
            border-radius: 0.75rem;
            object-fit: cover;
        }
        
        .modal-footer {
            padding: 1.5rem 2rem;
            border-top: 2px solid #f1f5f9;
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
        }
        
        .btn-cancel, .btn-submit {
            padding: 0.875rem 2rem;
            border: none;
            border-radius: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
            font-size: 0.95rem;
        }
        
        .btn-cancel {
            background: #f1f5f9;
            color: #475569;
        }
        
        .btn-cancel:hover {
            background: #e2e8f0;
        }
        
        .btn-submit {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            box-shadow: 0 2px 8px rgba(99, 102, 241, 0.3);
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4);
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: white;
            border-radius: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            border: 2px solid #e2e8f0;
        }
        
        .empty-state-icon {
            font-size: 5rem;
            color: #cbd5e1;
            margin-bottom: 1.5rem;
        }
        
        .empty-state h3 {
            font-size: 1.5rem;
            color: #475569;
            margin: 0 0 0.5rem;
        }
        
        .empty-state p {
            color: #94a3b8;
            margin: 0;
        }
        
        /* Custom Pagination */
        .pagination-wrapper {
            margin-top: 2rem;
            background: white;
            padding: 1.5rem 2rem;
            border-radius: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            border: 2px solid #e2e8f0;
        }
        
        .pagination-info {
            text-align: center;
            margin-bottom: 1rem;
            color: #64748b;
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .pagination-controls {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            flex-wrap: wrap;
        }
        
        .pagination-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 0.75rem;
            color: #475569;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .pagination-btn:hover {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            border-color: #6366f1;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }
        
        .pagination-btn.disabled {
            background: #f1f5f9;
            color: #cbd5e1;
            border-color: #e2e8f0;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        
        .pagination-btn i {
            font-size: 0.875rem;
        }
        
        .pagination-numbers {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .pagination-number {
            min-width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 0.75rem;
            color: #475569;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .pagination-number:hover {
            background: #f8fafc;
            border-color: #6366f1;
            color: #6366f1;
            transform: translateY(-2px);
        }
        
        .pagination-number.active {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            border-color: #6366f1;
            cursor: default;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }
        
        .pagination-dots {
            color: #94a3b8;
            font-weight: 600;
            padding: 0 0.25rem;
            user-select: none;
        }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .filter-grid {
                grid-template-columns: 1fr 1fr;
            }
            
            .books-gallery {
                grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            }
        }
        
        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                text-align: center;
            }
            
            .header-left h1 {
                font-size: 2rem;
                justify-content: center;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .filter-grid {
                grid-template-columns: 1fr;
            }
            
            .books-gallery {
                grid-template-columns: 1fr;
            }
            
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .pagination-wrapper {
                padding: 1rem;
            }
            
            .pagination-btn span {
                display: none;
            }
            
            .pagination-btn {
                padding: 0.625rem;
            }
            
            .pagination-number {
                min-width: 36px;
                height: 36px;
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <?php echo $__env->make('components.admin-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        
        <!-- Main Content -->
        <main class="main-content" id="mainContent">
            <!-- Header -->
            <header class="header">
                <div class="header-content">
                    <button class="menu-toggle" id="menuToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <h1 class="header-title">Kelola Buku</h1>
                    
                    <div class="header-actions">
                        <div class="user-info">
                            <div class="user-avatar">
                                <?php echo e(strtoupper(substr(auth()->user()->name, 0, 2))); ?>

                            </div>
                            <div class="user-details">
                                <div class="user-name"><?php echo e(auth()->user()->name); ?></div>
                                <div class="user-role"><?php echo e(ucfirst(auth()->user()->role)); ?></div>
                            </div>
                        </div>
                        
                        <form method="POST" action="<?php echo e(route('logout')); ?>" style="display: inline;">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn-logout">
                                <i class="fas fa-sign-out-alt"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>
            
            <!-- Books Management Content -->
    <div class="books-management-container">
        <!-- Page Header -->
        <div class="page-header">
            <div class="header-left">
                <h1>
                    <i class="fas fa-book-open"></i>
                    Kelola Buku
                </h1>
                <p>Manajemen koleksi buku perpustakaan</p>
            </div>
            <div class="header-actions">
                <button class="btn-add" onclick="openAddModal()">
                    <i class="fas fa-plus-circle"></i>
                    Tambah Buku Baru
                </button>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="fas fa-book"></i>
                </div>
                <div class="stat-content">
                    <h3><?php echo e($totalBooks); ?></h3>
                    <p>Total Buku</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <h3><?php echo e($availableBooks); ?></h3>
                    <p>Buku Tersedia</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div class="stat-content">
                    <h3><?php echo e($totalStock); ?></h3>
                    <p>Total Stok</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon orange">
                    <i class="fas fa-tags"></i>
                </div>
                <div class="stat-content">
                    <h3><?php echo e($categoriesCount); ?></h3>
                    <p>Kategori</p>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <form method="GET" action="<?php echo e(route('admin.books.index')); ?>" id="filterForm">
                <div class="filter-grid">
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fas fa-search"></i>
                            Cari Buku
                        </label>
                        <input type="text" name="search" class="filter-input" placeholder="Judul, penulis, ISBN, atau penerbit..." value="<?php echo e(request('search')); ?>">
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fas fa-tag"></i>
                            Kategori
                        </label>
                        <select name="category" class="filter-select">
                            <option value="">Semua Kategori</option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>" <?php echo e(request('category') == $category->id ? 'selected' : ''); ?>>
                                    <?php echo e($category->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fas fa-circle-check"></i>
                            Ketersediaan
                        </label>
                        <select name="availability" class="filter-select">
                            <option value="">Semua</option>
                            <option value="available" <?php echo e(request('availability') == 'available' ? 'selected' : ''); ?>>Tersedia</option>
                            <option value="unavailable" <?php echo e(request('availability') == 'unavailable' ? 'selected' : ''); ?>>Tidak Tersedia</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fas fa-sort"></i>
                            Urutkan
                        </label>
                        <select name="sort" class="filter-select">
                            <option value="created_at" <?php echo e(request('sort') == 'created_at' ? 'selected' : ''); ?>>Terbaru</option>
                            <option value="title" <?php echo e(request('sort') == 'title' ? 'selected' : ''); ?>>Judul</option>
                            <option value="author" <?php echo e(request('sort') == 'author' ? 'selected' : ''); ?>>Penulis</option>
                            <option value="published_year" <?php echo e(request('sort') == 'published_year' ? 'selected' : ''); ?>>Tahun Terbit</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-filter">
                        <i class="fas fa-filter"></i>
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Books Gallery -->
        <?php if($books->count() > 0): ?>
            <div class="books-gallery">
                <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="book-card">
                        <div class="book-cover">
                            <img src="<?php echo e(asset($book->cover_image ?? 'Gambar/default-book.jpg')); ?>" alt="<?php echo e($book->title); ?>">
                            <span class="book-status <?php echo e($book->available > 0 ? 'available' : 'unavailable'); ?>">
                                <?php echo e($book->available > 0 ? 'Tersedia' : 'Habis'); ?>

                            </span>
                        </div>
                        <div class="book-content">
                            <span class="book-category"><?php echo e($book->category->name); ?></span>
                            <h3 class="book-title"><?php echo e($book->title); ?></h3>
                            <p class="book-author">
                                <i class="fas fa-user-edit"></i>
                                <?php echo e($book->author); ?>

                            </p>
                            <div class="book-info">
                                <div class="book-info-item">
                                    <span class="book-info-label">Penerbit</span>
                                    <span class="book-info-value"><?php echo e(Str::limit($book->publisher, 15)); ?></span>
                                </div>
                                <div class="book-info-item">
                                    <span class="book-info-label">Tahun</span>
                                    <span class="book-info-value"><?php echo e($book->published_year); ?></span>
                                </div>
                                <div class="book-info-item">
                                    <span class="book-info-label">ISBN</span>
                                    <span class="book-info-value"><?php echo e($book->isbn); ?></span>
                                </div>
                                <div class="book-info-item">
                                    <span class="book-info-label">Stok</span>
                                    <span class="book-info-value"><?php echo e($book->stock); ?> / <?php echo e($book->available); ?></span>
                                </div>
                            </div>
                            <div class="book-actions">
                                <button class="btn-edit" onclick="editBook(<?php echo e($book->id); ?>)">
                                    <i class="fas fa-edit"></i>
                                    Edit
                                </button>
                                <button class="btn-delete" onclick="deleteBook(<?php echo e($book->id); ?>)">
                                    <i class="fas fa-trash"></i>
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Custom Pagination -->
            <?php if($books->hasPages()): ?>
            <div class="pagination-wrapper">
                <div class="pagination-info">
                    <span>Menampilkan <?php echo e($books->firstItem()); ?> - <?php echo e($books->lastItem()); ?> dari <?php echo e($books->total()); ?> buku</span>
                </div>
                <div class="pagination-controls">
                    
                    <?php if($books->onFirstPage()): ?>
                        <button class="pagination-btn disabled" disabled>
                            <i class="fas fa-chevron-left"></i>
                            <span>Sebelumnya</span>
                        </button>
                    <?php else: ?>
                        <a href="<?php echo e($books->previousPageUrl()); ?>" class="pagination-btn">
                            <i class="fas fa-chevron-left"></i>
                            <span>Sebelumnya</span>
                        </a>
                    <?php endif; ?>

                    
                    <div class="pagination-numbers">
                        <?php
                            $currentPage = $books->currentPage();
                            $lastPage = $books->lastPage();
                            $range = 2;
                            $start = max(1, $currentPage - $range);
                            $end = min($lastPage, $currentPage + $range);
                        ?>

                        
                        <?php if($start > 1): ?>
                            <a href="<?php echo e($books->url(1)); ?>" class="pagination-number">1</a>
                            <?php if($start > 2): ?>
                                <span class="pagination-dots">...</span>
                            <?php endif; ?>
                        <?php endif; ?>

                        
                        <?php for($i = $start; $i <= $end; $i++): ?>
                            <?php if($i == $currentPage): ?>
                                <span class="pagination-number active"><?php echo e($i); ?></span>
                            <?php else: ?>
                                <a href="<?php echo e($books->url($i)); ?>" class="pagination-number"><?php echo e($i); ?></a>
                            <?php endif; ?>
                        <?php endfor; ?>

                        
                        <?php if($end < $lastPage): ?>
                            <?php if($end < $lastPage - 1): ?>
                                <span class="pagination-dots">...</span>
                            <?php endif; ?>
                            <a href="<?php echo e($books->url($lastPage)); ?>" class="pagination-number"><?php echo e($lastPage); ?></a>
                        <?php endif; ?>
                    </div>

                    
                    <?php if($books->hasMorePages()): ?>
                        <a href="<?php echo e($books->nextPageUrl()); ?>" class="pagination-btn">
                            <span>Selanjutnya</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    <?php else: ?>
                        <button class="pagination-btn disabled" disabled>
                            <span>Selanjutnya</span>
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <h3>Tidak Ada Buku Ditemukan</h3>
                <p><?php echo e(request('search') ? 'Coba ubah kata kunci pencarian Anda' : 'Mulai tambahkan buku pertama Anda'); ?></p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Add/Edit Book Modal -->
    <div class="modal" id="bookModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>
                    <i class="fas fa-book"></i>
                    <span id="modalTitle">Tambah Buku Baru</span>
                </h2>
                <button class="btn-close" onclick="closeModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="bookForm" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <input type="hidden" id="bookId" name="book_id">
                <input type="hidden" id="formMethod" value="POST">
                
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label required">Judul Buku</label>
                        <input type="text" name="title" id="title" class="form-input" placeholder="Masukkan judul buku" required>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label required">Penulis</label>
                            <input type="text" name="author" id="author" class="form-input" placeholder="Nama penulis" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label required">ISBN</label>
                            <input type="text" name="isbn" id="isbn" class="form-input" placeholder="ISBN buku" required>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label required">Kategori</label>
                            <select name="category_id" id="category_id" class="form-select" required>
                                <option value="">Pilih Kategori</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label required">Stok</label>
                            <input type="number" name="stock" id="stock" class="form-input" placeholder="Jumlah stok" min="0" required>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label required">Penerbit</label>
                            <input type="text" name="publisher" id="publisher" class="form-input" placeholder="Nama penerbit" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label required">Tahun Terbit</label>
                            <input type="number" name="published_year" id="published_year" class="form-input" placeholder="Tahun terbit" min="1900" max="<?php echo e(date('Y') + 1); ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" id="description" class="form-textarea" placeholder="Deskripsi buku (opsional)"></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Cover Buku</label>
                        
                        <!-- Upload Tabs -->
                        <div class="upload-tabs">
                            <button type="button" class="upload-tab active" onclick="switchUploadTab('file')">
                                <i class="fas fa-upload"></i> Upload File
                            </button>
                            <button type="button" class="upload-tab" onclick="switchUploadTab('url')">
                                <i class="fas fa-link"></i> URL Gambar
                            </button>
                        </div>
                        
                        <!-- Upload File Option -->
                        <div class="upload-option active" id="uploadFile">
                            <div class="file-upload" onclick="document.getElementById('cover_image').click()">
                                <input type="file" name="cover_image" id="cover_image" accept="image/*" onchange="previewImageFile(event)">
                                <div class="file-upload-content">
                                    <i class="fas fa-cloud-upload-alt file-upload-icon"></i>
                                    <p class="file-upload-text">
                                        <strong>Klik untuk upload</strong> atau drag & drop<br>
                                        <small>PNG, JPG, GIF (max. 2MB)</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- URL Option -->
                        <div class="upload-option" id="uploadUrl">
                            <div class="url-input-group">
                                <input type="text" id="imageUrl" class="url-input" placeholder="https://example.com/image.jpg">
                                <button type="button" class="btn-load-image" onclick="loadImageFromUrl()">
                                    <i class="fas fa-download"></i> Muat Gambar
                                </button>
                            </div>
                            <p style="font-size: 0.85rem; color: #64748b; margin: 0;">
                                <i class="fas fa-info-circle"></i> Salin link gambar dari internet dan paste di sini
                            </p>
                        </div>
                        
                        <input type="hidden" name="cover_image_url" id="cover_image_url">
                        
                        <div class="image-preview" id="imagePreview">
                            <img id="previewImg" src="" alt="Preview">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save"></i>
                        Simpan Buku
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // CSRF Token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Switch Upload Tab
        function switchUploadTab(tab) {
            // Update tabs
            document.querySelectorAll('.upload-tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.upload-option').forEach(o => o.classList.remove('active'));
            
            if (tab === 'file') {
                document.querySelector('.upload-tab:first-child').classList.add('active');
                document.getElementById('uploadFile').classList.add('active');
            } else {
                document.querySelector('.upload-tab:last-child').classList.add('active');
                document.getElementById('uploadUrl').classList.add('active');
            }
        }

        // Load Image from URL
        function loadImageFromUrl() {
            const url = document.getElementById('imageUrl').value.trim();
            
            if (!url) {
                Swal.fire('Error!', 'Masukkan URL gambar terlebih dahulu', 'error');
                return;
            }
            
            // Validate URL
            try {
                new URL(url);
            } catch (e) {
                Swal.fire('Error!', 'URL tidak valid', 'error');
                return;
            }
            
            // Set preview
            const img = new Image();
            img.onload = function() {
                document.getElementById('previewImg').src = url;
                document.getElementById('cover_image_url').value = url;
                document.getElementById('imagePreview').classList.add('active');
                Swal.fire('Berhasil!', 'Gambar berhasil dimuat', 'success');
            };
            img.onerror = function() {
                Swal.fire('Error!', 'Gagal memuat gambar dari URL', 'error');
            };
            img.src = url;
        }

        // Open Add Modal
        function openAddModal() {
            document.getElementById('modalTitle').textContent = 'Tambah Buku Baru';
            document.getElementById('bookForm').reset();
            document.getElementById('bookId').value = '';
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('imagePreview').classList.remove('active');
            document.getElementById('imageUrl').value = '';
            document.getElementById('cover_image_url').value = '';
            switchUploadTab('file');
            document.getElementById('bookModal').classList.add('active');
        }

        // Edit Book
        async function editBook(id) {
            try {
                const response = await fetch(`/admin/books/${id}/edit`, {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    const book = data.book;
                    
                    document.getElementById('modalTitle').textContent = 'Edit Buku';
                    document.getElementById('bookId').value = book.id;
                    document.getElementById('formMethod').value = 'PUT';
                    document.getElementById('title').value = book.title;
                    document.getElementById('author').value = book.author;
                    document.getElementById('isbn').value = book.isbn;
                    document.getElementById('category_id').value = book.category_id;
                    document.getElementById('stock').value = book.stock;
                    document.getElementById('publisher').value = book.publisher;
                    document.getElementById('published_year').value = book.published_year;
                    document.getElementById('description').value = book.description || '';
                    
                    if (book.cover_image) {
                        document.getElementById('previewImg').src = `/${book.cover_image}`;
                        document.getElementById('imagePreview').classList.add('active');
                    }
                    
                    switchUploadTab('file');
                    document.getElementById('bookModal').classList.add('active');
                } else {
                    Swal.fire('Error!', data.message || 'Gagal mengambil data buku', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire('Error!', 'Terjadi kesalahan saat mengambil data buku', 'error');
            }
        }

        // Delete Book
        function deleteBook(id) {
            Swal.fire({
                title: 'Hapus Buku?',
                text: 'Apakah Anda yakin ingin menghapus buku ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f56565',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const response = await fetch(`/admin/books/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            }
                        });

                        const data = await response.json();

                        if (data.success) {
                            Swal.fire('Terhapus!', data.message, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error!', data.message, 'error');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        Swal.fire('Error!', 'Terjadi kesalahan saat menghapus buku', 'error');
                    }
                }
            });
        }

        // Close Modal
        function closeModal() {
            document.getElementById('bookModal').classList.remove('active');
        }

        // Preview Image from File
        function previewImageFile(event) {
            const file = event.target.files[0];
            if (file) {
                // Clear URL input
                document.getElementById('imageUrl').value = '';
                document.getElementById('cover_image_url').value = '';
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImg').src = e.target.result;
                    document.getElementById('imagePreview').classList.add('active');
                };
                reader.readAsDataURL(file);
            }
        }

        // Form Submit
        document.getElementById('bookForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const bookId = document.getElementById('bookId').value;
            const method = document.getElementById('formMethod').value;
            const formData = new FormData(this);

            const url = bookId ? `/admin/books/${bookId}` : '/admin/books';

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    // Close modal immediately
                    closeModal();
                    
                    // Show success notification
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    let errorMessage = data.message || 'Terjadi kesalahan';
                    if (data.errors) {
                        errorMessage = Object.values(data.errors).flat().join('<br>');
                    }
                    Swal.fire('Error!', errorMessage, 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire('Error!', 'Terjadi kesalahan saat menyimpan data', 'error');
            }
        });

        // Close modal on outside click
        document.getElementById('bookModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // ESC key to close modal
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    </script>
        </main>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\PERPUSTAKAAN\resources\views/dashboard/admin-books.blade.php ENDPATH**/ ?>