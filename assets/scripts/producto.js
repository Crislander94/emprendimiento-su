CKEDITOR.replace( 'descripcion' );
$.uploadPreview({
    input_field: "#image-upload",
    preview_box: "#image-preview",
    label_field: "#image-label",
    label_default: "Choose File",
    label_selected: "Change File",
    no_label: false,
    success_callback: null
});

if(document.getElementById('registrar_producto') !== null){
    document.getElementById('registrar_producto').addEventListener('submit', e =>{
        e.preventDefault();
        const cod_categoria = document.getElementById('cod_categoria').value;
        const nom_producto = document.getElementById('nom_producto').value;
        const precio = document.getElementById('precio').value;
        const editor = CKEDITOR.instances.descripcion;

        if(cod_categoria === ''){
            Swal.fire('Validacion', 'Seleccione una categoria', 'warning');
            return;
        }

        if(nom_producto === ''){
            Swal.fire('Validacion', 'Ingrese el nombre del producto', 'warning');
            return;
        }
        if(precio === '' || parseFloat(precio)  <= 0){
            Swal.fire('Validacion', 'Ingrese un precio válido', 'warning');
            return;
        }

        if(editor.getData().length === 0){
            Swal.fire('Validacion', 'Escriba una descripcion al producto', 'warning');
            return;
        }
        document.getElementById('registrar_producto').submit();
    });
}