<?php
    require_once("../Clases/Fabrica.php");
    $legajo = $_GET['legajo'];
    $empleados = array();
    $archivo = array();
    $ar = fopen("../Archivos/empleados.txt","r");
    $flag = false;

    while(!feof($ar))
    {
        $listado = fgets($ar);
        $archivo = explode(" - ",$listado);
        $archivo[0] = trim($archivo[0]);
        if($archivo[0] != ""&&$archivo[4]==$legajo)
        {   
            $flag=true;
            $empleado = new Empleado($archivo[0],$archivo[1],$archivo[2],$archivo[3],$archivo[4],$archivo[5],$archivo[6]);
            $fabrica = new Fabrica("Sociedad anonima",7);
            $fabrica->TraerDeArchivo("../Archivos/empleados.txt",);
            if($fabrica->EliminarEmpleado($empleado))
            {
                $fabrica->GuardarEnArchivo("empleados.txt");
                echo " Se elimino al empleado".$empleado->ToString();
                break;
            }else{
                echo "No se puedo eliminar";
            }
        }          
    }
    if(!$flag)
    {
        echo "No se puedo encontrar empleado";
    }

    fclose($ar);
?>