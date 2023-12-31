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

        $response = Http::withHeaders($tokenHeader) -> get ( "http://localhost:8003/api/v1/user/" . $id);
        return $response -> json();
    }

    public function BuscarTarea(Request $request, $idTarea){
    $arrayPelado = [];
    $tarea = Tarea::findOrFail($idTarea);
    $arrayPelado[] = [
        "id" => $tarea->id,
        "titulo" => $tarea->titulo,
        "idAutor" => $tarea->idAutor,
        "idUsuario" => $this->obtenerDatosDeUsuario($tarea->idUsuario, $request),
        "cuerpo" => $tarea->cuerpo,
        "categorias" => $tarea->categorias,
        "comentarios" => $tarea->comentarios
    ];
    return $arrayPelado;
}

    public function EliminarTarea(Request $request, $idTarea){
        $tarea = Tarea::FindOrFail($idTarea);
        $tarea -> delete();

        $email = $this->obtenerDatosDeUsuario($tarea->idUsuario, $request)['email'];
         Http::post('http://127.0.0.1:8010/api/enviar', [
            'from' => 'gestorTarea@gmail.com',
            'to' => $email,
            'subject' => 'Tarea eliminada',
        ]);

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

        $email = $this->obtenerDatosDeUsuario($tarea->idUsuario, $request)['email'];
        $mensaje = $request -> post("titulo");
         Http::post('http://127.0.0.1:8010/api/enviar', [
            'from' => 'gestorTarea@gmail.com',
            'to' => $email,
            'subject' => 'Tarea modificada: ' . $mensaje,
        ]);

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

        $email = $this->obtenerDatosDeUsuario($tarea->idUsuario, $request)['email'];
        $mensaje = $request -> post("titulo");
         Http::post('http://127.0.0.1:8010/api/enviar', [
            'from' => 'gestorTarea@gmail.com',
            'to' => $email,
            'subject' => 'Tarea creada: ' . $mensaje,
        ]);
        
        return $tarea;
    }
}
