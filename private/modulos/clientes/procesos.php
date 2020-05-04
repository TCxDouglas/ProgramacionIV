<?php

include('../../Config/config.php');
$cliente= new cliente($conexion);

$proceso='';

if(isset($_GET['proceso']) && strlen($_GET['proceso'])>0){
    $proceso=$_GET['proceso'];
}

$cliente->$proceso($_GET['cliente']);
print_r(json_encode($cliente->respuesta));

class cliente{
    private $datos=array(),$bd;
    public $respuesta=['msg'=>'correcto'];

    public function __construct($bd){
        $this->bd=$bd;
    }

    public function recibirDatos($cliente){
        $this->datos=json_decode($cliente, true);
        $this->validar_datos();
    }

    private function validar_datos(){
        if(empty($this->datos['dui'])){
            $this->respuesta['msg']='Por Favor Ingrese el DUI del cliente';
        
        }
        if(empty($this->datos['nombreC'])){
            $this->respuesta['msg']='Por Favor Ingrese el nombre del cliente';

        }
        if(empty($this->datos['direccion'])){
            $this->respuesta['msg']='Por Favor Ingrese la direccion del cliente';

        }
        $this->almacenar_cliente();
    }

    private function almacenar_cliente(){
        if($this->respuesta['msg']==='correcto'){
            if($this->datos['accion']==="nuevo"){
                $this->bd->consultas('
                INSERT INTO clientes (nombreC,direccion,telefono,dui) VALUES(
                    "'. $this->datos['nombreC'] .'",
                    "'. $this->datos['direccion'] .'",
                    "'. $this->datos['telefono'] .'",
                    "'. $this->datos['dui'] .'"
                    )
                ');
                $this->respuesta['msg']='Registro Insertado con Exito';
            }else if($this->datos['accion']==='modificar'){
                $this->bd->consultas('
                UPDATE clientes SET 
                nombreC= "'. $this->datos['nombreC'].'",
                direccion= "'. $this->datos['direccion'].'",
                telefono= "'.$this->datos['telefono'].'",
                dui= "'.$this->datos['dui'].'"
                WHERE idCliente="'. $this->datos['idCliente'].'"
                ');
                $this->respuesta['msg']='Registro Actualizado con Exito';
            }
        }
    }

    public function buscarCliente($valor=''){
        $this->bd->consultas('
        SELECT clientes.idCliente, clientes.nombreC, clientes.direccion, clientes.telefono, clientes.dui
        FROM clientes
        WHERE clientes.nombreC LIKE "%'.$valor.'%" OR clientes.direccion LIKE "%'.$valor.'%" OR clientes.dui LIKE "%'.$valor.'%"
        ');
        return $this->respuesta=$this->bd->obtener_datos();
    }

    public function eliminarCliente($idCliente=''){
        $this->bd->consultas('
        DELETE clientes 
        FROM clientes
        WHERE clientes.idCliente="'.$idCliente.'"
        ');
        $this->respuesta['msg']="Registro Eliminado con Exito";
    }
}

?>