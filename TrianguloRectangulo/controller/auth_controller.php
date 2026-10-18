<?php
require_once __DIR__ . '/../model/usuario_model.php';

class AuthController
{
    /**
     * Gestiona el inicio de sesión único del sistema matemático
     */
    public function login(string $correo, string $clave): bool
    {
        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->login($correo, $clave);

        if ($usuario) {
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            // Si no tiene nombre guardado, usa el correo como identificador
            $_SESSION['usuario'] = $usuario['nombre'] ?: $usuario['correo'];
            $_SESSION['correo'] = $usuario['correo'];
            return true;
        }

        return false;
    }

    /**
     * Protege las vistas del triángulo rectángulo.
     * Si no hay sesión activa, deniega el paso y manda al login.
     */
    public static function verificarSesion(): void
    {
        if (empty($_SESSION['id_usuario'])) {
            // Asegúrate de que tu archivo de login se llame exactamente login.php
            header('Location: login.php');
            exit;
        }
    }
}
