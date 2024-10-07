@extends('layouts.app')

@section('content')
    <h1 class="mb-10">
        Make a review for {{$book->title}}
    </h1>
    <form method="POST" action="{{route('books.reviews.store', $book)}}">
        @csrf

        <label for="review" class="mb-2">
    Review
        </label>
        <textarea id="review" name="review" required class="mt-2 mb-4 shadow-sm appearance-none border w-full py-2 px-3 text-slate-700 leading-tight focus:outline-none rounded-md border-slate-300">

        </textarea>

        <label for="rating" class="mb-2">
    Rating
        </label>
        <select name="rating" id="rating" class=" mt-2 mb-4 shadow-sm appearance-none border w-full py-2 px-3 text-slate-700 leading-tight focus:outline-none rounded-md border-slate-300">
        <!-- <option value="">Make a rate</option> -->
            <option>

                <?php
                for ($i =0; $i<=5;$i++):

                ?>

                <option value="{{$i}}">{{$i}}</option>

                <?php
                endfor;
                ?>

            </option>
        </select>

        <button type="submit" class="bg-white rounded-md px-4 py-2 text-center font-medium text-slate-500 shadow-sm ring-1 ring-slate-700/10 hover:bg-slate-50 h-10">
            Confirm
        </button>

    </form>
@endsection