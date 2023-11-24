<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificación</title>
</head>
<body>
    <div style="text-align: center; padding: 20px;">
         <h1 style="color: #333; margin-top: 20px;">TICOMARKET TE INFORMA QUE:</h1>
         <h3>
        <?php
            use App\Http\Controllers\ControllerPoliticas;

            $contenido = new ControllerPoliticas();
            echo $contenido->contenidoNombre();
            ?>
         </h3>
           <p>
        <?php
         $contenido = new ControllerPoliticas();
         echo $contenido->contenidoDescripcion();
         ?>
         </p>
    </div>
</body>
</html>
