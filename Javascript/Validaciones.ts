
    
    function AdministrarValidacionesLogin()
    {
        let camposLogin = Array("txtApellido", "txtDni");
        for (var index = 0; index < camposLogin.length; index++) {
            AdministrarSpanError(camposLogin[index],(ValidarCamposVacios(camposLogin[index])));            
        }
        AdministrarSpanError(camposLogin[1],ValidarRangoNumerico(parseInt((<HTMLInputElement>document.getElementById(camposLogin[1])).value),1000000,55000000));

        if(VerificarValidaciones())
        {
            let form = <HTMLFormElement>document.getElementById('login');
            form.submit();
        }
    }    

    function AdministrarValidaciones( )
    {
        let campos= Array("txtNombre","txtApellido","txtDni","txtLegajo","txtSueldo","imgFoto");
        for (let index = 0; index < campos.length; index++) {
            AdministrarSpanError(campos[index],ValidarCamposVacios(campos[index]));        
        }
        AdministrarSpanError(campos[2],(ValidarRangoNumerico(parseInt((<HTMLInputElement>document.getElementById(campos[2])).value),1000000,55000000)));
        AdministrarSpanError(campos[3],(ValidarRangoNumerico(parseInt((<HTMLInputElement>document.getElementById(campos[3])).value),100,550)));
        AdministrarSpanError("cboSexo",ValidarCombo("cboSexo","--"));
        let radio=ObtenerTurnoSeleccionado();
        let sueldo : number =parseInt((<HTMLInputElement>document.getElementById(campos[4])).value);
        AdministrarSpanError(campos[4],(ValidarRangoNumerico(sueldo,8000,ObtenerSueldoMaximo(radio))));

        if(VerificarValidacionesAlta())
        {
            /*let accion = ((<HTMLInputElement>document.getElementById("hdnModificar")).value);
            let post = Array();
            campos.forEach(function(item){
                post.push(((<HTMLInputElement>document.getElementById(item)).value));
            });*/
            let frm = document.forms.namedItem("form");
            let data = new FormData(<HTMLFormElement>frm);
            let imgFoto= <HTMLInputElement>document.getElementById("imgFoto");
            data.append("imgfoto",imgFoto.files[0]);
            
            main.AccionAgregar(data);
        }
    }
    function AdministrarModificar(dni : number)
    {
        if(dni!=null)
        {
            main.AccionAdministracion(((<HTMLInputElement>document.getElementById("btnModificar")).value),dni.toString());
        }
    }
    function ValidarCamposVacios(id : string): boolean
    {
        if((<HTMLInputElement> document.getElementById(id)).value)
        {
            return true;
        }
        return false;
    }
    function ValidarRangoNumerico(num:number,min:number,max:number):boolean
    {
        if(num<=max&&num>=min)
        {
            return true;
        }

        return false;
    }
    function ValidarCombo(id : string, valor : string):boolean
    {
        if((<HTMLInputElement> document.getElementById(id)).value!= valor)
        {
            return true;
        }
        return false;
    }
    function ObtenerTurnoSeleccionado():string
    {
        let radio : HTMLCollectionOf<HTMLInputElement> = <HTMLCollectionOf<HTMLInputElement>><unknown> document.getElementsByName("rdoTurno");
        let seleccionados : string = "";
        for (let i = 0; i < radio.length; i++) {
            if (radio[i].checked===true) {
                seleccionados+=radio[i].id;
            }    
        }
        return seleccionados;
    }
    function ObtenerSueldoMaximo(turno : string) : number
    {
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
    function VerificarValidaciones(): boolean
    {
        let span = Array(document.getElementById("txtApellidoError"),document.getElementById("txtDniError")) ;
        let flag = true;
        span.forEach(function(item) {
            if(item?.style.display!="none")
            {
                flag = false;
            }
        });
        return flag;
    }

    function AdministrarSpanError(id:string,flag:boolean): void
    {
        let span = document.getElementById(id+"Error");
        if(flag)
        {
            span?.style.setProperty("display","none");
        }else
        {
            span?.style.setProperty("display","block");
        }
    }   
    function VerificarValidacionesAlta(): boolean
    {        
        let flag = true;
        let span = Array(document.getElementById("txtApellidoError"),document.getElementById("txtDniError"),document.getElementById("txtNombreError"),document.getElementById("cboSexoError"),document.getElementById("txtLegajoError"),document.getElementById("txtSueldoError"),document.getElementById("imgFotoError"));
        /*span.forEach(function(item) {
            if(item?.style.display!="none")
            {
                flag = false;
            }    
        });*/

        for (let index = 0; index < span.length; index++) {
            if(span[index]?.style.display!="none")
            {
                flag = false;
            }  
        }
        return flag;
    }
