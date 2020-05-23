<?php
    require_once '../vendor/autoload.php';
    require_once("../Clases/Fabrica.php");
    use Mpdf\Mpdf;
    header('content-type:application/pdf');

    $mpdf = new Mpdf(['orientation' => 'P', 
                        'pagenumPrefix' => 'Página nro. ',
                        'pagenumSuffix' => ' - ',
                        'nbpgPrefix' => ' de ',
                        'nbpgSuffix' => ' páginas']);


    $mpdf->SetHeader('{DATE j-m-Y}|Carlos Castro|{PAGENO}{nbpg}');
    $mpdf->setFooter('{DATE Y}|TP5 BIS BIS|{PAGENO}');
    $lista = '<table class="table" border="1" align="center">
                <thead>
                    <tr>
                        <th>  Nombre </th>
                        <th>  Apellido     </th>
                        <th>  DNI       </th>
                        <th>  Sexo </th>
                        <th>  Legajo     </th>
                        <th>  Sueldo       </th>
                        <th>  Turno </th>
                        <th>  Foto </th>
                    </tr> 
                </thead>'; 


    $archivo=array();
    $ar = fopen("../Archivos/empleados.txt","r");
    $index = 0;      
    if($ar!=null)
    {
        while(!feof($ar))
        {
            $listado = trim(fgets($ar));
            $archivo = explode(" - ",$listado);
            if($archivo[0] != "")
            {
                $aux=new Empleado($archivo[0],$archivo[1],$archivo[2],$archivo[3],$archivo[4],$archivo[5],$archivo[6]) ;
                $aux->SetPathFoto($archivo[7]);
                $lista .= "<tr>
                                <td>".$aux->GetNombre()."</td>
                                <td>".$aux->GetApellido()."</td>
                                <td>".$aux->GetDni()."</td>
                                <td>".$aux->GetSexo()."</td>
                                <td>".$aux->GetLegajo()."</td>
                                <td>".$aux->GetSueldo()."</td>
                                <td>".$aux->GetTurno()."</td>
                                <td><img src='.".$aux->GetPathFoto()."' width='100px' height='100px'/></td>
                            </tr>";
                $index++;
            }                       
        }
    } 
    $lista .='</table>';
    $mpdf->WriteHTML("<h3>Listado de productos</h3>");
    $mpdf->WriteHTML("<br>");
    $mpdf->WriteHTML($lista);
    $mpdf->Output();
