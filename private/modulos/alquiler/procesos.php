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
        if(empty($this->datos['nombreC'])){
            $this->respuesta['msg']='Por Favor Ingrese el cliente del alquiler';
        
        }
        if(empty($this->datos['nombre'])){
            $this->respuesta['msg']='Por Favor Ingrese la Pelicula del alquiler';

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
                    "'. $this->datos['nombreC'] .'",
                    "'. $this->datos['nombre'] .'",
                    "'. $this->datos['fechaPrestamo'] .'",
                    "'. $this->datos['fechaDevolucion'] .'",
                    "'. $this->datos['valor'] .'"
                    )
                ');
                $this->respuesta['msg']='Registro Insertado con Exito';
            }
            else if($this->datos['accion']==='modificar'){
                $this->bd->consultas('
                UPDATE alquiler SET 
                idCliente= "'. $this->datos['nombreC'].'",
                idPelicula= "'. $this->datos['nombre'].'",
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
        SELECT alquiler.idAlquiler, clientes.nombreC, peliculas.nombre, alquiler.fechaPrestamo, alquiler.fechaDevolucion, alquiler.valor 
        FROM alquiler INNER JOIN peliculas ON(peliculas.idPelicula=alquiler.idPelicula) 
        INNER JOIN clientes ON(clientes.idCliente=alquiler.idCliente) 
        WHERE clientes.nombreC LIKE "%'.$valor .'%" OR peliculas.nombre LIKE "%'.$valor .'%"
        ');
        return $this->respuesta=$this->bd->obtener_datos();
    }

    public function eliminarAlquiler($idAlquiler=''){
        $this->bd->consultas(' DELETE alquiler
        FROM alquiler
        WHERE alquiler.idAlquiler="'.$idAlquiler.'"
        ');
        $this->respuesta['msg']="Registro Eliminado con Exito";
    }


    public function traer_datos_clientes(){
        $this->bd->consultas('SELECT * FROM clientes');
        $Clientes = $this->bd->obtener_datos();
        $imprimirClientes = [];
        $imprimirClientesIDs = [];
        for ($i=0; $i < count($Clientes); $i++) { 
            $imprimirClientes[] = $Clientes[$i]['nombreC'];
            $imprimirClientesIDs[] = $Clientes[$i]['idCliente'];
        }
        // echo json_encode($imprimirAgregarServicios);

        return $this->respuesta = ['Clientes'=>$imprimirClientes, 'ClientesID'=>$imprimirClientesIDs ];//array de php en v7+
    }

    public function traer_datos_peliculas(){
        $this->bd->consultas('SELECT * FROM peliculas');
        $Peliculas = $this->bd->obtener_datos();
        $imprimirPeliculas = [];
        $imprimirPeliculasIDs = [];
        for ($i=0; $i < count($Peliculas); $i++) { 
            $imprimirPeliculas[] = $Peliculas[$i]['nombre'];
            $imprimirPeliculasIDs[] = $Peliculas[$i]['idPelicula'];
        }
        // echo json_encode($imprimirAgregarServicios);

        return $this->respuesta = ['Peliculas'=>$imprimirPeliculas, 'PeliculasID'=>$imprimirPeliculasIDs ];//array de php en v7+
    }
}

?>