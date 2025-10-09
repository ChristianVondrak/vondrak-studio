<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'excerpt', 'client', 'industry', 'role', 'cover',
        'tags', 'stack', 'summary', 'problem', 'solution', 'features',
        'outcomes', 'impact_bullets', 'kpis', 'timeline', 'gallery',
        'testimonial', 'live', 'repo',
    ];

    protected $casts = [
        'tags' => 'array',
        'stack' => 'array',
        'solution' => 'array',
        'features' => 'array',
        'impact_bullets' => 'array',
        'kpis' => 'array',
        'timeline' => 'array',
        'gallery' => 'array',
        'testimonial' => 'array',
    ];

    public function toFrontend(): array
    {
        return [
            'title' => $this->title,
            'excerpt' => $this->excerpt,
            'cover' => $this->cover, // puede ser null; el frontend usa fallback
            'summary' => $this->summary,
            'problem' => $this->problem,
            'solution' => $this->solution ?? [],
            'outcomes' => $this->outcomes,
            'impactBullets' => $this->impact_bullets ?? [],
            'features' => $this->features ?? [],
            'kpis' => $this->kpis ?? [],
            'client' => $this->client,
            'industry' => $this->industry,
            'role' => $this->role,
            'stack' => $this->stack ?? [],
            'live' => $this->live,
            'repo' => $this->repo,
            'timeline' => $this->timeline ?? [],
            'gallery' => $this->gallery ?? [],
            'testimonial' => $this->testimonial,
            'tags' => $this->tags ?? [],
        ];
    }
}
