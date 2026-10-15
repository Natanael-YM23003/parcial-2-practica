<?php

if (session_start() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../vendor/autoload.php';

use Prestamos\Controladores\PrestamoControlador;

$controlador = new PrestamoControlador();
$controlador->cargar();
