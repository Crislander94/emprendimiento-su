<div class="py-4 bg-light">
    <div class="row justify-content-center m-0">
        <div class="col-md-6 col-12">
            <form class="card" action="<?= RUTA ?>usuario/login" method="post" id="iniciar_usuario">
                <div class="card-header" style="font-size:17px;font-weight:bold" >Inicia Sesion</div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="general_label_styles" for="usuario">Usuario</label>
                        <input type="text" class="form-control input_general_styles" name="usuario" id="usuario" placeholder="Escriba su usuario">
                    </div>
                    <div class="input-group" style="margin-bottom:1rem">
                        <label for="contrasena" style="width:100%">Contraseña</label>
                        <input class="form-control input-registro form-control-solid h-auto py-7 px-6 rounded-lg" type="password"  name="contrasena" id="contrasena" autocomplete="off" placeholder="Escriba su Contraseña"/>
                        <span toggle="#contrasena" class="input-group-append input-group-text container-icon-eye toggle-password"><i class="fa fa-eye" aria-hidden="true"></i></span>
                    </div>

                    <p class="text-center mb-1">No tienes cuenta?</p>
                    <p class="text-center" ><a href="<?php echo RUTA ?>/usuario/crear">Registrate</a></p>
                </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-end">
                        <input type="submit" class="btn btn-primary" value="Iniciar Sesion">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?= RUTA?>assets/scripts/usuario.js"></script>