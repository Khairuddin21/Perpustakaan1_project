<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Kelola Anggota - <?php echo e(config('app.name', 'Sistem Perpustakaan')); ?></title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Custom Styles -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/dashboard.css', 'resources/js/dashboard.js']); ?>
    
    <style>
        .users-management-container {
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
        }
        
        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
        }
        
        /* Search & Filter Section */
        .search-filter-section {
            background: white;
            padding: 1.5rem;
            border-radius: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            margin-bottom: 2rem;
            border: 2px solid #e2e8f0;
        }
        
        .search-box {
            position: relative;
            flex: 1;
            max-width: 400px;
        }
        
        .search-box input {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 3rem;
            border: 2px solid #e2e8f0;
            border-radius: 0.75rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .search-box input:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }
        
        .search-box i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }
        
        /* Users Table */
        .users-table-container {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            overflow: hidden;
            border: 2px solid #e2e8f0;
        }
        
        .users-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .users-table thead {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
        }
        
        .users-table th {
            padding: 1.25rem 1.5rem;
            text-align: left;
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .users-table tbody tr {
            border-bottom: 1px solid #e2e8f0;
            transition: all 0.2s ease;
        }
        
        .users-table tbody tr:hover {
            background: #f8fafc;
        }
        
        .users-table td {
            padding: 1.25rem 1.5rem;
            color: #475569;
        }
        
        /* Role Badge */
        .role-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.375rem 0.875rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            gap: 0.375rem;
        }
        
        .role-badge.admin {
            background: #fee2e2;
            color: #dc2626;
        }
        
        .role-badge.pustakawan {
            background: #dbeafe;
            color: #2563eb;
        }
        
        .role-badge.anggota {
            background: #dcfce7;
            color: #16a34a;
        }
        
        /* Status Badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.375rem 0.875rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            gap: 0.375rem;
        }
        
        .status-badge.active {
            background: #dcfce7;
            color: #16a34a;
        }
        
        .status-badge.inactive {
            background: #fee2e2;
            color: #dc2626;
        }
        
        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }
        
        .btn-action {
            padding: 0.5rem 0.75rem;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .btn-edit {
            background: #dbeafe;
            color: #2563eb;
        }
        
        .btn-edit:hover {
            background: #2563eb;
            color: white;
        }
        
        .btn-toggle {
            background: #fef3c7;
            color: #d97706;
        }
        
        .btn-toggle:hover {
            background: #d97706;
            color: white;
        }
        
        .btn-delete {
            background: #fee2e2;
            color: #dc2626;
        }
        
        .btn-delete:hover {
            background: #dc2626;
            color: white;
        }
        
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
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
        
        .modal-content {
            background-color: white;
            margin: 5% auto;
            padding: 0;
            border-radius: 1rem;
            max-width: 600px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideDown 0.3s ease;
        }
        
        @keyframes slideDown {
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
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            padding: 1.5rem;
            border-radius: 1rem 1rem 0 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .modal-header h2 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .close {
            color: white;
            font-size: 2rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.2s ease;
            line-height: 1;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.5rem;
        }
        
        .close:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        
        .modal-body {
            padding: 2rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #1e293b;
            font-weight: 600;
            font-size: 0.875rem;
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.875rem;
            border: 2px solid #e2e8f0;
            border-radius: 0.75rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
        }
        
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }
        
        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }
        
        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            padding-top: 1rem;
            border-top: 2px solid #e2e8f0;
        }
        
        .btn-submit {
            padding: 0.875rem 2rem;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            border: none;
            border-radius: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
        }
        
        .btn-cancel {
            padding: 0.875rem 2rem;
            background: #f1f5f9;
            color: #475569;
            border: none;
            border-radius: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-cancel:hover {
            background: #e2e8f0;
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #94a3b8;
        }
        
        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }
        
        .empty-state p {
            font-size: 1.125rem;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Admin Sidebar -->
        <?php echo $__env->make('components.admin-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        
        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Navigation -->
            <nav class="top-nav">
                <button class="menu-toggle" id="menuToggle">
                    <i class="fas fa-bars"></i>
                </button>
                
                <div class="nav-right">
                    <div class="user-info">
                        <span class="user-name"><?php echo e(auth()->user()->name); ?></span>
                        <span class="user-role"><?php echo e(ucfirst(auth()->user()->role)); ?></span>
                    </div>
                    
                    <form action="<?php echo e(route('logout')); ?>" method="POST" style="display: inline;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn-logout">
                            <i class="fas fa-sign-out-alt"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </nav>
            
            <!-- Content Area -->
            <div class="users-management-container">
                <!-- Page Header -->
                <div class="page-header">
                    <div class="header-left">
                        <h1>
                            <i class="fas fa-users"></i>
                            Kelola Anggota
                        </h1>
                        <p>Kelola data pengguna sistem perpustakaan</p>
                    </div>
                    <div class="header-actions">
                        <button class="btn-add" onclick="openAddModal()">
                            <i class="fas fa-plus"></i>
                            Tambah Anggota
                        </button>
                    </div>
                </div>
                
                <!-- Search & Filter Section -->
                <div class="search-filter-section">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchInput" placeholder="Cari anggota...">
                    </div>
                </div>
                
                <!-- Users Table -->
                <div class="users-table-container">
                    <table class="users-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Telepon</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="usersTableBody">
                            <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr data-user-id="<?php echo e($user->id); ?>">
                                <td><?php echo e($index + 1); ?></td>
                                <td>
                                    <strong><?php echo e($user->name); ?></strong>
                                    <?php if($user->id === auth()->user()->id): ?>
                                    <span style="color: #6366f1; font-size: 0.75rem;">(Anda)</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($user->email); ?></td>
                                <td>
                                    <span class="role-badge <?php echo e($user->role); ?>">
                                        <?php if($user->role === 'admin'): ?>
                                            <i class="fas fa-crown"></i>
                                        <?php elseif($user->role === 'pustakawan'): ?>
                                            <i class="fas fa-user-tie"></i>
                                        <?php else: ?>
                                            <i class="fas fa-user"></i>
                                        <?php endif; ?>
                                        <?php echo e(ucfirst($user->role)); ?>

                                    </span>
                                </td>
                                <td><?php echo e($user->phone ?? '-'); ?></td>
                                <td>
                                    <span class="status-badge <?php echo e($user->is_active ? 'active' : 'inactive'); ?>">
                                        <i class="fas fa-circle"></i>
                                        <?php echo e($user->is_active ? 'Aktif' : 'Nonaktif'); ?>

                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-action btn-edit" onclick="openEditModal(<?php echo e($user->id); ?>)">
                                            <i class="fas fa-edit"></i>
                                            Edit
                                        </button>
                                        <?php if($user->id !== auth()->user()->id): ?>
                                        <button class="btn-action btn-toggle" onclick="toggleStatus(<?php echo e($user->id); ?>)">
                                            <i class="fas fa-toggle-on"></i>
                                            Toggle
                                        </button>
                                        <button class="btn-action btn-delete" onclick="deleteUser(<?php echo e($user->id); ?>)">
                                            <i class="fas fa-trash"></i>
                                            Hapus
                                        </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <i class="fas fa-users"></i>
                                        <p>Belum ada data anggota</p>
                                    </div>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
    
    <!-- Add/Edit User Modal -->
    <div id="userModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>
                    <i class="fas fa-user-plus"></i>
                    <span id="modalTitle">Tambah Anggota</span>
                </h2>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <div class="modal-body">
                <form id="userForm">
                    <input type="hidden" id="userId" name="user_id">
                    
                    <div class="form-group">
                        <label for="name">Nama Lengkap <span style="color: #dc2626;">*</span></label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email <span style="color: #dc2626;">*</span></label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password <span style="color: #dc2626;" id="passwordRequired">*</span></label>
                        <input type="password" id="password" name="password">
                        <small style="color: #64748b; font-size: 0.875rem;" id="passwordHint">
                            Minimal 8 karakter
                        </small>
                    </div>
                    
                    <div class="form-group">
                        <label for="role">Role <span style="color: #dc2626;">*</span></label>
                        <select id="role" name="role" required>
                            <option value="">Pilih Role</option>
                            <option value="admin">Admin</option>
                            <option value="pustakawan">Pustakawan</option>
                            <option value="anggota">Anggota</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Nomor Telepon</label>
                        <input type="text" id="phone" name="phone">
                    </div>
                    
                    <div class="form-group">
                        <label for="address">Alamat</label>
                        <textarea id="address" name="address" rows="3"></textarea>
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-save"></i>
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        // CSRF Token Setup
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Modal Functions
        function openAddModal() {
            document.getElementById('modalTitle').innerHTML = '<i class="fas fa-user-plus"></i> Tambah Anggota';
            document.getElementById('userForm').reset();
            document.getElementById('userId').value = '';
            document.getElementById('passwordRequired').style.display = 'inline';
            document.getElementById('password').required = true;
            document.getElementById('passwordHint').textContent = 'Minimal 8 karakter';
            document.getElementById('userModal').style.display = 'block';
        }
        
        function openEditModal(userId) {
            document.getElementById('modalTitle').innerHTML = '<i class="fas fa-edit"></i> Edit Anggota';
            document.getElementById('passwordRequired').style.display = 'none';
            document.getElementById('password').required = false;
            document.getElementById('passwordHint').textContent = 'Kosongkan jika tidak ingin mengubah password';
            
            // Fetch user data
            fetch(`/admin/users/${userId}/edit`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const user = data.user;
                    document.getElementById('userId').value = user.id;
                    document.getElementById('name').value = user.name;
                    document.getElementById('email').value = user.email;
                    document.getElementById('role').value = user.role;
                    document.getElementById('phone').value = user.phone || '';
                    document.getElementById('address').value = user.address || '';
                    document.getElementById('userModal').style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Gagal mengambil data anggota'
                });
            });
        }
        
        function closeModal() {
            document.getElementById('userModal').style.display = 'none';
            document.getElementById('userForm').reset();
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('userModal');
            if (event.target == modal) {
                closeModal();
            }
        }
        
        // Form Submit
        document.getElementById('userForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const userId = document.getElementById('userId').value;
            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());
            
            // Remove password if empty in edit mode
            if (userId && !data.password) {
                delete data.password;
            }
            
            const url = userId ? `/admin/users/${userId}` : '/admin/users';
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    let errorMessage = data.message;
                    if (data.errors) {
                        errorMessage = Object.values(data.errors).flat().join('\n');
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat menyimpan data'
                });
            });
        });
        
        // Toggle Status
        function toggleStatus(userId) {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Ubah status anggota ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Ubah',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#6366f1',
                cancelButtonColor: '#94a3b8'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/users/${userId}/toggle-status`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: data.message,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan'
                        });
                    });
                }
            });
        }
        
        // Delete User
        function deleteUser(userId) {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: 'Yakin ingin menghapus anggota ini? Data tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#94a3b8'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/users/${userId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: data.message,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan saat menghapus data'
                        });
                    });
                }
            });
        }
        
        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('#usersTableBody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\Perpustakaan1_project\resources\views/dashboard/admin-users.blade.php ENDPATH**/ ?>