<?php 
    $coloralert = '';
    $nombre_alerta = '';
    $mensajexxx = '';
    if(isset($_SESSION["mensaje"])) {
        $coloralert = $_SESSION["color_alerta"];
        $mensajexxx = $_SESSION["mensaje"];
        $nombre_alerta = $_SESSION["resultado_response"];
?>
    <div class="bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 py-4">
                    <div class="mx-auto alert alert-<?php echo $coloralert; ?> alert-dismissible fade show" role="alert">
                        <strong><?php echo $nombre_alerta; ?> &nbsp;&nbsp;&nbsp;</strong> <?php echo $mensajexxx;?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="margin-top: 0px;">
                            <span aria-hidden="true">&times;</span>
                        </button> -->
                    </div>
    
                </div>
            </div>
        </div>
    </div>
<?php
        unset($_SESSION["mensaje"]);
        unset($_SESSION["color_alerta"]);
        unset($_SESSION["resultado_response"]);
    }
?>