<?php
require_once __DIR__ . '/../config/Database.php';

class TrianguloModel
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::conectar();
    }

    public function listar(string $buscar = ''): array
    {
        if ($buscar !== '') {
            $sql = "SELECT * FROM triangulo
                    WHERE detalle LIKE :buscarDetalle
                       OR CAST(base AS CHAR) LIKE :buscarBase
                       OR CAST(altura AS CHAR) LIKE :buscarAltura
                       OR CAST(area AS CHAR) LIKE :buscarArea
                       OR CAST(perimetro AS CHAR) LIKE :buscarPerimetro
                    ORDER BY id_triangulo DESC";
            $stmt = $this->pdo->prepare($sql);

            $valorBuscar = '%' . $buscar . '%';

            $stmt->execute([
                'buscarDetalle'   => $valorBuscar,
                'buscarBase'      => $valorBuscar,
                'buscarAltura'    => $valorBuscar,
                'buscarArea'      => $valorBuscar,
                'buscarPerimetro' => $valorBuscar,
            ]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        $sql = "SELECT * FROM triangulo ORDER BY id_triangulo DESC";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId(int $id): ?array
    {
        $sql = "SELECT * FROM triangulo WHERE id_triangulo = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $registro = $stmt->fetch(PDO::FETCH_ASSOC);

        return $registro ?: null;
    }

    public function guardar(string $detalle, float $base, float $altura): bool
    {
        // Fórmulas matemáticas del triángulo rectángulo
        $area = ($base * $altura) / 2;
        $hipotenusa = sqrt(($base ** 2) + ($altura ** 2));
        $perimetro = $base + $altura + $hipotenusa;

        $sql = "INSERT INTO triangulo(detalle, base, altura, area, perimetro)
                VALUES(:detalle, :base, :altura, :area, :perimetro)";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'detalle'   => $detalle,
            'base'      => $base,
            'altura'    => $altura,
            'area'      => $area,
            'perimetro' => $perimetro,
        ]);
    }

    public function actualizar(int $id, string $detalle, float $base, float $altura): bool
    {
        // Fórmulas matemáticas del triángulo rectángulo
        $area = ($base * $altura) / 2;
        $hipotenusa = sqrt(($base ** 2) + ($altura ** 2));
        $perimetro = $base + $altura + $hipotenusa;

        $sql = "UPDATE triangulo
                SET detalle = :detalle,
                    base = :base,
                    altura = :altura,
                    area = :area,
                    perimetro = :perimetro
                WHERE id_triangulo = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'id'        => $id,
            'detalle'   => $detalle,
            'base'      => $base,
            'altura'    => $altura,
            'area'      => $area,
            'perimetro' => $perimetro,
        ]);
    }

    public function eliminar(int $id): bool
    {
        $sql = "DELETE FROM triangulo WHERE id_triangulo = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute(['id' => $id]);
    }
}
