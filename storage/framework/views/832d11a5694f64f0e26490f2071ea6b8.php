<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Pengembalian Buku - <?php echo e(config('app.name', 'Sistem Perpustakaan')); ?></title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Custom Styles -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/dashboard.css']); ?>
    
    <style>
        .loan-requests-container {
            padding: 2rem;
        }
        
        .page-header {
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.25rem;
            background: white;
            color: #6366f1;
            border: 2px solid #6366f1;
            border-radius: 0.75rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(99, 102, 241, 0.1);
        }
        
        .btn-back:hover {
            background: #6366f1;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }
        
        .header-text {
            flex: 1;
        }
        
        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .page-title i {
            color: #6366f1;
        }
        
        .page-subtitle {
            color: #64748b;
            font-size: 1rem;
        }
        
        .stats-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-box {
            background: white;
            padding: 1.5rem;
            border-radius: 1rem;
            border: 2px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .stat-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
        }
        
        .stat-box:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            border-color: currentColor;
        }
        
        .stat-box.pending::before {
            background: #f59e0b;
        }
        
        .stat-box.pending {
            color: #f59e0b;
        }
        
        .stat-box.approved::before {
            background: #10b981;
        }
        
        .stat-box.approved {
            color: #10b981;
        }
        
        .stat-box.rejected::before {
            background: #ef4444;
        }
        
        .stat-box.rejected {
            color: #ef4444;
        }
        
        .stat-box.total::before {
            background: #6366f1;
        }
        
        .stat-box.total {
            color: #6366f1;
        }
        
        .stat-icon-box {
            width: 60px;
            height: 60px;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            color: white;
        }
        
        .stat-box.pending .stat-icon-box {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }
        
        .stat-box.approved .stat-icon-box {
            background: linear-gradient(135deg, #10b981, #059669);
        }
        
        .stat-box.rejected .stat-icon-box {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }
        
        .stat-box.total .stat-icon-box {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
        }
        
        .stat-content {
            flex: 1;
        }
        
        .stat-label {
            font-size: 0.875rem;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
            margin-top: 0.25rem;
        }
        
        .filter-tabs {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 2rem;
            border-bottom: 2px solid #e2e8f0;
            background: white;
            border-radius: 1rem 1rem 0 0;
            padding: 0.5rem 0.5rem 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        
        .filter-tab {
            padding: 1rem 1.75rem;
            background: none;
            border: none;
            color: #64748b;
            font-weight: 600;
            cursor: pointer;
            position: relative;
            transition: all 0.3s ease;
            border-radius: 0.75rem 0.75rem 0 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .filter-tab:hover {
            color: #6366f1;
            background: rgba(99, 102, 241, 0.05);
        }
        
        .filter-tab.active {
            color: #6366f1;
            background: linear-gradient(to top, rgba(99, 102, 241, 0.1), transparent);
        }
        
        .filter-tab.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #6366f1, #8b5cf6);
            border-radius: 3px 3px 0 0;
        }
        
        .filter-tab .badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 24px;
            height: 24px;
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            padding: 0 0.5rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 700;
            box-shadow: 0 2px 6px rgba(239, 68, 68, 0.3);
            animation: pulse-badge 2s infinite;
        }
        
        @keyframes pulse-badge {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }
        
        .requests-grid {
            display: grid;
            gap: 1.5rem;
        }
        
        .request-card {
            background: white;
            border-radius: 1rem;
            padding: 1.75rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            border: 2px solid #e2e8f0;
            display: grid;
            grid-template-columns: 100px 1fr auto;
            gap: 1.75rem;
            align-items: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .request-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, #6366f1, #8b5cf6);
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }
        
        .request-card:hover {
            box-shadow: 0 8px 24px rgba(99, 102, 241, 0.15);
            transform: translateY(-4px);
            border-color: #6366f1;
        }
        
        .request-card:hover::before {
            transform: scaleY(1);
        }
        
        .request-photo-container {
            position: relative;
        }
        
        .request-photo {
            width: 100px;
            height: 100px;
            border-radius: 1rem;
            object-fit: cover;
            border: 3px solid #e2e8f0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .request-card:hover .request-photo {
            border-color: #6366f1;
            transform: scale(1.05);
        }
        
        .photo-badge {
            position: absolute;
            bottom: -8px;
            right: -8px;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
            border: 3px solid white;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.4);
        }
        
        .request-info {
            flex: 1;
        }
        
        .request-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 0.75rem;
        }
        
        .borrower-name {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .borrower-name i {
            color: #6366f1;
            font-size: 1rem;
        }
        
        .status-badge {
            padding: 0.375rem 1rem;
            border-radius: 2rem;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }
        
        .status-badge i {
            font-size: 0.625rem;
        }
        
        .status-badge.pending {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            color: #92400e;
            border: 2px solid #fbbf24;
        }
        
        .status-badge.approved,
        .status-badge.borrowed {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #065f46;
            border: 2px solid #10b981;
        }
        
        .status-badge.rejected {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #991b1b;
            border: 2px solid #ef4444;
        }
        
        .status-badge.returned {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            color: #1e40af;
            border: 2px solid #3b82f6;
        }
        
        .status-badge.overdue {
            background: linear-gradient(135deg, #fce7f3, #fbcfe8);
            color: #831843;
            border: 2px solid #ec4899;
        }
        
        .book-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #6366f1;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .book-title i {
            font-size: 1rem;
        }
        
        .request-details {
            display: flex;
            gap: 1.75rem;
            flex-wrap: wrap;
            color: #64748b;
            font-size: 0.875rem;
        }
        
        .detail-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: #f8fafc;
            padding: 0.5rem 0.875rem;
            border-radius: 0.5rem;
            border: 1px solid #e2e8f0;
        }
        
        .detail-item i {
            color: #6366f1;
            font-size: 0.875rem;
        }
        
        .request-actions {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        
        .btn-action {
            padding: 0.875rem 1.5rem;
            border: none;
            border-radius: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.625rem;
            font-size: 0.875rem;
            white-space: nowrap;
            min-width: 120px;
        }
        
        .btn-approve {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }
        
        .btn-approve:hover {
            background: linear-gradient(135deg, #059669, #047857);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.4);
        }
        
        .btn-reject {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }
        
        .btn-reject:hover {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(239, 68, 68, 0.4);
        }
        
        .btn-view {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: white;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }
        
        .btn-view:hover {
            background: linear-gradient(135deg, #4f46e5, #4338ca);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(99, 102, 241, 0.4);
        }
        
        .empty-state {
            text-align: center;
            padding: 5rem 2rem;
            color: #64748b;
            background: white;
            border-radius: 1rem;
            border: 2px dashed #e2e8f0;
        }
        
        .empty-state i {
            font-size: 5rem;
            color: #e2e8f0;
            margin-bottom: 1.5rem;
            display: inline-block;
            animation: float-icon 3s ease-in-out infinite;
        }
        
        @keyframes float-icon {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }
        
        .empty-state h3 {
            font-size: 1.5rem;
            color: #1e293b;
            margin-bottom: 0.75rem;
            font-weight: 700;
        }
        
        .empty-state p {
            font-size: 1rem;
            color: #64748b;
        }
        
        /* Books Grid */
        .books-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
        }

        /* Book Card */
        .book-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .book-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        .book-card-header {
            padding: 1.5rem;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        .book-card .book-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: white;
        }

        .book-author {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .book-card-body {
            padding: 1.5rem;
        }

        .book-info-row {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            padding: 0.75rem;
            background: #f9fafb;
            border-radius: 8px;
        }

        .book-info-row i {
            font-size: 1.1rem;
            color: #667eea;
            margin-right: 0.75rem;
            width: 20px;
        }

        .book-info-row .label {
            font-weight: 600;
            color: #6b7280;
            margin-right: 0.5rem;
        }

        .book-info-row .value {
            color: #1e293b;
        }

        .return-form {
            border-top: 2px solid #f3f4f6;
            padding-top: 1.5rem;
            margin-top: 1.5rem;
        }

        .return-form h4 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        .form-help {
            font-size: 0.85rem;
            color: #6b7280;
            margin-top: 0.25rem;
        }

        .btn-return {
            width: 100%;
            padding: 0.875rem;
            background: linear-gradient(135deg, var(--success), #059669);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-return:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(16, 185, 129, 0.4);
        }

        .btn-return:disabled {
            background: #d1d5db;
            cursor: not-allowed;
            transform: none;
        }

        .return-requested {
            background: #fef3c7;
            border: 2px solid #fbbf24;
            padding: 1rem 3.5rem 1rem 1rem;
            border-radius: 8px;
            margin-top: 1rem;
            position: relative;
            display: flex;
            align-items: center;
        }

        .return-requested i {
            color: #d97706;
            margin-right: 0.5rem;
        }

        .return-requested p {
            color: #92400e;
            font-weight: 600;
            margin: 0;
            flex: 1;
        }

        .btn-clear-request {
            position: absolute;
            top: 50%;
            right: 1rem;
            transform: translateY(-50%);
            width: 36px;
            height: 36px;
            background: #dc2626;
            color: white;
            border: 2px solid #991b1b;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            font-size: 1.1rem;
            font-weight: bold;
            box-shadow: 0 2px 8px rgba(220, 38, 38, 0.3);
        }

        .btn-clear-request:hover {
            background: #b91c1c;
            border-color: #7f1d1d;
            transform: translateY(-50%) scale(1.15);
            box-shadow: 0 4px 16px rgba(220, 38, 38, 0.5);
        }

        .btn-clear-request:active {
            transform: translateY(-50%) scale(1.05);
            box-shadow: 0 2px 8px rgba(220, 38, 38, 0.4);
        }

        .btn-clear-request i {
            color: white !important;
            margin: 0;
            line-height: 1;
        }

        /* Fade in animation for dynamically added form */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ===== MODAL STYLES ===== */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-container {
            background: white;
            border-radius: 20px;
            width: 90%;
            max-width: 900px;
            max-height: 85vh;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
            transform: scale(0.9) translateY(20px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .modal-overlay.active .modal-container {
            transform: scale(1) translateY(0);
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 1.5rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-header h2 {
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 0;
        }

        .modal-close {
            width: 40px;
            height: 40px;
            border: none;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-close:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: rotate(90deg);
        }

        .modal-content {
            padding: 2rem;
            max-height: calc(85vh - 100px);
            overflow-y: auto;
        }

        .modal-content::-webkit-scrollbar {
            width: 8px;
        }

        .modal-content::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .modal-content::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 10px;
        }

        /* Borrowed Books Modal Styles */
        .borrowed-books-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .borrowed-book-item {
            display: flex;
            gap: 1.5rem;
            padding: 1.5rem;
            background: #f8fafc;
            border-radius: 12px;
            border: 2px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .borrowed-book-item:hover {
            border-color: var(--primary);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
        }

        .borrowed-book-cover {
            width: 80px;
            height: 120px;
            border-radius: 8px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .borrowed-book-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .borrowed-book-cover i {
            font-size: 2rem;
            color: white;
        }

        .borrowed-book-info {
            flex: 1;
        }

        .borrowed-book-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .borrowed-book-author {
            font-size: 0.95rem;
            color: #6b7280;
            margin-bottom: 1rem;
        }

        .borrowed-book-dates {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .borrowed-book-date {
            font-size: 0.9rem;
            color: #374151;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .borrowed-book-date i {
            color: var(--primary);
        }

        .borrowed-book-status {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .extend-btn {
            padding: 0.5rem 1rem;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .extend-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        /* Loan History Modal Styles */
        .history-filters {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .history-filters select,
        .history-filters input {
            flex: 1;
            padding: 0.75rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .history-filters select:focus,
        .history-filters input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .loan-history-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .history-item {
            display: flex;
            gap: 1.5rem;
            padding: 1.5rem;
            background: #f8fafc;
            border-radius: 12px;
            border: 2px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .history-item:hover {
            border-color: var(--primary);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
        }

        .history-book-cover {
            width: 70px;
            height: 100px;
            border-radius: 8px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .history-book-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .history-book-cover i {
            font-size: 1.75rem;
            color: white;
        }

        .history-book-info {
            flex: 1;
        }

        .history-book-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.25rem;
        }

        .history-book-author {
            font-size: 0.9rem;
            color: #6b7280;
            margin-bottom: 0.75rem;
        }

        .history-dates {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.5rem;
            margin-bottom: 0.75rem;
        }

        .history-date {
            font-size: 0.85rem;
            color: #374151;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .history-date i {
            color: var(--primary);
            font-size: 0.75rem;
        }

        .history-status {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .status-badge.returned {
            background: #d1fae5;
            color: #065f46;
        }

        .status-badge.pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-badge.rejected {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-badge.due-soon {
            background: #fed7aa;
            color: #9a3412;
        }

        .loading-state,
        .empty-state-modal {
            text-align: center;
            padding: 3rem 1rem;
        }

        .loading-state i,
        .empty-state-modal i {
            font-size: 3rem;
            color: #d1d5db;
            margin-bottom: 1rem;
        }

        .loading-spinner {
            display: inline-block;
            width: 50px;
            height: 50px;
            border: 4px solid rgba(102, 126, 234, 0.2);
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .empty-state-modal h3 {
            font-size: 1.25rem;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .empty-state-modal p {
            color: #6b7280;
        }

        /* Responsive */
        @media (max-width: 1024px) {
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
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .books-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .books-grid {
                grid-template-columns: 1fr;
            }

            .content-area {
                padding: 1rem;
            }

            .header {
                padding: 0 1rem;
            }

            .header-title {
                font-size: 1.25rem;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <?php if(auth()->user()->role === 'admin'): ?>
            <?php if (isset($component)) { $__componentOriginal6fc2d165f80d597f34aa0f8014c366d2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6fc2d165f80d597f34aa0f8014c366d2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin-sidebar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6fc2d165f80d597f34aa0f8014c366d2)): ?>
<?php $attributes = $__attributesOriginal6fc2d165f80d597f34aa0f8014c366d2; ?>
<?php unset($__attributesOriginal6fc2d165f80d597f34aa0f8014c366d2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6fc2d165f80d597f34aa0f8014c366d2)): ?>
<?php $component = $__componentOriginal6fc2d165f80d597f34aa0f8014c366d2; ?>
<?php unset($__componentOriginal6fc2d165f80d597f34aa0f8014c366d2); ?>
<?php endif; ?>
        <?php elseif(auth()->user()->role === 'pustakawan'): ?>
            <?php if (isset($component)) { $__componentOriginal3669d248200f2dc31f2689292901c050 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3669d248200f2dc31f2689292901c050 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.pustakawan-sidebar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('pustakawan-sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3669d248200f2dc31f2689292901c050)): ?>
<?php $attributes = $__attributesOriginal3669d248200f2dc31f2689292901c050; ?>
<?php unset($__attributesOriginal3669d248200f2dc31f2689292901c050); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3669d248200f2dc31f2689292901c050)): ?>
<?php $component = $__componentOriginal3669d248200f2dc31f2689292901c050; ?>
<?php unset($__componentOriginal3669d248200f2dc31f2689292901c050); ?>
<?php endif; ?>
        <?php endif; ?>
        
        <!-- Main Content -->
        <main class="main-content" id="mainContent">
            <!-- Header -->
            <header class="header">
                <div class="header-content">
                    <button class="menu-toggle" id="menuToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <h1 class="header-title">Pengembalian Buku</h1>
                    
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
                            <button type="submit" class="nav-item" style="background: none; border: none; color: #64748b; padding: 0.5rem 1rem; border-radius: 0.5rem; transition: all 0.3s ease;">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <div class="loan-requests-container">
                <div class="page-header">
                    <div class="header-text">
                        <h2 class="page-title"><i class="fas fa-undo-alt"></i> Pengembalian Buku</h2>
                        <?php if(in_array(auth()->user()->role, ['admin', 'pustakawan'])): ?>
                            <p class="page-subtitle">Kelola permintaan pengembalian buku dari anggota perpustakaan. Verifikasi kondisi buku dan proses pengembalian.</p>
                        <?php else: ?>
                            <p class="page-subtitle">Ajukan pengembalian untuk buku yang sedang Anda pinjam. Isi formulir di bawah ini dan datang ke perpustakaan untuk mengembalikan buku secara fisik.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if($borrowedBooks->isEmpty()): ?>
                    <div class="empty-state">
                        <i class="fas fa-book-open"></i>
                        <h3>Tidak Ada Buku yang Dipinjam</h3>
                        <?php if(in_array(auth()->user()->role, ['admin', 'pustakawan'])): ?>
                            <p>Belum ada buku yang sedang dipinjam oleh anggota saat ini.</p>
                        <?php else: ?>
                            <p>Anda belum memiliki buku yang sedang dipinjam saat ini.</p>
                            <a href="<?php echo e(route('books.browse')); ?>" class="btn">
                                <i class="fas fa-search"></i> Jelajahi Buku
                            </a>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="books-grid">
                        <?php $__currentLoopData = $borrowedBooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="book-card">
                                <div class="book-card-header">
                                    <div class="book-title"><?php echo e($loan->book->title); ?></div>
                                    <div class="book-author"><?php echo e($loan->book->author); ?></div>
                                </div>

                                <div class="book-card-body">
                                    <?php if(in_array(auth()->user()->role, ['admin', 'pustakawan'])): ?>
                                        <div class="book-info-row">
                                            <i class="fas fa-user"></i>
                                            <span class="label">Peminjam:</span>
                                            <span class="value"><?php echo e($loan->user->name); ?></span>
                                        </div>
                                        <div class="book-info-row">
                                            <i class="fas fa-envelope"></i>
                                            <span class="label">Email:</span>
                                            <span class="value"><?php echo e($loan->user->email); ?></span>
                                        </div>
                                        <?php if($loan->nis): ?>
                                            <div class="book-info-row">
                                                <i class="fas fa-id-card"></i>
                                                <span class="label">NIS:</span>
                                                <span class="value"><?php echo e($loan->nis); ?></span>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <div class="book-info-row">
                                        <i class="fas fa-calendar"></i>
                                        <span class="label">Tanggal Pinjam:</span>
                                        <span class="value"><?php echo e($loan->loan_date->format('d M Y')); ?></span>
                                    </div>

                                    <div class="book-info-row">
                                        <i class="fas fa-calendar-check"></i>
                                        <span class="label">Jatuh Tempo:</span>
                                        <span class="value"><?php echo e($loan->due_date->format('d M Y')); ?></span>
                                    </div>

                                    <div class="book-info-row">
                                        <i class="fas fa-hourglass-half"></i>
                                        <span class="label">Status:</span>
                                        <?php
                                            $today = \Carbon\Carbon::now()->startOfDay();
                                            $dueDate = \Carbon\Carbon::parse($loan->due_date)->startOfDay();
                                            $daysRemaining = $today->diffInDays($dueDate, false);
                                        ?>
                                        <?php if($daysRemaining < 0): ?>
                                            <span class="status-badge overdue">Terlambat <?php echo e(abs($daysRemaining)); ?> hari</span>
                                        <?php elseif($daysRemaining == 0): ?>
                                            <span class="status-badge overdue">Jatuh tempo hari ini</span>
                                        <?php else: ?>
                                            <span class="status-badge borrowed"><?php echo e($daysRemaining); ?> hari lagi</span>
                                        <?php endif; ?>
                                    </div>

                                    <?php if(!$loan->return_request_date): ?>
                                        <div class="return-form">
                                            <?php if(in_array(auth()->user()->role, ['admin', 'pustakawan'])): ?>
                                                <h4><i class="fas fa-check-circle"></i> Proses Pengembalian</h4>
                                            <?php else: ?>
                                                <h4><i class="fas fa-clipboard-list"></i> Formulir Pengembalian</h4>
                                            <?php endif; ?>
                                            <form class="return-request-form" data-loan-id="<?php echo e($loan->id); ?>">
                                                <?php if(!in_array(auth()->user()->role, ['admin', 'pustakawan'])): ?>
                                                    <div class="form-group">
                                                        <label for="return_nis_<?php echo e($loan->id); ?>">
                                                            <i class="fas fa-id-card"></i> NIS <span style="color: red;">*</span>
                                                        </label>
                                                        <input 
                                                            type="text" 
                                                            id="return_nis_<?php echo e($loan->id); ?>" 
                                                            name="return_nis" 
                                                            placeholder="Masukkan NIS Anda"
                                                            value="<?php echo e($loan->nis ?? ''); ?>"
                                                            required
                                                        >
                                                        <div class="form-help">Nomor Induk Siswa Anda</div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="return_borrower_name_<?php echo e($loan->id); ?>">
                                                            <i class="fas fa-user"></i> Nama Lengkap <span style="color: red;">*</span>
                                                        </label>
                                                        <input 
                                                            type="text" 
                                                            id="return_borrower_name_<?php echo e($loan->id); ?>" 
                                                            name="return_borrower_name" 
                                                            placeholder="Masukkan nama lengkap Anda"
                                                            value="<?php echo e(auth()->user()->name); ?>"
                                                            required
                                                        >
                                                        <div class="form-help">Nama sesuai identitas</div>
                                                    </div>
                                                <?php else: ?>
                                                    <input type="hidden" name="return_nis" value="<?php echo e($loan->nis ?? 'STAFF'); ?>">
                                                    <input type="hidden" name="return_borrower_name" value="<?php echo e($loan->user->name); ?>">
                                                <?php endif; ?>

                                                <div class="form-group">
                                                    <label for="return_condition_<?php echo e($loan->id); ?>">
                                                        <i class="fas fa-clipboard-check"></i> Kondisi Buku <span style="color: red;">*</span>
                                                    </label>
                                                    <select 
                                                        id="return_condition_<?php echo e($loan->id); ?>" 
                                                        name="return_condition" 
                                                        required
                                                    >
                                                        <option value="">-- Pilih Kondisi --</option>
                                                        <option value="baik">Baik (Tidak ada kerusakan)</option>
                                                        <option value="rusak_ringan">Rusak Ringan (Lecet/sobek kecil)</option>
                                                        <option value="rusak_berat">Rusak Berat (Halaman hilang/rusak parah)</option>
                                                    </select>
                                                    <div class="form-help">Pilih kondisi buku saat ini</div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="return_notes_<?php echo e($loan->id); ?>">
                                                        <i class="fas fa-comment-alt"></i> Catatan Tambahan (Opsional)
                                                    </label>
                                                    <textarea 
                                                        id="return_notes_<?php echo e($loan->id); ?>" 
                                                        name="return_notes" 
                                                        placeholder="Jelaskan kerusakan atau catatan lainnya (jika ada)"
                                                    ></textarea>
                                                    <div class="form-help">Deskripsikan kondisi atau masalah buku jika ada</div>
                                                </div>

                                                <button type="submit" class="btn-return">
                                                    <?php if(in_array(auth()->user()->role, ['admin', 'pustakawan'])): ?>
                                                        <i class="fas fa-check"></i>
                                                        Proses Pengembalian
                                                    <?php else: ?>
                                                        <i class="fas fa-paper-plane"></i>
                                                        Ajukan Pengembalian
                                                    <?php endif; ?>
                                                </button>
                                            </form>
                                        </div>
                                    <?php else: ?>
                                        <div class="return-requested" id="return-requested-<?php echo e($loan->id); ?>">
                                            <p>
                                                <i class="fas fa-check-circle"></i>
                                                Permintaan pengembalian sudah diajukan pada <?php echo e(\Carbon\Carbon::parse($loan->return_request_date)->format('d M Y H:i')); ?>

                                            </p>
                                            <button 
                                                type="button" 
                                                class="btn-clear-request" 
                                                onclick="clearReturnRequest(<?php echo e($loan->id); ?>)"
                                                title="Hapus riwayat pengembalian"
                                            >
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <!-- Modal for Borrowed Books -->
    <div class="modal-overlay" id="borrowedBooksModal">
        <div class="modal-container">
            <div class="modal-header">
                <h2><i class="fas fa-book-reader"></i> Buku yang Sedang Dipinjam</h2>
                <button class="modal-close" onclick="closeBorrowedBooksModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-content">
                <div class="borrowed-books-list" id="borrowedBooksList">
                    <!-- Borrowed books will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Loan History -->
    <div class="modal-overlay" id="loanHistoryModal">
        <div class="modal-container">
            <div class="modal-header">
                <h2><i class="fas fa-history"></i> Riwayat Peminjaman</h2>
                <button class="modal-close" onclick="closeLoanHistoryModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-content">
                <div class="history-filters">
                    <select id="historyFilter" onchange="filterHistory()">
                        <option value="all">Semua Status</option>
                        <option value="returned">Sudah Dikembalikan</option>
                        <option value="borrowed">Sedang Dipinjam</option>
                        <option value="overdue">Terlambat</option>
                        <option value="pending">Menunggu Persetujuan</option>
                        <option value="rejected">Ditolak</option>
                    </select>
                    <input type="text" id="historySearch" placeholder="Cari judul buku..." onkeyup="searchHistory()">
                </div>
                <div class="loan-history-list" id="loanHistoryList">
                    <!-- Loan history will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <script>
        // Check user role
        const userRole = '<?php echo e(auth()->user()->role); ?>';
        const isStaff = ['admin', 'pustakawan'].includes(userRole);
        
        // Form submission handler (reusable function)
        function attachFormSubmitHandler(form) {
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const loanId = this.dataset.loanId;
                const submitBtn = this.querySelector('.btn-return');
                const formData = new FormData(this);
                
                // Validate required fields
                const nis = formData.get('return_nis');
                const name = formData.get('return_borrower_name');
                const condition = formData.get('return_condition');
                
                if (!nis || !name || !condition) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Data Tidak Lengkap',
                        text: 'Mohon lengkapi semua field yang wajib diisi (NIS, Nama, dan Kondisi Buku).',
                        confirmButtonColor: '#667eea'
                    });
                    return;
                }
                
                // Confirm submission - different message for staff
                const confirmTitle = isStaff ? 'Konfirmasi Proses Pengembalian' : 'Konfirmasi Pengembalian';
                const confirmText = isStaff ? 
                    'Apakah Anda yakin ingin memproses pengembalian buku ini?' : 
                    'Apakah Anda yakin ingin mengajukan pengembalian dengan data berikut?';
                const warningText = isStaff ? 
                    '<i class="fas fa-check-circle"></i> Buku akan dikembalikan ke stok perpustakaan.' :
                    '<i class="fas fa-exclamation-triangle"></i> Setelah mengajukan, silakan datang ke perpustakaan untuk mengembalikan buku secara fisik.';
                
                const result = await Swal.fire({
                    title: confirmTitle,
                    html: `
                        <div style="text-align: left; padding: 1rem;">
                            <p style="margin-bottom: 1rem;">${confirmText}</p>
                            <div style="background: #f3f4f6; padding: 1rem; border-radius: 8px;">
                                <p style="margin: 0.5rem 0;"><strong>NIS:</strong> ${nis}</p>
                                <p style="margin: 0.5rem 0;"><strong>Nama:</strong> ${name}</p>
                                <p style="margin: 0.5rem 0;"><strong>Kondisi:</strong> ${condition === 'baik' ? 'Baik' : condition === 'rusak_ringan' ? 'Rusak Ringan' : 'Rusak Berat'}</p>
                                ${formData.get('return_notes') ? `<p style="margin: 0.5rem 0;"><strong>Catatan:</strong> ${formData.get('return_notes')}</p>` : ''}
                            </div>
                            <p style="margin-top: 1rem; color: ${isStaff ? '#10b981' : '#d97706'}; font-weight: 600;">
                                ${warningText}
                            </p>
                        </div>
                    `,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#10b981',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: isStaff ? 'Ya, Proses' : 'Ya, Ajukan',
                    cancelButtonText: 'Batal',
                    width: '600px'
                });
                
                if (!result.isConfirmed) {
                    return;
                }
                
                // Disable button
                submitBtn.disabled = true;
                submitBtn.innerHTML = isStaff ? 
                    '<i class="fas fa-spinner fa-spin"></i> Memproses...' :
                    '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
                
                try {
                    const response = await fetch('/api/returns/submit', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            loan_id: loanId,
                            return_nis: nis,
                            return_borrower_name: name,
                            return_condition: condition,
                            return_notes: formData.get('return_notes') || ''
                        })
                    });
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        await Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message,
                            confirmButtonColor: '#10b981'
                        });
                        
                        // Reload page to show updated status
                        window.location.reload();
                    } else {
                        throw new Error(data.message);
                    }
                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: error.message || 'Terjadi kesalahan saat ' + (isStaff ? 'memproses' : 'mengajukan') + ' pengembalian.',
                        confirmButtonColor: '#ef4444'
                    });
                    
                    // Re-enable button
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = isStaff ?
                        '<i class="fas fa-check"></i> Proses Pengembalian' :
                        '<i class="fas fa-paper-plane"></i> Ajukan Pengembalian';
                }
            });
        }

        // Attach handlers to all existing forms
        document.querySelectorAll('.return-request-form').forEach(form => {
            attachFormSubmitHandler(form);
        });

        // Clear return request function
        async function clearReturnRequest(loanId) {
            // Confirm deletion
            const result = await Swal.fire({
                title: 'Hapus Riwayat Pengembalian?',
                html: `
                    <div style="text-align: left; padding: 1rem;">
                        <p style="margin-bottom: 1rem;">Apakah Anda yakin ingin menghapus riwayat pengembalian ini?</p>
                        <div style="background: #fee2e2; padding: 1rem; border-radius: 8px; border-left: 4px solid #ef4444;">
                            <p style="margin: 0; color: #991b1b; font-weight: 600;">
                                <i class="fas fa-exclamation-triangle"></i> Perhatian:
                            </p>
                            <p style="margin: 0.5rem 0 0; color: #7f1d1d;">
                                Data permintaan pengembalian akan dihapus dan Anda perlu mengajukan ulang jika ingin mengembalikan buku.
                            </p>
                        </div>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                width: '500px'
            });

            if (!result.isConfirmed) {
                return;
            }

            // Show loading
            Swal.fire({
                title: 'Menghapus...',
                html: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            try {
                const response = await fetch('/api/returns/clear', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        loan_id: loanId
                    })
                });

                const data = await response.json();

                if (data.success) {
                    // Close loading alert
                    Swal.close();

                    // Find the current card and grid
                    const returnRequestedBox = document.getElementById(`return-requested-${loanId}`);
                    const bookCard = returnRequestedBox.closest('.book-card');
                    const booksGrid = document.querySelector('.books-grid');

                    // Fade out and remove the WHOLE card
                    bookCard.style.transition = 'all 0.25s ease';
                    bookCard.style.opacity = '0';
                    bookCard.style.transform = 'scale(0.98)';

                    setTimeout(() => {
                        // Remove the card
                        if (bookCard && bookCard.parentNode) {
                            bookCard.parentNode.removeChild(bookCard);
                        }

                        // If no more cards, show empty-state
                        if (!booksGrid || booksGrid.querySelectorAll('.book-card').length === 0) {
                            const emptyHTML = `
                                <div class="empty-state" style="animation: fadeIn 0.2s ease;">
                                    <i class=\"fas fa-book-open\"></i>
                                    <h3>Tidak Ada Buku yang Dipinjam</h3>
                                    <p>Anda belum memiliki buku yang sedang dipinjam saat ini.</p>
                                    <a href=\"<?php echo e(route('books.browse')); ?>\" class=\"btn\">
                                        <i class=\"fas fa-search\"></i> Jelajahi Buku
                                    </a>
                                </div>`;

                            if (booksGrid) {
                                booksGrid.outerHTML = emptyHTML;
                            }
                        }

                        // Success toast
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Riwayat pengembalian dihapus',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        });
                    }, 250);
                } else {
                    throw new Error(data.message);
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: error.message || 'Terjadi kesalahan saat menghapus riwayat.',
                    confirmButtonColor: '#ef4444'
                });
            }
        }

        // Menu toggle functionality
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');

        if (menuToggle) {
            menuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('active');
                mainContent.classList.toggle('expanded');
            });
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            if (window.innerWidth <= 1024) {
                if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
                    sidebar.classList.remove('active');
                }
            }
        });

        // Placeholder functions for sidebar navigation (if not defined elsewhere)
        if (typeof showProfileModal === 'undefined') {
            window.showProfileModal = function() {
                alert('Fitur profil akan segera tersedia!');
            };
        }

        if (typeof showBorrowedBooks === 'undefined') {
            window.showBorrowedBooks = function() {
                const modal = document.getElementById('borrowedBooksModal');
                const booksList = document.getElementById('borrowedBooksList');
                
                // Show modal
                modal.classList.add('active');
                
                // Show loading
                booksList.innerHTML = `
                    <div class="loading-state">
                        <div class="loading-spinner"></div>
                        <p>Memuat buku yang sedang dipinjam...</p>
                    </div>
                `;
                
                // Fetch borrowed books
                fetch('/api/borrowed-books', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (data.borrowed_books.length === 0) {
                            booksList.innerHTML = `
                                <div class="empty-state-modal">
                                    <i class="fas fa-book-open"></i>
                                    <h3>Tidak Ada Buku yang Sedang Dipinjam</h3>
                                    <p>Mulai jelajahi koleksi kami dan pinjam buku favorit Anda!</p>
                                </div>
                            `;
                        } else {
                            booksList.innerHTML = data.borrowed_books.map(book => `
                                <div class="borrowed-book-item">
                                    <div class="borrowed-book-cover">
                                        ${book.book.cover_image ? 
                                            `<img src="${book.book.cover_image.startsWith('http') ? book.book.cover_image : '/' + book.book.cover_image}" alt="${book.book.title}">` : 
                                            '<i class="fas fa-book"></i>'
                                        }
                                    </div>
                                    <div class="borrowed-book-info">
                                        <h3 class="borrowed-book-title">${book.book.title}</h3>
                                        <p class="borrowed-book-author">oleh ${book.book.author}</p>
                                        <div class="borrowed-book-dates">
                                            <div class="borrowed-book-date">
                                                <i class="fas fa-calendar-alt"></i>
                                                Dipinjam: ${book.loan_date}
                                            </div>
                                            <div class="borrowed-book-date">
                                                <i class="fas fa-calendar-check"></i>
                                                Jatuh Tempo: ${book.due_date}
                                            </div>
                                        </div>
                                        <div class="borrowed-book-status">
                                            <span class="status-badge ${book.status}">${book.status_text}</span>
                                            ${book.can_extend ? 
                                                `<button class="extend-btn" onclick="extendLoan(${book.id})">
                                                    <i class="fas fa-clock"></i> Perpanjang
                                                </button>` : ''
                                            }
                                        </div>
                                    </div>
                                </div>
                            `).join('');
                        }
                    } else {
                        booksList.innerHTML = `
                            <div class="empty-state-modal">
                                <i class="fas fa-exclamation-triangle"></i>
                                <h3>Gagal Memuat Data</h3>
                                <p>${data.message || 'Terjadi kesalahan saat memuat data.'}</p>
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    booksList.innerHTML = `
                        <div class="empty-state-modal">
                            <i class="fas fa-exclamation-triangle"></i>
                            <h3>Gagal Memuat Data</h3>
                            <p>Terjadi kesalahan saat memuat data. Silakan coba lagi.</p>
                        </div>
                    `;
                });
            };
        }

        if (typeof showLoanHistory === 'undefined') {
            window.showLoanHistory = function() {
                const modal = document.getElementById('loanHistoryModal');
                const historyList = document.getElementById('loanHistoryList');
                
                // Show modal
                modal.classList.add('active');
                
                // Load history
                loadLoanHistory();
            };
        }

        // Close Borrowed Books Modal
        function closeBorrowedBooksModal() {
            document.getElementById('borrowedBooksModal').classList.remove('active');
        }

        // Close Loan History Modal
        function closeLoanHistoryModal() {
            document.getElementById('loanHistoryModal').classList.remove('active');
        }

        // Load Loan History
        function loadLoanHistory(status = 'all', search = '') {
            const historyList = document.getElementById('loanHistoryList');
            
            // Show loading
            historyList.innerHTML = `
                <div class="loading-state">
                    <div class="loading-spinner"></div>
                    <p>Memuat riwayat peminjaman...</p>
                </div>
            `;
            
            // Build query parameters
            const params = new URLSearchParams();
            if (status !== 'all') params.append('status', status);
            if (search) params.append('search', search);
            
            // Fetch loan history
            fetch('/api/loan-history?' + params.toString(), {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.loan_history.length === 0) {
                        historyList.innerHTML = `
                            <div class="empty-state-modal">
                                <i class="fas fa-history"></i>
                                <h3>Tidak Ada Riwayat Peminjaman</h3>
                                <p>Belum ada riwayat peminjaman yang sesuai dengan filter.</p>
                            </div>
                        `;
                    } else {
                        historyList.innerHTML = data.loan_history.map(history => `
                            <div class="history-item">
                                <div class="history-book-cover">
                                    ${history.book.cover_image ? 
                                        `<img src="${history.book.cover_image.startsWith('http') ? history.book.cover_image : '/' + history.book.cover_image}" alt="${history.book.title}">` : 
                                        '<i class="fas fa-book"></i>'
                                    }
                                </div>
                                <div class="history-book-info">
                                    <h3 class="history-book-title">${history.book.title}</h3>
                                    <p class="history-book-author">oleh ${history.book.author}</p>
                                    <div class="history-dates">
                                        ${history.request_date ? `
                                            <div class="history-date">
                                                <i class="fas fa-paper-plane"></i>
                                                Diajukan: ${history.request_date}
                                            </div>
                                        ` : ''}
                                        ${history.loan_date ? `
                                            <div class="history-date">
                                                <i class="fas fa-calendar-alt"></i>
                                                Dipinjam: ${history.loan_date}
                                            </div>
                                        ` : ''}
                                        ${history.return_date ? `
                                            <div class="history-date">
                                                <i class="fas fa-calendar-check"></i>
                                                Dikembalikan: ${history.return_date}
                                            </div>
                                        ` : ''}
                                        ${history.due_date && !history.return_date ? `
                                            <div class="history-date">
                                                <i class="fas fa-clock"></i>
                                                Jatuh Tempo: ${history.due_date}
                                            </div>
                                        ` : ''}
                                    </div>
                                    <div class="history-status">
                                        <span class="status-badge ${history.status}">${history.status_text}</span>
                                        <span style="font-size: 0.8rem; color: var(--text-light);">${history.duration}</span>
                                    </div>
                                </div>
                            </div>
                        `).join('');
                    }
                } else {
                    historyList.innerHTML = `
                        <div class="empty-state-modal">
                            <i class="fas fa-exclamation-triangle"></i>
                            <h3>Gagal Memuat Data</h3>
                            <p>${data.message || 'Terjadi kesalahan saat memuat data.'}</p>
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                historyList.innerHTML = `
                    <div class="empty-state-modal">
                        <i class="fas fa-exclamation-triangle"></i>
                        <h3>Gagal Memuat Data</h3>
                        <p>Terjadi kesalahan saat memuat data. Silakan coba lagi.</p>
                    </div>
                `;
            });
        }

        // Filter History
        function filterHistory() {
            const status = document.getElementById('historyFilter').value;
            const search = document.getElementById('historySearch').value;
            loadLoanHistory(status, search);
        }

        // Search History
        function searchHistory() {
            const status = document.getElementById('historyFilter').value;
            const search = document.getElementById('historySearch').value;
            loadLoanHistory(status, search);
        }

        // Extend Loan
        function extendLoan(loanId) {
            if (!confirm('Apakah Anda yakin ingin memperpanjang peminjaman buku ini selama 7 hari?')) {
                return;
            }
            
            fetch(`/api/extend-loan/${loanId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        confirmButtonColor: '#10b981'
                    });
                    // Refresh borrowed books list
                    showBorrowedBooks();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: data.message,
                        confirmButtonColor: '#ef4444'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Terjadi kesalahan. Silakan coba lagi.',
                    confirmButtonColor: '#ef4444'
                });
            });
        }

        // Close modals when clicking outside
        document.querySelectorAll('.modal-overlay').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.remove('active');
                }
            });
        });
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\Perpustakaan1_project\resources\views/dashboard/returns.blade.php ENDPATH**/ ?>