<script>
    function ventanamodal(url,nombre_producto){
        $('#side-modal-r').modal('show');
        document.getElementById('titulo_modal1').innerHTML = nombre_producto;
        document.getElementById('modal_img_producto').setAttribute('src', url);
    }
</script>
<div class="modal fade" id="side-modal-r" style="z-index:9999"  tabindex="-1" role="dialog" aria-labelledby="formModal"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo_modal1">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="datosAqui1">
                <img src="" style="width:100%;height" id="modal_img_producto" alt="#PreviewImage">
            </div>
        </div>
    </div>
</div>