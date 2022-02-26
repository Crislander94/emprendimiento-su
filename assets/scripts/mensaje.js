if(document.getElementById('generar_mensaje') !== null){
    document.getElementById('generar_mensaje').addEventListener('submit' , e => {
        e.preventDefault();
        const nombre = document.getElementById('nombre').value;
        const correo = document.getElementById('correo').value;
        const asunto = document.getElementById('asunto').value;
        const mensaje = document.getElementById('mensaje').value;

        if(nombre === ''){
            Swal.fire('Validacion', 'Debes ingresar un nombre', 'warning');
            return;
        }
        if(asunto === ''){
            Swal.fire('Validacion', 'Debes ingresar un asunto', 'warning');
            return;
        }
        if(mensaje === ''){
            Swal.fire('Validacion', 'Debes ingresar un mensaje', 'warning');
            return;
        }
        if(correo === '' || !revisar_correo(correo)){
            Swal.fire('Validacion', 'Debes ingresar un correo válido', 'warning');
            return;
        }
        document.getElementById('generar_mensaje').submit();
    })
}