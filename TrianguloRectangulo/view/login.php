<?php
session_start();
require_once __DIR__ . '/../controller/auth_controller.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = trim($_POST['correo'] ?? '');
    $clave = trim($_POST['clave'] ?? '');

    if ($correo === '' || $clave === '') {
        $mensaje = 'Complete todos los campos';
    } else {
        $auth = new AuthController();

        if ($auth->login($correo, $clave)) {
            header('Location: home.php');
            exit;
        }

        $mensaje = 'Correo o clave incorrectos';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index,follow">
    <meta name="description" content="Sistema de Cálculo Matemático">
    <meta name="keywords" content="matematicas, sistema, login">
    <meta name="author" content="BC TECH">

    <link rel="icon" href="../imagenes/cifras.png">
    <link rel="stylesheet" href="../assetes/css/style.css">

    <title>Iniciar Sesión</title>
</head>
<body>
    <main>
        <div class="caja">
            <form action="" method="post" id="frmLogin">
                <img src="../imagenes/triangulo-rectangulo.png" alt="Logo Instituciones">
                <input type="email" name="correo" id="correo" placeholder="Correo electrónico" required>
                <input type="password" name="clave" id="clave" placeholder="Contraseña" required>
                <button type="submit" id="btnIngresar">Ingresar</button>
            </form>
            
            <?php if (!empty($mensaje)) : ?>
                <script>
                    alert("<?php echo htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8'); ?>");
                </script>
            <?php endif; ?>
        </div>
    </main>
    <script src="../assetes/js/app.js"></script>
</body>
</html>
