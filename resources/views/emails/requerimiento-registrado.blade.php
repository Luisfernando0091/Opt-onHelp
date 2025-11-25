<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Requerimiento registrado</title>
</head>
<body>
    <p>Hola {{ $requerimiento->usuario->name }},</p>

    <p>Tu requerimiento ha sido registrado correctamente.</p>

    <p><strong>Código:</strong> {{ $requerimiento->codigo }}</p>
    <p><strong>Estado:</strong> {{ $requerimiento->estado }}</p>

    <p>Pronto nuestro equipo te dará una respuesta 😊.</p>

    <p>Atentamente,<br>El equipo de soporte de TI</p>
</body>
</html>
