<template>
    <div id="appCliente">
        <div class="row">
            <div class="col col-md-4">
                <!--<vue-resizable :fit-parent="fit" :dragSelector="selector" :width="500">-->
                <div class="card text-white" id="carCliente">
                    <div class="card-header bg-primary">
                        Registro de Clientes
                        <button type="button" class="btn-close text-end" @click="cerrarForm"></button>
                    </div>
                    <div class="card-body text-dark">
                        <form method="post" @submit.prevent="guardarCliente" @reset="nuevoCliente">
                            <div class="row p-1">
                                <div class="col col-md-3">Codigo:</div>
                                <div class="col col-md-4">
                                    <input title="Ingrese el codigo" v-model="cliente.codigo" pattern="[0-9]{3,10}" required type="text" class="form-control">
                                </div>
                            </div>
                            <div class="row p-1">
                                <div class="col col-md-3">Nombre:</div>
                                <div class="col">
                                    <input title="Ingrese el nombre" v-model="cliente.nombre" pattern="[A-Za-zñÑáéíóúü ]{3,75}" required type="text" class="form-control">
                                </div>
                            </div>
                            <div class="row p-1">
                                <div class="col col-md-3">Direccion:</div>
                                <div class="col">
                                    <input title="Ingrese la direccion" v-model="cliente.direccion" pattern="[A-Za-zñÑáéíóúü ]{3,100}" required type="text" class="form-control">
                                </div>
                            </div>
                            <div class="row p-1">
                                <div class="col col-md-3">Telefono:</div>
                                <div class="col col-md-4">
                                    <input title="Ingrese el tel" v-model="cliente.telefono" pattern="[0-9]{4}-[0-9]{4}" required type="text" class="form-control">
                                </div>
                            </div>
                            <div class="row p-1">
                                <div class="col col-md-3">DUI:</div>
                                <div class="col">
                                    <input title="Ingrese el DUI" v-model="cliente.dui" pattern="[0-9]{8}-[0-9]{1}" required type="text" class="form-control">
                                </div>
                            </div>
                            <div class="row p-1">
                                <div class="col text-center">
                                    <div v-if="cliente.mostrar_msg" class="alert alert-primary alert-dismissible fade show" role="alert">
                                        {{ cliente.msg }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-2">
                                <div class="col text-center">
                                    <input class="btn btn-success" type="submit" value="Guardar">
                                    <input class="btn btn-warning" type="reset" value="Nuevo">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!--</vue-resizable>-->
            </div>
            <div class="col col-md-8">
                <!--<vue-resizable :dragSelector="selector" :width="600">-->
                <div class="card text-white" id="carBuscarcliente">
                    <div class="card-header bg-primary">
                        Busqueda de clientes
                        <button type="button" @click="cerrarForm" class="btn-close" data-bs-dismiss="alert" data-bs-target="#carBuscarcliente" aria-label="Close"></button>
                    </div>
                    <div class="card-body">
                        <table class="table table-dark table-hover">
                            <thead>
                                <tr>
                                    <th colspan="6">
                                        Buscar: <input @keyup="buscandocliente" v-model="buscar" placeholder="buscar aqui" class="form-control" type="text" >
                                    </th>
                                </tr>
                                <tr>
                                    <th>CODIGO</th>
                                    <th>NOMBRE</th>
                                    <th>DIRECCION</th>
                                    <th>TEL</th>
                                    <th>DUI</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in clientes" @click='modificarcliente( item )' :key="item.idcliente">
                                    <td>{{item.codigo}}</td>
                                    <td>{{item.nombre}}</td>
                                    <td>{{item.direccion}}</td>
                                    <td>{{item.telefono}}</td>
                                    <td>{{item.dui}}</td>
                                    <td>
                                        <button class="btn btn-danger" @click="eliminarcliente(item)">Eliminar</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--</vue-resizable>-->
            </div>
        </div>
    </div>
</template>

<script>
    //Vue.component('vue-resizable', VueResizable.default);
    export default {
        props : ['form'],
         data:()=>{
            return {
                selector: '.card',
                fit: false,
                buscar:'',
                clientes:[],
                cliente:{
                    accion : 'nuevo',
                    mostrar_msg : false,
                    msg : '',
                    id : 0,
                    idcliente : '',
                    codigo: '',
                    nombre: '',
                    direccion: '',
                    telefono: '',
                    dui: ''
                }
            }
        },
        methods:{
            cerrarForm(){
                this.form['cliente'].mostrar = false;
            },
            async sincronizarDatosServidor(cliente, metodo, url){
                await axios({
                    method : metodo,
                    url,
                    data : cliente
                })
                .then(resp=>{
                    if(cliente.accion=='nuevo'){
                        cliente.id = resp.data.id;
                        this.insertarLocal(cliente);//actualizar el id del cliente que se genero en el servidor con laravel y mysql
                    }
                    this.cliente.msg = `cliente procesado ${data.msg}`;
                })
                .catch(err=>{
                    this.cliente.msg = `Error al procesar el cliente ${err}`;
                })
            },
            insertarLocal(cliente){
                let store = this.abrirStore('cliente', 'readwrite'),
                    query = store.put(cliente);
                query.onsuccess = e=>{
                    this.nuevocliente();
                    this.obtenerDatos();
                    this.cliente.msg = 'cliente procesado con exito';
                };
                query.onerror = e=>{
                    this.cliente.msg = `Error al procesar el cliente ${e.target.error}`;
                };
            },
            buscandocliente(){
                this.obtenerDatos(this.buscar);
            },
            eliminarcliente(cliente){
                if( confirm(`Esta seguro de eliminar el cliente ${cliente.nombre}?`) ){
                    cliente.accion = 'eliminar';
                    let store = this.abrirStore('cliente', 'readwrite'),
                        query = store.delete(cliente.idcliente),
                        metodo = 'DELETE',
                        url = `/cliente/${cliente.id}`;
                    this.sincronizarDatosServidor(cliente, metodo, url);
                    query.onsuccess = e=>{
                        this.nuevocliente();
                        this.obtenerDatos();
                        this.cliente.msg = 'cliente eliminado con exito';
                    };
                    query.onerror = e=>{
                        this.cliente.msg = `Error al eliminar el cliente ${e.target.error}`;
                    };
                }
                this.nuevocliente();
            },
            modificarcliente(datos){
                this.cliente = JSON.parse(JSON.stringify(datos));
                this.cliente.accion = 'modificar';
            },
            guardarcliente(){
                let metodo = 'PUT',
                    url = `/cliente/${this.cliente.id}`;
                if(this.cliente.accion=="nuevo"){
                    this.cliente.idcliente = generarIdUnicoFecha();
                    metodo = 'POST';
                    url = '/cliente';
                }
                let cliente = JSON.parse(JSON.stringify(this.cliente));
                this.sincronizarDatosServidor(cliente, metodo, url);
                this.insertarLocal(cliente);
            },
            obtenerDatos(valor=''){
                let store = this.abrirStore('cliente', 'readonly'),
                    data = store.getAll();
                data.onsuccess = e=>{
                    if( data.result.length<=0 ){
                        fetch(`cliente`, 
                            {credentials: 'same-origin'})
                            .then(res=>res.json())
                            .then(data=>{
                                this.clientes = data;
                                data.map(cliente=>{
                                    let store = this.abrirStore('cliente', 'readwrite'),
                                        query = store.put(cliente);
                                    query.onsuccess = e=>{
                                        console.log(`cliente ${cliente.nombre} guardado`);
                                    };
                                    query.onerror = e=>{
                                        console.log(`Error al guardar el cliente ${e.target.error}`);
                                    };
                                });
                            })
                            .catch(err=>{
                                this.cliente.msg = `Error al guardar el cliente ${err}`;
                            });
                    }
                    this.clientes = data.result.filter(cliente=>cliente.nombre.toLowerCase().indexOf(valor.toLowerCase())>-1);
                };
                data.onerror = e=>{
                    this.cliente.msg = `Error al obtener los clientes ${e.target.error}`;
                };
            },
            nuevocliente(){
                this.cliente.accion = 'nuevo';
                this.cliente.msg = '';
                this.cliente.idcliente = '';
                this.cliente.codigo = '';
                this.cliente.nombre = '';
                this.cliente.direccion = '';
                this.cliente.telefono = '';
                this.cliente.dui = '';
            },
            abrirStore(store, modo){
                return db.transaction(store, modo).objectStore(store);
            }
        },
        created(){
            //this.obtenerDatos();
        },
    }
</script>