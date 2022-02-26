<?php $link_anterior = 'usuario/gestion' ?>
<div class="py-4 bg-light">
    <div class="row justify-content-center m-0">
        <div class="col-md-6 col-12">
            <form class="card" action="<?= RUTA ?>usuario/editar" method="post" id="editar_usuario">
                <div class="card-header" style="font-size:17px;font-weight:bold" >Modificar Usuario</div>
                <div class="card-body">
                    <input type="hidden" name="current_usuario" value="<?= $nombre_usuariox ?>">
                    <input type="hidden" name="id" value="<?= $idx ?>">
                    <div class="form-group">
                        <label class="general_label_styles" for="usuario">Usuario</label>
                        <input type="text" class="form-control input_general_styles" name="usuario" id="usuario" placeholder="Escriba su usuario Ejemplo: @usuario21" value="<?= $nombre_usuariox ?>">
                    </div>
                    <div class="input-group" style="margin-bottom:1rem">
                        <label for="contrasena" style="width:100%">Contraseña</label>
                        <input class="form-control input-registro form-control-solid h-auto py-7 px-6 rounded-lg" type="password"  name="contrasena" id="contrasena" autocomplete="off" placeholder="Escriba su Contraseña" value="<?= $password ?>"/>
                        <span toggle="#contrasena" class="input-group-append input-group-text container-icon-eye toggle-password"><i class="fa fa-eye" aria-hidden="true"></i></span>
                    </div>
                    <div class="form-group">
                        <label class="general_label_styles" for="nombres">Nombres</label>
                        <input type="text" class="form-control input_general_styles" name="nombres" id="nombres" placeholder="Escriba sus nombre" value="<?= $nombres ?>">
                    </div>
                    <div class="form-group">
                        <label class="general_label_styles" for="correo">Correo</label>
                        <input type="text" class="form-control input_general_styles" name="correo" id="correo" placeholder="Escriba su usuario" value="<?= $emailx ?>">
                    </div>
                    <div class="form-group">
                        <label class="general_label_styles" for="telefono">telefono</label>
                        <input type="text" class="form-control input_general_styles"name="telefono" id="telefono" placeholder="Escriba su usuario" onkeypress="ValidaSoloNumeros()" value="<?= $telefonox ?>">
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
<script src="<?= RUTA?>assets/scripts/usuario.js"></script>