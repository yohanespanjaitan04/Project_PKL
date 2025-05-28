<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus User - UPT PERPUS</title>
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
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 28px;
            color: #1f2937;
            font-weight: 600;
        }

        .breadcrumb {
            margin-bottom: 20px;
            font-size: 14px;
            color: #6b7280;
        }

        .breadcrumb a {
            color: #3b82f6;
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .breadcrumb span {
            margin: 0 8px;
        }

        .delete-container {
            max-width: 600px;
            margin: 0 auto;
        }

        .delete-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }

        .delete-header {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            padding: 25px;
            text-align: center;
        }

        .warning-icon {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 24px;
        }

        .delete-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .delete-subtitle {
            font-size: 16px;
            opacity: 0.9;
        }

        .delete-body {
            padding: 30px;
        }

        .warning-message {
            background: #fef3c7;
            border: 1px solid #f59e0b;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 25px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .warning-message-icon {
            color: #f59e0b;
            font-size: 20px;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .warning-message-text {
            color: #92400e;
            font-size: 14px;
            line-height: 1.5;
        }

        .user-details {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .user-details h3 {
            color: #1f2937;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .user-detail-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .user-detail-item:last-child {
            border-bottom: none;
        }

        .user-detail-label {
            font-weight: 500;
            color: #6b7280;
            width: 30%;
        }

        .user-detail-value {
            color: #1f2937;
            width: 70%;
            font-weight: 500;
        }

        .button-group {
            display: flex;
            gap: 12px;
            justify-content: center;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
            min-width: 120px;
            justify-content: center;
        }

        .btn-cancel {
            background: #f3f4f6;
            color: #374151;
            border: 1px solid #d1d5db;
        }

        .btn-cancel:hover {
            background: #e5e7eb;
            color: #1f2937;
            transform: translateY(-1px);
        }

        .btn-delete {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }

        .btn-delete:hover {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .confirmation-text {
            color: #6b7280;
            font-size: 14px;
            text-align: center;
            margin-bottom: 25px;
            line-height: 1.5;
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

            .button-group {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo-section">
            <div class="logo">UD</div>
            <div class="university-name">UNIVERSITAS</div>
            <div class="university-name">DIPONEGORO</div>
            <div class="library-name">UPT PERPUS</div>
            <div class="user-info">
                <div class="user-avatar">👤</div>
                <div>
                    <div style="font-weight: 600;">Adi</div>
                    <div style="font-size: 12px; opacity: 0.8;">Admin</div>
                </div>
            </div>
        </div>
        
        <div class="nav-menu">
            <a href="#" class="nav-item">
                <div class="nav-icon">📊</div>
                Dashboard
            </a>
            <a href="#" class="nav-item active">
                <div class="nav-icon">👥</div>
                User Manajemen
            </a>
            <a href="#" class="nav-item">
                <div class="nav-icon">👤</div>
                Profil
            </a>
        </div>
    </div>

    <div class="main-content">
        <div class="header">
            <div class="breadcrumb">
                <a href="#">Dashboard</a>
                <span>›</span>
                <a href="#">User Manajemen</a>
                <span>›</span>
                <span style="color: #1f2937;">Hapus User</span>
            </div>
            <h1>Hapus User</h1>
        </div>

        <div class="delete-container">
            <div class="delete-card">
                <div class="delete-header">
                    <div class="warning-icon">⚠️</div>
                    <div class="delete-title">Konfirmasi Penghapusan</div>
                    <div class="delete-subtitle">Tindakan ini tidak dapat dibatalkan</div>
                </div>

                <div class="delete-body">
                    <div class="warning-message">
                        <div class="warning-message-icon">⚠️</div>
                        <div class="warning-message-text">
                            <strong>Peringatan:</strong> Menghapus user akan menghapus semua data yang terkait secara permanen. Pastikan Anda yakin dengan keputusan ini karena tindakan ini tidak dapat dibatalkan.
                        </div>
                    </div>

                    <div class="user-details">
                        <h3>Detail User yang akan dihapus:</h3>
                        <div class="user-detail-item">
                            <span class="user-detail-label">Nama:</span>
                            <span class="user-detail-value">Dr. Sarah Johnson</span>
                        </div>
                        <div class="user-detail-item">
                            <span class="user-detail-label">Email:</span>
                            <span class="user-detail-value">sarah.johnson@university.edu</span>
                        </div>
                        <div class="user-detail-item">
                            <span class="user-detail-label">Role:</span>
                            <span class="user-detail-value">Dosen</span>
                        </div>
                        <div class="user-detail-item">
                            <span class="user-detail-label">Department:</span>
                            <span class="user-detail-value">Ekonomi</span>
                        </div>
                        <div class="user-detail-item">
                            <span class="user-detail-label">Tanggal Dibuat:</span>
                            <span class="user-detail-value">15 Januari 2024</span>
                        </div>
                    </div>

                    <div class="confirmation-text">
                        Apakah Anda yakin ingin menghapus user ini? Silakan konfirmasi dengan menekan tombol "Hapus User" di bawah ini.
                    </div>

                    <div class="button-group">
                        <a href="#" class="btn btn-cancel" onclick="history.back()">
                            ← Batal
                        </a>
                        <button class="btn btn-delete" onclick="confirmDelete()">
                            🗑️ Hapus User
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete() {
            // Simulasi proses penghapusan dengan konfirmasi tambahan
            const confirmed = confirm('Apakah Anda benar-benar yakin ingin menghapus user Dr. Sarah Johnson? Tindakan ini tidak dapat dibatalkan.');
            
            if (confirmed) {
                // Simulasi loading
                const deleteBtn = document.querySelector('.btn-delete');
                deleteBtn.innerHTML = '⏳ Menghapus...';
                deleteBtn.disabled = true;
                
                // Simulasi API call
                setTimeout(() => {
                    alert('User berhasil dihapus!');
                    // Redirect ke halaman user management
                    window.location.href = '#user-management';
                }, 2000);
            }
        }

        // Highlight active menu
        document.addEventListener('DOMContentLoaded', function() {
            // Focus management untuk accessibility
            const deleteButton = document.querySelector('.btn-delete');
            const cancelButton = document.querySelector('.btn-cancel');
            
            // Keyboard navigation
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    history.back();
                }
            });
        });
    </script>
</body>
</html>