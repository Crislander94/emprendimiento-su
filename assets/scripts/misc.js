// Validación de solo numeros
function ValidaSoloNumeros() {
    if ((event.keyCode < 48) || (event.keyCode > 57))
        event.returnValue = false;
}

// Validación de solo Letras
function ValidaSoloLetras() {
    if ((event.keyCode != 32) && (event.keyCode < 65) || (event.keyCode > 90) && (event.keyCode < 97) || (event.keyCode > 122))
        event.returnValue = false;
}

// verificar Correo
function revisar_correo(str) {
    var filter = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    if (filter.test(str)) {
        return true;
    } else {
        return false;
    }
}

function redireccionar(ruta){window.location.href = ruta;}


function EliminarRegistro(ruta){
    Swal.fire({
        title: "Estas Seguro?",
        text: "Si eliminas estos registros desapareceran de la lista!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminarlo!',
        cancelButtonText: 'No, cancelar!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            window.location = ruta;
        } else if (
            result.dismiss === swal.DismissReason.cancel
        ) {
            Swal.fire('Cancelado, no se realizo ningun cambio!');
        }
    })
}

function regresar(ruta) {
    Swal.fire({
        title: "Estas Seguro?",
        text: "Esta Seguro de Regresar, si no has grabado se borrara la información",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            window.location = ruta;
        } else if (
            result.dismiss === swal.DismissReason.cancel
        ) {
            Swal.fire('Continuemos!', ':)', 'success');
        }
    });
}

function decimalNumbers(e, field) {
    key = e.keyCode ? e.keyCode : e.which
    // backspace
    if (key == 8) return true
 
    // 0-9 a partir del .decimal  
    if (field.value != "") {
        if ((field.value.indexOf(".")) > 0) {
            //si tiene un punto valida dos digitos en la parte decimal
            if (key > 47 && key < 58) {
                if (field.value == "") return true
                //regexp = /[0-9]{1,10}[\.][0-9]{1,3}$/
                regexp = /[0-9]{2}$/
                return !(regexp.test(field.value))
            }
        }
    }
    // 0-9 
    if (key > 47 && key < 58) {
        if (field.value == "") return true
        regexp = /[0-9]{10}/
        return !(regexp.test(field.value))
    }
    // .
    if (key == 46) {
        if (field.value == "") return false
        regexp = /^[0-9]+$/
        return regexp.test(field.value)
    }
    // other key
    return false
}

function getPathOrigin(){
    return window.location.origin +'/proyecto-emprendimiento-main/';
}

const getTotal = () => {
    return new Promise(resolve => {
        const request = new XMLHttpRequest();
        const form = new FormData();
        form.append('key','getTotal');
        request.open('POST',  getPathOrigin()+'endpoints/carrito.php');
        request.onreadystatechange = () => {
            if(request.readyState === 4 && request.status === 200){
                const response = JSON.parse(request.responseText);
                const {codigo} = response;
                switch (parseInt(codigo)) {
                    case 200:
                        const {total} = response;
                        const total_cabecera = document.getElementById('precio_carrito_cabecera');
                        if(
                            total_cabecera !== null
                        ){
                            total_cabecera.innerHTML = total;
                            resolve(total);
                        }
                        break;
                    case -1:
                        resolve('0.00');
                        break;
                    case -2:
                        console.log('Necesitas iniciar sesion como cliente para hacer esta accion');
                        resolve('0.00');
                        break;
                        case -3:
                            console.log('Solo usuarios clientes pueden calcular el total de su pedido');
                            resolve('0.00');
                        break;
                    default:
                        console.log('Error en el webservices');
                        resolve('0.00');
                        break;
                }
            }
        }
        request.send(form);
    });
}

const getTotalItem = () => {
    return new Promise(resolve => {
        const request = new XMLHttpRequest();
        const form = new FormData();
        form.append('key','getTotalitems');
        request.open('POST',  getPathOrigin()+'endpoints/carrito.php');
        request.onreadystatechange = () => {
            if(request.readyState === 4 && request.status === 200){
                const response = JSON.parse(request.responseText);
                const {codigo} = response;
                switch (parseInt(codigo)){
                    case 200:
                        const {cantidad} = response;
                        const cantidad_cabecera = document.getElementById('cantidad_productos_cabecera');
                        if(
                            cantidad !== null
                        ){
                            cantidad_cabecera.innerHTML = cantidad;
                            resolve(cantidad);
                        }else{
                            cantidad_cabecera.innerHTML = 0;
                            resolve(0);
                        }
                        break;
                    case -1:
                        console.log(response);
                        resolve(0);
                    case -2:
                        console.log('Necesitas iniciar sesion como cliente para hacer esta accion');
                        resolve(0);
                        break;
                        case -3:
                            console.log('Solo usuarios clientes pueden calcular el total de su pedido');
                            resolve(0);
                        break;
                    default:
                        console.log('Error en el webservices');
                        resolve(0);
                        break;
                }
            }
        }
        request.send(form);
    });
}

async function init(){
    await getTotalItem();
    await getTotal();
}

init();