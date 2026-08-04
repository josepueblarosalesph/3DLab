<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\HomeController;
use App\Livewire\Admin\InquiryIndex;
use App\Livewire\Admin\PostForm;
use App\Livewire\Admin\PostIndex;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/actualidad', [BlogController::class, 'index'])->name('blog.index');
Route::get('/actualidad/{post:slug}', [BlogController::class, 'show'])->name('blog.show');

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AuthController::class, 'create'])->name('login');
    Route::post('/admin/login', [AuthController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/publicaciones', PostIndex::class)->name('posts.index');
    Route::get('/publicaciones/nueva', PostForm::class)->name('posts.create');
    Route::get('/publicaciones/{post}/editar', PostForm::class)->name('posts.edit');
    Route::get('/consultas', InquiryIndex::class)->name('inquiries.index');
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
});
