<?php
    include_once '../paginacion.php';
    include_once '../../db/conexion.php';
    include_once '../../models/productoModel.php';
    include_once '../../config/settings.php';
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
    $producto           = new Producto('listado',$_offset,intval($cregistros),$condicion);
    $response           = $producto->serverQuery($conexionx);
    $response_productos = ($response->fetchAll(PDO::FETCH_ASSOC));
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
        <section class="container">
            <div class="row">
                <?php
                    $num = 0;
                    if(empty($response_productos)){ ?>
                        <div class="col-12 bg-light d-flex flex-wrap justify-content-center" style="width:100%; padding: 10px; text-align:center;">
                            <img width="300" height="300" src="<?= RUTA ?>assets/img/extra/leyendo.png" alt="#Sin Resultados" />
                            <p style="color:#000; font-weight: 600; font-size: 20px;width:100%">No se han encontrado resultados..</p>
                        </div>
                <?php
                    }else{
                    foreach ($response_productos as $key => $value) {
                        $id = $value["ID"];
                        $nom_producto = $value["NOM_PRODUCTO"];
                        $cod_categoria = $value["COD_CATEGORIA"];
                        $nom_categoria = $value["NOM_CATEGORIA"];
                        $detalle_producto = $value["DESCRIPCION"];
                        $precio_producto = $value["PRECIO"];
                        $imagen = $value["IMAGEN_PRODUCTO"];
                        $rand = rand();
                        $imagen = ($imagen == '' || $imagen == null) ? RUTA.'assets/img/custom_image.jpg' : RUTA.'archivos/productos/'.$imagen.'?v='.$rand;
                ?>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-4 custome_resize_cards_plantilla">
                        <div class="card spcial_card_product" style="border-radius: 11px 11px 5px 5px;">
                            <div class="content_thumb_producto_fact">
                                <div class="thumb custom_content_img_plantilla_producto d-flex justify-content-center align-items-center">
                                    <div class="ribbon ribbon-bookmark ribbon-vertical-right ribbon-info">
                                        <i class="fas fa-heartbeat"></i>
                                    </div>
                                    <img class="img-fluid" src="<?php echo $imagen; ?>" alt="#Producto Prueba" style="width:100%">
                                    <div class="button_actions_productos">
                                        <a data-toggle="tooltip"  data-bs-toggle="tooltip" data-bs-placement="top" href="<?=RUTA ?>producto/modificar&id=<?php echo $id; ?>"  title="Modificar Registro" id="modificar1">
                                            <button type="button" class="btn btn_actions_product_list custom_general_button bg_buttons_warning">
                                                <i class="text-white fas fa-edit iconolist"></i>
                                            </button>
                                        </a>
                                        <a href="#" data-toggle="tooltip"  data-bs-toggle="tooltip" data-bs-placement="top" onClick="javascript:EliminarRegistro('<?= RUTA ?>producto/eliminar&id=<?php echo $id; ?>');" title="Eliminar Registro" id="modificar1">
                                            <button type="button"  class="btn btn_actions_product_list custom_general_button bg_buttons_danger" >
                                                <i class="text-white fas fa-trash iconolist"></i>
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body card-body_custom_product_fact">
                                <p class="title_product">
                                    <?php if($nom_producto != ''):?>
                                        <?php if(strlen($nom_producto) > 15) : 
                                            echo substr($nom_producto, 0, 15).'...';
                                        ?>
                                        <?php else:
                                            echo $nom_producto;
                                            endif;
                                        ?>
                                    <?php else: ?>
                                        Sin Nombre de producto.
                                    <?php endif; ?>
                                </p>
                                <p class="description_product">
                                    <?php if($detalle_producto != ''):?>
                                        <?php if(strlen($detalle_producto) > 20) : 
                                            echo substr($detalle_producto, 0, 20).'...';    
                                        ?>
                                        <?php else: 
                                            echo $detalle_producto;
                                            endif;
                                        ?>
                                    <?php else: ?>
                                        Sin Detalle de producto.
                                    <?php endif; ?>
                                </p>
                                <p class="price_product">$<?php echo $precio_producto?></p>
                            </div>
                        </div>
                    </div>
                <?php }  }
                ?>
            </div>
        </section>
    </section>
</form>