<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarea;

class TareaController extends Controller
{
    public function ListarTarea(Request $request){
        return $tarea = Tarea::all();
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
        $tarea -> idautor = $request -> post("idautor");
        $tarea -> idusuario = $request -> post("idusuario");
        $tarea -> cuerpo = $request -> post("cuerpo");
        $tarea -> fechacreacion = $request -> post("fechacreacion");
        $tarea -> categorias = $request -> post("categorias");

        $tarea -> save();

        return $tarea;
    }

    public function CrearTarea(Request $request){
        $tarea = new Tarea();
        $tarea -> titulo = $request -> post("titulo");
        $tarea -> idautor = $request -> post("idautor");
        $tarea -> idusuario = $request -> post("idusuario");
        $tarea -> cuerpo = $request -> post("cuerpo");
        $tarea -> fechacreacion = $request -> post("fechacreacion");
        $tarea -> categorias = $request -> post("categorias");

        $tarea -> save();

        return $tarea;
    }
}