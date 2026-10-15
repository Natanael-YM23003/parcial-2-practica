<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Préstamos</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <div class="contenedor-listado">
        <h1>Listado de Préstamos Registrados</h1>

        <table>
            <thead>
                <tr>
                    <th>Carnet</th>
                    <th>Código</th>
                    <th>Nombre del Equipo</th>
                    <th>Tipo</th>
                    <th>Días Máximos</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($prestamos)): ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">No hay préstamos registrados.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($prestamos as $p): ?>
                        <tr>
                            <td><?= htmlspecialchars($p['carnet']) ?></td>
                            <td><?= htmlspecialchars($p['codigo']) ?></td>
                            <td><?= htmlspecialchars($p['nombre']) ?></td>
                            <td><?= htmlspecialchars($p['tipo']) ?></td>
                            <td><?= $p['dias_maximos'] ?> día(s)</td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <br>
        <a href="index.php"><button>Registrar Nuevo Préstamo</button></a>
    </div>
</body>

</html>