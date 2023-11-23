<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificación</title>
</head>
<body>
    <div style="text-align: center; padding: 20px;">
         <h1 style="color: #333; margin-top: 20px;">hola este es el contenido:</h1>
         <?php
         use App\Http\Controllers\ControllerNotificaciones;

         $contenido = new ControllerNotificaciones();
         echo $contenido->contenido();
         ?>
    </div>
</body>
</html>
