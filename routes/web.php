<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RekapController;
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
use App\Http\Controllers\WorkController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\SendGridEmailController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InventoryItemController;
use App\Http\Controllers\InventoriesController;
use App\Http\Controllers\DistributionController;
use App\Http\Controllers\KasLogistikController;
use App\Http\Controllers\KasLokasiController;
use App\Http\Controllers\KasOperasionalController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\GajiController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\PinjamanController;
use App\Http\Controllers\SaldoUtamaController;
use App\Http\Controllers\PajakController;
use App\Http\Controllers\BpjsController;


// Authentication routes with email verification enabled

// Homepage route



Route::get('/', [PartnerController::class, 'showUserHome'])->name('home');
//Authentication routes
//Route::get('admin/', [AuthController::class, 'showLoginForm'])->name('login');
//Route::post('admin/', [AuthController::class, 'login']);

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
Route::get('/employee/{id}/pictpkwt', [EmployeeController::class, 'exportFotoPkwt'])->name('admin.employee.pkwt');
Route::delete('admin/employee/{employeeId}/delete-document/{documentKey}', [EmployeeController::class, 'deleteDocument'])->name('admin.employee.deleteDocument');

Route::resource('employee', EmployeeController::class);
Route::get('/employee', [EmployeeController::class, 'index'])->name('admin.employee.index');
Route::get('/employee/create', [EmployeeController::class, 'create'])->name('admin.employee.create');
Route::put('/employee/edit/{employee}', [EmployeeController::class, 'update'])->name('admin.employee.update');
Route::get('/employee/{id}/edit', [EmployeeController::class, 'edit'])->name('admin.employee.edit');
Route::post('/employee/store', [EmployeeController::class, 'store'])->name('admin.employee.store');
Route::delete('/employee/{employee}', [EmployeeController::class, 'destroy'])->name('admin.employee.destroy');
Route::put('/employee/{id}/aktif', [EmployeeController::class, 'aktif'])->name('admin.employee.aktif');
Route::put('/employee/{id}/nonaktif', [EmployeeController::class, 'nonaktif'])->name('admin.employee.nonaktif');
Route::put('/employee/{id}/blacklist', [EmployeeController::class, 'blacklist'])->name('admin.employee.blacklist');
Route::get('/employee/{id}', [EmployeeController::class, 'show'])->name('admin.employee.show');
Route::delete('/employee/{employeeId}/delete-certification/{gadaDetailId}', [EmployeeController::class, 'deleteCertification'])->name('employee.deleteCertification');



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

Route::resource('work', WorkController::class);
Route::get('/work', [WorkController::class, 'index'])->name('admin.work.index');
Route::get('/work/create', [WorkController::class, 'create'])->name('admin.work.create');
Route::put('/work/edit/{work}', [WorkController::class, 'update'])->name('admin.work.update');
Route::get('/work/edit/{id}', [WorkController::class, 'edit'])->name('admin.work.edit');
Route::post('/work/store', [WorkController::class, 'store'])->name('admin.work.store');
Route::put('/work/{id}/aktif', [WorkController::class, 'aktif'])->name('admin.work.aktif');
Route::put('/work/{id}/nonaktif', [WorkController::class, 'nonaktif'])->name('admin.work.nonaktif');
Route::put('/work/{id}/blacklist', [WorkController::class, 'blacklist'])->name('admin.work.blacklist');
Route::delete('/work/{work}', [WorkController::class, 'destroy'])->name('admin.work.destroy');
Route::get('/work/{id}', [WorkController::class, 'show'])->name('admin.work.show');

Route::get('/invoice', [InvoiceController::class, 'index'])->name('admin.invoice.index');
    Route::get('/invoice/create', [InvoiceController::class, 'create'])->name('admin.invoice.create');
    Route::post('/invoice', [InvoiceController::class, 'store'])->name('admin.invoice.store');
    Route::get('/invoice/{invoice}', [InvoiceController::class, 'show'])->name('admin.invoice.show');
    Route::get('/invoice/{invoice}/edit', [InvoiceController::class, 'edit'])->name('admin.invoice.edit');
    Route::put('/invoice/{invoice}', [InvoiceController::class, 'update'])->name('admin.invoice.update');
    Route::post('/invoice/{id}/upload', [InvoiceController::class, 'upload'])->name('admin.invoice.upload');
    Route::delete('/invoice/{invoice}', [InvoiceController::class, 'destroy'])->name('admin.invoice.destroy');

