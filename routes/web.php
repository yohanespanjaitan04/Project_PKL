<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserManajemenController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Middleware\RoleMiddleware; // Import middleware

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Protected Routes - Authenticated Users Only (General Access)
|--------------------------------------------------------------------------
| Route di sini adalah route yang bisa diakses oleh SEMUA user yang sudah login,
| tanpa mempedulikan role khusus, kecuali ada pengecekan di controller/middleware lain.
*/
Route::middleware(['auth'])->group(function () {
    // General Dashboard (bisa diarahkan berdasarkan role di DashboardController)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes (akses profil pribadi)
    Route::get('/profil', [AuthController::class, 'profile'])->name('profil');
    Route::get('/profil/edit', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');

    // AJAX Routes untuk dropdown dinamis (dapat diakses oleh semua yang login)
    Route::get('/getProdi', [JurnalController::class, 'getProdi'])->name('getProdi');
    Route::get('/getSemester', [JurnalController::class, 'getSemester'])->name('getSemester');
    Route::get('/getMataKuliah', [JurnalController::class, 'getMataKuliah'])->name('getMataKuliah');

    // Home controller routes - GENERAL (dengan logic role-based di HomeController)
    // Ini adalah route yang Anda gunakan untuk tampilan dashboard umum
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Personal jurnal routes untuk user yang login (Dosen/Mahasiswa)
    // Ini mengacu pada daftar jurnal yang dibuat oleh user tersebut
    // URL: /jurnal-saya
    Route::get('/jurnal-saya', [JurnalController::class, 'index'])->name('jurnal.my');
    // Jika 'Jurnal Baru' mengarah ke form create, gunakan route di bawah
    Route::get('/jurnal-baru', [JurnalController::class, 'create'])->name('jurnal.new'); // Mengarahkan ke form create

    // Main jurnal creation/editing routes for authenticated users (specifically Dosen/Admin through middleware/logic)
    // Ini harusnya digunakan oleh Dosen dan Admin untuk CREATE, EDIT, DELETE jurnal.
    // URL: /jurnal, /jurnal/create, etc.
    // Penting: HANYA route ini yang boleh menjadi dasar untuk logic request->is() di JurnalController
    Route::resource('jurnal', JurnalController::class)->except(['index', 'show', 'download']); // index, show, download akan didefinisikan ulang di bawah
    Route::get('/jurnal', [JurnalController::class, 'index'])->name('jurnal.index'); // Override index untuk kontrol role
    Route::get('/jurnal/{jurnal}', [JurnalController::class, 'show'])->name('jurnal.show');
    Route::get('/jurnal/{jurnal}/download', [JurnalController::class, 'download'])->name('jurnal.download');


    // Bulk edit routes - HANYA UNTUK DOSEN DAN ADMIN (authorization di controller)
    Route::post('/jurnal/bulk-edit', [HomeController::class, 'bulkEdit'])->name('jurnal.bulk-edit');
    Route::post('/jurnal/bulk-update', [HomeController::class, 'bulkUpdate'])->name('jurnal.bulk-update');
});


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
| Route khusus untuk Admin, dengan prefix 'admin'.
| Logic 'request()->is('admin/*')' di controller akan bekerja di sini.
*/
Route::middleware(['auth', RoleMiddleware::class.':admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profil', [AdminProfileController::class, 'show'])->name('profil');
    // User Management (Admin Only)
    // Ini adalah resource yang mengelola user, jadi pastikan UserManajemenController mengelola ini
    Route::resource('users', UserManajemenController::class)->except(['show']); // Contoh: 'users' bukan 'UserManajemen'
    // Jika Anda ingin route spesifik seperti /admin/user atau /admin/users
    // Route::get('/user', [UserManajemenController::class, 'index'])->name('user.index'); // Kalau mau spesifik /admin/user
    // Route::get('/users', [UserManajemenController::class, 'index'])->name('users.index'); // Ini sudah ditangani resource
Route::resource('jurnal', JurnalController::class); // Ini akan membuat admin.jurnal.index, .create, .store, .edit, .update, .destroy
    // Admin dapat melihat semua jurnal (bukan hanya miliknya)
    // Route::get('/jurnals', [JurnalController::class, 'index'])->name('jurnals.index'); // Jika ingin membedakan index admin
    // Route::resource('jurnal', JurnalController::class); // Ini sudah ditangani di group 'Authenticated Users' agar tidak duplikat logic di controller
    // Namun jika admin memiliki fitur berbeda untuk jurnal (misal: manage all jurnal), maka bisa diaktifkan kembali
    // Tapi akan lebih baik jika JurnalController::index itu sendiri yang menentukan
    // berdasarkan role user yang sedang mengaksesnya dari route umum '/jurnal'.
    // Atau jika ada tampilan khusus admin untuk jurnal, gunakan controller terpisah atau method terpisah.
});


/*
|--------------------------------------------------------------------------
| Dosen Routes
|--------------------------------------------------------------------------
| Route khusus untuk Dosen, dengan prefix 'dosen'.
| Logic 'request()->is('dosen/*')' (jika Anda menambahkannya) akan bekerja di sini.
*/
Route::middleware(['auth', RoleMiddleware::class.':dosen,admin'])->prefix('dosen')->name('dosen.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/jurnal', [JurnalController::class, 'index'])->name('jurnal.index');

    // Dosen bisa mengelola jurnal mereka sendiri.
    // Jika Route::resource('jurnal', JurnalController::class) yang di atas sudah mencukupi,
    // maka ini mungkin tidak perlu duplikat.
    // Namun, jika /dosen/jurnal punya tampilan berbeda, biarkan ini.
    // Karena Anda sudah punya '/jurnal-saya' di atas, ini bisa jadi duplikat fungsionalitas.
    // Saran: hapus resource ini jika '/jurnal-saya' sudah cukup.
    // Route::resource('jurnal', JurnalController::class); // Hati-hati duplikasi logic.
    // Jika Anda ingin /dosen/jurnal juga menampilkan jurnal dosen,
    // maka JurnalController::index harus punya logic untuk itu berdasarkan Auth::user()->role.
});


/*
|--------------------------------------------------------------------------
| Mahasiswa Routes
|--------------------------------------------------------------------------
| Route khusus untuk Mahasiswa, dengan prefix 'mahasiswa'.
*/
Route::middleware(['auth', RoleMiddleware::class.':mahasiswa,dosen,admin'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Mahasiswa hanya bisa melihat daftar jurnal (semua jurnal)
    // Jika JurnalController::index sudah menangani filter berdasarkan role,
    // maka route ini bisa diarahkan ke route umum.
    // Atau jika ini adalah daftar jurnal yang bisa diakses mahasiswa (bukan jurnal-saya), ini bisa tetap.
    Route::get('/jurnal', [JurnalController::class, 'index'])->name('jurnal.index');
    Route::get('/jurnal/{jurnal}', [JurnalController::class, 'show'])->name('jurnal.show');
    Route::get('/jurnal/{jurnal}/download', [JurnalController::class, 'download'])->name('jurnal.download');
});