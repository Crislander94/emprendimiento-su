<?php
    include_once '../paginacion.php';
    include_once '../../db/conexion.php';
    include_once '../../models/pedidoModel.php';
    include_once '../../config/settings.php';
    session_start();
    $db = new DBClass();
    $conexionx = $db->getconnection();
    $valor_query = 0;

    $consulta = '';

    if($_SESSION["rol"] === 'A'){ $consulta = 'listado_gestion'; }
    if($_SESSION["rol"] === 'C'){ $consulta = 'listado'; }
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
    $pedido           = new Pedido($consulta,$_offset,intval($cregistros),$condicion, $_SESSION["id"]);
    $response           = $pedido->serverQuery($conexionx);
    $response_pedidos = ($response->fetchAll(PDO::FETCH_ASSOC));
    $response->nextRowset();
    $response2 = $response->fetchAll(PDO::FETCH_ASSOC);
    $total =($response2[0]["total_rows"]);
?>
<form name="fcms" method="post" action="">
    <section>
        <input type="hidden" name="proceso">
        <input type="hidden" name="eliminar" value="false">
        <div class="d-flex justify-content-end">
            <nav class="d-inline-block">
                <?php $pagination->btn_primary($total, $_page, $_max_item, "busqueda_tr"); ?>
            </nav>
        </div>
        <div class="table-responsive">
            <table class="table_custom">
                <thead>
                    <tr>
                    <tr style="left: 0px;">
                        <th><span style="width: 40px;padding-left:10px;padding-right:10px">#</span></th>
                        <th><span style="width: 100px;">Valor</span></th>
                        <th><span style="width: 100px;">Nombre</span></th>
                        <th><span style="width: 100px;">Correo</span></th>
                        <th><span style="width: 250px;">Estado</span></th>
                        <th><span style="width: 144px;">Fecha Creación</span></th>
                        <th><span style="width: 130px;">Acciones</span></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $num = 0;
                       if(empty($response_pedidos)){
                            echo '<tr>';
                            echo    '<td colspan="8">';
                            echo         '<p class="text-center bg-light" style="padding:20px 0;">No se han encontrado resultados..</p>';
                            echo     '</td>';
                            echo '</tr>';
                       }else{
                        foreach ($response_pedidos as $key => $value) {
                            $id = $value["id"];
                            $valor = number_format($value["valor"], 2);
                            $nombre = $value["nombre"];
                            $correo = $value["correo"];
                            $correo = (strlen($correo) > 15) ? substr($correo, 0,14).'..' : $correo;
                            $fecha_creacion = $value["fecha_creacion"];
                            $estado = $value["estado"];
                            $color_estado = $value["color_estado"];
                            $num++;
                    ?>
                    <tr>
                        <td class="datatable-cell-sorted datatable-cell-left datatable-cell" data-field="RecordID" aria-label="1">
                            <span style="width: 40px;padding-left:10px;padding-right:10px"><span class="font-weight-bolder"><?= $num ?></span></span>
                        </td>
                        <td data-field="OrderID" aria-label="64616-103" class="datatable-cell">
                            <span style="width: 250px;">
                                <div class="d-flex align-items-center">
                                    <div class="font-weight-bold text-muted" style="width:100px;">$<?= $valor ?></div>
                                </div>
                            </span>
                        </td>
                        <td data-field="OrderID" aria-label="64616-103" class="datatable-cell">
                            <span style="width: 250px;">
                                <div class="d-flex align-items-center">
                                    <div class="font-weight-bold text-muted" style="width:100px;"><?= $nombre ?></div>
                                </div>
                            </span>
                        </td>
                        <td data-field="OrderID" aria-label="64616-103" class="datatable-cell">
                            <span style="width: 250px;">
                                <div class="d-flex align-items-center">
                                    <div class="font-weight-bold text-muted" style="width:100px;"><?= $correo ?></div>
                                </div>
                            </span>
                        </td>
                        <td data-field="OrderID" aria-label="64616-103" class="datatable-cell">
                            <span style="width: 250px;">
                                <div class="d-flex align-items-center">
                                    <span class="bg-<?= $color_estado ?>" style="width:150px;padding:10px;text-center;color:#fff;border-radius:5px"><?= $estado ?></span>
                                </div>
                            </span>
                        </td>
                        <td data-field="OrderID" aria-label="64616-103" class="datatable-cell">
                            <span style="width: 250px;">
                                <div class="d-flex align-items-center">
                                    <div class="font-weight-bold text-muted" style="width:100px;"><?=$fecha_creacion ?></div>
                                </div>
                            </span>
                        </td>
                        <td>
                            <?php if($_SESSION["rol"]  === 'C') : ?>
                                <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                    <a data-toggle="tooltip" href="<?= RUTA ?>pedido/detalle&id=<?php echo $id; ?>"  data-bs-toggle="tooltip" data-bs-placement="top" title="Ver Detalle del pedido" id="modificar1">
                                        <button type="button" class="btn btn-success centro">
                                            <i class="text-white fas fa-eye iconolist"></i>
                                        </button>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <?php if($_SESSION["rol"]  === 'A') : ?>
                                <?php if($estado !== 'ENVIADO' && $estado !== 'RECIBIDO') : ?>
                                    <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                        <a data-toggle="tooltip" href="<?= RUTA ?>pedido/detalle&id=<?php echo $id; ?>"  data-bs-toggle="tooltip" data-bs-placement="top" title="Ver Detalle del pedido" id="modificar1">
                                            <button type="button" class="btn btn-warning centro">
                                                <i class="text-white fas fa-edit iconolist"></i>
                                            </button>
                                        </a>
                                    </div>
                                <?php elseif($estado === 'ENVIADO' || $estado === 'RECIBIDO'): ?>
                                    <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                        <a data-toggle="tooltip" href="<?= RUTA ?>pedido/detalle&id=<?php echo $id; ?>"  data-bs-toggle="tooltip" data-bs-placement="top" title="Ver Detalle del pedido" id="modificar1">
                                            <button type="button" class="btn btn-success centro">
                                                <i class="text-white fas fa-eye iconolist"></i>
                                            </button>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php }  }
                    ?>
                </tbody>
            </table>
        </div>
    </section>
</form>