<?php

use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\ApprovalController;
use App\Http\Controllers\Admin\AumController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Public\AgendaController as PublicAgendaController;
use App\Http\Controllers\Public\AumController as PublicAumController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\PostController as PublicPostController;
use App\Http\Controllers\Public\ProfileController;
use App\Http\Controllers\Public\SeoController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('seo.sitemap');
Route::get('/robots.txt', [SeoController::class, 'robots'])->name('seo.robots');

Route::get('/profil', [ProfileController::class, 'profil'])->name('profil');
Route::get('/profil/visi-misi', [ProfileController::class, 'visiMisi'])->name('profil.visi-misi');
Route::get('/profil/sejarah', [ProfileController::class, 'sejarah'])->name('profil.sejarah');
Route::get('/profil/struktur', [ProfileController::class, 'struktur'])->name('profil.struktur');
Route::get('/majelis', [ProfileController::class, 'majelis'])->name('majelis');
Route::get('/berita', [PublicPostController::class, 'index'])->name('berita.index');
Route::get('/berita/kategori/{category}', [PublicPostController::class, 'index'])->name('berita.category');
Route::get('/berita/{slug}', [PublicPostController::class, 'show'])->name('berita.show');
Route::get('/aum', [PublicAumController::class, 'index'])->name('aum.index');
Route::get('/aum/{id}', [PublicAumController::class, 'show'])->name('aum.show');
Route::get('/agenda', [PublicAgendaController::class, 'index'])->name('agenda.index');
Route::get('/kontak', [ContactController::class, 'index'])->name('kontak');
Route::post('/kontak', [ContactController::class, 'store'])->middleware('throttle:5,1')->name('kontak.store');

Route::get('/login', [LoginController::class, 'showLoginForm'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest', 'throttle:5,1')->name('login.attempt');
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');

    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda.index');
    Route::get('/agenda/create', [AgendaController::class, 'create'])->name('agenda.create');
    Route::post('/agenda', [AgendaController::class, 'store'])->name('agenda.store');
    Route::get('/agenda/{agenda}/edit', [AgendaController::class, 'edit'])->name('agenda.edit');
    Route::put('/agenda/{agenda}', [AgendaController::class, 'update'])->name('agenda.update');
    Route::delete('/agenda/{agenda}', [AgendaController::class, 'destroy'])->name('agenda.destroy');
    Route::get('/aum', [AumController::class, 'index'])->name('aum.index');
    Route::get('/aum/create', [AumController::class, 'create'])->name('aum.create');
    Route::post('/aum', [AumController::class, 'store'])->name('aum.store');
    Route::get('/aum/{aum}/edit', [AumController::class, 'edit'])->name('aum.edit');
    Route::put('/aum/{aum}', [AumController::class, 'update'])->name('aum.update');
    Route::delete('/aum/{aum}', [AumController::class, 'destroy'])->name('aum.destroy');
    Route::post('/aum/{aum}/restore', [AumController::class, 'restore'])->withTrashed()->name('aum.restore');
    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
    Route::get('/announcements/create', [AnnouncementController::class, 'create'])->name('announcements.create');
    Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
    Route::get('/announcements/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('announcements.edit');
    Route::put('/announcements/{announcement}', [AnnouncementController::class, 'update'])->name('announcements.update');
    Route::delete('/announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/messages/{message}/read', [MessageController::class, 'markRead'])->name('messages.read');
    Route::delete('/messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');
    Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');
    Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');

    Route::middleware('superadmin')->group(function () {
        Route::get('/approvals', [ApprovalController::class, 'index'])->name('approvals.index');
        Route::post('/approvals/{post}/approve', [ApprovalController::class, 'approve'])->name('approvals.approve');
        Route::post('/approvals/{post}/reject', [ApprovalController::class, 'reject'])->name('approvals.reject');
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::post('/users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active');
        Route::post('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
    });
});
