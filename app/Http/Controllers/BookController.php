<?php

namespace App\Http\Controllers;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = $request->input('title');
        $filter = $request->input('filter','');
        $books = Book::when($title, fn($query, $title) => $query->title($title));

        $books = match($filter){
        'most_popular_last_month'=> $books->pLM(),
        'most_popular_last_6months'=> $books->pL6M(),
        'high_rated_last_month'=> $books->hRLM(),
        'high_rated_last_6months'=> $books->hrL6M(),
        default => $books->latest()->avgRating()->reviewCounts()
        };

        $cacheKey = 'books:' . $title . ':' . $filter;

        // $books=$books->get();
        $books = cache()->remember($cacheKey, 3600, fn () => $books->get());

        return view('books.index', ['books' => $books]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $cacheKey = 'book:' . $id;
        $book = cache()->remember($cacheKey, 3600, fn() => 
        Book::with(['reviews' => fn($query) => $query->latest()])
    ->avgRating()->reviewCounts()->findOrFail($id));
        return view('books.show', ['book' => $book]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
