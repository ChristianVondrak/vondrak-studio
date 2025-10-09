<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';

use App\Models\Project;

// Datos del proyecto Tech Savvy Way (Orion)
$projectData = [
    'title' => 'Tech Savvy Way',
    'slug' => 'orion',
    'subtitle' => 'Plataforma de gestión empresarial integral',
    'description' => 'Sistema completo de gestión empresarial que integra módulos de facturación, inventario, CRM y reportes avanzados. Diseñada específicamente para pequeñas y medianas empresas que buscan digitalizar y optimizar sus procesos operativos.',
    'client' => 'Tech Savvy Way S.A.S',
    'status' => 'live',
    'start_date' => '2024-03-01',
    'end_date' => '2024-08-30',
    'technologies' => ['Laravel', 'Vue.js', 'MySQL', 'Tailwind CSS', 'Inertia.js'],
    'features' => [
        'Dashboard ejecutivo en tiempo real',
        'Módulo de facturación electrónica',
        'Gestión integral de inventarios',
        'CRM con seguimiento de leads',
        'Reportes y analítica avanzada',
        'Sistema de roles y permisos',
        'Integración con APIs de pago',
        'Notificaciones push y email'
    ],
    'url_live' => 'https://app.techsavvyway.com',
    'url_github' => 'https://github.com/techsavvyway/platform',
    'cover' => '/resources/js/assets/projects/orion/dashboard.jpg',
    'kpis' => [
        ['label' => 'Tiempo de desarrollo', 'value' => '6 meses'],
        ['label' => 'Módulos implementados', 'value' => '8 módulos'],
        ['label' => 'Reducción de tiempo', 'value' => '65%'],
        ['label' => 'Usuarios activos', 'value' => '150+ usuarios']
    ],
    'impact_metrics' => [
        ['label' => 'Eficiencia operativa', 'value' => '+65%'],
        ['label' => 'Reducción de errores', 'value' => '-80%'],
        ['label' => 'Tiempo de facturación', 'value' => '-70%'],
        ['label' => 'Satisfacción del cliente', 'value' => '95%']
    ],
    'timeline' => [
        ['label' => 'Análisis y diseño', 'when' => 'Semanas 1-3'],
        ['label' => 'Desarrollo backend', 'when' => 'Semanas 4-12'],
        ['label' => 'Frontend y UX', 'when' => 'Semanas 8-16'],
        ['label' => 'Integración y testing', 'when' => 'Semanas 17-20'],
        ['label' => 'Despliegue y go-live', 'when' => 'Semanas 21-24']
    ],
    'gallery' => [
        [
            'src' => '/resources/js/assets/projects/orion/dashboard.jpg',
            'caption' => 'Dashboard principal con métricas en tiempo real y accesos rápidos a todos los módulos del sistema'
        ],
        [
            'src' => '/resources/js/assets/projects/orion/proyectos.jpg', 
            'caption' => 'Módulo de gestión de proyectos con seguimiento de tareas, cronogramas y asignación de recursos'
        ],
        [
            'src' => '/resources/js/assets/projects/orion/reportes.jpg',
            'caption' => 'Sistema de reportes avanzados con gráficos interactivos y exportación en múltiples formatos'
        ],
        [
            'src' => '/resources/js/assets/projects/orion/detalle_proyecto.jpg',
            'caption' => 'Vista detallada de proyectos con seguimiento de progreso, documentos y comunicaciones'
        ],
        [
            'src' => '/resources/js/assets/projects/orion/notificaciones.jpg',
            'caption' => 'Centro de notificaciones con alertas personalizables y seguimiento de actividades'
        ],
        [
            'src' => '/resources/js/assets/projects/orion/proceso_pago.jpg',
            'caption' => 'Flujo completo de procesamiento de pagos con múltiples métodos y confirmaciones automáticas'
        ]
    ],
    'challenge' => 'El cliente necesitaba reemplazar múltiples sistemas legacy desconectados que generaban inconsistencias en los datos y procesos ineficientes. El reto principal fue crear una solución unificada que mantuviera la funcionalidad existente mientras mejoraba significativamente la experiencia del usuario.',
    'solution' => 'Desarrollamos una plataforma web moderna usando Laravel y Vue.js que centraliza todos los procesos empresariales en una interfaz intuitiva. Implementamos un sistema de migración de datos robusto y capacitación personalizada para garantizar una transición exitosa.',
    'testimonial' => [
        'message' => 'La plataforma ha transformado completamente nuestros procesos operativos. Lo que antes nos tomaba horas, ahora lo hacemos en minutos. El equipo de Vondrak Studio no solo desarrolló una excelente solución técnica, sino que nos acompañó en todo el proceso de implementación.',
        'author' => 'María González',
        'role' => 'Gerente General',
        'company' => 'Tech Savvy Way S.A.S'
    ]
];

try {
    // Eliminar proyecto existente si existe
    Project::where('slug', 'orion')->delete();
    
    // Crear nuevo proyecto
    $project = Project::create($projectData);
    
    echo "✅ Proyecto 'Tech Savvy Way' creado exitosamente!\n";
    echo "ID: {$project->id}\n";
    echo "Título: {$project->title}\n";
    echo "Slug: {$project->slug}\n";
    echo "Imágenes en galería: " . count($project->gallery) . "\n";
    
    echo "\n📸 Imágenes de la galería:\n";
    foreach ($project->gallery as $i => $item) {
        echo "  " . ($i + 1) . ": {$item['src']} - {$item['caption']}\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
