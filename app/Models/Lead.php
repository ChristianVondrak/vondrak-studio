<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
  protected $fillable = [
    'name','email','serviceType','budget','message',
    'utm_source','utm_medium','utm_campaign','utm_term','utm_content',
    'referrer','landing_url','gclid','ip','user_agent'
  ];
}

