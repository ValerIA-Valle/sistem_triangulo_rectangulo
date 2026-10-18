<?php
require_once __DIR__ . '/../model/triangulo_model.php';

class TrianguloController
{
    private TrianguloModel $modelo;

    public function __construct()
    {
        $this->modelo = new TrianguloModel();
    }

    public function procesarFormulario(): string
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return '';
        }

        $accion = $_POST['accion'] ?? '';

        if ($accion === 'guardar') {
            return $this->guardarOActualizar();
        }

        if ($accion === 'eliminar') {
            return $this->eliminar();
        }

        return '';
    }

    private function guardarOActualizar(): string
    {
        $id = (int) ($_POST['id_triangulo'] ?? 0);
        $detalle = trim($_POST['txtDetalle'] ?? '');
        
        $base = trim($_POST['txtBase'] ?? '');
        $altura = trim($_POST['txtAltura'] ?? '');

        // esto es la validacion ambos deben ser numéricos y mayores a cero
        if ($base === '' || !is_numeric($base) || (float) $base <= 0) {
            return 'Ingrese una base válida mayor a cero';
        }
        if ($altura === '' || !is_numeric($altura) || (float) $altura <= 0) {
            return 'Ingrese una altura válida mayor a cero';
        }

        if ($id > 0) {
            $this->modelo->actualizar($id, $detalle, (float) $base, (float) $altura);
            header('Location: home.php?mensaje=actualizado');
            exit;
        }

        $this->modelo->guardar($detalle, (float) $base, (float) $altura);
        header('Location: home.php?mensaje=guardado');
        exit;
    }

    private function eliminar(): string
    {
        $id = (int) ($_POST['id_triangulo'] ?? 0);

        if ($id <= 0) {
            return 'No se pudo eliminar el registro';
        }

        $this->modelo->eliminar($id);
        header('Location: home.php?mensaje=eliminado');
        exit;
    }

    public function listar(string $buscar = ''): array
    {
        return $this->modelo->listar($buscar);
    }

    public function obtenerParaEditar(int $id): ?array
    {
        if ($id <= 0) {
            return null;
        }

        return $this->modelo->obtenerPorId($id);
    }
}
