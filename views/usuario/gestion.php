<?php
    $link_reg_nuevo = '';
    $valor          = '"nombre_usuario:Nombre Usuario","email:Correo"';
?>
<div class="p-4 mx-auto">
    <div class="card">
        <h5 class="card-header">Usuarios</h5>
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
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="contenidotabla" class="mt-4 card-deck p-4"></div>
</div>
<script> const ruta = '<?= RUTA?>views/usuario/list-usuarios.php';</script>
<script src="<?= RUTA ?>assets/scripts/mis_listados.js"></script>
<script>busqueda_tr()</script>