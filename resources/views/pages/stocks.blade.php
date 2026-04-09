@extends('layouts.master')

@section('content')
    <h1>Stocks</h1>

    <ul>
        @foreach($stocks as $stock)
            <li>
                <p>{{ $stock->name }}</p>
                <p>{{ $stock->description }}</p>
                <img width="300px" src="{{ $stock->image }}" alt="{{ $stock->name }}">
            </li>
        @endforeach
    </ul>

@endsection
