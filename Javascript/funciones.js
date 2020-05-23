function AdministrarValidacionesLogin() {
    var camposLogin = Array("txtApellido", "txtDni");
    for (var index = 0; index < camposLogin.length; index++) {
        AdministrarSpanError(camposLogin[index], (ValidarCamposVacios(camposLogin[index])));
    }
    AdministrarSpanError(camposLogin[1], ValidarRangoNumerico(parseInt(document.getElementById(camposLogin[1]).value), 1000000, 55000000));
    if (VerificarValidaciones()) {
        var form = document.getElementById('login');
        form.submit();
    }
}
function AdministrarValidaciones() {
    var campos = Array("txtNombre", "txtApellido", "txtDni", "txtLegajo", "txtSueldo", "imgFoto");
    for (var index = 0; index < campos.length; index++) {
        AdministrarSpanError(campos[index], ValidarCamposVacios(campos[index]));
    }
    AdministrarSpanError(campos[2], (ValidarRangoNumerico(parseInt(document.getElementById(campos[2]).value), 1000000, 55000000)));
    AdministrarSpanError(campos[3], (ValidarRangoNumerico(parseInt(document.getElementById(campos[3]).value), 100, 550)));
    AdministrarSpanError("cboSexo", ValidarCombo("cboSexo", "--"));
    var radio = ObtenerTurnoSeleccionado();
    var sueldo = parseInt(document.getElementById(campos[4]).value);
    AdministrarSpanError(campos[4], (ValidarRangoNumerico(sueldo, 8000, ObtenerSueldoMaximo(radio))));
    if (VerificarValidacionesAlta()) {
        /*let accion = ((<HTMLInputElement>document.getElementById("hdnModificar")).value);
        let post = Array();
        campos.forEach(function(item){
            post.push(((<HTMLInputElement>document.getElementById(item)).value));
        });*/
        var frm = document.forms.namedItem("form");
        var data = new FormData(frm);
        var imgFoto = document.getElementById("imgFoto");
        data.append("imgfoto", imgFoto.files[0]);
        main.AccionAgregar(data);
    }
}
function AdministrarModificar(dni) {
    if (dni != null) {
        main.AccionAdministracion((document.getElementById("btnModificar").value), dni.toString());
    }
}
function ValidarCamposVacios(id) {
    if (document.getElementById(id).value) {
        return true;
    }
    return false;
}
function ValidarRangoNumerico(num, min, max) {
    if (num <= max && num >= min) {
        return true;
    }
    return false;
}
function ValidarCombo(id, valor) {
    if (document.getElementById(id).value != valor) {
        return true;
    }
    return false;
}
function ObtenerTurnoSeleccionado() {
    var radio = document.getElementsByName("rdoTurno");
    var seleccionados = "";
    for (var i = 0; i < radio.length; i++) {
        if (radio[i].checked === true) {
            seleccionados += radio[i].id;
        }
    }
    return seleccionados;
}
function ObtenerSueldoMaximo(turno) {
    switch (turno) {
        case "Mañana":
            return 20000;
            break;
        case "Tarde":
            return 18500;
            break;
        case "Noche":
            return 25000;
            break;
        default:
            break;
    }
    return 0;
}
function VerificarValidaciones() {
    var span = Array(document.getElementById("txtApellidoError"), document.getElementById("txtDniError"));
    var flag = true;
    span.forEach(function (item) {
        if ((item === null || item === void 0 ? void 0 : item.style.display) != "none") {
            flag = false;
        }
    });
    return flag;
}
function AdministrarSpanError(id, flag) {
    var span = document.getElementById(id + "Error");
    if (flag) {
        span === null || span === void 0 ? void 0 : span.style.setProperty("display", "none");
    }
    else {
        span === null || span === void 0 ? void 0 : span.style.setProperty("display", "block");
    }
}
function VerificarValidacionesAlta() {
    var _a;
    var flag = true;
    var span = Array(document.getElementById("txtApellidoError"), document.getElementById("txtDniError"), document.getElementById("txtNombreError"), document.getElementById("cboSexoError"), document.getElementById("txtLegajoError"), document.getElementById("txtSueldoError"), document.getElementById("imgFotoError"));
    /*span.forEach(function(item) {
        if(item?.style.display!="none")
        {
            flag = false;
        }
    });*/
    for (var index = 0; index < span.length; index++) {
        if (((_a = span[index]) === null || _a === void 0 ? void 0 : _a.style.display) != "none") {
            flag = false;
        }
    }
    return flag;
}
var Ajax = /** @class */ (function () {
    function Ajax() {
        var _this = this;
        this.Get = function (ruta, success, params, error) {
            if (params === void 0) { params = " "; }
            var parametros = params.length > 0 ? params : "";
            ruta = params.length > 0 ? ruta + "?" + parametros : ruta;
            _this._xhr.open('GET', ruta);
            _this._xhr.send();
            _this._xhr.onreadystatechange = function () {
                if (_this._xhr.readyState === Ajax.DONE) {
                    if (_this._xhr.status === Ajax.OK) {
                        success(_this._xhr.responseText);
                    }
                    else {
                        if (error !== undefined) {
                            error(_this._xhr.status);
                        }
                    }
                }
            };
        };
        this.Post = function (ruta, success, params, error) {
            if (params === void 0) { params = ""; }
            var parametros;
            _this._xhr.open('POST', ruta, true);
            if (typeof (params) == 'string') {
                parametros = (params.length > 0) ? params : "";
                _this._xhr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
            }
            else {
                parametros = params;
            }
            _this._xhr.send(params);
            _this._xhr.onreadystatechange = function () {
                if (_this._xhr.readyState === Ajax.DONE) {
                    if (_this._xhr.status === Ajax.OK) {
                        success(_this._xhr.responseText);
                    }
                    else {
                        if (error !== undefined) {
                            error(_this._xhr.responseText);
                        }
                    }
                }
            };
        };
        this._xhr = new XMLHttpRequest();
        Ajax.DONE = 4;
        Ajax.OK = 200;
    }
    return Ajax;
}());
/// <reference path="ajax.ts"/> 
/// <reference path="Validaciones.ts"/> 
window.onload = function () {
    main.AccionAdministracion();
};
var main;
(function (main) {
    var ajax = new Ajax();
    function AccionAdministracion(accion, aux) {
        var parametro;
        switch (accion) {
            case 'Modificar':
                parametro = "accion=" + accion + "&hideDni=" + aux;
                ajax.Post("./backend/formEmpleado.php", MostrarFormModificar, parametro, Error);
                break;
            case 'Alta':
                parametro = 'accion=' + accion;
                ajax.Post("./backend/formEmpleado.php", MostrarFormAgregar, parametro, Error);
                break;
            case 'Eliminar':
                parametro = "legajo=" + aux;
                ajax.Get("./backend/eliminar.php", ExitoEliminar, parametro, Error);
                break;
            default:
                ajax.Post("./backend/mostrarEmpleados.php", Listado, "", Error);
                break;
        }
    }
    main.AccionAdministracion = AccionAdministracion;
    function Listado(retorno) {
        document.getElementById("index").innerHTML = "Mostrar";
        document.getElementById("Titulo").innerHTML = "<tr><td><h2>Listado de Empleados</h2></td></tr>";
        document.getElementById("Mostrar").innerHTML = '<form method="POST" action="./backend/EmpleadoPDF.php">' + retorno + '</form>';
        document.getElementById("Opcion").innerHTML = '<tr><td><h2><p onclick=main.AccionAdministracion("Alta")>Agregar empleado</p></h2></td></tr>';
    }
    function MostrarFormAgregar(retorno) {
        document.getElementById("index").innerHTML = "Agregar";
        document.getElementById("Titulo").innerHTML = "<tr><td><h2>Alta Empleados</h2></td></tr>";
        document.getElementById("Mostrar").innerHTML = retorno;
        document.getElementById("Opcion").innerHTML = '<h2><p onclick="main.AccionAdministracion()">Volver a listado</p></h2>';
    }
    function MostrarFormModificar(retorno) {
        document.getElementById("index").innerHTML = "Modificar";
        document.getElementById("Titulo").innerHTML = "<tr><td><h2>Modificar empleado</h2></td></tr>";
        document.getElementById("Mostrar").innerHTML = retorno;
        document.getElementById("Opcion").innerHTML = '<h2><p onclick="main.AccionAdministracion()">Volver a listado</p></h2>';
    }
    function AccionAgregar(form) {
        ajax.Post("./backend/administracion.php", AccionAdministracion, form, Error);
    }
    main.AccionAgregar = AccionAgregar;
    function ExitoEliminar(retorno) {
        alert(retorno);
        AccionAdministracion();
    }
    function Error(retorno) {
        alert(retorno);
    }
})(main || (main = {}));
