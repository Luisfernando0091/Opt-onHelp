<?php

// namespace App\Exports;

// use App\Models\Incidente;
// use Illuminate\Support\Collection;
// use Maatwebsite\Excel\Concerns\FromCollection;
// use Maatwebsite\Excel\Concerns\WithHeadings;

// class IncidentesExport implements FromCollection, WithHeadings
// {
//     protected $incidentes;

//     public function __construct(Collection $incidentes)
//     {
//         $this->incidentes = $incidentes;
//     }

//     public function collection()
//     {
//         return $this->incidentes->map(function ($i) {
//             return [
//                 'Código' => $i->codigo,
//                 'Título' => $i->titulo,
//                 'Descripción' => $i->descripcion,
//                 'Estado' => $i->estado,
//                 'Prioridad' => $i->prioridad,
//                 'Usuario' => $i->usuario->name ?? '—',
//                 'Técnico' => $i->tecnico->name ?? '—',
//                 'Fecha Reporte' => $i->fecha_reporte
//                     ? \Carbon\Carbon::parse($i->fecha_reporte)->format('d/m/Y')
//                     : '',
//             ];
//         });
//     }

//     public function headings(): array
//     {
//         return [
//             'Código', 'Título', 'Descripción', 'Estado', 'Prioridad',
//             'Usuario', 'Técnico', 'Fecha Reporte',
//         ];
//     }
// }



// namespace App\Exports;

// use App\Models\Incidente;
// use Illuminate\Http\Request;
// use Maatwebsite\Excel\Concerns\FromCollection;
// use Maatwebsite\Excel\Concerns\WithHeadings;

// class IncidentesExport implements FromCollection, WithHeadings
// {
//     protected $request;

//     public function __construct(Request $request)
//     {
//         $this->request = $request;
//     }

//     public function collection()
//     {
//         $user = auth()->user();

//         $isAdmin = $user->hasRole('admin');
//         $isTecnico = $user->hasRole('tecnico');

//         // Base query
//         $query = Incidente::query();

//         // FILTRO POR ROL
//         if (!$isAdmin && !$isTecnico) {
//             // Solo usuario normal: ver solo sus tickets
//             $query->where('usuario_id', $user->id);
//         }

//         // FILTROS DE FECHA
//         if ($this->request->fecha_desde) {
//             $query->whereDate('fecha_reporte', '>=', $this->request->fecha_desde);
//         }

//         if ($this->request->fecha_hasta) {
//             $query->whereDate('fecha_reporte', '<=', $this->request->fecha_hasta);
//         }

//         if ($this->request->mes) {
//             $query->whereMonth('fecha_reporte', $this->request->mes);
//         }

//         $incidentes = $query->with(['usuario', 'tecnico'])->get();

//         // FORMATO EXPORTADO
//         return $incidentes->map(function ($i) {
//             return [
//                 'Código' => $i->codigo,
//                 'Título' => $i->titulo,
//                 'Descripción' => $i->descripcion,
//                 'Estado' => $i->estado,
//                 'Prioridad' => $i->prioridad,
//                 'Usuario' => $i->usuario->name ?? '—',
//                 'Técnico' => $i->tecnico->name ?? '—',
//                 'Fecha Reporte' =>
//                     $i->fecha_reporte
//                         ? \Carbon\Carbon::parse($i->fecha_reporte)->format('d/m/Y')
//                         : '',
//             ];
//         });
//     }

//     public function headings(): array
//     {
//         return [
//             'Código', 'Título', 'Descripción', 'Estado', 'Prioridad',
//             'Usuario', 'Técnico', 'Fecha Reporte',
//         ];
//     }


namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class IncidentesExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data->map(function ($item) {
            return [
                'ID' => $item->id,
                'Código' => $item->codigo,
                'Título' => $item->titulo,
                'Descripción' => $item->descripcion,
                'Usuario' => $item->usuario?->name,
                'Técnico' => $item->tecnico?->name,
                'Estado' => $item->estado,
                'Prioridad' => $item->prioridad,
                'Fecha Reporte' => $item->fecha_reporte,
                'Fecha Cierre' => $item->fecha_cierre,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Código',
            'Título',
            'Descripción',
            'Usuario',
            'Técnico',
            'Estado',
            'Prioridad',
            'Fecha Reporte',
            'Fecha Cierre',
        ];
    }
}


