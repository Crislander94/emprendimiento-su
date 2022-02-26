<?php
    $link_reg_nuevo = '';
    $valor          = '"nombre:Nombre","asunto:Asunto"';
?>
<div class="p-4 mx-auto">
    <div class="card">
        <h5 class="card-header">Mensajes</h5>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel-body">
                        <form name="filtrocabecera" method="post" id="filtrocabecera" action="">
                            <input type="hidden" name="pagina_actual">
                            <div class="row">
                                <div class="col-lg-2 m-b-20 pull-right">
                                    <select class="form-control general_select_styles" style="height:auto;" name="combo" id="cregistros" onchange="busqueda_tr()">
                                        <option value="5" >5 Registros</option>
                                        <option value="10">10 Registros</option>
                                        <option value="15">15 Registros</option>
                                        <option value="20">20 Registros</option>
                                    </select>
                                </div>
                                <div id="busq_select" class="col-lg-2 m-b-10">
                                    <select class="form-control general_select_styles" style="height:auto;" id="opciones" name="opciones[]" onchange="busqueda_tr();"  >
                                        <?php 
                                            $opciones = explode( ',', $valor);
                                            foreach($opciones as $i =>$key) {
                                                $key = str_replace('"', "", $key);
                                                list($campo_select,$valor_select) = explode(":",$key);   
                                                echo "<option value='$campo_select'>$valor_select</option>";
                                            }
                                        ?>
                                    </select>
                                    <br>
                                </div>
                                <div id="busq_input" class="col-lg-4">
                                    <section class="panel" id="buscap"  >
                                        <input name="busca[]" class='form-control general_search_styles' type="text"  id="busca" onKeyUp="busqueda_tr()" placeholder="Buscar" value="">
                                        <br>
                                    </section>
                                </div>
                                <div id="filtros_dinamicos" class="col-lg-12"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="contenidotabla" class="mt-4 card-deck p-4"></div>
</div>
<script> const ruta = '<?= RUTA?>views/list-mensajes.php';</script>
<script src="<?= RUTA ?>assets/scripts/mis_listados.js"></script>
<script>
    busqueda_tr();
    function modal_mensaje(e){
        const mensaje = e.getAttribute('data-id');
        const txt_mensaje = document.getElementById('txt_mensaje_modal');
        txt_mensaje.innerHTML = mensaje;
        $('#modal_mensaje').modal('show');
    }
</script>
<div class="modal fade" id="modal_mensaje" style="z-index:9999"  tabindex="-1" role="dialog" aria-labelledby="formModal"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo_modalxxx">Mensaje </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="p-4 bg-light" id="txt_mensaje_modal"></p>
            </div>
        </div>
    </div>
</div>