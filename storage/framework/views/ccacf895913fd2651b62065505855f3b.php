<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Akses Peminjaman - <?php echo e(config('app.name', 'Sistem Perpustakaan')); ?></title>
    
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
        
        /* Modal */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.3s ease;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        
        .modal-overlay.active {
            display: flex;
        }
        
        .modal-content {
            background: white;
            border-radius: 1.5rem;
            padding: 0;
            max-width: 700px;
            width: 90%;
            max-height: 90vh;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.3s ease;
        }
        
        @keyframes slideUp {
            from {
                transform: translateY(30px);
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
            padding: 2rem;
            border-bottom: 2px solid #e2e8f0;
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
        }
        
        .modal-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .modal-title i {
            color: #6366f1;
        }
        
        .modal-close {
            background: white;
            border: 2px solid #e2e8f0;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            cursor: pointer;
            color: #64748b;
            transition: all 0.3s ease;
        }
        
        .modal-close:hover {
            background: #ef4444;
            border-color: #ef4444;
            color: white;
            transform: rotate(90deg);
        }
        
        .modal-body {
            padding: 2rem;
            max-height: calc(90vh - 140px);
            overflow-y: auto;
        }
        
        .modal-body::-webkit-scrollbar {
            width: 8px;
        }
        
        .modal-body::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        .modal-body::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        
        .detail-row {
            display: grid;
            grid-template-columns: 180px 1fr;
            gap: 1.5rem;
            padding: 1.25rem;
            background: #f8fafc;
            border-radius: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }
        
        .detail-row:hover {
            background: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        
        .detail-label {
            font-weight: 700;
            color: #64748b;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .detail-label i {
            color: #6366f1;
        }
        
        .detail-value {
            color: #1e293b;
            font-weight: 500;
        }
        
        .photo-preview {
            width: 100%;
            max-width: 400px;
            border-radius: 1rem;
            border: 3px solid #e2e8f0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .photo-preview:hover {
            transform: scale(1.02);
            border-color: #6366f1;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .request-card {
                grid-template-columns: 1fr;
                gap: 1.25rem;
                text-align: center;
            }
            
            .request-photo-container {
                margin: 0 auto;
            }
            
            .request-actions {
                flex-direction: row;
                justify-content: center;
            }
            
            .detail-row {
                grid-template-columns: 1fr;
                gap: 0.5rem;
            }
            
            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        /* SweetAlert2 Custom Styles */
        .swal-wide {
            width: 600px !important;
            max-width: 90% !important;
        }
        
        .swal2-popup {
            border-radius: 1rem !important;
            padding: 2rem !important;
        }
        
        .swal2-title {
            font-size: 1.5rem !important;
            font-weight: 700 !important;
            color: #1e293b !important;
            padding: 0 0 1rem 0 !important;
        }
        
        .swal2-html-container {
            font-size: 0.95rem !important;
            color: #64748b !important;
            margin: 0 !important;
        }
        
        .swal2-actions {
            gap: 1rem !important;
            margin-top: 1.5rem !important;
        }
        
        .swal-btn-confirm,
        .swal2-confirm {
            padding: 0.75rem 2rem !important;
            border-radius: 0.75rem !important;
            font-weight: 600 !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3) !important;
        }
        
        .swal-btn-confirm:hover,
        .swal2-confirm:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4) !important;
        }
        
        .swal-btn-cancel,
        .swal2-cancel {
            padding: 0.75rem 2rem !important;
            border-radius: 0.75rem !important;
            font-weight: 600 !important;
            transition: all 0.3s ease !important;
        }
        
        .swal-btn-danger {
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3) !important;
        }
        
        .swal-btn-danger:hover {
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4) !important;
        }
        
        .swal2-input,
        .swal2-textarea {
            font-size: 0.95rem !important;
        }
        
        .swal2-textarea:focus {
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1) !important;
        }
        
        /* Range input styling */
        .swal2-range {
            width: 100% !important;
            margin: 1rem 0 !important;
            -webkit-appearance: none;
            appearance: none;
            height: 8px !important;
            border-radius: 5px !important;
            background: linear-gradient(to right, #6366f1, #8b5cf6) !important;
            outline: none !important;
            opacity: 0.9 !important;
            transition: opacity 0.2s !important;
        }
        
        .swal2-range:hover {
            opacity: 1 !important;
        }
        
        .swal2-range::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: white;
            border: 3px solid #6366f1;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(99, 102, 241, 0.4);
            transition: all 0.3s ease;
        }
        
        .swal2-range::-webkit-slider-thumb:hover {
            transform: scale(1.2);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.6);
        }
        
        .swal2-range::-moz-range-thumb {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: white;
            border: 3px solid #6366f1;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(99, 102, 241, 0.4);
            transition: all 0.3s ease;
        }
        
        .swal2-range::-moz-range-thumb:hover {
            transform: scale(1.2);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.6);
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
                    
                    <h1 class="header-title">Akses Peminjaman</h1>
                    
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
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>
            
            <!-- Content -->
            <div class="loan-requests-container">
                <div class="page-header">
                    <a href="<?php echo e(route('dashboard')); ?>" class="btn-back">
                        <i class="fas fa-arrow-left"></i>
                        Kembali ke Dashboard
                    </a>
                    <div class="header-text">
                        <h2 class="page-title">
                            <i class="fas fa-clipboard-list"></i>
                            Manajemen Peminjaman Buku
                        </h2>
                        <p class="page-subtitle">Kelola permintaan peminjaman dari anggota perpustakaan</p>
                    </div>
                </div>
                
                <!-- Stats Summary -->
                <div class="stats-summary">
                    <div class="stat-box pending">
                        <div class="stat-icon-box">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-label">Pending</div>
                            <div class="stat-value" id="stat-pending">0</div>
                        </div>
                    </div>
                    <div class="stat-box approved">
                        <div class="stat-icon-box">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-label">Disetujui</div>
                            <div class="stat-value" id="stat-approved">0</div>
                        </div>
                    </div>
                    <div class="stat-box rejected">
                        <div class="stat-icon-box">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-label">Ditolak</div>
                            <div class="stat-value" id="stat-rejected">0</div>
                        </div>
                    </div>
                    <div class="stat-box total">
                        <div class="stat-icon-box">
                            <i class="fas fa-list"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-label">Total</div>
                            <div class="stat-value" id="stat-total">0</div>
                        </div>
                    </div>
                </div>
                
                <!-- Filter Tabs -->
                <div class="filter-tabs">
                    <button class="filter-tab active" data-status="pending">
                        <i class="fas fa-clock"></i>
                        Pending
                        <span class="badge" id="pending-count">0</span>
                    </button>
                    <button class="filter-tab" data-status="approved">
                        <i class="fas fa-check-circle"></i>
                        Disetujui
                    </button>
                    <button class="filter-tab" data-status="rejected">
                        <i class="fas fa-times-circle"></i>
                        Ditolak
                    </button>
                    <button class="filter-tab" data-status="all">
                        <i class="fas fa-list"></i>
                        Semua
                    </button>
                </div>
                
                <!-- Requests Grid -->
                <div class="requests-grid" id="requestsGrid">
                    <!-- Will be populated by JavaScript -->
                </div>
            </div>
        </main>
    </div>
    
    <!-- Detail Modal -->
    <div class="modal-overlay" id="detailModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">
                    <i class="fas fa-info-circle"></i>
                    Detail Permintaan Peminjaman
                </h3>
                <button class="modal-close" onclick="closeDetailModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Will be populated by JavaScript -->
            </div>
        </div>
    </div>
    
    <script>
        let currentFilter = 'pending';
        let allLoans = [];
        
        // Load loan requests
        async function loadLoanRequests() {
            try {
                const response = await fetch('/api/admin/loan-requests');
                const data = await response.json();
                
                if (data.success) {
                    allLoans = data.loans;
                    updatePendingCount();
                    renderLoans();
                }
            } catch (error) {
                console.error('Error loading loans:', error);
                Swal.fire('Error', 'Gagal memuat data peminjaman', 'error');
            }
        }
        
        // Update pending count
        function updatePendingCount() {
            const pendingCount = allLoans.filter(loan => loan.status === 'pending').length;
            const approvedCount = allLoans.filter(loan => loan.status === 'approved' || loan.status === 'borrowed').length;
            const rejectedCount = allLoans.filter(loan => loan.status === 'rejected').length;
            
            document.getElementById('pending-count').textContent = pendingCount;
            document.getElementById('stat-pending').textContent = pendingCount;
            document.getElementById('stat-approved').textContent = approvedCount;
            document.getElementById('stat-rejected').textContent = rejectedCount;
            document.getElementById('stat-total').textContent = allLoans.length;
        }
        
        // Render loans based on filter
        function renderLoans() {
            const grid = document.getElementById('requestsGrid');
            let filtered = allLoans;
            
            if (currentFilter !== 'all') {
                filtered = allLoans.filter(loan => loan.status === currentFilter);
            }
            
            if (filtered.length === 0) {
                grid.innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <h3>Tidak Ada Data</h3>
                        <p>Belum ada permintaan peminjaman dengan status ini</p>
                    </div>
                `;
                return;
            }
            
            grid.innerHTML = filtered.map(loan => {
                const photoUrl = loan.borrower_photo 
                    ? '/storage/' + loan.borrower_photo 
                    : 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"%3E%3Crect fill="%23e2e8f0" width="100" height="100"/%3E%3Ctext x="50" y="50" text-anchor="middle" dy=".3em" fill="%236366f1" font-size="40" font-family="Arial"%3E' + loan.user.name.charAt(0).toUpperCase() + '%3C/text%3E%3C/svg%3E';
                
                return `
                <div class="request-card">
                    <div class="request-photo-container">
                        <img src="${photoUrl}" 
                             alt="Borrower Photo" 
                             class="request-photo">
                        <div class="photo-badge">
                            <i class="fas fa-${loan.identification_method === 'qr_scan' ? 'qrcode' : 'keyboard'}"></i>
                        </div>
                    </div>
                    
                    <div class="request-info">
                        <div class="request-header">
                            <span class="borrower-name">
                                <i class="fas fa-user"></i>
                                ${loan.user.name}
                            </span>
                            <span class="status-badge ${loan.status}">
                                <i class="fas fa-circle"></i>
                                ${getStatusText(loan.status)}
                            </span>
                        </div>
                        <div class="book-title">
                            <i class="fas fa-book"></i>
                            ${loan.book.title}
                        </div>
                        <div class="request-details">
                            <div class="detail-item">
                                <i class="fas fa-calendar-alt"></i>
                                <span>${formatDate(loan.request_date)}</span>
                            </div>
                            ${loan.nisn ? `
                                <div class="detail-item">
                                    <i class="fas fa-id-card"></i>
                                    <span>NISN: ${loan.nisn}</span>
                                </div>
                            ` : ''}
                            ${loan.nis ? `
                                <div class="detail-item">
                                    <i class="fas fa-id-badge"></i>
                                    <span>NIS: ${loan.nis}</span>
                                </div>
                            ` : ''}
                            <div class="detail-item">
                                <i class="fas fa-${loan.identification_method === 'qr_scan' ? 'qrcode' : 'keyboard'}"></i>
                                <span>${loan.identification_method === 'qr_scan' ? 'QR Scan' : 'Input Manual'}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="request-actions">
                        ${loan.status === 'pending' ? `
                            <button class="btn-action btn-approve" onclick="approveLoan(${loan.id})">
                                <i class="fas fa-check"></i>
                                ACC
                            </button>
                            <button class="btn-action btn-reject" onclick="rejectLoan(${loan.id})">
                                <i class="fas fa-times"></i>
                                Tolak
                            </button>
                        ` : `
                            <button class="btn-action btn-view" onclick="viewDetail(${loan.id})">
                                <i class="fas fa-eye"></i>
                                Detail
                            </button>
                        `}
                    </div>
                </div>
            `;
            }).join('');
        }
        
        // Filter tabs
        document.querySelectorAll('.filter-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                currentFilter = this.dataset.status;
                renderLoans();
            });
        });
        
        // Approve loan
        async function approveLoan(loanId) {
            const loan = allLoans.find(l => l.id === loanId);
            
            // Step 1: Ask for loan duration
            const { value: loanDuration, isConfirmed: durationConfirmed } = await Swal.fire({
                title: '<i class="fas fa-calendar-alt"></i> Tentukan Durasi Peminjaman',
                html: `
                    <div style="text-align: left; padding: 1rem;">
                        <p style="margin-bottom: 1rem; color: #64748b;">Anda akan menyetujui peminjaman untuk:</p>
                        <div style="background: #f1f5f9; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; border-left: 4px solid #6366f1;">
                            <p style="margin: 0.5rem 0;"><strong>Peminjam:</strong> ${loan.user.name}</p>
                            <p style="margin: 0.5rem 0;"><strong>Buku:</strong> ${loan.book.title}</p>
                            <p style="margin: 0.5rem 0;"><strong>Penulis:</strong> ${loan.book.author}</p>
                        </div>
                        <div style="background: #dbeafe; padding: 1rem; border-radius: 0.5rem; border-left: 4px solid #2563eb;">
                            <p style="color: #1e40af; font-weight: 600; margin: 0 0 0.5rem 0;">
                                <i class="fas fa-info-circle"></i> Tentukan Durasi Peminjaman:
                            </p>
                            <p style="color: #64748b; font-size: 0.875rem; margin: 0;">
                                Pilih berapa hari buku akan dipinjamkan (1-30 hari)
                            </p>
                        </div>
                    </div>
                `,
                input: 'range',
                inputLabel: 'Durasi Peminjaman (Hari)',
                inputAttributes: {
                    min: '1',
                    max: '30',
                    step: '1'
                },
                inputValue: 7,
                showCancelButton: true,
                confirmButtonText: '<i class="fas fa-arrow-right"></i> Lanjutkan',
                cancelButtonText: '<i class="fas fa-times"></i> Batal',
                confirmButtonColor: '#6366f1',
                cancelButtonColor: '#64748b',
                customClass: {
                    popup: 'swal-wide'
                },
                didOpen: () => {
                    const input = Swal.getInput();
                    const valueDisplay = document.createElement('div');
                    valueDisplay.style.cssText = `
                        text-align: center;
                        font-size: 2rem;
                        font-weight: 700;
                        color: #6366f1;
                        margin: 1rem 0;
                        padding: 1rem;
                        background: linear-gradient(135deg, #f0f4ff, #e0e7ff);
                        border-radius: 0.75rem;
                        border: 2px solid #c7d2fe;
                    `;
                    valueDisplay.innerHTML = `<span id="durationValue">${input.value}</span> Hari`;
                    input.parentElement.insertBefore(valueDisplay, input.nextSibling);
                    
                    input.addEventListener('input', (e) => {
                        document.getElementById('durationValue').textContent = e.target.value;
                    });
                }
            });
            
            if (!durationConfirmed) return;
            
            // Step 2: Final confirmation with chosen duration
            const result = await Swal.fire({
                title: '<i class="fas fa-check-circle"></i> Konfirmasi Persetujuan',
                html: `
                    <div style="text-align: left; padding: 1rem;">
                        <div style="background: #f1f5f9; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem;">
                            <p style="margin: 0.5rem 0;"><strong>Peminjam:</strong> ${loan.user.name}</p>
                            <p style="margin: 0.5rem 0;"><strong>Buku:</strong> ${loan.book.title}</p>
                            <p style="margin: 0.5rem 0;"><strong>Penulis:</strong> ${loan.book.author}</p>
                        </div>
                        <div style="background: linear-gradient(135deg, #dcfce7, #bbf7d0); padding: 1.25rem; border-radius: 0.75rem; margin-bottom: 1rem; border: 2px solid #10b981; text-align: center;">
                            <p style="color: #065f46; font-weight: 700; font-size: 1.1rem; margin: 0;">
                                <i class="fas fa-calendar-check"></i> Durasi Peminjaman
                            </p>
                            <p style="color: #059669; font-size: 2.5rem; font-weight: 800; margin: 0.5rem 0;">
                                ${loanDuration} Hari
                            </p>
                            <p style="color: #064e3b; font-size: 0.875rem; margin: 0;">
                                <i class="fas fa-clock"></i> Jatuh tempo: ${calculateDueDate(loanDuration)}
                            </p>
                        </div>
                        <p style="color: #059669; font-weight: 600; text-align: center;">
                            <i class="fas fa-info-circle"></i> Apakah Anda yakin ingin menyetujui peminjaman ini?
                        </p>
                    </div>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: '<i class="fas fa-check"></i> Ya, Setujui Peminjaman',
                cancelButtonText: '<i class="fas fa-arrow-left"></i> Kembali',
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#64748b',
                customClass: {
                    popup: 'swal-wide',
                    confirmButton: 'swal-btn-confirm',
                    cancelButton: 'swal-btn-cancel'
                },
                showLoaderOnConfirm: true,
                preConfirm: async () => {
                    try {
                        const response = await fetch(`/api/admin/loans/${loanId}/approve`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                loan_duration: parseInt(loanDuration)
                            })
                        });
                        
                        const data = await response.json();
                        
                        if (!data.success) {
                            throw new Error(data.message);
                        }
                        
                        return data;
                    } catch (error) {
                        Swal.showValidationMessage(`Gagal: ${error.message}`);
                    }
                },
                allowOutsideClick: () => !Swal.isLoading()
            });
            
            if (result.isConfirmed) {
                await Swal.fire({
                    title: '<i class="fas fa-check-circle" style="color: #10b981;"></i> Peminjaman Disetujui!',
                    html: `
                        <p style="color: #64748b; margin-top: 1rem;">
                            Peminjaman telah berhasil disetujui dengan durasi <strong style="color: #10b981;">${loanDuration} hari</strong>.<br>
                            Anggota dapat mengambil buku sesuai jadwal yang ditentukan.
                        </p>
                        <div style="background: #f0fdf4; padding: 1rem; border-radius: 0.5rem; margin-top: 1rem; border: 2px solid #bbf7d0;">
                            <p style="color: #065f46; margin: 0; font-size: 0.875rem;">
                                <i class="fas fa-calendar-times"></i> Jatuh tempo: <strong>${calculateDueDate(loanDuration)}</strong>
                            </p>
                        </div>
                    `,
                    icon: 'success',
                    confirmButtonText: 'Tutup',
                    confirmButtonColor: '#10b981',
                    timer: 4000
                });
                loadLoanRequests();
            }
        }
        
        // Calculate due date from duration
        function calculateDueDate(days) {
            const date = new Date();
            date.setDate(date.getDate() + parseInt(days));
            return date.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'long',
                year: 'numeric'
            });
        }
        
        // Reject loan
        async function rejectLoan(loanId) {
            const loan = allLoans.find(l => l.id === loanId);
            
            // First confirmation - Ask for reason
            const { value: reason, isConfirmed: firstConfirm } = await Swal.fire({
                title: '<i class="fas fa-exclamation-triangle"></i> Tolak Peminjaman',
                html: `
                    <div style="text-align: left; padding: 1rem;">
                        <p style="margin-bottom: 1rem; color: #64748b;">Anda akan menolak peminjaman untuk:</p>
                        <div style="background: #fef2f2; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem; border: 2px solid #fecaca;">
                            <p style="margin: 0.5rem 0;"><strong>Peminjam:</strong> ${loan.user.name}</p>
                            <p style="margin: 0.5rem 0;"><strong>Buku:</strong> ${loan.book.title}</p>
                            <p style="margin: 0.5rem 0;"><strong>Penulis:</strong> ${loan.book.author}</p>
                        </div>
                        <p style="color: #dc2626; font-weight: 600; margin-bottom: 0.5rem;">
                            <i class="fas fa-info-circle"></i> Alasan penolakan (opsional):
                        </p>
                    </div>
                `,
                input: 'textarea',
                inputPlaceholder: 'Contoh: Buku sedang dalam perbaikan, Anggota memiliki tunggakan, dll.',
                inputAttributes: {
                    style: 'min-height: 100px; border: 2px solid #e2e8f0; border-radius: 0.5rem; padding: 0.75rem;'
                },
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '<i class="fas fa-arrow-right"></i> Lanjutkan',
                cancelButtonText: '<i class="fas fa-times"></i> Batal',
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                customClass: {
                    popup: 'swal-wide'
                }
            });
            
            if (!firstConfirm) return;
            
            // Second confirmation - Final confirmation
            const finalConfirm = await Swal.fire({
                title: '<i class="fas fa-ban"></i> Konfirmasi Penolakan',
                html: `
                    <div style="text-align: center; padding: 1rem;">
                        <p style="font-size: 1.1rem; color: #dc2626; font-weight: 600; margin-bottom: 1rem;">
                            ⚠️ Apakah Anda yakin ingin menolak peminjaman ini?
                        </p>
                        ${reason ? `
                            <div style="background: #fef2f2; padding: 1rem; border-radius: 0.5rem; margin: 1rem 0; border-left: 4px solid #ef4444;">
                                <p style="margin: 0; text-align: left; color: #64748b;">
                                    <strong>Alasan:</strong><br>
                                    <span style="font-style: italic;">"${reason}"</span>
                                </p>
                            </div>
                        ` : ''}
                        <p style="color: #64748b; margin-top: 1rem;">
                            Anggota akan menerima notifikasi penolakan ini.
                        </p>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '<i class="fas fa-check"></i> Ya, Tolak Peminjaman',
                cancelButtonText: '<i class="fas fa-arrow-left"></i> Kembali',
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                customClass: {
                    popup: 'swal-wide',
                    confirmButton: 'swal-btn-danger'
                },
                showLoaderOnConfirm: true,
                preConfirm: async () => {
                    try {
                        const response = await fetch(`/api/admin/loans/${loanId}/reject`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({ reason: reason || null })
                        });
                        
                        const data = await response.json();
                        
                        if (!data.success) {
                            throw new Error(data.message);
                        }
                        
                        return data;
                    } catch (error) {
                        Swal.showValidationMessage(`Gagal: ${error.message}`);
                    }
                },
                allowOutsideClick: () => !Swal.isLoading()
            });
            
            if (finalConfirm.isConfirmed) {
                await Swal.fire({
                    title: '<i class="fas fa-ban" style="color: #ef4444;"></i> Peminjaman Ditolak',
                    html: `
                        <p style="color: #64748b; margin-top: 1rem;">
                            Peminjaman telah ditolak.<br>
                            Anggota akan mendapatkan notifikasi penolakan.
                        </p>
                    `,
                    icon: 'info',
                    confirmButtonText: 'Tutup',
                    confirmButtonColor: '#64748b',
                    timer: 3000
                });
                loadLoanRequests();
            }
        }
        
        // View detail
        function viewDetail(loanId) {
            const loan = allLoans.find(l => l.id === loanId);
            if (!loan) return;
            
            const modalBody = document.getElementById('modalBody');
            modalBody.innerHTML = `
                ${loan.borrower_photo ? `
                    <div class="detail-row">
                        <div class="detail-label">
                            <i class="fas fa-camera"></i>
                            Foto Peminjam
                        </div>
                        <div class="detail-value">
                            <img src="/storage/${loan.borrower_photo}" alt="Borrower Photo" class="photo-preview" onerror="this.style.display='none'">
                        </div>
                    </div>
                ` : ''}
                <div class="detail-row">
                    <div class="detail-label">
                        <i class="fas fa-user"></i>
                        Nama Peminjam
                    </div>
                    <div class="detail-value">${loan.user.name}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">
                        <i class="fas fa-envelope"></i>
                        Email
                    </div>
                    <div class="detail-value">${loan.user.email}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">
                        <i class="fas fa-book"></i>
                        Judul Buku
                    </div>
                    <div class="detail-value">${loan.book.title}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">
                        <i class="fas fa-pen"></i>
                        Penulis
                    </div>
                    <div class="detail-value">${loan.book.author}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">
                        <i class="fas fa-info-circle"></i>
                        Status
                    </div>
                    <div class="detail-value">
                        <span class="status-badge ${loan.status}">
                            <i class="fas fa-circle"></i>
                            ${getStatusText(loan.status)}
                        </span>
                    </div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">
                        <i class="fas fa-calendar-plus"></i>
                        Tanggal Request
                    </div>
                    <div class="detail-value">${formatDate(loan.request_date)}</div>
                </div>
                ${loan.loan_date ? `
                    <div class="detail-row">
                        <div class="detail-label">
                            <i class="fas fa-calendar-check"></i>
                            Tanggal Pinjam
                        </div>
                        <div class="detail-value">${formatDate(loan.loan_date)}</div>
                    </div>
                ` : ''}
                ${loan.due_date ? `
                    <div class="detail-row">
                        <div class="detail-label">
                            <i class="fas fa-calendar-times"></i>
                            Jatuh Tempo
                        </div>
                        <div class="detail-value">${formatDate(loan.due_date)}</div>
                    </div>
                ` : ''}
                ${loan.nisn ? `
                    <div class="detail-row">
                        <div class="detail-label">
                            <i class="fas fa-id-card"></i>
                            NISN
                        </div>
                        <div class="detail-value">${loan.nisn}</div>
                    </div>
                ` : ''}
                ${loan.nis ? `
                    <div class="detail-row">
                        <div class="detail-label">
                            <i class="fas fa-id-badge"></i>
                            NIS
                        </div>
                        <div class="detail-value">${loan.nis}</div>
                    </div>
                ` : ''}
                <div class="detail-row">
                    <div class="detail-label">
                        <i class="fas fa-${loan.identification_method === 'qr_scan' ? 'qrcode' : 'keyboard'}"></i>
                        Metode Identifikasi
                    </div>
                    <div class="detail-value">${loan.identification_method === 'qr_scan' ? 'QR Scan' : 'Input Manual'}</div>
                </div>
                ${loan.notes ? `
                    <div class="detail-row">
                        <div class="detail-label">
                            <i class="fas fa-sticky-note"></i>
                            Catatan
                        </div>
                        <div class="detail-value">${loan.notes}</div>
                    </div>
                ` : ''}
            `;
            
            document.getElementById('detailModal').classList.add('active');
        }
        
        // Close modal
        function closeDetailModal() {
            document.getElementById('detailModal').classList.remove('active');
        }
        
        // Utility functions
        function getStatusText(status) {
            const statusMap = {
                'pending': 'Menunggu',
                'approved': 'Disetujui',
                'rejected': 'Ditolak',
                'borrowed': 'Dipinjam',
                'returned': 'Dikembalikan',
                'overdue': 'Terlambat'
            };
            return statusMap[status] || status;
        }
        
        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'long',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }
        
        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            loadLoanRequests();
            
            // Refresh every 30 seconds
            setInterval(loadLoanRequests, 30000);
        });
        
        // Close modal when clicking overlay
        document.getElementById('detailModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDetailModal();
            }
        });
    </script>
    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/js/dashboard.js']); ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\PERPUSTAKAAN\resources\views/dashboard/loan-requests.blade.php ENDPATH**/ ?>