@extends('layouts.app')
@section('content')
    <div class="container">
        @foreach($products as $product)
            <a href={{"/product/".$product->id}}>{{$product->name}}</a>
            <br>
        @endforeach
    </div>
@endsection