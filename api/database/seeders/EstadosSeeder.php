<?php

namespace Database\Seeders;

use App\Models\Estado;
use Illuminate\Database\Seeder;

class EstadosSeeder extends Seeder
{
    public function run(): void
    {
        $estados = [
            ['estado' => 'pendiente_pago'],
            ['estado' => 'pagada'],
            ['estado' => 'confirmada'],
            ['estado' => 'rechazada'],
        ];

        foreach ($estados as $estado) {
            Estado::create($estado);
        }
    }
}
