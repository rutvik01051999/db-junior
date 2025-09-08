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
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\CerificateController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('admin.dashboard.index');
    } else if (Auth::guest()) {
        return view('front.home');
    }
});

Route::get('/temp', function () {
    return view('admin.layouts.app');
});
Route::get('contact', [HomeController::class, 'contactUsPage'])->name('contact.page');
Route::get('privacy-policy', [HomeController::class, 'privacyPage'])->name('privacy.page');
Route::get('terms-of-service', [HomeController::class, 'termsPage'])->name('terms.page');
Route::get('certificate', [HomeController::class, 'certificateGet'])->name('certificate.get');
Route::get('register/form', [HomeController::class, 'registerForm'])->name('register.form');
Route::post('certificate/download', [HomeController::class, 'certificateDownload'])->name('certificate.download');


Auth::routes();

// lang.swap
Route::get('lang/{locale}', [LanguageController::class, '__invoke'])->name('lang.swap');

Route::middleware(SetLocale::class)->group(function () {
    Route::prefix('admin/dashboard')->name('admin.dashboard.')->middleware('auth')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        Route::get('/users-registrations', [DashboardController::class, 'userRegistrations'])->name('users-registrations');
    });
    
    Route::prefix('admin/users')->name('admin.users.')->middleware('auth')->group(function () {
        Route::get('/', [UsersController::class, 'index'])->name('index')->can('view-all-users');
        Route::get('create', [UsersController::class, 'create'])->name('create')->can('create-update-user');
        Route::post('store', [UsersController::class, 'store'])->name('store');
        Route::post('check-email', [CheckEmailController::class, '__invoke'])->name('check-email');
        Route::get('/{user}/edit', [UsersController::class, 'edit'])->name('edit')->can('create-update-user');
        Route::put('/{user}/update', [UsersController::class, 'update'])->name('update');
        Route::delete('/{user}/destroy', [UsersController::class, 'destroy'])->name('destroy')->can('delete-user');
    }); 

    Route::prefix('admin/select2')->name('admin.select2.')->middleware('auth')->group(function () {
        Route::post('/roles', [Select2Controller::class, 'roles'])->name('roles');
        Route::post('/states', [Select2Controller::class, 'states'])->name('states');
        Route::post('/cities', [Select2Controller::class, 'cities'])->name('cities');
    });

    Route::prefix('admin/roles')->name('admin.roles.')->middleware(['auth', 'role:Super Admin'])->group(function () {
        Route::get('/', [RolesController::class, 'index'])->name('index');
        Route::get('/create', [RolesController::class, 'create'])->name('create');
        Route::post('/store', [RolesController::class, 'store'])->name('store');
        Route::get('/{role}/edit', [RolesController::class, 'edit'])->name('edit');
        Route::put('/{role}/update', [RolesController::class, 'update'])->name('update');
        Route::delete('/{role}/destroy', [RolesController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('admin/activities')->name('admin.activities.')->middleware(['auth', 'role:Super Admin'])->group(function () {
        Route::get('activity-logs', [ActivityLogsController::class, 'index'])->name('activity-logs.index')->can('view-activity-logs');
    });

    // Banner Sections Routes
    Route::prefix('admin/banner-sections')->name('admin.banner-sections.')->middleware('auth')->group(function () {
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
    Route::prefix('admin/main-contents')->name('admin.main-contents.')->middleware('auth')->group(function () {
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
    Route::prefix('admin/processes')->name('admin.processes.')->middleware('auth')->group(function () {
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
    Route::prefix('admin/participants')->name('admin.participants.')->middleware('auth')->group(function () {
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
    Route::prefix('admin/guest-of-honours')->name('admin.guest-of-honours.')->middleware('auth')->group(function () {
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
    Route::prefix('admin/sliders')->name('admin.sliders.')->middleware('auth')->group(function () {
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
    Route::prefix('admin/videos')->name('admin.videos.')->middleware('auth')->group(function () {
        Route::get('/', [VideoController::class, 'index'])->name('index');
        Route::get('/create', [VideoController::class, 'create'])->name('create');
        Route::post('/', [VideoController::class, 'store'])->name('store');
        Route::get('/{video}', [VideoController::class, 'show'])->name('show');
        Route::get('/{video}/edit', [VideoController::class, 'edit'])->name('edit');
        Route::put('/{video}', [VideoController::class, 'update'])->name('update');
        Route::post('/update-status', [VideoController::class, 'updateStatus'])->name('update-status');
        Route::delete('/{video}', [VideoController::class, 'destroy'])->name('destroy');
    });
});
