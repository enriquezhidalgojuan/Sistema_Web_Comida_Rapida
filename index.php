<?php
include("conexion.php");
session_start();
//si la variable de sessión no existe...
if (isset($_SESSION['id_usuario'])) {
	header("Location: admin.php");
}
//LOGIN
	//Si no está vacía...
//if (!empty($_POST)) {

	//si el usuario da a el botón ingresar...
	if (isset($_POST['ingresar'])) {
	$usuario=mysqli_real_escape_string($conexion,$_POST['user']);
	$password=mysqli_real_escape_string($conexion,$_POST['pass']);
	$password_encriptada=sha1($password);
	$sql="SELECT idusuarios FROM usuarios WHERE usuario='$usuario' and password='$password_encriptada'";
	$resultado=$conexion->query($sql);
	$rows=$resultado->num_rows;
	if ($rows>0) {
		$row=$resultado->fetch_assoc();
		//asigno mi variable de sesión y a ellos le asignamos en row el "idusuario"(de mi BD)
		$_SESSION['id_usuario']=$row['idusuarios'];
		header("Location: admin.php");
	}else{
 			echo "<script>
				alert('Usuario o Password incorrecto!');
				window.location='index.php';
				</script>";

	}

}

//REGISTRO DE USUARIO
if (isset($_POST["registrar"])) {
	//usamos 'mysqli_real_escape_string' para evitar inyección SQL
	$nombre=mysqli_real_escape_string($conexion,$_POST['nombre']);
	$correo=mysqli_real_escape_string($conexion,$_POST['correo']);
	$usuario=mysqli_real_escape_string($conexion,$_POST['user']);
	$password=mysqli_real_escape_string($conexion,$_POST['pass']);
	//usaremos la encriptación sha1()
	$password_encriptada=sha1($password);
	//no se va permitir registrar un usuario que no se encuentre en la tabla "usuario"
	$sqluser="SELECT idusuarios FROM usuarios WHERE usuario='$usuario'";
	//le asigno la conexion en una función donde recibe el parámetro de nuestra consulta
	$resultadouser=$conexion->query($sqluser);
	//contamos los registros con la función "num_rows"
	$filas=$resultadouser->num_rows;
	if ($filas>0) {
		echo "<script>
				alert('El usuario ya existe');
				window.location='index.php';
			</script>";
	}else{
		//insertamos información al usuario
		$sqlusuario="INSERT INTO usuarios (Nombre,Correo,Usuario,Password)
		VALUES('$nombre','$correo','$usuario','$password_encriptada')";
		$resultadousuario=$conexion->query($sqlusuario);
		if ($resultadousuario>0) {
			echo "<script>
					alert('Registro Exitoso');
					window.location='index.php';
				</script>";
		}else{
			echo "<script>
					alert('Error al Registrarse');
					window.location='index.php';
				</script>";
		}
	}

}

