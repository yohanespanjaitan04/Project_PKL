<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail User - Perpustakaan Universitas</title>
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
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 28px;
            color: #1f2937;
            font-weight: 600;
        }

        .back-button {
            padding: 10px 20px;
            background: #6b7280;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
            transition: background 0.2s ease;
        }

        .back-button:hover {
            background: #4b5563;
        }

        .user-detail-container {
            margin-bottom: 30px;
        }

        .details-card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            border: 1px solid #e5e7eb;
        }

        .details-title {
            font-size: 20px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f3f4f6;
        }

        .detail-row {
            display: grid;
            grid-template-columns: 1fr 2fr;
            padding: 15px 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 600;
            color: #374151;
            font-size: 14px;
        }

        .detail-value {
            color: #1f2937;
            font-size: 14px;
        }

        .action-buttons {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            border: 1px solid #e5e7eb;
            display: flex;
            gap: 15px;
            justify-content: flex-end;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: #3b82f6;
            color: white;
        }

        .btn-primary:hover {
            background: #2563eb;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #f3f4f6;
            color: #374151;
            border: 1px solid #d1d5db;
        }

        .btn-secondary:hover {
            background: #e5e7eb;
        }

        .btn-danger {
            background: #ef4444;
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
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

            .user-detail-container {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .detail-row {
                grid-template-columns: 1fr;
                gap: 5px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
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
            <h1>Detail User</h1>
            <a href="#" class="back-button">← Kembali</a>
        </div>

        <div class="user-detail-container">
            <div class="details-card">
                <div class="details-title">Informasi Lengkap</div>
                
                <div class="detail-row">
                    <div class="detail-label">Nama Lengkap</div>
                    <div class="detail-value">Dr. Sarah Johnson</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Email</div>
                    <div class="detail-value">sarah.johnson@university.edu</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Role</div>
                    <div class="detail-value">Dosen</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Department</div>
                    <div class="detail-value">Ekonomi</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">NIDN</div>
                    <div class="detail-value">1234567890</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">No Telp</div>
                    <div class="detail-value">1234567890</div>
                </div>


            </div>
        </div>


    </div>
</body>
</html>