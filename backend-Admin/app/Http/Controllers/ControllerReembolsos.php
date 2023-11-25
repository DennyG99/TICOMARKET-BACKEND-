<?php

namespace App\Http\Controllers;

use App\Models\Reembolso;
use App\Models\Reembolsos;
use Exception;
use Illuminate\Http\Request;

class ControllerReembolsos extends Controller
{

    public function get(){
        try{
            $data = Reembolsos::get();
            return response()->json($data, 200);
        }catch(Exception $e){
            return response()->json(['error', $e->getMessage()], 500);
        }
    }

    public function create(Request $request){
        try{
            $data = [
                'fechaSolicitud' => $request['fechaSolicitud'],
                'idEstado'       => $request['idEstado'],
                'motivo'         => $request['motivo'],
                'idVendedor'     => $request['idVendedor'],
            ];

            Reembolsos::create($data);
            return response()->json($data,200);
        }catch(Exception $e){
            return response()->json(['error', $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id){
        try{
            $data['idEstado']=$request['idEstado'];
            Reembolsos::find($id)->update($data);

            return response()->json($data,200);
        }catch(Exception $e){
            return response()->json(['error', $e->getMessage()], 500);
        }
    }
}