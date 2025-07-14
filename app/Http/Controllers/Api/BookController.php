<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Writer;
use App\Models\Book; 
use Illuminate\Http\Request;
use App\Http\Requests\BookRequest;
use App\Http\Requests\WriterRequest;
use Illuminate\Support\Str;


class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        //Acedemos los libros
        $books= Book::all();

        //se lo enviamos en modo json
        return response()->json([
            'message' => 'List of Book',
            'books' => $books->makeHidden(['iduser'])


        ], 200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $request)
    {
        //
        $userID = $request->user();
        if($userID->role == 'reader'){
            return response()->json(['Unauthorized'],401);
        }
        else{
            // Validar los datos
            $validated = $request->validated();

            // Agregar el idwriter al array de datos validados
            $validated['idwriter'] = $userID->writer->idwriter;

            // Agregar la fecha de publicación actual
            $validated['publish_date'] = now();
            
            //procesar la imagen si existe
             if ($request->hasFile('photo')) {
                $imagePath = $request->file('photo')->store('books', 'public');
                $validated['photo'] = $imagePath;
            }
            //crear el libro
            $book=Book::create($validated);

            //asignar géneros si existen
             if ($request->has('genres')) {
                $book->genres()->sync($request->genres); // Usar sync en lugar de attach
            }
            
            // Devolver una respuesta JSON
             return response()->json(
            ['message' => 'Book created successfully'], 201
        );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
