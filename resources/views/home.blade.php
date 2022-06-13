@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto CAR WASH</title>
    <body class="p-3 mb-2 bg-danger text-white" >
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="home">::.CAR WASH.::</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">  
            <li class="nav-item">
             <a @click="abrirForm('cliente')" class="nav-link" href="{{ url('/index') }}">{{ __('Clientes') }}<a/>
            </li>       
            <li class="nav-item"> 
            <a @click="abrirForm('Reservacion')" class="nav-link" href="">Reservacion<a/>
            </li>
            <li class="nav-item"> 
            <a @click="abrirForm('Reservacion')" class="nav-link" href="">Calendario<a/>
            </li>
            <a class="navbar-brand" href="{{ url('') }}">
                    Chat
                </a>
                <a class="navbar-brand" href="/">
               <img src="https://img4.grocerymeta.com/773/381/4923291067733818.jpg#.Ym7yU6XjUic.link" width="100" height="100" class="d-inline-block align-top" alt="">
                </a>
         </ul>  
            </div>
        </div>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/vue-select@latest/dist/vue-select.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-vue@latest/dist/bootstrap-vue.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-vue@latest/dist/bootstrap-vue-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-vue@latest/dist/bootstrap-vue-table.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-vue@latest/dist/bootstrap-vue-dialog.css">

    
</head>

   

  

    <Cliente-component v-bind:form="forms" ref="Clientes" v-show="forms['Clientes'].mostrar" ></Cliente-component>
    <Reservacion-component v-bind:form="forms" ref="Reservacion" v-show="forms['Reservacion'].mostrar" ></Reservacion-component>
    
    
    <cliente v-bind:form="forms" ref="cliente" v-show="forms['cliente'].mostrar" ></cliente>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.5.1/socket.io.min.js" integrity="sha512-mHO4BJ0ELk7Pb1AzhTi3zvUeRgq3RXVOu9tTRfnA6qOxGK4pG2u57DJYolI4KrEnnLTcH9/J5wNOozRTDaybXg==" crossorigin="anonymous" referrerpolicy="no-referrer">
        
        </script>
        <script src="https://unpkg.com/vue-resizable@1"></script>
        <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
@endsection
