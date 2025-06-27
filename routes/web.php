<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\WorkController;
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


Route::get('/send-email-form', [SendGridEmailController::class, 'showSendEmailForm'])->name('send.email.form');
Route::get('/send-email', [SendGridEmailController::class, 'sendEmailWithContent'])->name('send.email');
Route::get('/send-test-email', [SendGridEmailController::class, 'sendTestEmail'])->name('send.test.email');
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




    // Partner management routes
    Route::resource('partner', PartnerController::class);

Route::get('/partner', [PartnerController::class, 'index'])->name('admin.partner.index');
Route::get('/partner/create', [PartnerController::class, 'create'])->name('admin.partner.create');
Route::put('/partner/{partner}', [PartnerController::class, 'update'])->name('admin.partner.update');
Route::get('/partner/edit/{id}', [PartnerController::class, 'edit'])->name('admin.partner.edit'); // Corrected route
Route::post('/partner/store', [PartnerController::class, 'store'])->name('admin.partner.store');
Route::delete('/partners/{partner}', [PartnerController::class, 'destroy'])->name('admin.partner.destroy');
Route::get('/partners/{id}', [PartnerController::class, 'show'])->name('admin.partner.show');
Route::get('/partner/{id}/employees', [PartnerController::class, 'showEmployees'])->name('admin.partner.showemployee');


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

Route::get('/employee/{id}/pictdiri', [EmployeeController::class, 'exportFotodiri'])->name('admin.employee.diri');
Route::get('/employee/{id}/certificate', [EmployeeController::class, 'exportCertificate'])->name('admin.employee.sertifikat');
Route::get('/employee/{id}/certificate1', [EmployeeController::class, 'exportCertificate1'])->name('admin.employee.sertifikat1');
Route::get('/employee/{id}/certificate2', [EmployeeController::class, 'exportCertificate2'])->name('admin.employee.sertifikat2');
Route::get('/employee/{id}/certificate3', [EmployeeController::class, 'exportCertificate3'])->name('admin.employee.sertifikat3');
Route::get('/employee/{id}/pictktp', [EmployeeController::class, 'exportKTPPhoto'])->name('admin.employee.ktp');
Route::get('/employee/{id}/pictkk', [EmployeeController::class, 'exportFotoKk'])->name('admin.employee.kk');
Route::get('/employee/{id}/pictkta', [EmployeeController::class, 'exportFotoKTA'])->name('admin.employee.kta');
Route::get('/employee/{id}/pictijasah', [EmployeeController::class, 'exportFotoIjasah'])->name('admin.employee.ijasah');
Route::get('/employee/{id}/pictbpjsket', [EmployeeController::class, 'exportFotoBpjsket'])->name('admin.employee.bpjsket');
Route::get('/employee/{id}/pictbpjskes', [EmployeeController::class, 'exportFotoBpjskes'])->name('admin.employee.bpjskes');
Route::get('/employee/{id}/pictnpwp', [EmployeeController::class, 'exportFotoNpwp'])->name('admin.employee.npwp');
Route::get('/employee/{id}/jobapp', [EmployeeController::class, 'exportLamaran'])->name('admin.employee.jobapp');
Route::delete('admin/employee/{employeeId}/delete-document/{documentKey}', [EmployeeController::class, 'deleteDocument'])->name('admin.employee.deleteDocument');

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
Route::delete('/employee/{employeeId}/delete-certification/{gadaDetailId}', [EmployeeController::class, 'deleteCertification'])->name('employee.deleteCertification');


Route::resource('departemen', DepartemenController::class);
Route::get('/departemen', [DepartemenController::class, 'index'])->name('admin.departemen.index');
Route::get('/departemen/create', [DepartemenController::class, 'create'])->name('admin.departemen.create');
Route::put('/departemen/edit/{departemen}', [DepartemenController::class, 'update'])->name('admin.departemen.update');
Route::get('/departemen/edit/{id}', [DepartemenController::class, 'edit'])->name('admin.departemen.edit');
Route::post('/departemen/store', [DepartemenController::class, 'store'])->name('admin.departemen.store');
Route::delete('/departemen/{id}', [DepartemenController::class, 'destroy'])->name('admin.departemen.destroy');
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
Route::get('/sertifikasi', [GadaController::class, 'index'])->name('admin.gada.index');
Route::get('/sertifikasi/create', [GadaController::class, 'create'])->name('admin.gada.create');
Route::put('/sertifikasi/edit/{gada}', [GadaController::class, 'update'])->name('admin.gada.update');
Route::get('/sertifikasi/edit/{id}', [GadaController::class, 'edit'])->name('admin.gada.edit');
Route::post('/sertifikasi/store', [GadaController::class, 'store'])->name('admin.gada.store');
Route::delete('/sertifikasi/{gada}', [GadaController::class, 'destroy'])->name('admin.gada.destroy');
Route::get('/sertifikasi/{id}', [GadaController::class, 'show'])->name('admin.gada.show');

Route::resource('work', WorkController::class);
Route::get('/work', [WorkController::class, 'index'])->name('admin.work.index');
Route::get('/work/create', [WorkController::class, 'create'])->name('admin.work.create');
Route::put('/work/edit/{work}', [WorkController::class, 'update'])->name('admin.work.update');
Route::get('/work/edit/{id}', [WorkController::class, 'edit'])->name('admin.work.edit');
Route::post('/work/store', [WorkController::class, 'store'])->name('admin.work.store');
Route::delete('/work/{work}', [WorkController::class, 'destroy'])->name('admin.work.destroy');
Route::get('/work/{id}', [WorkController::class, 'show'])->name('admin.work.show');
});

// Visitor cookie route
Route::get('/set-visitor-cookie', [VisitorController::class, 'setVisitorCookie']);

// Default home route, only used if needed
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