//FIN REGISTRO DE USUARIO
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Donde la Abuela</title>

		<meta name="description" content="User login page" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />


		<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />

		<link rel="stylesheet" href="assets/css/fonts.googleapis.com.css" />

		<link rel="stylesheet" href="assets/css/ace.min.css" />

		<link rel="stylesheet" href="assets/css/ace-rtl.min.css" />

	</head>

	<body class="login-layout">
		<div class="main-container">
			<div class="main-content">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="login-container">
							<div class="center">
								<h1>
									<img src="assets/images/gallery/hamburger.ico" width="50px">
									<span class="red">Donde </span>
									<span class="white" id="id-text2">la Abuela</span>
								</h1>
								<h4 class="blue" id="id-company-text">El sabor que esperabas...</h4>
							</div>

							<div class="space-6"></div>

							<div class="position-relative">
								<div id="login-box" class="login-box visible widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header blue lighter bigger">
												<img src="assets/images/gallery/donde_la_abuela.ico">
											</h4>

											<div class="space-6"></div>

											<form action="<?php $_SERVER["PHP_SELF"]; ?>" method="POST" >
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" class="form-control"  name="user"placeholder="Usuario" required />
															<i class="ace-icon fa fa-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" name="pass"class="form-control" placeholder="Contraseña" required/>
															<i class="ace-icon fa fa-lock"></i>
														</span>
													</label>

													<div class="space"></div>

													<div class="clearfix">
														<label class="inline">
															<input type="checkbox" class="ace" />
															<span class="lbl"> Recordarme</span>
														</label>

											<button type="submit" name="ingresar" class="width-35 pull-right btn btn-sm btn-primary">
												<i class="ace-icon fa fa-key"></i>
												<span class="bigger-110">Ingresar</span>
											</button>


													</div>

													<div class="space-4"></div>
												</fieldset>
											</form>

											<div class="social-or-login center">
												<span class="bigger-110">Encuentranos en...</span>
											</div>

											<div class="space-6"></div>

											<div class="social-login center">
												<a href="http://www.youtube.com" target="_blank" class="btn btn-danger">
													<i class="ace-icon fa fa-youtube" ></i>
												</a>
												<a href="https://www.facebook.com/profile.php?id=100009118411819" target="_blank" class="btn btn-primary">
													<i class="ace-icon fa fa-facebook"></i>
												</a>

												<a href="https://twitter.com" target="_blank" class="btn btn-info">
													<i class="ace-icon fa fa-twitter"></i>
												</a>

												<a href="https://www.instagram.com" target="_blank" class="btn btn-danger">
													<i class="ace-icon fa fa-instagram"></i>
												</a>
											</div>
										</div>

										<div class="toolbar clearfix">
											<div>
												<a href="#" data-target="#forgot-box" class="forgot-password-link">
													<i class="ace-icon fa fa-arrow-left"></i>
													Olvide mi contraseña
												</a>
											</div>

											<div>
												<a href="#" data-target="#signup-box" class="user-signup-link">
													Nuevo Registro
													<i class="ace-icon fa fa-arrow-right"></i>
												</a>
											</div>
										</div>
									</div>
								</div>

								<div id="forgot-box" class="forgot-box widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header red lighter bigger">
												<i class="ace-icon fa fa-key"></i>
												Recuperar Contraseña
											</h4>

											<div class="space-6"></div>
											<p>
												Ungresa tu correo electronico para recibir las instrucciones
											</p>

						<form>
							<fieldset>
								<label class="block clearfix">
									<span class="block input-icon input-icon-right">
									<input type="email" class="form-control" placeholder="Email" />
									<i class="ace-icon fa fa-envelope"></i>
									</span>
								</label>
							<div class="clearfix">
								<button type="button" class="width-35 pull-right btn btn-sm btn-danger">
								<i class="ace-icon fa fa-lightbulb-o"></i>
								<span class="bigger-110">Enviar</span>
								</button>
							</div>
							</fieldset>
						</form>
				</div>

	<div class="toolbar center">
		<a href="#" data-target="#login-box" class="back-to-login-link">
			Regresar al Login
			<i class="ace-icon fa fa-arrow-right"></i>
			</a>
			</div>
			</div>
			</div>

	<div id="signup-box" class="signup-box widget-box no-border">
             	<div class="widget-body">
			<div class="widget-main">
				<h4 class="header green lighter bigger">
					<i class="ace-icon fa fa-users blue"></i>
						Registro de Nuevos Usuarios
				</h4>
	<div class="space-6"></div>
		<p>Ingresa los datos solicitados acontinuacion: </p>
		<form action="<?php $_SERVER["PHP_SELF"]; ?>" method="POST" >
			<fieldset>
			            <label class="block clearfix">
					<span class="block input-icon input-icon-right">
						<input type="text" class="form-control"  name="nombre" placeholder="Nombre Completo"  required />
							<i class="ace-icon fa fa-users"></i>
					</span>
				</label>
			
				<label class="block clearfix">
					<span class="block input-icon input-icon-right">
				             	<input type="email" class="form-control" name="correo" placeholder="Email"  required />
					                        <i class="ace-icon fa fa-envelope"></i>
					</span>
				</label>
					<label class="block clearfix">
						<span class="block input-icon input-icon-right">
			                     		<input type="text" class="form-control" name="user" placeholder="Usuario"  required />
                                       				<i class="ace-icon fa fa-user"></i>
  						</span>
				</label>
				<label class="block clearfix">
                     				<span class="block input-icon input-icon-right">
		                      			<input type="password" class="form-control" name="pass" placeholder="Password"  required />
							<i class="ace-icon fa fa-lock"></i>
					</span>
				</label>

				<label class="block clearfix">
					<span class="block input-icon input-icon-right">
						<input type="password" class="form-control" name="passr" placeholder="Repetir password" />
							<i class="ace-icon fa fa-retweet"></i>
									</span>
				</label>

				<label class="block">
					<input type="checkbox" class="ace" />
						<span class="lbl">
						Acepto los
						<a href="#">Terminos de Uso</a>
						</span>
				</label>
				<div class="space-24"></div>
				<div class="clearfix">
					<button type="reset" class="width-30 pull-left btn btn-sm">
						<i class="ace-icon fa fa-refresh"></i>
							<span class="bigger-110">Reset</span>
					</button>
					
					<button type="submit" name="registrar"   class="width-65 pull-right btn btn-sm btn-success">
						<span class="bigger-110">Registrar</span>
							<i class="ace-icon fa fa-arrow-right icon-on-right"></i>
					</button>
					 </div>
			</fieldset>
		</form>
	</div>

			<div class="toolbar center">
				<a href="#" data-target="#login-box" class="back-to-login-link">
					<i class="ace-icon fa fa-arrow-left"></i>
						Regresar al Login
				</a>
			</div>
		</div>
	</div>
</div>

							<div class="navbar-fixed-top align-right">
								<br />
								&nbsp;
								<a id="btn-login-dark" href="#">Oscuro</a>
								&nbsp;
								<span class="blue">/</span>
								&nbsp;
								<a id="btn-login-blur" href="#">Azul</a>
								&nbsp;
								<span class="blue">/</span>
								&nbsp;
								<a id="btn-login-light" href="#">Claro</a>
								&nbsp; &nbsp; &nbsp;
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<script src="assets/js/jquery-2.1.4.min.js"></script>

		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>

		<script type="text/javascript">
			jQuery(function($) {
			 $(document).on('click', '.toolbar a[data-target]', function(e) {
				e.preventDefault();
				var target = $(this).data('target');
				$('.widget-box.visible').removeClass('visible');//hide others
				$(target).addClass('visible');//show target
			 });
			});

			jQuery(function($) {
			 $('#btn-login-dark').on('click', function(e) {
				$('body').attr('class', 'login-layout');
				$('#id-text2').attr('class', 'white');
				$('#id-company-text').attr('class', 'blue');

				e.preventDefault();
			 });
			 $('#btn-login-light').on('click', function(e) {
				$('body').attr('class', 'login-layout light-login');
				$('#id-text2').attr('class', 'grey');
				$('#id-company-text').attr('class', 'blue');

				e.preventDefault();
			 });
			 $('#btn-login-blur').on('click', function(e) {
				$('body').attr('class', 'login-layout blur-login');
				$('#id-text2').attr('class', 'white');
				$('#id-company-text').attr('class', 'light-blue');

				e.preventDefault();
			 });

			});
		</script>
	</body>
</html>
