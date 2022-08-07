<?php

namespace App\Http\Controllers\Api;

use App\Models\{Book, Publisher, Author};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rules = [
            'offset' => 'integer|min:0',
            'limit' => 'integer|min:1|max:100',
        ];

        $validator = validator(request()->all(), $rules);

        if($validator->fails()){
            return response()->json([
                'message' => implode(', ', $validator->messages()->all()),
            ], 400);
        }

        $offset = request('offset', 0);
        $limit = request('limit', 10);
        $books = Book::with('authors:id,name', 'publisher:id,name')->offset($offset)->limit($limit)->get();
        return $this->json([
            'count' => Book::count(),
            'books' => $books,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $book = Book::where('title', $request->title)->first();

        if ($book) {
            $this->update($request, $book->id);
        }

        $rules = [
            'title' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'authors' => 'required|array|min:1',
            "authors.*"  => "required|string|distinct|max:255",
        ];

        $validator = validator($request->all(), $rules);

        if($validator->fails()){
            return response()->json([
                'message' => implode(', ', $validator->messages()->all()),
            ], 400);
        }

        $publisher = Publisher::firstOrCreate([
            'name' => $request->publisher,
        ]);

        $book = Book::create([
            'title' => $request->title,
            'publisher_id' => $publisher->id,
        ]);

        $book->authors()->detach();

        $authors_ids = Author::whereIn('name', $request->authors)->pluck('id')->toArray();

        if($authors_ids){
            $book->authors()->attach($authors_ids);
        }

        return $this->json([
            'book' => $book,
            'message' => 'Book created.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::with('authors:id,name', 'publisher:id,name')->find($id);

        if (!$book) {
            return $this->json(['message' => 'Book not found.'], 404);
        }

        return $this->json($book, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return $this->json([
                'message' => 'Book not found!',
            ], 404);
        }

        $rules = [
            'title' => 'string|max:255',
            'publisher' => 'string|max:255',
            'authors' => 'array|min:1',
            "authors.*"  => "string|distinct|max:255",
        ];

        $validator = validator($request->all(), $rules);

        if($validator->fails()){
            return response()->json([
                'message' => implode(', ', $validator->messages()->all()),
            ], 400);
        }

        if ($request->filled('title')) {
            $book::update(['title' => $request->title]);
        }

        if ($request->filled('publisher')) {

            $publisher = Publisher::firstOrCreate([
                'name' => $request->publisher,
            ]);

            $book::update(['publisher_id' => $publisher->id]);
        }

        if ($request->has('authors')) {

            $book->authors()->detach();

            $authors_ids = Author::whereIn('name', $request->authors)->pluck('id')->toArray();

            if($authors_ids){
                $book->authors()->attach($authors_ids);
            }
        }

        $book->update($request->all());

        return $this->json([
            'book' => $book,
            'message' => 'Book updated.', 
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return $this->json([
                'message' => 'Book not found!',
            ], 404);
        }

        $book->authors()->detach();

        $book->delete();

        return $this->json([
            'message' => 'Book deleted.'
        ]);
    }

    public function json($data, $http_code = 200)
    {
        return response()->json( $data, $http_code, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );
    }
}
