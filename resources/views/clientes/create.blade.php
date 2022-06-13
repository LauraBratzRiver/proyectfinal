@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin tb">
        <div class="pull-left">
            <h2>Agregar nuevo cliente</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ URL::to('clientes/') }}" title="Atras"><i class="fas fa-back"></i></a>
           
        </div>
    </div>
</div>
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> Hay algunos problemas con su entrada.<br><br>
        <ul>
            @foreach ($errors->all() as $error)


                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{ route('clientes.store') }}" method="POST">

    @csrf
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Nombre:</strong>
                <input type="text" name="nombre" class="form-control" placeholder="Nombre">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Apellido:</strong>
                <input type="text" name="apellido" class="form-control" placeholder="Apellido">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Reservacion:</strong>
                <input type="text" name="reservacion" class="form-control" placeholder="Reservacion">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </div>
</form>
@endsection
