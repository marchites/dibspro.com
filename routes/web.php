<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('home');
});

// AUTHENTICATION
Route::view('/login', 'auth.login')->name('login');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginProcess']);

Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'registerProcess']);

Route::post('/logout', [AuthController::class, 'logout']);

// PROPERTY
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/property/{slug}', [PropertyController::class, 'show'])->name('property.show');
Route::get('/property', [PropertyController::class, 'index'])->name('property');

// ARTICLES
Route::get('/article', [ArticleController::class, 'index'])->name('article');
Route::get('/article/{slug}', [ArticleController::class, 'show'])->name('article.show');
Route::get('/article/category/{slug}', [ArticleController::class, 'category']);

Route::middleware('auth')->group(function () {

    // USER ACCOUNT
    Route::get('/account', function () {
        return view('account.index');
    });

    // FAVORITE PROPERTIES
    Route::get('/favorite', [PropertyController::class, 'favoriteList'])->name('favorite');
    Route::post('/favorite/toggle', [PropertyController::class, 'toggleFavorite']);

});

Route::middleware(['auth', 'admin'])->prefix('dashboard')->group(function () {

    // PROPERTY
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/properties', [DashboardController::class, 'properties']);
    Route::get('/properties/create', [DashboardController::class, 'createProperty']);
    Route::post('/properties/store', [DashboardController::class, 'storeProperty']);
    Route::get('/properties/{id}/edit', [DashboardController::class, 'editProperty']);
    Route::put('/properties/{id}/update', [DashboardController::class, 'updateProperty']);
    Route::delete('/properties/{id}/delete', [DashboardController::class, 'deleteProperty']);

    // ARTICLE
    Route::get('/articles', [DashboardController::class, 'articles']);
    Route::get('/articles/create', [DashboardController::class, 'createArticle']);
    Route::post('/articles/store', [DashboardController::class, 'storeArticle']);
    Route::get('/articles/{id}/edit', [DashboardController::class, 'editArticle']);
    Route::put('/articles/{id}/update', [DashboardController::class, 'updateArticle']);
    Route::delete('/articles/{id}/delete', [DashboardController::class, 'deleteArticle']);
    Route::put('/properties/{id}/toggle-status',[DashboardController::class, 'togglePropertyStatus']);

    // SETTINGS
    Route::get('/settings', [DashboardController::class, 'settings']);
    Route::post('/settings/update', [DashboardController::class, 'updateSettings']);

});

Route::middleware(['auth', 'agent'])->prefix('agent')->group(function () {

    // AGENT DASHBOARD
    Route::get('/dashboard', function () {
        return view('agent.dashboard');
    });

});