var appBuscarAlquiler = new Vue({
    el: '#frm-buscar-alquiler',
    data: {
        misalquileres: [],
        valor: ''
    },
    methods: {
        buscarAlquiler: function () {
            fetch(`private/modulos/alquiler/procesos.php?proceso=buscarAlquiler&alquiler=${this.valor}`).then(resp => resp.json()).then(resp => {
                this.misalquileres = resp;
            });
        },
        modificarAlquiler: function (alquiler) {
            appAlquiler.Alquiler = alquiler;
            appAlquiler.Alquiler.accion = 'modificar';
        },
        eliminarAlquiler: function (idAlquiler) {
            let dialog = document.getElementById("dialogAlquiler");
            dialog.close();
            dialog.showModal();

            $(`#btnCancelarAlquiler`).click(e => {
                dialog.close();
            });

            $(`#btnConfirmarAlquiler`).click(e => {
                fetch(`private/modulos/alquiler/procesos.php?proceso=eliminarAlquiler&alquiler=${idAlquiler}`).then(resp => resp.json()).then(resp => {
                    //console.log(resp)
                    this.buscarAlquiler();
                    
                });
                dialog.close();
            });
            
        }
    },
    created: function () {
        this.buscarAlquiler();
    }
});