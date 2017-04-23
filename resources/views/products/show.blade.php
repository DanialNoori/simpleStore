@extends('layouts.app')
@section('content')
    <div class="container">
        <div>name: {{$product->name}}</div>
        <div>description: {{$product->description}}</div>
        @if(count($product->categories))
            <div>categories: </div>
        @endif
        @foreach($product->categories as $category)
            <div>{{$category->name}}</div>
        @endforeach
        <br>
        {{--@if(Auth::check() && $product->user_id === Auth::user()->id)--}}
        @can('update',$product)
            <div class="btn-group btn-group-justified" role="group">
                <div class="btn-group" role="group">
                    <form action="{{ url('/product/'.$product->id) }}"  method="POST">
                        <input type="hidden" name="_method" value="DELETE">
                        {{csrf_field()}}
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
                <div class="btn-group" role="group">
                    <a href={{"/product/".$product->id."/edit"}}><button type="button" class="btn btn-primary">Update</button></a>
                </div>
            </div>
        @endcan
        {{--@endif--}}
    </div>
@endsection