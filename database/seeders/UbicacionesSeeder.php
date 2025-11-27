<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ubicacion; // Importa el modelo

class UbicacionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ubicaciones = [
            'Cajamarca', 'Chiclayo', 'Chimbote', 'Piura', 'Trujillo', 
            'Arequipa', 'Cusco', 'Huancayo', 'Huaraz', 'Ica', 
            'Tacna', 'Ayacucho', 'Huacho', 'Juliaca', 'Pucallpa', 
            'Tarapoto', 'Lima (Central)', // Corregido el nombre
        ];

        foreach ($ubicaciones as $ubicacion) {
            Ubicacion::create(['nombre' => $ubicacion]);
        }
    }
}