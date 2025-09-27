<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('excerpt')->nullable();
            $table->string('client');
            $table->string('industry');
            $table->string('role')->nullable();
            $table->string('cover')->nullable();
            $table->json('tags')->nullable();
            $table->json('stack')->nullable();
            $table->longText('summary');
            $table->longText('problem');
            $table->json('solution')->nullable();
            $table->json('features')->nullable();
            $table->longText('outcomes');
            $table->json('impact_bullets')->nullable();
            $table->json('kpis')->nullable();
            $table->json('timeline')->nullable();
            $table->json('gallery')->nullable();
            $table->json('testimonial')->nullable();
            $table->string('live')->nullable();
            $table->string('repo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
