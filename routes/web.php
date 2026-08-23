<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublicPortalController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\LegislativeWorkController;
use App\Http\Controllers\ConstituencyProjectController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\SpeechController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\PublicationController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/about', [PublicPortalController::class, 'about'])->name('about');
Route::get('/appointees', [\App\Http\Controllers\AppointeeController::class, 'index'])->name('appointees');

// Achievements public routes
Route::get('/achievements', [AchievementController::class, 'index'])->name('achievements');
Route::get('/achievements/{achievement:slug}', [AchievementController::class, 'show'])->name('achievements.show');

// Legislative Work public routes
Route::get('/legislative-work', [LegislativeWorkController::class, 'index'])->name('legislative-work');
Route::get('/legislative-work/bills', [LegislativeWorkController::class, 'bills'])->name('legislative-work.bills');
Route::get('/legislative-work/motions', [LegislativeWorkController::class, 'motions'])->name('legislative-work.motions');
Route::get('/legislative-work/{slug}', [LegislativeWorkController::class, 'show'])->name('legislative-work.show');

// Constituency Projects public routes
Route::get('/projects', [ConstituencyProjectController::class, 'index'])->name('projects');
Route::get('/projects/{project:slug}', [ConstituencyProjectController::class, 'show'])->name('projects.show');

// News public routes
Route::get('/news', [NewsController::class, 'index'])->name('news');
Route::get('/news/{article:slug}', [NewsController::class, 'show'])->name('news.show');

// Speeches public routes
Route::get('/speeches', [SpeechController::class, 'index'])->name('speeches');
Route::get('/speeches/{speech:slug}', [SpeechController::class, 'show'])->name('speeches.show');

// Media public routes
Route::get('/media', [MediaController::class, 'index'])->name('media');
Route::get('/media/{album:slug}', [MediaController::class, 'show'])->name('media.show');

// Publications public routes
Route::get('/publications', [PublicationController::class, 'index'])->name('publications');
Route::get('/publications/{publication:slug}', [PublicationController::class, 'show'])->name('publications.show');

Route::get('/events', [PublicPortalController::class, 'events'])->name('events');

Route::get('/contact', [PublicPortalController::class, 'contact'])->name('contact.show');
Route::post('/contact', [PublicPortalController::class, 'submitContact'])->name('contact.submit');
