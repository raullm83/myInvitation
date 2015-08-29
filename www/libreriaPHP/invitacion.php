<?php

include_once './libreriaPHP/Mobile_Detect.php';

$letras = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');

function getTitulo($conn, $claveCodificada) {
	if (claveValida($conn, $claveCodificada)) {
		$consulta = "SELECT titulo FROM invitacion where clave = '" . $claveCodificada . "' and activo = 1 limit 0,1";
		if ($resultado = $conn -> query($consulta)) {
			while ($fila = $resultado -> fetch_row()) {
				return $fila[0];
			}
		}
	}
	return '';
}

function getImagenInicio($conn, $claveCodificada) {

	if (claveValida($conn, $claveCodificada)) {
		$consulta = "SELECT i.id, d.imagen_inicio, d.version_imagen_inicio " . 
			" FROM invitacion i join dato_inicio d on d.id = i.id " . 
			" where i.clave = '" . $claveCodificada . 
			"' and i.activo = 1 limit 0,1";
		if ($resultado = $conn -> query($consulta)) {
			while ($fila = $resultado -> fetch_row()) {
				return './recursos/' . $fila[0] . '/imagen/' . $fila[1] . '?v=' . $fila[2];
			}
		}
	}
	return '';
}

function getMensajeInicio($conn, $claveCodificada) {
	if (claveValida($conn, $claveCodificada)) {
		$consulta = "SELECT d.mensaje_bienvenida " . 
			" FROM invitacion i join dato_inicio d on d.id = i.id " . 
			" where i.clave = '" . $claveCodificada . 
			"' and i.activo = 1 limit 0,1";
		if ($resultado = $conn -> query($consulta)) {
			while ($fila = $resultado -> fetch_row()) {
				return $fila[0];
			}
		}
	}
	return '';
}

function getTipoContacto($conn, $claveCodificada) {
	$pila = array();
	if (claveValida($conn, $claveCodificada)) {
		$consulta = "Select id, texto from tipo_contacto where activo = 1 order by orden";
		if ($resultado = $conn -> query($consulta)) {
			while ($fila = $resultado -> fetch_row()) {
				$pila[$fila[0]] = $fila[1];
			}
		}
	}
	return $pila;
}

function getContactos($conn, $claveCodificada, $tipoContacto){
	$pila = array();
	if (claveValida($conn, $claveCodificada)) {
		$consulta = "Select texto, valor from contacto c join invitacion i on c.id_invitacion = i.id " . 
			" where c.id_tipo_contacto = ". $tipoContacto ." and i.activo = 1 order by orden";
		if ($resultado = $conn -> query($consulta)) {
			while ($fila = $resultado -> fetch_row()) {
				$pila[$fila[0]] = $fila[1];
			}
		}
	}
	return $pila;
}

function getCuentasBancarias($conn, $claveCodificada){
	$pila = array();
	if (claveValida($conn, $claveCodificada)) {
		$consulta = "SELECT b.nombre, c.cuenta ".
			" FROM invitacion i ".
			" JOIN cuenta_bancaria c ON i.id = c.id_invitacion ".
			" JOIN banco b ON c.id_banco = b.id ".
			" WHERE i.clave = '" . $claveCodificada . 
			"' AND i.activo = 1 ".
			" ORDER BY b.nombre";
		if ($resultado = $conn -> query($consulta)) {
			while ($fila = $resultado -> fetch_row()) {
				$pila[$fila[0]] = $fila[1];
			}
		}
	}
	return $pila;
}

function getDirecciones($conn, $claveCodificada){
	$pila = array();
	if (claveValida($conn, $claveCodificada)) {
		$consulta = "SELECT d.descripcion, d.direccion, d.direccion2, d.localidad, d.provincia ".
					" FROM invitacion i ".
					" JOIN direccion d ON i.id = d.id_invitacion ".
					" WHERE i.clave = '" . $claveCodificada . "' AND i.activo = 1 ".
					"ORDER BY d.orden";		
		if ($resultado = $conn -> query($consulta)) {
			while ($fila = $resultado -> fetch_row()) {
				$pila[$fila[0]] = array($fila[1], $fila[2], $fila[3], $fila[4]);
			}
		}
	}
	return $pila;
}

function getHorarios($conn, $claveCodificada){
	$pila = array();
	$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
	$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	
	if (claveValida($conn, $claveCodificada)) {
		$consulta = "SELECT h.descripcion, h.fecha, h.hora ".
					" FROM horario h ".
					" JOIN invitacion i ON h.id_invitacion = i.id ".
					" WHERE i.clave = '" . $claveCodificada . "' AND i.activo = 1 ".
					" ORDER BY h.orden";		
		if ($resultado = $conn -> query($consulta)) {
			while ($fila = $resultado -> fetch_row()) {
					
				$time = strtotime($fila[1]);
				
				$myFormatForView = $dias[date("w", $time)].' '.date("j", $time).' de '.$meses[date("n", $time)-1].' de '.date("Y", $time);
				
				$pila[$fila[0]] = array($myFormatForView, date_format(date_create($fila[2]), 'H:i'));
			}
		}
	}
	return $pila;
}

function esMobile(){
	$detect = new Mobile_Detect();
	return $detect->isMobile();
}

function esApple() {
	$detect = new Mobile_Detect();
	return $detect->getOperatingSystems() == 'iOS';
}

?>