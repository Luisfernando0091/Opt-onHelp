<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Incidente registrado</title>
</head>
<body>
    <h2>Hola {{ $incidente->usuario_nombre }},</h2>
    <p>Tu incidente ha sido registrado correctamente.</p>

    <p><strong>Código:</strong> {{ $incidente->codigo }}</p>
    <p><strong>Estado:</strong> {{ $incidente->estado }}</p>

    <p>Por favor, mantén la calma 😌. Nuestro equipo ya está revisando tu caso.</p>

    <p>Atentamente,<br>
    El equipo de soporte de <strong>OpcionHelp</strong></p>
</body>
</html>
