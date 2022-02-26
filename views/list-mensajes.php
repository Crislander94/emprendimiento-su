<?php
    include_once 'paginacion.php';
    include_once '../db/conexion.php';
    include_once '../models/mensajeModel.php';
    include_once '../config/settings.php';
    session_start();
    $db = new DBClass();
    $conexionx = $db->getconnection();
    $valor_query = 0;
    $condicion_busqueda = '';
    foreach ($_POST['busca'] as $key => $value) {
        $condicion  =  $_POST['opciones'][$valor_query];
        $data =  $_POST['busca'][$valor_query];
        if ($condicion != "" && $data != "") {
            $condicion_busqueda =  $condicion_busqueda . " AND $condicion like ('%$data%')";
        }
        $valor_query++;
    }

    //Consultas de las tablas
    $condicion         =  $condicion_busqueda;
    $mensajexxx           = new Mensaje('listado',$_offset,intval($cregistros),$condicion);
    $response           = $mensajexxx->serverQuery($conexionx);
    $response_mensajes = ($response->fetchAll(PDO::FETCH_ASSOC));
    $response->nextRowset();
    $response2 = $response->fetchAll(PDO::FETCH_ASSOC);
    $total =($response2[0]["total_rows"]);
?>
<div>
    <input type="hidden" name="proceso">
    <input type="hidden" name="eliminar" value="false">
    <div class="d-flex justify-content-end">
        <nav class="d-inline-block">
            <?php $pagination->btn_primary($total, $_page, $_max_item, "busqueda_tr"); ?>
        </nav>
    </div>
    <div class="row">
        <?php
            if(empty($response_mensajes)){ 
        ?>
                <div class="col-12 bg-light d-flex flex-wrap justify-content-center" style="width:100%; padding: 10px; text-align:center;">
                    <img width="300" height="300" src="<?= RUTA ?>assets/img/extra/trabajando.png" alt="#Sin Resultados" />
                    <p style="color:#000; font-weight: 600; font-size: 20px;width:100%">No se han encontrado resultados..</p>
                </div>
        <?php
            }else{
                foreach ($response_mensajes as $key => $value) {
                    $id             = $value["id"];
                    $mensaje        = $value["mensaje"];
                    $asunto         = $value["asunto"];
                    $asunto         = (strlen($asunto) > 64) ? substr($asunto,0,60).'...' : $asunto;
                    $mensaje         = (strlen($mensaje) > 208) ? substr($mensaje,0,208).'...' : $mensaje;
                    $nombre         = $value["nombre"];
                    $correo         = $value["correo"];
                    $fecha_creacion = $value["fecha_creacion"];
        ?>
                    <div class="col-xl-3 col-lg-4 col-sm-6 col-12 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <p data-toggle="tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="<?= $asunto ?>" class="asunto_mensaje_lista" style="font-weight:600"><?= $asunto; ?></p>
                            </div>
                            <div class="card-body">
                                <p><span style="font-weight:600">Nombre: </span><?= $nombre; ?></p>
                                <p><span style="font-weight:600">Correo: </span><?= $correo; ?></p>
                                <p style="font-weight:600">Mensaje:</p>
                                <p class="py-4 px-2 bg-light descripcion_mensaje_lista" data-id="<?= $value['mensaje'] ?>" onclick="modal_mensaje(this)" ><?= $mensaje; ?></p>
                                <p style="text-align:right"><?= $fecha_creacion; ?></p>
                            </div>
                            <div class="card-footer">
                                <form class="d-flex justify-content-end" action="<?= RUTA ?>mensaje/eliminar&id=<?=$id ?>">
                                    <button class="btn btn-danger" >Eliminar Mensaje<i class="mx-2 text-white fas fa-comment-slash"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
        <?php
                } 
            }
        ?>
    </div>
</div>