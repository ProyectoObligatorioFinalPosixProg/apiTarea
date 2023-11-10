<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TareaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'titulo' => $this->faker->word(),
            'idautor' => $this->faker-> numberBetween(1,100),
            'idusuario' => $this -> faker -> numberBetween(1,100),
            'cuerpo' => $this -> faker -> RandomElement(['Realizar una Copia de Seguridad', 'Limpiar Archivos Temporales', 'Actualizar Software','Organizar Archivos','Gestión de Contraseñas']),
            'categorias' => $this->faker->RandomElement(['Desarrollo de Software', 'Sistemas Operativos', 'Redes de Computadoras','Bases de Datos','Ciberseguridad'])
        ];
    }
}
