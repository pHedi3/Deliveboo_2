@extends('layouts.app')


@section('content')
    <single-restaurant
     :id="{{$id}}" />
     
@endsection
    <i class="fas fa-times d-none"></i>
    <i class="fas fa-plus d-none"></i>
    <i class="fas fa-sort-down d-none"></i>
    <i class="fas fa-shopping-cart d-none"></i>

