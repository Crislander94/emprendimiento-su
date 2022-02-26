function add_carrito(id){
    const request = new XMLHttpRequest();
    const form = new FormData();
    form.append('key','add_carrito');
    form.append('id', id);


    request.open('POST',  getPathOrigin()+'endpoints/carrito.php');
    request.onreadystatechange = async () => {
        if(request.readyState === 4 && request.status === 200){
            const response = JSON.parse(request.responseText);
            const {codigo} = response;
            switch (parseInt(codigo)) {
                case 200:
                    await getTotal();
                    await getTotalItem();
                    Swal.fire({
                        title: "Seguir Comprando",
                        text: "Desea seguir comprando?",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, seguir comprando!',
                        cancelButtonText: 'No, ir al carrito!',
                        confirmButtonClass: 'btn btn-success',
                        cancelButtonClass: 'btn btn-danger',
                        buttonsStyling: false,
                        reverseButtons: true
                    }).then((result) => {
                        if (
                            result.dismiss === swal.DismissReason.cancel
                        ) {
                            document.location.href = getPathOrigin()+"carrito/index";
                        }
                    });
                    break;
                case -1:
                    Swal.fire('Carrito', 'Ya se encuentra en el carrito', 'info');
                    break;
                case -2:
                    Swal.fire('Error', 'Necesitas iniciar sesion como cliente para hacer esta accion', 'warning').then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = getPathOrigin()+ 'home/login';
                        } else if (result.dismiss === 'backdrop') {
                            window.location.href = getPathOrigin()+ 'home/login';
                        }else if (result.dismiss === 'esc') {
                            window.location.href = getPathOrigin()+ 'home/login';
                        }
                    });
                    break;
                    case -3:
                        Swal.fire('Carrito', 'Solo usuarios clientes pueden comprar', 'info');
                    break;
                default:
                    console.log('Error en el webservices');
                    break;
            }
        }
    }
    
    request.send(form);
}

function delete_carrito(e, id){
    const parent = e.parentElement.parentElement;
    const request = new XMLHttpRequest();
    const form = new FormData();
    form.append('key','delete');
    form.append('id', id);
    request.open('POST',  getPathOrigin()+'endpoints/carrito.php');
    request.onreadystatechange = async() => {
        if(request.readyState === 4 && request.status === 200){
            const response = JSON.parse(request.responseText);
            const {codigo} = response;
            switch (parseInt(codigo)) {
                case 200:
                    parent.remove();
                    const total = await getTotal();
                    document.getElementById('precio_subtotal_carrito').innerHTML = `$ ${total}`;
                    document.getElementById('precio_total_carrito').innerHTML = `$ ${total}`;
                    const cantidad = await getTotalItem();
                    if(parseInt(cantidad) === 0){
                        document.getElementById('content_carrito').innerHTML = `<tr class="p-4">
                                                    <td colspan="5" class="text-center">
                                                        <img src="${getPathOrigin()}assets/img/extra/leyendo.png" width="400" height="400" alt="#0 Articulos">
                                                        <p>0 Articulos en tu carrito</p>
                                                    </td>
                                                </tr>`
                    }
                    break;
                case -1:
                    console.log(response);
                    break;
                case -2:
                    Swal.fire('Error', 'Necesitas iniciar sesion como cliente para hacer esta accion', 'warning').then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = getPathOrigin()+ 'home/login';
                        } else if (result.dismiss === 'backdrop') {
                            window.location.href = getPathOrigin()+ 'home/login';
                        }else if (result.dismiss === 'esc') {
                            window.location.href = getPathOrigin()+ 'home/login';
                        }
                    });
                    break;
                    case -3:
                        Swal.fire('Carrito', 'Solo usuarios clientes pueden comprar', 'info');
                    break;
                default:
                    console.log('Error en el webservices');
                    break;
            }
        }
    }
    request.send(form);
}


function actualizar_carrito(){
    const request = new XMLHttpRequest();
    request.open('POST', getPathOrigin()+'endpoints/carrito.php');
    request.onreadystatechange = () => {
        if(request.readyState === 4 && request.status === 200){
            const response = JSON.parse(request.responseText);
            const {codigo} = response;
            switch (parseInt(codigo)) {
                case 200:
                    window.location.reload();
                    break;
                case -1:
                    Swal.fire('Error', 'Ocurrio un problema al querer actualizar el carrito' , 'error');
                    break;
                case -2:
                    Swal.fire('Error', 'Necesitas iniciar sesion como cliente para hacer esta accion', 'warning').then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = getPathOrigin()+ 'home/login';
                        } else if (result.dismiss === 'backdrop') {
                            window.location.href = getPathOrigin()+ 'home/login';
                        }else if (result.dismiss === 'esc') {
                            window.location.href = getPathOrigin()+ 'home/login';
                        }
                    });
                    break;
                    case -3:
                        Swal.fire('Carrito', 'Solo usuarios clientes pueden comprar', 'info');
                    break;
                default:
                    console.log('Error en el webservices');
                    break;
            }
        }
    }
    request.send(new FormData(document.getElementById('carrito_compras')));
}

async function vaciar_carrito(){
    const cantidad = await getTotalItem();
    if(parseInt(cantidad) > 0){
        const request = new XMLHttpRequest();
        const form = new FormData();
        form.append('key', 'vaciar');
        request.open('POST', getPathOrigin()+'endpoints/carrito.php');
        request.onreadystatechange = () => {
            if(request.readyState === 4 && request.status === 200){
                const response = JSON.parse(request.responseText);
                const {codigo} = response;
                switch (parseInt(codigo)) {
                    case 200:
                        window.location.reload();
                        break;
                    case -1:
                        Swal.fire('Error', 'Ocurrio un problema al querer vaciar el carrito' , 'error');
                        break;
                    case -2:
                        Swal.fire('Error', 'Necesitas iniciar sesion como cliente para hacer esta accion', 'warning').then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = getPathOrigin()+ 'home/login';
                            } else if (result.dismiss === 'backdrop') {
                                window.location.href = getPathOrigin()+ 'home/login';
                            }else if (result.dismiss === 'esc') {
                                window.location.href = getPathOrigin()+ 'home/login';
                            }
                        });
                        break;
                        case -3:
                            Swal.fire('Carrito', 'Solo usuarios clientes pueden comprar', 'info');
                        break;
                    default:
                        console.log('Error en el webservices');
                        break;
                }
            }
        }
        request.send(form);
    }else{
        Swal.fire('Carrito', 'Se debe tener al menos un producto en el carrito para vaciarlo', 'warning')
    }
}

function aumentar_cantidad(id){
    const input = document.getElementById(id);
    const txt_input = document.getElementById(`txt_${id}`);
    input.value = (parseInt(input.value)+1);
    txt_input.value = input.value;
}

function dismininuir_cantidad(id){
    const input = document.getElementById(id);
    const txt_input = document.getElementById(`txt_${id}`);

    if(parseInt(input.value) > 1){
        input.value = (parseInt(input.value)-1);
        txt_input.value = input.value;
    }
}


async function generar_pedido(){
    const cantidad = await getTotalItem();

    if(parseInt(cantidad) === 0){
        Swal.fire('Carrito', 'Debe seleccionar al menos un producto para generar su pedido' , 'info');
    }else{
        window.location.href = getPathOrigin()+'pedido/crear';
    }
}