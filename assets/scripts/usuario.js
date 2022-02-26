if(document.getElementById('iniciar_usuario') !== null){
    document.getElementById('iniciar_usuario').addEventListener('submit', e =>{ 
        e.preventDefault();
        const usuario = document.getElementById('usuario').value;
        const contrasena = document.getElementById('contrasena').value;
        
        if(usuario === ''){
            Swal.fire('Valdacion', 'Debe ingresar un usuario', 'warning');
            return;
        }
        if(contrasena === ''){
            Swal.fire('Valdacion', 'Debe ingresar una contrasena', 'warning');
            return;
        }
        document.getElementById('iniciar_usuario').submit();
    });
}
if(document.getElementById('registrar_usuario') !== null){
    document.getElementById('registrar_usuario').addEventListener('submit', e =>{ 
        e.preventDefault();

        const rol = document.getElementById('rol').value;
        const usuario = document.getElementById('usuario').value;
        const regex = /@{1}([A-Za-z0-9]{1,}[\_]?[A-Za-z0-9]*)$/g;
        const nombres = document.getElementById('nombres').value;
        const correo = document.getElementById('correo').value;
        const telefono = document.getElementById('telefono').value;
        const contrasena = document.getElementById('contrasena').value;



        if(rol === ''){
            Swal.fire('Valdacion', 'Debe seleccionar un rol', 'warning');
            return;
        }
        if(usuario === ''){
            Swal.fire('Valdacion', 'Debe ingresar un usuario', 'warning');
            return;
        }

        if(!regex.test(usuario)){
            Swal.fire('Validacion', 'Debe ingresar un usuario valido Ejemplo: @usuario_1', 'warning');
            return;
        }
        if(contrasena === ''){
            Swal.fire('Valdacion', 'Debe ingresar una contrasena', 'warning');
            return;
        }
        if(nombres === ''){
            Swal.fire('Valdacion', 'Debe ingresar un nombres', 'warning');
            return;
        }
        if(correo === '' || !revisar_correo(correo)){
            Swal.fire('Valdacion', 'Debe ingresar un correo válido', 'warning');
            return;
        }
        if(telefono === ''){
            Swal.fire('Valdacion', 'Debe ingresar un telefono', 'warning');
            return;
        }
        document.getElementById('registrar_usuario').submit();
    })
}
if(document.getElementById('editar_usuario') !== null){
    document.getElementById('editar_usuario').addEventListener('submit', e =>{
        e.preventDefault();
        const usuario = document.getElementById('usuario').value;
        const regex = /@{1}([A-Za-z0-9]{1,}[\_]?[A-Za-z0-9]*)$/g;
        const nombres = document.getElementById('nombres').value;
        const correo = document.getElementById('correo').value;
        const telefono = document.getElementById('telefono').value;
        const contrasena = document.getElementById('contrasena').value;

        if(usuario === ''){
            Swal.fire('Valdacion', 'Debe ingresar un usuario', 'warning');
            return;
        }

        if(!regex.test(usuario)){
            Swal.fire('Validacion', 'Debe ingresar un usuario valido Ejemplo: @usuario_1', 'warning');
            return;
        }
        if(contrasena === ''){
            Swal.fire('Valdacion', 'Debe ingresar una contrasena', 'warning');
            return;
        }
        if(nombres === ''){
            Swal.fire('Valdacion', 'Debe ingresar un nombres', 'warning');
            return;
        }
        if(correo === '' || !revisar_correo(correo)){
            Swal.fire('Valdacion', 'Debe ingresar un correo válido', 'warning');
            return;
        }
        if(telefono === ''){
            Swal.fire('Valdacion', 'Debe ingresar un telefono', 'warning');
            return;
        }
        document.getElementById('editar_usuario').submit();
    })
}

