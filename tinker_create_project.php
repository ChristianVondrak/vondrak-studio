$projectData = [
    'title' => 'Tech Savvy Way',
    'slug' => 'orion',
    'excerpt' => 'Plataforma de gestión empresarial integral',
    'client' => 'Tech Savvy Way S.A.S',
    'industry' => 'Software & Technology',
    'role' => 'Full Stack Development',
    'cover' => '/resources/js/assets/projects/orion/dashboard.jpg',
    'tags' => ['Laravel', 'Vue.js', 'MySQL', 'Tailwind CSS', 'Inertia.js'],
    'stack' => ['Laravel', 'Vue.js', 'MySQL', 'Tailwind CSS', 'Inertia.js'],
    'summary' => 'Sistema completo de gestión empresarial que integra módulos de facturación, inventario, CRM y reportes avanzados. Diseñada específicamente para pequeñas y medianas empresas que buscan digitalizar y optimizar sus procesos operativos.',
    'problem' => 'El cliente necesitaba reemplazar múltiples sistemas legacy desconectados que generaban inconsistencias en los datos y procesos ineficientes. El reto principal fue crear una solución unificada que mantuviera la funcionalidad existente mientras mejoraba significativamente la experiencia del usuario.',
    'outcomes' => 'La plataforma ha transformado completamente los procesos operativos del cliente, reduciendo en un 65% el tiempo de tareas administrativas y eliminando un 80% de los errores por duplicación de datos.',
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
    'solution' => [
        'Desarrollamos una plataforma web moderna usando Laravel y Vue.js que centraliza todos los procesos empresariales en una interfaz intuitiva.',
        'Implementamos un sistema de migración de datos robusto y capacitación personalizada para garantizar una transición exitosa.',
        'Integramos múltiples APIs de pago y servicios externos para automatizar procesos clave.'
    ],
    'impact_bullets' => [
        'Eficiencia operativa aumentada en 65%',
        'Reducción de errores en 80%',
        'Tiempo de facturación reducido en 70%',
        'Satisfacción del cliente del 95%'
    ],
    'live' => 'https://app.techsavvyway.com',
    'repo' => 'https://github.com/techsavvyway/platform',
    'kpis' => [
        ['label' => 'Tiempo de desarrollo', 'value' => '6 meses'],
        ['label' => 'Módulos implementados', 'value' => '8 módulos'],
        ['label' => 'Reducción de tiempo', 'value' => '65%'],
        ['label' => 'Usuarios activos', 'value' => '150+ usuarios']
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
    'testimonial' => [
        'message' => 'La plataforma ha transformado completamente nuestros procesos operativos. Lo que antes nos tomaba horas, ahora lo hacemos en minutos. El equipo de Vondrak Studio no solo desarrolló una excelente solución técnica, sino que nos acompañó en todo el proceso de implementación.',
        'author' => 'María González',
        'role' => 'Gerente General',
        'company' => 'Tech Savvy Way S.A.S'
    ]
];

App\Models\Project::where('slug', 'orion')->delete();
$project = App\Models\Project::create($projectData);
echo "Project created: " . $project->title . " (ID: " . $project->id . ")\n";
echo "Gallery items: " . count($project->gallery) . "\n";
