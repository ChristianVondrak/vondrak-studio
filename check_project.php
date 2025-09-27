<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->boot();

use App\Models\Project;

try {
    $project = Project::where('slug', 'orion')->first();
    
    if (!$project) {
        echo "❌ Proyecto Orion no encontrado\n";
        exit(1);
    }
    
    echo "✅ Proyecto Orion encontrado:\n";
    echo "ID: {$project->id}\n";
    echo "Title: {$project->title}\n";
    echo "Slug: {$project->slug}\n";
    echo "Gallery items: " . count($project->gallery ?? []) . "\n";
    
    if ($project->gallery) {
        echo "\n📸 Gallery images:\n";
        foreach ($project->gallery as $index => $item) {
            echo "  {$index}: {$item['src']} - {$item['caption']}\n";
        }
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
