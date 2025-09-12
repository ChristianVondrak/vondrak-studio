<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('leads', function (Blueprint $t) {
      $t->id();
      $t->string('name',120);
      $t->string('email',160);
      $t->enum('serviceType',['informativa','landing','tienda']);
      $t->enum('budget',['menos-400','400-800','800-1500','1500-3000','3000-5000','mas-5000']);
      $t->text('message');

      // Marketing tracking
      $t->string('utm_source',120)->nullable();
      $t->string('utm_medium',120)->nullable();
      $t->string('utm_campaign',160)->nullable();
      $t->string('utm_term',160)->nullable();
      $t->string('utm_content',160)->nullable();
      $t->string('referrer',2048)->nullable();
      $t->string('landing_url',2048)->nullable();
      $t->string('gclid',255)->nullable();

      // Consentimiento y meta
      $t->boolean('consent')->default(false);
      $t->string('ip',45)->nullable();
      $t->string('user_agent',512)->nullable();

      $t->timestamps();
    });
  }
  public function down(): void { Schema::dropIfExists('leads'); }
};
