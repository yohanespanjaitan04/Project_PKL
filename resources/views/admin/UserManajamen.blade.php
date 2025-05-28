<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Manajemen - UPT Perpus</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #4f46e5, #3b82f6);
            color: white;
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
        }

        .logo-section {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logo {
            width: 50px;
            height: 50px;
            background: white;
            border-radius: 50%;
            margin: 0 auto 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #4f46e5;
            font-size: 18px;
        }

        .university-name {
            font-size: 12px;
            margin-bottom: 5px;
            opacity: 0.9;
        }

        .library-name {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }

        .user-avatar {
            width: 24px;
            height: 24px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .nav-menu {
            padding: 20px 0;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            cursor: pointer;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.1);
            border-left-color: white;
        }

        .nav-item.active {
            background: rgba(255, 255, 255, 0.15);
            border-left-color: white;
        }

        .nav-icon {
            width: 20px;
            height: 20px;
            margin-right: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .main-content {
            margin-left: 250px;
            flex: 1;
            padding: 30px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 28px;
            color: #1f2937;
            font-weight: 600;
        }

        .add-user-btn {
            background: #3b82f6;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background 0.2s ease;
        }

        .add-user-btn:hover {
            background: #2563eb;
        }

        .table-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            background: #f9fafb;
            padding: 16px;
            text-align: left;
            font-weight: 600;
            color: #374151;
            border-bottom: 1px solid #e5e7eb;
            font-size: 14px;
        }

        .table td {
            padding: 16px;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: top;
        }

        .table tr:last-child td {
            border-bottom: none;
        }

        .table tr:hover {
            background: #f9fafb;
        }

        .user-number {
            font-weight: 600;
            color: #1f2937;
            font-size: 16px;
        }

        .user-name {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 4px;
        }

        .user-email {
            color: #6b7280;
            font-size: 13px;
        }

        .role-badge {
            background: #f3f4f6;
            color: #374151;
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
        }

        .department {
            color: #374151;
            font-weight: 500;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .action-btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-view {
            background: #3b82f6;
            color: white;
        }

        .btn-view:hover {
            background: #2563eb;
        }

        .btn-edit {
            background: #10b981;
            color: white;
        }

        .btn-edit:hover {
            background: #059669;
        }

        .btn-delete {
            background: #ef4444;
            color: white;
        }

        .btn-delete:hover {
            background: #dc2626;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            margin-top: 20px;
        }

        .pagination-btn {
            width: 32px;
            height: 32px;
            border: 1px solid #d1d5db;
            background: white;
            color: #374151;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .pagination-btn:hover {
            background: #f3f4f6;
            border-color: #9ca3af;
        }

        .pagination-btn.active {
            background: #3b82f6;
            color: white;
            border-color: #3b82f6;
        }

        .pagination-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
            }

            .header {
                flex-direction: column;
                gap: 15px;
                align-items: stretch;
            }

            .table-container {
                overflow-x: auto;
            }

            .table {
                min-width: 700px;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo-section">
            <div class="logo">UD</div>
            <div class="university-name">UNIVERSITAS DIPONEGORO</div>
            <div class="library-name">UPT PERPUS</div>
            <div class="user-info">
                <div class="user-avatar">👤</div>
                <div>
                    <div style="font-weight: 600;">Adi</div>
                    <div style="font-size: 12px; opacity: 0.8;">Admin</div>
                </div>
            </div>
        </div>

        <nav class="nav-menu">
            <div class="nav-item" onclick="showDashboard()">
                <div class="nav-icon">📊</div>
                Dashboard
            </div>
            <div class="nav-item active" onclick="showUserManagement()">
                <div class="nav-icon">👥</div>
                User Manajemen
            </div>
            <div class="nav-item" onclick="showProfile()">
                <div class="nav-icon">👤</div>
                Profil
            </div>
        </nav>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Daftar User</h1>
            <button class="add-user-btn">
                <span>👤</span>
                Tambah User Baru
            </button>
        </div>

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>User</th>
                        <th>Role</th>
                        <th>Department</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="user-number">1</td>
                        <td>
                            <div class="user-name">Dr. Sarah Johnson</div>
                            <div class="user-email">sarah.johnson@university.edu</div>
                        </td>
                        <td>
                            <span class="role-badge">Dosen</span>
                        </td>
                        <td class="department">Ekonomi</td>
                        <td>
                            <div class="action-buttons">
                                <button class="action-btn btn-view">Lihat</button>
                                <button class="action-btn btn-edit">Edit</button>
                                <button class="action-btn btn-delete">Hapus</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="user-number">2</td>
                        <td>
                            <div class="user-name">Prof. Robert Chen</div>
                            <div class="user-email">robert.chen@university.edu</div>
                        </td>
                        <td>
                            <span class="role-badge">Dosen</span>
                        </td>
                        <td class="department">Kedokteran</td>
                        <td>
                            <div class="action-buttons">
                                <button class="action-btn btn-view">Lihat</button>
                                <button class="action-btn btn-edit">Edit</button>
                                <button class="action-btn btn-delete">Hapus</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="user-number">3</td>
                        <td>
                            <div class="user-name">Dr. Maria Gonzalez</div>
                            <div class="user-email">maria.gonzalez@university.edu</div>
                        </td>
                        <td>
                            <span class="role-badge">Dosen</span>
                        </td>
                        <td class="department">Hukum</td>
                        <td>
                            <div class="action-buttons">
                                <button class="action-btn btn-view">Lihat</button>
                                <button class="action-btn btn-edit">Edit</button>
                                <button class="action-btn btn-delete">Hapus</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="pagination">
            <button class="pagination-btn" disabled>‹</button>
            <button class="pagination-btn active">1</button>
            <button class="pagination-btn">2</button>
            <button class="pagination-btn">3</button>
            <button class="pagination-btn">›</button>
        </div>
    </div>

    <script>
        // Navigation functionality
        function showDashboard() {
            document.querySelectorAll('.nav-item').forEach(item => item.classList.remove('active'));
            event.target.closest('.nav-item').classList.add('active');
            // Here you would typically load the dashboard content
            console.log('Dashboard clicked');
        }

        function showUserManagement() {
            document.querySelectorAll('.nav-item').forEach(item => item.classList.remove('active'));
            event.target.closest('.nav-item').classList.add('active');
            console.log('User Management clicked');
        }

        function showProfile() {
            document.querySelectorAll('.nav-item').forEach(item => item.classList.remove('active'));
            event.target.closest('.nav-item').classList.add('active');
            console.log('Profile clicked');
        }

        // Table action buttons
        document.querySelectorAll('.btn-view').forEach(btn => {
            btn.addEventListener('click', function() {
                const row = this.closest('tr');
                const userName = row.querySelector('.user-name').textContent;
                alert(`Melihat detail ${userName}`);
            });
        });

        document.querySelectorAll('.btn-edit').forEach(btn => {
            btn.addEventListener('click', function() {
                const row = this.closest('tr');
                const userName = row.querySelector('.user-name').textContent;
                alert(`Mengedit ${userName}`);
            });
        });

        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', function() {
                const row = this.closest('tr');
                const userName = row.querySelector('.user-name').textContent;
                if (confirm(`Apakah Anda yakin ingin menghapus ${userName}?`)) {
                    row.remove();
                    alert(`${userName} telah dihapus`);
                }
            });
        });

        // Add user button
        document.querySelector('.add-user-btn').addEventListener('click', function() {
            alert('Form tambah user baru akan terbuka');
        });

        // Pagination functionality
        document.querySelectorAll('.pagination-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                if (!this.disabled && !this.classList.contains('active')) {
                    document.querySelectorAll('.pagination-btn').forEach(b => b.classList.remove('active'));
                    
                    if (this.textContent === '›') {
                        // Next page logic
                        console.log('Next page');
                    } else if (this.textContent === '‹') {
                        // Previous page logic
                        console.log('Previous page');
                    } else {
                        // Page number
                        this.classList.add('active');
                        console.log('Page', this.textContent);
                    }
                }
            });
        });

        // Table row hover effects
        document.querySelectorAll('.table tr').forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.01)';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>