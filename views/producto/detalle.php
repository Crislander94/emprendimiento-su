<div class="px-4 py-4 bg-light">
    <div class="container">
        <div class="row py-4">
            <div class="col-12">
                <h3 class="text-center" style="font-weight:600" >Detalle del producto</h3>
            </div>
            <div class="col-md-6 col-12 text-center">
                <img class="img_detalle_producto" onclick="ventanamodal('<?= $imagen?>', '<?= $nom_productox ?>')" 
                    src="<?=$imagen ?>" alt="<?= $nom_productox?>" width="400" height="400"
                    style="box-shadow:2px 2px 10px rgba(0,0,0,.05);border-radius:5px"
                />
            </div>
            <div class="col-md-6 col-12">
                <p class="title_detalle_producto"><?= $nom_productox?></p>
                <p class="precio_detalle_producto">$<?= number_format($preciox,2); ?></p>
                <p>Descripcion:</p>
                <span class="descripcion_producto">
                    <?= trim($descripcionx) ?>
                </span>
                <button onclick="add_carrito('<?= $id; ?>')" class="btn btn-primary2">Añadir al carrito<i class="fas fa-cart-plus mx-2 text-white"></i></button>
            </div>
        </div>
    </div>
</div>
<?php include_once 'views/view-image.php' ?>
<script src="<?= RUTA ?>assets/scripts/carrito.js"></script>