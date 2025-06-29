<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PartnerController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\GadaController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\SendGridEmailController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\KasLogistikController;
use App\Http\Controllers\KasLokasiController;
use App\Http\Controllers\KasOperasionalController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\GajiController;
use App\Http\Controllers\DokumenController;


// Authentication routes with email verification enabled

// Homepage route



Route::get('/', [PartnerController::class, 'showUserHome'])->name('home');
// Authentication routes
Route::get('admin/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('admin/', [AuthController::class, 'login']);

Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('forgot.password.form');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('forgot.password');// Show reset password form (GET request)
Route::get('password/reset/{token}/{email}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');

// Handle password reset (POST request)
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset.password');
Route::get('/notifications', [NotificationController::class, 'fetchNotifications']);
Route::get('/notifications/read/{id}', [NotificationController::class, 'markAsRead'])
    ->name('notifications.markAsRead');

Route::get('/chart-data-invoice', [ChartController::class, 'getDataInvoice'])->name('chart.invoice');
Route::get('/chart-data-laporan', [ChartController::class, 'getDataLaporan'])->name('chart.laporan');
Route::get('/chart-garis-invoice', [ChartController::class, 'getInvoiceGaris']);
Route::get('/chart-garis-laporan', [ChartController::class, 'getLaporanGaris']);
Route::get('/send-email-form', [SendGridEmailController::class, 'showSendEmailForm'])->name('send.email.form');
Route::get('/send-email', [SendGridEmailController::class, 'sendEmailWithContent'])->name('send.email');
Route::get('/send-test-email', [SendGridEmailController::class, 'sendTestEmail'])->name('send.test.email');
Route::get(
    '/notifications/get',
    [App\Http\Controllers\NotificationController::class, 'getNotificationsData']
)->name('notifications.get');
Auth::routes();

// Static page routes
Route::view('/tentang', 'tentang_kami')->name('tentang-kami');
Route::resource('service', ServiceController::class);
Route::get('/layanan', [ServiceController::class, 'showUser'])->name('layanan');
Route::view('/programkerja', 'program_kerja')->name('program-kerja');
Route::view('/fasilitas', 'fasilitas')->name('fasilitas');
Route::get('/client', [PartnerController::class, 'showUser'])->name('client');
Route::view('/karir', 'karir')->name('karir');
// Menampilkan daftar gallery
Route::get('/gallery', [GalleryController::class, 'showUser'])->name('gallery');

Route::view('/kontak', 'kontak_kami')->name('kontak-kami');
Route::get('/article', [ArticleController::class, 'showUser'])->name('article');
Route::get('/article/{id}', [ArticleController::class, 'showReadmore'])->name('article.showReadmore');

// Admin routes with authentication and email verification middleware
Route::prefix('admin')->middleware(['auth'])->group(function () {

    // Dashboard route - only accessible to verified users
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/saldoutama', function () {
        return view('admin.saldo.index');
    });
    // Jasa management routes
    Route::resource('service', ServiceController::class);
Route::get('/service', [ServiceController::class, 'index'])->name('admin.service.index');
Route::get('/service/create', [ServiceController::class, 'create'])->name('admin.service.create');
Route::put('/service/{service}', [ServiceController::class, 'update'])->name('admin.service.update');
Route::get('/service/edit/{id}', [ServiceController::class, 'edit'])->name('admin.service.edit'); // Corrected route
Route::post('/service/store', [ServiceController::class, 'store'])->name('admin.service.store');
Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('admin.service.destroy');
Route::get('/services/{id}', [ServiceController::class, 'show'])->name('admin.service.show');

// In web.php (routes file)
Route::get('storage/{file}', function ($file) {
    $path = storage_path('app/' . $file);

    if (file_exists($path)) {
        return response()->file($path);
    }

    abort(404);
})->name('storage.file');
Route::get('/laporanmasalah', function () {
    return view('admin.report.index');
});

Route::get('/laporanmasalah/detail', function () {
    return view('admin.report.detail');
})->name('laporanmasalah.detail');
Route::get('/invoice', function () {
    return view('admin.invoice.index');
});
Route::get('/invoice/detail', function () {
    return view('admin.invoice.detail');
})->name('invoice.detail');
Route::get('/gaji', function () {
    return view('admin.gaji.index');
});
Route::get('/gaji/detail', function () {
    return view('admin.gaji.detail');
})->name('gaji.detail');
Route::get('/kasoperasional', function () {
    return view('admin.kasoperasional.index');
});
Route::get('/kasoperasional/detail', function () {
    return view('admin.kasoperasional.detail');
})->name('kasoperasional.detail');

Route::get('/kasoperasional/tambahsaldo', function () {
    return view('admin.kasoperasional.tambah');
})->name('kasoperasional.tambah');
Route::get('/kaslokasi', function () {
    return view('admin.kaslokasi.index');
});
Route::get('/kaslokasi/tambahsaldo', function () {
    return view('admin.kaslokasi.tambah');
})->name('kaslokasi.tambah');
Route::get('/kaslogistik', function () {
    return view('admin.kaslogistik.index');
});
Route::get('/kaslogistik/tambahsaldo', function () {
    return view('admin.kaslogistik.tambah');
})->name('kaslogistik.tambah');
Route::get('/kaslogistik/detail', function () {
    return view('admin.kaslogistik.detail');
})->name('kaslogistik.detail');
Route::get('/barang', function () {
    return view('admin.stockbarang.index');
});
Route::get('/barang/tambahsaldo', function () {
    return view('admin.stockbarang.tambah');
})->name('stockbarang.tambah');
Route::get('/barang/detail', function () {
    return view('admin.stockbarang.detail');
})->name('stockbarang.detail');
Route::get('/distribusi', function () {
    return view('admin.distribusi.index');
});
Route::get('/distribusi/tambahsaldo', function () {
    return view('admin.distribusi.tambah');
})->name('distribusi.tambah');
Route::get('/distribusi/detail', function () {
    return view('admin.distribusi.detail');
})->name('distribusi.detail');
Route::get('/inventaris', function () {
    return view('admin.inventaris.index');
});
Route::get('/inventaris/tambahsaldo', function () {
    return view('admin.inventaris.tambah');
})->name('inventaris.tambah');
Route::get('/inventaris/detail', function () {
    return view('admin.inventaris.detail');
})->name('inventaris.detail');
    // Partner management routes
    Route::resource('partner', PartnerController::class);

Route::get('/partner', [PartnerController::class, 'index'])->name('admin.partner.index');
Route::get('/partner/create', [PartnerController::class, 'create'])->name('admin.partner.create');
Route::put('/partner/{partner}', [PartnerController::class, 'update'])->name('admin.partner.update');
Route::get('/partner/edit/{id}', [PartnerController::class, 'edit'])->name('admin.partner.edit'); // Corrected route
Route::post('/partner/store', [PartnerController::class, 'store'])->name('admin.partner.store');
Route::delete('/partners/{partner}', [PartnerController::class, 'destroy'])->name('admin.partner.destroy');
Route::get('/partners/{id}', [PartnerController::class, 'show'])->name('admin.partner.show');
Route::get('/partner/{id}/employees', [PartnerController::class, 'getEmployees']);


    // Email verification routes (handled by Auth::routes(['verify' => true]))
    // These are only needed if you have custom logic; otherwise, they're covered by Auth::routes(['verify' => true])
    Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->middleware('auth')->name('verification.verify');
    Route::post('/email/resend', [VerificationController::class, 'resend'])->middleware('auth')->name('verification.resend');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::resource('article', ArticleController::class);
Route::get('/article', [ArticleController::class, 'index'])->name('admin.article.index');
Route::get('/article/create', [ArticleController::class, 'create'])->name('admin.article.create');
Route::put('/article/{article}', [ArticleController::class, 'update'])->name('admin.article.update');
Route::get('/article/edit/{id}', [ArticleController::class, 'edit'])->name('admin.article.edit');
Route::post('/article/store', [ArticleController::class, 'store'])->name('admin.article.store');
Route::delete('/article/{article}', [ArticleController::class, 'destroy'])->name('admin.article.destroy');
Route::get('/article/{id}', [ArticleController::class, 'show'])->name('admin.article.show');


Route::resource('gallery', GalleryController::class);
Route::get('/gallery', [GalleryController::class, 'index'])->name('admin.gallery.index');
Route::get('/gallery/create', [GalleryController::class, 'create'])->name('admin.gallery.create');
Route::put('/gallery/{gallery}', [GalleryController::class, 'update'])->name('admin.gallery.update');
Route::get('/gallery/edit/{id}', [GalleryController::class, 'edit'])->name('admin.gallery.edit');
Route::post('/gallery/store', [GalleryController::class, 'store'])->name('admin.gallery.store');
Route::delete('/gallery/{gallery}', [GalleryController::class, 'destroy'])->name('admin.gallery.destroy');
Route::get('/gallery/{id}', [GalleryController::class, 'show'])->name('admin.gallery.show');

Route::resource('user', UserController::class);
Route::get('/user', [UserController::class, 'index'])->name('admin.user.index');
Route::get('/user/create', [UserController::class, 'create'])->name('admin.user.create');
Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('admin.user.edit');
Route::put('/user/edit/{user}', [UserController::class, 'update'])->name('admin.user.update');
Route::post('/user/store', [UserController::class, 'store'])->name('admin.user.store');
Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('admin.user.destroy');
Route::delete('/user/{id}', [UserController::class, 'show'])->name('admin.user.show');

Route::post('/employee/import', [EmployeeController::class, 'import'])->name('admin.employee.import');
Route::get('/employee/export', [EmployeeController::class, 'export'])->name('admin.employee.export');

Route::get('/employee/{id}/certificate', [EmployeeController::class, 'exportCertificate'])->name('admin.employee.certificate');
Route::get('/employee/{id}/pictktp', [EmployeeController::class, 'exportPictKTP'])->name('admin.employee.pictktp');

Route::resource('employee', EmployeeController::class);
Route::get('/employee', [EmployeeController::class, 'index'])->name('admin.employee.index');
Route::get('/employee/create', [EmployeeController::class, 'create'])->name('admin.employee.create');
Route::put('/employee/edit/{employee}', [EmployeeController::class, 'update'])->name('admin.employee.update');
Route::get('/employee/{id}/edit', [EmployeeController::class, 'edit'])->name('admin.employee.edit');
Route::post('/employee/store', [EmployeeController::class, 'store'])->name('admin.employee.store');
Route::delete('/employee/{employee}', [EmployeeController::class, 'destroy'])->name('admin.employee.destroy');
Route::put('/admin/employee/{id}/aktif', [EmployeeController::class, 'aktif'])->name('admin.employee.aktif');
Route::put('/admin/employee/{id}/nonaktif', [EmployeeController::class, 'nonaktif'])->name('admin.employee.nonaktif');
Route::put('/admin/employee/{id}/blacklist', [EmployeeController::class, 'blacklist'])->name('admin.employee.blacklist');
Route::get('/employee/{id}', [EmployeeController::class, 'show'])->name('admin.employee.show');



Route::resource('departemen', DepartemenController::class);
Route::get('/departemen', [DepartemenController::class, 'index'])->name('admin.departemen.index');
Route::get('/departemen/create', [DepartemenController::class, 'create'])->name('admin.departemen.create');
Route::put('/departemen/edit/{departemen}', [DepartemenController::class, 'update'])->name('admin.departemen.update');
Route::get('/departemen/edit/{id}', [DepartemenController::class, 'edit'])->name('admin.departemen.edit');
Route::post('/departemen/store', [DepartemenController::class, 'store'])->name('admin.departemen.store');
Route::delete('/departemen/{departemen}', [DepartemenController::class, 'destroy'])->name('admin.departemen.destroy');
Route::get('/departemen/{id}', [DepartemenController::class, 'show'])->name('admin.departemen.show');

Route::resource('jabatan', JabatanController::class);
Route::get('/jabatan', [JabatanController::class, 'index'])->name('admin.jabatan.index');
Route::get('/jabatan/create', [JabatanController::class, 'create'])->name('admin.jabatan.create');
Route::put('/jabatan/edit/{jabatan}', [JabatanController::class, 'update'])->name('admin.jabatan.update');
Route::get('/jabatan/edit/{id}', [JabatanController::class, 'edit'])->name('admin.jabatan.edit');
Route::post('/jabatan/store', [JabatanController::class, 'store'])->name('admin.jabatan.store');
Route::delete('/jabatan/{jabatan}', [JabatanController::class, 'destroy'])->name('admin.jabatan.destroy');
Route::get('/jabatan/{id}', [JabatanController::class, 'show'])->name('admin.jabatan.show');

Route::resource('gada', GadaController::class);
Route::get('/gada', [GadaController::class, 'index'])->name('admin.gada.index');
Route::get('/gada/create', [GadaController::class, 'create'])->name('admin.gada.create');
Route::put('/gada/edit/{gada}', [GadaController::class, 'update'])->name('admin.gada.update');
Route::get('/gada/edit/{id}', [GadaController::class, 'edit'])->name('admin.gada.edit');
Route::post('/gada/store', [GadaController::class, 'store'])->name('admin.gada.store');
Route::delete('/gada/{gada}', [GadaController::class, 'destroy'])->name('admin.gada.destroy');
Route::get('/gada/{id}', [GadaController::class, 'show'])->name('admin.gada.show');
});

