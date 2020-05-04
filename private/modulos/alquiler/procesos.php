<?php

include('../../Config/config.php');
$alquiler= new alquiler($conexion);

$proceso='';

if(isset($_GET['proceso']) && strlen($_GET['proceso'])>0){
    $proceso=$_GET['proceso'];
}

$alquiler->$proceso($_GET['alquiler']);
print_r(json_encode($alquiler->respuesta));

class alquiler{
    private $datos=array(),$bd;
    public $respuesta=['msg'=>'correcto'];

    public function __construct($bd){
        $this->bd=$bd;
    }

    public function recibirDatos($alquiler){
        $this->datos=json_decode($alquiler, true);
        $this->validar_datos();
    }

    private function validar_datos(){
        if(empty($this->datos['idCliente'])){
            $this->respuesta['msg']='Por Favor Ingrese el idCliente del alquiler';
        
        }
        if(empty($this->datos['idPelicula'])){
            $this->respuesta['msg']='Por Favor Ingrese el idPelicula del alquiler';

        }
        if(empty($this->datos['fechaPrestamo'])){
            $this->respuesta['msg']='Por Favor Ingrese la Fecha de Prestamo del alquiler';

        }
        $this->almacenar_alquiler();
    }

    private function almacenar_alquiler(){
        if($this->respuesta['msg']==='correcto'){
            if($this->datos['accion']==="nuevo"){
                $this->bd->consultas('
                INSERT INTO alquiler (idCliente, idPelicula, fechaPrestamo, fechaDevolucion, valor) VALUES(
                    "'. $this->datos['idCliente'] .'",
                    "'. $this->datos['idPelicula'] .'",
                    "'. $this->datos['fechaPrestamo'] .'",
                    "'. $this->datos['fechaDevolucion'] .'",
                    "'. $this->datos['valor'] .'"
                    )
                ');
                $this->respuesta['msg']='Registro Insertado con Exito';
            }else if($this->datos['accion']==='modificar'){
                $this->bd->consultas('
                UPDATE alquiler SET 
                idCliente= "'. $this->datos['idCliente'].'",
                idPelicula= "'. $this->datos['idPelicula'].'",
                fechaPrestamo= "'.$this->datos['fechaPrestamo'].'",
                fechaDevolucion= "'.$this->datos['fechaDevolucion'].'",
                valor= "'.$this->datos['valor'].'"
                WHERE idAlquiler="'. $this->datos['idAlquiler'].'"
                ');
                $this->respuesta['msg']='Registro Actualizado con Exito';
            }
        }
    }

    public function buscarAlquiler($valor=''){
        $this->bd->consultas('
            SELECT cl.nombre, pe.nombre, al.fechaPrestamo, al.fechaDevolucion, al.valor
            FROM alquiler al, clientes cl, peliculas pe
            WHERE al.idCliente=cl.idCliente AND al.idPelicula=pe.idPelicula AND
            cl.nombre LIKE "%'.$valor.'%" OR pe.nombre LIKE "%'.$valor.'%"
        ');
        return $this->respuesta=$this->bd->obtener_datos();
    }

    public function eliminarAlquiler($idAlquiler=''){
        $this->bd->consultas('
        DELETE alquiler 
        FROM alquiler
        WHERE alquiler.idAlquiler="'.$idAlquiler.'"
        ');
        $this->respuesta['msg']="Registro Eliminado con Exito";
    }
}

?>