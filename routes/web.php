<?php

use App\Http\Controllers\ActivityLogsController;
use App\Http\Controllers\Admin\CheckEmailController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\Select2Controller;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\BannerSectionController;
use App\Http\Controllers\Admin\MainContentController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\ProcessController;
use App\Http\Controllers\Admin\ParticipantController;
use App\Http\Controllers\Admin\GuestOfHonourController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\CmsPageController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\JuniorEditorRegistrationsController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\CerificateController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FrontCmsPageController;
use App\Http\Controllers\ContactController;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [HomeController::class, 'index']);

Route::get('/temp', function () {
    return view('admin.layouts.app');
});
Route::get('contact', [HomeController::class, 'contactUsPage'])->name('contact.page');
Route::post('contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('privacy-policy', [HomeController::class, 'privacyPage'])->name('privacy.page');
Route::get('terms-of-service', [HomeController::class, 'termsPage'])->name('terms.page');

// CMS Pages Routes
Route::get('/page/{slug}', [FrontCmsPageController::class, 'show'])->name('cms-page.show');
Route::get('certificate', [HomeController::class, 'certificateGet'])->name('certificate.get');
Route::get('register/form', [HomeController::class, 'registerForm'])->name('register.form');
Route::post('certificate/send-otp', [HomeController::class, 'sendOtp'])->name('certificate.send-otp');
Route::post('certificate/verify-otp', [HomeController::class, 'verifyOtp'])->name('certificate.verify-otp');
Route::post('certificate/download', [HomeController::class, 'certificateDownload'])->name('certificate.download')->middleware('certificate.rate.limit:1,5');
Route::get('certificate/generate', [HomeController::class, 'certificateGenerate'])->name('certificate.generate')->middleware('certificate.rate.limit:5,1');
Route::post('certificate/download-jpg', [HomeController::class, 'certificateDownloadJpg'])->name('certificate.download-jpg')->middleware('certificate.rate.limit:3,1');



// lang.swap
Route::get('lang/{locale}', [LanguageController::class, '__invoke'])->name('lang.swap');

// Language switching routes - work on any page
Route::get('ln=hi', function() {
    $currentUrl = request()->header('referer') ?: url()->previous() ?: '/';
    
    // Parse the URL to handle existing parameters
    $parsedUrl = parse_url($currentUrl);
    $path = $parsedUrl['path'] ?? '/';
    $query = $parsedUrl['query'] ?? '';
    
    // Parse existing query parameters
    parse_str($query, $params);
    
    // Update or add the language parameter
    $params['lang'] = 'hi';
    
    // Rebuild the URL
    $newQuery = http_build_query($params);
    $newUrl = $path . ($newQuery ? '?' . $newQuery : '');
    
    return redirect($newUrl);
})->name('switch.hindi');

Route::get('ln=en', function() {
    $currentUrl = request()->header('referer') ?: url()->previous() ?: '/';
    
    // Parse the URL to handle existing parameters
    $parsedUrl = parse_url($currentUrl);
    $path = $parsedUrl['path'] ?? '/';
    $query = $parsedUrl['query'] ?? '';
    
    // Parse existing query parameters
    parse_str($query, $params);
    
    // Update or add the language parameter
    $params['lang'] = 'en';
    
    // Rebuild the URL
    $newQuery = http_build_query($params);
    $newUrl = $path . ($newQuery ? '?' . $newQuery : '');
    
    return redirect($newUrl);
})->name('switch.english');

Route::middleware(SetLocale::class)->group(function () {
    Route::prefix('admin/dashboard')->name('admin.dashboard.')->middleware(['auth', 'track.admin.activities'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
    });
    
    Route::prefix('admin/users')->name('admin.users.')->middleware(['auth', 'track.admin.activities'])->group(function () {
        Route::get('/', [UsersController::class, 'index'])->name('index')->can('view-all-users');
        Route::get('create', [UsersController::class, 'create'])->name('create')->can('create-update-user');
        Route::post('store', [UsersController::class, 'store'])->name('store');
        Route::post('check-email', [CheckEmailController::class, '__invoke'])->name('check-email');
        Route::get('/{user}/edit', [UsersController::class, 'edit'])->name('edit')->can('create-update-user');
        Route::put('/{user}/update', [UsersController::class, 'update'])->name('update');
        Route::delete('/{user}/destroy', [UsersController::class, 'destroy'])->name('destroy')->can('delete-user');
    }); 

    Route::prefix('admin/select2')->name('admin.select2.')->middleware(['auth', 'track.admin.activities'])->group(function () {
        Route::post('/roles', [Select2Controller::class, 'roles'])->name('roles');
        Route::post('/states', [Select2Controller::class, 'states'])->name('states');
        Route::post('/cities', [Select2Controller::class, 'cities'])->name('cities');
    });

    Route::prefix('admin/roles')->name('admin.roles.')->middleware(['auth', 'role:Super Admin', 'track.admin.activities'])->group(function () {
        Route::get('/', [RolesController::class, 'index'])->name('index');
        Route::get('/create', [RolesController::class, 'create'])->name('create');
        Route::post('/store', [RolesController::class, 'store'])->name('store');
        Route::get('/{role}/edit', [RolesController::class, 'edit'])->name('edit');
        Route::put('/{role}/update', [RolesController::class, 'update'])->name('update');
        Route::delete('/{role}/destroy', [RolesController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('admin/activities')->name('admin.activities.')->middleware(['auth', 'role:Super Admin|Admin', 'track.admin.activities'])->group(function () {
        Route::get('activity-logs', [ActivityLogsController::class, 'index'])->name('activity-logs.index')->can('view-activity-logs');
    });

    // Banner Sections Routes
    Route::prefix('admin/banner-sections')->name('admin.banner-sections.')->middleware(['auth', 'track.admin.activities'])->group(function () {
        Route::get('/', [BannerSectionController::class, 'index'])->name('index');
        Route::get('/create', [BannerSectionController::class, 'create'])->name('create');
        Route::post('/', [BannerSectionController::class, 'store'])->name('store');
        Route::get('/{bannerSection}/edit', [BannerSectionController::class, 'edit'])->name('edit');
        Route::put('/{bannerSection}', [BannerSectionController::class, 'update'])->name('update');
        Route::delete('/{bannerSection}', [BannerSectionController::class, 'destroy'])->name('destroy');
        
        // AJAX routes
        Route::post('/update-status', [BannerSectionController::class, 'updateStatus'])->name('update-status');
        Route::post('/update-order', [BannerSectionController::class, 'updateOrder'])->name('order');
    });

    // Main Content Routes
    Route::prefix('admin/main-contents')->name('admin.main-contents.')->middleware(['auth', 'track.admin.activities'])->group(function () {
        Route::get('/', [MainContentController::class, 'index'])->name('index');
        Route::get('/create', [MainContentController::class, 'create'])->name('create');
        Route::post('/', [MainContentController::class, 'store'])->name('store');
        Route::post('/update-status', [MainContentController::class, 'updateStatus'])->name('update-status');
        Route::get('/{mainContent}', [MainContentController::class, 'show'])->name('show');
        Route::get('/{mainContent}/edit', [MainContentController::class, 'edit'])->name('edit');
        Route::put('/{mainContent}', [MainContentController::class, 'update'])->name('update');
        Route::delete('/{mainContent}', [MainContentController::class, 'destroy'])->name('destroy');
    });

    // Video Management Routes
    // Process Routes
    Route::prefix('admin/processes')->name('admin.processes.')->middleware(['auth', 'track.admin.activities'])->group(function () {
        Route::get('/', [ProcessController::class, 'index'])->name('index');
        Route::get('/create', [ProcessController::class, 'create'])->name('create');
        Route::post('/', [ProcessController::class, 'store'])->name('store');
        Route::get('/{process}', [ProcessController::class, 'show'])->name('show');
        Route::get('/{process}/edit', [ProcessController::class, 'edit'])->name('edit');
        Route::put('/{process}', [ProcessController::class, 'update'])->name('update');
        Route::post('/update-status', [ProcessController::class, 'updateStatus'])->name('update-status');
        Route::delete('/{process}', [ProcessController::class, 'destroy'])->name('destroy');
    });

    // Participants Routes
    Route::prefix('admin/participants')->name('admin.participants.')->middleware(['auth', 'track.admin.activities'])->group(function () {
        Route::get('/', [ParticipantController::class, 'index'])->name('index');
        Route::get('/create', [ParticipantController::class, 'create'])->name('create');
        Route::post('/', [ParticipantController::class, 'store'])->name('store');
        Route::get('/{participant}', [ParticipantController::class, 'show'])->name('show');
        Route::get('/{participant}/edit', [ParticipantController::class, 'edit'])->name('edit');
        Route::put('/{participant}', [ParticipantController::class, 'update'])->name('update');
        Route::post('/update-status', [ParticipantController::class, 'updateStatus'])->name('update-status');
        Route::delete('/{participant}', [ParticipantController::class, 'destroy'])->name('destroy');
    });

    // Guest Of Honours Routes
    Route::prefix('admin/guest-of-honours')->name('admin.guest-of-honours.')->middleware(['auth', 'track.admin.activities'])->group(function () {
        Route::get('/', [GuestOfHonourController::class, 'index'])->name('index');
        Route::get('/create', [GuestOfHonourController::class, 'create'])->name('create');
        Route::post('/', [GuestOfHonourController::class, 'store'])->name('store');
        Route::get('/{guestOfHonour}', [GuestOfHonourController::class, 'show'])->name('show');
        Route::get('/{guestOfHonour}/edit', [GuestOfHonourController::class, 'edit'])->name('edit');
        Route::put('/{guestOfHonour}', [GuestOfHonourController::class, 'update'])->name('update');
        Route::post('/update-status', [GuestOfHonourController::class, 'updateStatus'])->name('update-status');
        Route::delete('/{guestOfHonour}', [GuestOfHonourController::class, 'destroy'])->name('destroy');
    });

    // Sliders Routes
    Route::prefix('admin/sliders')->name('admin.sliders.')->middleware(['auth', 'track.admin.activities'])->group(function () {
        Route::get('/', [SliderController::class, 'index'])->name('index');
        Route::get('/create', [SliderController::class, 'create'])->name('create');
        Route::post('/', [SliderController::class, 'store'])->name('store');
        Route::get('/{slider}', [SliderController::class, 'show'])->name('show');
        Route::get('/{slider}/edit', [SliderController::class, 'edit'])->name('edit');
        Route::put('/{slider}', [SliderController::class, 'update'])->name('update');
        Route::post('/update-status', [SliderController::class, 'updateStatus'])->name('update-status');
        Route::delete('/{slider}', [SliderController::class, 'destroy'])->name('destroy');
    });

    // Video Routes
    Route::prefix('admin/videos')->name('admin.videos.')->middleware(['auth', 'large.uploads', 'track.admin.activities'])->group(function () {
        Route::get('/', [VideoController::class, 'index'])->name('index');
        Route::get('/create', [VideoController::class, 'create'])->name('create');
        Route::post('/', [VideoController::class, 'store'])->name('store');
        Route::get('/{video}', [VideoController::class, 'show'])->name('show');
        Route::get('/{video}/edit', [VideoController::class, 'edit'])->name('edit');
        Route::put('/{video}', [VideoController::class, 'update'])->name('update');
        Route::post('/update-status', [VideoController::class, 'updateStatus'])->name('update-status');
        Route::delete('/{video}', [VideoController::class, 'destroy'])->name('destroy');
    });

    // CMS Pages Routes
    Route::prefix('admin/cms-pages')->name('admin.cms-pages.')->middleware(['auth', 'track.admin.activities'])->group(function () {
        Route::get('/', [CmsPageController::class, 'index'])->name('index');
        Route::get('/create', [CmsPageController::class, 'create'])->name('create');
        Route::post('/', [CmsPageController::class, 'store'])->name('store');
        Route::get('/{cmsPage}', [CmsPageController::class, 'show'])->name('show');
        Route::get('/{cmsPage}/edit', [CmsPageController::class, 'edit'])->name('edit');
        Route::put('/{cmsPage}', [CmsPageController::class, 'update'])->name('update');
        Route::post('/update-status', [CmsPageController::class, 'updateStatus'])->name('update-status');
        Route::delete('/{cmsPage}', [CmsPageController::class, 'destroy'])->name('destroy');
    });

    // Contact Form Submissions Routes
Route::prefix('admin/contacts')->name('admin.contacts.')->middleware(['auth', 'track.admin.activities'])->group(function () {
    Route::get('/', [AdminContactController::class, 'index'])->name('index');
    Route::get('/{contact}', [AdminContactController::class, 'show'])->name('show');
    Route::delete('/{contact}', [AdminContactController::class, 'destroy'])->name('destroy');
});

// Employee Management Routes
Route::prefix('admin/employees')->name('admin.employees.')->middleware(['auth', 'track.admin.activities'])->group(function () {
    Route::get('/', [EmployeeController::class, 'index'])->name('index');
    Route::get('/create', [EmployeeController::class, 'create'])->name('create');
    Route::post('/', [EmployeeController::class, 'store'])->name('store');
    Route::get('/{employee}', [EmployeeController::class, 'show'])->name('show');
    Route::post('/fetch-data', [EmployeeController::class, 'fetchEmployeeData'])->name('fetch-data');
});

// Junior Editor Registrations Routes
Route::prefix('admin/junior-editor-registrations')->name('admin.junior-editor-registrations.')->middleware(['auth', 'track.admin.activities'])->group(function () {
    Route::get('/', [JuniorEditorRegistrationsController::class, 'index'])->name('index');
    Route::get('/{juniorEditorRegistration}', [JuniorEditorRegistrationsController::class, 'show'])->name('show');
    Route::post('/update-payment-status', [JuniorEditorRegistrationsController::class, 'updatePaymentStatus'])->name('update-payment-status');
    Route::get('/export/csv', [JuniorEditorRegistrationsController::class, 'export'])->name('export');
    Route::get('/export/excel', [JuniorEditorRegistrationsController::class, 'exportExcel'])->name('export.excel');
    Route::get('/export/pdf', [JuniorEditorRegistrationsController::class, 'exportPdf'])->name('export.pdf');
});


// Winner Management Routes
Route::prefix('admin/winners')->name('admin.winners.')->middleware(['auth', 'track.admin.activities'])->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\WinnerController::class, 'index'])->name('index');
    Route::post('/upload-csv', [App\Http\Controllers\Admin\WinnerController::class, 'uploadCsv'])->name('upload-csv');
    Route::delete('/{id}', [App\Http\Controllers\Admin\WinnerController::class, 'destroy'])->name('destroy');
});

// Junior Editor Registration Routes
Route::get('/register', [App\Http\Controllers\JuniorEditorController::class, 'index'])->name('junior-editor.register');
Route::post('/send-otp', [App\Http\Controllers\JuniorEditorController::class, 'sendOtp'])->name('junior-editor.send-otp');
Route::post('/verify-otp', [App\Http\Controllers\JuniorEditorController::class, 'verifyOtp'])->name('junior-editor.verify-otp');
Route::post('/rate-limit-info', [App\Http\Controllers\JuniorEditorController::class, 'getRateLimitInfo'])->name('junior-editor.rate-limit-info');
Route::get('/states', [App\Http\Controllers\JuniorEditorController::class, 'getStates'])->name('junior-editor.states');
Route::post('/cities', [App\Http\Controllers\JuniorEditorController::class, 'getCities'])->name('junior-editor.cities');
Route::post('/save-partial', [App\Http\Controllers\JuniorEditorController::class, 'savePartialRegistration'])->name('junior-editor.save-partial');
Route::post('/test-form', [App\Http\Controllers\JuniorEditorController::class, 'testFormSubmission'])->name('junior-editor.test-form');
Route::post('/create-order', [App\Http\Controllers\JuniorEditorController::class, 'createOrder'])->name('junior-editor.create-order');
Route::post('/update-payment', [App\Http\Controllers\JuniorEditorController::class, 'updatePayment'])->name('junior-editor.update-payment');
Route::post('/payment-failure', [App\Http\Controllers\JuniorEditorController::class, 'handlePaymentFailure'])->name('junior-editor.payment-failure');
Route::get('/payment-success', function() {
    return view('front.payment-success');
})->name('payment-success');
});
