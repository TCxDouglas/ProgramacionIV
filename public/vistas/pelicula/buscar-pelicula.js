var appBuscarMateria = new Vue({
    el: '#frm-buscar-materias',
    data: {
        mismaterias: [],
        valor: ''
    },
    methods: {
        buscarMateria: function () {
            fetch(`private/modulos/materias/procesos.php?proceso=buscarMateria&materia=${this.valor}`).then(resp => resp.json()).then(resp => {
                this.mismaterias = resp;
            });
        },
        modificarMateria: function (materia) {
            appmateria.materia = materia;
            appmateria.materia.accion = 'modificar';
        },
        eliminarMateria: function (idMateria) {
            let dialog = document.getElementById("dialogMaterias");
            dialog.close();
            dialog.showModal();

            $(`#btnCancelarMateria`).click(e => {
                dialog.close();
            });

            $(`#btnConfirmarMateria`).click(e => {
                fetch(`private/modulos/materias/procesos.php?proceso=eliminarMateria&materia=${idMateria}`).then(resp => resp.json()).then(resp => {
                    //console.log(resp)
                    this.buscarMateria();
                });
                dialog.close();
            });
            
        }
    },
    created: function () {
        this.buscarMateria();
    }
});