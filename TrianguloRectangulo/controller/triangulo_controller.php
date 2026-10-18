<?php
class TrianguloController 
{
    /**
     * Procesa las acciones del formulario (Guardar, Actualizar, Eliminar)
     */
    public function procesarFormulario(): string 
    {
        // Temporalmente devolvemos una cadena vacía para que no interfiera
        return '';
    }

    /**
     * Obtiene un registro específico para pasarlo al formulario de edición
     */
    public function obtenerParaEditar(int $id) 
    {
        return null;
    }

    /**
     * Lista todos los registros del historial o los filtra por el buscador
     */
    public function listar(string $buscar): array 
    {
        // Devolvemos un arreglo vacío temporal para que la tabla no rompa la página
        return [];
    }
}
