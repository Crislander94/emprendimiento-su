<footer class="py-4">
	<div class="direccion py-4">
		<div class="row mx-0">
			<div  class="col-md-4">
				<div class="logo2 mx-auto mb-4 text-center">
					<a href="<?php echo RUTA?>"><img src="<?php echo RUTA?>assets/img/logo.png" alt="#Logo-Principal"></a>
				</div>
				<h6 class="titulo2 text-center">Redes sociales </h6>
				<div class="d-flex justify-content-center align-items-center">
					<!-- <a class="facebook enlace-social" 	target="_blank" href="#"><i class="fab fa-facebook-f"></i></a> -->
					<a class="instagram enlace-social" 	target="_blank" href="https://www.instagram.com/pclink_ec/"><i class="fab fa-instagram"></i></a>
					<a class="twitter enlace-social" 	target="_blank" href="https://twitter.com/pclink_ec"><i class="fab fa-twitter"></i></a>
				</div>
			</div>

			<div class="col-md-8 pt-4 px-5">
				<h4 class="titulo" style="text-align: right">Contáctanos</h4>
				<p class="calle">Edificio Brickell Tower piso 4 local 29</p>
				<p class="calle">Av Febrer Cordero Rivadeneira, La aurora</p>
				<p class="telefono">+593 991848446 - +593 939893684</p>
				<p class="correo">ventas@pclink.com - tecnico@pclink.ec</p>
			</div>
		</div>
	</div>
</footer>
<script src="<?php echo RUTA ?>assets/plugins/sweetAlert2/sweetalert2.all.min.js"></script>
<script src="<?php echo RUTA ?>assets/plugins/bootstrap-5/bootstrap.bundle.min.js"></script>
<!-- <script src="<?php echo RUTA ?>assets/plugins/popper/popper.min.js"></script> -->
<script>
	$(document).ready(function () {
		$(".toggle-password").click(function() {
			$(this).find('i').toggleClass("fa-eye fa-eye-slash");
			var input = $($(this).attr("toggle")); 
			if (input.attr("type") == "password") {
				input.attr("type", "text");
			} else {
				input.attr("type", "password");
			}
		});
	});
</script>
</body>
</html>