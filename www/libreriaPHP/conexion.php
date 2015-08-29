<?php

function comprobarParametro() {
	if ((isset($_GET["id"]) and !empty($_GET["id"])) == 1) {
		return TRUE;
	}
	return FALSE;
}

function crearConexion() {
	$servername = "localhost";
	$username = "root";
	$password = "";
	$basedatos = "myinvitation";

	// Create connection
	return new mysqli($servername, $username, $password, $basedatos);
}

$conn = crearConexion();
$claveIndicada = comprobarParametro();

function cerrarConexion($conn) {
	$conn -> close();
}

function conexionValida($conn) {
	if ($conn -> connect_error) {
		return FALSE;
	}
	return TRUE;
}

function codificar($cadena) {
	return hash("sha512", $cadena);
}

function claveValida($conn, $claveCodificada) {

	$consulta = "SELECT id FROM invitacion where clave = '" . $claveCodificada . "' and activo = 1 limit 0,1";
	if ($resultado = $conn -> query($consulta)) {
		while ($fila = $resultado -> fetch_row()) {
			return TRUE;
		}
	}
	return FALSE;
}
?>