<?php

include('../../Config/config.php');
$alumno= new alumno($conexion);

$proceso='';

if(isset($_GET['proceso']) && strlen($_GET['proceso'])>0){
    $proceso=$_GET['proceso'];
}

$alumno->$proceso($_GET['alumno']);
print_r(json_encode($alumno->respuesta));

class alumno{
    private $datos=array(),$bd;
    public $respuesta=['msg'=>'correcto'];

    public function __construct($bd){
        $this->bd=$bd;
    }

    public function recibirDatos($alumno){
        $this->datos=json_decode($alumno, true);
        $this->validar_datos();
    }

    private function validar_datos(){
        if(empty(trim($this->datos['codigo']))){
            $this->respuesta['msg']='Por Favor Ingrese el codigo del estudiante';
        
        }
        if(empty(trim($this->datos['nombre']))){
            $this->respuesta['msg']='Por Favor Ingrese el nombre del estudiante';

        }
        if(empty(trim($this->datos['direccion']))){
            $this->respuesta['msg']='Por Favor Ingrese la direccion del estudiante';

        }
        $this->almacenar_alumno();
    }

    private function almacenar_alumno(){
        if($this->respuesta['msg']==='correcto'){
            if($this->datos['accion']==="nuevo"){
                $this->bd->consultas('
                INSERT INTO alumnos (codigo,nombre,direccion,telefono) VALUES(
                    "'. $this->datos['codigo'] .'",
                    "'. $this->datos['nombre'] .'",
                    "'. $this->datos['direccion'] .'",
                    "'. $this->datos['telefono'] .'"
                    )
                ');
                $this->respuesta['msg']='Registro Insertado con Exito';
            }else if($this->datos['accion']==='modificar'){
                $this->bd->consultas('
                UPDATE alumnos SET 
                codigo= "'. $this->datos['codigo'].'",
                nombre= "'. $this->datos['nombre'].'",
                direccion= "'. $this->datos['direccion'].'",
                telefono= "'.$this->datos['telefono'].'"
                WHERE idAlumno="'. $this->datos['idAlumno'].'"
                ');
                $this->respuesta['msg']='Registro Actualizado con Exito';
            }else{
                $this->respuesta['msg'] = 'Error no se envio la accion a realizar';
            }
        }
    }

    public function buscarAlumno($valor=''){
        $this->bd->consultas('
        SELECT alumnos.idAlumno, alumnos.codigo, alumnos.nombre, alumnos.direccion, alumnos.telefono
        FROM alumnos
        WHERE alumnos.codigo LIKE "%'.$valor.'%" OR alumnos.nombre LIKE "%'.$valor.'%"
        ');
        return $this->respuesta=$this->bd->obtener_datos();
    }

    public function eliminarAlumno($idAlumno=''){
        $this->bd->consultas('
        DELETE alumnos 
        FROM alumnos
        WHERE alumnos.idAlumno="'.$idAlumno.'"
        ');
        $this->respuesta['msg']="Registro Eliminado con Exito";
    }
}

?>