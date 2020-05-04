var appcliente = new Vue({
    el: '#frm-clientes',
    data: {
        cliente: {
            idCliente: 0,
            accion: 'nuevo',
            nombreC: '',
            direccion: '',
            telefono: '',
            dui: '',
            msg: ''
        }
    },
    methods: {
        guardarCliente: function () {
            fetch(`private/modulos/clientes/procesos.php?proceso=recibirDatos&cliente=${JSON.stringify(this.cliente)}`).then(resp => resp.json()).then(resp => {
                this.cliente.msg = resp.msg;
                this.limpiarCliente()
            });
        },
        limpiarCliente: function () {
            this.cliente.idCliente = 0;
            this.cliente.nombreC = '';
            this.cliente.direccion = '';
            this.cliente.telefono = '';
            this.cliente.accion = 'nuevo';
            appBuscarClientes.buscarCliente();
        }
    }
});