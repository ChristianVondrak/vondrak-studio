<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class ProjectsController extends Controller
{
    private array $demoSlugs = ['panel-rrhh', 'avantiway-maps', 'vondrak-studio'];

    public function show(string $slug)
    {
        $response = Inertia::render('marketing/projects/ShowDemo', [
            'slug' => $slug,
            'project' => [],
        ])->toResponse(request());

        if (!in_array($slug, $this->demoSlugs, true)) {
            $response->setStatusCode(404);
        }

        return $response;
    }
}
