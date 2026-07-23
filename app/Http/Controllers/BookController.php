<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\Api\BookResource;
use App\Models\Api\Book;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return Book::orderByDesc('created_at')->paginate(6)->toResourceCollection(BookResource::class);
        } catch (\Throwable $th) {
            Log::error('BookController', [
                'message' => 'Erro ao buscar livros',
                'error' => $th->getMessage(),
            ]);

            return response()->json([
                'message' => 'Erro ao buscar livros',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        try {

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $image_path = $image->storeAs('images/books', $image->getClientOriginalName(), 'public');
                $request->merge(['image_path' => $image_path]);
            }

            return Book::create($request->except('image'))->toResource();
        } catch (\Throwable $th) {
            Log::error('BookController', [
                'message' => 'Erro ao criar livro',
                'error' => $th->getMessage(),
            ]);

            return response()->json([
                'message' => 'Erro ao criar livro',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //
    }
}
