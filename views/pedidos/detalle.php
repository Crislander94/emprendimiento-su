<div class="row m-0">
    <div class="col-12 bg-light">
        <?php
            $id = $response_pedido["ID"];
            $nombre = $response_pedido["NOMBRE"];
            $valor = $response_pedido["VALOR"];
            $direccion = $response_pedido["DIRECCION"];
            $provincia = $response_pedido["PROVINCIA"];
            $ciudad = $response_pedido["CIUDAD"];
            $correo = $response_pedido["CORREO"];
            $telefono = $response_pedido["TELEFONO"];
            $st_pedido = $response_pedido["ST_PEDIDO"];
        ?>
        <p class="text-center title_detalle_pedido">
            Datos Generales del pedido
        </p>
        <div class="row px-4">
            <div class="col-6">
                <p class="descripcion_general_pedido">Nombre Destinatario:</p>
                <p class="descripcion_general_pedido">Provincia:</p>
                <p class="descripcion_general_pedido">Ciudad:</p>
                <p class="descripcion_general_pedido">Direccion:</p>
                <p class="descripcion_general_pedido">Telefono Destinatario:</p>
                <p class="descripcion_general_pedido">Correo Destinatario:</p>
                <p class="descripcion_general_pedido">Precio Final:</p>
            </div>
            <div class="col-6" style="text-align:right">
                <p><?= $nombre ?></p>
                <p><?= $provincia ?></p>
                <p><?= $ciudad ?></p>
                <p><?= $direccion ?></p>
                <p><?= $telefono ?></p>
                <p><?= $correo ?> </p>
                <p>$<?= number_format($valor,2) ?></p>
            </div>
        </div>
    </div>
    <div class="col-12">
        <?php if($_SESSION["rol"] === 'C'): ?>
            <form action="<?= RUTA ?>pedido/actualizar_cliente" method="post">
                <input type="hidden" name="id_pedido" value="<?= $id ?>">
                <?php if( $st_pedido === 'E') : ?>
                    <div class="d-flex p-4 align-items-center justify-content-between">
                        <p class="mb-0">Presione el boton para confirmar la llegada de su pedido</p>
                        <button class="btn btn-success">Pedido Recibido <i class="mx-2 fas fa-parachute-box text-white"></i></button>
                    </div>
                <?php elseif($st_pedido !== 'E' && $st_pedido !== 'R'): ?>
                    <p class="text-center py-4">El pedido aún no ha sido enviado a su destino, sea paciente</p>
                    <div class="d-flex justify-content-center py-1">
                        <button type="button" onclick="redireccionar('<?=RUTA?>pedido/mis_pedidos')" class="btn btn-danger">Regresar Al Alistado<i class="fas fa-truck-loading text-white mx-2"></i></button>
                    </div>
                <?php elseif($st_pedido === 'R'): ?>
                    <p class="text-center py-4" style="color:green">Usted ha confirmado que la llegada de su pedido fue exitosa</p>
                    <div class="d-flex justify-content-center py-1">
                        <button type="button" onclick="redireccionar('<?=RUTA?>pedido/mis_pedidos')" class="btn btn-danger">Regresar Al Alistado<i class="fas fa-truck-loading text-white mx-2"></i></button>
                    </div>
                <?php endif;?>
            </form>
        <?php endif; ?>
        <?php if($_SESSION["rol"] === 'A'): ?>
            <form action="<?= RUTA ?>pedido/actualizar_gestion" class="p-4" method="post">
                <input type="hidden" name="id_pedido" value="<?= $id ?>">
                <div class="row ">
                    <?php if( $st_pedido !== 'E' && $st_pedido !== 'R') : ?>
                        <div class="col-8">
                            <select name="st_pedido" class="general_select_styles">
                                <option  <?php if (!(strcmp($st_pedido, "P"))) {echo "selected=\"selected\"";} ?> value="P">Pendiente</option>
                                <option  <?php if (!(strcmp($st_pedido, "W"))) {echo "selected=\"selected\"";} ?> value="W">Preparación</option>
                                <option  <?php if (!(strcmp($st_pedido, "L"))) {echo "selected=\"selected\"";} ?> value="L">Listo</option>
                                <option  <?php if (!(strcmp($st_pedido, "E"))) {echo "selected=\"selected\"";} ?> value="E">Enviado</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <div class="d-flex align-items-center justify-content-end">
                                <button class="btn btn-success">Cambiar estado<i class="mx-2 fas fa-exchange-alt text-white"></i></button>
                            </div>
                        </div>
                    <?php else:  ?>
                        <div class="col-12">
                            <div class="d-flex align-items-center justify-content-end">
                                <button type="button" onclick="redireccionar('<?=RUTA?>pedido/gestion')" class="btn btn-danger">Regresar Al Alistado<i class="fas fa-truck-loading text-white mx-2"></i></button>
                            </div>
                        </div>
                    <?php endif ?>
                </div>
            </form>
        <?php endif; ?>

        <?php if($_SESSION["rol"] === 'A'): ?>
        <?php endif; ?>
    </div>
    <div class="col-12 px-4">
        <p class="text-center title_detalle_pedido">
            Detalle del pedido
        </p>

        <div class="table_responsive px-4">
            <table class="table_custom">
                <thead>
                    <tr>
                        <th style="width:40px" class="px-3">#</th>
                        <th class="text-center px-4" style="width: 100px;"><i class="fas fa-photo-video"></i></th>
                        <th style="width:444px">Nombre Producto</th>
                        <th style="width:50px" class="text-center">Cantidad</th>
                        <th style="width:80px;text-align:right">P Unit</th>
                        <th style="width:100px;text-align:right" class="px-2">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $num = 0;
                        if(!empty($detalle_pedido)){
                        foreach ($detalle_pedido as $key => $value) {
                            $num++;
                            $nom_producto = $value["nom_producto"];
                            $cantidad = intval($value["cantidad"]);
                            $precio = floatval($value["precio"]);
                            $cod_producto = $value["cod_producto"];
                            $total = $cantidad * $precio;
                            $imagen = ($value["imagen_producto"] === null || $value["imagen_producto"] === '') ? 'assets/img/custom_image.jpg'  : 'archivos/productos/'.$value["imagen_producto"];
                    ?>
                        <tr>
                            <td class="px-3">
                                <span style="width:40px" ><?= $num ?></span>
                            </td>
                            <td class="text-center px-4" style="width: 100px;">
                                <img src="<?= RUTA.$imagen ?>" width="80" height="80" alt="#<?= $nom_producto ?>">
                            </td>
                            <td style="width:444px">
                                <a href="<?= RUTA ?>producto/detalle&id=<?= $cod_producto ?>" target="_blank"><?= $nom_producto ?></a>
                            </td>
                            <td style="width:50px" class="text-center">
                                <?= $cantidad ?>
                            </td>
                            <td style="width:80px;text-align:right">
                                $<?= number_format($precio, 2) ?>
                            </td>
                            <td style="width:100px;text-align:right" class="px-2">
                                $<?= number_format($total, 2) ?>
                            </td>
                        </tr>
                    <?php
                            }
                        }else{
                            echo 'Sin datos del pedido';
                        }
                        
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>