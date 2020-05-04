var apppelicula = new Vue({
    el: '#frmPelicula',
    data: {
        pelicula: {
            id_pelicula: 0,
            accion: 'nuevo',
            nombre: '',
            sinopsis: '',
            genero: '',
            duracion: '',
            msg: ''
        }
    },
    methods: {
        guardarPelicula: function () {
            fetch(`private/modulos/peliculas/procesos.php?proceso=recibirDatos&peliculas=${JSON.stringify(this.pelicula)}`).then(resp => resp.json()).then(resp => {
                this.pelicula.msg = resp.msg;
                this.pelicula.id_pelicula = 0;
                this.pelicula.nombre = '';
                this.pelicula.sinopsis = '';
                this.pelicula.genero = '';
                this.pelicula.duracion = '';
                this.pelicula.accion = 'nuevo';
                appBuscarPelicula.buscarPelicula();
            });
        }
    }
});