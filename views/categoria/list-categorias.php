<?php
    include_once '../paginacion.php';
    include_once '../../db/conexion.php';
    include_once '../../models/categoriaModel.php';
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
    $categoria           = new Categoria('listado',$_offset,intval($cregistros),$condicion);
    $response           = $categoria->serverQuery($conexionx);
    $response_categorias = ($response->fetchAll(PDO::FETCH_ASSOC));
    $response->nextRowset();
    $response2 = $response->fetchAll(PDO::FETCH_ASSOC);
    $total =($response2[0]["total_rows"]);
?>
<form name="fcms" class="card" method="post" action="">
    <section>
        <input type="hidden" name="proceso">
        <input type="hidden" name="eliminar" value="false">
        <div class="card-footer d-flex justify-content-end">
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
                        <th><span style="width: 100px;">Nombre</span></th>
                        <th><span style="width: 144px;">Fecha Creación</span></th>
                        <th><span style="width: 130px;">Acciones</span></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $num = 0;
                       if(empty($response_categorias)){
                            echo '<tr>';
                            echo    '<td colspan="4">';
                            echo         '<center><span>No se han encontrado resultados..</span></center>';
                            echo     '</td>';
                            echo '</tr>';
                       }else{

                      
                        foreach ($response_categorias as $key => $value) {

                            $id = $value["id"];
                            $nom_categoria = $value["nom_categoria"];
                            $fecha_creacion = $value["fecha_creacion"];
                            $num++;
                    ?>
                    <tr>
                        <td class="datatable-cell-sorted datatable-cell-left datatable-cell" data-field="RecordID" aria-label="1">
                            <span style="width: 40px;padding-left:10px;padding-right:10px"><span class="font-weight-bolder"><?= $num ?></span></span>
                        </td>
                        <td data-field="OrderID" aria-label="64616-103" class="datatable-cell">
                            <span style="width: 250px;">
                                <div class="d-flex align-items-center">
                                    <div class="font-weight-bold text-muted" style="width:100px;"><?= $nom_categoria ?></div>
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
                            <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                <a  data-toggle="tooltip" data-bs-toggle="tooltip" data-bs-placement="top" href="<?= RUTA ?>categoria/modificar&id=<?php echo $id; ?>"  title="Modificar Registro" id="modificar1">
                                    <button type="button" class="btn btn-warning centro">
                                        <i class="text-white fas fa-edit iconolist"></i>
                                    </button>
                                </a>
                                <a href="#"  data-toggle="tooltip" data-bs-toggle="tooltip" data-bs-placement="top"  onClick="javascript:EliminarRegistro('<?= RUTA ?>categoria/eliminar&id=<?= $id; ?>');" title="Eliminar Registro" id="eliminar1">
                                    <button type="button"  class="btn btn-danger izquierdo" >
                                        <i class="fas fa-trash iconolist"></i>
                                    </button>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php }  }
                    ?>
                </tbody>
            </table>
        </div>
    </section>
</form>