<template>
    <div id="appReservacion">
        <div class="row">
            <div class="col col-md-4">
                <!--<vue-resizable :fit-parent="fit" :dragSelector="selector" :width="500">-->
                <div class="card text-white" id="carReservacion">
                    <div class="card-header bg-primary">
                        Registro de Reservacion
                        <button type="button" class="btn-close text-end" @click="cerrarForm"></button>
                    </div>
                    <div class="card-body text-dark">
                        <form method="post" @submit.prevent="guardarReservacion" @reset="nuevoReservacion">
                            
                            <div class="row p-1">
                                <div class="col col-md-3">Nombre:</div>
                                <div class="col">
                                    <input title="Ingrese el nombre" v-model="Reservacion.nombre" pattern="[A-Za-zñÑáéíóúü ]{3,75}" required type="text" class="form-control">
                                </div>
                            </div>
                            <div class="row p-1">
                                <div class="col col-md-3">Reservacion:</div>
                                <div class="col">
                                    <input title="Ingrese la reservacion" v-model="Reservacion.reservacion" pattern="[A-Za-zñÑáéíóúü ]{3,100}" required type="text" class="form-control">
                                </div>
                            </div>
                           
                           
                           
                            <div class="row p-1">
                                <div class="col text-center">
                                    <div v-if="Reservacion.mostrar_msg" class="alert alert-primary alert-dismissible fade show" role="alert">
                                        {{ Reservacion.msg }}
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
                <div class="card text-white" id="carBuscarReservacion">
                    <div class="card-header bg-primary">
                        Busqueda de Reservacions
                        <button type="button" @click="cerrarForm" class="btn-close" data-bs-dismiss="alert" data-bs-target="#carBuscarReservacion" aria-label="Close"></button>
                    </div>
                    <div class="card-body">
                        <table class="table table-dark table-hover">
                            <thead>
                                <tr>
                                    <th colspan="6">
                                        Buscar: <input @keyup="buscandoReservacion" v-model="buscar" placeholder="buscar aqui" class="form-control" type="text" >
                                    </th>
                                </tr>
                                <tr>
                                    <th>NOMBRE</th>
                                    <th>RESERVACION</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in Reservacions" @click='modificarReservacion( item )' :key="item.idReservacion">
                                    <td>{{item.nombre}}</td>
                                    <td>{{item.reservacion}}</td>
                                    
                                    <td>
                                        <button class="btn btn-danger" @click="eliminarReservacion(item)">Eliminar</button>
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
                Reservacions:[],
                Reservacion:{
                    accion : 'nuevo',
                    mostrar_msg : false,
                    msg : '',
                    id : 0,
                    idReservacion : '',
                    nombre: '',
                    reservacion: ''
                  
                }
            }
        },
        methods:{
            cerrarForm(){
                this.form['Reservacion'].mostrar = false;
            },
            async sincronizarDatosServidor(Reservacion, metodo, url){
                await axios({
                    method : metodo,
                    url,
                    data : Reservacion
                })
                .then(resp=>{
                    if(Reservacion.accion=='nuevo'){
                        Reservacion.id = resp.data.id;
                        this.insertarLocal(Reservacion);//actualizar el id del Reservacion que se genero en el servidor con laravel y mysql
                    }
                    this.Reservacion.msg = `Reservacion procesado ${data.msg}`;
                })
                .catch(err=>{
                    this.Reservacion.msg = `Error al procesar el Reservacion ${err}`;
                })
            },
            insertarLocal(Reservacion){
                let store = this.abrirStore('Reservacion', 'readwrite'),
                    query = store.put(Reservacion);
                query.onsuccess = e=>{
                    this.nuevoReservacion();
                    this.obtenerDatos();
                    this.Reservacion.msg = 'Reservacion procesado con exito';
                };
                query.onerror = e=>{
                    this.Reservacion.msg = `Error al procesar el Reservacion ${e.target.error}`;
                };
            },
            buscandoReservacion(){
                this.obtenerDatos(this.buscar);
            },
            eliminarReservacion(Reservacion){
                if( confirm(`Esta seguro de eliminar el Reservacion ${Reservacion.nombre}?`) ){
                    Reservacion.accion = 'eliminar';
                    let store = this.abrirStore('Reservacion', 'readwrite'),
                        query = store.delete(Reservacion.idReservacion),
                        metodo = 'DELETE',
                        url = `/Reservacion/${Reservacion.id}`;
                    this.sincronizarDatosServidor(Reservacion, metodo, url);
                    query.onsuccess = e=>{
                        this.nuevoReservacion();
                        this.obtenerDatos();
                        this.Reservacion.msg = 'Reservacion eliminado con exito';
                    };
                    query.onerror = e=>{
                        this.Reservacion.msg = `Error al eliminar el Reservacion ${e.target.error}`;
                    };
                }
                this.nuevoReservacion();
            },
            modificarReservacion(datos){
                this.Reservacion = JSON.parse(JSON.stringify(datos));
                this.Reservacion.accion = 'modificar';
            },
            guardarReservacion(){
                let metodo = 'PUT',
                    url = `/Reservacion/${this.Reservacion.id}`;
                if(this.Reservacion.accion=="nuevo"){
                    this.Reservacion.idReservacion = generarIdUnicoFecha();
                    metodo = 'POST';
                    url = '/Reservacion';
                }
                let Reservacion = JSON.parse(JSON.stringify(this.Reservacion));
                this.sincronizarDatosServidor(Reservacion, metodo, url);
                this.insertarLocal(Reservacion);
            },
            obtenerDatos(valor=''){
                let store = this.abrirStore('Reservacion', 'readonly'),
                    data = store.getAll();
                data.onsuccess = e=>{
                    if( data.result.length<=0 ){
                        fetch(`Reservacion`, 
                            {credentials: 'same-origin'})
                            .then(res=>res.json())
                            .then(data=>{
                                this.Reservacions = data;
                                data.map(Reservacion=>{
                                    let store = this.abrirStore('Reservacion', 'readwrite'),
                                        query = store.put(Reservacion);
                                    query.onsuccess = e=>{
                                        console.log(`Reservacion ${Reservacion.nombre} guardado`);
                                    };
                                    query.onerror = e=>{
                                        console.log(`Error al guardar el Reservacion ${e.target.error}`);
                                    };
                                });
                            })
                            .catch(err=>{
                                this.Reservacion.msg = `Error al guardar el Reservacion ${err}`;
                            });
                    }
                    this.Reservacions = data.result.filter(Reservacion=>Reservacion.nombre.toLowerCase().indexOf(valor.toLowerCase())>-1);
                };
                data.onerror = e=>{
                    this.Reservacion.msg = `Error al obtener los Reservacions ${e.target.error}`;
                };
            },
            nuevoReservacion(){
                this.Reservacion.accion = 'nuevo';
                this.Reservacion.msg = '';
                this.Reservacion.idReservacion = '';
                this.Reservacion.nombre = '';
                this.Reservacion.reservacion = '';
            
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