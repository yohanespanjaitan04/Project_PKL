<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard UPT Perpus</title>
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

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            border: 1px solid #e5e7eb;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .stat-title {
            font-size: 16px;
            color: #6b7280;
            font-weight: 500;
        }

        .stat-icon {
            width: 24px;
            height: 24px;
            opacity: 0.6;
        }

        .stat-number {
            font-size: 36px;
            font-weight: 700;
            color: #111827;
        }

        .history-section {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            border: 1px solid #e5e7eb;
        }

        .history-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .history-title {
            font-size: 20px;
            font-weight: 600;
            color: #1f2937;
        }

        .history-list {
            list-style: none;
        }

        .history-item {
            padding: 12px 0;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .history-item:last-child {
            border-bottom: none;
        }

        .history-dot {
            width: 8px;
            height: 8px;
            background: #3b82f6;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .history-text {
            color: #374151;
            font-size: 14px;
        }

        .history-link {
            color: #3b82f6;
            text-decoration: none;
        }

        .history-link:hover {
            text-decoration: underline;
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

            .stats-container {
                grid-template-columns: 1fr;
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
                    <div style="font-weight: 600;">ADI</div>
                    <div style="font-size: 12px; opacity: 0.8;">Admin</div>
                </div>
            </div>
        </div>

        <nav class="nav-menu">
            <a href="#" class="nav-item active">
                <div class="nav-icon">📊</div>
                Dashboard
            </a>
            <a href="#" class="nav-item">
                <div class="nav-icon">👥</div>
                User Manajemen
            </a>
            <a href="#" class="nav-item">
                <div class="nav-icon">+</div>
                Tambah jurnal
            </a>
            <a href="#" class="nav-item">
                <div class="nav-icon">👤</div>
                Profil
            </a>
        </nav>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Dashboard</h1>
        </div>

        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Total Buku</div>
                    <div class="stat-icon">📄</div>
                </div>
                <div class="stat-number">123</div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Total Jurnal</div>
                    <div class="stat-icon">📋</div>
                </div>
                <div class="stat-number">456</div>
            </div>
        </div>

        <div class="history-section">
            <div class="history-header">
                <div class="history-title">History</div>
                <div class="stat-icon">📋</div>
            </div>
            <ul class="history-list">
                <li class="history-item">
                    <div class="history-dot"></div>
                    <div class="history-text">
                        <a href="#" class="history-link">Bisnis</a>, joko Anwar, Erlangga, 2018
                    </div>
                </li>
                <li class="history-item">
                    <div class="history-dot"></div>
                    <div class="history-text">
                        <a href="#" class="history-link">Basis Data</a>, irfan, Erlangga, 2018
                    </div>
                </li>
                <li class="history-item">
                    <div class="history-dot"></div>
                    <div class="history-text">
                        <a href="#" class="history-link">Basis Data</a>, irfan, Erlangga, 2018
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <script>
        // Add some interactivity
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelectorAll('.nav-item').forEach(nav => nav.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Add hover effects to stat cards
        document.querySelectorAll('.stat-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-4px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    </script>
</body>
</html>