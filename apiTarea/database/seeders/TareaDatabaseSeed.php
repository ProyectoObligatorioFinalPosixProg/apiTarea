<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TareaDatabaseSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Tarea::factory(100)->create();
        \App\Models\Tarea::factory(1)->create([
            "titulo" => "Desarrollo primario",
            "idautor" => 1,
            "idusuario" => 1,
            "cuerpo" => "Realizar formulario BCU",
            "categorias" => "Auditoria"
        ]);
    }
}
