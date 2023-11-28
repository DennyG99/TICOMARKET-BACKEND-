<!--<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <h1>Su codigo de verificacion es </h1>
    {{ $codigoVerificacion }}


</body>

</html>-->


<!DOCTYPE html> 
<html lang="en"> 
    <head> 
        <meta charset="UTF-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>One Time Password</title>
         <style>
         body { font-family: Arial, sans-serif; background-color: #666060; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; } 
         .otp-container { background-color: #f7f7f7; padding: 30px; border-radius: 5px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); text-align: center; } 
         .otp-container h1 { margin: 0; color: #000000; } 
         .otp-container p { margin: 0; color: #666666; } 
         .otp-code { font-size: 24px; font-weight: bold; color: #333333; } </style> 
         </head> 
         <body> 
            <div class="otp-container"> 
                <h1>Codigo de verificación</h1> 
                <p>es: </p>
                 <p class="otp-code">{{ $codigoVerificacion }}
                </p> 
                </div>
             </body>
              </html>