<?php
require_once "persona.php";

class Empleado extends Persona
{
    protected $_pathFoto;
    protected $_legajo;
    protected $_sueldo;
    protected $_turno;
    
    public function __construct($nombre,$apellido,$dni,$sexo,$legajo,$sueldo,$turno)
    {
        parent::__construct($nombre,$apellido,$dni,$sexo);
        $this->_legajo = $legajo;
        $this->_sueldo = $sueldo;
        $this->_turno = $turno;
    }

    public function GetLegajo()
    {
        return $this->_legajo;
    }

    public function GetSueldo()
    {
        return $this->_sueldo;
    }

    public function GetTurno()
    {
        return $this->_turno;
    }
    public function GetPathFoto()
    {
        return $this->_pathFoto;
    }
    public function SetPathFoto($foto)
    {
        $this->_pathFoto = $foto;
    }
    public function Hablar($idioma = array())
    {
        $aux = " ";
        foreach ($idioma as $key ) {
            $aux = $aux." ".$key;
        }
        return "El Empleado habla ".$aux;
    }

    public function ToString()
    {
        return parent::ToString()." - ".$this->_legajo." - ".$this->_sueldo." - ". $this->_turno." - ".$this->_pathFoto;
    }
}
