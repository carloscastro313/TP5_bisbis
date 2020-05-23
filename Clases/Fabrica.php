<?php
require_once "Empleado.php";
require_once "interfaces.php";

class Fabrica implements IArchivo
{
    private $_cantidadMaxima;
    private $_empleados;
    private $_razon;

    public function __construct($razonSocial,$cantidadMaxima=5)
    {
        $this->_empleados = array();
        $this->_cantidadMaxima = $cantidadMaxima;
        $this->_razon = $razonSocial;
    }
    public function GetEmpleados()
    {
        return $this->_empleados;
    }
    public function AgregarEmpleado($emp)
    {
        if($emp != null&& count($this->_empleados) < $this->_cantidadMaxima)
        {
            array_push($this->_empleados,$emp);
            $this->EliminarEmpleadosRepetidos();
            return true;
        }
        return false;
    }

    public function CalcularSueldo()
    {
        $SueldoTotal=0;
        foreach ($this->_empleados as $key) {
            $SueldoTotal+=$key->GetSueldo();
        }

        return "El total de los sueldos: ".$SueldoTotal;
    }

    public function EliminarEmpleado($emp)
    {
        if($emp != null)
        {    
            $index =array_search($emp,$this->_empleados,false);
            $path = ".".$this->_empleados[$index]->GetPathFoto();
            $path = trim($path);
            if(file_exists($path))
            {
                unlink($path);  
            }           
            unset($this->_empleados[$index]);
            return true;
        }
        return false;
    }
    
    private function EliminarEmpleadosRepetidos()
    {
        $this->_empleados = array_unique($this->_empleados,SORT_REGULAR);
    }

    public function ToString()
    {
        $datos= "Razon Social= ".$this->_razon."<br/>";
        foreach ($this->_empleados as $key) {
            $datos=$datos. $key->ToString()."<br/>";
        }

        return $datos;
    }
    function TraerDeArchivo($nombreArchivo)
    {     
        $archivo = array();
        $index = 0;
        $ar = fopen($nombreArchivo,"r");
        if($ar!=null)
        {
            while(!feof($ar))
            {
                $listado = fgets($ar);
                $archivo = explode(" - ",$listado);
                $archivo[0] = trim($archivo[0]);
                if($archivo[0] != "")
                {
                    $this->AgregarEmpleado(new Empleado($archivo[0],$archivo[1],$archivo[2],$archivo[3],$archivo[4],$archivo[5],$archivo[6]));
                    $this->_empleados[$index]->SetPathFoto($archivo[7]);
                    $index++;
                }              
            }
            fclose($ar);
        }        
    }
    function GuardarEnArchivo($nombreArchivo)
    {
        $ar = fopen("../Archivos/".$nombreArchivo,"w");
        foreach ($this->_empleados as $empleado) {
            fwrite($ar,$empleado->ToString()."\r\n");
        }
        /*for ($i=0; $i <$this->_empleados->count; $i++) { 
            fwrite($ar,$this->_empleados[$i]->ToString()."\r\n");
        }*/
        fclose($ar);
    }
}