Route::get('/baranggudang', [InventoryItemController::class, 'index'])->name('admin.inventory.index');
    Route::get('/baranggudang/create', [InventoryItemController::class, 'create'])->name('admin.inventory.create');
    Route::post('/baranggudang', [InventoryItemController::class, 'store'])->name('admin.inventory.store');
    Route::get('/baranggudang/{inventoryItem}', [InventoryItemController::class, 'show'])->name('admin.inventory.show');
    Route::get('/baranggudang/{inventoryItem}/edit', [InventoryItemController::class, 'edit'])->name('admin.inventory.edit');
    Route::put('/baranggudang/{inventoryItem}', [InventoryItemController::class, 'update'])->name('admin.inventory.update');
    Route::delete('/baranggudang/{inventoryItem}', [InventoryItemController::class, 'destroy'])->name('admin.inventory.destroy');

    Route::get('/inventories', [InventoriesController::class, 'index'])->name('admin.inventaris.index');
    Route::get('/inventories/create', [InventoriesController::class, 'create'])->name('admin.inventaris.create');
    Route::post('/inventories', [InventoriesController::class, 'store'])->name('admin.inventaris.store');
    Route::get('/inventories/{inventories}', [InventoriesController::class, 'show'])->name('admin.inventaris.show');
    Route::get('/inventories/{inventories}/edit', [InventoriesController::class, 'edit'])->name('admin.inventaris.edit');
    Route::put('/inventories/{inventories}', [InventoriesController::class, 'update'])->name('admin.inventaris.update');
    Route::post('/inventories/{id}/upload', [InventoriesController::class, 'upload'])->name('admin.inventaris.upload');
    Route::delete('/inventories/{inventories}', [InventoriesController::class, 'destroy'])->name('admin.inventaris.destroy');

    Route::get('/distributions', [DistributionController::class, 'index'])->name('admin.distributions.index');
    Route::get('/distributions/create', [DistributionController::class, 'create'])->name('admin.distributions.create');
    Route::post('/distributions', [DistributionController::class, 'store'])->name('admin.distributions.store');
    Route::get('/distributions/{distribution}', [DistributionController::class, 'show'])->name('admin.distributions.show');
    Route::get('/distributions/{distribution}/edit', [DistributionController::class, 'edit'])->name('admin.distributions.edit');
    Route::put('/distributions/{distribution}', [DistributionController::class, 'update'])->name('admin.distributions.update');
    Route::post('/distributions/{id}/upload', [DistributionController::class, 'upload'])->name('admin.distributions.upload');
    Route::delete('/distributions/{distribution}', [DistributionController::class, 'destroy'])->name('admin.distributions.destroy');

    //kaslogistik

// Visitor cookie route
Route::get('/set-visitor-cookie', [VisitorController::class, 'setVisitorCookie']);

Route::post('/kas-logistik/tambah', [KasLogistikController::class, 'store'])->name('kaslogistik.store');
Route::post('/kas-logistik/kredit', [KasLogistikController::class, 'kredit'])->name('kaslogistik.kredit');
Route::get('/kaslogistik', [KasLogistikController::class, 'index'])->name('kaslogistik.index');
Route::delete('/kaslogistik/{id}', [KasLogistikController::class, 'destroy'])->name('kaslogistik.destroy');

//kaslokasi
Route::get('/kaslokasi', [KasLokasiController::class, 'index']);
Route::post('/kaslokasi/store', [KasLokasiController::class, 'store'])->name('kaslokasi.store');
Route::post('/kaslokasi/kredit', [KasLokasiController::class, 'kredit'])->name('kaslokasi.kredit');
Route::delete('/kaslokasi/{id}', [KasLokasiController::class, 'destroy'])->name('kaslokasi.destroy');

//kasoperasional
Route::get('/kasoperasional', [KasOperasionalController::class, 'index'])->name('kasoperasional.index');
Route::post('/kasoperasional/store', [KasOperasionalController::class, 'store'])->name('kasoperasional.store');
Route::post('/kasoperasional/kredit', [KasOperasionalController::class, 'kredit'])->name('kasoperasional.kredit');
Route::delete('/kasoperasional/{id}', [KasOperasionalController::class, 'destroy'])->name('kasoperasional.destroy');



//pengaduan

Route::get('/laporanmasalah', [PengaduanController::class, 'index'])->name('pengaduan.index');
Route::get('/laporanmasalah/create', [PengaduanController::class, 'create'])->name('pengaduan.create');
Route::post('/laporanmasalah', [PengaduanController::class, 'store'])->name('pengaduan.store');
Route::get('/laporanmasalah/{id}', [PengaduanController::class, 'show'])->name('laporanmasalah.detail');
Route::get('/laporanmasalah/{id}/validasi', [PengaduanController::class, 'validasi'])->name('pengaduan.validasi');
Route::get('/laporanmasalah/{id}/approve', [PengaduanController::class, 'approve'])->name('pengaduan.approve');
Route::get('/laporanmasalah/{id}/logs', [PengaduanController::class, 'showLogs'])->name('pengaduan.logs');
Route::post('/laporanmasalah/{id}/logs', [PengaduanController::class, 'storeLog'])->name('pengaduan.storeLog');
Route::get('/laporanmasalah/{id}/logs/create', [PengaduanController::class, 'createLog'])->name('pengaduan.createLog');
Route::get('/laporanmasalah/{id}/logs/{logId}/edit', [PengaduanController::class, 'editLog'])->name('pengaduan.editLog');

