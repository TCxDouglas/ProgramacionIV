var appmateria = new Vue({
    el: '#frm-materia',
    data: {
        materia: {
            idmateria: 0,
            accion: 'nuevo',
            codigo: '',
            nombre: '',
            carrera: '',
            ciclo: '',
            msg: ''
        }
    },
    methods: {
        guardarMateria: function () {
            fetch(`private/modulos/materias/procesos.php?proceso=recibirDatos&materia=${JSON.stringify(this.materia)}`).then(resp => resp.json()).then(resp => {
                this.materia.msg = resp.msg;
                this.materia.idmateria = 0;
                this.materia.codigo = '';
                this.materia.nombre = '';
                this.materia.carrera = '';
                this.materia.ciclo = '';
                this.materia.accion = 'nuevo';
                appBuscarMateria.buscarMateria();
            });
        }
    }
});