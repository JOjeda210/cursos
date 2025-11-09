<?php
namespace App\Services;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use InvalidArgumentException;
use RuntimeException;

class CursosPublicos
{
    public function obtenerCursosPublicos(): array
    {
        try 
        {
            $results = DB::select("SELECT * FROM cursos WHERE publico = ? AND activo = ?", [true, true]);
            return array_map(fn($row) => (array) $row, $results);
        } 
        
        catch (\Exception $e) 
        {
            throw new RuntimeException('Error obteniendo cursos: ' . $e->getMessage(), 0, $e);
        }
    }

    public function obtenerCursoPorId(int $id): ?array
    {
        if ($id <= 0) 
        {
            throw new InvalidArgumentException('El id tiene que ser mayor a 0');
        }

        try 
        {
            $result = DB::selectOne("SELECT * FROM cursos WHERE id = ? AND activo = ? LIMIT 1", [$id, true]);
            return $result ? (array) $result : null;
        } catch (\Exception $e) {
            throw new RuntimeException('No se pudo traer el curso: ' . $e->getMessage(), 0, $e);
        }
    }

    public function buscar(array $filtros = [], int $limit = 20, int $offset = 0): array
    {
        $limit = max(1, min(100, (int) ($filtros['limit'] ?? $limit)));
        $offset = max(0, (int) ($filtros['offset'] ?? $offset));

        $where = ["activo = ?", "publico = ?"];
        $bindings = [true, true];

        if ($categoria = Arr::get($filtros, 'categoria')) 
        {
            $where[] = "categoria = ?";
            $bindings[] = $categoria;
        }

        if ($titulo = Arr::get($filtros, 'titulo')) 
        {
            $where[] = "titulo LIKE ?";
            $bindings[] = '%' . $titulo . '%';
        }

        $whereSql = implode(' AND ', $where);
        $bindings[] = $limit;
        $bindings[] = $offset;

        try 
        {
            $sql = "SELECT * FROM cursos WHERE {$whereSql} LIMIT ? OFFSET ?";
            $results = DB::select($sql, $bindings);
            return array_map(fn($row) => (array) $row, $results);
        }

        catch (\Exception $e) 
        {
            throw new RuntimeException('Fallo la búsqueda: ' . $e->getMessage(), 0, $e);
        }
    }
}