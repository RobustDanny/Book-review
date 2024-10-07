@extends('layouts.app')

@section('content')
  <div class="mb-4">
    <h1 class="mb-2 text-2xl">{{ $book->title }}</h1>

    <div class="book-info">
      <div class="block text-slate-600 mb-4 text-lg font-semibold">by {{ $book->author }}</div>
      <div class="text-sm font-medium text-slate-700 flex items-center">
        <div class="mr-2 text-sm font-medium text-slate-700">
          <!-- {{ number_format($book->reviews_avg_rating, 1) }} -->
          <x-star-raview :rating="$book->reviews_avg_rating"/>
        </div>
        <span class="text-xs text-slate-500 text-sm text-gray-500">
          {{ $book->reviews_count }} {{ Str::plural('review', 5) }}

        </span>
      </div>
    </div>
  </div>
    <div>
    <a href="{{route('books.reviews.create', $book)}}">
    Add a review
    </a>
    </div>
  <div>
    <h2 class="mb-4 text-xl font-semibold">Reviews</h2>
    <ul>
      @forelse ($book->reviews as $review)
        <li class="text-sm rounded-md bg-white p-4 leading-6 text-slate-900 shadow-md shadow-black/5 ring-1 ring-slate-700/10 mb-4">
          <div>
            <div class="mb-2 flex items-center justify-between">
              <!-- <div class="font-semibold">{{ $review->rating }}</div> -->
              <x-star-raview :rating="$review->rating"/>
              <div class="text-xs text-slate-500">
                {{ $review->created_at->format('M j, Y') }}</div>
            </div>
            <p class="text-gray-700">{{ $review->review }}</p>
          </div>
        </li>
      @empty
        <li class="mb-4">
          <div class="text-sm rounded-md bg-white py-10 px-4 text-center leading-6 text-slate-900 shadow-md shadow-black/5 ring-1 ring-slate-700/10">
            <p class="font-medium text-slate-500 text-lg font-semibold">No reviews yet</p>
          </div>
        </li>
      @endforelse
    </ul>
  </div>
@endsection