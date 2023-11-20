<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categorias = [
            'Juegos',
            'Redes sociales',
            'Comunicación',
            'Productividad',
            'Herramientas',
            'Estilo de vida',
            'Música y audio',
            'Fotografía',
            'Viajes y local',
            'Noticias y revistas',
            'Educación',
            'Salud y bienestar',
            'Entretenimiento',
            'Libros y referencia',
            'Finanzas',
            'Compras',
            'Negocios',
            'Personalización',
            'Deportes',
            'Mapas y navegación',
        ];

        foreach ($categorias as $categoria) {
            category::create(['category_name' => $categoria]);
        }
    }
}
