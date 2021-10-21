@extends('layouts.app')

@section('content')
    <orders-component :id="{{$id}}" />
@endsection

<i class="fas fa-utensils d-none"></i>
<i class="fas fa-info-circle d-none"></i>
<i class="fas fa-file-alt d-none"></i>
