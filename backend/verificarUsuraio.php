<?php
$dni = $_POST["Dni"];
$apellido = $_POST["Apellido"];
$flag = false;
$ar = fopen("../Archivos/empleados.txt","r");

if($ar!=null)
{
    while(!feof($ar))
    {
        $listado = fgets($ar);
        $archivo = explode(" - ",$listado);
        $archivo[1] = trim($archivo[1]);
        $archivo[2] = trim($archivo[2]);
        if($archivo[2] == $dni && $archivo[1] == $apellido)
        {
            $flag = true;
            break;
        } 
    }
}

if($flag)
{
    session_start();
    $_SESSION["DNIEmpleado"] = $dni;
    header("Location: ../index.php");
}else
{
    echo '<h3>No existe empleado</h3></br><h2><a href="../login.html">Volver al index</a></h2>';
}