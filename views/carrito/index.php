<div class="row p-4 m-0">
    <div class="col-12 col-lg-8 mb-4">
        <form class="container_compras_carrito mb-4" id="carrito_compras">
            <input type="hidden" name="key" value="actualizar_carrito">
            <p class="title_detalle_carrito">Detalle de la compra</p>
            <table class="table-responsive table_carrito">
                <thead>
                    <tr>
                        <th class="text-center"><i class="fas fa-photo-video"></i></th>
                        <th>Descripcion</th>
                        <th>cantidad</th>
                        <th>p. Unit</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody id="content_carrito">
                    <?php 
                        if(empty($response)):
                    ?>
                        <tr class="p-4">
                            <td colspan="5" class="text-center">
                                <img src="<?= RUTA ?>assets/img/extra/leyendo.png" width="400" height="400" alt="#0 Articulos">
                                <p>0 Articulos en tu carrito</p>
                            </td>
                        </tr>
                    <?php else : ?>
                        <?php
                            foreach ($response as $key => $value) {
                                $idxx = $value["id"];
                        ?>
                            <tr>
                                <td class="text-center">
                                    <img class="imagen_carrito_producto" width="90" height="90" src="<?= RUTA ?>archivos/productos/<?= $value["imagen_producto"]?>" alt="<?= $value["nom_producto"]; ?>">
                                </td>
                                <td><?= $value["nom_producto"]?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <input type="hidden" name="cod_producto[]" value="<?= $idxx?>">
                                        <input type="hidden" name="cantidad[]" id="<?= $idxx ?>" value="<?= $value["cantidad"] ?>">
                                        <button type="button" class="btn btn-danger button_plus" onclick="aumentar_cantidad('<?= $idxx ;?>')"> + </button>
                                        <input type="text" class="cantidad_carrito" id="txt_<?= $idxx ?>" value="<?= $value["cantidad"]?>" disabled>
                                        <button type="button" class="btn btn-info button_minus" onclick="dismininuir_cantidad('<?= $idxx ;?>')"> - </button>
                                    </div>
                                </td>
                                <td>$<?= number_format($value["precio"],2) ?></td>
                                <td>
                                    <i onclick="delete_carrito(this, '<?= $idxx ?>')" class="fas fa-trash" style="cursor:pointer;color:#ff2000"></i>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </form>
        <div class="d-flex justify-content-end bg-light p-4">
            <button class="btn btn-danger mx-3" onclick="vaciar_carrito()">Vaciar Carrito<i class="fas fa-minus-circle mx-2 text-white"></i></button>
            <button class="btn btn-primary2" onclick="actualizar_carrito()">Actualizar Carrito<i class="fas fa-cart-plus mx-2 text-white"></i></button>
        </div>
    </div>
    <div class="col-12 col-lg-4">
        <div class="container_total">
            <p class="title_total_carrito">Total Carrito</p>
            <?php
                $total_final = ($response_total[0]["total"] === null || $response_total[0]["total"] === '') ? '0.00' : number_format($response_total[0]["total"], 2);
            ?>
            <div class="d-flex justify-content-between">
                <p>SUBTOTAL</p>
                <p id="precio_subtotal_carrito">$<?= $total_final ?></p>
            </div>
            <div class="d-flex justify-content-between">
                <p>IVA 0%</p>
                <p id="precio_iva_carrito">$0.00</p>
            </div>
            <hr />
            <div class="d-flex justify-content-between">
                <p>TOTAL</p>
                <p id="precio_total_carrito">$<?= $total_final ?></p>
            </div>
        </div>
        <div class="py-4 d-flex justify-content-center">
            <button class="btn btn-primary2" onclick="generar_pedido()">Generar Pedido <i class="fas fa-cash-register mx-2 text-white"></i></button>
        </div>
    </div>
</div>


<script src="<?= RUTA?>assets/scripts/carrito.js"></script>