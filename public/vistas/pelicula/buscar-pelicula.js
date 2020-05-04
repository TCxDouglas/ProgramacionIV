var appBuscarPelicula = new Vue({
    el: '#frm-buscar-pelicula',
    data: {
        mispeliculas: [],
        valor: ''
    },
    methods: {
        buscarPelicula: function () {
            fetch(`private/modulos/peliculas/procesos.php?proceso=buscarPelicula&peliculas=${this.valor}`).then(resp => resp.json()).then(resp => {
                console.log(resp);
                this.mispeliculas = resp;
            });
        },
        modificarPelicula: function (pelicula) {
            apppelicula.pelicula = pelicula;
            apppelicula.pelicula.accion = 'modificar';
        },
        eliminarPelicula: function (id_pelicula) {
            let dialog = document.getElementById("dialogPelicula");
            dialog.close();
            dialog.showModal();


            $(`#btnCancelarPelicula`).click(e=>{
                dialog.close();
            })

            $(`#btnConfirmarPelicula`).click(e=>{
                fetch(`private/modulos/peliculas/procesos.php?proceso=eliminarPelicula&peliculas=${id_pelicula}`).then(resp => resp.json()).then(resp => {
                    console.log(resp)
                    this.buscarPelicula();
                });
                dialog.close();
            })
            
        }
    },
    created: function () {
        this.buscarPelicula();
    }
});