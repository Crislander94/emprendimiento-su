<?php
    $link_reg_nuevo = '';
    $valor          = '"nombre:Nombre Usuario","correo:Correo"';
?>
    <div class="bg-light py-4 mb-4">
        <h5 class="title_pedidos text-center py-4">Mis  Pedidos</h5>
        <p class="text-center">Aqui puede observar un listado de todos los pedidos que ha realizado</p>
    </div>
    <div class="row m-0">
        <div class="col-lg-12">
            <div class="panel-body">
                <form name="filtrocabecera" method="post" id="filtrocabecera" action="">
                    <input type="hidden" name="pagina_actual">
                    <div class="row">
                        <div class="col-lg-2 m-b-20 pull-right">
                            <select class="form-control general_select_styles" name="combo" id="cregistros" onchange="busqueda_tr()" style="height:auto !important">
                                <option value="10">10 Registros</option>
                                <option value="20">20 Registros</option>
                                <option value="25">25 Registros</option>
                                <option value="30">30 Registros</option>
                            </select>
                        </div>
                        <div id="busq_select" class="col-lg-2 m-b-10">
                            <select class="form-control general_select_styles" id="opciones" name="opciones[]" onchange="busqueda_tr();"  style="height:auto !important">
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
                            <input name="busca[]" class='form-control general_search_styles' type="text" id="busca" onKeyUp="busqueda_tr()" placeholder="Buscar">
                        </div>
                        <div id="filtros_dinamicos" class="col-lg-12"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="contenidotabla" class="mt-4 card-deck p-4"></div>
</div>
<script> const ruta = '<?= RUTA?>views/pedidos/list-pedidos.php';</script>
<script src="<?= RUTA ?>assets/scripts/mis_listados.js"></script>
<script>busqueda_tr()</script>