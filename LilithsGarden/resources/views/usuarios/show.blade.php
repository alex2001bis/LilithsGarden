@extends('layouts.app')
@section('title', 'Perfil')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Usuario') }}</div>
                <div class="card-body">
                    {{__('Nombre:')}}
                    <input class="form-control" type="text" value="{{ $usuario->name }}" disabled>
                    <hr>
                    {{__('Email:')}}
                    <input class="form-control" type="text" value="{{ $usuario->email }}" disabled>
                    <hr>
                    {{__('Direccion:')}}
                    <input class="form-control" type="text" value="{{ $usuario->deliveryAddress }}" disabled>
                    @if (Auth::user()->role == 1)
                        <hr>
                        {{__('Rol:')}}
                        <input class="form-control" type="text" value="{{ $usuario->role }}" disabled>
                    @endif
                    <br>
                    <a href="{{route('usuarios.edit', $usuario)}}"><button class="btn btn-primary">Editar</button></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection