<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Préstamo de Equipo Audiovisual</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <div class="contenedor-formulario">
        <h1>Registro de Préstamo</h1>

        <?php if (!empty($error)): ?>
            <div class="alerta-error">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="index.php" method="POST">
            <label for="carnet">Carnet del Estudiante:</label>
            <input type="text" id="carnet" name="carnet" value="<?= htmlspecialchars($valores['carnet'] ?? '') ?>" required>

            <label for="codigo">Código del Equipo:</label>
            <input type="text" id="codigo" name="codigo" value="<?= htmlspecialchars($valores['codigo'] ?? '') ?>" required>

            <label for="nombre">Nombre del Equipo:</label>
            <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($valores['nombre'] ?? '') ?>" required>

            <label for="tipo">Tipo de Equipo:</label>
            <select id="tipo" name="tipo" required>
                <option value="">-- Seleccione un tipo --</option>
                <?php foreach (\Prestamos\Enum\TipoEquipo::cases() as $tipoCase): ?>
                    <option value="<?= $tipoCase->value ?>" <?= (isset($valores['tipo']) && $valores['tipo'] === $tipoCase->value) ? 'selected' : '' ?>>
                        <?= ucfirst($tipoCase->value) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Registrar Préstamo</button>
        </form>

        <br>
        <a href="listar.php">Ver listado de préstamos</a>
    </div>
</body>

</html>