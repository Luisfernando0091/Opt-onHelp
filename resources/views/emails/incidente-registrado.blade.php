<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Incidente registrado</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333;">
    <h2>Hola {{ $incidente->usuario_nombre }},</h2>
    <p>Tu incidente ha sido registrado correctamente.</p>

    <p><strong>Código:</strong> {{ $incidente->codigo }}</p>
    <p><strong>Estado:</strong> {{ $incidente->estado }}</p>

    <p>Por favor, mantén la calma 😌. Nuestro equipo ya está revisando tu caso.</p>

    {{-- <p>
        <img src="http://127.0.0.1:8000/img/B/emoji.png" 
             alt="OpcionHelp Emoji" 
             width="64" height="64"
             style="vertical-align: middle;" />
    </p> --}}

    <p>Atentamente,<br>
    El equipo de soporte de <strong> TI</strong></p>
</body>
</html>
