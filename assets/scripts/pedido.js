if(document.getElementById('generar_pedido') !== null){
    document.getElementById('generar_pedido').addEventListener('submit' , e => {
        e.preventDefault();
        const nombre = document.getElementById('nombre').value;
        const direccion = document.getElementById('direccion').value;
        const correo = document.getElementById('correo').value;
        const telefono = document.getElementById('telefono').value;

        if(nombre === ''){
            Swal.fire('Validacion', 'Debes ingresar un nombre', 'warning');
            return;
        }
        if(direccion === ''){
            Swal.fire('Validacion', 'Debes ingresar una dirección', 'warning');
            return;
        }
        if(correo === '' || !revisar_correo(correo)){
            Swal.fire('Validacion', 'Debes ingresar un correo válido', 'warning');
            return;
        }
        if(telefono === ''){
            Swal.fire('Validacion', 'Debes ingresar un telefono', 'warning');
            return;
        }
        document.getElementById('generar_pedido').submit();
    })
}