<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeadRequest;
use App\Mail\NewLead;
use App\Models\Lead;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;

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
    $data['consent'] = (bool)($data['consent'] ?? false);

    $lead = Lead::create($data);

    // Notifica por email (Mailpit en dev)
    Mail::to('hello@vondrak.dev')->send(new NewLead($lead));

    return response()->json(['ok'=>true]);
  }
}
