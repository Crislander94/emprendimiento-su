<div class="row p-4 m-0">
    <div class="col-12 py-4">
        <form action="<?= RUTA?>home/guardar_configuracion" class="row" method="POST">
            <div class="col-12 text-center py-2">
                <h3>Configuración del sitio</h3>
            </div>
            <div class="col-lg-6 col-12 mb-4">
                <label for="">Color Primario</label>
                <div id="cp2" class="input-group">
                    <input type="text" class="form-control input-lg" name="color_primary" value="<?= $color_primario ?>" style="padding:0px 5px"/>
                    <span class="input-group-append">
                        <span class="input-group-text colorpicker-input-addon"><i></i></span>
                    </span>
                </div>
            </div>
            <div class="col-lg-6 col-12 mb-4">
                <label for="">Color Secundario</label>
                <div id="cp3" class="input-group">
                    <input type="text" class="form-control input-lg" name="color_secondary" value="<?= $color_secundario ?>" style="padding:0px 5px"/>
                    <span class="input-group-append">
                        <span class="input-group-text colorpicker-input-addon"><i></i></span>
                    </span>
                </div>
            </div>
            <div class="col-12 mb-4">
                <select name="text_style" class="general_select_styles" style="width:100%">
                    <option <?php if (!(strcmp($fuente_primaria, "'Arial', sans-serif"))) {echo "selected";} ?> value="Arial">Default</option>
                    <option <?php if (!(strcmp($fuente_primaria, "'Open Sans', sans-serif"))) {echo "selected";} ?> value="Open Sans">Open Sans</option>
                    <option <?php if (!(strcmp($fuente_primaria, "'Coming Soon', sans-serif"))) {echo "selected";} ?> value="Coming Soon">Coming Soon</option>
                    <option <?php if (!(strcmp($fuente_primaria, "'Poppins', sans-serif"))) {echo "selected";} ?> value="Poppins">Poppins</option>
                    <option <?php if (!(strcmp($fuente_primaria, "'Dancing Script', sans-serif"))) {echo "selected";} ?> value="Dancing Script">Dancing Script</option>
                </select>
            </div>

            <div class="col-12 d-flex justify-content-center">
                <button class="btn btn-primary2">Guardar Configruacion</button>
            </div>
        </form>
    </div>
</div>
<script>
  $(function () {
    $('#cp2').colorpicker({});
    $('#cp3').colorpicker({});
  });
</script>
<!-- session_start();
setcookie("letra_cliente",$_POST["letra"].' !important;',time()+60*60*24*360,'/');
if(isset($_COOKIE["letra_cliente"])){
$font_family = $_COOKIE["letra_cliente"];
} -->