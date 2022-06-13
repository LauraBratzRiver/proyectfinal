@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin tb">
        <div class="pull-left">
            <h2>Editar datos clientes</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ url('/clientes') }}" title="Regresar"><i class="fa fa-backward"></i></a>

        </div>
    </div>
</div>
<form action="{{ route('/clientes.update', $clientes->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Nombre:</strong>
                <input type="text" name="nombre" class="form-control" placeholder="Nombre" value="{{ $reservacion->nombre }}">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Apellido:</strong>
                <input type="text" name="apellido" class="form-control" placeholder="Apellido" value="{{ $reservacion->apellido }}">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Reservacion:</strong>
                <input type="text" name="reservacion" class="form-control" placeholder="Reservacion" value="{{ $reservacion->reservacion }}">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Editar</button>
        </div>
    </div>
</form>
@endsection


