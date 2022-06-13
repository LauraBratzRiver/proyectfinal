/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
import Vue from 'vue';
window.db = '';
window.generarIdUnicoFecha = ()=>{
    let fecha = new Date();
    return Math.floor(fecha.getTime()/1000).toString(16);
}

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
import cliente from './components/ClienteComponent.vue';
import reservacion from './components/ReservacionComponent.vue';
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',

    components:{
        cliente,
        reservacion,
        
    },
    data:{
        forms:{
            cliente:{mostrar:false},
            reservacion:{mostrar:false}
          
        }
    },
    methods:{
        abrirForm(form){
            this.forms[form].mostrar = !this.forms[form].mostrar;
            this.$refs[form].obtenerDatos();
        },
        abrirBd(){
            /**
             * Mecanismos de Almacenamiento
             * 1. WebSQL
             * 2. localStorage
             * 3. IndexedDB
             */
            let indexDb = indexedDB.open('db_carWash', 1);
            indexDb.onupgradeneeded = e=>{
                let db = e.target.result;
                let tblcliente = db.createObjectStore('cliente', {keyPath:'idCliente'});
                
 ;

                tblcliente.createIndex('idCliente', 'idCliente', {unique:true});
                tblcliente.createIndex('codigo', 'codigo', {unique:false});

          
            };
            indexDb.onsuccess = e=>{
                db = e.target.result;
            };
            indexDb.onerror = e=>{
                console.log(e.target.error);
            };
        },
    },
    created(){
        this.abrirBd();
    }
});
