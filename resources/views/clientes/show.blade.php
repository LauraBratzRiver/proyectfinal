@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin tb">
        <div class="pull-left">
            <h2>{{$clientes->nombre}}</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ url('/clientes') }}" title="Regresar"></a>
             class="fas fa-backward"></i></a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Nombre:</strong>
            {{$clientes->nombre}}
        </div>
    </div>
            
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Apellido:</strong>
            {{$clientes->apellido}}
            
    </div>
</div>
@endsection



