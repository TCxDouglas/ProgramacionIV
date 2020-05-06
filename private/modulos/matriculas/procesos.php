<?php

include('../../Config/config.php');
$matricula= new matricula($conexion);

$proceso='';

if(isset($_GET['proceso']) && strlen($_GET['proceso'])>0){
    $proceso=$_GET['proceso'];
}

$matricula->$proceso($_GET['matricula']);
print_r(json_encode($matricula->respuesta));

class matricula{
    private $datos=array(),$bd;
    public $respuesta=['msg'=>'correcto'];

    public function __construct($bd){
        $this->bd=$bd;
    }

    public function recibirDatos($matricula){
        $this->datos=json_decode($matricula, true);
        $this->validar_datos();
    }

    private function validar_datos(){
        if(empty($this->datos['periodo']['id'])){
            $this->respuesta['msg']='Por Favor el periodo del matricula';
        
        }
        if(empty($this->datos['alumno']['id'])){
            $this->respuesta['msg']='Por Favor Ingrese el alumno';

        }
        $this->almacenar_matricula();
    }

    private function almacenar_matricula(){
        if($this->respuesta['msg']==='correcto'){
            if($this->datos['accion']==="nuevo"){
                $this->bd->consultas('
                INSERT INTO matriculas (idPeriodo,idAlumno,fecha) VALUES(
                    "'. $this->datos['periodo']['id'] .'",
                    "'. $this->datos['alumno']['id'] .'",
                    "'. $this->datos['fecha'] .'"
                    )
                ');
                $this->respuesta['msg']='Registro Insertado con Exito';
            }else if($this->datos['accion']==='modificar'){
                $this->bd->consultas('
                UPDATE matriculas SET 
                idPeriodo= "'. $this->datos['periodo']['id'].'",
                idAlumno= "'. $this->datos['alumno']['id'].'",
                fecha= "'. $this->datos['fecha'].'"
                WHERE idMatricula="'. $this->datos['idMatricula'].'"
                ');
                $this->respuesta['msg']='Registro Actualizado con Exito';
            }
        }
    }

    public function buscarMatricula($valor=''){

        if( substr_count($valor, '-')===2 ){
            $valor = implode('-', array_reverse(explode('-',$valor)));
        }

        $this->bd->consultas('
            SELECT matriculas.idMatricula, matriculas.idPeriodo, matriculas.idAlumno, 
                date_format(matriculas.fecha,"%d-%m-%Y") AS fecha, matriculas.fecha AS f, 
                alumnos.codigo, alumnos.nombre, 
                periodos.periodo, periodos.activo
                FROM matriculas
                INNER JOIN alumnos on(alumnos.idAlumno=matriculas.idAlumno)
                INNER JOIN periodos on(periodos.idPeriodo=matriculas.idPeriodo)
                WHERE alumnos.nombre LIKE "%'. $valor .'%" or 
                periodos.periodo LIKE "%'. $valor .'%" or 
                matriculas.fecha LIKE "%'. $valor .'%"
        ');
        $matriculas = $this->respuesta = $this->bd->obtener_datos();
        foreach ($matriculas as $key => $value) {
            $datos[] = [
                'idMatricula' => $value['idMatricula'],
                'alumno'      => [
                    'id'      => $value['idAlumno'],
                    'label'   => $value['nombre']
                ],
                'periodo'      => [
                    'id'      => $value['idPeriodo'],
                    'label'   => $value['periodo']
                ],
                'fecha'       => $value['f'],
                'f'           => $value['fecha']

            ]; 
        }
        return $this->respuesta = $datos;
    }
    public function traer_periodos_alumnos(){
        $this->bd->consultas('
            SELECT periodos.periodo AS label, periodos.idPeriodo AS id
            FROM periodos
        ');
        $periodos = $this->bd->obtener_datos();
        $this->bd->consultas('
            SELECT alumnos.nombre AS label, alumnos.idAlumno AS id
            FROM alumnos
        ');
        $alumnos = $this->bd->obtener_datos();
        return $this->respuesta = ['periodos'=>$periodos, 'alumnos'=>$alumnos ];//array de php en v7+
    }

    public function eliminarMatricula($idMatricula = 0){
        $this->bd->consultas('
            DELETE matriculas
            FROM matriculas
            WHERE matriculas.idMatricula="'.$idMatricula.'"
        ');
        return $this->respuesta['msg'] = 'Registro eliminado correctamente';;
    }
}

?>