<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Incidentes</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid #333;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }
        .logo {
            width: 100px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #555;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #efefef;
        }
        .footer {
            text-align: right;
            margin-top: 10px;
            font-size: 10px;
            color: #777;
        }
    </style>
</head>
<body>

    <header>
        <img src="{{ public_path('img/A/logo.png') }}" alt="Logo" class="logo">
        <div>
            {{-- <strong>{{ config('app.name') }}</strong><br> --}}
            <small>Reporte del sistema OpcionHelp</small>
        </div>
    </header>

    <h2>Reporte de Incidentes</h2>
    <p><strong>Fecha de generación:</strong> {{ now()->format('d/m/Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Título</th>
                <th>Prioridad</th>
                <th>Estado</th>
                <th>Usuario</th>
                <th>Técnico</th>
                <th>Fecha Reporte</th>
            </tr>
        </thead>
        <tbody>
            @foreach($incidentes as $incidente)
            <tr>
                <td>{{ $incidente->codigo }}</td>
                <td>{{ $incidente->titulo }}</td>
                <td>{{ $incidente->prioridad }}</td>
                <td>{{ $incidente->estado }}</td>
                <td>{{ $incidente->usuario?->name ?? '—' }}</td>
                <td>{{ $incidente->tecnico?->name ?? 'No asignado' }}</td>
                <td>{{ $incidente->fecha_reporte ? \Carbon\Carbon::parse($incidente->fecha_reporte)->format('d/m/Y') : '' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Generado automáticamente por el sistema OpcionHelp -
         {{-- {{ config('app.name') }} --}}
    </div>

</body>
</html>
{{--  --}}