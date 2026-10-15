<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practica</title>
</head>

<body>
    <div class="container">
        <h1>Registrar pedido</h1>
        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php else: ?>
            <form action="index.php" method="post">

            </form>
        <?php endif; ?>
    </div>
</body>

</html>