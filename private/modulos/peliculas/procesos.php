<?php

include('../../Config/config.php');
$peliculas= new peliculas($conexion);

$proceso='';

if(isset($_GET['proceso']) && strlen($_GET['proceso'])>0){
    $proceso=$_GET['proceso'];
}

$peliculas->$proceso($_GET['peliculas']);
print_r(json_encode($peliculas->respuesta));

class peliculas{
    private $datos=array(),$bd;
    public $respuesta=['msg'=>'correcto'];

    public function __construct($bd){
        $this->bd=$bd;
    }

    public function recibirDatos($peliculas){
        $this->datos=json_decode($peliculas, true);
        $this->validar_datos();
    }

    private function validar_datos(){
        if(empty($this->datos['nombre'])){
            $this->respuesta['msg']='Por Favor Ingrese el nombre del peliculas';
        
        }
        if(empty($this->datos['genero'])){
            $this->respuesta['msg']='Por Favor Ingrese el genero del peliculas';

        }
        if(empty($this->datos['duracion'])){
            $this->respuesta['msg']='Por Favor Ingrese la duracion del peliculas';

        }
        $this->almacenar_pelicula();
    }

    private function almacenar_pelicula(){
        if($this->respuesta['msg']==='correcto'){
            if($this->datos['accion']==="nuevo"){
                $this->bd->consultas('
                INSERT INTO peliculas (nombre,sinopsis,genero,duracion) VALUES(
                    "'. $this->datos['nombre'] .'",
                    "'. $this->datos['sinopsis'] .'",
                    "'. $this->datos['genero'] .'",
                    "'. $this->datos['duracion'] .'"
                    )
                ');
                $this->respuesta['msg']='Registro Insertado con Exito';
            }else if($this->datos['accion']==='modificar'){
                $this->bd->consultas('
                UPDATE peliculas SET
                nombre= "'. $this->datos['nombre'].'",
                sinopsis= "'. $this->datos['sinopsis'].'",
                genero= "'.$this->datos['genero'].'",
                duracion= "'.$this->datos['duracion'].'"
                WHERE idPelicula="'. $this->datos['idPelicula'].'"
                ');
                $this->respuesta['msg']='Registro Actualizado con Exito';
            }
        }
    }

    public function buscarPelicula($valor=''){
        $this->bd->consultas('
        SELECT peliculas.idPelicula, peliculas.nombre, peliculas.sinopsis, peliculas.genero, peliculas.duracion
        FROM peliculas
        WHERE peliculas.nombre LIKE "%'.$valor.'%" OR peliculas.genero LIKE "%'.$valor.'%" OR peliculas.duracion LIKE "%'.$valor.'%"
        ');
        return $this->respuesta=$this->bd->obtener_datos();
    }

    public function eliminarPelicula($idPelicula=''){
        $this->bd->consultas('
        DELETE peliculas 
        FROM peliculas
        WHERE peliculas.idPelicula="'.$idPelicula.'"
        ');
        $this->respuesta['msg']="Registro Eliminado con Exito";
    }
}

?>