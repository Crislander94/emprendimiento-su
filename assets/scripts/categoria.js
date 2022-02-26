CKEDITOR.replace( 'descripcion' );
if(document.getElementById('crear_categoria') !== null){
    document.getElementById('crear_categoria').addEventListener('submit', e =>{
        e.preventDefault();
        const nom_categoria = document.getElementById('nom_categoria').value;
        const editor = CKEDITOR.instances.descripcion;
        if(nom_categoria === ''){
            Swal.fire('Validacion', 'Ingrese el nombre de la categoria', 'warning');
            return;
        }
        if(editor.getData().length === 0){
            Swal.fire('Validacion', 'No deje vacía su recomendación', 'warning');
            return;
        }
        document.getElementById('crear_categoria').submit();
    });
}