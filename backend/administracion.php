<?php
    require("../Clases/Fabrica.php");
    $empleado = new Empleado($_POST["txtNombre"],$_POST["txtApellido"],$_POST["txtDni"],$_POST["cboSexo"],$_POST["txtLegajo"],$_POST["txtSueldo"],$_POST["rdoTurno"]);
    $extend = explode(".",$_FILES["imgFoto"]["name"]);
    $destino = "./fotos/".$empleado->GetDni()."-".$empleado->GetApellido().'.'.$extend[1];
    $fabrica = new Fabrica("Sociedad anonima",7);
    $flag = false;
    $fabrica->TraerDeArchivo("../Archivos/empleados.txt");
    
    if($_POST["hdnModificar"]=="Alta")
    { 
        if(validarFotos($destino,$extend))
        {
            $empleado->SetPathFoto($destino);
            if($fabrica->AgregarEmpleado($empleado))
            {
                $fabrica->GuardarEnArchivo("empleados.txt");
                $flag = true;
            }
        }    
    }else {
        $empleados =$fabrica->GetEmpleados();
        foreach ($empleados as $key) {
            if($key->GetLegajo()==$_POST["txtLegajo"])
            {
                if($fabrica->EliminarEmpleado($key))
                {
                    if(validarFotos($destino,$extend))
                    {
                        $empleado->SetPathFoto($destino);
                        if($fabrica->AgregarEmpleado($empleado))
                        $fabrica->GuardarEnArchivo("empleados.txt");
                        $flag = true;
                    break;
                    }
                }
            }
        }

    }

    /*if($flag)
    {
        header("Location: mostrar.php");
    }else
    {
        echo "No se pudo guardar empleado";
        echo '<h2><a href="mostrar.php>Volver al formulario</a></h2>';
    }
    */
    function validarFotos($archivo,$tipoArchivo) : bool
    {
        $archivo=".".$archivo;
        if(getimagesize($_FILES["imgFoto"]["tmp_name"])===false)
        {
            return false;
        }
        if(file_exists($archivo))
        {
            return false;
        }
        if(!($tipoArchivo!="jpg"&&$tipoArchivo!="gif"&&$tipoArchivo!="bmp"&&$tipoArchivo!="png"&&$tipoArchivo!="jpeg"))
        {
            return false;
        }
        if(($_FILES["imgFoto"]["size"])<1024)
        {
            return false;
        }
        
        if(!move_uploaded_file($_FILES["imgFoto"]["tmp_name"],$archivo))
        {
            return false; 
        }
        return true;
    }