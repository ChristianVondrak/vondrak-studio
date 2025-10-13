<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeadRequest;
use App\Mail\NewLead;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

class LeadController extends Controller
{
  public function store(StoreLeadRequest $request): JsonResponse
  {
    // Rate limit por IP (5/min)
    $key = 'lead:'.($request->ip());
    if (RateLimiter::tooManyAttempts($key, 5)) {
      return response()->json(['ok'=>false,'error'=>'Too many requests'], 429);
    }
    RateLimiter::hit($key, 60);

  $data = $request->validated();

    // enrich meta
    $data['ip'] = $request->ip();
    $data['user_agent'] = substr((string)$request->userAgent(), 0, 512);

    // Notificaciones por email
    // 1) Admin: dirección desde .env (LEADS_TO) con fallback a mail.from.address
    $adminAddress = env('LEADS_TO', config('mail.from.address'));
    if ($adminAddress) {
      Mail::to($adminAddress)->send(new NewLead($data));
    }

    // 2) Cliente: confirmación al email del lead
    // if (!empty($data['email'])) {
    //   Mail::to($data['email'])->send(new \App\Mail\LeadConfirmation($data));
    // }

    return response()->json(['ok'=>true]);
  }
}
