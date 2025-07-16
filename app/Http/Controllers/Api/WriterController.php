<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Writer;
use App\Models\Book; 
use App\Http\Requests\WriterRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;



class WriterController extends Controller
{
    public function index(Request $request){

        $userId = $request->user()->id;
        $writers = Writer::where('iduser', $userId)->get();
        
        return response()->json([
            'message' => 'List of writers',
            'writers' => $writers
        ], 200);

    }

    public function store(WriterRequest $request){

        $validated = $request->validated();
        // Asignar el iduser del usuario autenticado
        $validated['iduser'] = $request->user()->id;

        // Generar un UUID para idwriter
        $validated['idwriter'] = Str::uuid()->toString();
        
        // Crear el escritor
        Writer::create($validated);
        // Asignar roles reader y writer por sus IDs
        $user = $request->user();
        $user->roles()->syncWithoutDetaching([1, 2]);
               
        return response()->json(
            ['message' => 'Author created successfully',
        ], 201
        );

    }

    public function show($id, Request $request){
        // BUSCA EL ID DEL USUARIO AUTENTICADO
        $userId = $request->user()->id;
        $writer = Writer::find($id);

        //convierte el id del usuario a string para comparar
        $userId = (string)$userId;

        // Verifica si el escritor existe y si pertenece al usuario autenticado
        if (!$writer || $writer->iduser !== $userId) {
            return response()->json(['message' => 'Writer not found'], 404);
        } else {
            return response()->json([
                'message' => 'Writer found',
                'writer' => $writer
            ], 200);
        }
        
    }
   
    public function update(WriterRequest $request,$id){
        //buscar el escritor por id
        $userId= $request->user()->id;
        $writer=Writer::findOrfail($id);

        //convierte el id del usuario a string para comparar
        $userId = (string)$userId;

        // Verifica si el escritor existe y si pertenece al usuario autenticado
        if (!$writer || $writer->iduser !== $userId) {
            return response()->json(['message' => 'Unauthorized'], 404);

        } else {
            
            $validated= $request->validated();
            $writer->update($validated);

            return response()->json([
                'message' => 'Writer updated successfully',
                'writer' => $writer
            ], 200);
        }
    
       
       
    }

    public function destroy($id, Request $request)
    {
        //buscar el escritor por id
        $userId= $request->user()->id;
        $writer=Writer::findOrfail($id);

         //convierte el id del usuario a string para comparar
        $userId = (string)$userId;

        // Verifica si el escritor existe y si pertenece al usuario autenticado
         if (!$writer || $writer->iduser !== $userId) {
            return response()->json(['message' => 'Writer not found'], 404);

        } else {
            // Elimina el escritor
            $writer->delete();
            // Remueve el rol 'writer' (id 2) y deja solo 'reader' (id 1)
            $user = $request->user();
            $user->roles()->sync([1]);
            return response()->json([
                'message' => 'Writer deleted successfully, user is now only reader'
            ], 200);
        }
    }
    

}
