<?php
    unset($emp);
    if(isset($_POST["hideDni"]))
    {
        require("../Clases/Fabrica.php");
        $fabrica = new Fabrica("Sociedad anonima",7);
        $flag = false;
        $fabrica->TraerDeArchivo("../Archivos/empleados.txt");
        foreach ($fabrica->GetEmpleados() as $key => $value) {
            if($value->GetDni()==$_POST["hideDni"])
            {
                $emp = $value;
                $flag = true;
            break;
            }
        }
    }

    echo '
    <form name="form" enctype="text/plain">
        <table align="center"><tr>
                <td colspan="2"><h4>Datos Personales</h4></td>
            </tr>
            <tr>
                <td colspan="2"><hr/></td>
            </tr>
            <tr>
                <td>DNI:</td>
                <input type="hidden" id="hdnModificar" name="hdnModificar" value='.$_POST["accion"].'>
                <td style="text-align:left;padding-left:20px"> 
                    <input type="number" name="txtDni" id="txtDni" min="1000000" max="55000000" value="'.((isset($emp))?$emp->GetDni():"").'"'.((isset($emp))?"readonly":"").'>
                    <span id="txtDniError" style="display: none;">*</span>
                </td>
            </tr>
            <tr>
                <td>Apellido:</td>
                <td style="text-align:left;padding-left:20px"> 
                    <input type="text" name="txtApellido" id="txtApellido" value='.((isset($emp))?$emp->GetApellido():"").'>
                    <span id="txtApellidoError" style="display: none;">*</span>
                </td>
            </tr>
            <tr>
                <td>Nombre:</td>
                <td style="text-align:left;padding-left:20px"> 
                    <input type="text" name="txtNombre" id="txtNombre"value= '.((isset($emp))?$emp->GetNombre():"").'>
                    <span id="txtNombreError" style="display: none;">*</span>
                </td>
            </tr>
            <tr>
                <td>Sexo:</td>
                <td style="text-align:left;padding-left:20px"> 
                    <select name="cboSexo"id="cboSexo" name="Seleccion">
                        <option value="--" '.((!isset($emp))?"selected":"").'>Seleccione</option>
                        <option value="M" '.((isset($emp)&&$emp->GetSexo()=="M")?"selected":"").'>Masculino</option>
                        <option value="F" '.((isset($emp)&&$emp->GetSexo()=="F")?"selected":"").'>Femenino</option>
                    </select>
                    <span id="cboSexoError" style="display: none;">*</span>
                </td>
            </tr>
            <tr>
                <td colspan="2"><h4>Datos Laborales</h4></td>
            </tr>
            <tr>
                <td colspan="2"><hr/></td>
            </tr>
            <tr>
                <td>Legajo:</td>
                <td style="text-align:left;padding-left:20px"> 
                    <input type="number" name="txtLegajo" id="txtLegajo" min="100" max="550" value="'.((isset($emp))?$emp->GetLegajo():"").'"'.((isset($emp))?"readonly":"").'>
                    <span id="txtLegajoError" style="display: none;">*</span>
                </td>
            </tr>
            <tr>
                <td>Sueldo:</td>
                <td style="text-align:left;padding-left:20px"> 
                    <input type="number" name="txtSueldo" id="txtSueldo" min="8000" value='.((isset($emp))?$emp->GetSueldo():"").'>
                    <span id="txtSueldoError" style="display: none;">*</span>
                </td>
            </tr>
            <tr>
                <td>Turno:</td>    
            </tr>
            <tr>
                <td style="text-align:left;padding-left:20px">
                    <input type="radio" id="Mañana" name="rdoTurno" value="Mañana" '.((!isset($emp))?"checked":($emp->GetTurno()=="Mañana")?"checked":"").'>
                </td>
                <td>Mañana</td>
            </tr>
            <tr>
                <td style="text-align:left;padding-left:20px">
                    <input type="radio" id="Tarde" name="rdoTurno" value="Tarde" '.((isset($emp)&&($emp->GetTurno()=="Tarde"))?"checked":"").'>
                </td>
                <td>Tarde</td>
            </tr>
            <tr>
                <td style="text-align:left;padding-left:20px">
                    <input type="radio" id="Noche" name="rdoTurno" value="Noche" '.((isset($emp))&&($emp->GetTurno()=="Noche")?"checked":"").'>
                </td>
                <td>Noche</td>
            </tr>
            <tr>
                <td>Foto: </td>
                <td>
                    <input type="file" id="imgFoto" name="imgFoto" value='.((isset($emp))?$emp->GetPathFoto():"").' >
                    <span id="imgFotoError" style="display: none;">*</span>
                </td>
            </tr>
            <tr>
                <td colspan="2"><hr/></td>
            </tr>
            <tr>
                <td colspan="2" align="right">
                    <input type="reset" value="Limpiar">
                </td>
            </tr>
            <tr>
                <td colspan="2" align="right">
                    <input type="button" id="Enviar" value='.((isset($emp))?"Modificar":"Enviar"). ' onclick="AdministrarValidaciones()">
                </td>
            </tr>
        </table>
        </form>';
?>
    

