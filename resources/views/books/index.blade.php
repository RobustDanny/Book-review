@extends('layouts.app')

@section('content')
<h1 class="mb-10 text-2x1">Books</h1>
<form method="GET" action="{{route('books.index')}}" class="flex gap-2 text-center mb-2">

  <input class="mb-2 h-10 shadow-sm appearance-none border w-full py-2 px-3 text-slate-700 leading-tight focus:outline-none rounded-md border-slate-300"
   name="title" type="text" placeholder="Search by title" value="{{request('title')}}"/>

  <input type="hidden" name="filter" value="{{request('filter')}}"/>

  <button class="bg-white rounded-md px-4 py-2 text-center font-medium text-slate-500 shadow-sm ring-1 ring-slate-700/10 hover:bg-slate-50 h-10" 
  type="submit">Search</button>

  <a href="{{route('books.index')}}" class="mb-2 h-10 bg-white rounded-md px-4 py-2 text-center font-medium text-slate-500 shadow-sm ring-1 ring-slate-700/10 hover:bg-slate-50 h-10">
    Clear</a>
</form>
<div class="mb-4 flex space-x-2 rounded-md bg-slate-100 p-2">
@php
  $filters = [
    ''=> 'Latest',
    'most_popular_last_month' => 'Most popular in last month',
    'most_popular_last_6months' => 'Most popular in last 6 months',
    'high_rated_last_month'=> 'Highest rated in last month',
    'high_rated_last_6months' => 'Highest rated in last 6 months'
  ]
@endphp
    @foreach($filters as $key => $value)
    <a href="{{route('books.index', [...request()->query(), 'filter'=> $key])}}" class="{{request('filter') === $key || (request('filter') === null && $key === '')? 'bg-white shadow-sm text-slate-800 flex w-full items-center justify-center rounded-md px-4 py-2 text-center text-sm font-medium' 
    : 'flex w-full items-center justify-center rounded-md px-4 py-2 text-center text-sm font-medium text-slate-500'}}">
    {{$value}}</a>
    @endforeach
</div>


<ul>
    @forelse ($books as $book)
      <li class="mb-4">
        <div class="text-sm rounded-md bg-white p-4 leading-6 text-slate-900 shadow-md shadow-black/5 ring-1 ring-slate-700/10">
          <div
            class="flex flex-wrap items-center justify-between">
            <div class="w-full flex-grow sm:w-auto">
              <a href="{{ route('books.show', $book) }}" class="text-lg font-semibold text-slate-800 hover:text-slate-600">{{ $book->title }}</a>
              <span class="block text-slate-600">by {{ $book->author }}</span>
            </div>
            <div>
              <div class="text-sm font-medium text-slate-700">
              <x-star-raview :rating="$book->reviews_avg_rating"/>
              </div>
              <div class="text-xs text-slate-500">
                out of {{ $book->reviews_count }} {{ Str::plural('review', $book->reviews_count) }}
              </div>
            </div>
          </div>
        </div>
      </li>
    @empty
      <li class="mb-4">
        <div class="text-sm rounded-md bg-white py-10 px-4 text-center leading-6 text-slate-900 shadow-md shadow-black/5 ring-1 ring-slate-700/10">
          <p class="font-medium text-slate-500">No books found</p>
          <a href="{{ route('books.index') }}" class="reset-link">Reset criteria</a>
        </div>
      </li>
    @endforelse
  </ul>
@endsection