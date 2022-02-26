<?php $link_anterior = 'producto/gestion' ?>
<div class="py-4 bg-light">
    <div class="row justify-content-center m-0">
        <div class="col-md-6 col-12">
            <form class="card" action="<?= RUTA ?>producto/editar" enctype="multipart/form-data" method="post" id="registrar_producto">
                <div class="card-header" style="font-size:17px;font-weight:bold" >Editar Producto</div>
                <div class="card-body">
                    <input type="hidden" name="id" value="<?= $idx?>">
                    <input type="hidden" name="current_nombre" value="<?= $nom_productox?>">
                    <div class="form-group mb-3 text-center">
                        <label class="col-form-label" style="color:#121212;font-weight:bold">Imagen del producto</label>
                        <div class="col-sm-12 d-flex justify-content-center">
                            <div id="image-preview" class="image-preview" style="background:url(<?=$imagen?>);background-size: 250px 250px; ">
                                <label for="image-upload" id="image-label">Cambiar Imagen</label>
                                <input type="file" name="image" id="image-upload" />
                            </div>
                        </div>
                    </div>
                    <?php
                        $db = new DBClass();
                        $conexionx = $db->getconnection();
                        $productox = new Producto('getCategorias');
                        $smtx = $productox->serverQuery($conexionx);
                        $categorias = $smtx->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <div class="form-group mb-3">
                        <label class="general_label_styles" for="usuario">Categoria del producto</label>
                        <select class="form-control" name="cod_categoria" id="cod_categoria">
                            <option value="">Seleccione...</option>
                            <?php
                                if(!empty($categorias)){
                                    foreach ($categorias as $key => $value) {
                                        $selected = '';
                                        # code...
                                        $cod_categoria = $value["ID"];
                                        if(intval($cod_categoria) === intval($cod_categoriax)){$selected = "selected";}
                                        $nom_categoria = $value["NOM_CATEGORIA"];
                                    
                            ?>
                                <option value="<?= $cod_categoria ?>" <?= $selected ?>><?= $nom_categoria ?></option>
                            <?php 
                                    }
                                } 
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="general_label_styles" for="nom_producto">Nombre de Producto</label>
                        <input type="text" class="form-control input_general_styles"name="nom_producto" id="nom_producto" placeholder="Escriba el nombre del producto" value="<?= $nom_productox ?>">
                    </div>
                    <div class="form-group d-none">
                        <label class="general_label_styles" for="stock">Stock</label>
                        <input type="text" class="form-control input_general_styles"name="stock" id="stock" placeholder="Escriba su stock" onkeypress="ValidaSoloNumeros()" value="<?= $stockx ?>">
                    </div>
                    <div class="form-group">
                        <label class="general_label_styles" for="precio">Precio</label>
                        <input type="text" class="form-control input_general_styles"name="precio" id="precio" placeholder="Escriba su precio" onkeypress="return decimalNumbers(event, this);" value="<?= $preciox ?>">
                    </div>
                    <div class="form-group row m-0  mb-3">
                        <label class="col-form-label p-0 mb-2 col-sm-12" style="font-weight:bold;color:#000">Descripcion</label>
                        <div class="col-lg-12 p-0 col-md-12 col-sm-12">
                            <textarea  name="descripcion" id="descripcion" class="cke_wrapper" rows="10" cols="80"> <?= $descripcionx ?> </textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-end">
                        <input type="submit" class="btn btn-primary" value="Editar">
                        <input type="button" class="btn btn-danger mx-3" onclick="regresar('<?= RUTA.$link_anterior;?>')" value="Volver">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="<?= RUTA?>assets/plugins/ckeditor/ckeditor.js"></script>
<script src="<?php echo RUTA ?>assets/plugins/uploadPreview/jquery.uploadPreview.min.js"></script>
<script src="<?= RUTA?>assets/scripts/producto.js"></script>