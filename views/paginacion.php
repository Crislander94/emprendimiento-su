<?php 
	class pagination {
		function btn_primary($total_registros, $_page, $_max_item, $_js_function_name){
			$_count_row = 0;
			$_count_row = $total_registros;
			echo '<ul class="paginacion_styles_general color_morado">';
			if ($_count_row > 0) {
				if (!($_page + 1 == 1)) {
					echo   '<li class="active_link" onclick="' . $_js_function_name . '(\'1\');" > <i class="fas fa-angle-double-left"></i> </li>';
				}
				echo ' ';
				if ($_page + 1 > 2) {
					echo ' ';
				}
				$_btn = ceil(($_count_row / $_max_item));
				for ($i = 1; $i <= $_btn; $i++) {
					if (!($i >= ($_page + 4) or $i <= ($_page - 2))) {
						if ($i == $_page + 1) {
							echo ' <li class="active_link selected_link">';
						} else {
							echo '<li class="active_link" onclick="' . $_js_function_name . '(\'' . $i . '\');" >';
						}
						echo $i.'</li>';
					}
				}
				if (($_page + 1 < $_btn - 2)) {
					$_btn = $_btn -1;
					echo '<li class="active_link" onclick="' . $_js_function_name . '(\'' . $_btn . '\');"> <i class="fas fa-angle-double-right"></i> </li>';
				}
				if ($_btn != 1) {
					if (($_page + 1) == $_btn) {echo '';} else{}
				}	
			}
			echo '</ul>';
		}
	}
	$pagination = new pagination();
	$_page 		= intval($_POST["pagina_actual"]);
	$cregistros = intval($_POST["combo"]);
	if ($_page > 0) {
		$_page--;
	} else {
		$_page 	= 0;
	} 
	if ($cregistros == "") { $cregistros = 1;} 
	$_max_item 	= intval($cregistros); 
	$_offset 	= intval($_max_item) * intval($_page);

?>