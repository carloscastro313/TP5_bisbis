<?php
    require_once("../Clases/Fabrica.php");
    $archivo=array();
    $ar = fopen("../Archivos/empleados.txt","r");
    $index = 0;
    $src = "";      
    $lista = '<table align="center">
    <tr>
        <td>
            <h4>Info</h4>
        </td>
        <td><input type="submit" id="btnPDF" value="Exportar a PDF"></td>
    </tr>
    <tr>
        <td colspan="2"><hr/></td>
    </tr>';
    if($ar!=null)
    {
        while(!feof($ar))
        {
            $listado = fgets($ar);
            $archivo = explode(" - ",$listado);
            $archivo[0] = trim($archivo[0]);
            if($archivo[0] != "")
            {
                $aux=new Empleado($archivo[0],$archivo[1],$archivo[2],$archivo[3],$archivo[4],$archivo[5],$archivo[6]) ;
                $aux->SetPathFoto($archivo[7]);
                $src=$aux->GetPathFoto();
                $lista .= "<tr>
                        <td>"
                        .$aux->ToString()."<pre style='display:inline'>&#09;</pre>"."<img src=".$src." align='middle' style='width:90px;height:90px;'>".'<p onclick=main.AccionAdministracion("Eliminar",'.$aux->GetLegajo().')>Eliminar</p>
                        </td>
                        <td>
                            <input type="button" id="btnModificar" onclick="AdministrarModificar('.$aux->GetDni().')" value="Modificar">
                        </td>
                    </tr>';
                $index++;
            }                       
        }
    } 
    $lista .= '<tr>
        <td colspan="2"><hr/></td>
    </tr>
    </table>';
    echo $lista;         
    fclose($ar);
?>