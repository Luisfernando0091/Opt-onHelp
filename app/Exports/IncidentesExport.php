<?php

namespace App\Exports;

use App\Models\Incidente;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class IncidentesExport implements FromCollection, WithHeadings
{
    protected $incidentes;

    public function __construct(Collection $incidentes)
    {
        $this->incidentes = $incidentes;
    }

    public function collection()
    {
        return $this->incidentes->map(function ($i) {
            return [
                'Código' => $i->codigo,
                'Título' => $i->titulo,
                'Descripción' => $i->descripcion,
                'Estado' => $i->estado,
                'Prioridad' => $i->prioridad,
                'Usuario' => $i->usuario->name ?? '—',
                'Técnico' => $i->tecnico->name ?? '—',
                'Fecha Reporte' => optional($i->fecha_reporte)->format('d/m/Y'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Código', 'Título', 'Descripción', 'Estado', 'Prioridad',
            'Usuario', 'Técnico', 'Fecha Reporte',
        ];
    }
}
