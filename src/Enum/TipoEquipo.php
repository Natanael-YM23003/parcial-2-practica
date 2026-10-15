<?php

namespace Prestamos\Enum;

use Prestamos\Modelos\Equipo;
use Prestamos\Modelos\Laptop;
use Prestamos\Modelos\Proyector;

enum TipoEquipo: string
{
    case Laptop = 'laptop';
    case Proyector = 'proyector';
    public static function crearEquipo(string $codigo, string $nombre, self $tipo): Equipo
    {
        return match ($tipo) {
            self::Laptop => new Laptop($codigo, $nombre),
            self::Proyector => new Proyector($codigo, $nombre)
        };
    }
}