// Visitor cookie route
Route::get('/set-visitor-cookie', [VisitorController::class, 'setVisitorCookie']);

// Default home route, only used if needed
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//kaslogistik

Route::get('/', [KasLogistikController::class, 'index']);
Route::post('/kas-logistik/tambah', [KasLogistikController::class, 'store'])->name('kaslogistik.store');
Route::post('/kas-logistik/kredit', [KasLogistikController::class, 'kredit'])->name('kaslogistik.kredit');
Route::get('/admin/kaslogistik', [KasLogistikController::class, 'index'])->name('kaslogistik.index');

//kaslokasi
Route::get('/admin/kaslokasi', [KasLokasiController::class, 'index']);
Route::post('/admin/kaslokasi/store', [KasLokasiController::class, 'store'])->name('kaslokasi.store');
Route::post('/admin/kaslokasi/kredit', [KasLokasiController::class, 'kredit'])->name('kaslokasi.kredit');

//kasoperasional
Route::get('/admin/kasoperasional', [KasOperasionalController::class, 'index']);
Route::post('/admin/kasoperasional/store', [KasOperasionalController::class, 'store'])->name('kasoperasional.store');
Route::post('/admin/kasoperasional/kredit', [KasOperasionalController::class, 'kredit'])->name('kasoperasional.kredit');



