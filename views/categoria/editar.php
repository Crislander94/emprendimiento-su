<?php $link_anterior = 'categoria/gestion' ?>
<div class="py-4 bg-light">
    <div class="row justify-content-center m-0">
        <div class="col-md-6 col-12">
            <form class="card" action="<?= RUTA ?>categoria/editar" method="post" id="crear_categoria">
                <div class="card-header" style="font-size:17px;font-weight:bold" >Editar Categoria</div>
                <div class="card-body">
                    <input type="hidden" name="current_nombre" value="<?= $nombre_categoriax ?>">
                    <input type="hidden" name="id" value="<?= $idx ?>">
                    <div class="form-group">
                        <label class="general_label_styles" for="nom_categoria">Nombre</label>
                        <input type="text" class="form-control input_general_styles"name="nom_categoria" id="nom_categoria" placeholder="Escriba el nombre de la categoria" value="<?= $nombre_categoriax ?>">
                    </div>
                    <div class="form-group row m-0  mb-3">
                        <label class="col-form-label p-0 mb-2 col-sm-12" style="font-weight:bold;color:#000">Descripcion</label>
                        <div class="col-lg-12 p-0 col-md-12 col-sm-12">
                            <textarea  name="descripcion" id="descripcion" class="cke_wrapper" rows="10" cols="80"><?= $descripcionx ?></textarea>
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
<script src="<?= RUTA?>assets/scripts/categoria.js"></script>