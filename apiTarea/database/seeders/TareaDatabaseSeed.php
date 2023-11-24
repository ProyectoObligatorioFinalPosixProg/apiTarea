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
        \App\Models\Tarea::factory(10)->create();
        \App\Models\Tarea::factory(1)->create([
            "titulo" => "Desarrollo primario",
            "idautor" => 11,
            "idusuario" => 11,
            "cuerpo" => "Realizar formulario BCU",
            "categorias" => "Auditoria",
            "comentarios" => "Buen trabajo"
        ]);
    }
}
