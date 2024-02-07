<?php

namespace App\Http\Controllers;

use App\Models\Book_checkout;
use App\Models\User1;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Book_genre;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{

    public function create()
    {
        $book_categories = Book_genre::all();

        return view('library.index', compact('book_categories'));
    }
    public function searchByName(Request $request)
    {
        $name = $request->input('name');

        $user = User1::where('name', 'like', $name . '%')->get();
        return response()->json($user);
    }

    // search by book
    public function searchByBook(Request $request)
    {
        $bookName = $request->input('name');
        $categoryId = $request->input('category_id');

        $booksQuery = DB::table('books')
            ->join('authors', 'books.author_id', '=', 'authors.id')
            ->select('books.id', 'books.title', 'authors.name as author_name', 'books.publication_year')
            ->where(function ($query) use ($bookName) {
                $query->where('books.title', 'like',  $bookName . '%')
                    ->orWhere('authors.name', 'like', $bookName . '%')
                    ->orWhere('books.publication_year', 'like',  $bookName . '%');
            });

        if ($categoryId) {
            $booksQuery->where('books.genre', $categoryId);
        }

        $books = $booksQuery->get();

        return response()->json($books);
    }



    public function store(Request $request)
    {
        // dd($request->all());

        $validatedData = $request->validate([
            'user_id' => 'required',
            'book_id' => 'required',
            'receive_date' => 'required|date',
            'return_date' => 'required|date'

        ]);


        $books =DB::table('book_checkout')->insert([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,

            'receive_date'  => $request->receive_date,
            'return_date' => $request->return_date,

        ]);




        return redirect()->back();
    }


}
