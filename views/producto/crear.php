<?php $link_anterior = 'producto/gestion' ?>
<div class="py-4 bg-light">
    <div class="row justify-content-center m-0">
        <div class="col-md-6 col-12">
            <form class="card" action="<?= RUTA ?>producto/registro" enctype="multipart/form-data" method="post" id="registrar_producto">
                <div class="card-header" style="font-size:17px;font-weight:bold" >Crear Producto</div>
                <div class="card-body">
                    <div class="form-group mb-3 text-center">
                        <label class="col-form-label" style="color:#121212;font-weight:bold">Imagen del producto</label>
                        <div class="col-sm-12 d-flex justify-content-center">
                            <div id="image-preview" class="image-preview" style="background-size: 250px 250px; ">
                                <label for="image-upload" id="image-label">Cambiar Imagen</label>
                                <input type="file" name="image" id="image-upload" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="general_label_styles" for="usuario">Categoria del producto</label>
                        <select class="form-control" name="cod_categoria" id="cod_categoria">
                            <option value="">Seleccione...</option>
                            <?php
                                if(!empty($categorias)){
                                    foreach ($categorias as $key => $value) {
                                        # code...
                                        $cod_categoria = $value["ID"];
                                        $nom_categoria = $value["NOM_CATEGORIA"];
                                    
                            ?>
                                <option value="<?= $cod_categoria ?>"><?= $nom_categoria ?></option>
                            <?php 
                                    }
                                } 
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="general_label_styles" for="nom_producto">Nombre de Producto</label>
                        <input type="text" class="form-control input_general_styles"name="nom_producto" id="nom_producto" placeholder="Escriba el nombre del producto">
                    </div>
                    <div class="form-group d-none">
                        <label class="general_label_styles" for="stock">Stock</label>
                        <input type="text" class="form-control input_general_styles"name="stock" id="stock" placeholder="Escriba su stock" onkeypress="ValidaSoloNumeros()">
                    </div>
                    <div class="form-group">
                        <label class="general_label_styles" for="precio">Precio</label>
                        <input type="text" class="form-control input_general_styles"name="precio" id="precio" placeholder="Escriba su precio" onkeypress="return decimalNumbers(event, this);">
                    </div>
                    <div class="form-group row m-0  mb-3">
                        <label class="col-form-label p-0 mb-2 col-sm-12" style="font-weight:bold;color:#000">Descripcion</label>
                        <div class="col-lg-12 p-0 col-md-12 col-sm-12">
                            <textarea  name="descripcion" id="descripcion" class="cke_wrapper" rows="10" cols="80"></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-end">
                        <input type="submit" class="btn btn-primary" value="Crear">
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