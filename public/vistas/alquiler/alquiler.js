Vue.component('v-select', VueSelect.VueSelect);

var appAlquiler = new Vue({
    el: '#frm-alquiler',
    data: {
        Alquiler: {
            idalquiler: 0,
            accion: 'nuevo',
            nombreC: '',
            nombre: '',
            fechaPrestamo: '',
            fechaDevolucion: '',
            valor: '',
            msg: ''
        },
        Pelis : [],
        PelisId : [],
        Cliente : [],
        ClienteId : []

    },
    methods: {


        guardarAlquiler: function () {

            for (let index = 0; index < this.Pelis.length; index++) {
                if (this.Pelis[index] == this.Alquiler.nombre) {
                    this.Alquiler.nombre = this.PelisId[index];
                }
            }

            for (let index = 0; index < this.Cliente.length; index++) {
                if (this.Cliente[index] == this.Alquiler.nombreC) {
                    this.Alquiler.nombreC = this.ClienteId[index];
                }
            }

            var d = new Date();
            let Fecha = d.getFullYear() + "-" + ("0" + (d.getMonth() + 1)).slice(-2)  + "-" + ("0" + (d.getDate())).slice(-2);
            this.Alquiler.fechaPrestamo = Fecha;

            fetch(`private/modulos/alquiler/procesos.php?proceso=recibirDatos&alquiler=${JSON.stringify(this.Alquiler)}`).then(resp => resp.json()).then(resp => {
                this.Alquiler.msg = resp.msg;
                this.Alquiler.idalquiler = 0;
                this.Alquiler.nombreC = '';
                this.Alquiler.nombre = '';
                this.Alquiler.fechaPrestamo = '';
                this.Alquiler.fechaDevolucion = '';
                this.Alquiler.valor = '';
                this.Alquiler.accion = 'nuevo';
                appBuscarAlquiler.buscarAlquiler();
            });
        },

        limpiarData:function(){
            
            this.Alquiler.idalquiler = 0;
            this.Alquiler.nombreC = '';
            this.Alquiler.nombre = '';
            this.Alquiler.fechaPrestamo = '';
            this.Alquiler.fechaDevolucion = '';
            this.Alquiler.valor = '';
            this.Alquiler.accion = 'nuevo';
        }




    },
    created: function () {
        fetch(`private/modulos/alquiler/procesos.php?proceso=traer_datos_clientes&alquiler=`).then(resp=>resp.json()).then(resp=>{
            console.log(JSON.stringify(resp.Clientes));
            appAlquiler.Cliente = resp.Clientes;
            appAlquiler.ClienteId = resp.ClientesID;

        });

        fetch(`private/modulos/alquiler/procesos.php?proceso=traer_datos_peliculas&alquiler=`).then(resp=>resp.json()).then(resp=>{
            console.log(JSON.stringify(resp.Peliculas));
            appAlquiler.Pelis = resp.Peliculas;
            appAlquiler.PelisId = resp.PeliculasID;

        });
        }
});