<div class="py-4 bg-light">
    <div class="row justify-content-center m-0">
        <div class="col-md-6 col-12">
            <form class="card" action="<?= RUTA ?>pedido/registrar" method="post" id="generar_pedido">
                <div class="card-header" style="font-size:17px;font-weight:bold" >Crear Pedido</div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label class="general_label_styles" for="usuario">Provincia</label>
                        <select class="form-control" name="provincia" id="provincia">
                            <option value="Guayas">Guayas</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="general_label_styles" for="usuario">Ciudad</label>
                        <select class="form-control" name="ciudad" id="ciudad">
                            <option value="GUAYAQUIL">GUAYAQUIL</option>
                            <option value="ALFREDO BAQUERIZO MORENO">ALFREDO BAQUERIZO MORENO</option>
                            <option value="BALAO">BALAO</option>
                            <option value="BALZAR">BALZAR</option>
                            <option value="COLIMES">COLIMES</option>
                            <option value="DAULE">DAULE</option>
                            <option value="DURAN">DURAN</option>
                            <option value="EL EMPALME">EL EMPALME</option>
                            <option value="EL TRIUNFO">EL TRIUNFO</option>
                            <option value="MILAGRO">MILAGRO</option>
                            <option value="NARANJAL">NARANJAL</option>
                            <option value="NARANJITO">NARANJITO</option>
                            <option value="PALESTINA">PALESTINA</option>
                            <option value="PEDRO CARBO">PEDRO CARBO</option>
                            <option value="SAMBORONDON">SAMBORONDON</option>
                            <option value="SANTA LUCIA">SANTA LUCIA</option>
                            <option value="URBINA JADO">URBINA JADO</option>
                            <option value="YAGUACHI">YAGUACHI</option>
                            <option value="PLAYAS">PLAYAS</option>
                            <option value="SIMON BOLIVAR">SIMON BOLIVAR</option>
                            <option value="CORONEL MARCELINO MARIDUEÑA">CORONEL MARCELINO MARIDUEÑA</option>
                            <option value="LOMAS DE SARGENTILLO">LOMAS DE SARGENTILLO</option>
                            <option value="NOBOL">NOBOL</option>
                            <option value="GENERAL ANTONIO ELIZALDE">GENERAL ANTONIO ELIZALDE</option>
                            <option value="ISIDRO AYORA">ISIDRO AYORA</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="general_label_styles" for="nombre">Nombre</label>
                        <input type="text" class="form-control input_general_styles" name="nombre" onkeypress="ValidaSoloLetras()" id="nombre" placeholder="Escriba su nombre">
                    </div>
                    <div class="form-group">
                        <label class="general_label_styles" for="direccion">Direccion</label>
                        <input type="text" class="form-control input_general_styles" name="direccion" id="direccion" placeholder="Escriba su direccion">
                    </div>
                    <div class="form-group">
                        <label class="general_label_styles" for="correo">Correo</label>
                        <input type="text" class="form-control input_general_styles" name="correo" id="correo" placeholder="Escriba su correo">
                    </div>
                    <div class="form-group">
                        <label class="general_label_styles" for="telefono">telefono</label>
                        <input type="text" class="form-control input_general_styles" name="telefono" id="telefono" placeholder="Escriba su telefono" onkeypress="ValidaSoloNumeros()" maxlength="13">
                    </div>
                </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-end">
                        <input onclick="redireccionar('<?= RUTA ?>carrito/index')" type="button" class="btn btn-danger mx-2" value="Volver al carrito">
                        <input type="submit" class="btn btn-primary" value="Realizar Pedido">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="<?= RUTA?>assets/scripts/pedido.js"></script>