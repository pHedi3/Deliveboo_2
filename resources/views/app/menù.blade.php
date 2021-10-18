@extends('layouts.app')

@section('content')
    <menu-component :id="{{$id}}" />
@endsection

<i class="d-none fas fa-edit"></i>
<i class="d-none fas fa-trash-alt"></i>