<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeadRequest extends FormRequest
{
  public function rules(): array {
    return [
      'name'        => ['required','string','max:120'],
      'email'       => ['required','email','max:160'],
      'serviceType' => ['required','in:informativa,landing,tienda'],
      'budget'      => ['required','in:menos-400,400-800,800-1500,1500-3000,3000-5000,mas-5000'],
      'message'     => ['required','string','min:10','max:3000'],
      'company'     => ['nullable','size:0'],

      // tracking (opcionales)
      'utm_source'  => ['nullable','string','max:120'],
      'utm_medium'  => ['nullable','string','max:120'],
      'utm_campaign'=> ['nullable','string','max:160'],
      'utm_term'    => ['nullable','string','max:160'],
      'utm_content' => ['nullable','string','max:160'],
      'referrer'    => ['nullable','string','max:2048'],
      'landing_url' => ['nullable','string','max:2048'],
      'gclid'       => ['nullable','string','max:255'],
      'consent'     => ['nullable','boolean'],
    ];
  }
  public function authorize(): bool { return true; }
}
