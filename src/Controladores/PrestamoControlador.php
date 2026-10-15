<?php

namespace Prestamos\Controladores;

use Prestamos\Enum\TipoEquipo;
use Prestamos\Excepciones\DatosInvalidosException;

class PrestamoControlador
{

    public function cargar()
    {
        // Método encargado de mostrar el formulario (para peticiones GET o cuando hay errores)
        $error = '';
        $valores = [];

        // Incluimos la vista del formulario
        include __DIR__ . '/../vistas/formulario.php';
    }

    public function guardar()
    {
        // Método encargado de procesar la petición POST y guardar en sesión
        $error = '';
        $valores = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $valores = $_POST;

            $carnet = trim($_POST['carnet'] ?? '');
            $codigo = trim($_POST['codigo'] ?? '');
            $nombre = trim($_POST['nombre'] ?? '');
            $tipoStr = $_POST['tipo'] ?? '';

            try {
                if (empty($carnet) || empty($codigo) || empty($nombre) || empty($tipoStr)) {
                    throw new DatosInvalidosException("Todos los campos son obligatorios.");
                }

                // Validar carnet: exactamente dos letras mayúsculas seguidas de cinco dígitos (ej. PR21001)
                if (!preg_match('/^[A-Z]{2}\d{5}$/', $carnet)) {
                    throw new DatosInvalidosException("El carnet debe tener exactamente dos letras mayúsculas seguidas de cinco dígitos (Ej: PR21001).");
                }

                // Validar que el tipo exista en el Enum
                $tipoEnum = TipoEquipo::tryFrom($tipoStr);
                if (!$tipoEnum) {
                    throw new DatosInvalidosException("Debe seleccionar un tipo de equipo válido.");
                }

                // Crear el objeto de la subclase usando el método del Enum o match
                $equipoObj = TipoEquipo::crearEquipo($codigo, $nombre, $tipoEnum);
                $diasMaximos = $equipoObj->diasMaximoPrestamo();

                // Iniciar sesión si no está activa
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }

                // Guardar en sesión según la parte 4 del examen[cite: 1]
                $_SESSION['prestamos'][] = [
                    'carnet' => $carnet,
                    'codigo' => $equipoObj->codigo,
                    'nombre' => $equipoObj->nombre,
                    'tipo' => $tipoEnum->value,
                    'dias_maximos' => $diasMaximos
                ];

                // Redirigir al listado[cite: 1]
                header('Location: listar.php');
                exit;
            } catch (DatosInvalidosException $e) {
                $error = $e->getMessage();
                // Si hay error, volvemos a cargar la vista del formulario mostrando la alerta
                include __DIR__ . '/../vistas/formulario.php';
                return;
            }
        }
    }

    public function cargarListado()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $prestamos = $_SESSION['prestamos'] ?? [];

        include __DIR__ . '/../vistas/listado.php';
    }
}
