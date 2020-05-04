var appBuscarAlumnos = new Vue({
            el: '#frm-buscar-alumnos',
            data: {
                misalumnos: [],
                valor: ''
            },
            methods: {
                buscarAlumno: function () {
                        fetch(`private/modulos/alumnos/procesos.php?proceso=buscarAlumno&alumno=${this.valor}`).then(resp => resp.json()).then(resp => {
                            this.misalumnos = resp;
                        });
                },
                modificarAlumno: function (alumno) {
                    appalumno.alumno = alumno;
                    appalumno.alumno.accion = 'modificar';
                },
                eliminarAlumno: function (idAlumno) {
                    let dialog = document.getElementById("dialogAlumno");
                    dialog.close();
                    dialog.showModal();

                    $(`#btnCancelarAlumno`).click(e => {
                        dialog.close();
                    });

                    $(`#btnConfirmarAlumno`).click(e => {
                         fetch(`private/modulos/alumnos/procesos.php?proceso=eliminarAlumno&alumno=${idAlumno}`).then(resp => resp.json()).then(resp => {
                             this.buscarAlumno();
                             appalumno.limpiarAlumno();
                         });
                        dialog.close();
                    });
                   
                }
            },
    created: function () {
    this.buscarAlumno();
    }
});