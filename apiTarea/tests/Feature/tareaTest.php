<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class tareaTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_ListAllTareas()
    {
        $estructura = [
            "*" => [
            "idAutor",
            "idUsuario" => [
                "id",
                "name",
                "email",
                "email_verified_at",
                "created_at",
                "updated_at"
            ],
            "cuerpo",
            "categorias",
            "comentarios"
            ]
        ];
        $response = $this->get('/api/v1/tarea');
        $response->assertStatus(200);
        $response->assertJsonCount(11);
        $response->assertJsonStructure($estructura);

    }
}
