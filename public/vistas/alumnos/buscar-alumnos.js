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
                    alertify.confirm("Mantenimiento Alumnos", "Esta seguro de eliminar",
                        () => {
                            fetch(`private/modulos/alumnos/procesos.php?proceso=eliminarAlumno&alumno=${idAlumno}`).then(resp => resp.json()).then(resp => {
                                this.buscarAlumno();
                            });
                            alertify.success('Registro Eliminado correctamente.');
                        },
                        () => {
                            alertify.error('Eliminacion cancelada por el usuario.');
                        });
                   
                }
            },
    created: function () {
    this.buscarAlumno();
    }
});