//pengaduan

    Route::get('/admin/laporanmasalah', [PengaduanController::class, 'index'])->name('pengaduan.index');
    Route::get('/laporanmasalah/create', [PengaduanController::class, 'create'])->name('pengaduan.create');
    Route::post('/laporanmasalah', [PengaduanController::class, 'store'])->name('pengaduan.store');
    Route::get('/laporanmasalah/{id}', [PengaduanController::class, 'show'])->name('laporanmasalah.detail');
Route::get('/laporanmasalah/{id}/validasi', [PengaduanController::class, 'validasi'])->name('pengaduan.validasi');
Route::get('/laporanmasalah/{id}/approve', [PengaduanController::class, 'approve'])->name('pengaduan.approve');
Route::get('/laporanmasalah/{id}/logs', [PengaduanController::class, 'showLogs'])->name('pengaduan.logs');
Route::post('/laporanmasalah/{id}/logs', [PengaduanController::class, 'storeLog'])->name('pengaduan.storeLog');
Route::get('/laporanmasalah/{id}/logs/create', [PengaduanController::class, 'createLog'])->name('pengaduan.createLog');
Route::get('/laporanmasalah/{id}/logs/{logId}/edit', [PengaduanController::class, 'editLog'])->name('pengaduan.editLog');


// gaji
Route::get('/admin/gaji', [GajiController::class, 'index'])->name('gaji.index');
Route::get('/admin/gaji/create', [GajiController::class, 'create'])->name('gaji.create');
Route::post('/admin/gaji', [GajiController::class, 'store'])->name('gaji.store');
Route::get('/admin/gaji/{id}', [GajiController::class, 'show'])->name('gaji.detail');
Route::get('/admin/gaji/{id}/konfirmasi', [GajiController::class, 'konfirmasi'])->name('gaji.konfirmasi');
Route::get('/gaji/{id}', [GajiController::class, 'show'])->name('gaji.detail');
Route::get('/admin/gaji/{id}/logs', [GajiController::class, 'showLogs'])->name('gaji.logs');



    //dokumenlokasi
        Route::get('/admin/dokumenlokasi', [DokumenController::class, 'index'])->name('dokumenlokasi.index');
        Route::get('/admindokumenlokasi/create', [DokumenController::class, 'create'])->name('dokumenlokasi.create');
        Route::post('/admindokumenlokasi', [DokumenController::class, 'store'])->name('dokumenlokasi.store');
        Route::delete('/admindokumenlokasi/{id}', [DokumenController::class, 'destroy'])->name('dokumenlokasi.destroy');
        Route::get('/dokumenlokasi/{id}/edit', [DokumenController::class, 'edit'])->name('dokumenlokasi.edit');
        Route::put('/dokumenlokasi/{id}', [DokumenController::class, 'update'])->name('dokumenlokasi.update');
        Route::delete('/dokumenlokasi/{id}', [DokumenController::class, 'destroy'])->name('dokumenlokasi.destroy');
        Route::get('/', function () { return redirect()->route('dokumenlokasi.index');});
        Route::resource('dokumenlokasi', DokumenController::class);