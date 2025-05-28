<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User Baru</title>
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

        .breadcrumb {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .form-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            border: 1px solid #e5e7eb;
            padding: 30px;
        }

        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            flex: 1;
        }

        .form-group.full-width {
            width: 100%;
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="email"],
        select {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            background-color: white;
            transition: all 0.2s ease;
            font-family: inherit;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        select {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23374151' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px;
            padding-right: 40px;
        }

        .button-group {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }

        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            min-width: 100px;
            font-family: inherit;
        }

        .btn-cancel {
            background: #f9fafb;
            color: #374151;
            border: 1px solid #d1d5db;
        }

        .btn-cancel:hover {
            background: #f3f4f6;
            border-color: #9ca3af;
        }

        .btn-submit {
            background: #3b82f6;
            color: white;
        }

        .btn-submit:hover {
            background: #2563eb;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* Success Message */
        .success-message {
            background: #ecfdf5;
            border: 1px solid #10b981;
            color: #047857;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: none;
        }

        .success-message.show {
            display: block;
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

            .form-row {
                flex-direction: column;
                gap: 15px;
            }

            .button-group {
                flex-direction: column;
                align-items: stretch;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo-section">
            <div class="logo">UD</div>
            <div class="university-name">UNIVERSITAS DIPONEGORO</div>
            <div class="library-name">UPT PERPUS</div>
            <div class="user-info">
                <div class="user-avatar">
                    <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <div style="font-weight: 600;">Adi</div>
                    <div style="font-size: 12px; opacity: 0.8;">Admin</div>
                </div>
            </div>
        </div>
        
        <nav class="nav-menu">
            <a href="#" class="nav-item">
                <div class="nav-icon">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/>
                    </svg>
                </div>
                Dashboard
            </a>
            <a href="#" class="nav-item active">
                <div class="nav-icon">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M16 4c0-1.11.89-2 2-2s2 .89 2 2-.89 2-2 2-2-.89-2-2zm4 18v-6h2.5l-2.54-7.63A2.006 2.006 0 0 0 18 7c-.8 0-1.54.5-1.85 1.26l-1.92 5.63c-.1.29-.15.59-.15.89 0 1.1.9 2 2 2h.5v5c0 .55.45 1 1 1s1-.45 1-1zM12.5 11.5c.83 0 1.5-.67 1.5-1.5s-.67-1.5-1.5-1.5S11 9.17 11 10s.67 1.5 1.5 1.5zm1.5 1h-2c-.83 0-1.5.67-1.5 1.5v6c0 .83.67 1.5 1.5 1.5h2c.83 0 1.5-.67 1.5-1.5v-6c0-.83-.67-1.5-1.5-1.5zM5.5 6c1.11 0 2-.89 2-2s-.89-2-2-2-2 .89-2 2 .89 2 2 2zm2 16v-7H9v7c0 .55.45 1 1 1s1-.45 1-1zm-2.5-8.5c.28 0 .5-.22.5-.5s-.22-.5-.5-.5-.5.22-.5.5.22.5.5.5zm0-2c.83 0 1.5-.67 1.5-1.5S5.83 9 5 9s-1.5.67-1.5 1.5.67 1.5 1.5 1.5z"/>
                    </svg>
                </div>
                User Manajemen
            </a>
            <a href="#" class="nav-item">
                <div class="nav-icon">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
                Profil
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <div>
                <div class="breadcrumb">User Manajemen / Tambah User Baru</div>
                <h1>Add New User</h1>
            </div>
        </div>
        
        <div class="form-container">
            <div class="success-message" id="successMessage">
                User berhasil ditambahkan!
            </div>
            
            <form id="addUserForm">
                <div class="form-row">
                    <div class="form-group">
                        <label for="namaDepan">Nama Depan *</label>
                        <input type="text" id="namaDepan" name="namaDepan" required>
                    </div>
                    <div class="form-group">
                        <label for="namaBelakang">Nama Belakang *</label>
                        <input type="text" id="namaBelakang" name="namaBelakang" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="department">Department *</label>
                        <select id="department" name="department" required>
                            <option value="">Pilih Department</option>
                            <option value="Ekonomi">Ekonomi</option>
                            <option value="Kedokteran">Kedokteran</option>
                            <option value="Hukum">Hukum</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group full-width">
                        <label for="role">Role *</label>
                        <select id="role" name="role" required>
                            <option value="">Pilih Role</option>
                            <option value="Admin">Admin</option>
                            <option value="Dosen">Dosen</option>
                            <option value="Mahasiswa">Mahasiswa</option>
                        </select>
                    </div>
                </div>

                <div class="button-group">
                    <button type="button" class="btn btn-cancel" onclick="resetForm()">Batal</button>
                    <button type="submit" class="btn btn-submit">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('addUserForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const userData = {};
            
            for (let [key, value] of formData.entries()) {
                userData[key] = value;
            }
            
            console.log('Data User Baru:', userData);
            
            // Show success message
            const successMessage = document.getElementById('successMessage');
            successMessage.classList.add('show');
            
            // Hide success message after 3 seconds
            setTimeout(() => {
                successMessage.classList.remove('show');
            }, 3000);
            
            resetForm();
        });
        
        function resetForm() {
            document.getElementById('addUserForm').reset();
        }
        
        // Real-time validation
        const inputs = document.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (this.hasAttribute('required') && !this.value.trim()) {
                    this.style.borderColor = '#ef4444';
                } else {
                    this.style.borderColor = '#d1d5db';
                }
            });
            
            input.addEventListener('input', function() {
                if (this.style.borderColor === 'rgb(239, 68, 68)') {
                    this.style.borderColor = '#d1d5db';
                }
            });
        });

        // Email validation
        document.getElementById('email').addEventListener('input', function() {
            const email = this.value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (email && !emailRegex.test(email)) {
                this.style.borderColor = '#ef4444';
            } else {
                this.style.borderColor = '#d1d5db';
            }
        });
    </script>
</body>
</html>