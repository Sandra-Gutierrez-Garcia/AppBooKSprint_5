<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
         return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'publish_date' => 'nullable|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
            'content' => 'required|string|min:10',
        ];
        //para los generos if de post agregar obligaor

         if ($this->isMethod('POST')) {
        $rules['genres'] = 'required|array|min:1';
        $rules['genres.*'] = 'required|integer|exists:genre,idgenre';
        $rules['status'] = 'required|in:pending,completed,rejected'; // Agregar validación para el estado
        } 
        
        //para que no de error si no se envian los generos en el put
        else {
            $rules['genres'] = 'sometimes|array';
            $rules['genres.*'] = 'integer|exists:genre,idgenre';
        }
}
}