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

// Rutas de previsualización de correos (solo entorno local)
if (app()->isLocal()) {
    Route::get('/_preview/mail/new-lead', function () {
        $sample = [
            'name' => 'María Rodríguez',
            'email' => 'maria@example.com',
            'serviceType' => 'landing',
            'budget' => '1500-3000',
            'message' => "Hola! Necesitamos una landing para una campaña de producto.\nDebe ser rápida, con diseño moderno y analítica.",
            'utm_source' => 'google',
            'utm_medium' => 'cpc',
            'utm_campaign' => 'launch-q4',
            'utm_term' => 'landing pages',
            'utm_content' => 'ad-1',
            'referrer' => 'https://www.google.com/',
            'landing_url' => 'https://vondrak.dev/?utm_source=google&utm_medium=cpc',
            'gclid' => 'TeSt-GcLiD-123',
            'ip' => '203.0.113.42',
            'user_agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 Chrome/126.0.0.0 Safari/537.36',
        ];
        return new \App\Mail\NewLead($sample);
    });

    Route::get('/_preview/mail/lead-confirmation', function () {
        $sample = [
            'name' => 'María Rodríguez',
            'email' => 'maria@example.com',
            'serviceType' => 'landing',
            'budget' => '1500-3000',
            'message' => '¡Gracias por tu tiempo! Me interesa avanzar esta semana si es posible.',
        ];
        return new \App\Mail\LeadConfirmation($sample);
    });
}
