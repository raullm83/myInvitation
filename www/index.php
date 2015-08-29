<!DOCTYPE html>
<?php
	include_once './libreriaPHP/conexion.php'; 
	include_once './libreriaPHP/invitacion.php'; 
?>
<html>
<?php
	// Check connection
	if (!conexionValida($conn) or !$claveIndicada) {
	    die("Identificador no v&aacutelido " . $conn->connect_error);
	} else {
		$claveCodificada = codificar(htmlspecialchars($_GET["id"]));
		if(claveValida($conn, $claveCodificada)){
?>
    <head>
        <title><?php echo getTitulo($conn, $claveCodificada); ?></title>
		<link rel="icon" href="css/icons/favicon2.png">
		<!--[if IE]><link rel="shortcut icon" href="css/icons/favicon.jpg"><![endif]-->
		
        <meta charset="utf-8" />
        <meta name="format-detection" content="telephone=no" />
        <meta http-equiv="x-rim-auto-match" content="none">

        <meta name="msapplication-tap-highlight" content="no" />
        <!-- WARNING: for iOS 7, remove the width=device-width and height=device-height attributes. See https://issues.apache.org/jira/browse/CB-4323 -->
        <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height, target-densitydpi=device-dpi" />

        <link rel="stylesheet" type="text/css" href="css/index.css" />
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
		<link href='http://fonts.googleapis.com/css?family=Indie+Flower' rel='stylesheet' type='text/css'>

		<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
	    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=false&sensor=true"></script>
		
		<script type="text/javascript" src="js/index.js"></script>
    </head>
    <body>
    	<!-- Pagina index -->
		<div data-role="page" id="inicio" data-url="inicio" tabindex="0" class="ui-page ui-page-theme-a ui-page-footer-fixed" >
			<div role="main" class="ui-content">
				<div data-role="navbar" data-position="fixed" data-theme="a" role="banner" class="ui-header ui-bar-a ui-header-fixed slidedown ui-">
					<ul>
						<li><a href="#" data-icon="home" data-transition="slide" class="ui-btn-active"></a></li>
						<li><a href="#map-page" data-icon="navigation" data-transition="slide" ></a></li>
						<li><a href="#horario" data-icon="calendar" data-transition="slide" ></a></li>
						<li><a href="#contacto" data-icon="phone" data-transition="slide" ></a></li>
						<li><a href="#cuenta" data-icon="shop" data-transition="slide" ></a></li>
					</ul>
				</div><!-- /navbar -->
			</div>
			<div class="ui-grid-a ui-responsive">
				<div class="ui-block-a">
					<div class="ui-body">
						<span><?php echo getMensajeInicio($conn, $claveCodificada); ?></span>
					</div>
				</div>
				<div class="ui-block-b">
					<div class="ui-body">
						<img src="<?php echo getImagenInicio($conn, $claveCodificada); ?>" style="max-width: 100%; height: auto">
					</div>
				</div>
			</div>
		</div>
		<!-- Pagina map-page -->
		<div data-role="page" id="map-page" data-url="map-page" tabindex="1" class="ui-page ui-page-theme-a ui-page-footer-fixed" >
			<div role="main" class="ui-content">
				<div data-role="navbar" data-position="fixed" data-theme="a" role="banner" class="ui-header ui-bar-a ui-header-fixed slidedown">
					<ul>
						<li><a href="#inicio" data-icon="home"data-transition="slide" ></a></li>
						<li><a href="#" data-icon="navigation" data-transition="slide" class="ui-btn-active"></a></li>
						<li><a href="#horario" data-icon="calendar" data-transition="slide" ></a></li>
						<li><a href="#contacto" data-icon="phone" data-transition="slide" ></a></li>
						<li><a href="#cuenta" data-icon="shop" data-transition="slide" ></a></li>
					</ul>
				</div><!-- /navbar -->
			</div>
			<?php 
			$direcciones = getDirecciones($conn, $claveCodificada);
			reset($direcciones);
			$posicion = 1;
			while(list($descripcion, $datos) = each($direcciones)) {
			?>
			<div class="ui-grid-solo ui-responsive">
				<div class="ui-block-a">
					<h3 class="ui-bar ui-bar-a" style="margin: 0px; padding: .1em 1em;"><?php echo $descripcion; ?></h3>
					<div class="ui-body">
						<p style="margin: 0.5em">Dirección:</p>
						<p style="margin: 0.5em"><span style="font-weight: bold"><?php echo $datos[0] ?></span></p>
						<p style="margin: 0.5em"><span style="font-weight: bold"><?php echo $datos[1] ?></span></p>
						<p style="margin: 0.5em"><span style="font-weight: bold"><?php echo $datos[2]. ' ('. $datos[3]. ')' ?></span></p>
					</div>
				</div>
			</div>
			<div class="ui-grid-b">
    				<div class="ui-block-a">
					<a href="#popupMap<?php echo $posicion ?>" data-rel="popup" data-position-to="window" class="ui-btn ui-corner-all ui-shadow ui-btn-inline fondo-azul">Ver mapa</a>
				</div>
				<?php if(esMobile()) { ?>
				<div class="ui-block-b">
					<?php if(esApple()) { ?>
						<a href="maps:<?php echo rawurlencode($datos[0].' '.$datos[1].', '.$datos[2].' '.$datos[3]) ?>" data-rel="popup" data-position-to="window" class="ui-btn ui-corner-all ui-shadow ui-btn-inline fondo-verde">Ll&eacute;vame</a>
					<?php } else { ?>
						<a href="geo:0,0?q=<?php echo rawurlencode($datos[0].' '.$datos[1].', '.$datos[2].' '.$datos[3]) ?>" data-rel="popup" data-position-to="window" class="ui-btn ui-corner-all ui-shadow ui-btn-inline fondo-verde">Ll&eacute;vame</a>
					<?php } ?>				
				</div>
				<?php } else { ?>
					<a href="http://maps.google.com/?q=<?php echo $datos[0].' '.$datos[1].', '.$datos[2].' '.$datos[3] ?>&t=k" data-rel="popup" data-position-to="window" target="_blank" class="ui-btn ui-corner-all ui-shadow ui-btn-inline fondo-verde">Ll&eacute;vame</a>
				<?php } ?>
			</div>
				
			<div data-role="popup" id="popupMap<?php echo $posicion ?>" data-overlay-theme="a" data-theme="a" data-corners="false" data-tolerance="15,15">
				<a href="#" data-rel="back" class="ui-btn ui-btn-b ui-corner-all ui-shadow ui-btn-a ui-icon-delete ui-btn-icon-notext ui-btn-right">Cerrar</a>
				<iframe id="<?php echo $posicion ?>" src="map.php?direccion=<?php echo $datos[0].' '.$datos[1].', '.$datos[2].' '.$datos[3] ?>" width="480" height="320" seamless=""></iframe>
			</div>
			<?php
				$posicion = $posicion + 1; 
			} 
			?>
		</div>
		<!-- Pagina contacto -->
		<div data-role="page" id="contacto" data-url="contacto" tabindex="1" class="ui-page ui-page-theme-a ui-page-footer-fixed" >
			<div role="main" class="ui-content">
				<div data-role="navbar" data-position="fixed" data-theme="a" role="banner" class="ui-header ui-bar-a ui-header-fixed slidedown">
					<ul>
						<li><a href="#inicio" data-icon="home"data-transition="slide" ></a></li>
						<li><a href="#map-page" data-icon="navigation" data-transition="slide"></a></li>
						<li><a href="#horario" data-icon="calendar" data-transition="slide" ></a></li>
						<li><a href="#" data-icon="phone" data-transition="slide" class="ui-btn-active"></a></li>
						<li><a href="#cuenta" data-icon="shop" data-transition="slide" ></a></li>
					</ul>
				</div><!-- /navbar -->
			</div>
			<div class="ui-grid-a ui-responsive">
				<?php 
					$tipoContacto = getTipoContacto($conn, $claveCodificada);
					reset($tipoContacto);
					$posicion = 0;
					while (list($id, $valor) = each($tipoContacto)) {
				?>
					<div class="ui-block-<?php echo $letras[$posicion] ?>">
						<h3 class="ui-bar ui-bar-a" style="margin: 0px; padding: .1em 1em;"><?php echo $valor ?></h3>
						<div class="ui-body">
						<?php 
							$contactos = getContactos($conn, $claveCodificada, $id);
							reset($contactos);
							while (list($textoContacto, $valorContacto) = each($contactos)) {
								if($id == 1) {
						?>
								<p style="margin: 0.5em"><?php echo $textoContacto ?>: <span style="font-weight: bold"><?php echo $valorContacto ?></span> <?php if(esMobile()){?><a href="tel:+34<?php echo $valorContacto ?>" class="ui-btn ui-btn-inline fondo-azul">Llamame</a><?php } ?></p>
						<?php 
								} else {
						?>
								<p style="margin: 0.5em"><?php echo $textoContacto ?>: <span style="font-weight: bold"><?php echo $valorContacto ?></span> <a href="mailto:<?php echo $valorContacto ?>" class="ui-btn ui-btn-inline fondo-azul">Escribeme</a></p>
						<?php
								}
							}
						?>
						</div>
					</div>
				<?php 
						$posicion = $posicion + 1;
					}
				?>
			</div>
		</div>
		<!-- Pagina horario -->
		<div data-role="page" id="horario" data-url="horario" tabindex="1" class="ui-page ui-page-theme-a ui-page-footer-fixed" >
			<div role="main" class="ui-content">
				<div data-role="navbar" data-position="fixed" data-theme="a" role="banner" class="ui-header ui-bar-a ui-header-fixed slidedown">
					<ul>
						<li><a href="#inicio" data-icon="home"data-transition="slide" ></a></li>
						<li><a href="#map-page" data-icon="navigation" data-transition="slide"></a></li>
						<li><a href="#" data-icon="calendar" data-transition="slide" class="ui-btn-active"></a></li>
						<li><a href="#contacto" data-icon="phone" data-transition="slide" ></a></li>
						<li><a href="#cuenta" data-icon="shop" data-transition="slide" ></a></li>
					</ul>
				</div><!-- /navbar -->
			</div>
			<?php 
			$horarios = getHorarios($conn, $claveCodificada);
			reset($horarios);
			while(list($descripcion, $datos) = each($horarios)) {
			?>
			<div class="ui-grid-solo ui-responsive">
				<div class="ui-block-a">
					<h3 class="ui-bar ui-bar-a" style="margin: 0px; padding: .1em 1em;"><?php echo $descripcion; ?></h3>
					<div class="ui-body">
						<p style="margin: 0.5em">Fecha: <span style="font-weight: bold"><?php echo $datos[0] ?></span></p>
						<p style="margin: 0.5em">Hora: <span style="font-weight: bold"><?php echo $datos[1] ?></span></p>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
		<!-- Pagina cuenta -->
		<div data-role="page" id="cuenta" data-url="cuenta" tabindex="1" class="ui-page ui-page-theme-a ui-page-footer-fixed" >
			<div role="main" class="ui-content">
				<div data-role="navbar" data-position="fixed" data-theme="a" role="banner" class="ui-header ui-bar-a ui-header-fixed slidedown">
					<ul>
						<li><a href="#inicio" data-icon="home" data-transition="slide"  ></a></li>
						<li><a href="#map-page" data-icon="navigation" data-transition="slide"></a></li>
						<li><a href="#horario" data-icon="calendar" data-transition="slide" ></a></li>
						<li><a href="#contacto" data-icon="phone" data-transition="slide" ></a></li>
						<li><a href="#" data-icon="shop" data-transition="slide" class="ui-btn-active"></a></li>
					</ul>
				</div><!-- /navbar -->
			</div>
			<div class="ui-grid-solo ui-responsive">
				<div class="ui-block-a">
					<h3 class="ui-bar ui-bar-a" style="margin: 0px; padding: .1em 1em;">Cuenta bancaria</h3>
					<div class="ui-body">
					<?php 
						$cuentasBancarias = getCuentasBancarias($conn, $claveCodificada);
						reset($cuentasBancarias);
						while (list($banco, $cuenta) = each($cuentasBancarias)) {
					?>
							<p style="margin: 0.5em;"><?php echo $banco ?>: 
								<br/><span style="font-weight: bold"><?php echo $cuenta ?></span></p>
					<?php
						}
					?>
					</div>
				</div>
			</div>
		</div>
        
        <!-- Pie pagina -->
		<div data-role="footer" data-position="fixed" data-theme="a" role="contentinfo" class="ui-footer ui-bar-a ui-footer-fixed slideup">
			<div data-role="navbar" class="ui-navbar" role="navigation">
			
				<h1><a href="mailto:soporte@einvitacion.es" class="linkSimple">Ra&uacute;l Lima Miranda</a> &copy; <?php if (date("Y") == '2015') { echo date ("Y"); } else { echo '2015 - '.date("Y"); } ?></h1>
			</div><!-- /navbar -->
		</div>
    </body>
<?php
		}
	}
	cerrarConexion($conn);
?>
</html>
