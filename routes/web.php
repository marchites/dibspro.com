<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AccountController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\AgentController;
use App\Http\Controllers\Frontend\ArticleController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PropertyController;

// Route::get('/', function () {
//     return view('welcome');
// });

// NON MIDDLEWARE ROUTES
// Auth Routes
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginProcess']);

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerProcess']);

Route::post('/logout', [AuthController::class, 'logout']);

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/property/{slug}', [PropertyController::class, 'show'])->name('property.show');
Route::get('/property', [PropertyController::class, 'index'])->name('property');
Route::get('/property/{property}/whatsapp', [PropertyController::class, 'whatsapp'])->name('property.whatsapp');

// Article Routes
Route::get('/article', [ArticleController::class, 'index'])->name('article');
Route::get('/article/{slug}', [ArticleController::class, 'show'])->name('article.show');
Route::get('/article/category/{slug}', [ArticleController::class, 'category']);

// Kalkulator KPR 
Route::view('/kalkulator-kpr', 'frontend.kpr.index')->name('kpr.index');

// MIDDLEWARE FOR AUTHENTICATED USERS
Route::middleware('auth')->group(function () {

    // User Account
    Route::get('/account', [AccountController::class, 'index'])->name('account.index');
    Route::get('/account/profile/edit', [AccountController::class, 'editProfile']);
    Route::post('/account/profile/update', [AccountController::class, 'updateProfile']);

    // Favorite Properties
    Route::get('/favorite', [PropertyController::class, 'favoriteList'])->name('favorite');
    Route::post('/favorite/toggle', [PropertyController::class, 'toggleFavorite']);

});

// MIDDLEWARE FOR ADMIN
Route::middleware(['auth', 'admin'])->prefix('dashboard')->group(function () {

    // Dashboard Home
    Route::get('/', [AdminController::class, 'index']);

    // Property Management
    Route::get('/properties', [AdminController::class, 'properties']);
    Route::get('/properties/create', [AdminController::class, 'createProperty']);
    Route::post('/properties/store', [AdminController::class, 'storeProperty']);
    Route::get('/properties/{id}/edit', [AdminController::class, 'editProperty']);
    Route::put('/properties/{id}/update', [AdminController::class, 'updateProperty']);
    Route::delete('/properties/{id}/delete', [AdminController::class, 'deleteProperty']);
    Route::delete('/property/image/{id}', [AdminController::class, 'deletePropertyImage']);
    Route::delete('/dashboard/property/{id}/video', [AdminController::class, 'deletePropertyVideo']
);
    
    // Article Management
    Route::get('/articles', [AdminController::class, 'articles']);
    Route::get('/articles/create', [AdminController::class, 'createArticle']);
    Route::post('/articles/store', [AdminController::class, 'storeArticle']);
    Route::get('/articles/{id}/edit', [AdminController::class, 'editArticle']);
    Route::put('/articles/{id}/update', [AdminController::class, 'updateArticle']);
    Route::delete('/articles/{id}/delete', [AdminController::class, 'deleteArticle']);
    Route::put('/properties/{id}/toggle-status',[AdminController::class, 'togglePropertyStatus']);

    // Settings
    Route::get('/settings', [AdminController::class, 'settings']);
    Route::post('/settings/update', [AdminController::class, 'updateSettings']);

});

// MIDDLEWARE FOR AGENT
Route::middleware(['auth', 'agent'])->prefix('agent')->group(function () {

    // Agent Dashboard
    Route::get('/dashboard', [AgentController::class, 'index'])->name('agent.dashboard');

});