Route::get('/pengaduan/{id}/upload-bukti', [PengaduanController::class, 'formUploadBukti'])->name('pengaduan.uploadBukti');
Route::post('/pengaduan/{id}/upload-bukti', [PengaduanController::class, 'uploadBukti'])->name('pengaduan.uploadBuktiPost');
Route::get('/pengaduan/{id}/print', [PengaduanController::class, 'printPDF'])->name('pengaduan.print');
Route::get('/pengaduan/{id}/cetak-pdf', [PengaduanController::class, 'printPDF'])->name('pengaduan.print-pdf');



// gaji
Route::get('/gaji', [GajiController::class, 'index'])->name('gaji.index');
Route::get('/gaji/create', [GajiController::class, 'create'])->name('gaji.create');
Route::post('/gaji', [GajiController::class, 'store'])->name('gaji.store');
Route::get('/gaji/{id}', [GajiController::class, 'show'])->name('gaji.detail');
Route::get('/gaji/{id}/konfirmasi', [GajiController::class, 'konfirmasi'])->name('gaji.konfirmasi');
Route::get('/gaji/{id}', [GajiController::class, 'show'])->name('gaji.detail');
Route::get('/gaji/{id}/logs', [GajiController::class, 'showLogs'])->name('gaji.logs');



        //dokumenlokasi

        Route::get('/saldoutama', [SaldoUtamaController::class, 'index'])->name('admin.saldo.index');

 Route::get('/pinjaman', [PinjamanController::class, 'index'])->name('pinjaman.index');
    Route::get('/pinjaman/create', [PinjamanController::class, 'create'])->name('pinjaman.create');
    Route::post('/pinjaman', [PinjamanController::class, 'store'])->name('pinjaman.store');
    Route::get('/pinjaman/{id}/edit', [PinjamanController::class, 'edit'])->name('pinjaman.edit');
    Route::put('/pinjaman/{id}', [PinjamanController::class, 'update'])->name('pinjaman.update');
    Route::delete('/pinjaman/{id}', [PinjamanController::class, 'destroy'])->name('pinjaman.destroy');

    // Route untuk fitur Kredit (tambah pinjaman ke saldo)
    Route::post('/pinjaman/kredit', [PinjamanController::class, 'kredit'])->name('pinjaman.kredit');

     Route::get('/pajak', [PajakController::class, 'index'])->name('pajak.index');
    Route::get('/pajak/create', [PajakController::class, 'create'])->name('pajak.create');
    Route::post('/pajak', [PajakController::class, 'store'])->name('pajak.store');
    Route::get('/pajak/{id}/edit', [PajakController::class, 'edit'])->name('pajak.edit');
    Route::put('/pajak/{id}', [PajakController::class, 'update'])->name('pajak.update');
    Route::delete('/pajak/{id}', [PajakController::class, 'destroy'])->name('pajak.destroy');

    // Route untuk fitur Kredit (tambah pajak ke saldo)
    Route::post('/pajak/kredit', [PajakController::class, 'kredit'])->name('pajak.kredit');

    Route::get('/bpjs', [BpjsController::class, 'index'])->name('bpjs.index');
    Route::get('/bpjs/create', [BpjsController::class, 'create'])->name('bpjs.create');
    Route::post('/bpjs', [BpjsController::class, 'store'])->name('bpjs.store');
    Route::get('/bpjs/{id}/edit', [BpjsController::class, 'edit'])->name('bpjs.edit');
    Route::put('/bpjs/{id}', [BpjsController::class, 'update'])->name('bpjs.update');
    Route::delete('/bpjs/{id}', [BpjsController::class, 'destroy'])->name('bpjs.destroy');
    // Route untuk fitur Kredit (tambah BPJS ke saldo)
    Route::post('/bpjs/kredit', [BpjsController::class, 'kredit'])->name('bpjs.kredit');

});
   // Visitor cookie route
Route::get('/set-visitor-cookie', [VisitorController::class, 'setVisitorCookie']);

// Default home route, only used if needed
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



//notif


Route::get('/notifikasi', [NotificationController::class, 'index'])->name('notif.index');
Route::post('/notifikasi/baca/{id}', [NotificationController::class, 'markAsRead'])->name('notif.markAsRead');
Route::post('/notifikasi/baca/{id}', [NotificationController::class, 'markAsRead'])->name('notif.markAsRead');
Route::post('/notifikasi/baca/{id}', [\App\Http\Controllers\NotifikasiController::class, 'markAsRead'])->name('notif.markAsRead');
Route::get('/notifications/show', [App\Http\Controllers\NotificationController::class, 'show'])->name('notifications.show');
Route::get('/notifications/get', [App\Http\Controllers\NotificationController::class, 'get'])->name('notifications.get');
    Route::get('/rekapseragam', [RekapController::class, 'index'])->name('rekap.index');
    Route::get('/rekap-seragam', [DistributionController::class, 'daftarRekap']);



