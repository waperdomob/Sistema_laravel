@extends('layouts.app')

@section('content')
<div class="container">    
    @if (Session::has('mensaje'))
        <div class="alert alert-primary alert-dismissible" role="alert">
            {{  Session::get('mensaje') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        
<a href="{{route('empleado.create')}}" class="btn btn-success">Registrar nuevo empleado</a>
<h1>lista de empleados</h1>
<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th>#</th>
            <th>Foto</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Correo</th>            
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($empleados as $empleado)           
       
        <tr>
            <td>{{ $empleado->id}}</td>
            <td>
                <img  src="{{  asset(('storage').'/'.$empleado->photo)}}" whidth="100" height="100" >
            </td>
            <td>{{$empleado->name}}</td>
            <td>{{$empleado->lastname}}</td>
            <td>{{$empleado->email}}</td>            
            <td>
                <a href="{{ route('empleado.edit',$empleado)}}" class="btn btn-warning">Edit</a> 
                 | 
                <form action="{{ route('empleado.destroy',$empleado->id)}}" method="post" class="d-inline">
                    @csrf @method('DELETE')
                    <input class="btn btn-danger" type="submit" onclick="return confirm('Deseas borrar el empleado?')" value="Borrar">
                </form>
                </td>
        </tr>
        @endforeach
    </tbody>
</table>
{!! $empleados->links() !!}
</div>
@endsection