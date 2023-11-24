<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarea;
use Illuminate\Support\Facades\Http;

class TareaController extends Controller
{
    public function ListarTarea(Request $request){
        $arrayPelado = [];
        $tarea = Tarea::all();
        foreach($tarea as $tarea){
            $arrayPelado[] = [
                "id" => $tarea -> id,
                "titulo" => $tarea -> titulo,
                "idAutor" => $tarea -> idAutor,
                "idUsuario" => $this -> obtenerDatosDeUsuario($tarea -> idUsuario, $request),
                "cuerpo" => $tarea -> cuerpo,
                "categorias" => $tarea -> categorias,
                "comentarios" => $tarea -> comentarios
            ];
        }
        return $arrayPelado;
    }

    private function obtenerDatosDeUsuario($id, $request){
        $tokenHeader = [
            "Authorization" => $request -> header("Authorization"),
            "Accept" => "application/json",
            "Content-Type" => "application/json"
        ];

        $response = Http::withHeaders($tokenHeader) -> get ( "http://localhost:8002/api/v1/user/" . $id);
        return $response -> json();
    }

    public function BuscarTarea(Request $request, $idTarea){
        return $tarea = Tarea::FindOrFail($idTarea);
    }

    public function EliminarTarea(Request $request, $idTarea){
        $tarea = Tarea::FindOrFail($idTarea);
        $tarea -> delete();
        return [ "message" => "Deleted"];
    }

    public function ModificarTarea(Request $request, $idTarea){
        $tarea = Tarea::FindOrFail($idTarea);
        $tarea -> titulo = $request -> post("titulo");
        $tarea -> idAutor = $request -> post("idAutor");
        $tarea -> idUsuario = $request -> post("idUsuario");
        $tarea -> cuerpo = $request -> post("cuerpo");
        $tarea -> categorias = $request -> post("categorias");
        $tarea -> comentarios = $request -> post ("comentarios");

        $tarea -> save();

        return $tarea;
    }

    public function CrearTarea(Request $request){
        $tarea = new Tarea();
        $tarea -> titulo = $request -> post("titulo");
        $tarea -> idAutor = $request -> post("idAutor");
        $tarea -> idUsuario = $request -> post("idUsuario");
        $tarea -> cuerpo = $request -> post("cuerpo");
        $tarea -> categorias = $request -> post("categorias");
        $tarea -> comentarios = $request -> post ("comentarios");

        $tarea -> save();

         Http::post('http://127.0.0.1:8003/api/enviar', [
            'from' => 'mgmauriciocruz@gmail.com',
            'to' => 'mgmauriciocruz@gmail.com',
            'subject' => 'Tarea creada',
        ]);
        
        return $tarea;
    }
}
