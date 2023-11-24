<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Foundation\Testing\WithoutMiddleware;

class tareaTest extends TestCase
{
    use WithoutMiddleware;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_ListAllTareas(){
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

    public function test_ListOneTarea(){
        $estructura = [
            "id",
            "titulo",
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
    ];

    $response = $this->get('/api/v1/tarea/11');

    $response->assertStatus(200);
    $response->assertJsonCount(1); // Cambiado a 1 porque estás esperando un solo elemento en el array
    $response->assertJsonStructure([$estructura]); // Cambiado a [$estructura] para indicar que esperas un array que contiene esta estructura
    
    $response->assertJsonFragment([
        "id" => 11,
        "titulo" => "Desarrollo primario",
        "idAutor" => 11,
        "idUsuario" => [
            "id" => 11,
            "name" => "usuario",
            "email" => "usuario@email.com",
            "email_verified_at" => "2023-11-24T19:54:03.000000Z",
            "created_at" => "2023-11-24T19:54:03.000000Z",
            "updated_at" => "2023-11-24T19:54:03.000000Z"
        ],
        "cuerpo" => "Realizar formulario BCU",
        "categorias" => "Auditoria",
        "comentarios" => "Buen trabajo"
        ]);
    }

    public function test_CreateOneTarea(){
        $estructura = [
            "titulo",
            "idAutor",
            "idUsuario",
            "cuerpo",
            "categorias",
            "comentarios",
            "created_at",
            "updated_at",
            "id"
        ];

        $response = $this->post('/api/v1/tarea', [
            'titulo' => "Desarrollo primario",
            'idAutor' => 12, 
            'idUsuario' => 3, 
            'cuerpo' => "Realizar formulario BCU",
            'categorias' => "Auditoria",
            'comentarios' => "Buen trabajo"
        ]);

        $response->assertStatus(201); 
        $response->assertJsonCount(10); 
        $response->assertJsonStructure($estructura); 
        $response->assertJsonFragment([
            'titulo' => "Desarrollo primario",
            'idAutor' => 12, 
            'idUsuario' =>3,
            'cuerpo' => "Realizar formulario BCU",
            'categorias' => "Auditoria",
            'comentarios' => "Buen trabajo"
        ]);
        $this->assertDatabaseHas('tareas', [
            'titulo' => "Desarrollo primario",
            'idAutor' => 12,
            'idUsuario' => 3, 
            'cuerpo' => "Realizar formulario BCU",
            'categorias' => "Auditoria",
            'comentarios' => "Buen trabajo"
        ]);
    }

    public function test_UpdateOneTareaThatDoesExists()
{
    $estructura = [
        "id",
        "titulo",
        "idAutor",
        "idUsuario",
        "cuerpo",
        "categorias",
        "comentarios",
        "deleted_at",
        "created_at",
        "updated_at"
    ];

    $response = $this->put('/api/v1/tarea/12', [
        'titulo' => "Desarrollo",
        'idAutor' => 12,
        'idUsuario' => 12,
        'cuerpo' => "Realizar formulario BCU",
        'categorias' => "Auditoria",
        'comentarios' => "Buen trabajo"
    ]);

    $response->assertStatus(200);
    $response->assertJsonCount(10);
    $response->assertJsonStructure($estructura);

    $response->assertJsonFragment([
        'titulo' => "Desarrollo",
        'idAutor' => 12,
        'idUsuario' => 12,
        'cuerpo' => "Realizar formulario BCU",
        'categorias' => "Auditoria",
        'comentarios' => "Buen trabajo"
    ]);

    $this->assertDatabaseHas('tareas', [
        'id' => 12,
        'titulo' => "Desarrolloa",
        'idAutor' => 12,
        'idUsuario' => 12,
        'cuerpo' => "Realizar formulario BCU",
        'categorias' => "Auditoria",
        'comentarios' => "Buen trabajo"
        ]);
    }

    public function test_UpdateOneTareaThatDoesNotExists(){
        $response = $this->put('/api/v1/tarea/5000');
        $response->assertStatus(404);
    }

    public function test_DeleteOneTareaThatDoesExists(){
    $estructura = [
        "message"
    ];

    $response = $this->delete('/api/v1/tarea/12');

    $response->assertStatus(200);
    $response->assertJsonCount(1);
    $response->assertJsonStructure($estructura);
    $response->assertJsonFragment([
         "message" => "Deleted"
    ]);
    $this->assertSoftDeleted('tareas', [
        'id' => 12
    ]);
    }

    public function test_DeleteOneFruitThatDoesNotExists(){
        $response = $this->delete('/api/v1/tarea/5000');
        $response->assertStatus(404);
    }
}
