/// <reference path="ajax.ts"/> 
/// <reference path="Validaciones.ts"/> 

window.onload = ():void => {
    main.AccionAdministracion();
}; 

namespace main
{
    let ajax: Ajax = new Ajax();
    export function AccionAdministracion(accion?: string, aux?: string):void
    {
        let parametro;
        switch (accion) {
            case 'Modificar':
                parametro= `accion=${accion}&hideDni=${aux}`;
                ajax.Post("./backend/formEmpleado.php",MostrarFormModificar,parametro,Error);
                break;
            case 'Alta':
                parametro= 'accion='+accion;
                ajax.Post("./backend/formEmpleado.php",MostrarFormAgregar,parametro,Error);
                break;
            case 'Eliminar':
                parametro= `legajo=${aux}`;
                ajax.Get("./backend/eliminar.php",ExitoEliminar,parametro,Error);
                break;
            default:
                ajax.Post("./backend/mostrarEmpleados.php",Listado,"",Error);
                break;
        }
    }

    function Listado(retorno : string)
    {
        (<HTMLDivElement>document.getElementById("index")).innerHTML = "Mostrar";
        (<HTMLDivElement>document.getElementById("Titulo")).innerHTML = "<tr><td><h2>Listado de Empleados</h2></td></tr>";
        (<HTMLDivElement>document.getElementById("Mostrar")).innerHTML = '<form method="POST" action="./backend/EmpleadoPDF.php">'+retorno+'</form>';
        (<HTMLDivElement>document.getElementById("Opcion")).innerHTML = '<tr><td><h2><p onclick=main.AccionAdministracion("Alta")>Agregar empleado</p></h2></td></tr>';
    }

    function MostrarFormAgregar(retorno : string)
    {
        (<HTMLDivElement>document.getElementById("index")).innerHTML = "Agregar";
        (<HTMLDivElement>document.getElementById("Titulo")).innerHTML = "<tr><td><h2>Alta Empleados</h2></td></tr>";
        (<HTMLDivElement>document.getElementById("Mostrar")).innerHTML = retorno;
        (<HTMLDivElement>document.getElementById("Opcion")).innerHTML = '<h2><p onclick="main.AccionAdministracion()">Volver a listado</p></h2>';
    }
    function MostrarFormModificar(retorno : string)
    {
        (<HTMLDivElement>document.getElementById("index")).innerHTML = "Modificar";
        (<HTMLDivElement>document.getElementById("Titulo")).innerHTML = "<tr><td><h2>Modificar empleado</h2></td></tr>";
        (<HTMLDivElement>document.getElementById("Mostrar")).innerHTML = retorno;
        (<HTMLDivElement>document.getElementById("Opcion")).innerHTML = '<h2><p onclick="main.AccionAdministracion()">Volver a listado</p></h2>';
    }
    export function AccionAgregar(form:FormData)
    {    
        ajax.Post("./backend/administracion.php",AccionAdministracion,form,Error);
    }
    function ExitoEliminar(retorno : string)
    {
        alert(retorno);
        AccionAdministracion();
    }

    
    function Error(retorno : string)
    {
        alert(retorno);
    }
}