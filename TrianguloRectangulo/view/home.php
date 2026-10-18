<?php
session_start();
require_once __DIR__ . '/../controller/auth_controller.php';
require_once __DIR__ . '/../controller/triangulo_controller.php';

AuthController::verificarSesion();

$trianguloController = new TrianguloController();
$mensaje = $_GET['mensaje'] ?? '';
$mensajeFormulario = $trianguloController->procesarFormulario();

if ($mensajeFormulario !== '') {
    $mensaje = $mensajeFormulario;
}

$buscar = trim($_GET['buscar'] ?? '');
$registroEditar = null;

if (isset($_GET['editar'])) {
    $registroEditar = $trianguloController->obtenerParaEditar((int) $_GET['editar']);
}

$registros = $trianguloController->listar($buscar);

// Variables adaptadas al Triángulo Rectángulo
$idActual = $registroEditar['id_triangulo'] ?? '';
$baseActual = $registroEditar['base'] ?? '';
$alturaActual = $registroEditar['altura'] ?? '';
$detalleActual = $registroEditar['detalle'] ?? '';
$areaActual = $registroEditar['area'] ?? '';
$perimetroActual = $registroEditar['perimetro'] ?? '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index,follow">
    <meta name="description" content="Cálculo del área y perímetro del triángulo rectángulo">
    <meta name="keywords" content="triangulo, matematicas, sistema, base de datos">
    <meta name="author" content="BC TECH">

    <link rel="icon" href="../imagenes/cifras.png">
    <link rel="stylesheet" href="../assetes/css/style_home.css">

    <title>Triángulo Rectángulo - Principal</title>
</head>
<body>
    <header class="headeerHome">
        <div class="lineaSup">
            <div class="logo-links">
                <div class="logo">
                    <img src="../imagenes/cifras.png" alt="Logo Matemáticas">
                    <h1>Matemáticas</h1>
                </div>               
                <a href="#">Quiénes somos</a>
            </div>
            <div class="buscarHeader">
                <form class="form1" method="get" action="home.php">
                    <input type="text" name="buscar" id="txtBuscar" placeholder="Buscar por comentario..." value="<?php echo htmlspecialchars($buscar); ?>">
                    <button type="submit">Buscar</button>
                    <?php if ($buscar !== '') : ?>
                        <a class="btn-limpiar" href="home.php">Limpiar</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>
        <div class="lineaInf">
            <nav class="menu">
                <a href="home.php" class="activo">Inicio</a>
                <a href="#">Nuestra historia</a>
                <a href="logout.php" onclick="return confirm('¿Desea cerrar sesión?');" class="logout">Cerrar sesión</a>
            </nav>
        </div>
    </header>

    <main class="contenedor-principal">
        <div class="datos">
            <div class="titulo">
                <h1>Cálculo de Triángulo Rectángulo</h1>
                <p class="usuario-logueado">Usuario activo: <span><?php echo htmlspecialchars($_SESSION['usuario']); ?></span></p>
            </div>

            <?php if ($mensaje !== '') : ?>
                <p class="mensaje-alerta">
                    <?php echo htmlspecialchars(ucfirst($mensaje)); ?>
                </p>
            <?php endif; ?>

            <form action="" method="post" class="form2" id="frmFormulario">
                <input type="hidden" name="id_triangulo" value="<?php echo htmlspecialchars($idActual); ?>">

                <div class="grupo-inputs">
                    <div class="inputs">
                        <label for="txtBase">Base (Cateto A)</label>
                        <input class="inputHome" type="number" step="any" name="txtBase" id="txtBase" placeholder="Ej: 5" value="<?php echo htmlspecialchars($baseActual); ?>" required>
                    </div>
                    <div class="inputs">
                        <label for="txtAltura">Altura (Cateto B)</label>
                        <input class="inputHome" type="number" step="any" name="txtAltura" id="txtAltura" placeholder="Ej: 12" value="<?php echo htmlspecialchars($alturaActual); ?>" required>
                    </div>
                </div>

                <div class="inputs">
                    <label for="txtDetalle">Comentario u Observación</label>
                    <input class="inputHome" type="text" placeholder="Opcional: Ejemplo de clase, examen..." name="txtDetalle" id="txtDetalle" value="<?php echo htmlspecialchars($detalleActual); ?>">
                </div>

                <div class="grupo-inputs resultados">
                    <div class="inputs">
                        <label for="txtA">Área Calculada</label>
                        <input class="inputHome readonly" type="text" name="txtA" id="txtA" readonly placeholder="---" value="<?php echo htmlspecialchars($areaActual); ?>">
                    </div>
                    <div class="inputs">
                        <label for="txtP">Perímetro Calculado</label>
                        <input class="inputHome readonly" type="text" name="txtP" id="txtP" readonly placeholder="---" value="<?php echo htmlspecialchars($perimetroActual); ?>">
                    </div>
                </div>

                <div class="botones">
                    <button type="button" class="btn-calcular" onclick="calcularTriangulo();">Calcular dinámicamente</button>
                    <div class="acciones-finales">
                        <a class="btn-cancelar" href="home.php">Cancelar</a>
                        <button type="submit" class="btn-guardar" name="accion" value="guardar">
                            <?php echo $idActual !== '' ? 'Actualizar Registro' : 'Guardar en Historial'; ?>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="tabla-seccion">
            <h2>Historial de Cálculos Guardados</h2>
            <div class="tabla-responsiva">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Base</th>
                            <th>Altura</th>
                            <th>Detalle / Comentario</th>
                            <th>Área</th>
                            <th>Perímetro</th>
                            <th>Fecha de Registro</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($registros) > 0) : ?>
                            <?php foreach ($registros as $fila) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($fila['id_triangulo']); ?></td>
                                    <td><?php echo htmlspecialchars($fila['base']); ?></td>
                                    <td><?php echo htmlspecialchars($fila['altura']); ?></td>
                                    <td class="col-detalle"><?php echo htmlspecialchars($fila['detalle']); ?></td>
                                    <td class="destaque-calculo"><?php echo htmlspecialchars($fila['area']); ?></td>
                                    <td class="destaque-calculo"><?php echo htmlspecialchars($fila['perimetro']); ?></td>
                                    <td><?php echo htmlspecialchars($fila['fecha_registro']); ?></td>
                                    <td class="acciones">
                                        <a class="btn-tabla editar" href="home.php?editar=<?php echo (int) $fila['id_triangulo']; ?>">Editar</a>
                                        <form action="" method="post" onsubmit="return confirm('¿Está seguro de eliminar este cálculo permanentemente?');" style="display:inline;">
                                            <input type="hidden" name="id_triangulo" value="<?php echo (int) $fila['id_triangulo']; ?>">
                                            <button class="btn-tabla eliminar" type="submit" name="accion" value="eliminar">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="8" class="tabla-vacia">No tienes cálculos registrados aún.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <script src="../assetes/js/app.js?v=2"></script>
</body>
</html>
