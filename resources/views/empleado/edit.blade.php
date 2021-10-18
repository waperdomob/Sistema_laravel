@extends('layouts.app')

@section('content')
<div class="container">
<form action="{{route('empleado.update',$empleado->id)}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    @include('empleado._form',['modo'=>'Editar'])
</form>
</div>  