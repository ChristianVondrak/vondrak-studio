<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectsController extends Controller
{
    public function show(string $slug)
    {
        $project = Project::where('slug', $slug)->first();

        if (!$project) {
            // Puedes mostrar 404 o fallback a demo vacío
            return Inertia::render('marketing/projects/ShowDemo', [
                'slug' => $slug,
                'project' => [],
            ])->toResponse(request())->setStatusCode(404);
        }

        return Inertia::render('marketing/projects/ShowDemo', [
            'slug' => $slug,
            'project' => $project->toFrontend(),
        ]);
    }
}
