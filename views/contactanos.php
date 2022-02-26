<div class="py-4 bg-light">
    <div class="row justify-content-center m-0">
        <div class="col-md-6 col-12">
            <form class="card" action="<?= RUTA ?>/mensaje/registrar" method="post" id="generar_mensaje">
                <div class="card-header" style="font-size:17px;font-weight:bold" >Escríbenos</div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="general_label_styles" for="nombre">Nombre</label>
                        <input type="text" class="form-control input_general_styles" name="nombre" id="nombre" placeholder="Escriba su nombre" onkeypress = "ValidaSoloLetras()">
                    </div>
                    <div class="form-group">
                        <label class="general_label_styles" for="correo">Correo</label>
                        <input type="text" class="form-control input_general_styles" name="correo" id="correo" placeholder="Escriba su correo">
                    </div>
                    <div class="form-group">
                        <label class="general_label_styles" for="correo">Asunto</label>
                        <input type="text" class="form-control input_general_styles" name="asunto" id="asunto" placeholder="Asunto">
                    </div>

                    <div class="form-group">
                        <label class="general_label_styles" for="mensaje">Mensaje</label>
                        <textarea name="mensaje" class="form-control textarea_general_styles" id="mensaje" placholder="Escriba su mensaje"></textarea>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-end">
                        <input type="submit" class="btn btn-primary" value="Enviar Mensaje">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?= RUTA ?>assets/scripts/mensaje.js"></script>