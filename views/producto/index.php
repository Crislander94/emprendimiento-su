<?php
    $link_reg_nuevo = 'producto/crear';
    $valor          = '"a.nom_producto:Nombre","c.nom_categoria:Categoria"';
?>
<div class="p-4 mx-auto">
    <h5 class="title_productos_listado py-4">Nuestros Productos</h5>
    <p class="mb-3 text-center">Posicione el puntero encima de la imagen y de click en el carrito, o añadalo directamente desde el botón al final de la card.</p>
    <div class="row">
        <div class="col-lg-12">
            <form name="filtrocabecera" method="post" id="filtrocabecera" action="">
                <input type="hidden" name="pagina_actual">
                <input type="hidden" name="combo" id="cregistros" value="10" />
                <div class="row">
                    <div id="busq_select" class="col-md-3 col-12 m-b-10">
                        <section class="panel" id="buscao" style="height: 100%;">
                            <select class="general_select_styles"  id="opciones" name="opciones[]" onchange="busqueda_tr();"  >
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
                        </section> 
                    </div>
                    <div id="busq_input" class="col-md-9 col-12">
                        <section class="panel" id="buscap"  >
                            <input name="busca[]" class='general_search_styles' type="text" id="busca" onKeyUp="busqueda_tr()" placeholder="Buscar" value="">
                            <br />
                        </section>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="contenidotabla" class="mt-4 p-4"></div>
</div>
<script> const ruta = '<?= RUTA?>views/producto/list-productos-clientes.php';</script>
<script src="<?= RUTA ?>assets/scripts/mis_listados.js"></script>
<script>busqueda_tr()</script>