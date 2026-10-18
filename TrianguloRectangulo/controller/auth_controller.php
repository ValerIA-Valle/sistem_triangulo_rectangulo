<?php
require_once __DIR__ . '/../model/usuario_model.php';

class AuthController
{
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

    public static function verificarSesion(): void
    {
        if (empty($_SESSION['id_usuario'])) {
            header('Location: login.php');
            exit;
        }
    }
}
