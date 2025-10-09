<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\LeadController;

// Route::get('/', function () {
//     return Inertia::render('Welcome');
// })->name('home');

Route::get('/', fn () => Inertia::render('marketing/Home'));

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/leads', [LeadController::class, 'store'])->name('leads.store');

Route::get('/projects/{slug}', [ProjectsController::class, 'show'])->name('projects.show');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
