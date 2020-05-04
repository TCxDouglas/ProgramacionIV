var appBuscarClientes = new Vue({
    el: '#frm-buscar-clientes',
    data: {
        misclientes: [],
        valor: ''
    },
    methods: {
        buscarCliente: function () {
            fetch(`private/modulos/clientes/procesos.php?proceso=buscarCliente&cliente=${this.valor}`).then(resp => resp.json()).then(resp => {
                this.misclientes = resp;
            });
        },
        modificarCliente: function (cliente) {
            appcliente.cliente = cliente;
            appcliente.cliente.accion = 'modificar';
        },
        eliminarCliente: function (idCliente) {
            let dialog = document.getElementById("dialogCliente");
            dialog.close();
            dialog.showModal();

            $(`#btnCancelarCliente`).click(e => {
                dialog.close();
            });

            $(`#btnConfirmarCliente`).click(e => {
                fetch(`private/modulos/clientes/procesos.php?proceso=eliminarCliente&cliente=${idCliente}`).then(resp => resp.json()).then(resp => {
                    this.buscarCliente();
                    appcliente.limpiarCliente();
                });
                dialog.close();
            });

        }
    },

    created: function () {
        this.buscarCliente();
    }
});