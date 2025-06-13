@extends('layouts.app')

@section('title', 'Guía Completa: Cómo Empezar en el Gimnasio')

@section('content')
<div class="max-w-4xl mx-auto px-4">
    <!-- Breadcrumb -->
    <nav class="mb-6">
        <ol class="flex space-x-2 text-sm text-gray-600">
            <li><a href="{{ route('home') }}" class="hover:text-blue-600">Inicio</a></li>
            <li>/</li>
            <li><a href="{{ route('blog.index') }}" class="hover:text-blue-600">Blog</a></li>
            <li>/</li>
            <li class="text-gray-900">Guía para Empezar en el Gimnasio</li>
        </ol>
    </nav>

    <!-- Article Header -->
    <article class="card mb-6">
        <div class="card-body">
            <div class="flex items-center mb-4">
                <span class="bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full">Consejos</span>
                <span class="mx-3 text-gray-400">•</span>
                <span class="text-sm text-gray-600">15 de Junio, 2025</span>
                <span class="mx-3 text-gray-400">•</span>
                <span class="text-sm text-gray-600">5 min de lectura</span>
            </div>
            
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                Guía Completa: Cómo Empezar en el Gimnasio
            </h1>
            
            <div class="flex items-center mb-6">
                <div class="w-10 h-10 bg-gray-400 rounded-full flex items-center justify-center mr-3">
                    <span class="text-white font-medium">A</span>
                </div>
                <div>
                    <div class="font-medium text-gray-900">Admin</div>
                    <div class="text-sm text-gray-600">Entrenador Certificado</div>
                </div>
            </div>
            
            <p class="text-xl text-gray-600 leading-relaxed">
                Si eres principiante y quieres comenzar tu journey fitness, esta guía te dará todas las 
                herramientas necesarias para empezar de forma segura y efectiva en el gimnasio.
            </p>
        </div>
    </article>

    <!-- Article Content -->
    <div class="card mb-6">
        <div class="card-body prose prose-lg max-w-none">
            <h2>¿Por Qué Empezar en el Gimnasio?</h2>
            
            <p>
                El gimnasio es uno de los mejores lugares para comenzar tu transformación física. 
                Ofrece una gran variedad de equipos, un ambiente motivador y la posibilidad de 
                recibir orientación profesional.
            </p>

            <h3>Beneficios de Entrenar en el Gimnasio</h3>
            
            <ul>
                <li><strong>Equipamiento variado:</strong> Acceso a máquinas, pesas libres y equipos especializados</li>
                <li><strong>Ambiente motivador:</strong> Estar rodeado de personas con objetivos similares</li>
                <li><strong>Asesoramiento profesional:</strong> Entrenadores que pueden guiarte</li>
                <li><strong>Rutina estructurada:</strong> Horarios fijos que crean disciplina</li>
            </ul>

            <h2>Preparación Antes de tu Primera Visita</h2>

            <h3>1. Establece Objetivos Claros</h3>
            <p>
                Antes de pisar el gimnasio, define qué quieres lograr:
            </p>
            <ul>
                <li>Perder peso y quemar grasa</li>
                <li>Ganar masa muscular</li>
                <li>Mejorar la resistencia cardiovascular</li>
                <li>Aumentar la fuerza general</li>
                <li>Mejorar la salud y bienestar general</li>
            </ul>

            <h3>2. Equipamiento Básico</h3>
            <p>
                No necesitas mucho para empezar, pero estos elementos son esenciales:
            </p>
            <ul>
                <li>Ropa cómoda y transpirable</li>
                <li>Zapatillas deportivas adecuadas</li>
                <li>Botella de agua</li>
                <li>Toalla pequeña</li>
                <li>Audífonos (opcional)</li>
            </ul>

            <h2>Tu Primera Rutina</h2>

            <h3>Semana 1-2: Adaptación</h3>
            <p>
                Las primeras dos semanas son cruciales para que tu cuerpo se adapte:
            </p>

            <div class="bg-blue-50 p-4 rounded-lg my-4">
                <h4 class="font-semibold mb-2">Rutina de Principiante (3 días/semana)</h4>
                <p><strong>Día 1 - Tren Superior:</strong></p>
                <ul class="mb-3">
                    <li>Press de pecho con máquina: 3 series x 10-12 reps</li>
                    <li>Remo en máquina: 3 series x 10-12 reps</li>
                    <li>Press de hombros: 3 series x 10-12 reps</li>
                    <li>Curl de bíceps: 2 series x 12-15 reps</li>
                    <li>Extensión de tríceps: 2 series x 12-15 reps</li>
                </ul>
                
                <p><strong>Día 2 - Cardio y Core:</strong></p>
                <ul class="mb-3">
                    <li>Caminata en cinta: 20-30 minutos</li>
                    <li>Plancha: 3 series x 20-30 segundos</li>
                    <li>Crunches: 3 series x 15-20 reps</li>
                    <li>Estiramiento: 10 minutos</li>
                </ul>
                
                <p><strong>Día 3 - Tren Inferior:</strong></p>
                <ul>
                    <li>Prensa de piernas: 3 series x 12-15 reps</li>
                    <li>Curl de femoral: 3 series x 12-15 reps</li>
                    <li>Extensión de cuádriceps: 3 series x 12-15 reps</li>
                    <li>Elevación de gemelos: 3 series x 15-20 reps</li>
                    <li>Sentadillas asistidas: 2 series x 10-12 reps</li>
                </ul>
            </div>

            <h2>Consejos Importantes para Principiantes</h2>

            <h3>Nutrición e Hidratación</h3>
            <ul>
                <li>Mantente hidratado durante todo el entrenamiento</li>
                <li>Come algo ligero 1-2 horas antes de entrenar</li>
                <li>Incluye proteína en tu comida post-entrenamiento</li>
                <li>No hagas dietas extremas mientras empiezas a entrenar</li>
            </ul>

            <h3>Descanso y Recuperación</h3>
            <ul>
                <li>Duerme al menos 7-8 horas por noche</li>
                <li>Descansa al menos 1 día entre entrenamientos</li>
                <li>Escucha a tu cuerpo y no ignores el dolor</li>
                <li>Considera masajes o estiramientos suaves</li>
            </ul>

            <h2>Errores Comunes a Evitar</h2>

            <div class="bg-red-50 p-4 rounded-lg my-4">
                <h4 class="font-semibold mb-2 text-red-800">❌ No hagas esto:</h4>
                <ul class="text-red-700">
                    <li>Entrenar todos los días sin descanso</li>
                    <li>Usar peso excesivo desde el primer día</li>
                    <li>Copiar rutinas avanzadas sin preparación</li>
                    <li>Ignorar el calentamiento y enfriamiento</li>
                    <li>Compararte con otros en el gimnasio</li>
                    <li>Saltarte comidas o hacer dietas extremas</li>
                </ul>
            </div>

            <h2>Conclusión</h2>
            <p>
                Empezar en el gimnasio puede parecer intimidante al principio, pero con la preparación 
                adecuada y una mentalidad positiva, pronto se convertirá en una parte natural de tu rutina. 
                Recuerda que los resultados toman tiempo, así que sé paciente contigo mismo y celebra 
                cada pequeño progreso.
            </p>

            <p>
                <strong>¡Lo más importante es empezar!</strong> Cada experto fue una vez un principiante, 
                y tu journey fitness comienza con el primer paso que des en el gimnasio.
            </p>
        </div>
    </article>

    <!-- Related Articles -->
    <div class="card mb-6">
        <div class="card-header">
            <h2 class="text-xl font-semibold">Artículos Relacionados</h2>
        </div>
        <div class="card-body">
            <div class="grid md:grid-cols-2 gap-4">
                <a href="{{ route('blog.show', 2) }}" class="block p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <h3 class="font-semibold text-gray-900 mb-2">Los 10 Mejores Ejercicios para Principiantes</h3>
                    <p class="text-sm text-gray-600">Descubre los ejercicios fundamentales que todo principiante debe conocer.</p>
                </a>
                <a href="{{ route('blog.show', 3) }}" class="block p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <h3 class="font-semibold text-gray-900 mb-2">Cómo Evitar Lesiones en el Gimnasio</h3>
                    <p class="text-sm text-gray-600">Consejos esenciales para entrenar de forma segura y prevenir lesiones.</p>
                </a>
            </div>
        </div>
    </div>

    <!-- Share & Navigation -->
    <div class="flex justify-between items-center">
        <a href="{{ route('blog.index') }}" class="btn-secondary">
            ← Volver al Blog
        </a>
        
        <div class="flex space-x-2">
            <button class="bg-blue-600 text-white px-3 py-2 rounded text-sm hover:bg-blue-700">
                Compartir
            </button>
            <button class="bg-gray-600 text-white px-3 py-2 rounded text-sm hover:bg-gray-700">
                ❤️ Me Gusta
            </button>
        </div>
    </div>
</div>
@endsection