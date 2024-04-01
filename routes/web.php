<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('categories')->group(function (){
    Route::get('/', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('/{category}/update', [CategoryController::class, 'update'])->name('category.update');
    Route::get('/{category}/destroy', [CategoryController::class, 'destroy'])->name('category.destroy');
});

Route::prefix('posts')->group(function (){
    Route::get('/', [PostController::class, 'index'])->name('post.index');
    Route::get('/create', [PostController::class, 'create'])->name('post.create');
    Route::post('/store', [PostController::class, 'store'])->name('post.store');
    Route::get('/{post}/edit', [PostController::class, 'edit'])->name('post.edit');
    Route::post('/{post}/update', [PostController::class, 'update'])->name('post.update');
    Route::get('/{post}/destroy', [PostController::class, 'destroy'])->name('post.destroy');
});

require __DIR__.'/auth.php';
